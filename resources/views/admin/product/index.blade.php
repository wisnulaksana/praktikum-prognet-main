@extends('/admin/layouts/master',['title'=>'Product'])
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
    <!-- start: page -->
    <div class="row">
        <div class="col">
            <section class="card">
                @include('admin/layouts/notif')
                <header class="card-header">
                    <div class="card-actions">
                        <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                        <a href="#" class="card-action card-action-dismiss" data-card-dismiss></a>
                    </div>

                    <a href="{{Route('add-product')}}" class=" btn btn-sm btn-success"><i class="fa fa-plus"></i>
                        Tambah Product</a>
                </header>
                <div class="card-body">
                    <table class="dataTable table table-bordered table-striped mb-0 responsive" id="datatable-default">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th>category</th>
                                <th>Stock</th>
                                <th>Rate</th>
                                <th>Berat</th>
                                <th class="text-center">Discount</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no = 1;
                            @endphp



                            @foreach ($products as $product)



                            <tr>
                                <td>{{$no++}}</td>
                                <td>{{$product->product_name}}</td>
                                <td>{{$product->price}}</td>
                                <td>
                                    @foreach ($product->category as $category)
                                    {{$category->category_name}}
                                    @endforeach
                                </td>
                                <td>{{$product->stock}}</td>
                                <td>

                                    @if ($product->reviews->avg('rate'))

                                    @for ($i = 0; $i < 5; $i++) @if (floor($product->reviews->avg('rate')) - $i >= 1)
                                        {{--Full Start--}}
                                        <i class="fas fa-star text-warning"> </i>
                                        @elseif ($product->reviews->avg('rate') - $i > 0)
                                        {{--Half Start--}}
                                        <i class="fas fa-star-half-alt text-warning"> </i>
                                        @else
                                        {{--Empty Start--}}
                                        <i class="far fa-star text-warning"> </i>
                                        @endif
                                        @endfor
                                        @else
                                        @for ($i = 0; $i < 5; $i++) <i class="far fa-star"> </i>
                                            @endfor
                                            @endif


                                </td>
                                <td>{{$product->weight}} g</td>
                                <td class="text-center">

                                    <a href="{{Route('discounts',['product'=>$product->id])}}" class="btn btn-sm btn-success">
                                        @if ($product->discounts->isEmpty())
                                        0 %
                                        @else
                                        @foreach ($product->discounts as $discount)
                                        @if (date('Y-m-d') >= $discount->start && date('Y-m-d') < $discount->end)
                                            {{$discount->percentage}} %
                                            @else
                                            0 %
                                            @endif
                                            @endforeach
                                            @endif
                                    </a>
                                </td>
                                <td class="text-center">
                                    <a href="{{Route('edit-product',['product'=>$product->id])}}"
                                        class="edit btn btn-sm btn-primary"><i class="fas fa-pencil-alt"></i></a>
                                    <a href="{{Route('show-product',['product'=>$product->id])}}"
                                        class=" btn btn-sm btn-dark"><i class="fas fa-eye"></i></a>
                                    <a href="#DeletemodalForm" data-id="{{$product->id}}"
                                        data-nama="{{$product->product_name}}"
                                        class="trash modal-with-form btn btn-sm btn-danger"><i
                                            class="fa fa-trash"></i></a>
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
        <footer class="card-footer">
            <div class="row">
                <div class="col-md-12 text-right">
                    <button class="btn btn-primary" type="submit">Submit</button>
                    <button class="btn btn-default modal-dismiss">Cancel</button>
                </div>
            </div>
        </footer>
        </form>

    </section>
</div>


<div class="modal-block modal-block-primary mfp-hide" id="DeletemodalForm" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="myModalLabel">Delete Confirmation</h3>
            </div>
            <div class="modal-body">
                <p class="error-text">
                    <i class="fa fa-warning modal-icon"></i>
                    apakah anda yakin ingin menghapus item ini?
                </p>
            </div>
            <div class="modal-footer">
                <form id="formDelete" action="#" method="post">
                    @method('delete')
                    @csrf
                    <button class="btn btn-default modal-dismiss" data-dismiss="modal"
                        aria-hidden="true">Cancel</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer')
<script>
    $(".dataTable").on('click','.trash', function () { 
      var id = $(this).data('id');
      var nama = $(this).data('nama');
      $('#formDelete').attr('action', '/admin/product/destroy/' + id);
    });
</script>
@endsection