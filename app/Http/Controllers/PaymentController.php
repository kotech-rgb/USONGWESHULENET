<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FeeStructure;
use App\Models\StudentPayment;
use App\Models\Student;
use App\Models\Darasa;
use App\Models\Year;
use App\Models\Term;
use DB;
use Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class PaymentController extends Controller
{
    public function indexFees()
    {
        $fees = FeeStructure::all();
        $class=Darasa::all();
        $active_year=Year::where('status','active')->value('year_name');
         $active_term=Term::all();
        return view('Manage_payment.fee_index', compact('fees','class','active_year','active_term'));
    }

    public function storeFee(Request $request)
    {
        $request->validate([
            'class_id'=>'required',
            'academic_year'=>'required',
            'term_id'=>'required',
            'amount'=>'required|numeric',
        ]);

        FeeStructure::create($request->all());
        return back()->with('success','Fee Structure Added');
    }


    public function createPayment()
    {
        $students = Student::all();
        $active_year=Year::where('status','active')->value('year_name');
        $active_term=Term::all();
        $payments = DB::table('student_payments as sp')
            ->join('students as s', 'sp.student_id', '=', 's.id')
            ->select(
                'sp.*',
                's.firstname',
                's.lastname'
            )
            ->get();
        return view('Manage_payment.create_payment', compact('payments','students','active_year','active_term'));
      }

        public function storePayment(Request $request)
        {
            $request->validate([
                'student_id'   => 'required|exists:students,id',
                'ac_year'      => 'required|string',
                'mhula'        => 'required|string',
                'amount'       => 'required|numeric|min:0',
                'method'       => 'nullable|string|max:255',
                'payment_date' => 'nullable|date',
            ]);
            $student = Student::findOrFail($request->student_id);
            $total_required = FeeStructure::where('class_id', $student->class_name)
                                ->where('academic_year', $request->ac_year)
                                ->where('term_id', $request->mhula)
                                ->sum('amount');
            if ($total_required <= 0) {
                return redirect()->back()->with('invalid', 'No fee structure found for this student in this term and year');
            }
            $total_payed = StudentPayment::where('student_id', $student->id)
                                ->where('ac_year', $request->ac_year)
                                ->where('mhula', $request->mhula)
                                ->sum('amount');
            StudentPayment::create([
                'student_id'      => $student->id,
                'ac_year'         => $request->ac_year,
                'mhula'           => $request->mhula,
                'amount'          => $request->amount,
                'payed_amount'    => ($total_payed ?? 0) + $request->amount,
                'required_amount' => $total_required,
                'method'          => $request->method,
                'payment_date'    => $request->payment_date ?? now(),
                'received_by'     => Auth()->user()->email, 
                'recorded_date'   => now(),
            ]);
            return redirect(route('generate_receipts'))->with('success', 'Payment recorded successfully!');
        }


          public function view_payment(Request $request)
            {
                $payment = DB::table('student_payments')
                    ->join('students', 'student_payments.student_id', '=', 'students.id')
                    ->when($request->filled('class_name'), function ($q) use ($request) {
                        $q->where('students.class_name', $request->class_name);
                    })
                    ->when($request->filled('term'), function ($q) use ($request) {
                        $q->where('student_payments.mhula', $request->term);
                    })
                    ->when($request->filled('year'), function ($q) use ($request) {
                        $q->where('student_payments.ac_year', $request->year);
                    })
                    ->get();

                if ($payment->isEmpty() && $request->filled(['class_name', 'term', 'year'])) {
                    return redirect()->back()->with('invalid', 'No payment found for this class');
                }
                return view('Manage_payment.payments_index', [
                    'payment' => $payment,
                    'classes' => Darasa::all(),
                    'terms'   => Term::all(),
                    'years'   => Year::all(),
                ]);
            }


           public function fee_structure(Request $request)
            {
                $classes = Darasa::all();
                $active_year=Year::where('status','active')->value('year_name');
                $feeItemsByTerm = collect();
                if ($request->filled('class_name')) {
                    $feeItems = FeeStructure::where('class_id', $request->class_name)->orderBy('term_id')->get()
                        ->groupBy('term_id');
                    if ($feeItems->isEmpty()) {
                        return redirect()->back()->with('invalid', 'No fee structure defined for this class');
                    }
                    $feeItemsByTerm = $feeItems;
                }
                return view('Manage_payment.fee_structure', compact('classes','feeItemsByTerm','active_year'));
            }


                public function generate_receipts(Request $request)
                {
                    $students = Student::all();
                    $active_year = Year::where('status','active')->value('year_name');
                    $feeItemsByTerm = collect();
                    $qrCode = null;

                    if ($request->filled('student_id')) {
                        $feeItems = DB::table('students')
                            ->join('student_payments','students.id','=','student_payments.student_id')
                            ->where('student_id', $request->student_id)
                            ->where('ac_year', $active_year)
                            ->orderBy('mhula')
                            ->get()
                            ->groupBy('mhula');
                        if ($feeItems->isEmpty()) {
                            return redirect()->back()->with('invalid', 'No student payment found for this year');
                        }
                        $feeItemsByTerm = $feeItems;
                        $firstPayment = $feeItemsByTerm->first()->first(); // first group, first item
                        $qrContent = "Student: {$firstPayment->firstname} {$firstPayment->lastname}\n" .
                                     "Class: {$firstPayment->class_name}\n" .
                                     "Year: {$active_year}";
                        $qrCode = QrCode::size(80)->generate($qrContent);
                        }
                    return view('Manage_payment.receipts', compact('students','feeItemsByTerm','qrCode'));
                }



            public function debtors_index(Request $request)
        {
            $classes = Darasa::all();   
            $terms = Term::where('status','active')->value('term_name'); 
            $active_year = Year::where('status','active')->value('year_name');

            $debtors = DB::table('students')
                ->leftJoin('student_payments as sp', function ($join) use ($active_year, $request) {
                    $join->on('students.id', '=', 'sp.student_id')
                         ->where('sp.ac_year', $active_year)
                         ->where('sp.mhula', $request->term);
                })
                ->select(
                    'students.id',
                    'students.index_number',
                    'students.gender',
                    'students.phone',
                    'students.firstname',
                    'students.middlename',
                    'students.lastname',
                    DB::raw('MAX(sp.required_amount) as required_amount'),
                    DB::raw('MAX(sp.last_notified) as last_notified'),
                    DB::raw('COALESCE(SUM(sp.amount),0) as total_paid')
                )
                ->where('students.class_name', $request->class_name)
                ->groupBy(
                    'students.id',
                    'students.index_number',
                    'students.gender',
                    'students.phone',
                    'students.firstname',
                    'students.middlename',
                    'students.lastname'
                )
                ->havingRaw('COALESCE(SUM(sp.amount),0) < MAX(sp.required_amount)')
                ->get();

            if ($debtors->isEmpty() && $request->filled('term')) {
                return redirect()->back()->with('invalid', 'No debtors found for this class');
            }

            return view('Manage_payment.notify', compact('classes','terms','debtors'));   
        }


            public function debtors_all(Request $request)
            {
                $term  = Term::where('status','active')->value('term_name'); 
                $year  = Year::where('status','active')->value('year_name');
                $paymentsSub = DB::table('student_payments as sp')
                    ->select('sp.student_id', DB::raw('SUM(sp.amount) as total_paid'), DB::raw('MAX(sp.required_amount) as required_amount'))
                    ->where('sp.ac_year', $year)
                    ->where('sp.mhula', $term)
                    ->groupBy('sp.student_id');
                $debtors = DB::table('students')
                    ->leftJoinSub($paymentsSub, 'p', function ($join) {
                        $join->on('students.id', '=', 'p.student_id');
                    })
                    ->select(
                        'students.id',
                        'students.index_number',
                        'students.gender',
                        'students.phone',
                        'students.firstname',
                        'students.middlename',
                        'students.lastname',
                        DB::raw('COALESCE(p.required_amount, 0) as required_amount'),
                        DB::raw('COALESCE(p.total_paid, 0) as total_paid'),
                        DB::raw('(COALESCE(p.required_amount,0) - COALESCE(p.total_paid,0)) as balance')
                    )
                    ->whereRaw('COALESCE(p.total_paid,0) < COALESCE(p.required_amount,0)')
                    ->orderBy('students.index_number')
                    ->get();
                if ($debtors->isEmpty()) {
                    return back()->with('invalid', 'No debtors found for this term');
                }
                return view('Manage_payment.debitors', compact('debtors','term'));
            }



  
}
