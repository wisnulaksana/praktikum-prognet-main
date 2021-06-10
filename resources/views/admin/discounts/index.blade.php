@extends('/admin/layouts/master',['title'=>'Discounts'])
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
                <li><span>Discounts</span></li>

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


                    <a href="#modalForm" data-id="{{$product->id}}" data-nama="{{$product->product_name}}"
                        class=" btn modal-with-form btn-sm btn-success"><i class="fa fa-plus"></i> Tambah Diskon</a>
                </header>
                <div class="card-body">
                    <table class="dataTable table table-bordered table-striped mb-0 responsive" id="datatable-default">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Presentase</th>
                                <th>Mulai</th>
                                <th>Berakhir</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no = 1;
                            @endphp
                            @foreach ($discounts as $diskon)
                            <tr>
                                <td>{{$no++}}</td>
                                <td>{{$diskon->percentage}}</td>
                                <td>{{$diskon->start}}</td>
                                <td>{{$diskon->end}}</td>
                                <td class="text-center"> <a href="#DeletemodalForm" data-id="{{$diskon->id}}"
                                        class="trash modal-with-form btn btn-sm btn-danger"><i
                                            class="fa fa-trash"></i></a>
                                    <a href="#modalEditForm" data-id="{{$diskon->id}}"
                                        data-persen="{{$diskon->percentage}}" data-start="{{$diskon->start}}"
                                        data-end="{{$diskon->end}}"
                                        class="edit modal-with-form btn btn-sm btn-primary"><i
                                            class="fas fa-pencil-alt"></i></a></td>
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

<div id="modalForm" class="modal-block modal-block-primary mfp-hide">
    <section class="card">
        <header class="card-header">
            <h2 class="card-title">Discount Form</h2>
        </header>
        <div class="card-body">
            <form class="form-horizontal form-bordered form-bordered container" enctype="multipart/form-data"
                action="{{Route('discounts-store')}}" method="POST">
                @csrf
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label for="tags-input" class="control-label">Presentase</label>
                        <input type="text" name="percentage" class="form-control" required
                            placeholder="Input Prrcentase">
                    </div>
                    <div class="col-lg-12">
                        <label for="tags-input" class="control-label">Tanggal Mulai</label>
                        <input type="date" name="start" class="form-control" required placeholder="Input Tanggal Mulai">
                    </div>
                    <div class="col-lg-12">
                        <label for="tags-input" class="control-label">Tanggal Berakhir</label>
                        <input type="date" name="end" class="form-control" required
                            placeholder="Input Tanggal Berakhir">
                        <input type="hidden" value="{{$product->id}}" name="id_product">
                    </div>
                </div>
        </div>
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


<div id="modalEditForm" class="modal-block modal-block-primary mfp-hide">
    <section class="card">
        <header class="card-header">
            <h2 class="card-title">Discount Edit Form</h2>
        </header>
        <div class="card-body">
            <form class="form-horizontal form-bordered form-bordered container" id="EditFormDiscounts"
                enctype="multipart/form-data" action="" method="POST">
                @method('put')
                @csrf
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label for="tags-input" class="control-label">Presentase</label>
                        <input type="text" id="percentage" value="" name="percentage" class="form-control" required
                            placeholder="Input Prrcentase">
                    </div>
                    <div class="col-lg-12">
                        <label for="tags-input" class="control-label">Tanggal Mulai</label>
                        <input type="date" id="start" value="" name="start" class="form-control" required
                            placeholder="Input Tanggal Mulai">
                    </div>
                    <div class="col-lg-12">
                        <label for="tags-input" class="control-label">Tanggal Berakhir</label>
                        <input type="date" name="end" id="end" value="" class="form-control" required
                            placeholder="Input Tanggal Berakhir">
                    </div>
                </div>
        </div>
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
      $('#formDelete').attr('action', '/admin/discount/destroy/' + id);
    });

    $(".dataTable").on('click','.edit', function () { 
      var id = $(this).data('id');
      var persen = $(this).data('persen');
      var start = $(this).data('start');
      var end = $(this).data('end');
      $('#EditFormDiscounts').attr('action', '/admin/discount/update/' + id);
      $('#percentage').attr('value', persen);
      $('#start').attr('value', start);
      $('#end').attr('value', end);
    });
</script>
@endsection