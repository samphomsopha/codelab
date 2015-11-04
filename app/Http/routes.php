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
Route::get('/home', ['as' => 'home', 'uses' => 'HomeController@showHome']);
Route::match(array('GET','POST'), '/new-group','GroupController@newGroup');
Route::get('/join-group','GroupController@joinGroup');
Route::match(array('GET','POST'),'/process-group',['as' => 'processGroup', 'uses' => 'GroupController@processGroup']);
Route::get('/new-event','EventController@newEvent');
Route::get('/join-event','EventController@joinEvent');
Route::get('/login', ['as' => 'login', 'uses' => 'LoginController@showLogin']);
Route::get('/logout', ['as' => 'logout', 'uses' => 'LoginController@processLogout']);
Route::match(array('GET', 'POST'), '/process-login', ['as' => 'processLogin', 'uses' => 'LoginController@processLogin']);
Route::get('/register', ['as' => 'register', 'uses' => 'LoginController@showRegister']);
Route::match(array('GET', 'POST'),'/process-register', ['as' => 'processRegister', 'uses' => 'LoginController@processRegister']);
Route::get('/fblogin', 'LoginController@processFBLogin');