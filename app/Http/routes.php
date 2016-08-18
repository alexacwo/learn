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

Route::auth();

/* CLIENT side */

Route::get('/', 'ClientController@index');
Route::get('/home', 'ClientController@index');

Route::get('/test/{test}', 'ClientController@pass_test');

/* ADMIN side */

Route::get('/admin', 'Admin\AdminMainController@index');

/* TESTS: Add, edit and delete tests */

Route::get('/admin/tests', 'Admin\AdminTestController@index');
Route::get('/admin/edit/{test}', 'Admin\AdminTestController@edit_test');

Route::post('/admin/test_create', 'Admin\AdminTestController@test_create');
Route::post('/admin/edit/{test}', 'Admin\AdminTestController@add_question');
Route::post('/admin/add_option/{test}', 'Admin\AdminTestController@add_option');

//Route::post('/admin/test_options_json/{test}', 'Admin\AdminTestController@test_options_json');

Route::get('/admin/test_options_json/{test}', 'Admin\AdminTestController@test_options_json');


