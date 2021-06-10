@extends('/admin/layouts/master',['title'=>'Edit Product'])
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
                    <a href="{{Route('product')}}">
                        <span>Product</span>
                    </a>
                </li>
                <li><span>Edit Product</span></li>

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

                    <h4 class="card-title">Edit Form</h4>
                </header>
                <div class="card-body">
                    <form class="form-horizontal form-bordered form-bordered container" enctype="multipart/form-data"
                        action="{{Route('update-product',['product'=>$product->id])}}" method="POST">
                        @method('put')
                        @csrf
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <label for="tags-input" class="control-label">Nama <small
                                        class="text-danger font-weight-bold">*</small></label>
                                <input type="text" required name="product_name" value="{{$product->product_name}}"
                                    class="form-control" placeholder="Masukkan Product Name">
                            </div>
                            <div class="col-lg-12 mt-3">
                                <label for="tags-input" class="control-label">Harga <small
                                        class="text-danger font-weight-bold">*</small></label>
                                <input value="{{$product->price}}" type="number" required name="price"
                                    class="form-control" placeholder="Masukkan Harga Product">
                            </div>
                            <div class="col-lg-12 mt-3">
                                <label for="tags-input" class="control-label">Stock <small
                                        class="text-danger font-weight-bold">*</small></label>
                                <input value="{{$product->stock}}" type="number" required name="stock"
                                    class="form-control" placeholder="Masukkan Product Stock">
                            </div>
                            <div class="col-lg-12 mt-3">
                                <label for="tags-input" class="control-label">berat <small
                                        class="text-danger font-weight-bold">*</small></label>
                                <input value="{{$product->weight}}" type="number" required name="weight"
                                    class="form-control" placeholder="Masukkan Berat Product">
                                <small class="text-danger font-weight-bold">*Dalam Berat Gram</small>
                            </div>
                            <div class="col-lg-12 mt-3">
                                <label for="tags-input" class="control-label">Category <small
                                        class="text-danger font-weight-bold">*</small></label>
                                <div class="">
                                    <select id="selectCategory" required name="category_id[]" multiple
                                        data-plugin-selectTwo class="form-control populate placeholder"
                                        data-plugin-options='{ "placeholder": "Select Category", "allowClear": true }'>
                                        <option value="" disabled>Select Category</option>
                                        @foreach ($categorys as $category)

                                        <option value="{{$category->id}}">{{$category->category_name}}</option>

                                        @endforeach
                                    </select>
                                    <small class="text-danger font-weight-bold">*Dapat memilih lebih dari satu</small>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-3">
                                <div class="form-group">
                                    <label for="tags-input" class="control-label">Description <small
                                            class="text-danger font-weight-bold">*</small></label>
                                    <textarea required name="description" class="summernote" data-plugin-summernote
                                        data-plugin-options='{ "height": 180, "codemirror": { "theme": "ambiance" },"placeholder": "Masukkan Description Product", "allowClear": true }'
                                        placeholder="dad">{{$product->description}}</textarea>
                                </div>
                            </div>
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


<script src="/assets/vendor/summernote/summernote-bs4.js"></script>
<!-- Theme Initialization Files -->
<script src="/assets/js/theme.init.js"></script>
<!-- Examples -->
<script src="/assets/js/examples/examples.advanced.form.js"></script>

<script>
    $('select').select2().val([
        @foreach($product->product_category_detail as $category_detail)
        '{{$category_detail->category_id}}', 
        @endforeach
        ]).trigger('change')


</script>
@endsection