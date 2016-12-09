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

Route::get('/', 'JobsController@index');
Route::get('/add', 'JobsController@add');
Route::get('/edit/{job}', 'JobsController@edit');
Route::get('/delete', 'JobsController@delete');
Route::get('/dashboard', 'JobsController@dashboard');

Route::get('/settings', 'SettingsController@index');

Route::post('/add', 'JobsController@store');
Route::post('/edit/{job}', 'JobsController@update');
Route::post('/delete/{job}', 'JobsController@purge');

Route::get('/search', 'JobsController@search');
//Route::match(array('GET', 'POST'), '/search', 'JobsController@search');

Route::get('/jobs/status/{status}', 'JobsController@jobsByStatus');
Route::get('/jobs/status/{status}/{page}', 'JobsController@jobsByStatus');
Route::get('/jobs/page/{page}', 'JobsController@jobsByPage');

Route::get('/customer/{name}', 'JobsController@jobsByCustomer');


Route::get('/api/getjobstatus/{job}', 'JobsController@apigetstatus');
Route::get('/api/getstatuslist', 'JobsController@getstatuslist');
Route::post('/api/setjobstatus/{job}', 'JobsController@setjobstatus');
Route::post('/api/closejob/{job}', 'JobsController@closejob');

Route::post('/api/setstatuscolor/{status}', 'SettingsController@setstatuscolor');
Route::post('/api/setstatusname/{status}', 'SettingsController@setstatusname');
Route::post('/api/addstatus', 'SettingsController@addstatusname');

Route::post('/stores/store', 'SettingsController@addstore');
Route::post('/stores/delete/{store}', 'SettingsController@deletestore');
Route::post('/statuses/store', 'SettingsController@addstatus');
Route::post('/statuses/delete/{status}', 'SettingsController@deletestatus');
?>
