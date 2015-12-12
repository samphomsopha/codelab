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

Route::get('/', ['uses' => 'HomeController@showIndex', 'middleware' => ['parseinit']]);
Route::get('/home', ['middleware' => ['parseinit', 'auth'], 'as' => 'home', 'uses' => 'HomeController@showHome']);
Route::get('/testmail', ['middleware' => ['parseinit', 'auth'], 'uses' => 'HomeController@emailTest']);

/** Profile **/
Route::get('/profile/', ['as' => 'profile', 'uses' => 'ProfileController@showIndex', 'middleware' => ['parseinit', 'auth']]);
Route::get('/profile/edit', ['as' => 'editProfile', 'uses' => 'ProfileController@showEdit', 'middleware' => ['parseinit', 'auth']]);
Route::post('/profile/save', ['as' => 'saveProfile', 'uses' => 'ProfileController@save', 'middleware' => ['parseinit', 'auth']]);
Route::post('/services/profile/upload', ['as' => 'uploadProfile', 'uses' => 'ProfileServiceController@upload', 'middleware' => ['parseinit', 'auth']]);
/** Group **/
Route::get('/groups', ['middleware' => ['parseinit', 'auth'], 'as' => 'groups', 'uses' => 'GroupController@showGroups']);
Route::get('/group/', ['middleware' => ['parseinit', 'auth'], 'as' => 'group', 'uses' => 'GroupController@showGroup']);
Route::get('/group/{id}', ['middleware' => ['parseinit', 'auth'], 'as' => 'groupView', 'uses' => 'GroupController@showGroupView']);
Route::get('/group/{id}/delete', ['middleware' => ['parseinit', 'auth'], 'as' => 'groupDelete', 'uses' => 'GroupController@deleteGroup']);
Route::get('/editgroup/{id}', ['middleware' => ['parseinit', 'auth'], 'as' => 'editgroup', 'uses' => 'GroupController@editGroup']);
Route::get('/new-group', ['as' => 'newgroup','uses' => 'GroupController@newGroup']);
Route::post('/new-group', ['middleware' => ['parseinit', 'auth'], 'uses' => 'GroupController@newGroup']);
Route::get('/join-group', ['middleware' => ['parseinit'], 'as' => 'joinGroup', 'uses' => 'GroupController@joinGroup']);
Route::get('/joingroup/email/{code}', ['middleware' => ['parseinit'], 'as' => 'joinGroupByEmail', 'uses' => 'GroupController@joinGroupByLink']);

Route::post('/join-group', ['middleware' => ['parseinit'], 'uses' => 'GroupController@joinGroup']);
/** Group Services */
Route::get('/services/groups/events', ['middleware' => ['parseinit', 'auth'], 'as' => 'groupService', 'uses' => 'GroupServiceController@events']);
Route::get('/services/groups/events/{day}', ['middleware' => ['parseinit', 'auth'], 'as' => 'groupService', 'uses' => 'GroupServiceController@eventsByDay']);
Route::get('/services/groups/events/week/{week}', ['middleware' => ['parseinit', 'auth'], 'as' => 'groupService', 'uses' => 'GroupServiceController@eventsByWeek']);

/** Notification **/
Route::get('/notifications', ['middleware' => ['parseinit', 'auth'], 'as' => 'notification', 'uses' => 'HomeController@showNotifications']);
/** Notification Server **/
Route::get('/services/notifications/{chat_id?}', ['middleware' => ['parseinit', 'auth'], 'as' => 'getAlerts', 'uses' => 'NotificationServiceController@alerts']);
/** Events */
Route::get('/join-event', ['middleware' => ['parseinit'], 'as' => 'joinEvent', 'uses' => 'EventController@joinEvent']);
Route::post('/join-event', ['middleware' => ['parseinit', 'auth'], 'uses' => 'EventController@joinEvent']);
Route::get('/editevent/{id}', ['middleware' => ['parseinit', 'auth'], 'as' => 'editEvent', 'uses' => 'EventController@editEvent']);
Route::get('/event/{id}/delete', ['middleware' => ['parseinit', 'auth'], 'as' => 'eventDelete', 'uses' => 'EventController@deleteEvent']);


