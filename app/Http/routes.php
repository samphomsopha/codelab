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

Route::get('/', 'HomeController@showIndex');
Route::get('/new-event','EventController@newEvent');
Route::get('/join-event','EventController@joinEvent');
Route::get('/login', ['as' => 'login', 'uses' => 'LoginController@showLogin']);
Route::get('/register', ['as' => 'register', 'uses' => 'LoginController@showRegister']);
Route::get('/fblogin', 'LoginController@processFBLogin');