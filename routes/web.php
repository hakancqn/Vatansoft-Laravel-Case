<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::prefix('/user')->middleware('authorization')->group(
    function () {
        Route::get('/list', [UserController::class, 'list']);

        Route::post('/insert', [UserController::class, 'insert']);

        Route::put('/update/{id}', [UserController::class, 'update']);

        Route::put('/updatepw/{id}', [UserController::class, 'updatepw']);

        Route::delete('/delete/{id}', [UserController::class, 'delete']);

        Route::delete('/destroy/{id}', [UserController::class, 'destroy']);
    }
);

Route::get('/csrf', function () {
    return csrf_token();
});