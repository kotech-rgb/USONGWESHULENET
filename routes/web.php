<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Teachers;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\MarksController;
use App\Http\Controllers\ResultsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\GradingController;
use App\Http\Controllers\SMSController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MaombiController;

    Route::get('/', function () {
    // return redirect()->route('login');
        return view('welcome');
    });

    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/login')->with('success','Logged Out successfully');
    })->name('logout');


    Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [HomeController::class, 'home'])->name('dashboard');
    Route::get('/Myprofile', [HomeController::class, 'profile'])->name('Myprofile');
    Route::put('/profile/update', [HomeController::class, 'update'])->name('profile.update');
    Route::put('/profile/change-password', [HomeController::class, 'changePassword'])->name('profile.change-password');

    Route::post('/teachers/save', [Teachers::class, 'teachers_save'])->name('teachers_save');
    Route::get('/teachers', [Teachers::class, 'teachers_index'])->name('teachers_index');
    Route::post('/teachers/edit', [Teachers::class, 'teachers_edit'])->name('teachers_edit');


    Route::get('/classes', [ClassController::class, 'class_index'])->name('class_index');
    Route::post('/class/save', [ClassController::class, 'class_save'])->name('class_save');
    Route::post('/class/remove', [ClassController::class, 'class_remove'])->name('class_remove');

    Route::get('/Student', [StudentController::class, 'student_index'])->name('student_index');
    Route::get('/Student/transfer', [StudentController::class, 'student_transfer'])->name('student_transfer');
    Route::get('/wafutwe/ombi', [StudentController::class, 'wafutwe'])->name('wafutwe');
    Route::post('/Student/request/delete', [MaombiController::class, 'confirm_delete'])->name('student_delete_confirm');

    Route::post('/Student/trasnfer/save', [StudentController::class, 'student_transfer_save'])->name('student_transfer_save');
    Route::post('/Student/save', [StudentController::class, 'student_save'])->name('student_save');
    Route::post('/students/upload', [StudentController::class, 'upload_students'])->name('students.upload');
    Route::put('/students/{id}', [StudentController::class, 'student_update'])->name('student_update');
    Route::post('/students/delete_request', [MaombiController::class, 'delete_request'])->name('students.delete_request');

    Route::get('/subjects', [SubjectController::class,'subjects_index'])->name('subjects_index');
    Route::post('/subjects/save', [SubjectController::class,'subjects_save'])->name('subjects_save');
    Route::put('/subjects/{id}', [SubjectController::class, 'subject_update'])->name('subject_update');
    Route::post('/subjects/remove', [SubjectController::class, 'subject_remove'])->name('subject_remove');


    Route::get('/student_subject', [EnrollmentController::class,'student_subject_index'])->name('student_subject_index');
    Route::get('/teacher_subjects', [EnrollmentController::class,'teacher_subject_index'])->name('teacher_subject_index');
    Route::post('/teacher_enroll/save', [EnrollmentController::class,'student_subject_save'])->name('student_subject_save');
    Route::post('/remove_enrollment', [EnrollmentController::class,'de_enroll'])->name('de_enroll');
    Route::put('/student-subject/{class}', [EnrollmentController::class, 'student_subject_update'])->name('student_subject.update');
    Route::get('/class_teachers', [EnrollmentController::class,'class_teachers'])->name('class_teachers');
    Route::post('/class_teachers/save', [EnrollmentController::class,'class_teachers_save'])->name('class_teachers_save');
    Route::post('/class_teachers/remove', [EnrollmentController::class,'class_teachers_remove'])->name('class_teachers_remove');


    Route::get('/test/marks', [MarksController::class,'test_index'])->name('test_index');
    Route::get('/tamplate/index', [MarksController::class,'tamplate_index'])->name('tamplate_index');
    Route::get('/upload/index', [MarksController::class,'upload_index'])->name('upload_index');
    Route::post('/upload/save', [MarksController::class,'upload_save'])->name('upload_save');
    Route::post('/update/test', [MarksController::class,'update_test'])->name('update_test');
    Route::post('/update/exam', [MarksController::class,'update_exam'])->name('update_exam');
    Route::get('/upload/tracking', [MarksController::class,'upload_tracking'])->name('upload_tracking');
    Route::delete('/marks/reverse', [MarksController::class, 'reverse'])->name('marks.reverse');



    Route::get('/results/index', [ResultsController::class,'result_index'])->name('result_index');
    Route::get('/results/post', [ResultsController::class,'result_post'])->name('result_post');
    Route::post('/results/posting/deaprove', [ResultsController::class,'result_deaprove'])->name('result_deaprove');



    Route::get('/report/all', [ReportController::class,'allStudentsReport'])->name('report.allStudentsReport');
    Route::get('/report/single', [ReportController::class,'singleStudentReport'])->name('report.singleStudentReport');


    Route::get('/divisions', [GradingController::class, 'divisions_index'])->name('divisions.index'); 
    Route::post('/divisions/update', [GradingController::class, 'divisions_update'])->name('divisions.update');
    Route::get('/grades', [GradingController::class, 'grade_index'])->name('grade.index'); 
    Route::post('/grades/update', [GradingController::class, 'grade_update'])->name('grade.update');

    Route::get('/configuration/index', [GradingController::class, 'configuration_index'])->name('configuration.index'); 
    Route::get('/SMS/index', [SMSController::class, 'index'])->name('sms.index'); 
    Route::post('/SMS/send', [SMSController::class, 'messaging'])->name('sms.send'); 
    

    // Fees
    Route::get('/fees', [PaymentController::class, 'indexFees'])->name('fees.index');
    Route::get('/fee_structure', [PaymentController::class, 'fee_structure'])->name('fees.fee_structure');
    Route::post('/fees', [PaymentController::class, 'storeFee'])->name('fees.store');
    Route::get('/receipts/generate', [PaymentController::class, 'generate_receipts'])->name('generate_receipts');


    // Payments
    Route::get('/payments/create', [PaymentController::class, 'createPayment'])->name('payments.create');
    Route::get('/payments/view', [PaymentController::class, 'view_payment'])->name('payments.view');
    Route::post('/payments', [PaymentController::class, 'storePayment'])->name('payments.store');
    Route::get('/debtors/notify', [PaymentController::class, 'debtors_index'])->name('debtors.index');
    Route::post('/debtors/SMS/notify', [SMSController::class, 'notify_debitors'])->name('notify_debitors'); 
    Route::get('/debtors/view', [PaymentController::class, 'debtors_all'])->name('debitors.all'); 



});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');
require __DIR__.'/auth.php';
