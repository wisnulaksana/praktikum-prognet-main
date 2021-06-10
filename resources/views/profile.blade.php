@extends('layouts/master')
@section('content')

<main class="site-main main-container no-sidebar">
    <div class="container">
        <div class="row">
            <div class="main-content col-md-12">
                <div class="page-main-content">
                    <div class="BLitzz">
                        <div class="BLitzz-notices-wrapper">
                            <div class="row ">
                                <div class="col-md-4 mx-auto">
                                    <form class="BLitzz-cart-form" action="{{Route('profile.update',['user'=>$user->id])}}" method="post" enctype="multipart/form-data">
                                        @method('put')
                                        @csrf
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <img id="blah" style="width: 100%x; height:300px; border-radius:5px;"
                                                src="{{$user->image}}" alt="your image" />
                                            <input name="profile_image" type='file' id="imgInp" class="pt-2 mt-2 w-100" />

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8 mt-3">
                                    <div class="info-extra">
                                        <h4>Status Akun : @if($user->email_verified_at) <span class="badge badge-success">Terverifikasi</span> @else <span class="badge badge-danger">Belum Terverifikasi</span> @endif</h4>
                                        <h4>Jumlah Transaksi : {{$user->transaction->count()}}</h4>
                                    </div>
                                    <hr>
                                 
                                        <div class="form-gorup">
                                            <label for="Nama">Nama</label> 
                                            <input type="text" name="name" class="form-control w-100" value="{{$user->name}}" placeholder="Nama">
                                        </div>
                                        <div class="form-gorup pt-3">
                                            <label for="Email">Email</label>
                                            <input type="email" name="email" class="form-control w-100" value="{{$user->email}}" placeholder="Email">
                                            <small class="text-danger">* Mengganti Email akan menghilangkan status verifikasi akun</small>
                                        </div>
                                        <button type="submit" class="btn btn-primary float-right clearfix mt-3">Submit</button>
                                   
                                </div>
                            </form>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('scripts')
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