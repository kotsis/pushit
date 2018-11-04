<?php

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

Route::get('/admin/pushit', 'Kotsis\\Pushit\\PushitController@index');
Route::get('/pushit_subscribe', 'Kotsis\\Pushit\\PushitController@subscribe');