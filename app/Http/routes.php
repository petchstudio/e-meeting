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

Route::auth();

Route::get('storage/{path}', 'ApiController@storage')->where('path', '.*');

Route::group(['middleware' => 'admin', 'prefix' => 'admin', 'namespace' => 'Admin'], function () {

	Route::get('/', function () {
		return redirect('/admin/users');
	    //return view('admin.index');
	});
	
	Route::group(['prefix' => 'api'], function () {
		Route::get('/users', 'UserController@jsonIndex');
		Route::get('/position', 'PositionController@jsonIndex');
		Route::get('/meeting', 'MeetingController@jsonIndex');
		Route::get('/meeting/{meetingId}/user', 'MeetingUserController@jsonIndex');
	});

	Route::get('meeting/{id}/file/delete', 'MeetingController@destroyFile');
	Route::resource('users', 'UserController');
	Route::resource('position', 'PositionController');
	Route::resource('meeting', 'MeetingController');
	Route::resource('meeting/{meetingId}/user', 'MeetingUserController');
});

Route::group(['middleware' => 'auth'], function () {
	Route::get('/', 'HomeController@index');

	Route::group(['prefix' => 'api'], function () {
		Route::get('/meeting', 'MeetingController@jsonIndex');
		Route::get('/meeting/{status}', 'MeetingController@jsonIndex');
	});
});