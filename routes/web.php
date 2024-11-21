<?php

use Illuminate\Support\Facades\Route;
use App\Filament\Resources\WajibTeraPasarResource;

Route::get('/', function () {
    return view('welcome');
});

// Add this route to your routes file
Route::get('/wajib-tera-pasar/export-pdf', [WajibTeraPasarResource::class, 'exportPDF'])->name('wajib_tera_pasar.export_pdf');
