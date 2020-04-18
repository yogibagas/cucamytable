<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Badge;
use App\Badge_log;
use App\Point_log;
use Auth;
use DB;

class BadgeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Badge::orderBy('id','desc')->paginate(10);
        return view('panel.badge')
        ->with('data',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function myList(){
     $data = Badge::orderBy('id','desc')->get();
     $collection = Badge_log::where('id_user',Auth::user()->id)->get();
     $updateStatus = DB::table('badge_logs')->where('id_user',Auth::user()->id)->update(['status'=>1]);

     $collectionList = [];
     foreach($collection as $c){
       $collectionList [] = $c->id_badge;
     }

     $myBadge = Badge::whereIn('id',$collectionList)->get();
     // dd($collectionList);

       return view('panel.badge.list')->with('list',$data)->with('collection',$myBadge)->with('collectionList',$collectionList);
     }
    public function create()
    {
        //
        $model = new Badge();
        return view('panel.form.badge')->with('data',$model);
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
        $validation = $request->validate([
            'name' => 'required|string|max:125',
            'badge_image' => 'required|image|mimes:png|max:1024',
        ],
      [
        'badge_image' => "Badge image still empty",
      ]);

        if($request->badge_image != null){
            $filename = pathinfo($request->badge_image->getClientOriginalName(), PATHINFO_FILENAME);
            $imageName = $filename . '-' . time() . '.' . $request->badge_image->extension();
        }else{
            $imageName = "";
        }

        try {
            $request->badge_image->move(public_path('images/badges'), $imageName);
            $data = [
                'name' => $request->name,
                'image'=> $imageName,
                'status' => $request->status,
                'id_user'=> Auth::user()->id,
            ];
            Badge::create($data);

            return back()
                ->with('success', 'You have successfully add the new badge.');
        } catch(\Exception $ex) {
            return back()->with('failed', 'Error! ' . $ex->getMessage());
        }
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
        $model = Badge::findOrFail($id);
        return view('panel.form.badge')->with('data',$model);
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
        $model = Badge::findOrFail($id);
        $validation = $request->validate([
            'name' => 'required|string|max:125',
            'badge_image' => 'nullable|image|mimes:png|max:1024',
        ],
      [
        'badge_image' => "Badge image still empty",
      ]);

        if($request->badge_image != null){
            $filename = pathinfo($request->badge_image->getClientOriginalName(), PATHINFO_FILENAME);
            $imageName = $filename . '-' . time() . '.' . $request->badge_image->extension();
            $request->badge_image->move(public_path('images/badges'), $imageName);
        }else{
            $imageName = $model->image;
        }

        try {
            $data = [
                'name' => $request->name,
                'image'=> $imageName,
                'status' => $request->status,
            ];
            $model->update($data);

            return back()
                ->with('success', 'You have successfully update the badge.');
        } catch(\Exception $ex) {
            return back()->with('failed', 'Error! ' . $ex->getMessage());
        }
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

    public function pointLog(){
      $pointLog = Point_log::where('id_user',Auth::user()->id)->orderBy('created_at','desc')->paginate(10);
      if(Auth::user()->role == 0 )
      $pointLog = Point_log::orderBy('created_at','desc')->paginate(10);

      return view('panel.pointlog')->with('point',$pointLog);

    }

    public function leaderboards(){
      $badgeCollector = DB::table('badge_logs')
                 ->select('id_user', DB::raw('count(*) as total'),'users.name')
                 ->join('users','badge_logs.id_user','=','users.id')
                 ->groupBy('badge_logs.id_user')
                 ->orderBy('total','desc')->limit(10)
                 ->get();
      $mostReservator = DB::table('reservations')
                 ->select('id_user', DB::raw('count(*) as total'),'users.name')
                 ->join('users','reservations.id_user','=','users.id')
                 ->where('reservations.payment_status','>=','0')
                 ->groupBy('id_user')
                 ->orderBy('total','desc')->limit(10)
                 ->get();
      $highestPoint = DB::table('point_logs')
                 ->select('id_user', DB::raw('sum(points) as total'),'users.name')
                 ->join('users','point_logs.id_user','=','users.id')
                 ->groupBy('id_user')
                 ->orderBy('total','desc')->limit(10)
                 ->get();

      $mostSpend = DB::table('reservations')
                 ->select('id_user', DB::raw('sum(total_payment) as total'),'users.name')
                 ->join('users','reservations.id_user','=','users.id')
                 ->where('reservations.payment_status','>=','0')
                 ->groupBy('id_user')
                 ->orderBy('total','desc')->limit(10)
                 ->get();

      return view('panel.leaderboard')
      ->with('topBadge',$badgeCollector)
      ->with('topReservation',$mostReservator)
      ->with('topPoint',$highestPoint)
      ->with('topSpend',$mostSpend);
    }
}
