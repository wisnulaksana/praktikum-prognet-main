<?php

namespace App\Http\Controllers\Admin;


use App\Models\Couriers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CouriersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $couriers = Couriers::all();
        return view('admin/couriers/index',compact('couriers'));
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
        $couriers = $request->all();
        $couriers['code'] = strtolower($request->courier);
        Couriers::create($couriers);
        return redirect()->back()->with('success','Berhasil Menambahkan Kurir');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Couriers  $couriers
     * @return \Illuminate\Http\Response
     */
    public function show(Couriers $couriers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Couriers  $couriers
     * @return \Illuminate\Http\Response
     */
    public function edit(Couriers $couriers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Couriers  $couriers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Couriers $couriers)
    {
        $courier = $request->all();
        $courier['code'] = strtolower($request->courier);
      $couriers->update($courier);
        return redirect()->back()->with('info','Berhasil Mengupdate Kurir');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Couriers  $couriers
     * @return \Illuminate\Http\Response
     */
    public function destroy(Couriers $couriers)
    {
        $couriers->delete();
        return redirect()->back()->with('error','Data Telah Dihapus');
        
    }
}
