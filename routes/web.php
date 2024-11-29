<?php

use Illuminate\Support\Facades\Route;
use App\Filament\Resources\WajibTeraPasarResource;
use App\Filament\Resources\UttpNotificationResource;

Route::get('/', function () {
    return view('welcome');
});

// Filament automatically handles resource routes, including export actions.
// If you have custom routes for export, add them here.

// Example of adding a custom export route (if needed)
// This is usually not necessary as the export action is handled by the resource.
Route::get('/wajib-tera-pasar/export', [WajibTeraPasarResource::class, 'exportPDF'])->name('wajib_tera_pasar.export_pdf');
