<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Division;
use App\Models\Grade;
use App\Models\Year;
use App\Models\Term;
use App\Models\Configuration;
use DB;

class GradingController extends Controller
{
   public function divisions_index()
   {
    $O_level =Division::orderBy('start_point', 'asc')->where('level','O-level')->get();
    $A_level =Division::orderBy('start_point', 'asc')->where('level','A-level')->get();
    return view('Manage_division.index', compact('O_level','A_level'));
   }

   public function divisions_update(Request $request)
    {
        $request->validate([
            'div_id'      => 'required|numeric|exists:divisions,id',
            'div_name' => 'required|string',
            'start_point'=> 'required|integer',
            'end_point'  => 'required|integer',
        ]);
        Division::where('id', $request->div_id) 
        ->update([
                'div_name'  => $request->div_name,
                'start_point' => $request->start_point,
                'end_point'   => $request->end_point,
            ]);   
        return back()->with('success', 'Division updated successfully.');
    }


    public function grade_index()
   {
    $O_level_grades = Grade::where('level', 'O-level')->orderBy('start_form', 'desc')->get();
    $A_level_grades = Grade::where('level', 'A-level')->orderBy('start_form', 'desc')->get();
    return view('Manage_grade.index', compact('A_level_grades','O_level_grades'));
   }

   public function grade_update(Request $request)
   {
    $request->validate([
            'grade_id'      => 'required|numeric|exists:grades,id',
            'grade_name' => 'required|string|max:10|exists:grades,name',
            'points'=> 'required|string',
            'start_score'  => 'required|integer',
            'end_score'  => 'required|integer',
        ]);
       Grade::where('id', $request->grade_id) 
        ->update([
                'name'  => $request->grade_name,
                'start_form' => $request->start_score,
                'end_to'   => $request->end_score,
                'points'   => $request->points,
            ]); 
     return back()->with('success', 'Grade updated successfully.');    
   }



   public function configuration_index(Request $request)
{
    if ($request->filled(['shule','anuani','mahali','year','term','open_school','close_school','headmaster_name','report_head','sms_temp'])) {
        $configuration = Configuration::first();
        Term::where('status','active')->update(['status'=>'passive']);
        Year::where('status','active')->update(['status'=>'passive']);
        $configuration->update([
            'school_name' => $request->shule,
            'box'         => $request->anuani,
            'location'    => $request->mahali,
            'school_reg'  => $request->reg_number,
            'open_school'  => $request->open_school,
            'close_school'  => $request->close_school,
            'headmaster_name'=>$request->headmaster_name,
            'sms_temp' =>$request->sms_temp,
            'report_head' =>$request->report_head,
        ]);
        Term::where('term_name', $request->term)->update(['status'=>'active']);
        $year = $request->year;
        DB::table('years')->updateOrInsert(
            ['year_name' => $year],
            ['status' => 'active', 'updated_at' => now()]
        );
        return redirect()->back()->with('success','Configuration saved successfully');
    }
    return view('Manage_configuration.index');
}

}
