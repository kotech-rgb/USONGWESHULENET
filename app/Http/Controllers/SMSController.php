<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\services\SmsService;
use App\Models\Darasa; 
use App\Models\Student;
use App\Models\Result;
use App\Models\Semester;
use App\Models\Year;
use Auth;
use DB;


class SMSController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
    $darasa = $request->query('class_name');
    $mhula = $request->query('semester');
    $mwaka = $request->query('year');
    // $classes = Darasa::all()->map(fn($item) => preg_replace('/\s+[A-Z]$/', '', $item->name))
    //     ->unique()->values(); 
    $classes=['FORM ONE','FORM TWO','FORM THREE','FORM FOUR','FORM FIVE','FORM SIX','FORM FOUR GRADUATE','FORM SIX GRADUATE'];    
     $students = DB::table('results')
    ->join('students', 'results.student_id', '=', 'students.id')
    ->where('results.class', $darasa)
    ->where('results.year', $mwaka)
    ->where('results.term', $mhula)
    ->get();
    if ($students->isEmpty() && $request->filled('class_name') && $request->filled('semester') && $request->filled('year')) {
        return back()->with('invalid', 'No results approved for the selected class in this term');
    }
    return view('Manage_result.sms', compact('classes', 'students', 'darasa'));
   }

    /**
     * Show the form for creating a new resource.
     */
public function messaging(Request $request, SmsService $smsService)
{
    $school = DB::table('configurations')->first();
    $selectedStudentIds = $request->input('selected_students', []);
    if (empty($selectedStudentIds)) {
        return back()->with('invalid', 'Please select at least one student to send SMS');
    }
    if (count($selectedStudentIds) > 20) {
        return back()->with('invalid', 'Only batch of 20 students at a time');
    }
        $totalStudents = DB::table('students')->where('class_name', 'LIKE', $request->class_name . '%')->count();
        $students = DB::table('results')
        ->join('students', 'results.student_id', '=', 'students.id')
        ->whereIn('results.student_id', $selectedStudentIds)
        ->select('students.firstname','students.middlename','students.lastname','students.phone', 'results.division','results.score_details','results.total_points')
        ->get();
         $allSent = $students->every(function ($student) use ($smsService, $totalStudents, $school) {
        $formattedScores = str_replace(', ', "\n", $student->score_details);
        $message = "Taarifa kutoka shule ya {$school->school_name}\n";
        $message .= "Ndugu mzazi wa: " . strtoupper("{$student->firstname}, {$student->middlename}, {$student->lastname}") . ", matokeo ya mwanao ni kama ifuatavyo,\n";
        $message .= "\n{$formattedScores}";
        $message .= "\nAmepata DIVISION-{$student->division} ya POINTS-{$student->total_points}\n";
        $message .= $school->sms_temp;
        return $smsService->sendSMS($student->phone, $message, 'ResultNotification');
    });
    if ($allSent) {
        Result::whereIn('student_id', $selectedStudentIds)
            ->where('term', $request->semester)
            ->where('year', $request->year)
            ->update(['sms' => 1]);
        return redirect()->back()->with('success', 'Message sent to all selected students');
    }
    return back()->with('invalid', 'Some error occurred during sending SMS');
}



public function notify_debitors(Request $request, SmsService $smsService)
{
    $school = DB::table('configurations')->first();
    $active_year=Year::where('status','active')->value('year_name');
    $selectedStudentIds = $request->input('selected_students', []);

    // Validation
    if (empty($selectedStudentIds)) {
        return back()->with('invalid', 'Please select at least one student to send SMS');
    }
    if (count($selectedStudentIds) > 20) {
        return back()->with('invalid', 'Only batch of 20 students at a time');
    }

    // Fetch students with their balances
    $students = DB::table('students')
        ->join('student_payments as sp', 'students.id', '=', 'sp.student_id')
        ->select(
            'students.id',
            'students.firstname',
            'students.middlename',
            'students.lastname',
            'students.phone',
            'sp.mhula',
            DB::raw('MAX(sp.required_amount) as required_amount'),
            DB::raw('COALESCE(SUM(sp.amount),0) as total_paid'),
            DB::raw('(MAX(sp.required_amount) - COALESCE(SUM(sp.amount),0)) as balance')
        )
        ->whereIn('students.id', $selectedStudentIds)
        ->where('sp.ac_year', $active_year)
        ->where('sp.mhula', $request->term)
        // ->where('students.class_name', $request->class_name)
        ->groupBy(
            'students.id', 
            'students.firstname', 
            'students.middlename', 
            'students.lastname',
            'students.phone',
            'sp.mhula'
        )
        ->havingRaw('COALESCE(SUM(sp.amount),0) < MAX(sp.required_amount)')
        ->get();

    // Send SMS to each student’s parent
    $allSent = $students->every(function ($student) use ($smsService, $school) {
        $message = "Taarifa kutoka shule ya {$school->school_name}\n";
        $message .= "Ndugu mzazi wa " . strtoupper("{$student->firstname} {$student->middlename} {$student->lastname}") . " ";
        $message.="tunakukumbusha kuwa bado unadaiwa ada kiasi cha TZS:". number_format($student->balance). " katika awamu hii ya ({$student->mhula})";
        // $message .= "Kiasi unachotakiwa kulipa term ya {$student->mhula} ni:" . number_format($student->required_amount) ."\n";
        // $message .= "Kiasi kilicholipwa hadi sasa: " . number_format($student->total_paid) . " TZS\n";
        // $message .= "Hivyo unakumbushwa kumaliza kulipia ada iliyobaki: " . number_format($student->balance) . " TZS term ya {$student->mhula}\n";
        $message .= "\nLipa mapema kuepusha usumbufu kwa mwanao";
        return $smsService->sendSMS($student->phone, $message, 'DebtorsNotification');
    });

    if ($allSent) {
        DB::table('student_payments')
            ->whereIn('student_id', $selectedStudentIds)
            ->where('mhula',$request->term)
            ->update(['last_notified' => now()->format('F j, Y')]);
        return redirect()->back()->with('success', 'Message sent to all selected students\' parents');
    }

    return back()->with('invalid', 'Some error occurred during sending SMS');
}











}
