<?php

use Illuminate\Http\Request;
use App\Reservation;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/reservation/notify', "Panel\ReservationController@notify")->name('payment.notification');

Route::post('/reservation/redirect',function(Request $request){
  $reservation = Reservation::where('reservation_code',$request->TRANSIDMERCHANT)->first();
  return view('panel.reservation.confirmation')->with('request',$request)->with('reservation',$reservation);
});
