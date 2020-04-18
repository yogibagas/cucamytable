<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Menu;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      $food = Menu::whereHas('category', function ($query) {
    $query->where('menu_group', '=', "FOOD");
})->where('status',1)->orderBy('created_at','desc')->limit(6)->get();
      $cocktails = Menu::whereHas('category', function ($query2) {
    $query2->where('menu_categories.name', '=', "Cocktail");
})->where('status',1)->orderBy('created_at','desc')->limit(6)->get();
      $mocktails = Menu::whereHas('category', function ($query3) {
    $query3->where('menu_categories.name', '=', "Mocktail");
})->where('status',1)->orderBy('created_at','desc')->limit(6)->get();

    $menu = Menu::where('status',1)->orderBy('created_at','desc')->limit(6)->get();
        return view('front-site.index')->with('food',$food)->with('cocktail',$cocktails)->with('mocktail',$mocktails)->with('menu',$menu);
    }
}
