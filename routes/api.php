<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CopyController;
use App\Http\Controllers\LendingController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use App\Models\Book;
use App\Models\Copy;
use App\Models\Reservation;
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


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth.basic')->group(function () {
    Route::middleware('admin')->group(function () {
    Route::apiResource('/users', UserController::class);});

    Route::get('lending_by_user', [UserController::class, 'lendingByUser']);
    Route::get('all_lending_user_copy',[LendingController::class,'allLendingUserCopy' ]);
    Route::get('date_lending',[LendingController::class,'dateLending' ]);
    Route::get('count_lending_by_user', [UserController::class, 'countLendingByUser']);
    //lekérdezések with:
    Route::get('title_count/{title}', [BookController::class, 'titleCount']);
    Route::get('get_hardcovered/{hardcovered}', [BookController::class,'getHardcovered' ]);
    Route::get('adott_ev/{publication}', [BookController::class,'adottev' ]);
    Route::get('bent_levok', [BookController::class,'bentlevok' ]);
    Route::get('ma_visszahozott', [BookController::class,'mavisszahozott' ]);

    Route::patch('bring-back/{copy_id}/{start}', [LendingController::class, 'bringBack']);
    Route::post('/lendings', [LendingController::class, 'store']);
});


Route::apiResource('/copies', CopyController::class);
Route::apiResource('/books', BookController::class);

Route::get('/lendings', [LendingController::class, 'index']);
Route::get('/lendings/{user_id}/{copy_id}/{start}', [LendingController::class, 'show']);
//Route::put('/lendings/{user_id}/{copy_id}/{start}', [LendingController::class, 'update']);
Route::post('/lendings', [LendingController::class, 'store']);
Route::delete('/lendings/{user_id}/{copy_id}/{start}', [LendingController::class, 'destroy']); 


Route::get('/reservations', [ReservationController::class, 'index']);
Route::get('/reservations/{book_id}/{user_id}/{start}', [ReservationController::class, 'show']);
Route::post('/reservations', [ReservationController::class, 'store']);
Route::delete('/reservations/{book_id}/{user_id}/{start}', [ReservationController::class, 'destroy']);
Route::put('/reservations/{book_id}/{user_id}/{start}', [ReservationController::class, 'update']);


//egyéb végpontok
Route::patch('/user_update_password/{id}', [UserController::class, 'updatePassword']);

Route::get('/tobbkonyves_szerzo', [BookController::class,'tobbkonyvesszerzo' ]);
Route::get('ma_visszahozott', [BookController::class,'mavisszahozott' ]);