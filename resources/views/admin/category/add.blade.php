@extends('/layouts/master',['title'=>'Dashboard'])
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
                    <a href="{{Route('category')}}">
                        <span>Category</span>
                    </a>
                   </li>
                <li><span>Tambah Category</span></li>
                
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
                    <form class="form-horizontal form-bordered form-bordered container" enctype="multipart/form-data" action="{{Route('store-category')}}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <label for="tags-input" class="control-label">Input Category</label>
                                {{-- <input type="text" name="categorys[]" multiple id="tags-input" data-role="tagsinput" data-tag-class="badge badge-primary" class="form-control" />
                                 --}}
                                 <select name="categorys[]" id="" multiple id="tags-input" data-role="tagsinput" data-tag-class="badge badge-primary" class="form-control">
                                  
                                 </select>
                               <small class="text-danger">* Silahkan masukkan nama category (dapat memasukan lebih dari satu nama)</small>
                            </div>
                        </div>
                        <button class="float-right btn btn-sm btn-success" type="submit">Submit</button>
                    </form>
                </div>
            </section>
        </div></div>
</section>

@endsection

@section('footer')
    <!-- Specific Page Vendor -->
		<script src="/assets/vendor/jqueryui-touch-punch/jquery.ui.touch-punch.js"></script>
		<script src="/assets/vendor/select2/js/select2.js"></script>
		<script src="/assets/vendor/jquery-maskedinput/jquery.maskedinput.js"></script>
		<script src="/assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
        		<!-- Examples -->
		<script src="/assets/js/examples/examples.advanced.form.js"></script>

@endsection