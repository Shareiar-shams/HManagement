<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ProductsExport;
use App\Http\Controllers\Controller;
use App\Imports\ProductsImport;
use App\Models\Admin\Product;
use App\Models\Admin\ProductCategory;
use App\Models\Admin\ProductImage;
use App\Models\Admin\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Foundation\Validation\ValidatesRequests;

class ProductController extends Controller
{
    use ValidatesRequests;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function __construct()
    // {
    //     $this->middleware('permission:view product', ['only' => ['index','stockout','campaign_offer','imexport']]);
    //     $this->middleware('permission:create product', ['only' => ['add','create','affiliatecreate','customizecreate','store','addPermissionToRole','givePermissionToRole']]);
    //     $this->middleware('permission:update product', ['only' => ['update','edit']]);
    //     $this->middleware('permission:delete product', ['only' => ['destroy']]);
    // }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::all();
        
        return view('admin.product.item.index',compact('products'));
    }

    /**
     * Display a listing of the resource.
     */
    public function add()
    {
        $sku = Str::random(10);
        $type = ProductType::where('status',1)->orderBy('id','DESC')->get();
        $categories = ProductCategory::where('parent_id',null)->get();
        return view('admin.product.item.physical.create',compact('sku','categories','type'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sku = Str::random(10);
        $type = ProductType::where('status',1)->orderBy('id','DESC')->get();
        $categories = ProductCategory::where('parent_id',null)->get();
        return view('admin.product.item.physical.create',compact('sku','categories','type'));
    }

    public function img_dlt(Request $request)
    {
         
        $id = $request->id;
         
        $image = ProductImage::where('id',$id)->delete();
    }
   

    public function change_status(Request $request,$id)
    {
        $this->validate($request,[
            'status' => 'required',
        ]);
        $item = Product::find($id);

        $item->status = $request->status;
        $item->save(); 
        $notification = array(
            'message' => 'Status Change!', 
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|min:3',
            'slug' => 'required|min:3|max:255|unique:products',
            'SKU' => 'required|min:3|max:255|unique:products',
            
            'featured_image.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|dimensions:min_width=100,min_height=100',
            'gallery_image.*' => 'sometimes|image|mimes:jpg,jpeg,png,gif,svg|dimensions:min_width=100,min_height=100',
            'short_description' => 'required',
            'description' => 'required',
            'tags' => 'nullable',
            'adult_capacity' => 'nullable',
            'child_capacity' => 'nullable',
            'type_id'   => 'required|numeric',
            'category_id'   => 'required|numeric',
            
            'price' => 'required|numeric',
            'special_price' => 'nullable|numeric',
            
        ]);

        if($request->hasFile('featured_image'))
        {
            $imageName = $request->featured_image->getClientOriginalName();
            $imageName = $request->featured_image->store('public');
        }
        $tags = isset($request->tags) ? json_encode($request->tags) : null;
        $item = new Product();
        $item->name = $request->name;
        $item->slug = $request->slug;

        $item->SKU = $request->SKU;
        $item->featured_image = $imageName;
        $item->short_description = $request->short_description;
        $item->description = $request->description;
        $item->tags = $tags;
        $item->adult_capacity = $request->adult_capacity;
        $item->child_capacity = $request->child_capacity;
        $item->type_id = $request->type_id;
        $item->category_id = $request->category_id;
    
        $item->price = $request->price;
        $item->special_price = $request->special_price;
        
        $item->save(); 
        if($request->file('gallery_image'))
        {
            foreach ($request->file('gallery_image') as $image) {
                $productImage = new ProductImage;
                $name = $image->getClientOriginalName();
                $imageName = $image->store('public');
                // $path = 'images/product/'.$item->slug.'/'.$imagename;
                // $image->move($path);
                $productImage->product_id = $item->id;
                $productImage->image_path = $imageName;
                $productImage->save();
            }
        }
        $notification = array(
            'message' => 'Item Add Successfully!', 
            'alert-type' => 'success',
        );
        return redirect(route('item.index'))->with($notification);
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
        $type = ProductType::where('status',1)->orderBy('id','DESC')->get();
        $categories = ProductCategory::where('parent_id',null)->get();
        $product = Product::find($id);
        return view('admin.product.item.physical.edit',compact('product','categories','type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request,[
            'name' => 'required|min:3',
            'slug' => 'required|min:3|max:255',
            'SKU' => 'required|min:3|max:255',
            
            'featured_image.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|dimensions:min_width=100,min_height=100',
            'gallery_image.*' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|dimensions:min_width=100,min_height=100',
            'short_description' => 'required',
            'description' => 'required',
            'tags' => 'nullable',
            'adult_capacity' => 'nullable',
            'child_capacity' => 'nullable',
            'stock' => 'nullable|numeric',
            'type_id'   => 'required|numeric',
            'category_id'   => 'required|numeric',
            
            'price' => 'required|numeric',
            'special_price' => 'nullable|numeric',
            
        ]);
        $tags = isset($request->tags) ? json_encode($request->tags) : null;
        $item = Product::find($id);

        if($request->hasFile('featured_image'))
        {
            $imageName = $request->featured_image->getClientOriginalName();
            $imageName = $request->featured_image->store('public');
        }else{

            $imageName = $item->featured_image;
        }
        
        $item->name = $request->name;
        $item->slug = $request->slug;
    
        $item->SKU = $request->SKU;
        $item->featured_image = $imageName;
        $item->short_description = $request->short_description;
        $item->description = $request->description;
        $item->tags = $tags;
        $item->adult_capacity = $request->adult_capacity;
        $item->child_capacity = $request->child_capacity;
        $item->type_id = $request->type_id;
        $item->category_id = $request->category_id;
        
        $item->price = $request->price;
        $item->special_price = $request->special_price;
        
        $item->save(); 
        if($request->file('gallery_image'))
        {
            foreach ($request->file('gallery_image') as $image) {
                $productImage = new ProductImage;
                $name = $image->getClientOriginalName();
                $imageName = $image->store('public');
                
                $productImage->product_id = $item->id;
                $productImage->image_path = $imageName;
                $productImage->save();
            }
        }
        $notification = array(
            'message' => 'Item Update Successfully!', 
            'alert-type' => 'success',
        );
        return redirect(route('item.index'))->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Product::where('id',$id)->delete();
        productImage::where('product_id',$id)->delete();
        $notification = array(
            'message' => 'Product destroy.', 
            'alert-type' => 'error',
        );
        return redirect()->back()->with($notification);
    }

    public function export()
    {
        return Excel::download(new ProductsExport, 'rooms.csv');
    }

    public function import(Request $request)
    {
        $file = $request->file('csv');
        Excel::import(new ProductsImport, $file);

        $notification = array(
            'message' => 'Products imported successfully!', 
            'alert-type' => 'success',
        );
        return redirect(route('item.index'))->with($notification);
    }

    public function imexport()
    {
        return view('admin.product.item.import-export');
    }

    public function stockout()
    {
        $products = Product::where('productType','physical')->where('stock',0)->get();
        return view('admin.product.item.stock-out',compact('products'));
    }


    public function status(Request $request,$id)
    {
        $this->validate($request,[
            'status' => 'required',
        ]);
        $item = OfferProduct::find($id);

        $item->status = $request->status;
        $item->save(); 
        $notification = array(
            'message' => 'Status Change!', 
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    public function delete(string $id)
    {
        OfferProduct::where('id',$id)->delete();
        $notification = array(
            'message' => 'Product dissociate from offer!', 
            'alert-type' => 'error',
        );
        return redirect()->back()->with($notification);
    }
}
