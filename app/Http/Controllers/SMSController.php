<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SmsService;
use App\Services\ClickPesaService;
use App\Models\{Year, SmsPackage, Recharge, Configuration};
use Illuminate\Support\Str;
use DB;

class SMSController extends Controller
{
    public function index(Request $request)
    {
        $darasa = $request->query('class_name');
        $mhula = $request->query('semester');
        $mwaka = $request->query('year');
        $classes = ['FORM ONE', 'FORM TWO', 'FORM THREE', 'FORM FOUR', 'FORM FIVE', 'FORM SIX', 'FORM FOUR GRADUATE', 'FORM SIX GRADUATE'];
        $students = DB::table('results')
            ->join('students', 'results.student_id', '=', 'students.id')
            ->where('results.class', $darasa)
            ->where('results.year', $mwaka)
            ->where('results.term', $mhula)
            ->select('results.*', 'students.firstname', 'students.lastname', 'students.phone')
            ->get();
        if ($students->isEmpty() && $request->filled(['class_name', 'semester', 'year'])) {
            return back()->with('invalid', 'No results approved for the selected class in this term');
        }
        return view('Manage_result.sms', compact('classes', 'students', 'darasa'));
    }

    public function messaging(Request $request, SmsService $smsService)
    {
        return $this->processSmsSending($request, $smsService, false);
    }

    public function sendBatch(Request $request, SmsService $smsService)
    {
        return $this->processSmsSending($request, $smsService, true);
    }

