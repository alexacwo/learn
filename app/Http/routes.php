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

use App\Test;
use Illuminate\Http\Request;


Route::auth();


// Registration routes
Route::get('/register', 'Auth\AuthController@getRegister');

/* CLIENT */

Route::get('/', 'Client\ClientController@index');
Route::get('/home', 'Client\ClientController@index');

Route::get('/test/{test}', 'Client\ClientController@pass_test');

/* CLIENT -- TESTS: Create the test result and show test results */

Route::post('/test_result_create/', 'Client\ClientController@create_test_result');
Route::get('/test_result/{test_result}/', 'Client\ClientController@show_test_result');

/* ADMIN */

Route::get('/admin', 'Admin\AdminMainController@index');

/* ADMIN -- TESTS: Add, edit and delete tests */

Route::get('/admin/tests', 'Admin\AdminTestController@index');
Route::get('/admin/edit/{test}', 'Admin\AdminTestController@edit_test');

Route::post('/admin/test_create', 'Admin\AdminTestController@test_create');
Route::post('/admin/edit/{test}', 'Admin\AdminTestController@add_question');
Route::post('/admin/edit_questions/{test}', 'Admin\AdminTestController@edit_questions');

Route::delete('/delete_test/{test}', function (Test $test) {
    $test->delete();

    return redirect('/admin');
});

/* JSON information of available questions and options for a given test for AngularJS front-end */

Route::get('/admin/test_crud_json/{test}', 'Admin\AdminTestController@test_crud_json');


