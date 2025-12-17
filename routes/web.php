<?php


use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\EnrolledCourseController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Models\Configuration;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\StudentTypeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomFieldController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RelatedCoursesStatusController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\SectionVideoController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\WatchedVideoController;
use App\Http\Controllers\FavoriteVideoController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\CompanyController;


Route::get('/', function () {
    return redirect()->route('home');
});


Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

Route::resource('roles', RoleController::class);
Route::post('/roles/assign-permissions', [RoleController::class, 'assignPermissions'])->name('roles.assign_permissions');
Route::get('/users/assign-permissions', [PermissionController::class, 'assignPermissionsPage'])->name('assign-permissions');
Route::post('/users/assign-permissions', [PermissionController::class, 'assignPermissions'])->name('users.assign_permissions');
Route::get('/users/{id}/permissions', [PermissionController::class, 'getUserPermissions']);
Route::resource('student-type', StudentTypeController::class);
Route::resource('student', StudentController::class);
Route::resource('user', UserController::class);
Route::get('reset-password-modal', [UserController::class, 'resetPasswordModal'])->name('reset-password-modal');
Route::post('reset-password-form', [UserController::class, 'updatePassword'])->name('reset-password-form');
Route::resource('custom-field', CustomFieldController::class);
Route::resource('payment', PaymentController::class);
Route::post('get-enrollment-status', [PaymentController::class, 'getEnrollmentStatus'])->name('get-enrollment-status');
Route::resource('courses-status', RelatedCoursesStatusController::class);
Route::resource('section', SectionController::class);
Route::resource('chapter', ChapterController::class);
Route::resource('course', CourseController::class);
Route::resource('section-video',SectionVideoController::class);
Route::resource('material',MaterialController::class);
Route::delete('material-pdf/{id}', [MaterialController::class, 'deletePdf'])->name('material-pdf.delete');
Route::resource('watched-video',WatchedVideoController::class);
Route::resource('favorite-video',FavoriteVideoController::class);
Route::resource('enrolled-course',EnrolledCourseController::class);
Route::get('download-enrollment/{id}',[DownloadController::class,'receipt'])->name('download-enrollment');
Route::get('download-payment/{id}',[DownloadController::class,'payment'])->name('download-payment');



Route::get('view-student/{id}', [StudentController::class, 'viewStudent'])->name('view-student');

Route::get('home-student', [FrontController::class, 'myCourses'])->name('home-student');
Route::get('view-course/{id}', [FrontController::class, 'viewCourse'])->name('view-course');
Route::get('my-account', [FrontController::class, 'editAccount'])->name('my-account');
Route::get('change-password', [FrontController::class, 'updatePassword'])->name('change-password');
Route::get('view-lesson/{id}', [FrontController::class, 'viewLesson'])->name('view-lesson');


Route::resource('enrolled-course',EnrolledCourseController::class);
Route::get('enrolled-invoice/{id}', [EnrolledCourseController::class, 'getInvoice'])->name('enrolled-invoice');
Route::get('payment-invoice/{id}', [PaymentController::class, 'getInvoice'])->name('payment-invoice');
Route::post('change-password', [UserController::class, 'changePassword'])
    ->name('user.password.update');



Route::resource('company', CompanyController::class);



