<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Maombi;
use App\Models\Student;
use DB;

class MaombiController extends Controller
{
  
public function delete_request(Request $request)
{
    $valid=$request->validate([
        'reason'=>'required|string',
        'student_id'=>'required',
        'request_type'=>'required|string',
        'requested_by'=>'required|string',
    ]);
    if (Maombi::create($valid)) {
        return redirect()->back()->with('info','Request is sent wait for head of school approval');
    }
} 

public function confirm_delete(Request $request)
{
    $validated = $request->validate([
        'student_id' => 'required|integer',
        'action'     => 'required|in:confirmed,canceled',
        'class_name' => 'nullable|string',
    ]);
    $studentId = $validated['student_id'];
    $action    = $validated['action'];
    if ($action === 'confirmed') {
        $student = Student::find($studentId);
        if ($student) {
            $studentClass = $student->class_name;
            $student->delete();
            if ($studentClass) {
                $level = preg_replace('/\s+[A-Z]$/', '', $studentClass);
                DB::statement("SET @counter := 0");
                DB::statement("
                    UPDATE students s
                    JOIN (
                        SELECT id, (@counter := @counter + 1) AS new_index
                        FROM students
                        WHERE class_name LIKE ?
                        ORDER BY FIELD(gender, 'F', 'M'),
                                 firstname ASC,
                                 middlename ASC,
                                 lastname ASC
                    ) ranked ON s.id = ranked.id
                    SET s.index_number = LPAD(ranked.new_index, 4, '0')
                ", ["{$level}%"]);
            }
        }
        return back()->with('success', 'Student permanently deleted and class reindexed.');
    }
    if ($action === 'canceled') {
        DB::table('maombis')->where('student_id', $studentId)->delete();
        return back()->with('info', 'Request for deleting student is canceled');
    }
}




}
