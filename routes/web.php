<?php


use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Models\ConfigurationTable;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;



Route::get('/', function () {
    return view('welcome');
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

foreach (ConfigurationTable::all() as $page){
    Route::get('/' . $page->route, [ConfigurationController::class,'index'])->defaults('route', $page->route)->name($page->route);
    Route::get('/' . $page->route .'/create', [ConfigurationController::class,'create'])->defaults('route', $page->route)->name($page->route.'.'.'create');
    Route::post('/' . $page->route .'/store', [ConfigurationController::class,'store'])->defaults('route', $page->route)->name($page->route.'.'.'store');
    Route::get('/' . $page->route .'/edit/{id}', [ConfigurationController::class,'edit'])->defaults('route', $page->route)->name($page->route.'.'.'edit');
    Route::put('/' . $page->route .'/update/{id}', [ConfigurationController::class,'update'])->defaults('route', $page->route)->name($page->route.'.'.'update');
    Route::delete('/' . $page->route .'/delete/{id}', [ConfigurationController::class,'destroy'])->defaults('route', $page->route)->name($page->route.'.'.'delete');
}




