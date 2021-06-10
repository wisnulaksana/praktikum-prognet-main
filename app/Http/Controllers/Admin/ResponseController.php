<?php

namespace App\Http\Controllers\Admin;

use App\Models\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Models\ReviewProducts;
use App\Models\User;
use App\Notifications\UserNotification;
use Illuminate\Support\Facades\Auth;

class ResponseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $respond = $request->all();
        $respond['admin_id'] = Auth::guard('admin')->user()->id;
        Response::create($respond);
        $review = ReviewProducts::where('id', $request->review_id)->first();
        $product = Products::find($review->product_id);
        $user = User::find($review->user_id);
        $user->notify(new UserNotification("<a class='submit-form' data-submits='' href ='/detail-product/" . $review->product_id . "'>Reviewmu di produk " . $product->product_name . " telah direspon oleh admin</a>"));
        return redirect()->back()->with('success', 'berhasil membalas review pengguna');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Response  $response
     * @return \Illuminate\Http\Response
     */
    public function show(Response $response)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Response  $response
     * @return \Illuminate\Http\Response
     */
    public function edit(Response $response)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Response  $response
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Response $response)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Response  $response
     * @return \Illuminate\Http\Response
     */
    public function destroy(Response $response)
    {
        //
    }
}
