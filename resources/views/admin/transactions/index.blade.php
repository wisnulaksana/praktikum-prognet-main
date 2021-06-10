@extends('/admin/layouts/master',['title'=>'Transaction'])
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
                <li><span>Transaction</span></li>
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
                </header>
                <div class="card-body">
                    <div class="filter m-0 mb-3">
                                    <form action="report_export_excel" method="post">
                                        <div class="row">
                                            <div class=" form-gorup col-md-4">
                                                <select class="form-control" id="filter">
                                                    <option value="">all</option>
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                    <table class="dataTable table table-bordered table-striped mb-0 responsive" id="datatableFilter">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Jatuh Tempo</th>
                                <th>Alamat</th>
                                <th>Kota</th>
                                <th>Provinsi</th>
                                <th>Total</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no = 1;
                            @endphp
                            @foreach ($transactions as $transaksi)
                            <tr>
                                <td>{{$no++}}</td>
                                <td>{{$transaksi->timeout}}</td>
                                <td>{{$transaksi->address}}</td>
                                <td>{{$transaksi->regency}}</td>
                                <td>{{$transaksi->province}}</td>
                                <td>Rp.{{number_format($transaksi->total, 0, ',', '.')}}</td>
                                <td class="text-center">{{$transaksi->status}}
                                </td>

                                <td class="text-center">

                                    <a href="{{Route('show-transaksi',['transaction'=>$transaksi->id])}}"
                                        class=" btn btn-sm btn-dark"><i class="fas fa-eye"></i></a>

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
    $("#datatableFilter").on('click','.trash', function () {
        var id = $(this).data('id');
        var nama = $(this).data('nama');
        var title = document.getElementById("myModalLabel");
        title.innerHTML = "Data : "+ nama;

        $('#form-del-pengurus').attr('action', '/admin/pengurus/' + id);
    });

    $(document).ready(function() {

        // $.noConflict();
        $('#datatableFilter').DataTable({
           "columnDefs": [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: 2 },
                { orderable: false, targets: 3}
            ],
            bInfo: false,
            responsive: true,
            deferRender: true,
            rowReorder: {
                selector: 'td:nth-child(3)'
            },
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            
            initComplete: function() {
                $('button.dt-button').removeClass('dt-button');
                $('div.dt-buttons').addClass(' m-0 ml-lg-4');

                this.api().columns("6").every(function() {
                    var column = this;
                    var select = $('#filter').appendTo($("#filter")).on('change', function() {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
                        column.search(val ? '^' + val + '$' : '', true, false).draw();
                    });

                    column.data().unique().sort().each(function(d, j) {
                        select.append('<option value="' + d + '">' + d + '</option>');
                    });
                });
            }
        });
     
        
    });


</script>
@endsection