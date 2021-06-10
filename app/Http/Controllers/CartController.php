<?php

namespace App\Http\Controllers;

use App\Models\Carts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $price = 0;
        $total = 0;
        $carts = Carts::where('user_id', "=", Auth::user()->id)->where('status', '=', 'notyet')->get();
        foreach ($carts as $cart) {
            foreach ($cart->products->discounts as $diskon) {

               if (date('Y-m-d') >= $diskon->start  &&  date('Y-m-d') < $diskon->end) {
                    $price = $cart->products->price - ($diskon->percentage / 100 * $cart->products->price);
                }
            }
            if ($price == 0) {
                $total = $total + ($cart->products->price * $cart->qty);
            } else {
                $total = $total + ($price * $cart->qty);
            }

            // dd($cart->qty);
        }


        if ($request->ajax()) {
            foreach ($carts as $cart) {
                $output = '<li class="BLitzz-mini-cart-item mini_cart_item">
            <a href="javascript:void(0)" data-id="' . $cart->id . '" class="delete remove remove_from_cart_button">×</a>
            <a href="#">
                <img src="assets/images/apro134-1-600x778.jpg"
                     class="attachment-BLitzz_thumbnail size-BLitzz_thumbnail"
                     alt="img" width="600" height="778">' . $cart->products->product_name . '</a>
            <span class="quantity">' . $cart->qty . ' × <span
                    class="BLitzz-Price-amount amount"><span
                    class="BLitzz-Price-currencySymbol">';
                $is_discount = false;
                foreach ($cart->products->discounts as $discount) {
                    if (date('Y-m-d') >= $discount->start  &&  date('Y-m-d') < $discount->end) {
                        $diskon =  ($discount->percentage / 100) * $cart->products->price;
                        if ($diskon) {
                            $is_discount = true;
                            $output .= " Rp " . number_format($cart->products->price - $diskon, 2, ',', '.');
                        }
                    }
                }
                if ($is_discount) {
                    $output .= "<small><strike> Rp " . number_format($cart->products->price, 2, ',', '.') . '</strike></small>';
                } else {
                    $output .= "Rp " . number_format($cart->products->price, 2, ',', '.') . '</span>';
                }

                $output .= '</li>';
                echo ($output);
            }
        } else {
            return view('carts', compact('carts', 'total'));
        }
    }


    public function count()
    {
        $data = Carts::join('products', 'carts.product_id', '=', 'products.id')
            ->where('user_id', "=", Auth::user()->id)
            ->where('status', '=', 'notyet')
            ->get()->count();
        return json_encode($data);
    }

    public function totalprice()
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
               
        }
        $output = ' <span class=" BLitzz-Price-currencySymbol" id="total">Rp ' . number_format($total, 2, ',', '.') . '</span>';
        echo ($output);
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
        $carts = new Carts;
        $checkCarts = $carts->where('user_id', '=', Auth::user()->id)
            ->where('product_id', '=', $request->id)
            ->where('status', '=', 'notyet')
            ->get()->first();

        if ($request->stock < 1) {
            echo 'stok habis';
        } else {
            if ($checkCarts) {

                if ($checkCarts->product_id == $request->id) {
                    $qty = $checkCarts->qty + 1;
                    Carts::where('user_id', '=', Auth::user()->id)
                        ->where('product_id', '=', $request->id)
                        ->where('status', '=', 'notyet')
                        ->update([
                            'qty' => $qty,
                        ]);
                }
            } else {
                $carts->product_id = $request->id;
                $carts->user_id  = Auth::user()->id;
                $carts->qty = 1;
                $carts->status = 'notyet';
                $carts->save();
            }
            echo 'Product Ditambahkan Ke Keranjang';
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Carts  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Carts $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Carts  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Carts $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Carts  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Carts $cart)
    {
        foreach ($request->id as $key => $value) {

            Carts::where('id', "=", $request->id[$key])->update([
                'qty' => $request->qty[$key],
            ]);
        }
        echo 'cart berhasil Diupdate';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Carts  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Carts $cart, Request $request)
    {
        if ($request->ajax()) {
            $cart = Carts::find($request->id);
            echo 'Produk Dihapus Dari Keranjang';
            $cart->delete();
        } else {
            $cart->delete();
            return redirect()->back()->with('error', 'Produk Dihapus Dari Keranjang');
        }
    }
}
