<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Carts;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $totalDsic = 0;
        $products = Products::paginate(8);
        $categories = Category::all();



        $price = 0;
        $total = 0;
        $carts = Carts::where('user_id', "=", Auth::user()->id ?? '')->where('status', '=', 'notyet')->get();
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
        }

        $data = '';
        if ($request->ajax()) {
            foreach ($products as $product) {


                $data .= '<div
                class="product-item col-lg-3 col-6 col-md-4 featured_products style-02 rows-space-30 post-34 product type-product status-publish has-post-thumbnail product_cat-light product_cat-new-arrivals product_tag-light product_tag-hat product_tag-sock first instock sale featured shipping-taxable product-type-grouped">
                <div class="product-inner tooltip-top">
                    <div class="product-thumb">
                        <a class="thumb-link" href="detail-product/' . $product->id . '" tabindex="0">';
                $Count = 0;
                foreach ($product->product_image as $image) {
                    $Count++;
                    if ($Count == 1) {
                        $data .= '<img class="img-responsive" src="' . $image->image . '"
                                alt="' . $product->product_name . '" width="270" height="350">';
                    }
                }
                $data .= '</a>
                        <div class="flash">
                            <span class="onnew"><span class="text">New</span></span></div>';

                foreach ($product->discounts as $discount) {
                    if (date('Y-m-d') >= $discount->start  &&  date('Y-m-d') < $discount->end) {
                        $totalDsic += ($discount->percentage / 100) * $product->price;

                        $data .= '<a href="detail-product/' . $product->id . '" class="button yith-wcqv-button">' . $discount->percentage . '%</a>';
                    }
                }

                $data .= ' </div>
                    <div class="product-info"> 
                    <div class="rating-wapper nostar">';

                if ($product->reviews->avg('rate')) {



                    for ($i = 0; $i < 5; $i++) {
                        if (floor($product->reviews->avg('rate')) - $i >= 1) {

                            $data .= ' <i class="fas fa-star text-warning"> </i>';
                        } elseif ($product->reviews->avg('rate') - $i > 0) {

                            $data .= ' <i class="fas fa-star-half-alt text-warning"> </i>';
                        } else {

                            $data .= ' <i class="far fa-star text-warning"> </i>';
                        }
                    }
                } else {
                    for ($i = 0; $i < 5; $i++) {
                        $data .= '<i class="far fa-star"> </i>';
                    }
                }
                $data .= '</div>
                        <h3 class="product-name product_title">
                            <a href="detail-product/' . $product->id . '" tabindex="0">' . $product->product_name . '</a>
                        </h3>';
                if ($product->stock < 1) {
                    $data .= '<p class="p-0 m-0">Out Of Stock</p>';
                } else {
                    $data .= '<p class="p-0 m-0">' . $product->stock . ' In Stock </p>';
                }
                $data .= '<span class="price"><span class="BLitzz-Price-amount amount"><span
                                    class="BLitzz-Price-currencySymbol"> ';

                // $data .="Rp " . number_format($product->price, 2, ',', '.');
                $is_discount = false;
                foreach ($product->discounts as $discount) {
                    if (date('Y-m-d') >= $discount->start  &&  date('Y-m-d') < $discount->end) {
                        $diskon =  ($discount->percentage / 100) * $product->price;
                        if ($diskon) {

                            $is_discount = true;
                            $data .= " Rp " . number_format($product->price - $diskon, 2, ',', '.');
                        }
                    }
                }
                if ($is_discount) {
                    $data .= "<small><strike> Rp " . number_format($product->price, 2, ',', '.') . '</strike></small>';
                } else {
                    $data .= " Rp " . number_format($product->price, 2, ',', '.');
                }
                $data .= '</span>
                    </div>
                    <div class="group-button clearfix">
    
                        <div class="add-to-cart">
                            <a href="javascript:void(0)" data-id="' . $product->id . '"
                                data-stock="' . $product->stock . '" class="btn-add button product_type_grouped">
                                add to cart products</a></div>
    
                    </div>
                </div>
            </div>';
            }
            return $data;
        }

        //  dd($carts);
        return view('index', compact('products', 'categories', 'carts', 'total'));
    }


    public function categoryFilter(Request $request)
    {
        if ($request->id == null) {
            $products = Products::get();
        } else {
            $value = $request->id;
            $products = Products::whereHas('product_category_detail', function ($query) use ($value) {
                return $query->where('category_id', '=',  $value);
            })->get();
        }
        $data = '';
        if ($request->ajax()) {
            foreach ($products as $product) {
                $data .= '<div
                class="product-item col-lg-3 col-6 col-md-4 featured_products style-02 rows-space-30 post-34 product type-product status-publish has-post-thumbnail product_cat-light product_cat-new-arrivals product_tag-light product_tag-hat product_tag-sock first instock sale featured shipping-taxable product-type-grouped">
                <div class="product-inner tooltip-top">
                    <div class="product-thumb">
                    <a class="thumb-link" href="detail-product/' . $product->id . '" tabindex="0">';
                $Count = 0;
                foreach ($product->product_image as $image) {
                    $Count++;
                    if ($Count == 1) {
                        $data .= '<img class="img-responsive" src="' . $image->image . '"
                            alt="' . $product->product_name . '" width="270" height="350">';
                    }
                }
                $data .= '</a>
                        <div class="flash">
                            <span class="onnew"><span class="text">New</span></span></div>';

                foreach ($product->discounts as $discount) {
                    if (date('Y-m-d') >= $discount->start  &&  date('Y-m-d') < $discount->end) {
                        $data .= '<a href="detail-product/' . $product->id . '" class="button yith-wcqv-button">' . $discount->percentage . '%</a>';
                    }
                }

                $data .= ' </div>
                    <div class="product-info">
                    <div class="rating-wapper nostar">';

                if ($product->reviews->avg('rate')) {

                    for ($i = 0; $i < 5; $i++) {
                        if (floor($product->reviews->avg('rate')) - $i >= 1) {

                            $data .= ' <i class="fas fa-star text-warning"> </i>';
                        } elseif ($product->reviews->avg('rate') - $i > 0) {

                            $data .= ' <i class="fas fa-star-half-alt text-warning"> </i>';
                        } else {

                            $data .= ' <i class="far fa-star text-warning"> </i>';
                        }
                    }
                } else {
                    for ($i = 0; $i < 5; $i++) {
                        $data .= '<i class="far fa-star"> </i>';
                    }
                }
                $data .= '</div>
                        <h3 class="product-name product_title">
                            <a href="detail-product/' . $product->id . '" tabindex="0">' . $product->product_name . '</a>
                        </h3>';
                if ($product->stock < 1) {
                    $data .= '<p class="p-0 m-0">Out Of Stock</p>';
                } else {
                    $data .= '<p class="p-0 m-0">' . $product->stock . ' In Stock </p>';
                }
                $data .= '<span class="price"><span class="BLitzz-Price-amount amount"><span
                                    class="BLitzz-Price-currencySymbol"> ';

                // $data .="Rp " . number_format($product->price, 2, ',', '.');

                $is_discount = false;
                foreach ($product->discounts as $discount) {
                    if (date('Y-m-d') >= $discount->start  &&  date('Y-m-d') < $discount->end) {
                        $diskon =  ($discount->percentage / 100) * $product->price;
                        if ($diskon) {
                            $is_discount = true;
                            $data .= " Rp " . number_format($product->price - $diskon, 2, ',', '.');
                        }
                    }
                }
                if ($is_discount) {
                    $data .= "<small><strike> Rp " . number_format($product->price, 2, ',', '.') . '</strike></small>';
                } else {
                    $data .= " Rp " . number_format($product->price, 2, ',', '.');
                }

                $data .= '</span>
                    </div>
                    <div class="group-button clearfix">
    
                        <div class="add-to-cart">
                            <a href="javascript:void(0)" data-id="' . $product->id . '"
                                data-stock="' . $product->stock . '" class="btn-add button product_type_grouped">
                                add to cart products</a></div>
    
                    </div>
                </div>
            </div>';
            }

            return $data;
        }
    }
    public function searchFilter(Request $request)
    {

        if ($request->value == null) {
            $products = Products::get();
        } else {
            $products = Products::where('products.product_name', 'LIKE', '%' . $request->value . '%')->get();
        }
        $data = '';
        if ($request->ajax()) {
            foreach ($products as $product) {
                $data .= '<div
                class="product-item col-lg-3 col-6 col-md-4 featured_products style-02 rows-space-30 post-34 product type-product status-publish has-post-thumbnail product_cat-light product_cat-new-arrivals product_tag-light product_tag-hat product_tag-sock first instock sale featured shipping-taxable product-type-grouped">
                <div class="product-inner tooltip-top">
                    <div class="product-thumb">
                    <a class="thumb-link" href="detail-product/' . $product->id . '" tabindex="0">';
                $Count = 0;
                foreach ($product->product_image as $image) {
                    $Count++;
                    if ($Count == 1) {
                        $data .= '<img class="img-responsive" src="' . $image->image . '"
                            alt="' . $product->product_name . '" width="270" height="350">';
                    }
                }
                $data .= '</a>
                        <div class="flash">
                            <span class="onnew"><span class="text">New</span></span></div>';

                foreach ($product->discounts as $discount) {
                    if (date('Y-m-d') >= $discount->start  &&  date('Y-m-d') < $discount->end) {
                        $data .= '<a href="detail-product/' . $product->id . '" class="button yith-wcqv-button">' . $discount->percentage . '%</a>';
                    }
                }
                $data .= ' </div>
                    <div class="product-info">
                    <div class="rating-wapper nostar">';

                if ($product->reviews->avg('rate')) {

                    for ($i = 0; $i < 5; $i++) {
                        if (floor($product->reviews->avg('rate')) - $i >= 1) {

                            $data .= ' <i class="fas fa-star text-warning"> </i>';
                        } elseif ($product->reviews->avg('rate') - $i > 0) {

                            $data .= ' <i class="fas fa-star-half-alt text-warning"> </i>';
                        } else {

                            $data .= ' <i class="far fa-star text-warning"> </i>';
                        }
                    }
                } else {
                    for ($i = 0; $i < 5; $i++) {
                        $data .= '<i class="far fa-star"> </i>';
                    }
                }
                $data .= '</div>
                        <h3 class="product-name product_title">
                            <a href="detail-product/' . $product->id . '" tabindex="0">' . $product->product_name . '</a>
                        </h3>';
                if ($product->stock < 1) {
                    $data .= '<p class="p-0 m-0">Out Of Stock</p>';
                } else {
                    $data .= '<p class="p-0 m-0">' . $product->stock . ' In Stock </p>';
                }
                $data .= '<span class="price"><span class="BLitzz-Price-amount amount"><span
                                    class="BLitzz-Price-currencySymbol"> ';

                // $data .="Rp " . number_format($product->price, 2, ',', '.');

                $is_discount = false;
                foreach ($product->discounts as $discount) {
                    if (date('Y-m-d') >= $discount->start  &&  date('Y-m-d') < $discount->end) {
                        $diskon =  ($discount->percentage / 100) * $product->price;
                        if ($diskon) {
                            $is_discount = true;
                            $data .= " Rp " . number_format($product->price - $diskon, 2, ',', '.');
                        }
                    }
                }
                if ($is_discount) {
                    $data .= "<small><strike> Rp " . number_format($product->price, 2, ',', '.') . '</strike></small>';
                } else {
                    $data .= " Rp " . number_format($product->price, 2, ',', '.');
                }


                $data .= '</span>
                    </div>
                    <div class="group-button clearfix">
    
                        <div class="add-to-cart">
                            <a href="javascript:void(0)" data-id="' . $product->id . '"
                                data-stock="' . $product->stock . '" class="btn-add button product_type_grouped">
                                add to cart products</a></div>
    
                    </div>
                </div>
            </div>';
            }
            return $data;
        }
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
        if (Auth::user()->email_verified_at) {
            $carts = new Carts;
            if ($request->qty < 1) {
                return redirect()->back()->with('error', 'pembelian minimal 1 product');
            } else {
                $carts->product_id = $request->id;
                $carts->user_id  = Auth::user()->id ?? '';
                $carts->qty = $request->qty;
                $carts->status = 'notyet';
                $carts->save();
                return redirect('checkout');
            }
        } else {
            return redirect()->back()->with('warning', 'Email Belun Terverifikasi, silahkan verifikasi email terlebihdahulu');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function show(Products $products,Request $request)
    {
        $notificationId = $request->p;
            if (Auth::user()) {
            $userUnreadNotification = auth()->user()
                ->unreadNotifications->where('id', $notificationId)->first();
        // dd($notificationId);
        if ($userUnreadNotification) {
            $userUnreadNotification->update(['read_at' => now()]);
        }
    }
        $categories = Category::all();
        $price = 0;
        $total = 0;
        $carts = Carts::where('user_id', "=", Auth::user()->id ?? '')->where('status', '=', 'notyet')->get();
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
        }


        return view('detail-product', compact('products', 'carts', 'total'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function edit(Products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Products $products)
    {
        //
    }
    public function counttotal()
    {
        $myarray['count'] = Auth()->user()->unreadNotifications->count();
        $myarray['list'] = Auth()->user()->unreadNotifications;

        return json_encode($myarray);
    }

    public function MarkAllRead()
    {
        $user = User::find(Auth::user()->id);
        $user->unreadNotifications()->update(['read_at' => now()]);
        return redirect()->back();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy(Products $products)
    {
        //
    }
}
