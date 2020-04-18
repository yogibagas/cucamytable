<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Space;
use App\Reservation;
use App\Menu;
use Carbon\Carbon;
use App\MenuCategory;
use DB;
use Auth;
use App\Point_log;
use App\Challange;
use App\Reward;
use App\Badge;
use App\Badge_log;
use App\Challange_log;
use App\User;
use App\Detail_payment;
use PDF;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //give an authorize this function need a policy
        if(Auth::user()->role == 0 ){
        $reservation = Reservation::orderBy('created_at','desc')

        ->when($code = $request->get('code'), function($query) use ($code) {
          return $query->where('reservation_code', 'LIKE', "%$code%");
        })
        ->paginate(10);
      }if(Auth::user()->role == 2 ){
        $reservation = Reservation::where('payment_status',">=",0)
        ->whereDate('reservation_datetime',Carbon::today())
        ->when($code = $request->get('code'), function($query) use ($code) {
          return $query->where('reservation_code', 'LIKE', "%$code%");
        })
        ->orderBy('payment_status','asc')
        ->paginate(10);
      }

        // $reservation->where('reservation_code','LIKE','%'.$request->get('code').'%');
      return view('panel.reservation')->with('data',$reservation);
    }

    public function all(Request $request){
    $reservation = Reservation::when($code = $request->get('code'), function($query) use ($code) {
        return $query->where('reservation_code', 'LIKE', "%$code%");
      })->paginate(10);
      return view('panel.reservation')->with('data',$reservation);
    }
    public function reservationList(){
      $data = Reservation::where('id_user',Auth::user()->id)->orderBy('reservation_datetime','desc')->get();
      return view('panel.reservationlist')->with('data',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $maxPax = Space::max('maximum_pax');
        $minPax = Space::min('minimum_pax');
        $menuCategory = DB::table('menu_categories')->select('menu_categories.*')->join('menus','menu_categories.id','=','menus.id_category')->where('menus.status',1)
        ->groupBy('menu_categories.id')->orderBy('menu_categories.menu_group','desc')->get();
        $menu = Menu::where('status',1)->get();
        return view('panel.form.reservation')
        ->with('max',$maxPax)->with('min',$minPax)
        ->with('menu_cat',$menuCategory)->with('menu',$menu);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //insert preparation code

        $dt = Carbon::createFromFormat('m/d/Y H:i', $request->reservation_date . $request->reservation_time);
        $datetime = $dt->format('Y-m-d H:i:s');

        //generate reservation code
        $date = $dt->day;
        $month = $dt->month;
        $year = $dt->format('y');
        $hour = $dt->hour;
        // dd($month);
        $reservationCode = "C-".Auth::user()->id.$hour.$dt->day.$dt->month.$year.$dt->hour;
        // dd($reservationCode);
        $totalPayment =0;
        $menuChoosen = [];
        //check menu and price with total payment
        $i =0;
        foreach($request->id_menu as $menu){
          $findMenu = Menu::findOrFail($menu);
          $menuChoosen[$menu] = [
            'qty' => $request->qty[$i]
          ];
          $totalPayment += ($findMenu->price*$request->qty[$i]);
          $i++;
        }
        $tax = $totalPayment*18/100;
        $bankFee = ($totalPayment + $tax) * (1.5/100);
        if(empty($request->special_notes) || $request->special_notes == null)
          $request->special_notes = "";


        $dataReservasi = [
          'id_user' => Auth::user()->id,
          'id_space' => $request->id_spaces,
          'reservation_datetime' => $datetime,
          'total_pax' => $request->total_pax,
          'total_payment' => $totalPayment,
          'payment_status' => -1,
          'discount' => 0,
          'special_notes' => $request->special_notes,
          'tax' => $tax,
          'bank_fee' => $bankFee,
          'reservation_code'=> $reservationCode,
        ];

        $request->request->add(['reservation_code' => $reservationCode]);

        $validation = $request->validate([
           'reservation_code' => 'unique:reservations',
        ],
        [
          'reservation_code.unique' => "Sorry, you already make reservation on this time. Please check your reservation by <a href='".route('reservation.list')."' style='color:#FFF'><u>Click here</u></a>"
      ]);
        try {
          //debug code
         //dd($request->toArray(),$dataReservasi,$totalPayment);

         //check reservasi Data
         $dateNow = Carbon::now()->format('Y-m-d H:i:s');
         // dd($dateNow);
         $reservasiData = Reservation::where('id_user',Auth::user()->id)->where('created_at','<=',$dateNow)->where('payment_status',"-1")->get();
         foreach($reservasiData as $resvMade){
           $resvMade->update([
             'payment_status' => -2,
           ]);
         }


             $reservasi = Reservation::create($dataReservasi);
             $reservasi->detailReservation()->attach($menuChoosen);
             // dd($errors);
           // dd($reservasi, $menuChoosen);
          $created = Carbon::createFromFormat('Y-m-d H:i:s', $reservasi->created_at);
          $expired = $created->addDays(1)->format('d M Y H:i:s');
          $timezone = $created->tzName;
          // dd($expired,$timezone);
             return redirect("panel/reservation/".$reservasi->reservation_code."/summary")
             ->with('success', '<u><b>Please complete your payment before '.$expired.' ('.$timezone.') or your reservation will automatically canceled');
        } catch (\Exception $ex) {
          // dd($ex->getMessage());
           return back()->with('failed', 'Error! ' . $ex->getMessage());
        }
        // dd(response()->json($request->toArray()));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        // $datetime = Carbon::createFromFormat('d-m-Y H:i', '12-10-2019 16:00');
        // dd($reservationOwner);

        $reservation = Reservation::where('reservation_code',$id)->first();
        //redirect user when they checking other people reservation        dd()
        if(Auth::user()->role == 1 ){
        if($reservation->id_user != Auth::user()->id )
           return redirect("panel/reservation/list");
         }

       $created = Carbon::createFromFormat('Y-m-d H:i:s', $reservation->created_at->format('Y-m-d H:i:s'));
       $expired = $created->addDays(1)->format('d M Y H:i:s');
       $timezone = $created->tzName;

       $ownPoints = Auth::user()->points->sum('points');

       $timeNow = Carbon::now()->subHour(24);
       // dd($timeNow);
       // dd($reservation->detailReservation);

       //get total payment
        $totalPay = 0;
        $basket = "";
        foreach($reservation->detailReservation as $menuChoose){
          $totalPay += ($menuChoose->price*$menuChoose->pivot->qty);
          $basket .= $menuChoose->name.",".($menuChoose->price).".00".",".$menuChoose->pivot->qty.",".(($menuChoose->price*$menuChoose->pivot->qty)).".00".";";
        }
        // dd($returnBasket);
        $tax = (10.8/100)*$totalPay;
        $service = (8/100)*$totalPay;
        $basket .= "Tax,".($tax).".00".",1".",".($tax).".00";
        $basket .= ";Service,".($service).".00".",1".",".($service).".00";

        $returnBasket = $basket;
        $calculation =[
          'subTotal'=>$totalPay,
          'tax'=>$tax,
          'service'=>$service,
          'total'=>($totalPay+$tax+$service),
        ];
        // dd($calculation);

        $userPoints = $ownPoints;
        $grandTotal = ($totalPay+$tax+$service)*0.5;
        $maxPoint = 0.5*($grandTotal);
        if($ownPoints >= $maxPoint)
        $userPoints = 0.5*(0.5*($totalPay+$tax+$service));

        return view('panel.reservation.summary')->with('reservation',$reservation)
        ->with('expired_date',$expired.' ('.$timezone.' GMT+8)')
        ->with('points',$userPoints)
        ->with('calculation',$calculation)
        ->with('basket',$returnBasket);
//         $timestamp = Carbon::createFromTimestamp('12-10-201'. $entry->Time);
// $dateTime=date('d/m/Y h:i:s',$timestamp);
// Carbon::parse($dateTime);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function step1Form(Request $request){

        //select reservation to get space available


        $spaces = Space::get();
        $datetime = Carbon::createFromFormat('m/d/Y H:i', $request->date . $request->time)->format('Y-m-d H:i:s');

        //get view for space avaibility
        $spacesUsed = DB::table('reservations')
                            ->select('reservations.id_space as id','spaces.*',DB::raw("COUNT(*) as booked"))
                            ->join('spaces','reservations.id_space','=','spaces.id')
                            ->where('reservations.reservation_datetime', $datetime)
                            ->where('spaces.status',1)
                            ->groupBy('reservations.id_space')
                            ->get();
        $spaceID = [];
        $space = null;
        foreach($spacesUsed as $used){
            if(($used->avaibility - $used->booked) != 0){
                $spaceID [] = $used->id;
            }
            // $spaceID [] = $used->avaibility - $space->booked;
        }

        if(empty($spaceID)){
            $space = Space::where('status',1)
            ->where('spaces.maximum_pax','>=',$request->pax)
            ->get();}
        else{
            $space = Space::whereIn('id',$spaceID)
            ->where('spaces.maximum_pax','>=',$request->pax)
            ->get();}


        return response()->json($space);

    }
    public function stepMenu(Request $request){
        $data = Menu::whereIn('id',$request->id_menu)->with('category')->get();

        return response()->json($data);
    }

    public function reviewOrder(Request $request){
      $data = $request->toArray();
      //get space name
      $space = Space::findOrFail($request->id_space);
      //get menu
      $menu = [];
      //loop for qty var
      $i = 0;
       foreach($request->id_menu as $id_menu){
         $findMenu = Menu::findOrFail($id_menu);
          $menu [$findMenu->name] = [
            "qty"=> $request->qty_menu[$i],
            "price"=> $findMenu->price,
            "category"=>$findMenu->category->name,
          ];
          $i++;
       }


      $response = [
        "date" => $request->date,
        "time" => $request->time,
        "pax" => $request->pax,
        "space" => $space->name,
        "menu" => $menu,
      ];
      return response()->json($response);
    }

    public function getWords(Request $request){
      $amount = $request->amount;
      $merchantID = $request->merchantID;
      $shareKey = $request->shareKey;
      $reservationCode = $request->reservationCode;

      $raw = $amount.$merchantID.$shareKey.$reservationCode;
      $encrypt = sha1($raw);
      return response()->json(sha1($raw));
    }

    public function beforePayment(Request $request){
      $id = $request->TRANSIDMERCHANT;
      $model = Reservation::where('reservation_code',$id)->first();
      $userPoints = Auth::user()->points->sum('points');
      $discount = $userPoints;
      if($request->usePoint && $discount>0){
        $model->update([
          'discount'=>$discount,
        ]);
        $points = Point_log::create([
          'id_user'=> $model->id_user,
          'points' => "-".$discount,
          'desc' => "Point used for payment reservation ".$model->reservation_code,
        ]);

    }


      return view('panel.reservation.beforepayment')->with('data',$request);
    }

//use this when not using payment gateway
public function notifyNoPayment(Request $request){

                  $id = $request->TRANSIDMERCHANT;
                  $model = Reservation::where('reservation_code',$id)->first();
                  //prepare data to update the reservation record

                  $model->update(['payment_status'=>0]);
                  //challange that done by user
                  if($model->payment_status == 0){
                  $challangeDone = Challange_log::where('id_user',$model->id_user)->get();
                  $doneList = [];
                  foreach($challangeDone as $challangeComp){
                    $doneList [] = $challangeComp->id_challange;
                  }

                  //challange list
                  $challange = Challange::where('reservation_status',0)->where('status',1)->get();
                  $triggerList = [];
                  foreach($challange as $cl){
                    if($cl->is_multiple == 0){
                      if(!in_array($cl->id,$doneList)){
                        $triggerList [] = $cl->id;
                      }
                    }else{
                      $triggerList [] = $cl->id;
                    }
                  }

                  $challangeAvailable = Challange::whereIn('id',$triggerList)->where('status',1)->get();
                  // dd($triggerList);
                  foreach($challangeAvailable as $ca){
                    if($ca->type=="RESERVATION"){
                    $reservationMade = User::findOrFail($model->id_user)->reservation->where('payment_status',">=",0)->count();
                      if($ca->min_transaction <= ($model->total_payment+$model->tax)){
                        if($ca->reservation_required <= $reservationMade){
                          //insert to challange log so user marked for done this challange
                          $checkDone = Challange_log::where('id_challange',$ca->id)->where('id_user',$model->id_user)->first();
                          if(is_null($checkDone)){
                          Challange_log::create([
                            'id_challange'=>$ca->id,
                            'id_user'=>$model->id_user,
                            'notification_status'=>0,
                          ]);
                        }else{
                          $timeDone = $checkDone->times_done+1;
                          $checkDone->update(['times_done'=>$timeDone]);
                        }

                          //insert reward badge for user if get badge
                          if($ca->reward->id_badge){
                            $checkBadge = Badge_log::where('id_badge',$ca->reward->id_badge)->where('id_user',$model->id_user)->first();
                            if(is_null($checkBadge)){
                              Badge_log::create([
                              'id_user'=>$model->id_user,
                              'id_badge'=>$ca->reward->id_badge,
                              'description'=>"Badage Unlock from Reservation ".$model->reservation_code,
                            ]);
                          }
                           }
                          //insert point from reward
                          if($ca->reward->point){
                            $point = 0;
                            if($ca->reward->point_type == "FLAT"){
                              $point = $ca->reward->point;
                            }
                            else{
                              $point = ($ca->reward->point/100)*($model->total_payment+$model->tax);
                              if($point >= $ca->reward->max_point)
                                $point = $ca->reward->max_point;
                            }
                            Point_log::create([
                              'id_user'=>$model->id_user,
                              'points'=>$point,
                              'desc'=>"reward for reservation ".$model->reservation_code,
                            ]);
                          }

                        }
                      }
                    }

                    //another type
                      if($ca->type=="SPECIALDAY"){
                      $reservationMade = User::findOrFail($model->id_user)->reservation->where('payment_status',">=",0)->count();
                      // echo Carbon::parse($ca->reservation_date)->format('d-M-Y') ."{}". Carbon::now()->format('d-M-Y');
                        if($ca->min_transaction <= ($model->total_payment+$model->tax)){
                          if(Carbon::parse($ca->reservation_date)->format('d-M-Y') == Carbon::parse($model->reservation_datetime)->format('d-M-Y')){

                            //insert to challange log so user marked for done this challange
                            $checkDone = Challange_log::where('id_challange',$ca->id)->where('id_user',$model->id_user)->first();
                            if(is_null($checkDone)){
                            Challange_log::create([
                              'id_challange'=>$ca->id,
                              'id_user'=>$model->id_user,
                              'notification_status'=>0,
                            ]);
                          }else{
                            $timeDone = $checkDone->times_done+1;
                            $checkDone->update(['times_done'=>$timeDone]);
                          }

                            //insert reward badge for user if get badge
                            if($ca->reward->id_badge){
                              $checkBadge = Badge_log::where('id_badge',$ca->reward->id_badge)->where('id_user',$model->id_user)->first();
                              if(is_null($checkBadge)){
                              Badge_log::create([
                                'id_user'=>$model->id_user,
                                'id_badge'=>$ca->reward->id_badge,
                                'description'=>"Badage Unlock from Reservation ".$model->reservation_code,
                              ]);
                            }
                            }
                            //insert point from reward
                            if($ca->reward->point){
                              $point = 0;
                              if($ca->reward->point_type == "FLAT"){
                                $point = $ca->reward->point;
                              }
                              else{
                                $point = ($ca->reward->point/100)*($model->total_payment+$model->tax);
                                if($point >= $ca->reward->max_point)
                                  $point = $ca->reward->max_point;
                              }
                              Point_log::create([
                                'id_user'=>$model->id_user,
                                'points'=>$point,
                                'desc'=>"reward for reservation ".$model->reservation_code,
                              ]);
                            }

                          }
                        }
                      }

                      if($ca->type=="TOTALSPEND"){
                      $reservationMade = User::findOrFail($model->id_user)->reservation->where('payment_status',">=",0)->count();
                      // echo Carbon::parse($ca->reservation_date)->format('d-M-Y') ."{}". Carbon::now()->format('d-M-Y');
                        if($ca->min_transaction <= ($model->total_payment+$model->tax)){
                          $totalSpend =0;
                          if($ca->is_multiple_reservation == 0)
                          $totalSpend = ($model->total_payment + $model->tax);
                          else
                          $totalSpend = (User::findOrFail($model->id_user)->reservation->sum('total_payment'))+(User::findOrFail($model->id_user)->reservation->sum('tax'));

                          // dd((User::findOrFail($model->id_user)->reservation->sum('total_payment'))+(User::findOrFail($model->id_user)->reservation->sum('tax')));
                          if($ca->total_spend <= $totalSpend){

                            //insert to challange log so user marked for done this challange
                            $checkDone = Challange_log::where('id_challange',$ca->id)->where('id_user',$model->id_user)->first();
                            if(is_null($checkDone)){
                            Challange_log::create([
                              'id_challange'=>$ca->id,
                              'id_user'=>$model->id_user,
                              'notification_status'=>0,
                            ]);
                          }else{
                            $timeDone = $checkDone->times_done+1;
                            $checkDone->update(['times_done'=>$timeDone]);
                          }

                            //insert reward badge for user if get badge
                            if($ca->reward->id_badge){
                              $checkBadge = Badge_log::where('id_badge',$ca->reward->id_badge)->where('id_user',$model->id_user)->first();
                              if(is_null($checkBadge)){
                              Badge_log::create([
                                'id_user'=>$model->id_user,
                                'id_badge'=>$ca->reward->id_badge,
                                'description'=>"Badage Unlock from Reservation ".$model->reservation_code,
                              ]);
                            }
                            }
                            //insert point from reward
                            if($ca->reward->point){
                              $point = 0;
                              if($ca->reward->point_type == "FLAT"){
                                $point = $ca->reward->point;
                              }
                              else{
                                $point = ($ca->reward->point/100)*($model->total_payment+$model->tax);
                                if($point >= $ca->reward->max_point)
                                  $point = $ca->reward->max_point;
                              }
                              Point_log::create([
                                'id_user'=>$model->id_user,
                                'points'=>$point,
                                'desc'=>"reward for reservation ".$model->reservation_code,
                              ]);
                            }

                          }
                        }
                      }
                  }
                }

                   return redirect("panel/reservation/".$request->TRANSIDMERCHANT."/summary");
          }

    public function notify(Request $request){

      if(!$request->TRANSIDMERCHANT)
        return "You dont have access to this page";

        if($request->RESPONSECODE == 0000){ //disable this if remove the payment


                $id = $request->TRANSIDMERCHANT;
                $model = Reservation::where('reservation_code',$id)->first();

                //add to detail_payment
                Detail_payment::create([
                  'id_reservation'=> $model->id,
                  'brand'=> $request->BRAND,
                ]);

                //prepare data to update the reservation record

                $model->update(['payment_status'=>0]);
                //challange that done by user
                if($model->payment_status == 0){
                $challangeDone = Challange_log::where('id_user',$model->id_user)->get();
                $doneList = [];
                foreach($challangeDone as $challangeComp){
                  $doneList [] = $challangeComp->id_challange;
                }

                //challange list
                $challange = Challange::where('reservation_status',0)->where('status',1)->get();
                $triggerList = [];
                foreach($challange as $cl){
                  if($cl->is_multiple == 0){
                    if(!in_array($cl->id,$doneList)){
                      $triggerList [] = $cl->id;
                    }
                  }else{
                    $triggerList [] = $cl->id;
                  }
                }

                $challangeAvailable = Challange::whereIn('id',$triggerList)->where('status',1)->get();
                // dd($triggerList);
                foreach($challangeAvailable as $ca){
                  if($ca->type=="RESERVATION"){
                  $reservationMade = User::findOrFail($model->id_user)->reservation->where('payment_status',">=",0)->count();
                    if($ca->min_transaction <= ($model->total_payment+$model->tax)){
                      if($ca->reservation_required <= $reservationMade){
                        //insert to challange log so user marked for done this challange
                        $checkDone = Challange_log::where('id_challange',$ca->id)->where('id_user',$model->id_user)->first();
                        if(is_null($checkDone)){
                        Challange_log::create([
                          'id_challange'=>$ca->id,
                          'id_user'=>$model->id_user,
                          'notification_status'=>0,
                        ]);
                      }else{
                        $timeDone = $checkDone->times_done+1;
                        $checkDone->update(['times_done'=>$timeDone]);
                      }

                        //insert reward badge for user if get badge
                        if($ca->reward->id_badge){
                          $checkBadge = Badge_log::where('id_badge',$ca->reward->id_badge)->where('id_user',$model->id_user)->first();
                          if(is_null($checkBadge)){
                            Badge_log::create([
                            'id_user'=>$model->id_user,
                            'id_badge'=>$ca->reward->id_badge,
                            'description'=>"Badage Unlock from Reservation ".$model->reservation_code,
                          ]);
                        }
                         }
                        //insert point from reward
                        if($ca->reward->point){
                          $point = 0;
                          if($ca->reward->point_type == "FLAT"){
                            $point = $ca->reward->point;
                          }
                          else{
                            $point = ($ca->reward->point/100)*($model->total_payment+$model->tax);
                            if($point >= $ca->reward->max_point)
                              $point = $ca->reward->max_point;
                          }
                          Point_log::create([
                            'id_user'=>$model->id_user,
                            'points'=>$point,
                            'desc'=>"reward for reservation ".$model->reservation_code,
                          ]);
                        }

                      }
                    }
                  }

                  //another type
                    if($ca->type=="SPECIALDAY"){
                    $reservationMade = User::findOrFail($model->id_user)->reservation->where('payment_status',">=",0)->count();
                    // echo Carbon::parse($ca->reservation_date)->format('d-M-Y') ."{}". Carbon::now()->format('d-M-Y');
                      if($ca->min_transaction <= ($model->total_payment+$model->tax)){
                        if(Carbon::parse($ca->reservation_date)->format('d-M-Y') == Carbon::parse($model->reservation_datetime)->format('d-M-Y')){

                          //insert to challange log so user marked for done this challange
                          $checkDone = Challange_log::where('id_challange',$ca->id)->where('id_user',$model->id_user)->first();
                          if(is_null($checkDone)){
                          Challange_log::create([
                            'id_challange'=>$ca->id,
                            'id_user'=>$model->id_user,
                            'notification_status'=>0,
                          ]);
                        }else{
                          $timeDone = $checkDone->times_done+1;
                          $checkDone->update(['times_done'=>$timeDone]);
                        }

                          //insert reward badge for user if get badge
                          if($ca->reward->id_badge){
                            $checkBadge = Badge_log::where('id_badge',$ca->reward->id_badge)->where('id_user',$model->id_user)->first();
                            if(is_null($checkBadge)){
                            Badge_log::create([
                              'id_user'=>$model->id_user,
                              'id_badge'=>$ca->reward->id_badge,
                              'description'=>"Badage Unlock from Reservation ".$model->reservation_code,
                            ]);
                          }
                          }
                          //insert point from reward
                          if($ca->reward->point){
                            $point = 0;
                            if($ca->reward->point_type == "FLAT"){
                              $point = $ca->reward->point;
                            }
                            else{
                              $point = ($ca->reward->point/100)*($model->total_payment+$model->tax);
                              if($point >= $ca->reward->max_point)
                                $point = $ca->reward->max_point;
                            }
                            Point_log::create([
                              'id_user'=>$model->id_user,
                              'points'=>$point,
                              'desc'=>"reward for reservation ".$model->reservation_code,
                            ]);
                          }

                        }
                      }
                    }

                    if($ca->type=="TOTALSPEND"){
                    $reservationMade = User::findOrFail($model->id_user)->reservation->where('payment_status',">=",0)->count();
                    // echo Carbon::parse($ca->reservation_date)->format('d-M-Y') ."{}". Carbon::now()->format('d-M-Y');
                      if($ca->min_transaction <= ($model->total_payment+$model->tax)){
                        $totalSpend =0;
                        if($ca->is_multiple_reservation == 0)
                        $totalSpend = ($model->total_payment + $model->tax);
                        else
                        $totalSpend = (User::findOrFail($model->id_user)->reservation->sum('total_payment'))+(User::findOrFail($model->id_user)->reservation->sum('tax'));

                        // dd((User::findOrFail($model->id_user)->reservation->sum('total_payment'))+(User::findOrFail($model->id_user)->reservation->sum('tax')));
                        if($ca->total_spend <= $totalSpend){

                          //insert to challange log so user marked for done this challange
                          $checkDone = Challange_log::where('id_challange',$ca->id)->where('id_user',$model->id_user)->first();
                          if(is_null($checkDone)){
                          Challange_log::create([
                            'id_challange'=>$ca->id,
                            'id_user'=>$model->id_user,
                            'notification_status'=>0,
                          ]);
                        }else{
                          $timeDone = $checkDone->times_done+1;
                          $checkDone->update(['times_done'=>$timeDone]);
                        }

                          //insert reward badge for user if get badge
                          if($ca->reward->id_badge){
                            $checkBadge = Badge_log::where('id_badge',$ca->reward->id_badge)->where('id_user',$model->id_user)->first();
                            if(is_null($checkBadge)){
                            Badge_log::create([
                              'id_user'=>$model->id_user,
                              'id_badge'=>$ca->reward->id_badge,
                              'description'=>"Badage Unlock from Reservation ".$model->reservation_code,
                            ]);
                          }
                          }
                          //insert point from reward
                          if($ca->reward->point){
                            $point = 0;
                            if($ca->reward->point_type == "FLAT"){
                              $point = $ca->reward->point;
                            }
                            else{
                              $point = ($ca->reward->point/100)*($model->total_payment+$model->tax);
                              if($point >= $ca->reward->max_point)
                                $point = $ca->reward->max_point;
                            }
                            Point_log::create([
                              'id_user'=>$model->id_user,
                              'points'=>$point,
                              'desc'=>"reward for reservation ".$model->reservation_code,
                            ]);
                          }

                        }
                      }
                    }
                }
              }
        }//disable this if want remove payment

    echo "CONTINUE"; //disable this if want remove payment

    //enable return below when remove payment
       // return redirect("panel/reservation/".$request->TRANSIDMERCHANT."/summary");

      // dd($request->toArray(),$model->toArray());
    }
    public function extendPayment($id){
      $model = Reservation::where('reservation_code',$id)->first();
      $model->update([
        'created_at'=>Carbon::now()->format('Y-m-d H:i:s'),
      ]);

      return Redirect::back()
      ->with('success', '<u><b>Please complete your payment before '.$expired.' ('.$timezone.') or your reservation will automatically canceled');
    }

    public function reservationComplete(Request $request){
      $id = $request->TRANSIDMERCHANT;
      $model = Reservation::where('reservation_code',$id)->first();
      //prepare data to update the reservation record

      $model->update(['payment_status'=>2]);
      //challange that done by user
      if($model->payment_status == 2){
      $challangeDone = Challange_log::where('id_user',$model->id_user)->get();
      $doneList = [];
      foreach($challangeDone as $challangeComp){
        $doneList [] = $challangeComp->id_challange;
      }

      //challange list
      $challange = Challange::where('reservation_status',2)->where('status',1)->get();
      $triggerList = [];
      foreach($challange as $cl){
        if($cl->is_multiple == 0){
          if(!in_array($cl->id,$doneList)){
            $triggerList [] = $cl->id;
          }
        }else{
          $triggerList [] = $cl->id;
        }
      }

      $challangeAvailable = Challange::whereIn('id',$triggerList)->where('status',1)->get();
      // dd($triggerList);
      foreach($challangeAvailable as $ca){
        if($ca->type=="RESERVATION"){
        $reservationMade = User::findOrFail($model->id_user)->reservation->where('payment_status',">=",0)->count();
          if($ca->min_transaction <= ($model->total_payment+$model->tax)){
            if($ca->reservation_required <= $reservationMade){
              //insert to challange log so user marked for done this challange
              $checkDone = Challange_log::where('id_challange',$ca->id)->where('id_user',$model->id_user)->first();
              if(is_null($checkDone)){
              Challange_log::create([
                'id_challange'=>$ca->id,
                'id_user'=>$model->id_user,
                'notification_status'=>0,
              ]);
            }else{
              $timeDone = $checkDone->times_done+1;
              $checkDone->update(['times_done'=>$timeDone]);
            }

              //insert reward badge for user if get badge
              if($ca->reward->id_badge){
                $checkBadge = Badge_log::where('id_badge',$ca->reward->id_badge)->where('id_user',$model->id_user)->first();
                if(is_null($checkBadge)){
                  Badge_log::create([
                  'id_user'=>$model->id_user,
                  'id_badge'=>$ca->reward->id_badge,
                  'description'=>"Badage Unlock from Reservation ".$model->reservation_code,
                ]);
              }
               }
              //insert point from reward
              if($ca->reward->point){
                $point = 0;
                if($ca->reward->point_type == "FLAT"){
                  $point = $ca->reward->point;
                }
                else{
                  $point = ($ca->reward->point/100)*($model->total_payment+$model->tax);
                  if($point >= $ca->reward->max_point)
                    $point = $ca->reward->max_point;
                }
                Point_log::create([
                  'id_user'=>$model->id_user,
                  'points'=>$point,
                  'desc'=>"reward for reservation ".$model->reservation_code,
                ]);
              }

            }
          }
        }

        //another type
          if($ca->type=="SPECIALDAY"){
          $reservationMade = User::findOrFail($model->id_user)->reservation->where('payment_status',">=",0)->count();
          // echo Carbon::parse($ca->reservation_date)->format('d-M-Y') ."{}". Carbon::now()->format('d-M-Y');
            if($ca->min_transaction <= ($model->total_payment+$model->tax)){
              if(Carbon::parse($ca->reservation_date)->format('d-M-Y') == Carbon::parse($model->reservation_datetime)->format('d-M-Y')){

                //insert to challange log so user marked for done this challange
                $checkDone = Challange_log::where('id_challange',$ca->id)->where('id_user',$model->id_user)->first();
                if(is_null($checkDone)){
                Challange_log::create([
                  'id_challange'=>$ca->id,
                  'id_user'=>$model->id_user,
                  'notification_status'=>0,
                ]);
              }else{
                $timeDone = $checkDone->times_done+1;
                $checkDone->update(['times_done'=>$timeDone]);
              }

                //insert reward badge for user if get badge
                if($ca->reward->id_badge){
                  $checkBadge = Badge_log::where('id_badge',$ca->reward->id_badge)->where('id_user',$model->id_user)->first();
                  if(is_null($checkBadge)){
                  Badge_log::create([
                    'id_user'=>$model->id_user,
                    'id_badge'=>$ca->reward->id_badge,
                    'description'=>"Badage Unlock from Reservation ".$model->reservation_code,
                  ]);
                }
                }
                //insert point from reward
                if($ca->reward->point){
                  $point = 0;
                  if($ca->reward->point_type == "FLAT"){
                    $point = $ca->reward->point;
                  }
                  else{
                    $point = ($ca->reward->point/100)*($model->total_payment+$model->tax);
                    if($point >= $ca->reward->max_point)
                      $point = $ca->reward->max_point;
                  }
                  Point_log::create([
                    'id_user'=>$model->id_user,
                    'points'=>$point,
                    'desc'=>"reward for reservation ".$model->reservation_code,
                  ]);
                }

              }
            }
          }

          if($ca->type=="TOTALSPEND"){
          $reservationMade = User::findOrFail($model->id_user)->reservation->where('payment_status',">=",0)->count();
          // echo Carbon::parse($ca->reservation_date)->format('d-M-Y') ."{}". Carbon::now()->format('d-M-Y');
            if($ca->min_transaction <= ($model->total_payment+$model->tax)){
              $totalSpend =0;
              if($ca->is_multiple_reservation == 0)
              $totalSpend = ($model->total_payment + $model->tax);
              else
              $totalSpend = (User::findOrFail($model->id_user)->reservation->sum('total_payment'))+(User::findOrFail($model->id_user)->reservation->sum('tax'));

              // dd((User::findOrFail($model->id_user)->reservation->sum('total_payment'))+(User::findOrFail($model->id_user)->reservation->sum('tax')));
              if($ca->total_spend <= $totalSpend){

                //insert to challange log so user marked for done this challange
                $checkDone = Challange_log::where('id_challange',$ca->id)->where('id_user',$model->id_user)->first();
                if(is_null($checkDone)){
                Challange_log::create([
                  'id_challange'=>$ca->id,
                  'id_user'=>$model->id_user,
                  'notification_status'=>0,
                ]);
              }else{
                $timeDone = $checkDone->times_done+1;
                $checkDone->update(['times_done'=>$timeDone]);
              }

                //insert reward badge for user if get badge
                if($ca->reward->id_badge){
                  $checkBadge = Badge_log::where('id_badge',$ca->reward->id_badge)->where('id_user',$model->id_user)->first();
                  if(is_null($checkBadge)){
                  Badge_log::create([
                    'id_user'=>$model->id_user,
                    'id_badge'=>$ca->reward->id_badge,
                    'description'=>"Badage Unlock from Reservation ".$model->reservation_code,
                  ]);
                }
                }
                //insert point from reward
                if($ca->reward->point){
                  $point = 0;
                  if($ca->reward->point_type == "FLAT"){
                    $point = $ca->reward->point;
                  }
                  else{
                    $point = ($ca->reward->point/100)*($model->total_payment+$model->tax);
                    if($point >= $ca->reward->max_point)
                      $point = $ca->reward->max_point;
                  }
                  Point_log::create([
                    'id_user'=>$model->id_user,
                    'points'=>$point,
                    'desc'=>"reward for reservation ".$model->reservation_code,
                  ]);
                }

              }
            }
          }
      }
    }
    return redirect('/panel/reservation');
    }

    public function run($id){
      $reservation = Reservation::findOrFail($id);
      $reservation->update(['payment_status'=>1]);
      return redirect('/panel/reservation')->with('success','Reservation '.$reservation->reservation_code.' Success updated to not show on time');
    }

    public function report(){
      $this->authorize('menu.admin');
              $category = MenuCategory::get();
              return view('panel.reports.reservation')->with('category',$category);
    }

    public function reportGenerate(Request $request){
      $this->authorize('menu.admin');
      $request->validate([
        'start_date'    => 'required|date',
        'end_date'      => 'required|date|after_or_equal:start_date',
      ]);

      $date = [
        'start'=>$request->start_date,
        'end'=>$request->end_date
      ];

      $reservationStatus = "All";
      if($request->status != null)
      $reservationStatus = $request->status;
      // dd($request->all());


        $data = DB::table('reservations')
        ->select('reservations.reservation_code','users.name','reservations.payment_status',
        'reservations.reservation_datetime','reservations.total_payment',
        'reservations.tax','reservations.bank_fee')
        ->join('users','users.id','=','reservations.id_user')
        ->whereDate('reservation_datetime','>=',Carbon::parse($date['start'])->format('Y-m-d'))
        ->whereDate('reservation_datetime','<=',Carbon::parse($date['end'])->format('Y-m-d'))
        ->when($request->status !== null, function($query) use ($request) {
            return $query->where('reservations.payment_status', '=', $request->status);
          })
        ->get();
        $totalRevenue = 0;
        $totalTs = 0;
        $totalBank = 0;

        $totals = [
          'totalRevenue' => $totalRevenue,
          'totalTs' => $totalTs,
          'totalBank' => $totalBank,
          'reservationStatus' => $reservationStatus
        ];

        // dd($data);
          // return view('panel.reports.reservations_list',['data'=>$data,'date'=>$date,'totals'=>$totals]);
      $pdf = PDF::loadview('panel.reports.reservations_list',['data'=>$data,'date'=>$date,'totals'=>$totals])->setPaper('a4','landscape')->setWarnings(false);
      return $pdf->stream('reservation-report_'.Carbon::now()->format('d_m_Y_His'));
    }

    public function DPreportGenerate(Request $request){

      $request->validate([
        'start_date'    => 'required|date',
        'end_date'      => 'required|date|after_or_equal:start_date',
      ]);

      $date = [
        'start'=>$request->start_date,
        'end'=>$request->end_date
      ];

      $reservationStatus = "All";
      if($request->status != null)
      $reservationStatus = $request->status;

      $data = DB::table('reservations')
      ->select('reservations.reservation_code','users.name','reservations.payment_status',
      'reservations.reservation_datetime','reservations.total_payment',
      'reservations.tax','reservations.bank_fee','detail_payments.created_at as payment_date','detail_payments.brand')
      ->join('users','users.id','=','reservations.id_user')->join('detail_payments','reservations.id','=','detail_payments.id_reservation')
      ->whereDate('detail_payments.created_at','>=',Carbon::parse($date['start'])->format('Y-m-d'))
      ->whereDate('detail_payments.created_at','<=',Carbon::parse($date['end'])->format('Y-m-d'))
      ->when($request->status !== null, function($query) use ($request) {
          return $query->where('detail_payments.brand', '=', $request->status);
        })
      ->get();

      $totals = [
        'reservationStatus' => $reservationStatus
      ];

      $pdf = PDF::loadview('panel.reports.reservations_downpayment_list',['data'=>$data,'date'=>$date,'totals'=>$totals])->setPaper('a4','landscape')->setWarnings(false);
      return $pdf->stream('reservation-report_'.Carbon::now()->format('d_m_Y_His'));
    }
}
