<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/x-icon" href="/assets/images/favicon.png" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i&amp;display=swap"
        rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="/assets/css/animate.css" />
    <link rel="stylesheet" type="text/css" href="/assets/css/chosen.min.css" />
    <link rel="stylesheet" type="text/css" href="/assets/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
    <link rel="stylesheet" type="text/css" href="/assets/css/jquery.scrollbar.css" />
    <link rel="stylesheet" type="text/css" href="/assets/css/lightbox.min.css" />
    <link rel="stylesheet" type="text/css" href="/assets/css/magnific-popup.css" />
    <link rel="stylesheet" type="text/css" href="/assets/css/slick.min.css" />
    <link rel="stylesheet" type="text/css" href="/assets/fonts/flaticon.css" />
    <link rel="stylesheet" type="text/css" href="/assets/css/megamenu.css" />
    <link rel="stylesheet" type="text/css" href="/assets/css/dreaming-attribute.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="/assets/css/star-rating.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css" />
    <title>Home</title>
</head>

<body>
    @include('layouts/navigations')
    @yield('content')
</div>
    <script src="/assets/js/jquery-1.12.4.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/chosen.min.js"></script>
    <script src="/assets/js/countdown.min.js"></script>
    <script src="/assets/js/jquery.scrollbar.min.js"></script>
    <script src="/assets/js/lightbox.min.js"></script>
    <script src="/assets/js/magnific-popup.min.js"></script>
    <script src="/assets/js/slick.js"></script>
    <script src="/assets/js/jquery.zoom.min.js"></script>
    <script src="/assets/js/threesixty.min.js"></script>
    <script src="/assets/js/jquery-ui.min.js"></script>
    <script src="/assets/js/mobilemenu.js"></script>
    <script src="/assets/js/autoNumeric.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="/assets/js/star-rating.js"></script>
    @yield('scripts')
    <script>
  
    
        @if ($message = Session::get('error'))
        toastr.error('{{ session('error') }}');
        @elseif ($message = Session::get('warning'))
        toastr.warning('{{ session('warning') }}');
        @elseif ($message = Session::get('success'))
        toastr.success('{{ session('success') }}');
    @endif
            $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

    loadnotif();
