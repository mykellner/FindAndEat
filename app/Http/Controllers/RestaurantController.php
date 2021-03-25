<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\County;
use App\Models\City;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(County $county, City $cities)
    {
        //
        return view('restaurant/index', ['cities' => $cities, 'county' => $county, 'restaurant' => Restaurant::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(County $county, City $city)
    {
        abort_unless(Auth::check(), 401);
        $categories = Category::all();
        return view('restaurants/create', ['city' => $city, 'county' => $county, 'categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, County $county, City $city)
    {
        if(!$request->filled('name')) {
            return redirect()->back()->with('warning', 'Please enter a name for this County');
        }

        $restaurant = Restaurant::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'address' => $request->input('address'),
            'city_id' => $request->input('city_id'),
            ]);

        $restaurant->categories()->attach($request->input('categories'));

    
        return redirect()->route('restaurants.show', ['restaurant' => $restaurant, 'city' => $city, 'county' => $county]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function show(County $county, City $city, Restaurant $restaurant)
    {
        //
        return view('restaurants.show', ['city' => $city, 'county' => $county,'restaurant' => $restaurant]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function edit(Restaurant $restaurant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Restaurant $restaurant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Restaurant $restaurant)
    {
        //
    }
}
