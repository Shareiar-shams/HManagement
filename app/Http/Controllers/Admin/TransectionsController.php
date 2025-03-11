<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\User\Transaction;
use Illuminate\Http\Request;

class TransectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // function __construct()
    // {
    //      $this->middleware('permission:manage transaction', ['only' => ['index','create','store','show','edit','update','destroy']]);
    // }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Transaction::orderBy('id', 'DESC')->get();
        return view('admin.transection.index',compact('data'));
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
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $notification = array(
            'message' => 'Payment Succesfull. Contact with Creditor.', 
            'alert-type' => 'success',
        );
        return redirect(route('transections.index'))->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Transaction::where('id',$id)->delete();
        $notification = array(
            'message' => 'Transaction destroy.', 
            'alert-type' => 'error',
        );
        return redirect()->back()->with($notification);
    }
}
