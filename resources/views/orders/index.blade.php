@extends('admin.master')

@section('style')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
@endsection

@section('title', 'Order')

@section('content')

    <a href="/orders/create" class="btn btn-primary btn-sm"><i class="fa fa-shopping-cart"></i> Order Now</a>

    <div style="padding-top: 5px"></div>

    <div class="box box-primary">
        <div class="box-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Order Id</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Sale by</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $row)
                    <tr>
                        <td>#{{$row->invoice_no}}</td>
                        <td>{{$row->date}} {{$row->time}}</td>
                        <td>{{$row->amount}} R</td>
                        <td><span class="label label-primary">{{$row->status}} </span></td>
                        <td>{{$row->user_id}}</td>
                        <td>
                            <a href="/orders/order_id/{{\Illuminate\Support\Facades\Crypt::encrypt($row->id)}}" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                            <a class="btn btn-danger btn-xs"><i class="fa fa-minus"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th>Total:</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                </tfoot>
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
                ajax: '{{ route('get-agent') }}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'agent_name', name: 'agent_name'},
                    {data: 'tel', name: 'tel'},
                    {data: 'address', name: 'address'},
                    {data: 'Actions', name: 'Actions',orderable:false,serachable:false,sClass:'text-center'},
                ]
            });
        });
    </script>
@endsection
