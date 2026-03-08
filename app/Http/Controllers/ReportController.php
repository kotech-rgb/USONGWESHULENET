<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Darasa;
use Illuminate\Support\LazyCollection;
use PDF;

class ReportController extends Controller
{
   
public function allStudentsReport(Request $request)
{
    $termName       = DB::table('terms')->where('status', 'active')->value('term_name');
    $yearName       = DB::table('years')->where('status', 'active')->value('year_name');
    $School_details = DB::table('configurations')->first();

    $fullClass = $request->class;
    if (str_starts_with($fullClass, 'FORM FIVE') || str_starts_with($fullClass, 'FORM SIX')) {
        $baseClass = $fullClass;
    } else {
        $baseClass = preg_replace('/\s+[A-Z]+$/', '', $fullClass);
    }

    // Classes list
    // $classes = Darasa::all()
    //     ->map(fn($item) => preg_replace('/\s+[A-Z]$/', '', $item->name))
    //     ->unique()->values();
    $classes=['FORM ONE','FORM TWO','FORM THREE','FORM FOUR','FORM FIVE','FORM SIX','FORM FOUR GRADUATE','FORM SIX GRADUATE'];    

    // Count all students in class
    $totalStudentsInClass = DB::table('students')
        ->where('class_name', 'LIKE', $baseClass . '%')
        ->count();

    // === STEP 1: Load all results for calculation (ignoring pagination) ===
    $allResults = DB::table('results')
        ->join('students', 'results.student_id', '=', 'students.id')
        ->select(
            'students.id as student_id',
            'students.class_name',
            'results.score_details'
        )
        ->where('results.term', $request->term)
        ->where('results.year', $request->year)
        ->where('results.class', $request->class)
        ->get();

    // Load subjects registered per class
    $classSubjects = DB::table('student_subjects')
        ->select('class_id', 'subject_id')
        ->get()
        ->groupBy('class_id')
        ->map(fn($group) => $group->pluck('subject_id')->toArray());

    // Collect subject scores for all students
    $subjectScores = [];
    foreach ($allResults as $res) {
        foreach (explode(',', $res->score_details) as $detail) {
            if (preg_match('/^(.+)-(\d+)\(([A-Z])\)$/', trim($detail), $matches)) {
                $subject = trim($matches[1]);
                $score   = (int)$matches[2];

                if (in_array($subject, $classSubjects[$res->class_name] ?? [])) {
                    $subjectScores[$subject][$res->student_id] = $score;
                }
            }
        }
    }

    // Rank students per subject & calculate total students per subject
    $subjectRanks  = [];
    $subjectTotals = [];
    foreach ($subjectScores as $subject => $scores) {
        arsort($scores); // highest first
        $rank = 0;
        $prevScore = null;
        $sameRankCount = 0;

        foreach ($scores as $studentId => $score) {
            if ($score !== $prevScore) {
                $rank += $sameRankCount + 1;
                $sameRankCount = 0;
                $prevScore = $score;
            } else {
                $sameRankCount++;
            }
            $subjectRanks[$subject][$studentId] = $rank;
        }

        $subjectTotals[$subject] = count($scores);
    }

    // === STEP 2: Load paginated results for the view ===
    $resultsQuery = DB::table('results')
        ->join('students', 'results.student_id', '=', 'students.id')
        ->select(
            'students.id as student_id',
            'students.index_number',
            'students.firstname',
            'students.lastname',
            'students.middlename',
            'students.class_name',
            'results.score_details',
            'results.total_points',
            'results.division',
            'results.position',
            'results.term',
            'results.year',
            'results.class'
        )
        ->where('results.term', $request->term)
        ->where('results.year', $request->year)
        ->where('results.class', $request->class);
        if ($request->filled('search')) {
            $search = $request->search;
            $resultsQuery->where(function($q) use ($search) {
                $q->where('students.index_number', 'LIKE', "%{$search}%")
                  ->orWhere('students.firstname', 'LIKE', "%{$search}%")
                  ->orWhere('students.lastname', 'LIKE', "%{$search}%")
                  ->orWhere('students.middlename', 'LIKE', "%{$search}%");
            });
        }

    $results = $resultsQuery
        ->orderBy('results.position')
        ->paginate(50)
        ->withQueryString();

    // Attach subject details to paginated results
    foreach ($results as $res) {
        $subjectPositions = [];
        foreach (explode(',', $res->score_details) as $detail) {
            if (preg_match('/^(.+)-(\d+)\(([A-Z])\)$/', trim($detail), $matches)) {
                $subject = trim($matches[1]);
                $score   = (int)$matches[2];
                $grade   = $matches[3];
                if (in_array($subject, $classSubjects[$res->class_name] ?? [])) {
                    $subjectPositions[$subject] = [
                        'score'    => $score,
                        'grade'    => $grade,
                        'position' => $subjectRanks[$subject][$res->student_id] ?? null,
                        'total'    => $subjectTotals[$subject] ?? 0,
                    ];
                }
            }
        }
        $res->subject_positions = $subjectPositions;
    }
    return view('Manage_report.all', compact('results','termName','yearName','classes','totalStudentsInClass','School_details'));
}


}
