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

Route::get('/', 'App\Http\Controllers\HomeController@index')->middleware('auth')->name('home') ;

// Route::get('/','App\Http\Controllers\AuthController@getSignin')
//         ->middleware('guest')
//         ->name('auth.signin');

// if(Auth::check) { 
//         Route::get('/', 'App\Http\Controllers\HomeController@index')->middleware('auth')->name('home') :
// };

/*  Authing  */

Route::get('/signup','App\Http\Controllers\AuthController@getSignup')
        ->middleware('guest')
        ->name('auth.signup');
Route::post('/signup','App\Http\Controllers\AuthController@postSignup')
         ->middleware('guest');

Route::get('/signin','App\Http\Controllers\AuthController@getSignin')
        ->middleware('guest')
        ->name('auth.signin');

Route::post('/signin','App\Http\Controllers\AuthController@postSignin')
         ->middleware('guest') 
;

Route::get('/signout', 'App\Http\Controllers\AuthController@getSignOut')
         ->name('auth.signout') ; 


/*  Search  */

Route::get('/search', 'App\Http\Controllers\SearchController@getResults')
          ->middleware('auth')
          ->name('search.results') ; 

/*  Profile */

Route::get('/user/{username}','App\Http\Controllers\ProfileController@getProfile')
          ->middleware('auth')
          ->name('user.profile'); 

Route::get('/profile/edit','App\Http\Controllers\ProfileController@getEdit')
          ->name('profile.edit');

Route::post('/profile/edit','App\Http\Controllers\ProfileController@setEdit');

/*  Friends */

Route::get('/profile/{username}/friends/', 'App\Http\Controllers\FriendController@getIndex')
          ->middleware('auth')
          ->name('user.friends'); 

Route::get('/friends/add/{username}/', 'App\Http\Controllers\FriendController@getAdd')
          ->middleware('auth')
          ->name('add.friends'); 

Route::get('/friends/accept/{username}/', 'App\Http\Controllers\FriendController@getAccept')
          ->middleware('auth')
          ->name('accept.friends'); 

Route::get('/friends/delete/{username}/', 'App\Http\Controllers\FriendController@deleteFriend')
          ->middleware('auth')
          ->name('delete.friend'); 

/* Status */

Route::post('/add/status',  'App\Http\Controllers\StatusController@postStatus')
          ->middleware('auth')
          ->name('add.status'); 

Route::get('status/destoy/{id}', 'App\Http\Controllers\StatusController@destroy')
        ->middleware('auth')
        ->name('destroy.status'); 

          
Route::post('status/{statusId}/comment', 'App\Http\Controllers\StatusController@postComment')
        ->middleware('auth')
        ->name('post.comment'); 

                    
Route::get('status/{statusId}/like', 'App\Http\Controllers\StatusController@getLike')
        ->middleware('auth')
        ->name('get.like'); 

Route::get('/{username}/albums', 'App\Http\Controllers\AlbumController@getAlbum')
        ->middleware('auth')
        ->name('get.albums');    
// Albums 
Route::post('/add/album', 'App\Http\Controllers\AlbumController@postAlbum')
        ->middleware('auth')
        ->name('post.album');          

Route::get('/{username}/albums/{albumId}/images', 'App\Http\Controllers\AlbumController@getImage')
        ->middleware('auth')
        ->name('get.image');    

Route::delete('/albums/{albumId}', 'App\Http\Controllers\AlbumController@DeleteAlbum')
        ->middleware('auth')
        ->name('delete.album'); 

Route::delete('/albums/{albumId}/image/{imageId}', 'App\Http\Controllers\AlbumController@deleteImage')
        ->middleware('auth')
        ->name('delete.image');

Route::post('/albums/{albumId}/images', 'App\Http\Controllers\AlbumController@postImage')
        ->middleware('auth')
        ->name('post.image'); 


            