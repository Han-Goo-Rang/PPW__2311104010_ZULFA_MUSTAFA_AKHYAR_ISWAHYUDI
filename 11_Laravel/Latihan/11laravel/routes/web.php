<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Tugas 1: Perulangan for untuk menampilkan bilangan 1 s.d 10
Route::get('/mahasiswa', function () {
    $nilai = [80, 64, 30, 76, 95];
    return view('mahasiswa', $nilai);
});

// Tugas 2: Perulangan while untuk menampilkan bilangan 1 s.d 10
Route::get('/while', function () {
    return view('while');
});

// Tugas 3: Perulangan foreach untuk menampilkan nilai pada route berikut
Route::get('/foreach', function () {
    $nilai = [80, 64, 30, 76, 95];
    return view('foreach', compact('nilai'));
});
