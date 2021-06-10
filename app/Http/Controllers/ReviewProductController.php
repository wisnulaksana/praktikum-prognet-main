<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\ReviewProducts;
use App\Models\TransactionDetails;
use App\Models\Products;
use App\Notifications\AdminNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class ReviewProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Products $product)
    {


      return view('review-product',compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $review = New ReviewProducts;
        
        $review->product_id = $request->id;
        $review->rate = $request->rate;
        $review->content = $request->content;
        $review->user_id = Auth::user()->id;
        $review->save();
        // $admin = Admin::where('role', 'super admin')->get();
        $admin = Admin::get();
        // dd($admin);
        $product = Products::find($review->product_id);
        $notif = "<a class='dropdown-item submit-form' data-submits='' href='/admin/product/show/" . $request->id . "'>" .
            "<div class='item-content flex-grow'>" .
            "<h6 class='ellipsis font-weight-normal'>" . Auth::user()->name . "</h6>" .
            "<p class='font-weight-light small-text text-muted mb-0'>memberikan review ke" . $product->product_name ."</p>" .
            "</div>" .
            "</a>";
        // $admin->notify(new AdminNotification(['role'=>'super admin'],$notif));
        Notification::send($admin, new AdminNotification($notif)); // multiple notification
        echo 'Review Terkirim. Terima kasi sudah memberikan review anda';
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReviewProducts  $reviewProducts
     * @return \Illuminate\Http\Response
     */
    public function show(ReviewProducts $reviewProducts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReviewProducts  $reviewProducts
     * @return \Illuminate\Http\Response
     */
    public function edit(ReviewProducts $reviewProducts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ReviewProducts  $reviewProducts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReviewProducts $reviewProducts)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReviewProducts  $reviewProducts
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReviewProducts $reviewProducts)
    {
        //
    }
}
