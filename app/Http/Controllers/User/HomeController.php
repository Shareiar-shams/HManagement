<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Admin\ProductType;
use App\Models\Admin\Product;
use App\Models\Admin\Restaurant;
use App\Models\User\Book;
use App\Models\User\Transaction;
use Illuminate\Support\Facades\Http;
use App\Mail\BookingConfirmationMail;
use Auth;
class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $floors = ProductType::where('status',true)->get();
        $rooms = Product::where('status',true)->with('category')->with('images')->inRandomOrder()->limit(3)->get();

        return Inertia::render('User/Home',[
            'floors' => $floors,
            'rooms' => $rooms,
        ]);
    }
    public function hotelResults(Request $request)
    {
        $rooms = $request->session()->get('rooms');

        $guestData = $request->session()->get('guestData');

        $request->session()->put('providedDataGuest', $guestData);

        $error = $request->session()->get('error') ?? (!$rooms ? 'Page not found' : null);

        // Clear the session data after retrieving it
        $request->session()->forget(['error']);

        return Inertia::render('User/HotelResults', [
            'rooms' => $rooms,
            'guestData' => $guestData,
            'error' => $error,
        ]);
    }
    public function searchRoom(Request $request)
    {
        $floor = $request->input('floor');

        $adult = $request->input('adult');
        $children = $request->input('children');
        $days = $request->input('days');
        $checkinDate = $request->input('checkinDate');
        $checkoutDate = $request->input('checkoutDate');

        $floor = ProductType::where('id', $floor)->first();
        if ($floor) {
            $rooms = $floor->products()
                ->with('category')
                ->where('status', true)
                ->where('booked', false)
                ->where('adult_capacity', '>=', $adult)
                ->where('child_capacity', '>=', $children)
                ->inRandomOrder()
                ->get();

            $data = [
                'floorId' => $floor->id,
                'floorName' => $floor->name,
                'adult' => $adult,
                'children' => $children,
                'days' => $days,
                'checkinDate' => $checkinDate,
                'checkoutDate' => $checkoutDate,
            ];

            
            return redirect()->route('hotelResults')->with('rooms', $rooms)->with('guestData', $data);
        } else {
            return redirect()->route('hotelResults')->with('error', 'Floor not found');
        }
    }

    public function dashboard()
    {
        $booked_room = Book::where('user_id', Auth::id())->with('product')->get();

        return Inertia::render('Dashboard',[
            'booked_room' => $booked_room,
        ]);
    }

    public function userReserveRestaurent()
    {
        $booked_restaurent = Restaurant::where('user_id', Auth::id())->get();
        return Inertia::render('ReserveRestaurent',[
            'reserveRestaurent' => $booked_restaurent,
        ]);
    }

    public function roomDetails(Request $request, $slug)
    {

        $guestData = $request->session()->get('providedDataGuest');

        $request->session()->forget(['providedDataGuest']);

        $day = $guestData['days'] ?? 1;

        $room = Product::where('slug',$slug)->with('category')->with('images')->first();
        // Store room data in session
        session()->put('session_room_data', $room);

        if($guestData){

            $guestData['price'] = isset($room->special_price) ? $room->special_price * $day  : $room->price * $day;
            // Store guest data in session
            session()->put('session_guest_Data', $guestData);
        }

        return Inertia::render('User/RoomDetails', [
            'room' => $room,
            'guestData' => $guestData,
        ]);
    }

    public function getroomDetails()
    {
        return Inertia::render('User/Error');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $room = $request->session()->get('session_room_data');

        $guestData = $request->session()->get('session_guest_Data');

        $request->session()->forget(['session_room_data','session_guest_Data']);

        return Inertia::render('User/Reservation',[
            'selectedHotel' => $room,
            'guestData' => $guestData,
        ]);
    }


    public function rooms()
    {
        $rooms = Product::where('status',true)->with('category')->with('images')->inRandomOrder()->get();

        return Inertia::render('User/Rooms',[
            'rooms' => $rooms,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $tran_id = uniqid();
        $order = new Book();
        $order->room_name = $request->selectedHotel['name'];
        $order->SKU = $request->selectedHotel['SKU'];
        $order->room_price = $request->selectedHotel['price'];
        $order->total = $request->guestData['price'];

        $order->floor  = $request->guestData['floorName'];
        $order->checkinDate = $request->guestData['checkinDate'];
        $order->checkoutDate  = $request->guestData['checkoutDate'];
        $order->days  = $request->guestData['days'];
        $order->adult_members  = $request->guestData['adult'];
        $order->children_members  = $request->guestData['children'];

        $order->user_id  = Auth::user()->id;
        $order->product_id = $request->selectedHotel['id'];
        $order->tran_id  = $tran_id;
        $order->name  = $request->name;
        $order->email  = $request->email;
        $order->phone  = $request->phone;
        $order->sex  = $request->sex;
        $order->identification  = $request->identification;
        $order->phone  = $request->phone;
        $order->address  = $request->address;
        $order->town  = $request->city;
        $order->postcode  = $request->postcode;
        $order->payment_status  = "Unpaid";
        $order->order_status  = "Pending";
        $order->save();

        $room = Product::where('id', $request->selectedHotel['id'])->first();
        $room->booked = 1;
        $room->save();

        $transection = new Transaction();
        $transection->user_id = Auth::user()->id;
        $transection->book_id = $order->id;
        $transection->tran_number = $tran_id;
        $transection->gateway_type = "Cash";
        $transection->payment_status = '';
        $transection->status = "Unpaid";
        $transection->amount = $request->guestData['price'];
        $transection->transection_time = date('Y-m-d H:i:s.u');
        $transection->save();
        
        $guestData = [
            'customer_name' => $request->name,
            'floorName' => $order->floor,
            'adult' => $order->adult_members,
            'children' => $order->children_members,
            'days' => $order->days,
            'checkinDate' => $order->checkinDate,
            'checkoutDate' => $order->checkoutDate,
            'room_name' => $order->room_name,
            'price' => $room->price,
            'total_amount' => $order->total,
            'tran_id' => $tran_id,
            'bank_tran_id' => '',
            'payment_gateway_type' => '',
            'card_brand' => '',
        ];
        $user_data = [
            
            'name' => $request->name,
            'email' => $request->email,
            'identification' => $request->identification,
            'phone' => $request->phone,
            'sex' => $request->sex,
        ];

        \Mail::to($request->email)->send(new BookingConfirmationMail($guestData));
        return Inertia::render('User/Payment',[
            'selectedHotel' => $room,
            'guestData' => $guestData,
            'allGuestInfo' => $user_data,
        ]);
    }

    // Initiate payment request
    public function initiate(Request $request)
    {
        $postData = [
            'store_id' => env('SSLC_STORE_ID'),
            'store_passwd' => env('SSLC_STORE_PASSWORD'),
            'total_amount' => $request->total_amount,
            'currency' => $request->currency,
            'tran_id' => $request->tran_id,
            'success_url' => route('sslcommerz.success'),
            'fail_url' => route('sslcommerz.fail'),
            'cancel_url' => route('sslcommerz.cancel'),
            'shipping_method'=> 'Courier',
            'product_name'=> 'room',
            'product_category'=> 'Hotel',
            'product_profile'=> 'general',
            'cus_name' => $request->customer_name,
            'cus_email' => $request->customer_email,
            'cus_phone' => $request->customer_phone,
            'cus_add1' => $request->customer_address,
            'cus_city' => $request->customer_city,
            'cus_postcode'=> $request->customer_postcode,
            'cus_country' => 'Bangladesh',
            'ship_name'=> 'Customer Name',
            'ship_add1'=> 'Dhaka',
            'ship_city'=> 'Dhaka',
            'ship_state'=> 'Dhaka',
            'ship_postcode'=> 1000,
            'ship_country'=> 'Bangladesh',
        ];
        // Send request to SSLCommerz
        $response = Http::asForm()->post('https://sandbox.sslcommerz.com/gwprocess/v4/api.php', $postData);

        if ($response->ok()) {

            $data = $response->json();
            if (!empty($data['GatewayPageURL'])) {

                //Store room data in session
                $order = new Book();
                $order->room_name = $request->selectedHotel['name'];
                $order->SKU = $request->selectedHotel['SKU'];
                $order->room_price = $request->selectedHotel['special_price'] ?? $request->selectedHotel['price'];
                $order->total = $request->guestData['price'];

                $order->floor  = $request->guestData['floorName'];
                $order->checkinDate = $request->guestData['checkinDate'];
                $order->checkoutDate  = $request->guestData['checkoutDate'];
                $order->days  = $request->guestData['days'];
                $order->adult_members  = $request->guestData['adult'];
                $order->children_members  = $request->guestData['children'];

                $order->user_id  = Auth::user()->id;
                $order->product_id = $request->selectedHotel['id'];
                $order->tran_id  = $request->tran_id;
                $order->name  = $request->customer_name;
                $order->email  = $request->customer_email;
                $order->phone  = $request->customer_phone;
                $order->sex  = $request->customer_sex;
                $order->identification  = $request->customer_identification;
                $order->phone  = $request->customer_phone;
                $order->address  = $request->customer_address;
                $order->town  = $request->customer_city;
                $order->postcode  = $request->customer_postcode;
                $order->payment_status  = "Unpaid";
                $order->order_status  = "Pending";
                $order->save();

                $transection = new Transaction();
                $transection->user_id = Auth::user()->id;
                $transection->book_id = $order->id;
                $transection->tran_number = $request->tran_id;
                $transection->save();

                return response()->json(['GatewayPageURL' => $data['GatewayPageURL']]);
            }
        }
        
        return response()->json(['error' => 'Failed to initiate payment'], 500);
    }

    // Handle successful payment
    public function paymentSuccess(Request $request)
    {
        $request->session()->regenerate();
        // Validate transaction
        $validation = $this->validateTransaction($request->all());
        if ($validation['status'] === 'VALID') {
            
            $order = Book::where('tran_id', $request->tran_id)->first();

            $order->payment_status  = "Paid";
            $order->order_status  = "Booked";
            $order->save();

            $room = Product::where('id', $order->product_id)->first();
            $room->booked = 1;
            $room->save();

            $transection = Transaction::where('tran_number',$request->tran_id)->first();
            $transection->paymentId = $request->bank_tran_id;
            $transection->gateway_type = "SSLCommerz";
            $transection->payment_status = "Success";
            $transection->status = "Paid";
            $transection->amount = $request->amount;
            $transection->transection_time = $request->tran_date;
            $transection->save();
            
            $guestData = [
                'customer_name' => $order->name,
                'floorName' => $order->floor,
                'adult' => $order->adult_members,
                'children' => $order->children_members,
                'days' => $order->days,
                'checkinDate' => $order->checkinDate,
                'checkoutDate' => $order->checkoutDate,
                'room_name' => $order->room_name,
                'price' => $room->price,
                'total_amount' => $order->total,
                'tran_id' => $request->tran_id,
                'bank_tran_id' => $request->bank_tran_id,
                'payment_gateway_type' => $request->card_issuer,
                'card_brand' => $request->card_brand,
            ];
            $user_data = [
                'name' => $order->name,
                'email' => $order->email,
                'identification' => $order->identification,
                'phone' => $order->phone,
                'sex' => $order->sex,
            ];
            \Mail::to($user_data['email'])->send(new BookingConfirmationMail($guestData));

            return Inertia::render('User/Payment',[
                'selectedHotel' => $room,
                'guestData' => $guestData,
                'allGuestInfo' => $user_data,
            ]);
        }


    }

    // Handle failed payment
    public function paymentFail(Request $request)
    {
        $order = Book::where('tran_id', $request->tran_id)->first();
        $order->payment_status  = "Unpaid";
        $order->order_status  = "Canceled";
        $order->save();

        $transection = Transaction::where('tran_number',$request->tran_id)->first();
        $transection->paymentId = $request->bank_tran_id;
        $transection->gateway_type = "SSLCommerz";
        $transection->payment_status = "Failed";
        $transection->status = "Unpaid";
        $transection->amount = $request->amount;
        $transection->transection_time = $request->tran_date;
        $transection->save();
        
        return Inertia::render('User/PaymentError',[
            'message' => 'Uh-oh! Your payment couldn’t be processed. Check your card details and try again.',
        ]);
    }

    // Handle canceled payment
    public function paymentCancel(Request $request)
    {
        $order = Book::where('tran_id', $request->tran_id)->first();
        $order->payment_status  = "Unpaid";
        $order->order_status  = "Canceled";
        $order->save();


        $transection = Transaction::where('tran_number',$request->tran_id)->first();
        $transection->paymentId = $request->bank_tran_id;
        $transection->gateway_type = "SSLCommerz";
        $transection->payment_status = "Canceled";
        $transection->status = "Unpaid";
        $transection->amount = $request->amount;
        $transection->transection_time = $request->tran_date;
        $transection->save();

        // Log the canceled transaction
        // Example: Order::where('transaction_id', $request->tran_id)->update(['status' => 'canceled']);
        return Inertia::render('User/PaymentError',[
            'message' => "Payment Canceled! You can try again whenever you’re ready.",
        ]);
    }

    // Validate transaction (optional but recommended)
    private function validateTransaction($data)
    {
        $store_id = env('SSLC_STORE_ID');
        $store_passwd = env('SSLC_STORE_PASSWORD');
        $validation_id = $data['val_id'];

        $url = "https://sandbox.sslcommerz.com/validator/api/validationserverAPI.php?val_id={$validation_id}&store_id={$store_id}&store_passwd={$store_passwd}&v=1&format=json";

        $response = Http::get($url);

        return $response->json();
    }

    public function restaurent()
    {
        return Inertia::render('User/Restaurent');
    }

    public function restaurent_booking(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|email',
            'phone' => 'required|regex:/^01[3-9]\d{8}$/',
            'booking_time' => 'required|date|after:now',
            'number_of_guests' => 'required|integer|min:1',
        ]);

        try {
            $booking = new Restaurant();
            $booking->user_id = Auth::user()->id;
            $booking->name = $validatedData['name'];
            $booking->email = $validatedData['email'];
            $booking->phone = $validatedData['phone'];
            $booking->booking_time = $validatedData['booking_time'];
            $booking->number_of_guests = $validatedData['number_of_guests'];
            $booking->save();

            // Return success response
            return response()->json([
                'status' => 'success',
                'message' => 'Your table has been booked successfully!',
                'data' => $booking
            ], 201);

        } catch (\Exception $e) {
            // Return error response
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong! Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }

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
        //
    }
}
