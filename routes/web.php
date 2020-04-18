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

Route::get('/', 'HomeController@index');


Route::resource('country','CountryController');



Auth::routes();

Route::group(['prefix' => 'panel', 'middleware' => ['admin']], function () {
    Route::group(['middleware' => 'auth:web'],function(){

      Route::get('/user/reports','Panel\UserController@reports')->name('user.reports');
      Route::post('/user/generate','Panel\UserController@reportGenerate')->name('user.generate');
      Route::resource('/user','Panel\UserController');
    Route::get('/user/{id}','Panel\UserController@show')->name('user.show');


        Route::get('/', 'Panel\PanelController@index')->name('dashboard');


        Route::get('/badge/collection','Panel\BadgeController@myList')->name('badge.list');
        Route::resource('/badge','Panel\BadgeController');

        Route::get('/profile', 'Panel\ProfileController@index')->name('profile');


        Route::get('/menu/reports','Panel\MenuController@report')->name('menu.reports');
        Route::post('/menu/generate','Panel\MenuController@reportGenerate')->name('menu.generate');
        Route::resource('/menu','Panel\MenuController');
        Route::get('/menu','Panel\MenuController@index')->name('menu');
        Route::get('/menu/{id}/delete','Panel\MenuController@delete')->name('menu.delete');

        Route::get('/point/log','Panel\BadgeController@pointLog')->name('point.log');
        Route::get('/leaderboards','Panel\BadgeController@leaderboards')->name('leaderboards');


        Route::resource('/space','Panel\SpaceController');
        Route::get('/space/{id}/delete','Panel\SpaceController@delete')->name('space.delete');

        Route::get('/reservation/reports','Panel\ReservationController@report')->name('reservation.reports');
        Route::post('/reservation/generate','Panel\ReservationController@reportGenerate')->name('reservation.generate');
        Route::post('/reservation/dpGenerate','Panel\ReservationController@DPreportGenerate')->name('reservation.DPgenerate');
        Route::get('/reservation/all','Panel\ReservationController@all')->name('reservation.all');
        Route::post('/reservation/completed','Panel\ReservationController@reservationComplete')->name('reservation.complete');
        Route::get('/reservation/{id}/extend','Panel\ReservationController@extendPayment')->name('reservation.extend');
        Route::get('/reservation/list','Panel\ReservationController@reservationList')->name('reservation.list');
        Route::get('/reservation/{reservation}/summary','Panel\ReservationController@show')->name('reservation.summary');
        Route::resource('/reservation', 'Panel\ReservationController');
        Route::post('/reservation/cekstep1','Panel\ReservationController@step1Form')->name('reservation.step1');
        Route::post('/reservation/menu-check','Panel\ReservationController@stepMenu')->name('reservation.menucheck');
        Route::post('/reservation/revieworder','Panel\ReservationController@reviewOrder')->name('reservation.revieworder');
        Route::post('/reservation/getwords','Panel\ReservationController@getWords')->name('reservation.getwords');
        Route::post('/reservation/payment','Panel\ReservationController@beforepayment')->name('reservation.payment');
        Route::post('/reservation/notifyNoPayment','Panel\ReservationController@notifyNoPayment')->name('reservation.notifyNoPayment');
        Route::post('/reservation/notify','Panel\ReservationController@notify')->name('reservation.notify');
        Route::get('/reservation/{id}/run','Panel\ReservationController@run')->name('reservation.run');

        Route::resource('/reward','Panel\RewardController');
        Route::get('/reward/rewardlist/{type}','Panel\RewardController@rewardList')->name('reward.list');

        Route::get('/challange/list','Panel\ChallangeController@challangeList')->name('challange.list');
        Route::resource('/challange','Panel\ChallangeController');

    });
});
