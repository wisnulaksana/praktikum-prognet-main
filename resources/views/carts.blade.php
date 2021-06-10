@extends('layouts/master')
@section('content')
<div class="banner-wrapper has_background">
    <div class="banner-wrapper-inner"> 
        <div role="navigation" aria-label="Breadcrumbs" class="breadcrumb-trail breadcrumbs container">
            <ul class="trail-items breadcrumb">
                <li class="trail-item trail-begin"><a href="/"><span>Home</span></a></li>
                <li class="trail-item trail-end active"><span>Cart</span>
                </li>
            </ul>
        </div>
    </div>
</div>
<main class="site-main main-container no-sidebar">
    <div class="container">
        <div class="row">
            <div class="main-content col-md-12">
                <div class="page-main-content">
                    <div class="BLitzz">
                        <div class="BLitzz-notices-wrapper"></div>
                        <div class="BLitzz-cart-form">
                            <table class="shop_table shop_table_responsive cart BLitzz-cart-form__contents"
                                cellspacing="0">
                                <thead>
                                    <tr>
                                        <th class="product-remove">&nbsp;</th>
                                        <th class="product-name">Product</th>
                                        <th class="product-price">Price</th>
                                        <th class="product-quantity">Quantity</th>
                                        <th class="product-quantity">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($carts as $cart)


                                    <tr class="BLitzz-cart-form__cart-item cart_item">
                                        <td class="product-remove">
                                            <form action="{{Route('delete',['cart'=>$cart->id])}}" method="post">
                                                @method('delete')
                                                @csrf
                                                <button type="submit" class="btn btn-danger"
                                                    aria-label="Remove this item" data-product_id="27"
                                                    data-product_sku="885B712"><i class="fa fa-trash"></i></button>
                                            </form>
                                        </td>
                                      
                                        <td class="product-name" data-title="Product">
                                            <a href="#">{{$cart->products->product_name}}</a></td>
                                        <td class="product-price" data-title="Price">
                                            <span class="BLitzz-Price-amount amount">
                                                @php
                                                $is_discount = false;
                                                @endphp
                                                @foreach ($cart->products->discounts as
                                                $discount)
                                                @if (date('Y-m-d') >= $discount->start
                                                && date('Y-m-d') < $discount->end)
                                                    @php
                                                    $diskon = ($discount->percentage /
                                                    100) * $cart->products->price;

                                                    @endphp
                                                    @if ($diskon)
                                                    @php
                                                    $is_discount = true;
                                                    @endphp
                                                    {{"Rp " . number_format($cart->products->price - $diskon,2,',','.')}}
                                                    <br>
                                                    @endif
                                                    @endif
                                                    @endforeach
                                                    @if ($is_discount)
                                                    <small><strike>{{ "Rp " . number_format($cart->products->price, 2, ',', '.')}}</strike></small>
                                                    @else
                                                    {{"Rp " . number_format($cart->products->price,2,',','.')}}
                                                    @endif
                                            </span></td>
                                        <td class="product-quantity" data-title="Quantity">
                                            <div class="quantity">
                                                <span class="qty-label">Quantiy:</span>
                                                <div class="control">
                                                    <div>
                                                        <input type="hidden" name="id[]" value="{{$cart->id}}">
                                                        <div data-min="1"
                                                            class="dec button btn-number qtyplus quantity-minus">-
                                                        </div>
                                                        <input type="text" class="incdec input-qty input-text"
                                                            name="qty[]" id="value{{$cart->id}}" value="{{$cart->qty}}"
                                                            data-price="@if($is_discount){{$cart->products->price - $diskon}}@else{{$cart->products->price}}@endif" />
                                                        <div class="inc button btn-number qtyplus quantity-plus"
                                                            data-max="{{$cart->products->stock}}">+</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="product-price" data-title="Price">
                                            <span class="BLitzz-Price-amount amount subtotal">
                                                @if($is_discount)
                                                {{"Rp " . number_format(($cart->products->price-$diskon)*$cart->qty,0,',','.')}}@else
                                                {{"Rp " . number_format($cart->products->price*$cart->qty,0,',','.')}}@endif

                                            </span></td>

                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="6" class="actions">
                                            <button type="button" id="submit" class="button" name="update_cart"
                                                value="Update cart">Update cart
                                            </button>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="cart-collaterals">
                            <div class="cart_totals ">
                                <h2>Cart totals</h2>
                                <table class="shop_table shop_table_responsive" cellspacing="0">
                                    <tbody>
                                        <tr class="order-total">
                                            <th>Total</th>
                                            <td data-title="Total">
                                                <strong><span class="BLitzz-Price-amount amount sub-total">
                                                        <span
                                                            class="BLitzz-Price-currencySymbol-totals">{{"Rp " . number_format($total,2,',','.')}}</span>
                                                    </span></strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>



                                <div class="BLitzz-proceed-to-checkout @if ($carts->count() < 1) d-none @endif">
                                    <a href="{{Route('checkout')}}" class="checkout-button button alt BLitzz-forward">
                                        Proceed to checkout</a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@section('scripts')
<script>
    $(document).on('click','#submit',function(){
    var qty = $('input[name="qty[]"]').map(function(){ 
                    return this.value; 
                }).get();

    var id = $('input[name="id[]"]').map(function(){ 
                    return this.value; 
                }).get();

		$.ajax({
			url: '{{Route("update-cart")}}',
			type: 'post',
            data: {
                        'qty[]': qty,
                        'id[]': id,
                        // other data
                    },
			success: function(data){
                loadcount();
                loadcarts();
                loadtotal();
                if (data == 'stok habis') {
                    toastr.error(data);
                }else{
                    toastr.info(data);
                }
               
			}
		});
	});
</script>
@endsection