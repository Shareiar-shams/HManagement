<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Restaurant;
use Illuminate\Foundation\Validation\ValidatesRequests;

class RestaurentController extends Controller
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function __construct()
    // {
    //     $this->middleware('permission:view resturant', ['only' => ['index']]);
    //     $this->middleware('permission:create resturant', ['only' => ['create','store']]);
    //     $this->middleware('permission:update resturant', ['only' => ['edit','update']]);
    //     $this->middleware('permission:delete resturant', ['only' => ['destroy']]);
    // }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $restaurants = Restaurant::all();
        return view('admin.order.restaurant',compact('restaurants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Restaurant::where('id',$id)->delete();
        $notification = array(
            'message' => 'Restaurant Booking destroy.', 
            'alert-type' => 'error',
        );
        return redirect()->back()->with($notification);
    }
}
