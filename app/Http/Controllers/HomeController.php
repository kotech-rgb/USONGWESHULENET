<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Models\Student;
use App\Models\User;
use App\Models\Darasa;
use App\Models\Subject;
use App\Models\TeacherSubject;
use App\Models\Term;
use App\Models\Year;
use DB;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;


class HomeController extends Controller
{
    
    public function home()     
{         
    $subjects = Subject::all();         
    $students = Student::all();         
    $classes  = Darasa::all();         
    $teachers = User::all();         
    $user     = Auth()->user();         
    $myDetails = TeacherSubject::where('teacher', $user->id)->get(); 
    $teacherSubjects=TeacherSubject::where('teacher',$user->id)->get();
    $Myclasses = $teacherSubjects->map(function($item) {
    return preg_replace('/\s+[A-Z]$/', '', $item->class);
    })->unique()->values();
    $MySubjects = $teacherSubjects->pluck('subject')->unique()->values();        
    $term  = Term::where('status','active')->value('term_name');          
    $year  = Year::where('status','active')->value('year_name');         

    // payments subquery
    $paymentsSub = DB::table('student_payments as sp')
        ->select(
            'sp.student_id', 
            DB::raw('SUM(sp.amount) as total_paid'), 
            DB::raw('MAX(sp.required_amount) as required_amount'),
            DB::raw('MAX(sp.last_notified) as last_notified') // bring last_notified too
        )
        ->where('sp.ac_year', $year)
        ->where('sp.mhula', $term)
        ->groupBy('sp.student_id');

    // debtors
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
            DB::raw('(COALESCE(p.required_amount,0) - COALESCE(p.total_paid,0)) as balance'),
            'p.last_notified'
        )
        ->whereRaw('COALESCE(p.total_paid,0) < COALESCE(p.required_amount,0)')
        ->orderBy('students.index_number')
        ->get();
    $today = Carbon::now()->format('F j, Y'); // e.g., "August 26, 2025"
    $notifiedTodayCount = $debtors->where('last_notified', $today)->count();

    return view('dashboard', compact('subjects','students','classes','teachers','Myclasses','debtors','notifiedTodayCount','MySubjects'));     
}


    public function profile()
    {
        return view('my_profile');
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'fname' => 'required|string|max:50',
            'lname' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' =>'required|numeric',
        ]);
        $user->update($request->only('fname', 'lname', 'email','phone'));
        return back()->with('success', 'Profile updated successfully.');
    }

    public function changePassword(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed|min:6',
        ]);
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password does not match']);
        }
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);
        return back()->with('success', 'Password changed successfully.');
    }
}
