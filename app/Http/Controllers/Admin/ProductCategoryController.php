<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;

class ProductCategoryController extends Controller
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
        $categories = ProductCategory::with('children')->whereNull('parent_id')->orderBy('id','DESC')->get();
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
            'slug'      => 'required|min:3|max:255|string|unique:product_categories',
        ]);
        $item = new ProductCategory(); 

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

        $item = ProductCategory::find($id); 

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
        $category = ProductCategory::find($id);
        if ($category->children) {
            // foreach ($category->children()->with('products')->get() as $child) {
            //     foreach ($child->products as $product) {
            //         // product::where('category_id',$id)->update(['category_id' => NULL]);
            //     }
            // }
            
            $category->children()->delete();
        }

        // foreach ($category->products as $product) {
        //     // $product->update(['category_id' => NULL]);
        //     product::where('category_id',$id)->update(['category_id' => NULL]);
        // }

        $category->delete();

        $notification = array(
            'message' => 'Category Delete Successfully!', 
            'alert-type' => 'success',
        );
        return redirect(route('categories.index'))->with($notification);
    }
}
