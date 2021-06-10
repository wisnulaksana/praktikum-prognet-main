@php
$admin = Auth::guard('admin')->user();
@endphp
<!doctype html>
<html class="fixed">

<head>

    <!-- Basic -->
    <meta charset="UTF-8">

    <title>{{$title ?? 'admin'}}</title>
    <meta name="keywords" content="admin toko " />
    <meta name="description" content="admin toko">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="tokoonlen.net">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <!-- Web Fonts  -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light"
        rel="stylesheet" type="text/css">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="/assets/vendor/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="/assets/vendor/animate/animate.css">

    <link rel="stylesheet" href="/assets/vendor/font-awesome/css/all.min.css" />
    <link rel="stylesheet" href="/assets/vendor/magnific-popup/magnific-popup.css" />

    <!-- Specific Page Vendor CSS -->
    <link rel="stylesheet" href="/assets/vendor/select2/css/select2.css" />
    <link rel="stylesheet" href="/assets/vendor/select2-bootstrap-theme/select2-bootstrap.min.css" />
    <link rel="stylesheet" href="/assets/vendor/datatables/media/css/dataTables.bootstrap4.css" />
    <link rel="stylesheet" href="/assets/vendor/bootstrap-multiselect/css/bootstrap-multiselect.css" />
    <link rel="stylesheet" href="/assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.css" />
    <!-- Page plugins -->
    <link href="/assets/admin/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.css"
        integrity="sha512-nNlU0WK2QfKsuEmdcTwkeh+lhGs6uyOxuUs+n+0oXSYDok5qy0EI0lt01ZynHq6+p/tbgpZ7P+yUb+r71wqdXg=="
        crossorigin="anonymous" />

    <!-- Specific Page Vendor CSS -->
    <link rel="stylesheet" href="/assets/vendor/jquery-ui/jquery-ui.css" />
    <link rel="stylesheet" href="/assets/vendor/jquery-ui/jquery-ui.theme.css" />
    <link rel="stylesheet" href="/assets/vendor/select2/css/select2.css" />
    <link rel="stylesheet" href="/assets/vendor/select2-bootstrap-theme/select2-bootstrap.min.css" />
    <link rel="stylesheet" href="/assets/vendor/bootstrap-multiselect/css/bootstrap-multiselect.css" />
    <link rel="stylesheet" href="/assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.css" />
    <link rel="stylesheet" href="/assets/vendor/dropzone/basic.css" />
    <link rel="stylesheet" href="/assets/vendor/dropzone/dropzone.css" />
    <link rel="stylesheet" href="/assets/vendor/summernote/summernote-bs4.css" />
    <link rel="stylesheet" href="/assets/vendor/codemirror/lib/codemirror.css" />
    <link rel="stylesheet" href="/assets/vendor/codemirror/theme/monokai.css" />


    <!-- Theme CSS -->
    <link rel="stylesheet" href="/assets/css/theme.css" />

    <!-- Skin CSS -->
    <link rel="stylesheet" href="/assets/css/skins/default.css" />

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="/assets/css/custom.css">

    <!-- Head Libs -->
    <script src="/assets/vendor/modernizr/modernizr.js"></script>

</head>

<body>
    <section class="body">
        @include('admin/layouts/header')
        @include('admin/layouts/sidebar')
        @yield('content')
    </section>
    <!-- <section class=" bg-light">
        <div class="container container-with-sidebar">
            <div class="row">
                <div class="col-xl-9 p-0">
                    <div class="call-to-action-content ml-4 pt-xl-5 pb-4">
                        <h2 class=" text-dark">Praktikum Prognet @ 2021</h2>
                    </div>
                </div>

            </div>
        </div>

    </section> -->


    <!-- Vendor -->
    <script src="/assets/vendor/jquery/jquery.js"></script>
 <script type="text/javascript" src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
    <script src="/assets/vendor/popper/umd/popper.min.js"></script>
    <script src="/assets/vendor/bootstrap/js/bootstrap.js"></script>
    <script src="/assets/vendor/common/common.js"></script>
    <script src="/assets/vendor/nanoscroller/nanoscroller.js"></script>
    <script src="/assets/vendor/magnific-popup/jquery.magnific-popup.js"></script>
    <script src="/assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>

    <!-- Specific Page Vendor -->
    <script src="/assets/vendor/jqueryui-touch-punch/jquery.ui.touch-punch.js"></script>
    <script src="/assets/vendor/jquery-appear/jquery.appear.js"></script>
    <script src="/assets/vendor/bootstrap-multiselect/js/bootstrap-multiselect.js"></script>
    <script src="/assets/vendor/flot/jquery.flot.js"></script>
    <script src="/assets/vendor/flot/jquery.flot.pie.js"></script>
    <script src="/assets/vendor/flot/jquery.flot.categories.js"></script>

    <!-- Specific Page Vendor -->
    <script src="/assets/vendor/select2/js/select2.js"></script>
    <script src="/assets/vendor/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="/assets/vendor/datatables/media/js/dataTables.bootstrap4.min.js"></script>
    <script src="/assets/js/examples/examples.datatables.default.js"></script>

    <script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
    <script src="/assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
    <script src=" https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
    <!-- Specific Page Vendor -->
    <script src="/assets/vendor/select2/js/select2.js"></script>
    <script src="/assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"
        integrity="sha512-uURl+ZXMBrF4AwGaWmEetzrd+J5/8NRkWAvJx5sbPSSuOb0bZLqf+tOzniObO00BjHa/dD7gub9oCGMLPQHtQA=="
        crossorigin="anonymous"></script>
   
    <!-- Examples -->
    <script src="/assets/js/examples/examples.advanced.form.js"></script>
    <script src="/assets/js/examples/examples.modals.js"></script>

    <!-- Theme Base, Components and Settings -->
    <script src="/assets/js/theme.js"></script>

    <!-- Theme Custom -->
    <script src="/assets/js/custom.js"></script>

    <!-- Theme Initialization Files -->
    <script src="/assets/js/theme.init.js"></script>

    <!-- Examples -->
    <script src="/assets/js/examples/examples.dashboard.js"></script>

    @yield('footer')

    <script>
        $.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

loadnotif()
function loadnotif(){
        $.ajax({
                url: '{{Route("count-notif-admin")}}',
                type: 'get',
                success: function(data){
                    var responsedata = $.parseJSON(data);
                    $('.badge.count-notif').html(responsedata.count);
                    $('.float-right.badge.badge-default').html(responsedata.count);
                    
                    jQuery.each(responsedata.list, function(index, value){
                        $('ul.sub-notif').append('<li class="listnotif" >'+value.data+'</li>');

                        if(index == 0){
                            $('a.submit-form').attr('data-submits',value.id);    
                    }else{
    
                        $('a.submit-form').eq(index).attr('data-submits',value.id);

                    }
                        $('.readall').html('<a href="/admin/marksallreadadmin" class="view-more">Tandai Semua Notifikasi Terbaca</a>')
                    });
                }
        });
    }

  

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