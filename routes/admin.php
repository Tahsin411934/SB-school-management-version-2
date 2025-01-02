<?php

use App\Http\Controllers\AdmissionFeeController;
use App\Http\Controllers\AdmissionPaymentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EventFeeController;
use App\Http\Controllers\EventFeePaymentController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MonthlyFeeController;
use App\Http\Controllers\MonthlyFeePaymentController;
use App\Http\Controllers\MonthlyFeeStudentController;
use App\Http\Controllers\PasswordResetLinkController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\StationaryFeeBuyController;
use App\Http\Controllers\StationaryFeeController;
use App\Http\Controllers\StudentClassController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\StudentLedgerController;
use Illuminate\Support\Facades\Route;

Route::get('/admin/login', [LoginController::class,'create']);
Route::post('/admin/login-store', [LoginController::class,'store']);
Route::post('/admin/logout', [LoginController::class,'destroy']);
Route::get('/admin/register', function(){
return view('admin.pages.register');
});

Route::get('/admin/forget-password', [PasswordResetLinkController::class,'create']);


Route::middleware('admin')->group(function(){
    Route::get('/admin/dashboard', [AuthController::class,'index']);


    Route::get('/admin/create-category', [CategoryController::class, 'create']);
    Route::post('/admin/store-category', [CategoryController::class, 'store']);
    Route::get('/admin/getAllCategories', [CategoryController::class, 'getAllCategories']);
    Route::get('/admin/edit-category/{id}', [CategoryController::class, 'edit']);
    Route::post('/admin/update-category/{id}', [CategoryController::class, 'update']);
    Route::get('/admin/delete-category/{id}', [CategoryController::class, 'delete']);

    //student class
    Route::get('/admin/create-studentClass', [StudentClassController::class, 'create']);
    Route::post('/admin/store-studentClass', [StudentClassController::class, 'store']);
    Route::get('/admin/getAllStudentsClass', [StudentClassController::class, 'getAllStudentsClass']);
    Route::get('/admin/student-ledger', [StudentLedgerController::class, 'getStudentLedger'])->name('student.ledger');
    Route::get('/admin/edit-studentClass/{id}', [StudentClassController::class, 'edit']);
    Route::post('/admin/update-studentClass/{id}', [StudentClassController::class, 'update']);
    Route::get('/admin/delete-studentClass/{id}', [StudentClassController::class, 'delete']);
    
    //admissionFee
    Route::get('/admin/create-admissionFee', [AdmissionFeeController::class, 'create']);
    Route::post('/admin/store-admissionFee', [AdmissionFeeController::class, 'store']);
    Route::get('/admin/getAllAdmissionFee', [AdmissionFeeController::class, 'getAllAdmissionFee']);
    Route::get('/admin/edit-admissionFee/{id}', [AdmissionFeeController::class, 'edit']);
    Route::put('/admin/update-admissionFee/{id}', [AdmissionFeeController::class, 'update']);
    Route::get('/admin/delete-admissionFee/{id}', [AdmissionFeeController::class, 'delete']);
    //monthlyFee
    Route::get('/admin/create-monthlyFee', [MonthlyFeeController::class, 'create']);
    Route::post('/admin/store-monthlyFee', [MonthlyFeeController::class, 'store']);
    Route::get('/admin/getAllMonthlyFee', [MonthlyFeeController::class, 'getAllMonthlyFee']);
    Route::get('/admin/edit-monthlyFee/{id}', [MonthlyFeeController::class, 'edit']);
    Route::put('/admin/update-monthlyFee/{id}', [MonthlyFeeController::class, 'update']);
    Route::get('/admin/delete-monthlyFee/{id}', [MonthlyFeeController::class, 'delete']);

    //student
    Route::get('/admin/create-student', [StudentController::class, 'create']);
    Route::post('/admin/store-student', [StudentController::class, 'store']);
    Route::get('/admin/getClasses', [StudentClassController::class, 'getAllClasses']);
    Route::get('/admin/getAllStudents', [StudentController::class, 'getAllStudents']);
    Route::get('/admin/getAdmitedStudents/{class_id}', [StudentController::class, 'getAllAdmittedStudents'])->name('student.classWise');
    Route::get('/admin/edit-student/{id}', [StudentController::class, 'edit']);
    Route::put('/admin/update-student/{id}', [StudentController::class, 'update']);
    Route::get('/admin/student-profile/{id}', [StudentController::class, 'show']);
    Route::get('/admin/delete-student/{id}', [StudentController::class, 'delete']);

    Route::get('/admin/getAllStudentPromotion', [StudentController::class, 'getAllStudentClassWise']);
    Route::get('/admin/getAllStudentShifting', [StudentController::class, 'getAllStudentClassWiseShifting']);

    Route::get('admin/student-details', [StudentController::class, 'showDetails'])->name('student.details');
    Route::get('admin/student-shifting', [StudentController::class, 'showShiftingDetails'])->name('student.shifting');
    
    Route::post('/admin/promote-students', [StudentController::class, 'promoteStudents'])->name('student.promote');

    Route::post('/admin/shifting-student', [StudentController::class, 'shiftingStudent'])->name('class.shifting');


    //admission payment methods


    Route::get('/admin/admission-payment/{id}', [AdmissionPaymentController::class, 'create']);
    Route::post('/admin/store-admission-payment', [AdmissionPaymentController::class, 'store']);
    Route::get('admin/generate-invoice/{student_id}', [AdmissionPaymentController::class, 'generateInvoice']);

    
    //monthlyFeeStudent
    Route::get('/admin/monthly-fee-student', [MonthlyFeeStudentController::class, 'create']);   
    Route::post('/admin/store-student-monthly-fee', [MonthlyFeeStudentController::class, 'storeStudentMonthlyFee']);   
    Route::get('/admin/getAllStudentMonthlyFee', [MonthlyFeeStudentController::class, 'getAllStudentMonthlyFee']);   
    Route::get('admin/monthly-fee-student-details', [MonthlyFeeStudentController::class, 'showDetails'])->name('monthlyFeeStudent.details');
    Route::get('/admin/student-monthly-payment/{id}', [MonthlyFeeStudentController::class, 'MonthlyFee']);
    Route::get('admin/get-stationary-fee-data/{studentId}', [MonthlyFeeStudentController::class, 'getStationaryFeeData']);

    //stationaryFee
    Route::get('/admin/create-stationaryFee', [StationaryFeeController::class, 'create']);
    Route::post('/admin/store-stationaryFee', [StationaryFeeController::class, 'store']);
    Route::get('/admin/getAllStationaryFee', [StationaryFeeController::class, 'getAllStationaryFee']);
    Route::get('/admin/edit-stationaryFee/{id}', [StationaryFeeController::class, 'edit']);
    Route::put('/admin/update-stationaryFee/{id}', [StationaryFeeController::class, 'update']);
    Route::get('/admin/delete-stationaryFee/{id}', [StationaryFeeController::class, 'delete']);


    //stationaryFeeBuy
    Route::get('/admin/create-stationaryFeeBuy', [StationaryFeeBuyController::class, 'create']);
    Route::post('admin/store-stationaryFeeBuy', [StationaryFeeBuyController::class, 'store']);
    
    
    //eventFee
    Route::get('/admin/create-eventFee', [EventFeeController::class, 'create']);
    Route::post('admin/store-eventFee', [EventFeeController::class, 'store']);
    Route::get('admin/show-eventFee', [EventFeeController::class, 'showGroupedEventFees']);
    Route::get('event-fee/details/{event_name}/{class}', [EventFeeController::class, 'showEventDetails'])->name('eventFee.details');
    Route::post('event-fee/pay/{student_id}/{class_id}/{event_id}', [EventFeePaymentController::class, 'payFee'])->name('eventFee.pay');
    Route::get('event-fee/invoice/{student_id}/{class_id}/{event_id}', [EventFeePaymentController::class, 'generateInvoice'])->name('eventFee.generateInvoice');
    Route::get('/event-fee/edit/{id}', [EventFeeController::class, 'edit'])->name('eventFee.edit');
    Route::post('/admin/event-fee/update', [EventFeeController::class, 'update'])->name('eventFee.update');
    
    //event fee payment
    Route::post('event-fee/pay/{student_id}/{class_id}/{event_id}', [EventFeePaymentController::class, 'payFee'])->name('eventFee.pay');

    //monthly payments
    Route::post('admin/store-monthly-payment', [MonthlyFeePaymentController::class, 'store']);
    //invoice
    Route::get('/admin/student-monthly-invoice-payment/{id}/{month}', [StudentController::class, 'generateInvoice']);
    
    //reports
    Route::get('/admin/reports/daily-collection', [ReportController::class, 'dailyCollectionReport'])->name('reports.daily_collection');
    Route::get('/admin/reports/getAllStudentMonthlyFee', [ReportController::class, 'getAllStudentMonthlyFee']);
    Route::get('/admin/reports/getAllDueStudentMonthlyFee', [ReportController::class, 'getAllStudentDueMonthlyFee']);
    Route::get('/admin/reports/monthly-tuition-summary/{month}', [ReportController::class, 'monthlyTuitionSummary'])->name('reports.monthly_tuition_summary');
    Route::get('/admin/reports/monthly-collection-due-summary/{month}', [ReportController::class, 'monthlyCollectionDueSummary'])->name('reports.monthly_collection_due_summary');


    Route::get('/admin/reports/new-admitted-student-list', [ReportController::class, 'getAllStudents']);
    Route::get('/admin/reports/all-admitted-student-list', [ReportController::class, 'getAllStudentsList']);
    Route::get('/admin/reports/all-admitted-student-fee', [ReportController::class, 'admissionFeeReport']);

    //task
    Route::get('/admin/tasks/create-task', [TaskController::class, 'create']);
    Route::get('/admin/tasks/getYourTasks', [TaskController::class, 'getYourTasks']);
    Route::post('/admin/store-task', [TaskController::class, 'store']);
    Route::get('admin/edit-task/{id}', [TaskController::class, 'edit'])->name('admin.task.edit');
    Route::put('admin/update-task/{id}', [TaskController::class, 'update'])->name('admin.task.update');
    
    //roles
    Route::get('/admin/create-role', [RolesController::class, 'create']);
    Route::post('/admin/store-role', [RolesController::class, 'store']);
    Route::get('/admin/roles', [RolesController::class, 'index']);
    Route::get('/admin/edit-role/{id}', [RolesController::class, 'edit']);
    Route::put('/admin/update-role/{id}', [RolesController::class, 'update']);
    Route::delete('/admin/delete-role/{id}', [RolesController::class, 'destroy']);
    //users
    Route::get('/admin/create-user', [UsersController::class, 'create']);
    Route::post('/admin/store-user', [UsersController::class, 'store']);
    Route::get('/admin/users', [UsersController::class, 'index']);
    Route::get('/admin/edit-user/{id}', [UsersController::class, 'edit']);
    Route::put('/admin/update-user/{id}', [UsersController::class, 'update']);
    Route::delete('/admin/delete-user/{id}', [UsersController::class, 'destroy']);

    
});