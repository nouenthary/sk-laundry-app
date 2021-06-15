@extends('admin.master')

@section('style')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
@endsection

@section('title', 'Order')

@section('content')

    <a href="/orders/create" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-shopping-cart"></i> Order Now</a>

    <div style="padding-top: 5px"></div>

    <div class="box box-primary">
        <div class="box-body">

            <table class="table table-bordered datatable table-striped">
                <thead>
                    <tr>
                        <th>Order no</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Sale by</th>
                        <th width="150" class="text-center">Action</th>
                    </tr>
                </thead>
            </table>

         
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript">
        $(function () {
            let token =  $('input[name="_token"]').val();          

            let dataTable = $('.datatable').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                pageLength: 20,
                // scrollX: true,
                "order": [[ 0, "desc" ]],
                ajax: 'get-agent-orders',
                columns: [
                    {data: 'invoice_no', name: 'invoice_no', orderable: false},                 
                    {data: 'Date',name: 'Date', orderable: false },
                    {data: 'Status', name: 'Status',searchable: false, orderable: false}, 
                    {data: 'Total', name: 'Total',searchable: false, orderable: false},
                    {data: 'User_ID', name: 'User_ID',searchable: false, orderable: false},
                    {data: 'Actions', name: 'Actions',orderable:false,serachable:false,sClass:'text-center'},
                ]
            });

        });
    </script>
@endsection
