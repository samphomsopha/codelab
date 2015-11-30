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
Route::get('/home', ['middleware' => ['parseinit', 'auth'], 'as' => 'home', 'uses' => 'HomeController@showHome']);
Route::get('/calendar', ['middleware' => ['parseinit', 'auth'], 'as' => 'calendar', 'uses' => 'HomeController@showCalendar']);
/** Group **/
Route::get('/groups', ['middleware' => ['parseinit', 'auth'], 'as' => 'groups', 'uses' => 'GroupController@showGroups']);
Route::get('/group/', ['middleware' => ['parseinit', 'auth'], 'as' => 'group', 'uses' => 'GroupController@showGroup']);
Route::get('/group/{id}', ['middleware' => ['parseinit', 'auth'], 'as' => 'groupView', 'uses' => 'GroupController@showGroupView']);
Route::get('/editgroup/{id}', ['middleware' => ['parseinit', 'auth'], 'as' => 'editgroup', 'uses' => 'GroupController@editGroup']);
Route::get('/new-group', ['as' => 'newgroup','uses' => 'GroupController@newGroup']);
Route::post('/new-group', ['middleware' => ['parseinit', 'auth'], 'uses' => 'GroupController@newGroup']);
Route::get('/join-group', ['as' => 'joinGroup', 'uses' => 'GroupController@joinGroup']);
Route::post('/join-group', ['middleware' => ['parseinit', 'auth'], 'uses' => 'GroupController@joinGroup']);

/** Events */
Route::get('/join-event', ['as' => 'joinEvent', 'uses' => 'EventController@joinEvent']);
Route::post('/join-event', ['middleware' => ['parseinit', 'auth'], 'uses' => 'EventController@joinEvent']);
Route::get('/editevent/{id}', ['middleware' => ['parseinit', 'auth'], 'as' => 'editEvent', 'uses' => 'EventController@editEvent']);

/** chat room */
Route::get('/chat/{roomId}', ['middleware' => ['parseinit', 'auth'], 'as' => 'chat', 'uses' => 'ChatController@showChat']);
Route::get('/services/chat/{roomId}/messages/{messageId}/{since}', ['middleware' => ['parseinit', 'auth'], 'as' => 'chatService', 'uses' => 'ChatServiceController@getMessages']);
Route::get('/chat/upload/{roomId}', ['middleware' => ['parseinit', 'auth'], 'as' => 'chatUpload', 'uses' => 'ChatController@showUploader']);
Route::post('/chat/upload', ['middleware' => ['parseinit', 'auth'], 'as' => 'chatUploadHandle', 'uses' => 'ChatServiceController@upload']);
Route::post('/chat/message', ['middleware' => ['parseinit', 'auth'], 'as' => 'chatNewMessage', 'uses' => 'ChatServiceController@newMessage']);

/** messages */
Route::get('/services/message/{id}/delete', ['middleware' => ['parseinit', 'auth'], 'as' => 'messageDelete', 'uses' => 'ChatServiceController@deleteMessage']);

Route::match(array('GET','POST'), '/process-group',['middleware' => ['parseinit', 'auth'], 'as' => 'processGroup', 'uses' => 'GroupController@processGroup']);
Route::match(array('GET', 'POST'), '/group/{gid}/new-event',['middleware' => ['parseinit', 'auth'], 'as' => 'newEvent', 'uses' => 'EventController@newEvent']);
Route::get('/login', ['as' => 'login', 'uses' => 'LoginController@showLogin']);
Route::get('/logout', ['middleware' => ['parseinit', 'auth'], 'as' => 'logout', 'uses' => 'LoginController@processLogout']);
Route::match(array('GET', 'POST'), '/process-login', ['middleware' => ['parseinit'], 'as' => 'processLogin', 'uses' => 'LoginController@processLogin']);
Route::get('/register', ['middleware' => ['parseinit', 'auth'], 'as' => 'register', 'uses' => 'LoginController@showRegister']);
Route::match(array('GET', 'POST'),'/process-register', ['middleware' => ['parseinit', 'auth'], 'as' => 'processRegister', 'uses' => 'LoginController@processRegister']);
Route::get('/fblogin', ['middleware' => ['parseinit'], 'uses' => 'LoginController@processFBLogin']);

/** Shared Assets */
Route::get('assets/upload/{forid}', ['middleware' => ['parseinit', 'auth'], 'as' => 'upload', 'uses' => 'AssetController@showUpload']);
Route::post('assets/upload/{forid}', ['middleware' => ['parseinit', 'auth'], 'as' => 'processupload', 'uses' => 'AssetController@processUpload']);