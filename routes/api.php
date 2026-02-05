<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIController;

Route::post('login', [APIController::class, 'login']);

Route::middleware('auth:sanctum')->group( function () {
    Route::post('logout', [APIController::class, 'logout']);
    Route::get('get-information', [APIController::class, 'getInformation']);
    Route::get('get-invoices', [APIController::class, 'getInvoices']);
    Route::get('get-invoice-by-id/{id}', [APIController::class, 'getInvoiceById']);
    Route::get('download-invoice-by-id/{id}', [APIController::class, 'downloadInvoiceById']);
    Route::get('get-receipts', [APIController::class, 'getReceipts']);
    Route::get('get-receipt-by-id/{id}', [APIController::class, 'getReceiptById']);
    Route::get('download-receipt-by-id/{id}', [APIController::class, 'downloadReceiptById']);
    Route::get("get-home-data",[APIController::class, 'home']);
    Route::get("get-course-details/{id}",[APIController::class, 'getCourseDetails']);
    Route::get("get-lesson-details/{id}",[APIController::class, 'getLessonById']);
    Route::get("get-material-details/{id}",[APIController::class, 'getMaterialById']);

});




