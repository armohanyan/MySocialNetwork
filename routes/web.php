<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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


// ------------------------------------------ THIS ROUTES ARE ABOUT HOME ---------------------------------------------------------


Route::prefix('/')->middleware('auth')->group(function () {
        Route::get('/', 'App\Http\Controllers\HomeController@index')->name('home') ;
}); 

// ------------------------------------------ THIS ROUTES ARE ABOUT AUTH ---------------------------------------------------------

Route::prefix('/')->middleware('guest')->group(function () {
        Route::get('signup','App\Http\Controllers\AuthController@getSignup')->name('auth.signup');
        Route::post('signup','App\Http\Controllers\AuthController@postSignup');
        Route::get('signin','App\Http\Controllers\AuthController@getSignin')->name('auth.signin');
        Route::post('signin','App\Http\Controllers\AuthController@postSignin');
}); 
 
// ------------------------------------------ THIS ROUTES ARE ABOUT SIGNOUT ---------------------------------------------------------

Route::get('/signout', 'App\Http\Controllers\AuthController@getSignOut')->name('auth.signout') ; 

// ------------------------------------------ THIS ROUTES ARE ABOUT SEARCH ---------------------------------------------------------

Route::prefix('search')->middleware('auth')->group(function () {
        Route::get('/', 'App\Http\Controllers\SearchController@getResults')->middleware('auth')->name('search.results') ; 
});

// ------------------------------------------ THIS ROUTES ARE ABOUT PROFILE ---------------------------------------------------------

Route::prefix('profile')->middleware('auth')->group(function () {
        Route::get('/user/{username}','App\Http\Controllers\ProfileController@getProfile')->name('user.profile'); 
        Route::get('/edit','App\Http\Controllers\ProfileController@getEdit') ->name('profile.edit');
        Route::post('/edit','App\Http\Controllers\ProfileController@setEdit');
}); 

// ------------------------------------------ THIS ROUTES ARE ABOUT FRIEND ---------------------------------------------------------
                                
Route::prefix('friend')->middleware('auth')->group(function () {
        Route::get('/profile/{username}', 'App\Http\Controllers\FriendController@getIndex')->name('user.friends'); 
        Route::get('/add/{username}/', 'App\Http\Controllers\FriendController@getAdd')->name('add.friends'); 
        Route::get('/accept/{username}/', 'App\Http\Controllers\FriendController@getAccept')->name('accept.friends'); 
        Route::get('/delete/{username}/', 'App\Http\Controllers\FriendController@deleteFriend')->name('delete.friend'); 
}); 


// ------------------------------------------ THIS ROUTES ARE ABOUT STATUS ---------------------------------------------------------

Route::prefix('status')->middleware('auth')->group(function () {
        Route::post('/add', 'App\Http\Controllers\StatusController@postStatus')->name('add.status'); 
        Route::get('/destoy/{id}', 'App\Http\Controllers\StatusController@destroy')->name('destroy.status');      
        Route::post('/{statusId}/comment', 'App\Http\Controllers\StatusController@postComment')->name('post.comment'); 
        Route::get('/{statusId}/like', 'App\Http\Controllers\StatusController@getLike')->name('get.like'); 
});

// ------------------------------------------ THIS ROUTES ARE ABOUT ALBUM  ---------------------------------------------------------

Route::prefix('album')->middleware('auth')->group(function () {
        Route::get('/{username}', 'App\Http\Controllers\AlbumController@getAlbum')->name('get.albums'); 
        Route::post('/add', 'App\Http\Controllers\AlbumController@postAlbum')  ->name('post.album');          
        Route::delete('/{albumId}', 'App\Http\Controllers\AlbumController@DeleteAlbum')->name('delete.album'); 
        Route::get('/{albumId}/user/{username}', 'App\Http\Controllers\AlbumController@getImage')->name('get.image');    
        Route::delete('/{albumId}/image/{imageId}', 'App\Http\Controllers\AlbumController@deleteImage')->name('delete.image');
        Route::post('/{albumId}/images', 'App\Http\Controllers\AlbumController@postImage')->name('post.image'); 
        Route::get('/{imageId}/like', 'App\Http\Controllers\AlbumController@getLike')->name('get.image.like');    
});