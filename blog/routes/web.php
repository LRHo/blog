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
Route::group(['prefix'=>'','namespace'=>'Home'],function(){
    Route::get('/','IndexController@index');
    Route::get('/cate/{cate_id}', 'IndexController@cate');
    Route::get('/a/{art_id}', 'IndexController@article');
});
Route::group(['prefix'=>'admin','namespace'=>'Admin'],function(){
    Route::any('login','LoginController@login');
    Route::get('code','LoginController@code');
});

Route::group(['prefix'=>'admin','namespace'=>'Admin',
    'middleware'=>['web','admin.login']],function(){
    Route::get('index','IndexController@index');
    Route::get('info','IndexController@info');
    Route::get('quit','LoginController@quit');

    Route::any('pass','IndexController@pass');
    Route::any('upload','CommonController@upload');

    Route::post('cate/change','CategoryController@changeOrder');
    Route::post('link/change','LinksController@changeOrder');
    Route::post('nav/change','NavsController@changeOrder');
    Route::post('config/change','ConfigController@changeOrder');
    Route::post('config/changeContent','ConfigController@changeContent');
    Route::get('config/putfile','ConfigController@putFile');


    Route::resource('category','CategoryController');
    Route::resource('article','ArticleController');
    Route::resource('links','LinksController');
    Route::resource('navs','NavsController');
    Route::resource('config','ConfigController');
});
