<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use DB;
use Auth;
use App\Models\TeacherSubject;

use App\Models\Darasa;
use App\Models\Subject;
use App\Models\StudentSubject;
use App\Models\Student;
use App\Models\Year;
use App\Models\Term;
use App\Models\Test;
use App\Models\Exam;
use App\Models\Configuration;

class MarksController extends Controller
{

public function tamplate_index(Request $request)
{
    $configs = Configuration::first();
    if ($request->filled('class_name') && $request->filled('subject_name') && $request->filled('type')) {
        preg_match('/FORM\s+\w+/i', strtoupper($request->class_name), $matches);
        $form = strtoupper($matches[0] ?? '');
        $classIds = StudentSubject::where('subject_id', $request->subject_name)
        ->where('class_id', 'LIKE', $form . '%')
        ->pluck('class_id');
        if ($classIds->isEmpty()) {
            return redirect()->back()->with('invalid', 'No students class found for this subject this is because they are not enrolled.');
        }
        $students = Student::whereIn('class_name', $classIds)
           ->orderBy('index_number', 'asc') 
            ->get();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // ===== Add subject/class info on top =====
        $sheet->setCellValue('A1', 'Class: ' . $request->class_name);
        $sheet->setCellValue('A2', 'Subject: ' . $request->subject_name);
        $sheet->setCellValue('A3', 'Marks Entry Type: ' . ucfirst($request->type));

        $headerRow = 5;

        if ($request->input('type') === 'test') {
            $sheet->mergeCells('A1:K1');
            $sheet->mergeCells('A2:K2');
            $sheet->mergeCells('A3:K3');
            $sheet->getStyle('A1:A3')->getFont()->setBold(true)->setSize(14);

            $sheet->setCellValue('A' . $headerRow, 'NO#');
            $sheet->setCellValue('B' . $headerRow, 'FIRST NAME');
            $sheet->setCellValue('C' . $headerRow, 'MIDDLE NAME');
            $sheet->setCellValue('D' . $headerRow, 'LAST NAME');
            $sheet->setCellValue('E' . $headerRow, 'GENDER');
            $sheet->setCellValue('F' . $headerRow, 'STREAM');
            $sheet->setCellValue('G' . $headerRow, 'TEST ONE');
            $sheet->setCellValue('H' . $headerRow, 'TEST TWO');
            $sheet->setCellValue('I' . $headerRow, 'TEST THREE');
            $sheet->setCellValue('J' . $headerRow, 'TEST FOUR');
            $sheet->setCellValue('K' . $headerRow, 'TEST FIVE');
        } elseif ($request->input('type') === 'exam') {
            $sheet->mergeCells('A1:G1');
            $sheet->mergeCells('A2:G2');
            $sheet->mergeCells('A3:G3');
            $sheet->getStyle('A1:A3')->getFont()->setBold(true)->setSize(14);

            $sheet->setCellValue('A' . $headerRow, 'NO#');
            $sheet->setCellValue('B' . $headerRow, 'FIRST NAME');
            $sheet->setCellValue('C' . $headerRow, 'MIDDLE NAME');
            $sheet->setCellValue('D' . $headerRow, 'LAST NAME');
            $sheet->setCellValue('E' . $headerRow, 'GENDER');
            $sheet->setCellValue('F' . $headerRow, 'STREAM');
            $sheet->setCellValue('G' . $headerRow, 'SCORE');
        }

        // Fill student data
        $row = $headerRow + 1;
        foreach ($students as $student) {
            $index = str_pad($student->index_number, 4, '0', STR_PAD_LEFT);
            $sheet->setCellValue('A' . $row, $configs->school_reg . '.' . $index);
            $sheet->setCellValue('B' . $row, $student->firstname);
            $sheet->setCellValue('C' . $row, $student->middlename);
            $sheet->setCellValue('D' . $row, $student->lastname);
            $sheet->setCellValue('E' . $row, $student->gender);
            $sheet->setCellValue('F' . $row, $student->class_name);
            $row++;
        }
        // Download Excel file
        $fileName = $request->subject_name . ' ' . strtoupper($request->type) . ' SCORE FOR ' . $request->class_name . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $tempFile = tempnam(sys_get_temp_dir(), $fileName);
        $writer->save($tempFile);
        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    }

    // Load classes, subjects, teacher info for form display
    $user = Auth()->user();
    $madarasa = Darasa::all();
    $classes = $madarasa->map(fn($item) => preg_replace('/\s+[A-Z]$/', '', $item->name))
        ->unique()->values();

    $teacherSubjects = TeacherSubject::where('teacher', $user->id)->get();
    $Myclasses = $teacherSubjects->map(fn($item) => preg_replace('/\s+[A-Z]$/', '', $item->class))
        ->unique()->values();
    $MySubjects = $teacherSubjects->pluck('subject')->unique()->values();
    $subjects = Subject::all();

    return view('Manage_marks.tamplate', compact('classes', 'subjects', 'Myclasses', 'MySubjects'));
}



public function upload_save(Request $request)
{
    $request->validate([
        'file'        => 'required|file|mimes:xls,xlsx',
        'class_name'  => 'required|string',
        'subject_name'=> 'required|string',
        'type'        => 'required|string|in:test,exam',
    ]);

    $termName = Term::where('status', 'active')->value('term_name');
    $yearName = Year::where('status', 'active')->value('year_name');

    // Extract main form from request (FORM ONE, FORM TWO, etc.)
    preg_match('/FORM\s+\w+/i', strtoupper($request->class_name), $matches);
    $requestForm = strtoupper($matches[0] ?? '');

    $classIds = StudentSubject::where('subject_id', $request->subject_name)
        ->where('class_id', 'LIKE', $requestForm . '%')
        ->pluck('class_id');

    if ($classIds->isEmpty()) {
        return redirect()->back()->with('invalid', 'No students class found for this subject (not enrolled).');
    }

    $file = $request->file('file');
    $spreadsheet = IOFactory::load($file->getPathname());
    $sheet = $spreadsheet->getActiveSheet();
    $highestColumnIndex = Coordinate::columnIndexFromString($sheet->getHighestColumn());
    $highestRow = $sheet->getHighestDataRow();

    // Validate column count
    if ($request->type === 'test' && $highestColumnIndex !== 11) {
        return redirect()->back()->with('invalid', 'Excel sheet must have 10 columns for test scores (A to J).');
    }
    if ($request->type === 'exam' && $highestColumnIndex !== 7) {
        return redirect()->back()->with('invalid', 'Excel sheet must have 7 columns for exam scores (A to G).');
    }

    // Prevent test upload if exams already exist
    if ($request->type === 'test' && Exam::where('subjectE', $request->subject_name)
        ->where('classE', 'LIKE', $requestForm . '%')
        ->where('termE', $termName)
        ->where('yearE', $yearName)
        ->exists()) {
        return redirect()->back()->with('invalid', 'Cannot upload test scores because exam marks already exist.');
    }

    for ($row = 6; $row <= $highestRow; $row++) {
        $studentIdCell = $sheet->getCell("A{$row}")->getValue();
        if (empty($studentIdCell)) continue;

        $indexNumber = preg_replace('/^.*\.(\d+)$/', '$1', $studentIdCell);
        $student = Student::where('index_number', $indexNumber)
            ->where('class_name', 'LIKE', $requestForm . '%')
            ->first();

        if (!$student) {
            return redirect()->back()->with('invalid', "Student not found: {$studentIdCell}");
        }

        // Ensure student belongs to the selected class form
        $studentForm = '';
        if (preg_match('/FORM\s+\w+/i', strtoupper($student->class_name), $matches2)) {
            $studentForm = strtoupper($matches2[0]);
        }

        if ($studentForm !== $requestForm) {
            return redirect()->back()->with('invalid', 'Some students do not belong to the selected class form.');
        }

        if ($request->type === 'test') {
            $scores = [];
            foreach (['G','H','I','J','K'] as $col) {
                $value = $sheet->getCell("{$col}{$row}")->getValue();

                // Validate marks
                if ($value === null || $value === '') {
                    $scores[] = null;
                } elseif (!is_numeric($value) || $value < 0 || $value > 100) {
                    return redirect()->back()->with('invalid', "Invalid score for student {$student->index_number} at row {$row}, column {$col}. Must be 0-100 or empty.");
                } else {
                    $scores[] = (int)$value;
                }
            }

            Test::updateOrCreate(
                [
                    'studentT' => $student->id,
                    'subjectT' => $request->subject_name,
                    'classT'   => $student->class_name,
                ],
                [
                    'test1' => $scores[0],
                    'test2' => $scores[1],
                    'test3' => $scores[2],
                    'test4' => $scores[3],
                    'test5' => $scores[4],
                    'termT' => $termName,
                    'yearT' => $yearName,
                ]
            );
        } elseif ($request->type === 'exam') {
            $value = $sheet->getCell("G{$row}")->getValue();

            // Validate exam score
            if ($value === null || $value === '') {
                $score = null;
            } elseif (!is_numeric($value) || $value < 0 || $value > 100) {
                return redirect()->back()->with('invalid', "Invalid exam  score for student {$student->index_number} at row {$row}, column G. Must be 0-100 or empty.");
            } else {
                $score = (int)$value;
            }
            $testDetails = Test::where('studentT', $student->id)
                ->where('termT', $termName)
                ->where('yearT', $yearName)
                ->first();

            Exam::updateOrCreate(
                [
                    'studentE' => $student->id,
                    'subjectE' => $request->subject_name,
                    'classE'   => $student->class_name,
                ],
                [
                    'score' => $score,
                    'test'  => $testDetails->test_avg ?? null,
                    'termE' => $termName,
                    'yearE' => $yearName,
                ]
            );
        }
    }
    return redirect(route('test_index'))->with('success', 'Marks uploaded successfully for subject: ' . strtoupper($request->subject_name));
}





