@extends('/admin/layouts/master',['title'=>'Add Product'])
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
                <li>
                    <a href="{{Route('admin.add')}}">
                        <span>User</span>
                    </a>
                </li>
                <li><span>Tambah User Admin</span></li>

            </ol>

          
        </div>
    </header>
    <!-- start: page -->
    <div class="row">
        <div class="col">
            <section class="card">
                <header class="card-header">
                    <div class="card-actions">
                        <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                        <a href="#" class="card-action card-action-dismiss" data-card-dismiss></a>
                    </div>

                    <h4 class="card-title">Add Form</h4>
                </header>
                <div class="card-body">
                    <form class="form-horizontal form-bordered form-bordered container" enctype="multipart/form-data"
                        action="{{Route('admin.store')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" name="name" class="form-control w-100">
                        </div>
                        <div class="form-group">
                            <label for="">Username</label>
                            <input type="text" name="username" class="form-control w-100">
                        </div>
                        <div class="form-group">
                            <label for="">Phone</label>
                            <input type="text" name="phone" class="form-control w-100">
                        </div>
                        <div class="form-group">
                            <label for="">password</label>
                            <input type="password" name="password" class="form-control w-100">
                        </div>
                        <div class="form-group">
                            <label for="">Profile Image</label><br>
                            <img id="blah" style="width: 100%x; height:300px; border-radius:5px;"
                                    src="/assets/images/default-user.jpg" alt="your image" />
                                <input name="profile_image" type='file' id="imgInp" class="d-block pt-2 mt-2 w-100" />
                        </div>
                        <button class="float-right btn btn-sm btn-success p-2 mt-3" type="submit">Submit</button>
                    </form>
                </div>
            </section>
        </div>
    </div>
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
</script>
@endsection

