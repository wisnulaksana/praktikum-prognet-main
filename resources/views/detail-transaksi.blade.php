@extends('layouts/master')
@section('content')

<main class="site-main main-container no-sidebar">
    <div class="container">
        <div class="bayar">
            <h1 class="text-center text-primary font-weight-bolder">
                {{"Rp " . number_format($transaksi->total,2,',','.')}}
                <br>
                <small>Transfer To : 0988465775</small>
                <hr>
            </h1>
        </div>
        <div class="time text-center">
            @if ($transaksi->status == 'canceled')
            <h2>Transaksi Dibatalkan</h2>
            @elseif ($transaksi->status == 'verified')
            <h2>Transaksi Terverifikasi, Barang Akan Segera Dikirim</h2>
            @elseif ($transaksi->proof_of_payment && $transaksi->status == 'delivered')
            <h2> Barang Sudah Dikirim</h2>
            <form action="{{Route('verif-barang-diterima',['transactions' => $transaksi->id])}}" method="POST"
                enctype="multipart/form-data">
                @method('put')
                @csrf
                <button type="submit">Konfirmasi Barang Diterima</button>
            </form>
            @elseif ($transaksi->status == 'success')
            <h2> Barang Sudah Diterima, Transaksi Success</h2>
            @elseif ($transaksi->status == 'expired')
            <h2> TRANSAKSI EXPIRED</h2>
            @else
            @if (!$transaksi->proof_of_payment && $transaksi->status == 'unverified'|| $transaksi->status == 'failed')
            <div id="countdown"> </div>
            <form action="{{Route('cancel',['transactions' => $transaksi->id])}}" method="POST"
                enctype="multipart/form-data">
                @method('put')
                @csrf
                <button type="submit" onclick="return confirm('Yakin ingin Membatalkan Pesanan?')">Cancel Transaction</button>
            </form>
            @else
            <h2>Bukti Pembayaran Diterima, silahkan tunggu admin memverifikasi bukti pembayaran</h2>
            @endif
            @endif

        </div>

        <div class="row pt-5">
            @if ($transaksi->status == 'unverified' && $transaksi->proof_of_payment == null || $transaksi->status ==
            'failed' )

            <div class="main-content col-md-6">

                <div class="col2-set w-100" id="customer_details">
                    <div class="col-1">
                        <div class="BLitzz-billing-fields">
                            <h3>Upload Bukti Bayar</h3>
                            <div class="BLitzz-billing-fields__field-wrapper">
                                <form action="{{Route('upload-bukti',['transactions' => $transaksi->id])}}"
                                    method="POST" enctype="multipart/form-data">
                                    @method('put')
                                    @csrf
                                    <p class="form-row form-row-wide bukti-field validate-required form-group"
                                        id="billing_bukti_1_field" data-priority="50"><label for="billing_bukti_1"
                                            class="">Bukti Pembayaran&nbsp;<abbr class="required"
                                                title="required">*</abbr></label><span
                                            class="BLitzz-input-wrapper">
                                            <img id="blah" style="width: 100%; height:300px; border-radius:5px;"
                                    src="{{$transaksi->id}}" alt="-" class="p-3" />
                                            <input type="file" id="imgInp"
                                                class="input-name form-control" name="proof_of_payment"
                                                id="billing_bukti_1" placeholder="bukti Lengkap" value=""
                                                autocomplete="bukti-line1" data-placeholder="bukti Lengkap"></span>
                                    </p>
                                    <button type="submit" class="button alt" id="submit" value="submit"
                                        data-value="Submit">Submit
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            @endif
            <div
                class="main-content @if($transaksi->status == 'unverified' && $transaksi->proof_of_payment == null || $transaksi->status == 'failed') col-md-6 @else col-md-12 @endif">
                <div class="page-main-content">
                    <div class="BLitzz">
                        <div class="BLitzz-notices-wrapper"></div>
                        <form class="BLitzz-cart-form">
                            <table class="shop_table shop_table_responsive cart BLitzz-cart-form__contents"
                                cellspacing="0">
                                <thead>
                                    <tr>
                                        <th class="product-name">Nama</th>
                                        <th class="product-adress">Price</th>
                                        <th class="product-qty">qty</th>
                                        @if ($transaksi->status == 'success')
                                        <th class="product-action">action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $no = 1;
                                    @endphp
                                    @foreach ($transaksidetails as $item)

                                    <tr class="BLitzz-cart-form__cart-item cart_item">
                                        <td class="name">
                                            <p>{{$item->product->product_name}}</p></td>
                                        <td class="prices">
                                            <p>{{"Rp " . number_format($item->price,2,',','.')}}</p>
                                        </td>
                                        <td class="qty  text-center">
                                            <p>{{$item->quantity}}</p></td>
                                        @if ($transaksi->status == 'success')
                                        <td class="product-action text-center"> <button type="button"
                                                data-id="{{$item->product->id}}" class="btn btn-primary review"
                                                data-toggle="modal" data-target="#ModalLoginForm">
                                                review
                                            </button></td>
                                        @endif

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </form>
                        <div class="cart_totals pt-5">
                            <h2>totals</h2>
                            <table class="shop_table shop_table_responsive" cellspacing="0">
                                <tbody>
                                    <tr class="cart-subtotal">
                                        <th>Subtotal</th>
                                        <td data-title="Subtotal"><span class="BLitzz-Price-amount amount"><span
                                                    class="BLitzz-Price-currencySymbol">{{"Rp " . number_format($transaksi->sub_total,2,',','.')}}</span>
                                        </td>
                                    </tr>
                                    <tr class="cart-shipng">
                                        <th>Ongkos Kirim</th>
                                        <td data-title="shipig"><span class="BLitzz-Price-amount amount"><span
                                                    class="BLitzz-Price-currencySymbol">{{"Rp " . number_format($transaksi->shipping_cost,2,',','.')}}</span>
                                        </td>
                                    </tr>
                                    <tr class="order-total">
                                        <th>Total</th>
                                        <td data-title="Total"><strong><span class="BLitzz-Price-amount amount"><span
                                                        class="BLitzz-Price-currencySymbol">{{"Rp " . number_format($transaksi->total,2,',','.')}}</span></strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>
