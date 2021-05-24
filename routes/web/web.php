<?php

use Illuminate\Support\Facades\Route;


Auth::routes();


Route::get('/', 'HomeController@index')->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin', 'AdminsController@index')->name('admin.index');    
});




