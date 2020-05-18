<?php

use Illuminate\Support\Facades\Route;
use App\Http\Request\HomeRequest;
use App\Http\Middleware\UselessMiddleware;
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
Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::get('/welcome', 'HomeController@welcome'); 

Route::get('/home', 'HomeController@get');  

Route::post('/home', 'HomeController@post');

Route::get('/logout', 'HomeController@logout');
        
Route::get('/delete/{id?}', 'HomeController@delete');

Route::get('comment/{name?}/{id?}','HomeController@comment');

Route::post('comment/{name?}/{id?}','HomeController@commentpost');

Route::get('/home/favorite/{id?}', 'HomeController@favorite');


