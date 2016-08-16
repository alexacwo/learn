<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use App\Task;
use Illuminate\Http\Request;


Route::get('/tasks', 'TaskController@index');
Route::post('/task', 'TaskController@store');
Route::delete('/task/{task}', 'TaskController@destroy');

Route::auth();

Route::get('/', 'TaskController@index');
Route::get('/home', 'TaskController@index');

Route::get('/admin', 'AdminController@index');
Route::get('/admin/tests', 'AdminController@index');
Route::get('/admin/edit/{test}', 'AdminController@edit_test');

Route::post('/admin/test_create', 'AdminController@test_create');
Route::post('/admin/edit/{test}', 'AdminController@add_question');


