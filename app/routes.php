<?php
use Illuminate\View\Environment;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::resource('users', 'UsersController');
Route::resource('files', 'FilesController');
Route::resource('feedback', 'FeedbackController');
Route::resource('goals', 'GoalsController');
Route::resource('endorsements', 'EndorsementsController');
Route::resource('agree', 'AgreeController');
Route::resource('circles', 'CirclesController');
Route::resource('rights', 'RightsController');

Route::get('friends/add', 'FriendsController@getAdd');
Route::post('friends/add', 'FriendsController@postAdd');
Route::get('friends/autocomplete', 'FriendsController@getAutocomplete');

Route::controller('friends/{id}', 'FriendsController');
Route::controller('tribe', 'TribeController');



Route::controller('/', 'ApplicationController');
