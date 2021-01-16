<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', 'App\Http\Controllers\Api\AuthController@register');
Route::post('/login', 'App\Http\Controllers\Api\AuthController@login');

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', 'App\Http\Controllers\Api\AuthController@logout');
    Route::resource('/companies', "App\Http\Controllers\Api\CompanyController");
    Route::resource('/clients', "App\Http\Controllers\Api\ClientController");
    Route::get('/client_companies/{client_id}', 'App\Http\Controllers\Api\ClientController@clientCompanies');
});
