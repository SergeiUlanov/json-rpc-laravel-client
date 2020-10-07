<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WidgetFormController;


Route::get('/', function () {
    return view('request');
})->name('request');

Route::get('response', function () {
    return view('response');
})->name('response');

Route::get('errors', function () {
    return view('errors');
})->name('errors');

Route::post('/', [WidgetFormController::class, 'storeWidgetForm'])->name('request');
Route::post('response', [WidgetFormController::class, 'storeWidgetForm'])->name('response');
Route::post('errors', [WidgetFormController::class, 'storeWidgetForm'])->name('errors');

//Route::get('debug', [WidgetFormController::class, 'storeWidgetFormDebug'])->name('debug');
