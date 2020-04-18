<?php

namespace App\Http\Controllers\Panel;

use App\Badge;
use App\Http\Controllers\Controller;
use App\Reward;
use Auth;
use Illuminate\Http\Request;

class RewardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Reward::orderBy('id', 'desc')->paginate(10);
        return view("panel.reward")->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data = new Reward();
        $badgeExists = Reward::whereNotNull('id_badge')->get();
        $badgeUsed = [];
        foreach ($badgeExists as $existBadge) {
            $badgeUsed[] = $existBadge->id_badge;
        }

        $badge = Badge::whereNotIn('id', $badgeUsed)->where('status',1)->get();

        return view('panel.form.reward')->with('data', $data)
            ->with('badge', $badge);
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
            'point_type' => 'required|string|max:125',
            'point' => 'required|numeric',
            'max_point' => 'required|numeric',
            'id_badge' => 'required_with:badge,on',
        ]);
        $data = [
            'point_type' => $request->point_type,
            'point' => $request->point,
            'max_point' => $request->max_point,
            'id_badge' => $request->id_badge,
            'id_user' => Auth::user()->id,
        ];
        try {
            Reward::create($data);
            return back()->with('success', 'Reward Successfully added');
        } catch (\Exception $ex) {
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
        $model = Reward::with('badge')->findOrFail($id);
        return response()->json($model);
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

        $data = Reward::findOrFail($id);
        $badgeExists = Reward::where('id_badge', '!=', $data->id_badge)->whereNotNull('id_badge')->get();
        $badgeUsed = [];
        foreach ($badgeExists as $existBadge) {
            $badgeUsed[] = $existBadge->id_badge;
        }

        $badge = Badge::whereNotIn('id', $badgeUsed)->get();


        return view('panel.form.reward')->with('data', $data)
            ->with('badge', $badge);
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

        $model = Reward::findOrFail($id);
        $validation = $request->validate([
            'point_type' => 'required|string|max:125',
            'point' => 'required|numeric',
            'max_point' => 'required|numeric',
            'id_badge' => 'required_with:badge,on',
        ]);
        $data = [
            'point_type' => $request->point_type,
            'point' => $request->point,
            'max_point' => $request->max_point,
            'id_badge' => $request->id_badge,
            'status' => $request->status,
            'id_user' => Auth::user()->id,
        ];
        try {
            $model->update($data);
            return back()->with('success', 'Reward Successfully Updated! Last Update : ' . $model->updated_at);
        } catch (\Exception $ex) {
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
    public function rewardList(Request $request, $type)
    {
        $model = null;
        if ($type == "RESERVATION" || $type == "SPECIAL DAY") {
            $model = Reward::with('badge')->get();
        } else {
            $model = Reward::with('badge')->where('point_type', '!=', 'PERCENTAGE')->get();
        }

        return response()->json($model);
    }
}
