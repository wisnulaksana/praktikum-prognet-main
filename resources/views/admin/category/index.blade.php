@extends('/admin/layouts/master',['title'=>'Category'])
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
                <li><span>Category</span></li>

            </ol>

        
        </div>
    </header>
    <!-- start: page -->
    <div class="row">
        <div class="col">
            <section class="card">
                @include('/admin/layouts/notif')
                <header class="card-header">
                    <div class="card-actions">
                        <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                        <a href="#" class="card-action card-action-dismiss" data-card-dismiss></a>
                    </div>

                    <a href="#modalForm" class=" modal-with-form btn btn-sm btn-success"><i class="fa fa-plus"></i>
                        Tambah Category</a>
                </header>
                <div class="card-body">
                    <table class="dataTable table table-bordered table-striped mb-0 responsive" id="datatable-default">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no = 1;
                            @endphp
                            @foreach ($category as $item)
                            <tr>
                                <td>{{$no++}}</td>
                                <td>{{$item->category_name}}</td>
                                <td class="text-center">
                                    <a href="#editmodalForm" data-id="{{$item->id}}"
                                        data-nama="{{$item->category_name}}"
                                        class="edit modal-with-form btn btn-sm btn-primary"><i
                                            class="fas fa-pencil-alt"></i></a>
                                    <a href="#DeletemodalForm" data-id="{{$item->id}}"
                                        data-nama="{{$item->category_name}}"
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
<!-- Modal Form -->
<div id="modalForm" class="modal-block modal-block-primary mfp-hide">
    <section class="card">
        <header class="card-header">
            <h2 class="card-title">Category Form</h2>
        </header>
        <div class="card-body">
            <form class="form-horizontal form-bordered form-bordered container" enctype="multipart/form-data"
                action="{{Route('store-category')}}" method="POST">
                @csrf
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label for="tags-input" class="control-label">Input Category</label>
                        {{-- <input type="text" name="categorys[]" multiple id="tags-input" data-role="tagsinput" data-tag-class="badge badge-primary" class="form-control" />
                         --}}
                        <select name="categorys[]" id="" multiple id="tags-input" required data-role="tagsinput"
                            data-tag-class="badge badge-primary" class="form-control">

                        </select>
                        <small class="text-danger">* Silahkan masukkan nama category (dapat memasukan lebih dari satu
                            nama)</small>
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
<div id="editmodalForm" class="modal-block modal-block-primary mfp-hide">
    <section class="card">
        <header class="card-header">
            <h2 class="card-title">Category Form</h2>
        </header>
        <div class="card-body">
            <form id="formEdit" class="form-horizontal form-bordered form-bordered container"
                enctype="multipart/form-data" action="#" method="POST">
                @method('put')
                @csrf
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label for="tags-input" class="control-label">Input Category</label>
                        <input id="namainput" type="text" class="form-control" name="category_name" value="">

                        </select>
                        <small class="text-danger">* Silahkan masukkan nama category (dapat memasukan lebih dari satu
                            nama)</small>
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
                    <button class="btn btn-default modal-dismiss">Cancel</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer')


<script>
    $(".dataTable").on('click','.edit', function () { 
      var id = $(this).data('id');
      var nama = $(this).data('nama');
      $('#formEdit').attr('action', '/admin/category/update/' + id);
      $('#namainput').attr('value',nama);
    });

    $(".dataTable").on('click','.trash', function () { 
      var id = $(this).data('id');
      var nama = $(this).data('nama');
      $('#formDelete').attr('action', '/admin/category/delete/' + id);
    });
</script>
@endsection