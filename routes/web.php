<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', 'TopController@index')->name('index');
Route::post('/', 'TopController@analyze')->name('index');


Route::get('business_card', 'BusinessCardController@index');
Route::post('business_card/extract', 'BusinessCardController@extract');
