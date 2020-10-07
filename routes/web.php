<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WidgetFormController;


Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('about', function () {
    return view('about');
})->name('about');

Route::get('contacts', function () {
    return view('contacts');
})->name('contacts');

Route::post('/', [WidgetFormController::class, 'storeWidgetForm'])->name('home');
Route::post('about', [WidgetFormController::class, 'storeWidgetForm'])->name('about');
Route::post('contacts', [WidgetFormController::class, 'storeWidgetForm'])->name('contacts');

//Route::get('debug', [WidgetFormController::class, 'storeWidgetFormDebug'])->name('debug');