 public function upload_index()
{ 
    $user=Auth()->user();
    $teacherSubjects=TeacherSubject::where('teacher',$user->id)->get();
    $Myclasses = $teacherSubjects->map(function($item) {
    return preg_replace('/\s+[A-Z]$/', '', $item->class);
    })->unique()->values();
    $MySubjects = $teacherSubjects->pluck('subject')->unique()->values();
    $madarasa = Darasa::all();
    $classes = $madarasa->map(function($item) {
    return preg_replace('/\s+[A-Z]$/', '', $item->name);
    })->unique()->values(); 
    $subjects = Subject::all();
    
    return view('Manage_marks.upload', compact('classes', 'subjects','Myclasses','MySubjects'));
 }


public function test_index(Request $request)
{
    $user=Auth()->user();
    $configs=Configuration::first();
    $termName = Term::where('status', 'active')->value('term_name');
    $yearName = Year::where('status', 'active')->value('year_name');
    $madarasa = Darasa::all();
    $classes = $madarasa->map(function($item) {
    return preg_replace('/\s+[A-Z]$/', '', $item->name);
    })->unique()->values(); 
    $subjects = Subject::all();
    $teacherSubjects=TeacherSubject::where('teacher',$user->id)->get();
    $Myclasses = $teacherSubjects->map(function($item) {
    return preg_replace('/\s+[A-Z]$/', '', $item->class);
    })->unique()->values();
    $MySubjects = $teacherSubjects->pluck('subject')->unique()->values();
    if ($request->type=="test") {
    $tests=DB::table('students')
    ->join('tests','students.id','=','tests.studentT')
    ->where('classT', 'LIKE', $request->class_name . '%')
    ->where('tests.subjectT', $request->subject_name)
    ->where('tests.termT', $termName)
    ->where('tests.yearT', $yearName)
    ->get(); 
    if ($tests->isEmpty()) {
    return redirect()->back()->with('invalid', 'No test scores details found for the selected class this term');
    }       
     return view('Manage_marks.test', compact('classes', 'subjects','tests','Myclasses','MySubjects','configs'));
    }
    if ($request->type=="exam") {
        $exam=DB::table('students')
        ->join('exams','students.id','=','exams.studentE')
        ->where('classE', 'LIKE', $request->class_name . '%')
        ->where('exams.subjectE', $request->subject_name)
        ->where('exams.termE', $termName)
        ->where('exams.yearE', $yearName)
        ->get();
     if ($exam->isEmpty()) {
     return redirect()->back()->with('invalid', 'No exam scores details found for the selected criteria.');
     }        
     return view('Manage_marks.exam', compact('classes', 'subjects','exam','Myclasses','MySubjects','configs'));
    }
    return view('Manage_marks.test', compact('classes', 'subjects','Myclasses','MySubjects','configs'));
    
}

public function update_test(Request $request)
{
    $termName = Term::where('status', 'active')->value('term_name');
    $yearName = Year::where('status', 'active')->value('year_name');
    $validated = $request->validate([
        'identity' => 'required|integer|exists:tests,id',
        'test1' => 'nullable|numeric|min:0|max:100',
        'test2' => 'nullable|numeric|min:0|max:100',
        'test3' => 'nullable|numeric|min:0|max:100',
        'test4' => 'nullable|numeric|min:0|max:100',
        'test5' => 'nullable|numeric|min:0|max:100', 
    ]);
    if (Exam::where('subjectE', $request->subject)->where('classE', $request->class)->where('termE',$termName)->where('yearE',$yearName)->exists()) {
           return redirect()->back()->with('invalid', 'You are not allowed to edit test score because the exam marks already upload for that subject');
    }
    $test = Test::findOrFail($validated['identity']);
    $fields = ['test1', 'test2', 'test3', 'test4', 'test5'];
    foreach ($fields as $field) {
        if ($request->has($field)) {
            $test->$field = $request->input($field);
        }
    }
    $test->save();
    return redirect()->back()->with('success', 'Test scores updated successfully.');
}


public function update_exam(Request $request)
{
    $termName = Term::where('status', 'active')->value('term_name');
    $yearName = Year::where('status', 'active')->value('year_name');
    $validated = $request->validate([
        'identity' => 'required|integer|exists:exams,id',
        'score' => 'nullable|numeric|min:0|max:100',
    ]);
    $exam = Exam::findOrFail($validated['identity']);
    $exam->score=$validated['score'] ?? $exam->score;
    $exam->save();
    return redirect()->back()->with('success', 'Exam scores updated successfully.');
}



public function upload_tracking()
{
    $currentTerm = DB::table('terms')->where('status', 'active')->value('term_name');
    $currentYear = DB::table('years')->where('status', 'active')->value('year_name');

    // Get all classes with enrolled subjects and normalize
    $classes = DB::table('student_subjects')
        ->select('class_id')
        ->distinct()
        ->get()
        ->map(fn($c) => trim(strtoupper($c->class_id)))
        ->unique()
        ->values();

    $classSubjects = [];
    foreach ($classes as $class) {
        $subjects = DB::table('student_subjects')
            ->whereRaw('UPPER(TRIM(class_id)) = ?', [$class])
            ->pluck('subject_id')
            ->unique()
            ->values();
        $classSubjects[$class] = $subjects;
    }

    // Get tests uploaded for the current term and year, normalized
    $testsUploaded = DB::table('tests')
        ->where('termT', $currentTerm)
        ->where('yearT', $currentYear)
        ->select('classT', 'subjectT')
        ->get()
        ->map(fn($item) => trim(strtoupper($item->classT)) . '|' . trim(strtoupper($item->subjectT)))
        ->unique()
        ->values()
        ->toArray();

    // Get exams uploaded for the current term and year, normalized
    $examsUploaded = DB::table('exams')
        ->where('termE', $currentTerm)
        ->where('yearE', $currentYear)
        ->select('classE', 'subjectE')
        ->get()
        ->map(fn($item) => trim(strtoupper($item->classE)) . '|' . trim(strtoupper($item->subjectE)))
        ->unique()
        ->values()
        ->toArray();

    return view('Manage_marks.upload_tracking', compact(
        'classSubjects', 'testsUploaded', 'examsUploaded', 'currentTerm', 'currentYear'
    ));
}

public function reverse(Request $request)
{
    $request->validate([
        'class' => 'required',
        'subject' => 'required',
        'term' => 'required',
        'year' => 'required',
    ]);
    DB::table('exams')
        ->where('classE', $request->class)
        ->where('subjectE', $request->subject)
        ->where('termE', $request->term)
        ->where('yearE', $request->year)
        ->delete();
    return redirect()->back()->with('success', 'Marks successfully reversed.');
}





}
