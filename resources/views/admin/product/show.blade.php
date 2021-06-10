@extends('/admin//layouts/master',['title'=>'detail product'])
@section('content')
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Admin</h2>

        <div class="right-wrapper text-right">
            <ol class="breadcrumbs pr-3">
                <li>
                    <a href="/admin">
                        <i class="fas fa-home"></i>
                    </a>
                </li>
                <li><span>Product</span></li>

            </ol>

           
        </div>
    </header>
    @include('admin/layouts/notif')
    <div class="row">

        <div class="col-12 col-lg-4">
            <section class="card ">
                <header class="card-header">
                    <div class="card-actions">
                        <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                        <a href="#" class="card-action card-action-dismiss" data-card-dismiss></a>
                    </div>

                    <button class=" btn btn-sm btn-success" data-toggle="modal" data-target="#FormUpload"><i
                            class="fa fa-plus"></i>
                        Tambah Gambar</button>
                </header>
                <div class="card-body">
                    <div class="card-img p-1 m-1">
                        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                @foreach ($product->product_image as $image)
                                <div class="carousel-item text-center">
                                    <a href="{{$image->image}}" data-fancybox="gallery"
                                        data-caption='{{ $image->image_name }}'>
                                        <img class="text-center" style="width:250px;height:250px"
                                            src="{{ $image->image }}" alt=""></a>
                                    <form method="POST"
                                        action="{{Route('thumbnail-destroy',['productImages'=>$image->id])}}"
                                        class="  m-3">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="btn btn-danger m-0"><i
                                                class="fa fa-trash"></i></button>
                                    </form>
                                </div>
                                @endforeach
                            </div>
                            <a class="carousel-control-prev @if($product->product_image->count() < 2) d-none @endif"
                                href="#carouselExampleControls" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next @if($product->product_image->count() < 2) d-none @endif"
                                href="#carouselExampleControls" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>


                        {{-- <div class="image-product text-center">
                    </div> --}}
                        <hr class="p-0 m-0">
                        <p class="p-0 m-0 text-center font-weight-bold">Product Memiliki
                            {{$product->product_image->count()}} Gambar</p>
                    </div>
                </div>

            </section>
        </div>
        <div class="col-12 col-lg-8">
            <section class="card">
                <header class="card-header">
                    <div class="card-actions">
                        <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                        <a href="#" class="card-action card-action-dismiss" data-card-dismiss></a>
                    </div>
                    <a href="{{Route('edit-product',['product'=>$product->id])}}" class=" btn btn-sm btn-primary"><i
                            class="fas fa-pencil-alt"></i>
                        Edit Product</a>
                </header>
                <div class="card-body">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                            <tr>
                                <th>Nama</th>
                                <td>{{$product->product_name}}</td>

                            </tr>
                            <tr>
                                <th>Price</th>
                                <td>{{$product->price}}</td>
                            </tr>
                            <tr>
                                <th>Category</th>
                                <td>
                                    @foreach ($product->category as $category)
                                    {{$category->category_name}}
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td class="dsc">{!!$product->description!!}</td>
                            </tr>
                            <tr>
                                <th>Stock</th>
                                <td>{{$product->stock}} pcs</td>
                            </tr>
                            <tr>
                                <th>Berat</th>
                                <td>{{$product->weight}} kg</td>
                            </tr>
                            <tr>
                                <th>Diskon</th>

                                <td>
                                    @if($product->discounts->isEmpty())
                                    0 %
                                    @else
                                    @foreach ($product->discounts as $discount)
                                    {{$discount->percentage}} %,
                                    @endforeach
                                    @endif
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </section>
        </div>
        <div class="col-12 mt-5">
            <section class="card">
                <header class="card-header">
                    <div class="card-actions">
                        <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                        <a href="#" class="card-action card-action-dismiss" data-card-dismiss></a>
                    </div>
                    <h5 class="font-weight-bold text-dark">product review</h5>
                </header>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Rate</th>
                                <th>Review</th>
                                <th>Response</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($product->reviews as $review)
                            <tr>
                                <td>{{$review->user->name}}</td>
                                <td>
                                    @for ($i = 0; $i < $review->rate; $i++)

                                        <i class="fas fa-star text-warning"></i>

                                        @endfor
                                </td>
                                <td>{{$review->content}}</td>
                                <td>
                                    @foreach($responses as $response)
                                    @if($review->id == $response->review_id)
                                    {{ $response->content }},
                                    @endif
                                    @endforeach
                                </td>

                                <td class="text-center">
                                    <button data-id="{{$review->id}}" data-nama="{{$review->user->name}}"
                                        class="respond btn btn-sm btn-success" data-toggle="modal"
                                        data-target="#respondform">Balas</button>

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</section>

<!-- end: page -->
</section>
<!-- Modal Form -->
<div id="respondform" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="title-name"></h4>
            </div>
            <div class="modal-body">

                <form action="{{Route('respond-product')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="ulasan">Respond</label>
                        <textarea class="form-control" name="content" id="content" cols="5" rows="5"></textarea>

                    </div>
                    <div class="form-group">
                        <input type="hidden" id="id_review" value="" name="review_id">

                    </div>
                    <br>
                    <button class="btn btn-primary" type="submit" id="btn-submit" data-id="">Submit</button>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="FormUpload" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="title-name"></h4>
            </div>
            <div class="modal-body">

                <form action="{{Route('thumbnail-store')}}" method="POST" class="form-group"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="file" required name="files[]" multiple class="form-control">
                    <input type="hidden" value="{{$product->id}}" name="product_id">
                    <button class="float-right btn btn-success mt-3">Submit</button>
            </div>
            </form>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection
@section('footer')
<script src="/assets/dropzone/dist/dropzone.js"></script>
<script src="/assets/vendor/readmore-js/readmore.min.js"></script>
<script>
    $('.carousel-item').first().addClass('active')
    $('td.dsc p').readmore({
        speed: 400,
        collapsedHeight: 30,
        lessLink: '<a href="#" class="d-block">Load less</a>',
        moreLink: '<a class="d-block" href="#">Load More</a>',
    });
    $(document).on('click','.respond', function () { 
      var id = $(this).data('id');
      var nama = $(this).data('nama');
      $('#id_review').attr('value',id);
      $('#title-name').html('Berikan Repond Pada Ulasan : '+nama);
    });

  
</script>
@endsection