/** chat room */
Route::get('/chat/{roomId}', ['middleware' => ['parseinit', 'auth'], 'as' => 'chat', 'uses' => 'ChatController@showChat']);
Route::get('/services/chat/{roomId}/messages/{messageId}/{since}', ['middleware' => ['parseinit', 'auth'], 'as' => 'chatService', 'uses' => 'ChatServiceController@getMessages']);
Route::get('/chat/upload/{roomId}', ['middleware' => ['parseinit', 'auth'], 'as' => 'chatUpload', 'uses' => 'ChatController@showUploader']);
Route::post('/chat/upload', ['middleware' => ['parseinit', 'auth'], 'as' => 'chatUploadHandle', 'uses' => 'ChatServiceController@upload']);
Route::post('/chat/message', ['middleware' => ['parseinit', 'auth'], 'as' => 'chatNewMessage', 'uses' => 'ChatServiceController@newMessage']);

/** calender */
Route::get('/calendar', ['middleware' => ['parseinit', 'auth'], 'as' => 'calendar', 'uses' => 'CalendarController@showCalendar']);
Route::get('/calendar/month/{date?}', ['middleware' => ['parseinit', 'auth'], 'as' => 'calendarMonthView', 'uses' => 'CalendarController@showCalendar']);
Route::get('/calendar/week/{date?}', ['middleware' => ['parseinit', 'auth'], 'as' => 'calendarWeekView', 'uses' => 'CalendarController@showWeekView']);
Route::get('/calendar/day/{day?}', ['middleware' => ['parseinit', 'auth'], 'as' => 'calendarDayView', 'uses' => 'CalendarController@showDayView']);


/** messages */
Route::get('/services/message/{id}/delete', ['middleware' => ['parseinit', 'auth'], 'as' => 'messageDelete', 'uses' => 'ChatServiceController@deleteMessage']);

Route::match(array('GET','POST'), '/process-group',['middleware' => ['parseinit', 'auth'], 'as' => 'processGroup', 'uses' => 'GroupController@processGroup']);
Route::match(array('GET', 'POST'), '/group/{gid}/new-event', ['middleware' => ['parseinit', 'auth'], 'as' => 'newEvent', 'uses' => 'EventController@newEvent']);
Route::get('/calendar/newevent/{day}', ['middleware' => ['parseinit', 'auth'], 'as' => 'newCalendarEvent', 'uses' => 'EventController@newCalendarEvent']);

Route::get('/login', ['as' => 'login', 'uses' => 'LoginController@showLogin']);
Route::get('/logout', ['middleware' => ['parseinit', 'auth'], 'as' => 'logout', 'uses' => 'LoginController@processLogout']);
Route::match(array('GET', 'POST'), '/process-login', ['middleware' => ['parseinit'], 'as' => 'processLogin', 'uses' => 'LoginController@processLogin']);
Route::get('/register', ['middleware' => ['parseinit'], 'as' => 'register', 'uses' => 'LoginController@showRegister']);
Route::match(array('GET', 'POST'),'/process-register', ['middleware' => ['parseinit'], 'as' => 'processRegister', 'uses' => 'LoginController@processRegister']);
Route::get('/fblogin', ['middleware' => ['parseinit'], 'uses' => 'LoginController@processFBLogin']);

/** Shared Assets */
Route::get('assets/upload/{forid}', ['middleware' => ['parseinit', 'auth'], 'as' => 'upload', 'uses' => 'AssetController@showUpload']);
Route::post('assets/upload/{forid}', ['middleware' => ['parseinit', 'auth'], 'as' => 'processupload', 'uses' => 'AssetController@processUpload']);