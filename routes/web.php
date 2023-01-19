<?php
use App\Followup;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


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

    return view('login');
});



Route::group(['middleware' => 'auth','middleware' => 'checkstatus'], function () {

    Route::get('dashboard','DashboardController@index');
    Route::get('users/getUsers','UsersController@getUsers')->name('users.getUsers');
    Route::get('company/getCompany','CompanyController@getCompany')->name('company.getCompany');
    Route::get('/', 'HomeController@index');
  
    Route::resource('users', 'UsersController');
    Route::resource('company', 'CompanyController');
    
});

Route::post('users/change_status_by_id','UsersController@change_status_by_id');
Route::post('company/change_status_by_id','CompanyController@change_status_by_id');

Route::group(['middleware' => 'checkstatus'], function () {
    Auth::routes();
});

Route::get('/register', function () {
    return redirect('/login');

});

Route::get('forget-password', 'Auth\ForgotPasswordController@getEmail');
Route::post('forget-password', 'Auth\ForgotPasswordController@postEmail');

Auth::routes(['verify' => true]);

Route::get('/verify', function () {
    return redirect('/verify');
});
Route::get('/password/reset', function () {
    return redirect('/login');
});

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/reset/{token}', 'Auth\ResetPasswordController@getPassword');
Route::post('/reset', 'Auth\ResetPasswordController@updatePassword');
