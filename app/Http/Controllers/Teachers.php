<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;

class Teachers extends Controller
{
    
    public function teachers_index()
    {
       $users=User::all(); 
       return view('Manage_teacher.index',compact('users')); 
    }

    public function teachers_save(Request $request)
    {
       $valid=$request->validate([
       'fname'=>'required|string',
       'mname'=>'required|string',
       'lname'=>'required|string',
       'phone'=>'required|numeric|unique:users,phone',
       'region'=>'required|string',
       'role'=>'required|string',
       'gender'=>'required|string',
       'email'=>'required|email|unique:users',
       'password'=>'required|string',
       ]); 
       if (User::create($valid)) {
           return redirect()->back()->with('success','You have saved details successfully');
       }
    }

    public function teachers_edit(Request $request)
    {
       $valid=$request->validate([
       'id'=>'required|numeric', 
       'fname'=>'required|string',
       'mname'=>'required|string',
       'lname'=>'required|string',
       'status' =>'required|string',
        'phone' => [
            'required',
            'numeric',
            Rule::unique('users', 'phone')->ignore($request->id)
        ],
       'region'=>'required|string',
       'role'=>'required|string',
       'gender'=>'required|string',
       'email' => [
            'required',
            'email',
            Rule::unique('users', 'email')->ignore($request->id)
        ],
       ]); 
       User::where('id', $valid['id'])
       ->update([
       'fname'=>$valid['fname'],
       'mname'=>$valid['mname'],
       'lname'=>$valid['lname'],
       'phone'=>$valid['phone'],
       'region'=>$valid['region'],
       'role'=>$valid['role'],
       'gender'=>$valid['gender'],
       'email' =>$valid['email'],
       'status'=>$valid['status'],
       ]);
       return redirect()->back()->with('success','Changes saved successfully');
    }

    public function deleteTeacher($id)
    {
        User::where('id',$id)->update([
            'status' => 'suspended'
        ]);

        return redirect()->back()->with('success', 'Teacher suspended successfully');
    }
}
