<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Admin;
use App\Models\User\Book;
use App\Models\Admin\Product;
use App\Models\Admin\Transection;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;
use Carbon\Carbon;


class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // function __construct()
    // {
    //     $this->middleware('permission:manage customers', ['only' => ['create','status','show','destroy']]);
    //     $this->middleware('permission:manage subscribers', ['only' => ['subscribers','subscriber_mail','subscribers_mail_send','subscribers_delete']]);
    //     $this->middleware('permission:manage site mail', ['only' => ['all_mail','all_admin_sent_mail','mail_show','compose','send','mail_destroy','deleteAll']]);
    // }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        
        $users = User::all();
        $products = Product::all();
        
        $orders = Book::orderBy('id','DESC')->get();

        $recent_orders = Book::orderBy('id','DESC')->limit(10)->get();

        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year; // Get the current year

        $charts_orders = Book::whereYear('created_at', $currentYear)
                   ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(id) as id')) // Assuming 'amount' for order value
                   ->groupBy('month')
                   ->orderBy('id', 'DESC')
                   ->get();
        
        $labels = [];
        $data = [];

        foreach ($charts_orders as $order) {
            $labels[] = Carbon::createFromDate($currentYear, $order->month)->format('M'); // Format month labels
            $data[] = $order->id;
        }
        
        $existingData = [ // Your existing data
          'labels' => ['January', 'February'],
          'data' => [0, 0],
        ];

        // Approach 1: Merging with separate arrays
        $data = [
          'labels' => array_merge($existingData['labels'], $labels),
          'data' => array_merge($existingData['data'], $data),
        ];
        // Get the start and end dates of the last month

        $startOfCurrentMonth = Carbon::now()->startOfMonth();
        $endOfCurrentMonth = Carbon::now()->endOfMonth();

        // Prepare an array to hold the two-day intervals
        $dateRanges = [];
        for ($date = $startOfCurrentMonth; $date->lessThanOrEqualTo($endOfCurrentMonth); $date->addDays(2)) {
            $dateRanges[] = [
                'start' => $date->copy(),
                'end' => $date->copy()->addDays(1)
            ];
        }
        // Query the database to get the order counts for each interval
        $orderLabels = [];
        $orderCounts = [];
        $totalEarning = [];
        foreach ($dateRanges as $range) {
            $startDate = $range['start']->format('Y-m-d');
            $endDate = $range['end']->format('Y-m-d');

            $count = Book::whereBetween('created_at', [$startDate, $endDate])
                ->count();

            if(empty($count)){
                $count = Book::whereDate('created_at', $endDate)->count();
            }
            $amount = Book::where('payment_status', 'Paid')
                  ->whereBetween('created_at', [$startDate, $endDate])
                  ->sum('total');
            if(empty($amount)){
                $amount = Book::where('payment_status', 'Paid')
                  ->whereDate('created_at', $endDate)
                  ->sum('total');
            }
            $orderLabels[] =  $range['start']->format('M d');

            $orderCounts[] = $count;

            $totalEarning[] = $amount;
        }

        $month_wise_data = [
          'labels' => $orderLabels,
          'data' => $orderCounts,
          'amount' => $totalEarning,
        ];
        return view('admin.dashboard',compact('products','orders','users','recent_orders', 'data','month_wise_data'));
        // return view('admin.dashboard',compact('users'));
    }


    /**
     * Display a listing of the resource.
     */
    public function profile(): View
    {
        return view('admin.profile');
    }


    /**
     * ImageUpdate the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function imgupdate(Request $request, $id)
    {
        $this->validate($request,[
            'image.*' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if($request->hasFile('image'))
        {
            $imageName = $request->image->getClientOriginalName();
            $imageName = $request->image->store('public');
        }
        else
        {
            $data = Admin::where('id',$id)->first();
            $imageName = $data->image;
        }

        $admin =  Admin::find($id);
        $admin->image = $imageName;
        $admin->save(); 
        $notification = array(
            'message' => 'Picture Changed!', 
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    /**
     * Admin Password the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function passupdate(Request $request, $id)
    {
        $this->validate($request,[
            'old_password' => 'required|string',
            'new_password' =>  ['required','string',Password::min( 8 ),'same:c_password','different:old_password'],
        ]);

        $admin =  Admin::find($id);
        if (Hash::check($request->old_password, $admin->password)) { 
            $admin->fill([
                'password' => Hash::make($request->new_password)
            ])->save();

            $notification = array(
                'message' => 'Password Changed!', 
                'alert-type' => 'success',
            );
        } 
        else{
            $notification = array(
                'message' => 'Password does not match!', 
                'alert-type' => 'error',
            );
        }
        return redirect()->back()->with($notification);
        
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = User::orderBy('id', 'desc')->get();
        return view('admin.customers.websitecustomer',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    public function status(Request $request,string $id)
    {
        $this->validate($request,[
            'status' => 'required',
        ]);
        $user = User::find($id);

        $user->status = $request->status;
        $user->save(); 
        $notification = array(
            'message' => 'Status Change!', 
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = User::find($id);
        return view('admin.customers.show',compact('data'));
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
        // dd($request);

        $this->validate($request,[
            'name' => 'required|string|max:255',
            'position' => 'nullable',
            'phone' => 'required|min:11|max:14',
        ]);

        $admin =  Admin::find($id);
        $admin->name = $request->name;
        $admin->position = $request->position;
        $admin->phone = $request->phone;
        $admin->save(); 
        $notification = array(
            'message' => 'Profile Updated Successfully!', 
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

   

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::where('id',$id)->delete();
        $notification = array(
            'message' => 'User Destroyed.', 
            'alert-type' => 'error',
        );
        return redirect()->back()->with($notification);
    }

}
