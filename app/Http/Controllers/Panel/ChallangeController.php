<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Challange;
use App\Reward;
use Auth;
use Carbon\Carbon;
use DB;
use App\Challange_log;

class ChallangeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Challange::orderBy('id','desc')->paginate(10);
        return view('panel.challange')->with('data',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data = new Challange();
        $reward = Reward::where('status',1)->get();
        return view('panel.form.challange')->with('data',$data)
        ->with('reward',$reward);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data ="";
        $min_transaction = NULL;
            $reservation_required = null;
            $reservation_date = null;
            $is_multiple_reservation = null;
            $total_spend = null;

        if($request->type == "RESERVATION"){
            $validation = $request->validate([
                'id_reward'=> 'required|numeric',
                'reservation_required' => 'required|numeric',
                'reservation_status' => 'required|numeric'
            ],
            [
                'id_reward.required'=>"You have to choose the reward"
            ]);
            $min_transaction = 0;
            $reservation_required = $request->reservation_required;
            $reservation_date = NULL;
            $is_multiple_reservation = 0;
            $total_spend = 0;
        }else if($request->type == "SPECIALDAY"){
            $validation = $request->validate([
                'id_reward'=> 'required|numeric',
                'min_transaction' => 'required|numeric',
                'reservation_date' => 'required|date',
                'reservation_status' => 'required|numeric'
            ],
            [
                'id_reward.required'=>"You have to choose the reward",
                'reservation_date.required'=> "You have to choose the date"
            ]);
            $min_transaction = $request->min_transaction;
            $reservation_required = 1;
            $reservation_date = Carbon::parse($request->reservation_date)->format('Y/m/d');
            $is_multiple_reservation = 0;
            $total_spend = 0;
        }else if($request->type="TOTALSPEND"){
            $validation = $request->validate([
                'id_reward'=> 'required|numeric',
                'total_spend' => 'required|numeric|min:1',
                'is_multiple_reservation' => 'required|numeric',
                'reservation_status' => 'required|numeric'
            ],
            [
                'id_reward.required'=>"You have to choose the reward",
                'is_multiple_reservation.required'=> "You have to choose the date"
            ]);
            $min_transaction = 0;
            $reservation_required = 0;
            $reservation_date = null;
            $is_multiple_reservation = $request->is_multiple_reservation;
            $total_spend = $request->total_spend;
        }

        if($request->is_multiple)
            $isMultiple = 1;
        else
            $isMultiple = 0;

        $data = [
            'id_reward'=>$request->id_reward,
            'is_multiple'=>$isMultiple,
            'type'=>$request->type,
            'min_transaction'=>$min_transaction,
            'reservation_date'=> $reservation_date,
            'reservation_required'=>$reservation_required,
            'status'=>$request->status,
            'is_multiple_reservation'=>$is_multiple_reservation,
            'total_spend'=> $total_spend,
            'reservation_status'=>$request->reservation_status,
            'id_user'=>Auth::user()->id,
        ];

        try {
            Challange::create($data);
            return back()->with('success', 'Challange Successfully added');
        } catch (\Exception $ex) {
            // dd($ex->getMessage());
            return back()->with('failed', 'Error! ' . $ex->getMessage());
        }
        // dd($request->toArray());
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
            //
            $data = Challange::findOrFail($id);
            $reward = Reward::get();
            return view('panel.form.challange_edit')->with('data',$data)
            ->with('reward',$reward);
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
          $model = Challange::findOrFail($id);
          $data ="";
          $min_transaction = NULL;
              $reservation_required = null;
              $reservation_date = null;
              $is_multiple_reservation = null;
              $total_spend = null;

          if($request->type == "RESERVATION"){
              $validation = $request->validate([
                  'id_reward'=> 'required|numeric',
                  'reservation_required' => 'required|numeric',
                  'reservation_status' => 'required|numeric'
              ],
              [
                  'id_reward.required'=>"You have to choose the reward"
              ]);
              $min_transaction = 0;
              $reservation_required = $request->reservation_required;
              $reservation_date = NULL;
              $is_multiple_reservation = 0;
              $total_spend = 0;
          }else if($request->type == "SPECIALDAY"){
              $validation = $request->validate([
                  'id_reward'=> 'required|numeric',
                  'min_transaction' => 'required|numeric',
                  'reservation_date' => 'required|date',
                  'reservation_status' => 'required|numeric'
              ],
              [
                  'id_reward.required'=>"You have to choose the reward",
                  'reservation_date.required'=> "You have to choose the date"
              ]);
              $min_transaction = $request->min_transaction;
              $reservation_required = 1;
              $reservation_date = Carbon::parse($request->reservation_date)->format('Y/m/d');
              $is_multiple_reservation = 0;
              $total_spend = 0;
          }else if($request->type="TOTALSPEND"){
              $validation = $request->validate([
                  'id_reward'=> 'required|numeric',
                  'total_spend' => 'required|numeric|min:1',
                  'is_multiple_reservation' => 'required|numeric',
                  'reservation_status' => 'required|numeric'
              ],
              [
                  'id_reward.required'=>"You have to choose the reward",
                  'is_multiple_reservation.required'=> "You have to choose the date"
              ]);
              $min_transaction = 0;
              $reservation_required = 0;
              $reservation_date = null;
              $is_multiple_reservation = $request->is_multiple_reservation;
              $total_spend = $request->total_spend;
          }

          if($request->is_multiple)
              $isMultiple = 1;
          else
              $isMultiple = 0;

          $data = [
              'id_reward'=>$request->id_reward,
              'is_multiple'=>$isMultiple,
              'type'=>$request->type,
              'min_transaction'=>$min_transaction,
              'reservation_date'=> $reservation_date,
              'reservation_required'=>$reservation_required,
              'status'=>$request->status,
              'is_multiple_reservation'=>$is_multiple_reservation,
              'total_spend'=> $total_spend,
              'reservation_status'=>$request->reservation_status,
              'id_user'=>Auth::user()->id,
          ];

          try {
              $model->update($data);
              return back()->with('success', 'Challange Successfully updated');
          } catch (\Exception $ex) {
              // dd($ex->getMessage());
              return back()->with('failed', 'Error! ' . $ex->getMessage());
          }
          // dd($request->toArray());
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
    public function challangeList(){
      $done = DB::table('challange_logs')->select('challanges.id','is_multiple')->
            join('challanges','challange_logs.id_challange','=','challanges.id')->where('challange_logs.id_user',Auth::user()->id)->get();
      $idDone = [];
      foreach($done as $d){
        if(!$d->is_multiple)
        $idDone [] = $d->id;

      }
      // dd($idDone);

      $data = DB::table('challanges')->select('challanges.*','badges.name','badges.image','rewards.point','rewards.max_point','rewards.point_type')->join('rewards','rewards.id','=','challanges.id_reward')
      ->leftJoin('badges','badges.id','=','rewards.id_badge')->whereNotIn('challanges.id',$idDone)->get();
      // dd($data);
      return view('panel.challange.list')->with('data',$data);
    }
}
