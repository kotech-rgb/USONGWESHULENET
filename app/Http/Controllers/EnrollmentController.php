<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentSubject;
use App\Models\Darasa;
use App\Models\Subject;
use App\Models\User;
use App\Models\TeacherSubject;
use App\Models\TeacherClass;
use DB;

class EnrollmentController extends Controller
{
    
    public function student_subject_index(Request $request)
    {
        if ($request->filled('class_name')) {
            $C = Darasa::where('name', $request->class_name)->get();
        } else {
            $C = Darasa::all();
        }
        $S = Subject::all();
        $E = StudentSubject::all()->map(function ($item) {
            return $item->class_id . '-' . $item->subject_id;
        })->toArray();
        return view('Manage_enrollment.student_subject', compact('C', 'S', 'E'));
    }


    public function student_subject_update(Request $request, $class)
    {
        $request->validate([
        'subjects' => 'array',
        'subjects.*' => 'string|exists:subjects,sub_name',
        ]);
        $selectedSubjects = $request->input('subjects', []);
        StudentSubject::where('class_id', $class)->delete();
        foreach ($selectedSubjects as $subName) {
        StudentSubject::create([
            'class_id' => $class,
            'subject_id' => $subName,
        ]);
        }
        return redirect()->back()->with('success', 'Subjects updated successfully for class ' . $class);
    }


    public function teacher_subject_index()
    {
      $S = Subject::all();
      $C = Darasa::all();
      $U=User::where('role','Teacher')->get();
      $TS=DB::table('users')
      ->join('teacher_subjects','users.id','=','teacher_subjects.teacher')
      ->get();
      return view('Manage_enrollment.teacher_subject', compact('C', 'S', 'U','TS'));  
    }

    public function student_subject_save(Request $request)
    {
      $valid=$request->validate([
      'teacher'=>'required|string',
      'class'=>'required|string',
      'subject'=>'required|string',
      ]);  
      if (TeacherSubject::where('teacher',$valid['teacher'])->where('class',$valid['class'])->where('subject',$valid['subject'])->exists()) {
         return redirect()->back()->with('invalid','Teacher already enrolled for this class and subject');
      }
     if (TeacherSubject::create($valid)) {
         return redirect()->back()->with('success','Subject enrollment to teacher saved');
     }
     return redirect()->back()->with('invalid','Something went wrong');
    }

    public function de_enroll(Request $request)
    {
      if (TeacherSubject::where('id', $request->id)->delete()) {
           return redirect()->back()->with('success','Subject enrollment removed');
      }
       return redirect()->back()->with('invalid','Something went wrong');
    }




    public function class_teachers()
    {
     $S = Subject::all();
      $C = Darasa::all();
      $U=User::where('role','Teacher')->get();
      $TS=DB::table('users')
      ->join('teacher_classes','users.id','=','teacher_classes.teacher_id')
      ->get();
      return view('Manage_enrollment.class_teachers', compact('C', 'S', 'U','TS'));  
    }

    public function class_teachers_save(Request $request)
    {
      $valid=$request->validate([
      'teacher_id'=>'required|string',
      'class_id'=>'required|string',
      ]);  
      if (TeacherClass::where('class_id',$valid['class_id'])->exists()) {
         return redirect()->back()->with('invalid','This class of  '.$valid['class_id'].' has already teacher');
      }
     if (TeacherClass::create($valid)) {
         return redirect()->back()->with('success','Subject enrollment to teacher saved');
     }
     return redirect()->back()->with('invalid','Something went wrong');
    }

    public function class_teachers_remove(Request $request)
    {
      if (TeacherClass::where('id', $request->id)->delete()) {
           return redirect()->back()->with('success','Class teacher removed');
      }
       return redirect()->back()->with('invalid','Something went wrong');
    }

}
