<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Authenticate


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {

});

//DASHBOARD ROUTE
Route::get('/','HomeController@index')->name('dashboard');

//POST DELETE ROUTE
Route::delete('/delete/{post}','PostController@delete')->name('delete')->middleware(['verifiedToDelete']);

//COMMENT DELETE ROUTE
Route::delete('/comment/{comment}','CommentController@delete')->name('deleteComment')->middleware('verified');





Auth::routes(['verify'=>true]);

//VERIFIED MIDDLEWARE
Route::middleware(['verified'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');

    // POST ROUTES
    Route::get('/post', 'PostController@index')->name('post_question');
    Route::get('/post/{post}','PostController@show')->name('show');
    Route::post('/post','PostController@create');
    Route::patch('/post/update/{post}','PostController@update')->name('update');
    
    
    //COMMENT ROUTES
    Route::post('/comment','CommentController@create')->name('create');
    Route::post('/comment/update','CommentController@update')->name('updateComment');

    //ThumbController
    Route::post('/post/thumb','PostThumbsController@thumb')->name('postThumb');
    Route::post('/comment/thumb','CommentThumbsController@thumb')->name('commentThumb');

    Route::post('/thumb','ThumbController@thumb')->name('thumb');

});
