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
Route::get('aboutlab','HomeController@aboutlab')->name('aboutlab');
Route::get('/home', 'HomeController@index')->name('dashboard');
Route::get('/users/logout','Auth\LoginController@userLogout')->name('user.logout');

Route::prefix('user')->group(function(){
Route::get('/courses/courselist', 'Courses\UserCoursesController@index')->name('user.courses.index');
Route::get('/courses/mycourses', 'Courses\UserCoursesController@indexmy')->name('user.courses.my');
Route::get('/courses/details/{id}', 'Courses\UserCoursesController@details')->name('user.courses.details');
Route::post('/courses/enroll/{id}', 'Courses\UserCoursesController@enroll')->name('user.courses.enroll');
Route::get('/courses/request/{id}', 'Courses\UserCoursesController@request')->name('user.courses.request');
Route::get('/assignment/callpath/{id}','Assignments\UserController@callpath')->name('user.assignments.callpath');
Route::get('/grading/','Grades\UserController@getcourse')->name('user.grades.getcourse');
Route::get('/discover/{id}','Grades\UserController@allscore')->name('user.grades.allscore');
Route::get('/assignment/{id}','Assignments\UserController@indexmy')->name('user.assignments.indexmy');
Route::get('/score/{id}','Assignments\UserController@score')->name('user.assignments.score');
Route::get('/details/{id}','Assignments\UserController@detail')->name('user.assignments.detail');
Route::get('/submit/{id}','Assignments\UserController@submit')->name('user.assignments.submit');
Route::post('/push','Assignments\UserController@push')->name('user.assignments.push');
Route::post('/profile/update','UserProfileController@update')->name('user.profile.update');
Route::get('/profile/request','UserProfileController@request')->name('user.profile.request');
Route::get('/courses/outline/{id}','Courses\CoursesController@outline')->name('user.courses.detail');
});

Route::prefix('admin')->group(function(){

	Route::post('/profile/update','AdminProfileController@update')->name('admin.profile.update');
	Route::get('/profile/request','AdminProfileController@request')->name('admin.profile.request');
	Route::get('/profile/drop/{id}','AdminProfileController@drop')->name('admin.profile.drop');
	Route::post('/assign','Auth\AdminRegisterController@addnew')->name('admin.register.addnew');
	Route::get('/showassign','Auth\AdminRegisterController@show')->name('admin.register.show');

	Route::get('/login','Auth\AdminLoginController@showLoginForm')->name('admin.login');
	Route::post('/login','Auth\AdminLoginController@login')->name('admin.login.submit');
	Route::get('/', 'AdminController@index')->name('admin.dashboard');
	Route::get('/logout','Auth\AdminLoginController@logout')->name('admin.logout');

	Route::get('/assignment/add/{id}', 'Assignments\AssignmentsController@add')->name('admin.assignments.add');
	Route::get('/assignment/callpath/{id}','Assignments\AssignmentsController@callpath')->name('admin.assignments.callpath');

	Route::get('/assignment/callmaster1/{id}','Assignments\AssignmentsController@callmaster1')->name('admin.assignments.callmaster1');
	Route::get('/assignment/callout1/{id}','Assignments\AssignmentsController@callout1')->name('admin.assignments.callout1');
	Route::get('/remarks/explore/{id}','Assignments\AssignmentsController@maxscoreshow')->name('admin.assignments.maxscoreshow');

	Route::get('/remarks/{id}','Assignments\AssignmentsController@showremark')->name('admin.assignments.showremark') ;

	Route::get('/discover/{courseid}/{pinid}','Grades\AdminController@requestmark')->name('admin.remarks.requestmark');
	Route::get('/selectmode','Grades\AdminController@selector')->name('admin.remarks.pickmode');
	Route::get('/showuser/{id}','Grades\AdminController@showuser')->name('admin.remarks.showuser');

	Route::get('/assignment/callmaster2/{id}','Assignments\AssignmentsController@callmaster2')->name('admin.assignments.callmaster2');
	Route::get('/assignment/callout2/{id}','Assignments\AssignmentsController@callout2')->name('admin.assignments.callout2');
	
	Route::get('/assignment/callmaster3/{id}','Assignments\AssignmentsController@callmaster3')->name('admin.assignments.callmaster3'); Route::get('/assignment/callout3/{id}','Assignments\AssignmentsController@callout3')->name('admin.assignments.callout3');
Route::get('/assignment/callmaster4/{id}','Assignments\AssignmentsController@callmaster4')->name('admin.assignments.callmaster4'); Route::get('/assignment/callout4/{id}','Assignments\AssignmentsController@callout4')->name('admin.assignments.callout4');
Route::get('/assignment/callmaster5/{id}','Assignments\AssignmentsController@callmaster5')->name('admin.assignments.callmaster5'); Route::get('/assignment/callout5/{id}','Assignments\AssignmentsController@callout5')->name('admin.assignments.callout5');


	Route::get('/assignment/detail/{id}','Assignments\AssignmentsController@detail')->name('admin.assignments.detail');
	Route::get('/assignment/droper/{id}','Assignments\AssignmentsController@droper')->name('admin.assignments.droper');
	Route::get('/assignment/show/{id}','Assignments\AssignmentsController@show')->name('admin.assignments.show');
	Route::post('assignment/create','Assignments\AssignmentsController@insert')->name('admin.assignments.create');

	Route::get('assignment/drop/{id}','Assignments\AssignmentsController@drop')->name('admin.assignments.drop');
	Route::post('/assignment/{id}', 'Assignments\AssignmentsController@index')->name('admin.assignments.index');

	Route::post('/assignment/editreq/update','Assignments\AssignmentsController@update')->name('admin.assignments.update');
	Route::get('/assignment/editreq/{id}','Assignments\AssignmentsController@edit')->name('admin.assignments.editreq');
	Route::get('/assignment/request/{id}','Assignments\AssignmentsController@request')->name('admin.assignments.request');

	Route::get('/remarks','Courses\CoursesController@routeremark')->name('admin.couses.routeremark');
Route::get('/callcourse','Courses\CoursesController@callcourse')->name('admin.courses.callcourse');

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

