@extends('admin.master')

@section('style')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
@endsection

@section('title', 'Agent')

@section('content')


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
