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

/*Route::get('/', function () {
    return view('welcome');
});*/
Route::get('/', function () {
    return view('index');
});
// Route::get('/login', function () {
//     return view('login');
// });


Auth::routes();

Route::get('/home', 'HomeController@index')->name('dashboard');
Route::get('/users/logout','Auth\LoginController@userLogout')->name('user.logout');

Route::prefix('user')->group(function(){
Route::get('/courses/courselist', 'Courses\UserCoursesController@index')->name('user.courses.index');
Route::get('/courses/details/{id}', 'Courses\UserCoursesController@details')->name('user.courses.details');
Route::post('/courses/enroll/{id}', 'Courses\UserCoursesController@enroll')->name('user.courses.enroll');
Route::get('/courses/request/{id}', 'Courses\UserCoursesController@request')->name('user.courses.request');

Route::post('/profile/update','UserProfileController@update')->name('user.profile.update');
Route::get('/profile/request','UserProfileController@request')->name('user.profile.request');
});

Route::prefix('admin')->group(function(){
	Route::get('/login','Auth\AdminLoginController@showLoginForm')->name('admin.login');
	Route::post('/login','Auth\AdminLoginController@login')->name('admin.login.submit');
	Route::get('/', 'AdminController@index')->name('admin.dashboard');
	Route::get('/logout','Auth\AdminLoginController@logout')->name('admin.logout');

	Route::get('/courses', 'Courses\CoursesController@index')->name('admin.courses.index');
	Route::get('/courses/details/{id}', 'Courses\CoursesController@details')->name('admin.courses.details');
	Route::get('/courses/add', 'Courses\CoursesController@add')->name('admin.courses.add');
	Route::post('/courses/insert', 'Courses\CoursesController@insert')->name('admin.courses.insert');

	Route::post('/courses/edit/{id}', 'Courses\CoursesController@edit')->name('admin.courses.edit');
	
	Route::post('/courses/update/{id}', 'Courses\CoursesController@update')->name('admin.courses.update');
	Route::get('/courses/delete/{id}', 'Courses\CoursesController@delete')->name('admin.courses.delete');

	Route::get('/courses/request/{id}', 'Courses\CoursesController@request')->name('admin.courses.request');
	//Route::post('/courses/request','Courses\CoursesController@edit')

	Route::post('/password/email','Auth\AdminForgetPasswordController@sendResetLinkEmail')->name('admin.password.email');
	Route::get('/password/reset','Auth\AdminForgetPasswordController@showLinkRequestForm')->name('admin.password.request');
	Route::post('/password/reset','Auth\AdminResetPasswordController@reset');
	Route::get('/password/reset/{token}','Auth\AdminResetPasswordController@showResetForm')->name('admin.password.reset');

});

