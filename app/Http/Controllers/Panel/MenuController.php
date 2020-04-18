<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Menu;
use App\MenuCategory;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use PDF;

class MenuController extends Controller
{
    //
    public function index()
    {
      //give an authorize this function need a policy
      // $this->authorize('menu.view');
      $this->authorize('menu.admin');

        $menu = Menu::orderBy('id','desc')->paginate(10);
        return view('panel.menu')
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
        $this->authorize('menu.admin');
        $category = MenuCategory::get();
        $model = New Menu();
        return view('panel.form.menu')->with('data', $model)
        ->with('category',$category);
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
          // $this->authorize('menu');
        $validation = $request->validate([
            'name' => 'required|string|max:125',
            'price' => 'required|numeric',
            'id_category' => 'required|',
            'status' => 'required|numeric',
            'menu_images' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'desc'=> 'nullable|string'
        ]);

        if($request->menu_images != null){
            $filename = pathinfo($request->menu_images->getClientOriginalName(), PATHINFO_FILENAME);
            $imageName = $filename . '-' . time() . '.' . $request->menu_images->extension();
        }else{
            $imageName = "";
        }

        try {
            $request->menu_images->move(public_path('images/menu-images'), $imageName);
            $data = [
                'name' => $request->name,
                'price' => $request->price,
                'id_category' => $request->id_category,
                'image_name' => $imageName,
                'status' => $request->status,
                'id_user' => Auth::user()->id,
                'desc'=>$request->desc
            ];
            Menu::create($data);

            return back()
                ->with('success', 'You have successfully add the new menu.');
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
        $model= Menu::findOrFail($id);
        $category = MenuCategory::get();
        return view('panel.form.menu')->with('data',$model)->with('category',$category);
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
        $model = Menu::findOrFail($id);
        $validation = $request->validate([
            'name' => 'required|string|max:125',
            'price' => 'required|numeric',
            'id_category' => 'required|',
            'status' => 'required|numeric',
            'menu_images' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'desc'=> 'nullable|string',
        ]);

        if($request->menu_images != null){
            $filename = pathinfo($request->menu_images->getClientOriginalName(), PATHINFO_FILENAME);
            $imageName = $filename . '-' . time() . '.' . $request->menu_images->extension();
            $request->menu_images->move(public_path('images/menu-images'), $imageName);
        }else{
            $imageName = $model->image_name;
        }

        try {

            $data = [
                'name' => $request->name,
                'price' => $request->price,
                'id_category' => $request->id_category,
                'image_name' => $imageName,
                'status' => $request->status,
                'id_user' => Auth::user()->id,
                'desc'=>$request->desc
            ];
            $model->update($data);

            return redirect()->route('menu')
                ->with('success', 'You have successfully edit the menu.');
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
    public function delete($id){
        //
        $model = Menu::findOrFail($id);

         if($model->status == 1){
             $msg = "Deactived";
             $model->status = 0;
         }else{
             $msg="Actived";
             $model->status=1;
         }

         try{
             $model->save();

             return redirect()->route('menu')
                 ->with('success', $model->name.' has been '. $msg);
         }catch(\Exception $ex){
             return back()->with('failed', 'Error! ' . $ex->getMessage());
         }
    }
    public function report(){
      $this->authorize('menu.admin');
              $category = MenuCategory::get();
              return view('panel.reports.menu')->with('category',$category);
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

        $data = DB::table('menus')->select('menus.id','menus.name','menu_categories.name as category_name',DB::raw('SUM(detail_reservation.qty) As total_sold'))
        ->join('menu_categories','menus.id_category','=','menu_categories.id')
        ->join('detail_reservation','menus.id','=','detail_reservation.id_menu')
        ->join('reservations','detail_reservation.id_reservation','=','reservations.id')
        ->where('reservations.payment_status','>=','0')
        ->whereDate('reservation_datetime','>=',Carbon::parse($date['start'])->format('Y-m-d'))
        ->whereDate('reservation_datetime','<=',Carbon::parse($date['end'])->format('Y-m-d'))
        ->when($category = $request->input('category'), function($query) use ($category) {
            return $query->where('menus.id_category', '=', $category);
          })
        ->orderBy('id_category','asc')->groupBy('menus.id')
        ->get();
          // return view('panel.reports.menus_list',['data'=>$data,'date'=>$date]);
      $pdf = PDF::loadview('panel.reports.menus_list',['data'=>$data,'date'=>$date])->setPaper('a4','landscape')->setWarnings(false);
          return $pdf->stream('menu-report_'.Carbon::now()->format('d_m_Y_His'));
    }
}
