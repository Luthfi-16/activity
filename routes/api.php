<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegionController;
use App\Http\Controllers\Api\BranchController;
use App\Http\Controllers\Api\FieldworkStatusController;
use App\Http\Controllers\Api\FieldworkCategoryController;
use App\Http\Controllers\Api\UserPhoneController;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource('region', RegionController::class);
Route::apiResource('branch', BranchController::class);
Route::get('branch/region/{region_id}', [BranchController::class, 'getByRegion']);
Route::apiResource('fieldwork_statuses', FieldworkStatusController::class);
Route::apiResource('fieldwork_category', FieldworkCategoryController::class);
Route::apiResource('userphone', UserPhoneController::class);