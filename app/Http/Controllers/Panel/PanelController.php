<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Menu;
use App\Reservation;
use App\Point_log;
use Auth;
use Carbon\Carbon;

class PanelController extends Controller
{
    //
    public function index(){
      if(Auth::user()->role == 0 ){
      $reservation = Reservation::orderBy('created_at','desc')->limit(10)->get();
    }elseif(Auth::user()->role == 1){
    $reservation = Reservation::where('id_user',Auth::user()->id)->orderBy('created_at','desc')->limit(10)->get();
    }elseif(Auth::user()->role == 2 ){
    $reservation = Reservation::where('payment_status',">=",0)->whereDate('reservation_datetime',Carbon::today())->orderBy('payment_status','asc')->limit(10)->get();

    }

      $pointLog = Point_log::where('id_user',Auth::user()->id)->limit(4)->get();
      // dd($menuOrdered);
      $data = [
        'reservation' => $reservation,
        'pointLog' => $pointLog
      ];

        return view('panel.index')->with('data',$data);
    }
}
