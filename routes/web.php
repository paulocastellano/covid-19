<?php

// auth routes
Auth::routes(['register' => false]);

// home
Route::get('/', 'HomeController@index')->name('home');

// cities
Route::get('/estados/{state}/cidades/{city}', 'CitiesController@show')->name('cities.show');

// states
Route::get('/estados/{state}', 'StatesController@show')->name('states.show');
