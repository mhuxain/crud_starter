<?php

use App\Http\Controllers\FileUploadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::resource('/people', \App\Http\Controllers\PersonController::class);
Route::resource('/addresses', \App\Http\Controllers\AddressController::class);
Route::resource('/islands', \App\Http\Controllers\IslandController::class)->only(['index']);
Route::post("/upload", [FileUploadController::class, 'upload']);

Route::get("/files/{fileName}", function ($fileName) {
    $filePath = storage_path('app').DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR.$fileName;
    try {
        $resp = response()->file($filePath);
    } catch (Exception $e) {
        abort(404);
    }
    return $resp;

    // Route::controller(RoleController::class)->group(function () {
    //     Route::get('roles',[RoleController::class,'searchColumns']);

    // });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
