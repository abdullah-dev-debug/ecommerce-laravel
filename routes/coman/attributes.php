<?php

use App\Http\Controllers\Assets\AttributesController;
use App\Http\Controllers\Assets\ColorController;
use App\Http\Controllers\Assets\SizeController;
use App\Http\Controllers\Assets\UnitController;
use Illuminate\Routing\Route;

Route::prefix('attributes')->name('attributes.')->group(function () {
    Route::get('/', [AttributesController::class, 'index'])->name('list');

    Route::prefix('colors')->name('color.')->group(function () {
        Route::post('/', [ColorController::class, 'store'])->name('store');
        Route::delete('/{color}', [ColorController::class, 'destroy'])->name('destroy');
        Route::put('/{color}', [ColorController::class, 'update'])->name('update');
        Route::put('/{color}/status', [ColorController::class, 'toggleStatus'])->name('status');
    });

    Route::prefix('sizes')->name('size.')->group(function () {
        Route::post('/', [SizeController::class, 'store'])->name('store');
        Route::delete('/{size}', [SizeController::class, 'destroy'])->name('destroy');
        Route::put('/{size}', [SizeController::class, 'update'])->name('update');
        Route::put('/{size}/status', [SizeController::class, 'toggleStatus'])->name('status');
    });

    Route::prefix('units')->name('unit.')->group(function () {
        Route::post('/', [UnitController::class, 'store'])->name('store');
        Route::delete('/{unit}', [UnitController::class, 'destroy'])->name('destroy');
        Route::put('/{unit}', [UnitController::class, 'update'])->name('update');
        Route::put('/{unit}/status', [UnitController::class, 'toggleStatus'])->name('status');
    });
})

    ?>