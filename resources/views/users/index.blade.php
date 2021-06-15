@extends('admin.master')

@section('style')
    <link rel="stylesheet" type="text/css" href="/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
@endsection

@section('title', 'User')

@section('content')

    <div class="box box-primary" style="padding: 10px">
        <box class="box-body">

            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="datatable">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Photo</th>
                            <th scope="col">Username</th>
                            <th scope="col">Tel</th>
                            <th scope="col">Status</th>
                            {{-- <th scope="col">Role</th> --}}
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $row_num = 0; ?>
                        @foreach ($users as $row)
                            <tr data-id='{{ $row->id }}'>
                                <td>{{ ++$row_num }}</td>
                                <td>
                                    @if ($row->photo == '')
                                        <img src="https://i1.sndcdn.com/avatars-000387803255-gfwgsb-t500x500.jpg"
                                            height='25px' id="image-view" />
                                    @else
                                        <img id="image-view" src=" {{ asset('storage/profile/' . $row->photo) }} "
                                            height='25px' />
                                    @endif
                                </td>
                                <td>{{ $row->username }}</td>
                                <td>{{ $row->tel }}</td>
                                <td> <span class="label label-primary">{{ $row->status }} </span></td>
                                {{-- <td>{{ $row->role_id }} </td> --}}
                                <td>
                                    <a class="btn btn-primary btn-flat btn-xs" id="btn-edit"><i
                                            class="fa fa-pencil"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </box>
    </div>

    {{-- @include('service.modal_create')
    @include('service.modal_edit') --}}

@endsection

@section('script')
    <script src="/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">
        $(function() {
            let token = $('input[name="_token"]').val();

            $('#datatable').DataTable();
        });
    </script>
@endsection
