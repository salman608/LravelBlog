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

Route::get('/','HomeController@index')->name('home');
Route::get('post/{slug}','PostController@details')->name('post.details');
Route::get('posts','PostController@index')->name('post.index');
Route::get('categoryposts/{slug}','PostController@categoryPost')->name('category.posts');
Route::get('tagposts/{slug}','PostController@tagPost')->name('tag.posts');
// Route::get('categorypost/{slug}','PostController@postByCategory')->name('category.post
Route::get('/search','SearchController@search')->name('search');


Route::post('subscriber','SubscriberController@store')->name('subscriber.store');

Auth::routes();

Route::group(['middleware'=>['auth']], function(){
    Route::post('favorite/{post}/add','FavoriteController@add')->name('post.favorite');
    Route::post('comment/{post}','CommentController@store')->name('comment.store');
});

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['as'=>'admin.','prefix'=>'admin','namespace'=>'Admin','middleware'=>['auth','admin']],function(){
   Route::get('dashboard','DashboardController@index')->name('dashboard');

   Route::get('setting','SettingController@index')->name('setting');
   Route::put('update-profile','SettingController@updateProfile')->name('profile.update');
   Route::put('update-password','SettingController@updatePassword')->name('password.update');

   Route::resource('tag','TagController');
   Route::resource('category','CategoryController');
   Route::resource('post','PostController');

   Route::put('/post/{id}/approve','PostController@approval')->name('post.approve');
   Route::get('pending/post','PostController@pending')->name('post.pending');
   Route::get('/subscriber','SubscriberController@index')->name('subscriber.index');
   Route::delete('/subscriber/{subscriber}','SubscriberController@destroy')->name('subscriber.destroy');

   Route::get('/favorite','FavoriteController@index')->name('favorite.index');

   Route::get('comments','CommentController@index')->name('comment.index');
   Route::delete('comment/{id}','CommentController@destroy')->name('comment.destroy');

   Route::get('authors','AuthorController@index')->name('author.index');
   Route::delete('authors/{id}','AuthorController@destroy')->name('author.destroy');

});

Route::group(['as'=>'author.','prefix'=>'author','namespace'=>'Author','middleware'=>['auth','author']],function(){
  Route::get('dashboard','DashboardController@index')->name('dashboard');
  Route::resource('post','PostController');
  Route::get('setting','SettingController@index')->name('setting');
  Route::put('update-password','SettingController@updatePassword')->name('password.update');
  Route::put('update-profile','SettingController@updateProfile')->name('profile.update');

  Route::get('/favorite','FavoriteController@index')->name('favorite.index');

  Route::get('comments','CommentController@index')->name('comment.index');
  Route::delete('comment/{id}','CommentController@destroy')->name('comment.destroy');



});
