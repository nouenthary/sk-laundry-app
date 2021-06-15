@extends('admin.master')

@section('style')
    <link rel="stylesheet" type="text/css" href="/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
@endsection

@section('title', 'Service')

@section('content')
    <a class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modal-add-service">
        <i class="fa fa-plus"></i> New Service
    </a>

    <div style='padding-top: 5px'></div>

    <div class="box box-primary" style="padding: 10px">
        <box class="box-body">

            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="datatable">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Service</th>
                            <th scope="col">Unit Type</th>
                            <th scope="col">Unit</th>
                            <th scope="col">Price</th>
                            <th scope="col">Discount</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">Start Time</th>
                            <th scope="col">Type</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $row_num = 0; ?>
                        @foreach ($services as $row)
                            <tr data-id='{{ $row->id }}'>
                                <td>{{ ++$row_num }}</td>
                                <td>{{ $row->service_name }}</td>
                                <td>{{ $row->unit_type }}</td>
                                <td>{{ $row->unit }}</td>
                                <td>{{ $row->price }} R</td>
                                <td>{{ $row->discount }} %</td>
                                <td>
                                    @if ($row->start_date != '')
                                        {{ $row->start_date }}
                                    @else
                                        <i class="fa fa-calendar-plus-o"></i>
                                    @endif
                                </td>
                                <td>
                                    @if ($row->start_date != '')
                                        {{ $row->end_date }}
                                    @else
                                        <i class="fa fa-calendar-plus-o"></i>
                                    @endif
                                </td>
                                <td>{{ $row->type }}</td>
                                <td>
                                    <a class="btn btn-primary btn-flat btn-xs" id="btn-edit"><i
                                            class="fa fa-pencil"></i></a>
                                    <a class="btn btn-danger btn-flat btn-xs" id="btn-remove"><i
                                            class="fa fa-minus-circle"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </box>
    </div>

    @include('service.modal_create')
    @include('service.modal_edit')

@endsection

@section('script')
    <script src="/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">
        $(function() {
            let token = $('input[name="_token"]').val();

            $('#datatable').DataTable();

            // utils 
            function InputOnlyPrice(ctn) {
                $(document).on('keypress', ctn, function(e) {

                    $(ctn).on('input', function(e) {
                        if (/^(\d+(\.\d{0,3})?)?$/.test($(this).val())) {
                            $(this).data('prevValue', $(this).val());
                        } else {
                            $(this).val($(this).data('prevValue') || '');
                        }
                    }).trigger('input');
                });
            }

            // call
            InputOnlyPrice('#frm-add-service #unit');
            InputOnlyPrice('#frm-add-service #price');
            InputOnlyPrice('#frm-add-service #discount');

            InputOnlyPrice('#frm-edit-service #unit');
            InputOnlyPrice('#frm-edit-service #price');
            InputOnlyPrice('#frm-edit-service #discount');

            // add service
            $(document).on('submit', '#frm-add-service', function(e) {
                e.preventDefault();
                let form = $(this).serializeArray();

                let discount = $('#frm-add-service #discount').val();

                if (discount > 100) {
                    alert('Discount must be less then 100 %');
                }

                $.ajax({
                    type: "post",
                    url: "/services",
                    data: form,
                    success: function(r) {
                        if (r.error) {
                            alert(r.error);
                            return false;
                        }
                        location.reload();
                    }
                });
            });

            //edit
            $(document).on('click', '#btn-edit', function(e) {
                e.preventDefault();

                let id = $(this).closest('tr').attr('data-id');

                $.ajax({
                    type: "get",
                    url: "/services/" + id,
                    data: {
                        _token: token
                    },
                    success: function(r) {
                        if (r.data.error) {
                            alert(r.data.error);
                            return false;
                        }

                        let {
                            data
                        } = r;

                        $('#frm-edit-service #id').val(id);
                        $('#frm-edit-service #service_name').val(data.service_name);
                        $('#frm-edit-service #type').val(data.type);
                        $('#frm-edit-service #unit_type').val(data.unit_type);
                        $('#frm-edit-service #unit').val(data.unit);
                        $('#frm-edit-service #price').val(data.price);
                        $('#frm-edit-service #discount').val(data.discount);
                        $('#frm-edit-service #start_date').val(data.start_date);
                        $('#frm-edit-service #end_date').val(data.end_date);

                        $('#modal-edit-service').modal('show');
                    }
                });
            });

            // update
            $(document).on('submit', '#frm-edit-service', function(e) {
                e.preventDefault();

                let id = $('#frm-edit-service #id').val();

                let form = $(this).serializeArray();

                $.ajax({
                    type: "put",
                    url: "/services/" + id,
                    data: form,
                    success: function(r) {
                        if (r.error) {
                            alert(r.error);
                            return false;
                        }
                        location.reload();
                    }
                });
            });

            // remove
            $(document).on('click', '#btn-remove', function() {
                let id = $(this).closest('tr').attr('data-id');

                let con = confirm('Are you sure remove ?');

                if (!con) {
                    return false;
                }

                $.ajax({
                    type: "delete",
                    url: "/services/" + id,
                    data: {
                        _token: token
                    },
                    success: function(r) {
                        if (r.error) {
                            alert(r.error);
                            return false;
                        }
                        location.reload();
                    }
                });

            });
        });

    </script>
@endsection
