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
Route::get('/calendar', ['as' => 'calendar', 'uses' => 'HomeController@showCalendar']);
/** Group **/
Route::get('/groups', ['as' => 'groups', 'uses' => 'GroupController@showGroups']);
Route::get('/group/', ['as' => 'group', 'uses' => 'GroupController@showGroup']);
Route::get('/group/{id}', ['as' => 'groupView', 'uses' => 'GroupController@showGroupView']);
Route::get('/editgroup/{id}', ['as' => 'editgroup', 'uses' => 'GroupController@editGroup']);
Route::match(array('GET','POST'), '/new-group', ['as' => 'newgroup','uses' => 'GroupController@newGroup']);
Route::match(array('GET','POST'), '/join-group', ['as' => 'joinGroup','uses' => 'GroupController@joinGroup']);

/** Events */
Route::match(array('GET','POST'), '/join-event', ['as' => 'joinEvent', 'uses' => 'EventController@joinEvent']);
Route::get('/editevent/{id}', ['as' => 'editEvent', 'uses' => 'EventController@editEvent']);

/** chat room */
Route::get('/chat/{roomId}', ['as' => 'chat', 'uses' => 'ChatController@showChat']);
Route::get('/services/chat/{roomId}/messages/{messageId}/{since}', ['as' => 'chatService', 'uses' => 'ChatServiceController@getMessages']);
Route::get('/chat/upload/{roomId}', ['as' => 'chatUpload', 'uses' => 'ChatController@showUploader']);

Route::match(array('GET','POST'), '/process-group',['as' => 'processGroup', 'uses' => 'GroupController@processGroup']);
Route::match(array('GET', 'POST'), '/group/{gid}/new-event',['as' => 'newEvent', 'uses' => 'EventController@newEvent']);
Route::get('/login', ['as' => 'login', 'uses' => 'LoginController@showLogin']);
Route::get('/logout', ['as' => 'logout', 'uses' => 'LoginController@processLogout']);
Route::match(array('GET', 'POST'), '/process-login', ['as' => 'processLogin', 'uses' => 'LoginController@processLogin']);
Route::get('/register', ['as' => 'register', 'uses' => 'LoginController@showRegister']);
Route::match(array('GET', 'POST'),'/process-register', ['as' => 'processRegister', 'uses' => 'LoginController@processRegister']);
Route::get('/fblogin', 'LoginController@processFBLogin');

/** Shared Assets */
Route::get('assets/upload/{forid}', ['as' => 'upload', 'uses' => 'AssetController@showUpload']);
Route::post('assets/upload/{forid}', ['as' => 'processupload', 'uses' => 'AssetController@processUpload']);