function loadnotif(){
        $.ajax({
                url: '{{Route("count-notif")}}',
                type: 'get',
                success: function(data){
                    var responsedata = $.parseJSON(data);
                    var count = '0';
                    $('.count.countnotif').html(responsedata.count);

                    
                    jQuery.each(responsedata.list, function(index, value){
                        count ++;
                        $('ul.sub-menu.notif .notifi').append('<li class="listnotif" class="menu-item BLitzz-MyAccount-navigation-link BLitzz-MyAccount-navigation-link--dashboard is-active">'+value.data+'<hr> </li>');
                        if(index == 0){
                        $('a.submit-form').attr('data-submits',value.id);     
                    }else{
                        $('a.submit-form').eq(index).attr('data-submits',value.id);     

                    }
                        $('.markall').html('<a href = "/marksallread">Tandai Semua Pesan Terbaca</a>');
                    });
                }
        });
    }
        function loadcarts(){
        var html_option = '';
        $.ajax({
                url: '{{Route("cart")}}',
                type: 'get',
                success :'success',
                success: function(data){
                    html_option += data;
            $('.item-cart').html(html_option);

                }
            });
    }

    function loadcount(){
        $.ajax({
                url: '{{Route("count-cart")}}',
                type: 'get',
                success: function(data){
                    $('.countcarts').html(data);
                    if (data < 1) {
                        $('a.button.BLitzz-forward').addClass('w-100')
                        $('a.button.checkout.BLitzz-forward').addClass('d-none')
                    }else{
                        $('a.button.BLitzz-forward').removeClass('w-100')
                        $('a.button.checkout.BLitzz-forward').removeClass('d-none')
                    }
                }
            });
    }

    function loadtotal(){
        $.ajax({
                url: '{{Route("total-cart")}}',
                type: 'get',
                success: function(data){
                    $('span .BLitzz-Price-currencySymbol-totals').html(data);
                }
            });
    }


  

                $(document).on('click','.btn-add',function(){
                    @guest
                    toastr.warning('Silahkan Login terlebih Dahulu');
                    @endguest
                    @auth
                    @if(!Auth::user()->email_verified_at)
                    toastr.warning('Email Anda Belum Terverifikasi, silahkan verifikasi email terlebih dahulu');
                    @else
            var id = $(this).data('id');
            var stock = $(this).data('stock');
            $.ajax({
                url: '{{Route("add-cart")}}',
                type: 'post',
                data: {id: id,stock : stock},
                success: function(data){
                    loadcount();
                    loadcarts();
                    loadtotal();
                    
                    if (data == 'stok habis') {
                        toastr.error(data);
                    }else{
                        toastr.success(data);
                    } 
                }

            });
            @endif
            @endauth
        });

        $(document).on('click','.delete',function(){
            var id = $(this).data('id');
            $.ajax({
                url: '{{Route("delete-cart")}}',
                type: 'delete',
                data: {id: id},
                success: function(data){
                    loadcount();
                    loadcarts();
                    loadtotal();
                    toastr.error(data);
                }
            });
        });
    </script>

    <script>
        var price;
    var qty;
    var total;

        var format = function(num){
        var str = num.toString().replace("", ""), parts = false, output = [], i = 1, formatted = null;
        if(str.indexOf(".") > 0) {
            parts = str.split(".");
            str = parts[0];
        }
        str = str.split("").reverse();
        for(var j = 0, len = str.length; j < len; j++) {
            if(str[j] != ".") {
            output.push(str[j]);
            if(i%3 == 0 && j < (len - 1)) {
                output.push(".");
            }
            i++;
            }
        }
        formatted = output.reverse().join("");
        return("" + formatted + ((parts) ? "." + parts[1].substr(0, 2) : ""));
        };


    incrementVar = 0;
    $('.inc.button').click(function(){
        var max = $(this).data("max");
        if ($(this).prev('input').val() < $(this).data("max")) {
            var $this = $(this),
            $input = $this.prev('input'),
            $parent = $input.closest('div'),
            newValue = parseInt($input.val())+1;
        $parent.find('.inc').addClass('a'+newValue);
        $input.val(newValue);
        price = $(this).prev('input').data('price'); 
        incrementVar += newValue;
        total = price * newValue;
    var spans = $(this).closest("tr").find("span.BLitzz-Price-amount.amount.subtotal").html('Rp '+format(total));
        }else{
            toastr.info('Stock Product Habis');
        }
    
    });
    $('.dec.button').click(function(){
        var min = $(this).data("min");
        if ($(this).next('input').val() > $(this).data("min")) {
        var $this = $(this),
            $input = $this.next('input'),
            $parent = $input.closest('div'),
            newValue = parseInt($input.val())-1;
        // console.log($parent);
        $parent.find('.inc').addClass('a'+newValue);
        $input.val(newValue);
        price = $(this).next('input').data('price'); 
        incrementVar += newValue;
        total = price * newValue;
    var spans = $(this).closest("tr").find("span.BLitzz-Price-amount.amount.subtotal").html('Rp '+format(total));

    }else{
            toastr.error('Pembelian Minimal 1 Product');
        }
    });

    </script>
    <script src="/assets/js/functions.js"></script>
    <script>
    

            $(document).on('click','a.submit-form',function(){
    //add the value to be sent to the input in the form
    $('#link-extra-info input').val($(this).data('submits'));
    //the href in the link becomes the action of the form
    $('#link-extra-info').attr('action', $(this).attr('href'));
    
    //submit the form
    $('#link-extra-info').submit();
    
    //return false to cancel the normal action for the click event
    return false;
    });
    </script>
</body>


</html>