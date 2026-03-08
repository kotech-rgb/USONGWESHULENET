<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Darasa;
use App\Models\Exam;
use App\Models\Term;
use App\Models\Year;
use App\Models\Result;
use App\Models\Student;
use App\Models\TeacherSubject;
use DB;
use Auth;

class ResultsController extends Controller
{


public function result_index(Request $request)
{
    $termName = $request->term;
    $yearName = $request->academic_year;
    $user     = Auth::user();

    // Teacher's & all classes
    $teacherSubjects = DB::table('teacher_subjects')->where('teacher', $user->id)->get();
    $Myclasses = $teacherSubjects->map(fn($t) => preg_replace('/\s+[A-Z]$/', '', $t->class))->unique()->values();
    $classes   = Darasa::all()->map(fn($d) => preg_replace('/\s+[A-Z]$/', '', $d->name))->unique()->values();

    // Students filter
    $studentsQuery = Student::query();
    $form = '';
    if ($request->filled('class_name')) {
        preg_match('/FORM\s+\w+/i', strtoupper($request->class_name), $matches);
        $form = strtoupper($matches[0] ?? '');
        $studentsQuery->where('class_name', 'LIKE', $form . '%');
    }
    $students = $studentsQuery->get();
    if ($students->isEmpty() && $request->filled('class_name')) {
        return back()->with('invalid', 'No students found for this class.');
    }

    // Academic level
    $level     = in_array($form, ['FORM FIVE','FORM SIX']) ? 'A-level' : 'O-level';
    $grades    = DB::table('grades')->where('level', $level)->get();
    $divisions = DB::table('divisions')->where('level', $level)->get();

    // Subjects to exclude for A-level
    $excludedSubjects = [];
    if (in_array($form, ['FORM FIVE', 'FORM SIX'])) {
        $excludedSubjects = DB::table('subjects')
            ->whereIn('sub_name', ['GENERAL STUDIES', 'ACADEMIC COMMUNICATION SKILLS','BASIC APPLIED MATHEMATICS'])
            ->pluck('sub_name')
            ->toArray();
    }

    $results      = [];
    $subjectStats = [];

    // --- Process each student ---
    foreach ($students as $student) {
        $studentSubjects = DB::table('student_subjects')
            ->where('class_id', $student->class_name)
            ->pluck('subject_id')
            ->toArray();

        $exams = DB::table('exams')
            ->where('studentE', $student->id)
            ->where('termE', $termName)
            ->where('yearE', $yearName)
            ->whereIn('subjectE', $studentSubjects)
            ->get();

        $subjectGrades = [];
        $subjectGPA    = [];
        $pointsArray   = [];

        foreach ($studentSubjects as $subjectId) {
            $exam = $exams->first(fn($e) => $e->subjectE == $subjectId);

            if ($exam) {
                $gradeRecord = $grades->first(fn($g) => $exam->total_average >= $g->start_form && $exam->total_average <= $g->end_to);
                $gradeLetter = $gradeRecord?->name ?? 'N/A';
                $score       = $exam->total_average;

                $subjectGPA[$subjectId] = $gradeRecord?->points;

                if (!in_array($subjectId, $excludedSubjects)) {
                    $pointsArray[] = $gradeRecord?->points ?? 0;
                }
            } else {
                $gradeLetter = 'N/A';
                $score       = null; // numeric null for compatibility
            }

            $subjectGrades[] = "{$subjectId}-{$score}({$gradeLetter})";

            // Populate scores for subject summary
            $subjectStats[$subjectId]['scores'][$student->id] = $score;
            $subjectStats[$subjectId]['student_ids'][] = $student->id;
        }

        // Check if student has all F/N/A → mark ABS
        $allFailing = collect($subjectGrades)->every(fn($sub) => preg_match('/\((F|N\/A)\)$/', $sub));

        // Average score/grade
        $averageScore = $allFailing ? 'ABS' : ($exams->isNotEmpty() ? round($exams->avg('total_average'), 0) : 0);
        $averageGrade = $allFailing ? 'ABS' : ($grades->first(fn($g) => $averageScore >= $g->start_form && $averageScore <= $g->end_to)?->name ?? 'N/A');

        // Points & Division
        $topSubjects  = $level === 'A-level' ? 3 : 7;
        $pointsArray  = collect($pointsArray)->sort()->take($topSubjects)->all();
        $totalPoints  = $allFailing ? 'ABS' : (count($pointsArray) >= $topSubjects ? array_sum($pointsArray) : null);
        $division     = $allFailing ? 'ABS' : ($totalPoints ? $divisions->first(fn($d) => $totalPoints >= $d->start_point && $totalPoints <= $d->end_point)?->div_name ?? 'N/A' : 'INC');

        // Overall GPA
        $gpaValues  = array_filter($subjectGPA, fn($v) => $v !== null);
        $overallGPA = $allFailing ? 'ABS' : ($gpaValues ? min(5.0, round(array_sum($gpaValues)/count($gpaValues),2)) : 0);
        
        

        $results[$student->id] = [
            'student_id'    => $student->id,
            'indexNO'       => $student->index_number,
            'fullname'      => "{$student->firstname} {$student->middlename} {$student->lastname}",
            'gender'        => $student->gender,
            'stream'        => $student->class_name,
            'subjects'      => $allFailing ? 'ABS' : implode(', ', $subjectGrades),
            'average_score' => $averageScore,
            'average_grade' => $averageGrade,
            'total_points'  => $totalPoints,
            'division'      => $division,
            'class_name'    => $student->class_name,
            'subject_gpa'   => $subjectGPA,
            'overall_gpa'   => $overallGPA,
            'allAbsent'     => $allFailing,
        ];
    }
    

    // --- Ranking positions ---
    $positions = collect($results)->pluck('average_score','student_id')->sortDesc();
    $pos = 1;
    foreach ($positions as $studentId => $avg) {
        if($results[$studentId]['allAbsent'] !== true) {
            $results[$studentId]['position'] = $pos++;
        } else {
            $results[$studentId]['position'] = '-';
        }
    }
    
    // --- Save/approve results ---
    if ($request->filled('approve') && $results) {
        $upsertData = array_map(fn($r) => [
            'student_id'    => $r['student_id'],
            'term'          => $termName,
            'year'          => $yearName,
            'class'         => $request->class_name,
            'score_details' => $r['subjects'],
            'average_score' => $r['average_score'] === 'ABS' ? 0 : $r['average_score'],
            'average_grade' => $r['average_grade'],
            'total_points' => $r['total_points'] === 'ABS' ? 0 : $r['total_points'],
            'division'      => $r['division'],
            'position' => $r['position'] === '-' ? 0 : $r['position'],
        ], $results);

        Result::upsert(
            $upsertData,
            ['student_id','term','year','class'],
            ['score_details','average_score','average_grade','total_points','division','position']
        );
        return back()->with('success','Results approved and saved.');
    }
    

    // --- Subject-level summary & ranking ---
    $subjectSummary = $this->calculateSubjectSummary($subjectStats, $grades, $level);
    $subjectScores  = collect($subjectSummary)->map(fn($s)=>$s['average_score'])->sortDesc();
    $totalSubjects  = count($subjectScores);
    $rank=1;
    foreach($subjectScores as $sub_name=>$score){
        $subjectSummary[$sub_name]['position']=$rank.' / '.$totalSubjects;
        $rank++;
    }

    $subjectIds = array_keys($subjectSummary);
    $subjects   = DB::table('subjects')->whereIn('sub_name',$subjectIds)->pluck('sub_name')->toArray();

    // --- Division summary ---
    $allowedDivisions = ['I','II','III','IV','O'];
    $divisionSummary = [
        'F'=>array_fill_keys(array_merge($allowedDivisions,['INC']),0),
        'M'=>array_fill_keys(array_merge($allowedDivisions,['INC']),0),
        'T'=>array_fill_keys(array_merge($allowedDivisions,['INC']),0),
    ];

    foreach ($results as $res) {
        if($res['allAbsent'] !== true) {
            $gender = strtoupper($res['gender'][0] ?? 'T');
            $div = in_array($res['division'],$allowedDivisions) ? $res['division'] : ($res['division'] === 'INC' ? 'INC' : '0');
            $divisionSummary[$gender][$div]++;
        }
    }

    foreach($allowedDivisions as $div) {
        $divisionSummary['T'][$div] = $divisionSummary['F'][$div]+$divisionSummary['M'][$div];
    }
    $divisionSummary['T']['INC'] = $divisionSummary['F']['INC']+$divisionSummary['M']['INC'];

    // --- Sort results by index number (F first) ---
    $sortedResults = collect($results)
        ->sort(function($a,$b){
            $genderOrder=['F'=>0,'M'=>1];
            $aG=strtoupper($a['gender'][0] ?? 'M');
            $bG=strtoupper($b['gender'][0] ?? 'M');
            $genderComparison = ($genderOrder[$aG] ?? 2) <=> ($genderOrder[$bG] ?? 2);
            if($genderComparison!==0) return $genderComparison;
            return (int)($a['indexNO'] ?? 0) <=> (int)($b['indexNO'] ?? 0);
        })
        ->values()
        ->all();

    // --- Students summary ---
    $WanafnziSummary = ['Registered'=>count($students),'SAT'=>0,'ABSENT'=>0,'DIV-I'=>0,'DIV-II'=>0,'DIV-III'=>0,'DIV-IV'=>0,'DIV-0'=>0,'INC'=>0];
    foreach($results as $r){
        if(!empty($r['allAbsent']) && $r['allAbsent']){
            $WanafnziSummary['ABSENT']++;
        }else{
            $WanafnziSummary['SAT']++;
            $div = strtoupper(trim($r['division']));
            if(in_array($div,['I','II','III','IV'])) $WanafnziSummary['DIV-'.$div]++;
            elseif($div==='O') $WanafnziSummary['DIV-0']++;
            elseif($div==='INC') $WanafnziSummary['INC']++;
        }
    }
    $School_details = DB::table('configurations')->first();
    return view('Manage_result.index', compact(
        'classes','Myclasses','sortedResults','divisionSummary','allowedDivisions','School_details',
        'termName','yearName','grades','subjectStats','WanafnziSummary','subjectSummary','subjects'
    ));
}






public function result_post()
{
    // $classes = Darasa::all()->map(fn($item) => preg_replace('/\s+[A-Z]$/', '', $item->name))
    //     ->unique()->values();
    
    $classes=['FORM ONE','FORM TWO','FORM THREE','FORM FOUR','FORM FIVE','FORM SIX','FORM FOUR GRADUATE','FORM SIX GRADUATE'];
    $termName = Term::where('status', 'active')->value('term_name');
    $yearName = Year::where('status', 'active')->value('year_name');
    $postedClasses = Result::where('term', $termName)
    ->where('year', $yearName)
    ->pluck('class')
    ->map(fn($c) => trim($c))
    ->unique()
    ->toArray(); 
    return view('Manage_result.posting', compact('classes', 'termName', 'yearName', 'postedClasses'));
}

public function result_deaprove(Request $request)
{
    Result::where('class',$request->class)
    ->where('term', $request->term)
    ->where('year', $request->year) 
    ->delete();
    return back()->with('success', 'You have successfully deapproved the results');
}





/**
 * Calculate subject-level statistics for a class/term/year
 *
 * @param array $subjectStats   // [subject_id => ['scores' => [student_id => score], 'student_ids' => [...]]]
 * @param \Illuminate\Support\Collection $grades // grades table for this level
 * @param string $level         // "O-level" or "A-level"
 *
 * @return array
 */
private function calculateSubjectSummary(array $subjectStats, $grades, string $level): array
{
    $subjectSummary = [];

    // Define grade letters based on level
    $gradeLetters = $level === 'A-level'
        ? ['A','B','C','D','E','S','F']
        : ['A','B','C','D','F'];

    foreach ($subjectStats as $subjectId => $data) {
        $scores      = $data['scores'] ?? [];
        $gpas        = [];
        $gradesCount = array_fill_keys($gradeLetters, 0);
        $passCount   = 0;

        foreach ($scores as $studentId => $score) {
            $gradeRecord = $grades->first(fn($g) => $score >= $g->start_form && $score <= $g->end_to);
            $gradeLetter = $gradeRecord?->name ?? '-';
            $points      = $gradeRecord?->points ?? '-';

            $gradesCount[$gradeLetter] = ($gradesCount[$gradeLetter] ?? 0) + 1;
            $gpas[] = $points;

            if ($level === 'O-level' && in_array($gradeLetter, ['A','B','C','D'])) {
                $passCount++;
            } elseif ($level === 'A-level' && in_array($gradeLetter, ['A','B','C','D','E','S'])) {
                $passCount++;
            }
        }

        $averageScore = $scores ? round(array_sum($scores)/count($scores), 0) : 0;
        $averageGPA   = $gpas ? round(array_sum($gpas)/count($gpas), 2) : 0;
        if ($averageGPA !== null) {
        if ($averageGPA >= 1.0 && $averageGPA <= 1.5) {
        $remark = 'Grade A (Excellent)'; 
        $bg = "green";
        } elseif ($averageGPA > 1.5 && $averageGPA <= 2.0) {
            $remark = 'Grade B (Very Good)'; 
            $bg = "lightgreen";
        } elseif ($averageGPA > 2.0 && $averageGPA <= 2.9) {
            $remark = 'Grade C (Good)'; 
            $bg = "yellow";
        } elseif ($averageGPA > 2.9 && $averageGPA <= 3.9) {
            $remark = 'Grade D (Satisfactory)'; 
            $bg = "orange";
        } elseif ($averageGPA > 3.9 && $averageGPA <= 5.0) {
            $remark = 'Grade F (Fail)'; 
            $bg = "red";
        } else {
            $remark = 'INC'; 
            $bg = "grey";
        }
        $avgDisplay = number_format($averageGPA, 2);
        } else {
            $avgDisplay = 'N/A';
            $remark = 'INC';
            $bg = "grey";
        }

        $avgGradeRecord = $grades->first(fn($g) => $averageScore >= $g->start_form && $averageScore <= $g->end_to);
        $averageGrade   = $avgGradeRecord?->name ?? 'N/A';

        arsort($scores);
        $position = [];
        $pos = 1;
        foreach ($scores as $studentId => $score) {
            $position[$studentId] = $pos++;
        }

        $subjectSummary[$subjectId] = [
            'subject_id'    => $subjectId,
            'SAT'           => count($scores),
            'grades_count'  => $gradesCount,
            'average_score' => $averageScore,
            'average_gpa'   => $averageGPA,
            'average_grade' => $averageGrade,
            'total_pass'    => $passCount,
            'positions'     => $position,
            'remark'        => $remark,
            'bg'            => $bg,
        ];
    }
    return $subjectSummary;
}



}
