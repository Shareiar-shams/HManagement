<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;

class RoomCategoryController extends Controller
{
    use ValidatesRequests;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // function __construct()
    // {
    //      $this->middleware('permission:mange categories', ['only' => ['index','create','store','edit','update','destroy']]);
    // }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::orderBy('id','DESC')->get();
        return view('admin.product.categories.index',compact('categories'));
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
        $this->validate($request,[
            'name'      => 'required|min:3|max:255|string',
            'slug'      => 'required|min:3|max:255|string|unique:categories',
        ]);
        $item = new Category(); 

        $item->name = $request->name;
        $item->slug = $request->slug;
        $item->save(); 
        $notification = array(
            'message' => 'Category create successfully!', 
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
        
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
        $this->validate($request,[
            'name'  => 'required|min:3|max:255|string',
            'slug'  => 'required|min:3|max:255|string',
        ]);

        $item = Category::find($id); 

        $item->name = $request->name;
        $item->slug = $request->slug;
        $item->save(); 

        $notification = array(
                'message' => 'Category Updated Successfully!', 
                'alert-type' => 'success',
            );
        return redirect(route('categories.index'))->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);
        $category->delete();

        $notification = array(
            'message' => 'Category Delete Successfully!', 
            'alert-type' => 'success',
        );
        return redirect(route('categories.index'))->with($notification);
    }
}
