<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\BranchController;
use App\Http\Controllers\Api\FieldworkCategoryController;
use App\Http\Controllers\Api\FieldworkStatusController;
use App\Http\Controllers\Api\ListUserController;
use App\Http\Controllers\Api\RegionController;
use App\Http\Controllers\Api\UserPhoneController;
use App\Http\Controllers\Api\UserProfileController;
use App\Http\Controllers\Api\FieldworkController;
use App\Http\Controllers\Api\FieldworkExportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/login', [AuthApiController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthApiController::class, 'logout'])->name('api.logout');
    Route::get('/me', [AuthApiController::class, 'me'])->name('api.me');

    Route::apiResource('region', RegionController::class);
    Route::apiResource('branch', BranchController::class);
    Route::get('branch/region/{region_id}', [BranchController::class, 'getByRegion']);
    Route::apiResource('fieldwork_statuses', FieldworkStatusController::class);
    Route::apiResource('fieldwork_category', FieldworkCategoryController::class);
    Route::apiResource('userphone', UserPhoneController::class);
    Route::apiResource('listuser', ListUserController::class);
    Route::apiResource('fieldwork', FieldworkController::class);
    Route::prefix('fieldwork/export')->group(function () {
        Route::get('/index', [FieldworkExportController::class, 'index']);
        Route::get('/excel', [FieldworkExportController::class, 'exportExcel']);
        Route::get('/pdf', [FieldworkExportController::class, 'exportPdf']);
    });

    Route::get('/profile/me', [UserProfileController::class, 'myProfile']);
    Route::post('/profile', [UserProfileController::class, 'store']);
    Route::put('/profile', [UserProfileController::class, 'update']);
    
});
