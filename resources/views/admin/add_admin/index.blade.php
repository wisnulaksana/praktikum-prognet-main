@extends('/admin/layouts/master',['title'=>'User'])
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
                <li><span>User</span></li>

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

                    <a href="{{Route('admin.create')}}" class=" btn btn-sm btn-success"><i class="fa fa-plus"></i>
                        Tambah User Admin</a>
                </header>
                <div class="card-body">
               <table>
                <table class="dataTable table table-bordered table-striped mb-0 responsive" id="datatable-default">
                    <thead class="table-dark">
                        <tr>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Phone</th>
                            <th class="text-center" style="width: 30%">Profile Picture</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($adminUser as $admin)
                        <tr>
                            <td>{{$admin->name}}</td>
                            <td>{{$admin->username}}</td>
                            <td>{{$admin->phone}}</td>
                            <td class="text-center"><img src="{{$admin->image}}" style="width: 20%" alt=""></td>
                            <td class="text-center"><a href="{{Route('admin.edit',['admin'=>$admin->id])}}" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a> | <a href="#DeletemodalForm" data-id="{{$admin->id}}"
                                data-nama="{{$admin->name}}"
                                class="trash modal-with-form btn btn-danger"><i
                                    class="fa fa-trash"></i></a></td>
                        </tr>
                        @endforeach
                    </tbody>
               </table>
                </div>
            </section>
        </div>
    </div>
</section>

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
<!-- end: page -->
</section>

@endsection
@section('footer')
<script>
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

$(".dataTable").on('click','.trash', function () { 
      var id = $(this).data('id');
      var nama = $(this).data('nama');
      $('#formDelete').attr('action', '/admin/destroy/' + id);
    });
</script>
@endsection