    /**
     * Shared logic for sending Result SMS (Standard and Batch)
     */
    private function processSmsSending(Request $request, SmsService $smsService, $isJson = false)
    {
        $selectedStudentIds = $request->input('selected_students', []);
        if (empty($selectedStudentIds)) {
            return $isJson 
                ? response()->json(['success' => false, 'message' => 'No students selected.'], 400)
                : back()->with('invalid', 'Please select at least one student.');
        }

        DB::beginTransaction();
        try {
            $school = DB::table('configurations')->first();
            $students = $this->getStudentResults($selectedStudentIds, $request->year, $request->semester);

            $totalUnitsUsed = 0;
            $successCount = 0;

            foreach ($students as $student) {
                if (empty($student->phone)) continue;

                $message = $this->buildResultMessage($student, $school);
                $encodedMessage = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $message);
                
                // Calculate Units
                $length = strlen($encodedMessage);
                $units = ($length <= 160) ? 1 : ceil($length / 153);

                if ($smsService->sendSMS($student->phone, $encodedMessage, 'RESULTS NOTIFICATION')) {
                    $totalUnitsUsed += $units;
                    $successCount++;

                    DB::table('results')
                        ->where(['student_id' => $student->student_id, 'year' => $request->year, 'term' => $request->semester])
                        ->update(['sms' => 1]);
                }
            }

            if ($successCount > 0) {
                DB::table('configurations')->decrement('sms_balance', $totalUnitsUsed);
                DB::commit();

                $msg = "{$successCount} SMS sent. {$totalUnitsUsed} units deducted.";
                return $isJson 
                    ? response()->json(['success' => true, 'sent' => $successCount, 'units_used' => $totalUnitsUsed])
                    : back()->with('success', $msg);
            }

            DB::rollBack();
            return $isJson 
                ? response()->json(['success' => false, 'message' => 'Failed to send SMS.'], 500)
                : back()->with('invalid', 'No SMS sent.');

        } catch (\Exception $e) {
            DB::rollBack();
            return $isJson 
                ? response()->json(['success' => false, 'message' => $e->getMessage()], 500)
                : back()->with('invalid', 'Error: ' . $e->getMessage());
        }
    }

    private function getStudentResults($ids, $year, $term)
    {
        return DB::table('results')
            ->join('students', 'results.student_id', '=', 'students.id')
            ->whereIn('results.student_id', $ids)
            ->where(['results.year' => $year, 'results.term' => $term])
            ->select('results.*', 'students.firstname', 'students.lastname', 'students.phone')
            ->get();
    }

    private function buildResultMessage($student, $school)
    {
        $scoreEntries = explode(', ', $student->score_details);
        $formatted = array_map([$this, 'formatSubjectGrade'], $scoreEntries);
        $scoresString = implode(',', $formatted);
        $msg = "MATOKEO YA {$student->firstname} {$student->lastname},\n";
        $msg .=$scoresString . "\n";
        $msg .= "DIV:{$student->division} PTS:{$student->total_points}\n";
        $msg .= trim($school->sms_temp ?? '');
        return $msg;
    }

    private function formatSubjectGrade(string $entry): string
    {
        $parts = explode('-', $entry);
        if (count($parts) < 2) return $entry;
        $subject = trim($parts[0]);
        $scoreGrade = $parts[1];
        preg_match('/\((.*?)\)/', $scoreGrade, $matches);
        $grade = $matches[0] ?? '';
        // Remove N/A if it exists inside the grade
        if ($grade === '(N/A)') {
            $grade = '()';
        }
        $stopWords = ['YA', 'NA', 'WA', 'KWA', 'OF', 'AND', 'THE', 'IN', 'WITH'];
        $words = explode(' ', $subject);
        if (count($words) > 1) {
            $abbr = '';
            foreach ($words as $w) {
                if (!in_array(strtoupper($w), $stopWords)) {
                    $abbr .= substr($w, 0, 1);
                }
            }
        } else {
            $abbr = substr($subject, 0, 4);
        }
        return strtoupper($abbr ?: substr($subject, 0, 3)) . $grade;
    }

    public function notify_debitors(Request $request, SmsService $smsService)
    {
        $school = DB::table('configurations')->first();
        $active_year = Year::where('status', 'active')->value('year_name');
        $selectedStudentIds = $request->input('selected_students', []);

        if (empty($selectedStudentIds)) return back()->with('invalid', 'Select students first.');

        $students = DB::table('students')
            ->join('student_payments as sp', 'students.id', '=', 'sp.student_id')
            ->select(
                'students.phone', 'students.firstname', 'students.lastname', 'sp.mhula',
                DB::raw('(MAX(sp.required_amount) - SUM(sp.amount)) as balance')
            )
            ->whereIn('students.id', $selectedStudentIds)
            ->where(['sp.ac_year' => $active_year, 'sp.mhula' => $request->term])
            ->groupBy('students.id', 'students.phone', 'students.firstname', 'students.lastname', 'sp.mhula')
            ->havingRaw('SUM(sp.amount) < MAX(sp.required_amount)')
            ->get();

        foreach ($students as $student) {
            $message = "Shule ya {$school->school_name}\n";
            $message .= "Mzazi wa " . strtoupper("{$student->firstname} {$student->lastname}") . ", ";
            $message .= "unadaiwa ada TZS: " . number_format($student->balance) . " awamu ya {$student->mhula}. Lipa mapema.";
            
            $smsService->sendSMS($student->phone, $message, 'DebtorsNotification');
        }

        DB::table('student_payments')
            ->whereIn('student_id', $selectedStudentIds)
            ->where('mhula', $request->term)
            ->update(['last_notified' => now()->format('F j, Y')]);

        return back()->with('success', 'Notifications sent.');
    }

    /** Recharge home */
    public function recharge_home()
        {
            $packages = SmsPackage::orderBy('min_limit', 'asc')->get();
            return view('Manage_recharge.index', compact('packages'));
        }

    /** Store recharge */
    public function store_recharge(Request $request, ClickPesaService $clickPesaService)
    {
        $smsService = new SmsService();
        $smsBalanceResult = $smsService->getSmsBalance();
        $smsBalance = $smsBalanceResult['success']
            ? $smsBalanceResult['balance']['sms_balance'] ?? 0
            : 0;
        $request->validate([
            'SMS_amount'   => 'required|integer|min:1',
            'phone_number' => 'required|string|max:20',
        ]);
        if ($request->SMS_amount > $smsBalance) {
            return redirect()->back()->with('invalid', 'Insufficient SMS balance from Provider');
        }
        $package = SmsPackage::where('min_limit', '<=', $request->SMS_amount)
                    ->where('max_limit', '>=', $request->SMS_amount)
                    ->first();
        $price_per_unit = $package ? $package->price_per_unit : 25;
        $pay_amount = $request->SMS_amount * $price_per_unit;
        $company    = auth()->user()->company_from;
        $reference  = 'REF' . strtoupper(Str::random(10));

        try {
            $clickPesaService->initiateUssdPush($pay_amount, $request->phone_number, $reference);
            Recharge::create([
                'invoice'      => 'INV' . strtoupper(Str::random(10)),
                'reference'    => $reference,
                'status'       => 'pending',
                'SMS_amount'   => $request->SMS_amount,
                'pay_amount'   => $pay_amount,
                'phone_number' => $request->phone_number,
                'company_info' => $company,
            ]);
            return redirect()->route('recharge.status', $reference);

        } catch (\Exception $e) {
            $message = $e->getMessage();
            $decoded = json_decode($message, true);
            if (json_last_error() === JSON_ERROR_NONE && isset($decoded['message'])) {
                $message = $decoded['message'];
            }
            return redirect()->back()->with('invalid', $message)->withInput();
        }
    }

    /** Recharge status */
    public function recharge_status($ref)
    {
        $recharge = Recharge::where('reference', $ref)->firstOrFail();
        return view('Manage_recharge.payment_status', compact('recharge'));
    }

    /** Recharge history */
    public function recharge_history()
    {
        $user = auth()->user();
        $recharge = $user->role === 'admin'
            ? Recharge::orderBy('created_at', 'desc')->get()
            : Recharge::where('company_info', $user->company_from)->orderBy('created_at', 'desc')->get();

        return view('Manage_recharge.payment_history', compact('recharge'));
    }


}