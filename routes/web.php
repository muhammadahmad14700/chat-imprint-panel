<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

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

Route::get('/', function () {
    return view('welcome');
});
// Email related routes
//Route::get('/send-email', 'MailController@sendEmail');
Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::post('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');
Route::post('verifycode', 'Auth\VerificationController@verifycode')->name('verifycode');
Route::get('/cache-clear', function() {
    Artisan::call('optimize:clear');
    echo Artisan::output();
    //return "Cache is cleared. Application Optimized";
});

//New Routes For Social login
//Route::get('login/{social}', [LoginController::class, 'socialLogin'])->name('social.login');
//Route::get('login/{social}/callback', [LoginController::class, 'handleProviderCallback'])->name('social.callback');

Route::get('login/{social}', [LoginController::class, 'socialLogin']);
Route::get('login/{social}/callback', [LoginController::class, 'handleProviderCallback']);
/*
Route::group(['prefix' => 'admin'], function()
{
    Route::get('/admin', 'AdminController@index')->name('admin');
	Route::get('/manage', ['middleware' => ['permission:manage-admins'], 'uses' => 'AdminController@manageAdmins']);
    Route::resource('products','ProductController');
    Route::resource('categories','CategoryController');
});
*/
Auth::routes(['verify' => true]);

Route::get('/admin', 'AdminController@index')->name('admin');
Route::get('/chat', 'ChatController@index')->name('chat');
//Route::get('/manage', ['middleware' => ['permission:manage-admins'], 'uses' => 'AdminController@manageAdmins']);
Route::resource('products','ProductController');
Route::resource('categories','CategoryController');

Route::get('/home', 'UserController@index')->name('user')->middleware('verified');
Route::get('/user', 'UserController@index')->name('user')->middleware('verified');
Route::get('/username', 'UserController@username')->name('username')->middleware('verified');
Route::post('/save-name', 'UserController@save_name')->name('save-name')->middleware('verified');
Route::get('/password', 'UserController@password')->name('password')->middleware('verified');
Route::post('/save-password', 'UserController@save_password')->name('save-password')->middleware('verified');
// Route::get('/chat', 'ChatController@index');
Auth::routes();
