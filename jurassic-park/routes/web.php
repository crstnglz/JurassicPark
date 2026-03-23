<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

Route::get('/home', function(){
    return view('home');
});

Route::get('/login', function() {
    return view('login');
});

Route::get('/register', function(){
    return view('register');
});

Route::get('/profile', function(){
    return view('profile');
});

Route::get('/celdas', function(){
    return view('celdas');
});

Route::get('/dinosaurios', function(){
    return view('dinosaurios');
});

Route::get('/tareas', function() {
    return view ('tareas');
});

Route::get('/mis-tareas', function() {
    return view('mis-tareas');
});

Route::get('/simulacion', function() {
    return view('simulacion');
});

Route::get('/simulacion-brecha', function(){
    return view('simulacion-brecha');
});
