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

use App\Http\Controllers\CommentController;
use App\Post;
use App\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {

});

Route::get('/', function () {
    $posts= Post::orderBy('created_at','desc')->with(['comments' => function($query) {
        $query->with('comments_thumbs');
    }],'thumbs')->get();
    return view('welcome', compact('posts'));
})->name('dashboard');



Route::get('/post', 'PostController@index')->name('post_question')->middleware('verified');
Route::get('/post/{post}','PostController@show')->name('show')->middleware('verified');
Route::post('/post','PostController@create')->middleware('verified');
Route::patch('/post/update/{post}','PostController@update')->name('update')->middleware('verified');
Route::delete('/delete/{post}','PostController@delete')->name('delete')->middleware(['verifiedToDelete']);

Route::post('/comment','CommentController@create')->name('create')->middleware('verified');
Route::post('/comment/update','CommentController@update')->name('updateComment')->middleware('verified');
Route::delete('/comment/{comment}','CommentController@delete')->name('deleteComment')->middleware('verified');

Route::post('/post/thumb','PostThumbsController@thumb')->name('postThumb')->middleware('verified');
Route::post('/comment/thumb','CommentThumbsController@thumb')->name('commentThumb')->middleware('verified');



Auth::routes(['verify'=>true]);
Route::middleware(['verified'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
    //
});
