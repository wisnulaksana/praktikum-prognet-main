@extends('layouts/master')
@section('content')
<div class="banner-wrapper has_background">
    <img src="assets/images/slide35.png" class="img-responsive attachment-1920x447 size-1920x447" alt="img">
    <div class="banner-wrapper-inner">
        <h1 class="page-title container">Transaction</h1>
        <div role="navigation" aria-label="Breadcrumbs" class="breadcrumb-trail breadcrumbs container">
            <ul class="trail-items breadcrumb">
                <li class="trail-item trail-begin"><a href="/"><span>Home</span></a></li>
                <li class="trail-item trail-end active"><span>Transaction</span>
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
                        <form class="BLitzz-cart-form">
                            <table class="shop_table shop_table_responsive cart BLitzz-cart-form__contents"
                                cellspacing="0">
                                <thead>
                                    <tr>
                                        <th class="product-no">No</th>
                                        <th class="product-adress">Alamat</th>
                                        <th class="product-telp">Telepon</th>
                                        <th class="product-status">Status</th>
                                        <th class="product-subtotal">Total</th>
                                        <th class="product-action">action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($transaksis ->reverse() as $transaksi)

                                    <tr class="BLitzz-cart-form__cart-item cart_item">
                                        <td class="product-remove">
                                            {{$no++}}</td>
                                        <td class="address">
                                            <p>{{$transaksi->address}}</p></td>
                                        <td class="status">
                                            <p>{{$transaksi->telp}}</p></td>
                                        <td class="telp">
                                            <p>{{$transaksi->status}}</p>
                                        </td>

                                        <td class="product-subtotal">
                                            <span class="BLitzz-Price-amount amount">{{"Rp " . number_format($transaksi->total,2,',','.')}}</span></td>
                                        <td class="action text-center">
                                            <a href="{{Route('detail-transaksi',['transactions' => encrypt($transaksi->id) ])}}">Detail</a></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection