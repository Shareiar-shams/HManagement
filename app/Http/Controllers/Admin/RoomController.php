<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ProductsExport;
use App\Http\Controllers\Controller;
use App\Imports\ProductsImport;
use App\Models\Admin\Room;
use App\Models\Admin\Category;
use App\Models\Admin\RoomImage;
use App\Models\Admin\Floor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Foundation\Validation\ValidatesRequests;

class RoomController extends Controller
{
    use ValidatesRequests;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function __construct()
    // {
    //     $this->middleware('permission:view room', ['only' => ['index','stockout','campaign_offer','imexport']]);
    //     $this->middleware('permission:create room', ['only' => ['add','create','affiliatecreate','customizecreate','store','addPermissionToRole','givePermissionToRole']]);
    //     $this->middleware('permission:update room', ['only' => ['update','edit']]);
    //     $this->middleware('permission:delete room', ['only' => ['destroy']]);
    // }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Room::all();
        
        return view('admin.product.item.index',compact('products'));
    }

    /**
     * Display a listing of the resource.
     */
    public function add()
    {
        $sku = Str::random(10);
        $floors = Floor::where('status',1)->orderBy('id','DESC')->get();
        $categories = Category::all();
        return view('admin.product.item.physical.create',compact('sku','categories','floors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sku = Str::random(10);
        $floors = Floor::where('status',1)->orderBy('id','DESC')->get();
        $categories = Category::all();
        return view('admin.product.item.physical.create',compact('sku','categories','floors'));
    }

    public function img_dlt(Request $request)
    {
         
        $id = $request->id;
         
        $image = RoomImage::where('id',$id)->delete();
    }
   

    public function change_status(Request $request,$id)
    {
        $this->validate($request,[
            'status' => 'required',
        ]);
        $item = Room::find($id);

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
            'slug' => 'required|min:3|max:255|unique:rooms',
            'SKU' => 'required|min:3|max:255|unique:rooms',
            
            'featured_image.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|dimensions:min_width=100,min_height=100',
            'gallery_image.*' => 'sometimes|image|mimes:jpg,jpeg,png,gif,svg|dimensions:min_width=100,min_height=100',
            'short_description' => 'required',
            'description' => 'required',
            'tags' => 'nullable',
            'adult_capacity' => 'nullable',
            'child_capacity' => 'nullable',
            'floor_id'   => 'required|numeric',
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
        $item = new Room();
        $item->name = $request->name;
        $item->slug = $request->slug;

        $item->SKU = $request->SKU;
        $item->featured_image = $imageName;
        $item->short_description = $request->short_description;
        $item->description = $request->description;
        $item->tags = $tags;
        $item->adult_capacity = $request->adult_capacity;
        $item->child_capacity = $request->child_capacity;
        $item->floor_id = $request->floor_id;
        $item->category_id = $request->category_id;
    
        $item->price = $request->price;
        $item->special_price = $request->special_price;
        
        $item->save(); 
        if($request->file('gallery_image'))
        {
            foreach ($request->file('gallery_image') as $image) {
                $roomImage = new RoomImage;
                $imageName = $image->getClientOriginalName();
                $imageName = $image->store('public');
                // $path = 'images/product/'.$item->slug.'/'.$imagename;
                // $image->move($path);
                $roomImage->room_id = $item->id;
                $roomImage->image_path = $imageName;
                $roomImage->save();
            }
        }
        $notification = array(
            'message' => 'Room Add Successfully!', 
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
        $floors = Floor::where('status',1)->orderBy('id','DESC')->get();
        $categories = Category::all();
        $product = Room::find($id);
        return view('admin.product.item.physical.edit',compact('product','categories','floors'));
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
            'floor_id'   => 'required|numeric',
            'category_id'   => 'required|numeric',
            
            'price' => 'required|numeric',
            'special_price' => 'nullable|numeric',
            
        ]);
        $tags = isset($request->tags) ? json_encode($request->tags) : null;
        $item = Room::find($id);

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
        $item->floor_id = $request->floor_id;
        $item->category_id = $request->category_id;
        
        $item->price = $request->price;
        $item->special_price = $request->special_price;
        
        $item->save(); 
        if($request->file('gallery_image'))
        {
            foreach ($request->file('gallery_image') as $image) {
                $roomImage = new RoomImage;
                $imageName = $image->getClientOriginalName();
                $imageName = $image->store('public');
                
                $roomImage->room_id = $item->id;
                $roomImage->image_path = $imageName;
                $roomImage->save();
            }
        }
        $notification = array(
            'message' => 'Room Update Successfully!', 
            'alert-type' => 'success',
        );
        return redirect(route('item.index'))->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Room::where('id',$id)->delete();
        RoomImage::where('room_id',$id)->delete();
        $notification = array(
            'message' => 'Room destroy.', 
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
            'message' => 'Room imported successfully!', 
            'alert-type' => 'success',
        );
        return redirect(route('item.index'))->with($notification);
    }

    public function imexport()
    {
        return view('admin.product.item.import-export');
    }



}
