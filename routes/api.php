<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::post('tokens/create', [\App\Http\Controllers\ApiTokenController::class, 'createToken']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('/hall', App\Http\Controllers\HallController::class);

    Route::put('/hall/prices/{id}', [App\Http\Controllers\HallController::class, 'updatePrices']);

    Route::get('/hall/{hallId}/seances', [App\Http\Controllers\HallController::class, 'getSeances']);

    Route::put('/hall/{hallId}/sales', [App\Http\Controllers\HallController::class, 'setSales']);

    Route::put('/chair', [App\Http\Controllers\ChairController::class, 'updateChairs']);

    Route::apiResource('/movie', App\Http\Controllers\MovieController::class);

    Route::delete('/seance/all/{movieId}', [App\Http\Controllers\SeanceController::class, 'deleteAll']);
});


Route::get('/hall/{hallId}/chairs', [App\Http\Controllers\HallController::class, 'getChairs']);

Route::get('/chair/seance/{seanceId}/date/{date}', [App\Http\Controllers\ChairController::class, 'getBySeanceIdAndDate']);

Route::apiResource('/seance', App\Http\Controllers\SeanceController::class);

Route::apiResource('/chair', App\Http\Controllers\ChairController::class);

Route::get('/hall/{hallId}/seances/{movieId}', [App\Http\Controllers\HallController::class, 'getSeances']);

Route::get('/movie/date/{date}', [App\Http\Controllers\MovieController::class, 'getByDate']);

Route::get('/hall/seances/available', [App\Http\Controllers\HallController::class, 'getSeancesAvailable']);

Route::post('/ticket', [App\Http\Controllers\TicketController::class, 'store']);

Route::post("/qrcode", [App\Http\Controllers\QrcodeController::class, 'getQrcode']);

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
    return 'ok';
});
