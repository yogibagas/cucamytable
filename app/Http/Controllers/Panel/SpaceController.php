<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Space;

class SpaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $menu = Space::orderBy('id','desc')->paginate(10);
        return view('panel.space')
        ->with('data',$menu);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data = New Space();
        return view('panel.form.space')->with('data',$data);
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
            'name' => 'required|string|max:175',
            'maximum_pax' => 'required|numeric|digits_between:1,3',
            'minimum_pax' => 'required|numeric|digits_between:1,3',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'desc' => 'required|string',
            'avaibility' => 'required|numeric|digits_between:1,3',
            'status'=>'required|boolean',
        ]);

        if($request->images != null ){
            $filename = pathinfo($request->images->getClientOriginalName(), PATHINFO_FILENAME);
            $imageName = $filename . '-' . time() . '.' . $request->images->extension();
            $request->images->move(public_path('images/spaces'), $imageName);
        }else{
            $imageName = "";
        }

        try {
            $data = [
                'name' => $request->name,
                'maximum_pax' => $request->maximum_pax,
                'minimum_pax' => $request->minimum_pax,
                'image' => $imageName,
                'desc' =>  $request->desc,
                'avaibility' => $request->avaibility,
                'status'=> $request->status,
            ];
            Space::create($data);

            return back()
                ->with('success', 'You have successfully add the new space.');
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
        $data = Space::find($id);
        return view('panel.form.space')->with('data',$data);
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
        $model = Space::findOrFail($id);


        $validation = $request->validate([
            'name' => 'required|string|max:175',
            'maximum_pax' => 'required|numeric|digits_between:1,3',
            'minimum_pax' => 'required|numeric|digits_between:1,3',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'desc' => 'required|string',
            'avaibility' => 'required|numeric|digits_between:1,3',
            'status'=>'required|boolean',
        ]);
            if($request->images != null ){
                $filename = pathinfo($request->images->getClientOriginalName(), PATHINFO_FILENAME);
                $imageName = $filename . '-' . time() . '.' . $request->images->extension();
                $request->images->move(public_path('images/spaces'), $imageName);
            }else{
                $imageName = $model->image;
            }

        try {
            $data = [
                'name' => $request->name,
                'maximum_pax' => $request->maximum_pax,
                'minimum_pax' => $request->minimum_pax,
                'image' => $imageName,
                'desc' =>  $request->desc,
                'avaibility' => $request->avaibility,
                'status'=> $request->status,
            ];
            $model->update($data);

            return redirect()->route('space.index')
                ->with('success', 'You have successfully edit the space');
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
       
          
    }
    public function delete($id){
         //
         $model = Space::findOrFail($id);
         if($model->status == 1){
             $msg = "Deactived";
             $model->status = 0;
         }else{
             $msg="Actived";
             $model->status=1;
         }
         
         try{
             $model->save();
 
             return redirect()->route('space.index')
                 ->with('success', 'You Space has been '. $msg);
         }catch(\Exception $ex){
             return back()->with('failed', 'Error! ' . $ex->getMessage());
         }
    }
}
