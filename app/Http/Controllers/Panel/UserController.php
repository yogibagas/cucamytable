<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;
use App\Badge_log;
use App\Country;
use App\Badge;
use DB;
use Carbon\Carbon;
use PDF;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $this->authorize('menu.admin');
        $data = User::orderBy('created_at','desc')->paginate('10');
        return view('panel.user.list')->with('data',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $this->authorize('menu.admin');
        $model = new User();
        return view('panel.user.form')->with('data',$model);
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
          'name' => 'required|string|max:75',
          'username' => 'required|string|max:16|unique:users',
          'email' => 'required|string|email|max:255|unique:users',
          'phone' => 'required|regex:/[\d+]$/',
          'password' => 'required|string|min:6',
          'gender' => 'required',
          'role'=> 'required|numeric'
      ]);
      // dd($request->toArray());

      try {
          $data = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'gender' => $request->gender,
            'role'=> $request->role,
            'country_id' => 100
          ];
          User::create($data);

          return back()
              ->with('success', 'User Has been added');
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
        $data = User::findOrFail($id);
        $badges = Badge_log::where('id_user',$id)->get();
        $badgeList = [];
        foreach($badges as $b){
          $badgeList [] = $b->id_badge;
          // $badgeList [] = $b->id_badge;
        }
        $returnBadge = Badge::whereIn('id',$badgeList)->get();
        $badgeList = Badge::whereNotIn('id',$badgeList)->get();
        return view('panel.profile')->with('user',$data)
        ->with('badge',$returnBadge)
        ->with('badgeList',$badgeList);
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
        $this->authorize('menu.admin');
        $model = User::findOrFail($id);
        return view('panel.user.form')->with('data',$model);
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
        $model = User::findOrFail($id);

      $validation = $request->validate([
          'name' => 'required|string|max:75',
          'username' => 'required|string|max:16|unique:users,username,'.$model->id,
          'email' => 'required|string|email|max:255|unique:users,email,'.$model->id,
          'phone' => 'required|regex:/[\d+]$/',
          'gender' => 'required',
          'role'=> 'required|numeric',
          'status' => 'required|numeric'
      ]);
      // dd($request->toArray());
      $password = $model->password;
      if($request->password)
        $password = Hash::make($request->password);
      try {
          $data = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $password,
            'gender' => $request->gender,
            'role'=> $request->role,
            'country_id' => 100,
            'status' => $request->status
          ];
          $model->update($data);

          return back()
              ->with('success', 'User Has been updated');
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

    public function reports(){
      $country = Country::get();
      return view('panel.reports.users')->with('country',$country);
    }
    public function reportGenerate(Request $request){
      $user = User::when($role = $request->input('role'), function($query) use ($role) {
          return $query->where('role', '=', $role);
        })
        ->when($gender = $request->input('gender'), function($query) use ($gender) {
            return $query->where('gender', '=', $gender);
          })
        ->when($country = $request->input('country'), function($query) use ($country) {
            return $query->where('country_id', '=', $country);
          })
        ->when($status = $request->input('status'), function($query) use ($status) {
            return $query->where('status', '=', $status);
          })
        ->orderBy('created_at','desc')->get();
        // return view('panel.reports.users_list',['user'=>$user]);
$pdf = PDF::loadview('panel.reports.users_list',['user'=>$user])->setPaper('a4','landscape')->setWarnings(false);
        return $pdf->stream('users-report_'.Carbon::now()->format('d_m_Y_His'));
    }
}
