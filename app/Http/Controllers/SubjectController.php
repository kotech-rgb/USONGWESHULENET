<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;

class SubjectController extends Controller
{
    public function subjects_index()
    {
        $subjects = Subject::orderBy('sub_name')->get();
        return view('Manage_subject.index', compact('subjects'));
    }

    public function subjects_save(Request $request)
    {
        $request->validate([
            'sub_name' => 'required|string|max:255|unique:subjects,sub_name|regex:/^[a-zA-Z0-9 _-]+$/|max:255|unique:subjects,sub_name',
        ]);
        Subject::create([
            'sub_name' => $request->sub_name,
        ]);
        return redirect()->back()->with('success', 'Subject created successfully.');
    }

    public function subject_update(Request $request, $sub_name)
    {
        $request->validate([
            'sub_name' => 'required|string|regex:/^[a-zA-Z0-9 _-]+$/|max:255|unique:subjects,sub_name,' . $sub_name . ',sub_name',
        ]);
         $subject = Subject::where('sub_name',$sub_name)->update([
            'sub_name'=>$request->sub_name,
         ]);
          
        return redirect()->back()->with('success', 'Subject updated successfully.');
    }

    public function subject_remove(Request $request)
    {
     if (Subject::where('sub_name',$request->sub_name)->delete())
      {
       return redirect()->back()->with('success','Successfully deleted subject');
     }
    }
}
