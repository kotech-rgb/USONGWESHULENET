<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Darasa;

class ClassController extends Controller
{
    
    public function class_index()
    {
        $Array=Darasa::all();
        return view('Manage_class.index', compact('Array'));
    }

    public function class_save(Request $request)
    {
      $valid=$request->validate([
      'Class_Name'=>'required|string',
      ]);
      if (Darasa::where('name', $valid['Class_Name'].' '.$request->stream)->exists()) {
          return redirect()->back()->with('invalid','This class is already registered');
      }
      Darasa::create([
        'name'=>$valid['Class_Name'].' '.$request->stream,
      ]); 
      return redirect()->back()->with('success','Successfully saved class'); 
    }

    public function class_remove(Request $request)
    {
     if (Darasa::where('name',$request->Class_Name)->delete())
      {
       return redirect()->back()->with('success','Successfully deleted class');
     }
    }
}
