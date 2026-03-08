<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Darasa;
use App\Models\Configuration;
use App\Models\Maombi;
use PhpOffice\PhpSpreadsheet\IOFactory;
use DB;

class StudentController extends Controller
{

public function student_index(Request $request)
{
    $configs = Configuration::first();
    $maombisData = Maombi::select('student_id', 'request_type')->get()->keyBy('student_id');
    $query = Student::orderBy('index_number');
    if ($request->class_name) {
        $query->where('class_name', 'LIKE', $request->class_name . '%');
    }
    if ($request->search) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('firstname', 'LIKE', "%$search%")
              ->orWhere('middlename', 'LIKE', "%$search%")
              ->orWhere('lastname', 'LIKE', "%$search%")
              ->orWhere('index_number', 'LIKE', "%$search%")
              ->orWhere('email', 'LIKE', "%$search%")
              ->orWhere('phone', 'LIKE', "%$search%");
        });
    }
    $Array = $query->paginate(50)->appends($request->all());
    $classes = Darasa::all();
    $drs = ['FORM ONE','FORM TWO','FORM THREE', 'FORM FOUR','FORM FIVE','FORM SIX'];
    return view('Manage_student.index', compact('Array','classes','configs','maombisData','drs'));
}



public function student_save(Request $request)
{
    // ✅ 1. Validate input
    $validated = $request->validate([
        'firstname'   => 'required|string|max:255',
        'middlename'  => 'required|string|max:255',
        'lastname'    => 'required|string|max:255',
        'gender'      => 'required|in:M,F',
        'email'       => 'required|email',
        'phone'       => 'required|string',
        'class_name'  => 'required|string|max:255',
    ]);

    // ✅ 2. Standardize input
    $className = strtoupper(trim($validated['class_name']));
    $validated['class_name'] = $className;

    // ✅ 3. Save the new student
    Student::create([
        ...$validated,
        'index_number' => null,
    ]);

    // ✅ 4. Extract base level (e.g. "FORM SIX" from "FORM SIX HGL")
    $baseLevel = preg_replace('/\s+[A-Z]+$/', '', $className);

    // ✅ 5. Determine starting index
    $isFormFiveOrSix = str_starts_with($baseLevel, 'FORM FIVE') ||
                       str_starts_with($baseLevel, 'FORM 5') ||
                       str_starts_with($baseLevel, 'FORM SIX') ||
                       str_starts_with($baseLevel, 'FORM 6');

    $startIndex = $isFormFiveOrSix ? 501 : 1;

    // ✅ 6. Priority combinations
    $priority = ['HGE', 'HGL', 'HGK', 'HKL', 'HGLi', 'HGFa', 'EGM'];
    $priorityList = "'" . implode("','", $priority) . "'";

    // ✅ 7. Build the query
    $query = Student::where('class_name', 'like', $baseLevel . '%');

    if ($isFormFiveOrSix) {
        $query->orderByRaw("
            CASE 
                WHEN TRIM(SUBSTRING_INDEX(class_name, ' ', -1)) IN ($priorityList)
                THEN FIELD(TRIM(SUBSTRING_INDEX(class_name, ' ', -1)), $priorityList)
                ELSE 999
            END
        ")
        ->orderByRaw("TRIM(SUBSTRING_INDEX(class_name, ' ', -1)) ASC")
        ->orderByRaw("FIELD(gender, 'F','M')")
        ->orderBy('firstname', 'asc');
    } else {
        $query->orderByRaw("FIELD(gender, 'F','M')")
              ->orderBy('firstname', 'asc');
    }

    $students = $query->get();

    // ✅ 8. Reassign index numbers (in memory, fewer queries)
    $counter = $startIndex;
    foreach ($students as $student) {
        $student->index_number = str_pad($counter++, 4, '0', STR_PAD_LEFT);
    }

    // ✅ 9. Bulk update
    $students->each->save();

    return redirect()->back()->with('success', "Student registered and index numbers reordered successfully.");
}




public function student_update(Request $request, $id)
{
    $validated = $request->validate([
        'firstname'   => 'required|string|max:255',
        'middlename'  => 'required|string|max:255',
        'lastname'    => 'required|string|max:255',
        'gender'      => 'required|in:M,F',
        'email'       => 'required|email',
        'phone'       => 'required|string',
        'class_name'  => 'required|string|max:255',
    ]);

    // ✅ Custom combination order
    $combinationOrder = ['HGE','HGL', 'HGK', 'HKL', 'HGLi', 'HGFa', 'EGM'];

    $student = Student::findOrFail($id);
    $oldClass = strtoupper($student->class_name);
    $student->update($validated);
    $newClass = strtoupper($validated['class_name']);

    // Extract main levels (ignore stream/section)
    $oldLevel = preg_replace('/\s+[A-Z]+$/', '', $oldClass);
    $newLevel = preg_replace('/\s+[A-Z]+$/', '', $newClass);

    $levelsToReorder = array_unique([$oldLevel, $newLevel]);

    // Build FIELD() clause for custom ordering
    $fieldOrder = implode(',', array_map(fn($c) => DB::getPdo()->quote($c), $combinationOrder));

    foreach ($levelsToReorder as $level) {
        // Determine starting index number
        if (str_starts_with($level, 'FORM FIVE') || str_starts_with($level, 'FORM 5') ||
            str_starts_with($level, 'FORM SIX')  || str_starts_with($level, 'FORM 6')) {
            $start = 501;
        } else {
            $start = 1;
        }

        // Reset counter variable
        DB::statement("SET @counter := ?", [$start - 1]);

        // ✅ Reorder index numbers with custom sorting
        DB::statement("
            UPDATE students s
            JOIN (
                SELECT id, (@counter := @counter + 1) AS seq
                FROM students
                WHERE class_name LIKE ?
                ORDER BY FIELD(SUBSTRING_INDEX(class_name, ' ', -1), {$fieldOrder}),
                         FIELD(gender, 'F', 'M'),
                         firstname ASC,
                         middlename ASC,
                         lastname ASC
            ) ranked ON s.id = ranked.id
            SET s.index_number = LPAD(ranked.seq, 4, '0')
        ", ["{$level}%"]);
    }

    return redirect()->back()->with('success', 'Student updated and index numbers reordered successfully');
}




public function upload_students(Request $request)
{
    $request->validate([
        'file'       => 'required|mimes:xlsx,xls,csv',
        'class_name' => 'required|string|max:255',
    ]);

    $file = $request->file('file')->getRealPath();
    $fullClassName = $request->class_name;

    // ✅ Define your combination priority order here
    $combinationOrder = ['HGE','HGL', 'HGK', 'HKL', 'HGLi', 'HGFa', 'EGM'];

    // Load spreadsheet
    $reader = IOFactory::createReaderForFile($file);
    $reader->setReadDataOnly(true);
    $sheet = $reader->load($file)->getActiveSheet();
    $highestRow = $sheet->getHighestRow();

    $batchData = [];
    $inserted = 0;
    $updated = 0;

    // Preload existing students for fast lookup
    $existingStudents = Student::where('class_name', 'LIKE', $fullClassName.'%')
        ->get()
        ->keyBy(fn($s) => "{$s->firstname}-{$s->middlename}-{$s->lastname}-{$s->class_name}");

    for ($row = 2; $row <= $highestRow; $row++) {
        $firstname  = trim($sheet->getCell("A{$row}")->getValue());
        $middlename = trim($sheet->getCell("B{$row}")->getValue());
        $lastname   = trim($sheet->getCell("C{$row}")->getValue());
        $gender     = strtoupper(trim($sheet->getCell("D{$row}")->getValue()));
        $email      = trim($sheet->getCell("E{$row}")->getValue());
        $phone      = trim($sheet->getCell("F{$row}")->getValue());
        $stream     = trim($sheet->getCell("G{$row}")->getValue());

        if (!$firstname || !$lastname) continue;

        $classNameWithStream = "{$fullClassName} {$stream}";
        $key = "{$firstname}-{$middlename}-{$lastname}-{$classNameWithStream}";

        $data = [
            'firstname'  => $firstname,
            'middlename' => $middlename,
            'lastname'   => $lastname,
            'gender'     => $gender,
            'email'      => $email,
            'phone'      => $phone,
            'class_name' => $classNameWithStream,
        ];

        if (isset($existingStudents[$key])) {
            $existing = $existingStudents[$key];
            if ($existing->gender !== $gender || $existing->email !== $email || $existing->phone !== $phone) {
                $batchData[] = $data;
                $updated++;
            }
        } else {
            $batchData[] = $data;
            $inserted++;
        }

        if (count($batchData) >= 1000) {
            Student::upsert($batchData, ['firstname','middlename','lastname','class_name'], ['gender','email','phone']);
            $batchData = [];
        }
    }

    if ($batchData) {
        Student::upsert($batchData, ['firstname','middlename','lastname','class_name'], ['gender','email','phone']);
    }

    // Determine index number starting point
    $level = preg_replace('/\s+[A-Z]$/', '', $fullClassName);
    $start = (str_starts_with($level, 'FORM FIVE') || str_starts_with($level, 'FORM 5') ||
              str_starts_with($level, 'FORM SIX')  || str_starts_with($level, 'FORM 6')) ? 501 : 1;

    DB::statement("SET @counter := ?", [$start - 1]);

    // Build FIELD() part for custom combination order
    $fieldOrder = implode(',', array_map(fn($c) => DB::getPdo()->quote($c), $combinationOrder));

    // ⚡ Sort by combination order, gender F then M, then alphabetically
    DB::statement("
        UPDATE students s
        JOIN (
            SELECT id, (@counter := @counter + 1) AS seq
            FROM students
            WHERE class_name LIKE ?
            ORDER BY FIELD(SUBSTRING_INDEX(class_name, ' ', -1), {$fieldOrder}),
                     FIELD(gender, 'F', 'M'),
                     firstname ASC,
                     middlename ASC,
                     lastname ASC
        ) ranked ON s.id = ranked.id
        SET s.index_number = LPAD(ranked.seq, 4, '0')
    ", ["{$fullClassName}%"]);
    return back()->with('success', "{$inserted} students added, {$updated} students updated, index numbers reordered!");
}




public function student_transfer()
{
    $students=Student::all();
    $configs=Configuration::first();
    $classes=Darasa::all();
    return view('Manage_student.transfer', compact('students','configs','classes'));
}

public function student_transfer_save(Request $request)
{
    $request->validate([
        'class_name' => 'required|string',
        'selected_students' => 'required|array|min:1',
        'selected_students.*' => 'exists:students,id',
    ]);
    Student::whereIn('id', $request->selected_students)
        ->update(['class_name' => $request->class_name]);
    return redirect()->back()->with('success', 'Students transferred successfully!');
}

public function wafutwe()
{
    $wanafunzi=DB::table('maombis')
    ->join('students','maombis.student_id','=','students.id')
    ->get();
    $configs=Configuration::first();
    return view('Manage_student.delete_pending', compact('wanafunzi','configs'));
}




}
