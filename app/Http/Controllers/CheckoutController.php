<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Couriers;
use App\Models\Provinces;
use App\Models\Cities;
use App\Models\Carts;
use App\Models\Transactions;
use App\Models\TransactionDetails;
use App\Notifications\AdminNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;



use Kavist\RajaOngkir\Facades\RajaOngkir;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $provinsis = Provinces::all();
        $kurirs = Couriers::all();

        $price = 0;
        $total = 0;
        $berattotal = 0;
        $subprice = 0;
        $carts = Carts::where('user_id', "=", Auth::user()->id)->where('status', '=', 'notyet')->get();
        foreach ($carts as $cart) {
            foreach ($cart->products->discounts as $diskon) {

                if (date('Y-m-d') >= $diskon->start  &&  date('Y-m-d') < $diskon->end) {
                     $price = $cart->products->price - ($diskon->percentage / 100 * $cart->products->price);
                     $total += $price*$cart->qty;
                 }else{
                     $total += $cart->products->price * $cart->qty;
                 }
 
             }
             if ($price == 0) {
                $total += $cart->products->price * $cart->qty;
             }
            $berattotal = $berattotal + ($cart->products->weight * $cart->qty);
            $subprice = $subprice + ($cart->products->price * $cart->qty);

            // dd($cart->qty);
        }
        // dd($carts);
        return view('checkout', compact('provinsis', 'kurirs', 'carts', 'total', 'berattotal', 'subprice'));
    }
    public function getkota(Request $request)
    {
        $kota = Cities::where('province_id', '=', $request->id)->get();
        $sen = $kota->toArray();
        return response()->json([
            'status' => true,
            'kota' => $sen
        ], 200);
    }
    
    public function cekongkir(Request $request)
    {
        $asal = Cities::where('city_id', '128')->get()->first();
        $cost = RajaOngkir::ongkosKirim([
            'origin'        => $asal->city_id,     // ID kota/kabupaten asal
            'destination'   => $request->kota,      // ID kota/kabupaten tujuan
            'weight'        => $request->berat,    // berat barang dalam gram
            'courier'       => $request->kurir    // kode kurir pengiriman: ['jne', 'tiki', 'pos'] untuk starter
        ])->get();
        return response()->json($cost);
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
        $price = 0;
        $total = 0;
        $carts = Carts::where('user_id', "=", Auth::user()->id)->where('status', '=', 'notyet')->get();
        foreach ($carts as $cart) {
            foreach ($cart->products->discounts as $diskon) {

                if (date('Y-m-d') >= $diskon->start  &&  date('Y-m-d') < $diskon->end) {
                     $price = $cart->products->price - ($diskon->percentage / 100 * $cart->products->price);
                     $total += $price*$cart->qty;
                 }else{
                     $total += $cart->products->price * $cart->qty;
                 }
 
             }
          
             if ($price == 0) {
                $total += $cart->products->price * $cart->qty;
            }

            // dd($cart->qty);
        }

   
    
        $transaksi = new Transactions;

        $datetime = strtotime("+1 day");
        $tomorrowDate = date("Y-m-d H:i:s", $datetime);
        $transaksaction = $request->all();
        $transaksaction['timeout'] = $tomorrowDate;
        $transaksaction['total'] =  $request->shipping_cost + $total;
        $transaksaction['sub_total'] = $total;
        $transaksaction['user_id'] = Auth::user()->id;
        $transaksaction['status'] = 'unverified';
        $transaksaction['telp'] = $request->telp;
        // dd($transaksaction);
        $validator = Validator::make($transaksaction, [
        'province'      => 'required',
        'regency'  => 'required',
        'address'  => 'required',
        'courier_id'  => 'required',
        'shipping_cost'  => 'required',
        'telp'  => 'required|numeric',
        'total'  => 'required|numeric|not_in:0',
        'sub_total'  => 'required|numeric|not_in:0',
    ],
    ['sub_total.required' => 'Minimal 1 Barang di keranjang untuk melakukan checkout',
    'sub_total.numeric' => 'Minimal 1 Barang di keranjang untuk melakukan checkout',
    'sub_total.not_in' => 'Minimal 1 Barang di keranjang untuk melakukan checkout',
    'total.required'  => 'Minimal 1 Barang di keranjang untuk melakukan checkout',
    'total.numeric'  => 'Minimal 1 Barang di keranjang untuk melakukan checkout',
    'total.not_in'  => 'Minimal 1 Barang di keranjang untuk melakukan checkout',
    
    ]);
    // dd($request->harga_diskon);
    if ($validator->fails()) {
        return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
    }

       // proses data apabila sudah diinput
       if ($request->telp) {
        // mengambil nomor handphone telah diinput
        $handphone = $request->telp;
        // validasi inputan nomor handphone
        if (!preg_match("/^[0-9|(\+|)]*$/", $handphone) OR strlen(strpos($handphone, "+", 1)) > 0) {
            return redirect()->back()->with('false','Handphone hanya boleh menggunakan angka dan diawali simbol +');
        }
        else if (substr($handphone, 0, 3) != "+62" ) {
             return redirect()->back()->with('false','Handphone harus diawali dengan kode negara +62');
        }
        else if (substr($handphone, 3, 1) == "0" ) {
            return redirect()->back()->with('false','Handphone tidak boleh diikuti dengan angka 0 setelah kode negara');
        }
        else {
            $idtransaksi = $transaksi->create($transaksaction);
        }                
    }
        
        foreach ($carts as $key => $value) {
    // echo($request->harga_diskon[$key]);
          
            $idtransaksidetail = TransactionDetails::create([
                'transaction_id' => $idtransaksi->id,
                'product_id' => $value->product_id,
                'qty' => $value->qty,
                'discount' => $request->diskon[$key],
                'selling_price' => $request->harga_diskon[$key],
            ]);

            Carts::where('user_id', "=", Auth::user()->id)->update([
                'status' => 'checkedout',
            ]);
        // dd($idtransaksidetail);

        }
        $admin = Admin::whereIn('role', ['super admin'])->get();
        // dd($admin);

        $notif = "<a class='dropdown-item submit-form' data-submits='' href='/admin/transaksi/show/" . $idtransaksi->id . "'>" .
            "<div class='item-content flex-grow'>" .
            "<h6 class='ellipsis font-weight-normal'>" . Auth::user()->name . "</h6>" .
            "<p class='font-weight-light small-text text-muted mb-0'>Transaksi Baru Telah Dibuat" .
            "</p>" .
            "</div>" .
            "</a>";
        // $admin->notify(new AdminNotification(['role'=>'super admin'],$notif));
        Notification::send($admin, new AdminNotification($notif)); // multiple notification
        return redirect(Route('detail-transaksi', ['transactions' => encrypt($idtransaksi->id)]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
