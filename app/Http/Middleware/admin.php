<?php

namespace App\Http\Middleware;

use Closure;
use App\Badge_log;
use Auth;
use App\Reservation;
use Carbon\Carbon;
use DB;

class admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $newReservation = Reservation::whereDate('reservation_datetime','=',date('Y-m-d'))->where('payment_status','=',0)->count();
        // dd($newReservation);
        //Notification for badge menu
        $badgeNotification = Badge_log::where('id_user',Auth::user()->id)->where('status',0)->count('id_user');
        // 
        // $menuOrdered = DB::table('menus')
        // ->select('menus.id','menus.name', DB::raw('SUM(detail_reservation.qty) As total_sold'))
        // ->join('detail_reservation','menus.id','=','detail_reservation.id_menu')
        // ->join('reservations','detail_reservation.id_reservation','=','reservations.id')
        // ->where('reservations.payment_status','>=',0)->orderBy('total_sold','desc')->groupBy('menus.id')->limit(8)->get();
        // $menuName = [];
        // $totalSold = [];
        // // dd($menuOrdered);
        // foreach($menuOrdered as $m){
        //   $menuName [] = $m->name;
        //   $totalSold [] = $m->total_sold;
        // }

        $data = [
          'reservation' => $newReservation,
          'badge' => $badgeNotification,
        ];
        \View::share('notification', $data);
        // dd($badgeNotification);
        return $next($request);
    }
}