<div id="ModalLoginForm" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title">Berikan Ulasan</h1>
            </div>
            <div class="modal-body">
                <h4 for="Rating" class="text-center">Rating</h4>
                <div class="form-group row col-lg-4 col-12 mx-auto ">

                    <select class="star-rating" id="rate" name="rate">
                        <option value="">Select a rating</option>
                        <option value="5">Excellent</option>
                        <option value="4">Very Good</option>
                        <option value="3">Average</option>
                        <option value="2">Poor</option>
                        <option value="1">Terrible</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="ulasan">Ulasan</label>
                    <textarea class="form-control" name="content" id="content" cols="5" rows="5"></textarea>

                </div>
                <button type="button" id="btn-submit" data-id="">Submit</button>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection
@section('scripts')
<script>
    var starrating = new StarRating('.star-rating',{
            classNames: {
        active: "gl-active",
        base: "gl-star-rating",
        selected: "gl-selected",
    },
            clearable: true,
    maxStars: 10,
    stars: null,
    tooltip: 'Select a Rating',
         });

         $(document).on('click','.review', function () {
      var id = $(this).data('id');
      console.log(id);
      $('#btn-submit').attr('data-id', id);
    });

    function resetMyForm(){
        starrating.rebuild();
        destroyed = false;
        $('span.gl-star-rating--stars').removeAttr('class').addClass('gl-star-rating--stars s0');
        $('span.gl-star-rating--stars').removeAttr('aria-label').attr('aria-label','Select a Rating');
		$('textarea').val(''); 
}
    $('#btn-submit').click(function(){
		var id = $(this).attr('data-id');
		var rate = $('#rate').val();
		var content = $('#content').val();
		$.ajax({
			url: '{{Route("store-review")}}',
			type: 'post',
			data: {id: id, rate : rate,content : content},
			success: function(data){
				 $('#ModalLoginForm').modal('hide');
                 toastr.success(data);
                    resetMyForm();
                   

        console.log('berhasil memasukan ulasan');
            
			}
		});
	});
    @if(!$transaksi->proof_of_payment && $transaksi->status == 'unverified' || $transaksi->status == 'failed')
         CountDownTimer('{{$transaksi->created_at}}', 'countdown');
    function CountDownTimer(dt, id)
    {
        var end = new Date('{{$transaksi->timeout}}');
        var _second = 1000;
        var _minute = _second * 60;
        var _hour = _minute * 60;
        var _day = _hour * 24;
        var timer;
        function showRemaining() {
            var now = new Date();
            var distance = end - now;
            if (distance < 0) {

                clearInterval(timer);

                return;
            }
            var days = Math.floor(distance / _day);
            var hours = Math.floor((distance % _day) / _hour);
            var minutes = Math.floor((distance % _hour) / _minute);
            var seconds = Math.floor((distance % _minute) / _second);

            document.getElementById(id).innerHTML = days + ' days ';
            document.getElementById(id).innerHTML += hours + ' hrs ';
            document.getElementById(id).innerHTML += minutes + ' mins ';
            document.getElementById(id).innerHTML += seconds + ' secs';
            document.getElementById(id).innerHTML +=@if($transaksi->status == 'failed')'<h2>Bukti Pembayaran Tidak dapat di verifikasi, silahkan upload kembali bukti pembayaran</h2>'@else '<h2>BATAS WAKTU PEMBAYARAN</h2>' @endif;
        }
        timer = setInterval(showRemaining, 1000);
    }
    @endif

    function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    
    reader.onload = function(e) {
      $('#blah').attr('src', e.target.result);
    }
    
    reader.readAsDataURL(input.files[0]); // convert to base64 string
  }
}

$("#imgInp").change(function() {
  readURL(this);
})
</script>
@endsection