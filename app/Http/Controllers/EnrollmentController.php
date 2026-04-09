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
                $C = Darasa::orderBy('form_level')->get();
            }
            
            $S = Subject::all();

            // Key the array by "ClassName-SubjectName" and set the value as the "status"
            $E = StudentSubject::all()->pluck('status', 'class_subject_key')->toArray();
            
            // Note: If you don't have a 'class_subject_key' helper, use this manual map:
            $E = StudentSubject::all()->mapWithKeys(function ($item) {
                return [$item->class_id . '-' . $item->subject_id => $item->status];
            })->toArray();

            return view('Manage_enrollment.student_subject', compact('C', 'S', 'E'));
        }


    public function student_subject_update(Request $request, $class)
        {
            // 1. Validation: Validate the keys (subject names) and the status values
            $request->validate([
                'subjects' => 'array',
                'subjects.*.status' => 'required|in:core,optional',
            ]);

            // 2. Clear existing records for this class to refresh the list
            \App\Models\StudentSubject::where('class_id', $class)->delete();

            // 3. Process the nested array
            if ($request->has('subjects')) {
                foreach ($request->subjects as $subName => $data) {
                    
                    // 4. ONLY save if the checkbox 'selected' is present for this specific subject
                    if (isset($data['selected'])) {
                        \App\Models\StudentSubject::create([
                            'class_id'   => $class,
                            'subject_id' => $subName, // Using name as ID per your requirement
                            'status'     => $data['status'], // Correctly grabs 'core' or 'optional'
                        ]);
                    }
                }
            }

            return redirect()->back()->with('success', 'Changes saved');
        }


    public function teacher_subject_index()
    {
      $S = Subject::all();
      $C = Darasa::orderBy('form_level')->get();
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
      $C = Darasa::orderBy('form_level')->get();
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
