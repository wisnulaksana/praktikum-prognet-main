<header id="header" class="header style-04 header-dark sticky-top">
    @auth
    @if(!Auth::user()->email_verified_at)
    <div class="bg-unverif w-100 bg-danger p-4 m-0 text-center">
        <h4 class="p-0 m-0 text-white"> Email Anda Belum Tervirifikasi, jika anda belum menerima kode verifikasi klik <a
                class="verif" href="{{Route('send-email',['user'=>Auth::user()->id])}}"><u>disini</u></a> </h4>
    </div>
    @endif
    @endauth
    <div class="header-wrap-stick">
        <div class="header-position">
            <div class="header-nav">
                <div class="container">
                    <div class="BLitzz-menu-wapper"></div>
                    <div class="header-nav-inner">
                        <div class="header-logo-menu">
                            <div class="block-menu-bar">
                                <a class="menu-bar menu-toggle" href="#">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </a>
                            </div>
                            <div class="header-logo mt-2">
                                <a href="/"><img alt="BLitzz" src="/assets/images/logo-home.png" class="logo"></a>
                            </div>
                        </div>
                        <div class="box-header-nav menu-nocenter">
                            <ul id="menu-primary-menu"
                                class="clone-main-menu BLitzz-clone-mobile-menu BLitzz-nav main-menu">
                                <li id="menu-item-230"
                                    class="menu-item menu-item-type-post_type menu-item-object-megamenu menu-item-230 parent parent-megamenu item-megamenu menu-item-has-children">
                                    <a class="BLitzz-menu-item-title" title="Home" href="/">Home</a>

                                </li>
                                <li id="menu-item-238"
                                    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-238">
                                    <div class="header-control d-none d-lg-block">
                                        <div class="header-control-inner">
                                            <div class="meta-dreaming">

                                                <div class="menu-item block-user block-dreaming BLitzz-dropdown">
                                                    @guest
                                                    <a class="block-link" href="/login">
                                                        Login
                                                    </a>
                                                    @endguest
                                                    @guest
                                                    <a class="block-link" href="/register">
                                                        Register
                                                    </a>
                                                    @endguest
                                                    @auth
                                                    <a class="block-link" href="javascript:void(0)">
                                                        <figure class="profile-picture">
                                                            <img src="{{Auth::user()->image}}" alt="Joseph Doe"
                                                                class="rounded-circle"
                                                                data-lock-picture="{{Auth::user()->image}}" />
                                                        </figure>
                                                    </a>

                                                    <ul class="sub-menu">


                                                        <li
                                                            class="menu-item BLitzz-MyAccount-navigation-link BLitzz-MyAccount-navigation-link--orders">
                                                            <a href="{{Route('transaksi')}}">Transaction List</a>
                                                        </li>

                                                        <li
                                                            class="menu-item BLitzz-MyAccount-navigation-link BLitzz-MyAccount-navigation-link--edit-account">
                                                            <a href="{{Route('profile')}}">Account details</a>
                                                        </li>
                                                        <li
                                                            class="menu-item BLitzz-MyAccount-navigation-link BLitzz-MyAccount-navigation-link--customer-logout">
                                                            <a href="#" onclick="$('#form-logout').submit()">Logout</a>
                                                        </li>


                                                    </ul>

                                                </div>
                                                <div class="menu-item block-user block-dreaming BLitzz-dropdown pr-2">
                                                    <a class="block-link" href="javascript:void(0)">
                                                        <i class="fas fa-bell"></i>
                                                        <span class="count countnotif">0</span>
                                                    </a>
                                                    <ul class="sub-menu notif">
                                                        <form id="link-extra-info">
                                                            <input type="hidden" name="p" value="0">
                                                        </form>
                                                        <div class="notifi">
                                                            {{-- <span class=" text-center">Tidak ada notifikasi masuk</span> --}}
                                                        </div>
                                                        <div class="markall text-center">

                                                        </div>                                            

                                                    </ul>
                                                </div>
                                                <div
                                                    class="block-minicart block-dreaming BLitzz-mini-cart BLitzz-dropdown">
                                                    <div class="shopcart-dropdown block-cart-link"
                                                        data-BLitzz="BLitzz-dropdown">
                                                        <a class="block-link link-dropdown" href="{{Route('cart')}}">
                                                            <span class="flaticon-online-shopping-cart"></span>
                                                            <span class="count countcarts">{{$carts->count()}}</span>
                                                        </a>
                                                    </div>
                                                    <div class="widget BLitzz widget_shopping_cart">
                                                        <div class="widget_shopping_cart_content">
                                                            <h3 class="minicart-title">Your Cart<span
                                                                    class="countcarts minicart-number-items">{{$carts->count()}}</span>
                                                            </h3>
                                                            <ul class="BLitzz-mini-cart cart_list product_list_widget item-cart"
                                                                id="">
                                                                @foreach ($carts as $cart)

                                                                <li class="BLitzz-mini-cart-item mini_cart_item">
                                                                    <a href="javascript:void(0)" data-id="{{$cart->id}}"
                                                                        class="delete remove_from_cart_button">×</a>
                                                                    <a href="#">
                                                                        <img src="/assets/images/apro134-1-600x778.jpg"
                                                                            class="attachment-BLitzz_thumbnail size-BLitzz_thumbnail"
                                                                            alt="img" width="600"
                                                                            height="778">{{$cart->products->product_name}}&nbsp;
                                                                    </a>
                                                                    <span class="quantity">{{$cart->qty}} × <span
                                                                            class="BLitzz-Price-amount amount"><span
                                                                                class="BLitzz-Price-currencySymbol">
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
                                                                                    @endif
                                                                                    @endif
                                                                                    @endforeach
                                                                                    @if ($is_discount)
                                                                                    <small><strike>{{ "Rp " . number_format($cart->products->price, 2, ',', '.')}}</strike></small>
                                                                                    @else
                                                                                    {{"Rp " . number_format($cart->products->price,2,',','.')}}
                                                                                    @endif
                                                                            </span>
                                                                </li>

                                                                @endforeach
                                                            </ul>
                                                            <p class="BLitzz-mini-cart__total">
                                                                <strong>Subtotal:</strong>
                                                                <span class="BLitzz-Price-amount amount sub-total">
                                                                    <span
                                                                        class="BLitzz-Price-currencySymbol-totals">{{"Rp " . number_format($total,2,',','.')}}</span>
                                                                </span>
                                                            </p>
                                                            <p class="BLitzz-mini-cart__buttons buttons">
                                                                <a href="{{Route('cart')}}"
                                                                    class="@if($carts->count() < 1) w-100 @endif  button BLitzz-forward">Viewcart</a>
                                                                <a href="{{Route('checkout')}}"
                                                                    class="@if($carts->count() < 1) d-none @endif button checkout BLitzz-forward">Checkout</a>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endauth
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-mobile pr-4">
        <div class="header-mobile-left">
            <div class="block-menu-bar">
                <a class="menu-bar menu-toggle" href="#">
                    <span></span>
                    <span></span>
                    <span></span>
                </a>
            </div>


        </div>
        <div class="header-mobile-mid">
            <div class="header-logo">
                <a href="/"><img alt="BLitzz" src="/assets/images/logo.png" class="logo"></a></div>
        </div>
        <div class="header-mobile-right">
            <form id="form-logout" action="{{Route('logout')}}" method="post">
                @csrf
            </form>
            <div class="header-control-inner">
                <div class="meta-dreaming">
                    <div class="menu-item block-user block-dreaming BLitzz-dropdown">
                        @guest
                        <a href="/login">
                            Login
                        </a>
                        @endguest
                        @auth
                        <a class="block-link" href="javascript:void(0)">
                            <figure class="profile-picture">
                                <img src="{{Auth::user()->image}}" alt="User" class="rounded-circle"
                                    data-lock-picture="{{Auth::user()->image}}" />
                            </figure>
                        </a>
                        <ul class="sub-menu">
                            <li
                                class="menu-item BLitzz-MyAccount-navigation-link BLitzz-MyAccount-navigation-link--orders">
                                <a href="{{Route('transaksi')}}">Transaction List</a>
                            </li>

                            <li
                                class="menu-item BLitzz-MyAccount-navigation-link BLitzz-MyAccount-navigation-link--edit-account">
                                <a href="{{Route('profile')}}">Account details</a>
                            </li>
                            <li
                                class="menu-item BLitzz-MyAccount-navigation-link BLitzz-MyAccount-navigation-link--customer-logout">
                                <a href="#" onclick="$('#form-logout').submit()">Logout</a>
                            </li>


                        </ul>

                    </div>
                    <div class="menu-item block-user block-dreaming BLitzz-dropdown pr-2">
                        <a class="block-link" href="javascript:void(0)">
                            <i class="fas fa-bell"></i>
                            <span class="count countnotif">0</span>
                        </a>
                        <ul class="sub-menu notif">
                            <form id="link-extra-info">
                                <input type="hidden" name="p" value="0">
                            </form>
                            <div class="notifi">
                                {{-- <span class=" text-center">Tidak ada notifikasi masuk</span> --}}
                            </div>
                            <div class="markall text-center">

                            </div>                                            

                        </ul>
                    </div>
                    <div class="block-minicart block-dreaming BLitzz-mini-cart BLitzz-dropdown">
                        <div class="shopcart-dropdown block-cart-link" data-BLitzz="BLitzz-dropdown">
                            <a class="block-link link-dropdown" href="{{Route('cart')}}">
                                <span class="flaticon-online-shopping-cart"></span>
                                <span class="count countcarts">{{$carts->count()}}</span>
                            </a>
                        </div>
                        <div class="widget BLitzz widget_shopping_cart">
                            <div class="widget_shopping_cart_content">
                                <h3 class="minicart-title">Your Cart<span
                                        class="countcarts minicart-number-items">{{$carts->count()}}</span>
                                </h3>
                                <ul class="BLitzz-mini-cart cart_list product_list_widget item-cart" id="">
                                    @foreach ($carts as $cart)

                                    <li class="BLitzz-mini-cart-item mini_cart_item">
                                        <a href="javascript:void(0)" data-id="{{$cart->id}}"
                                            class="delete remove_from_cart_button">×</a>
                                        <a href="#">
                                            <img src="/assets/images/apro134-1-600x778.jpg"
                                                class="attachment-BLitzz_thumbnail size-BLitzz_thumbnail" alt="img"
                                                width="600" height="778">{{$cart->products->product_name}}&nbsp;
                                        </a>
                                        <span class="quantity">{{$cart->qty}} × <span
                                                class="BLitzz-Price-amount amount"><span
                                                    class="BLitzz-Price-currencySymbol">
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
                                                        @endif
                                                        @endif
                                                        @endforeach
                                                        @if ($is_discount)
                                                        <small><strike>{{ "Rp " . number_format($cart->products->price, 2, ',', '.')}}</strike></small>
                                                        @else
                                                        {{"Rp " . number_format($cart->products->price,2,',','.')}}
                                                        @endif
                                                </span>
                                    </li>

                                    @endforeach
                                </ul>
                                <p class="BLitzz-mini-cart__total"><strong>Subtotal:</strong>
                                    <span class="BLitzz-Price-amount amount sub-total">
                                        <span
                                            class="BLitzz-Price-currencySymbol-totals">{{"Rp " . number_format($total,2,',','.')}}</span>
                                    </span>
                                </p>
                                <p class="BLitzz-mini-cart__buttons buttons">
                                    <a href="{{Route('cart')}}"
                                        class="@if($carts->count() < 1) w-100 @endif button BLitzz-forward">Viewcart</a>
                                    <a href="{{Route('checkout')}}"
                                        class="@if($carts->count() < 1) d-none @endif button checkout BLitzz-forward">Checkout</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</header>