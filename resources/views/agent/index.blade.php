@extends('admin.master')

@section('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
@endsection

@section('title', 'Agent')

@section('content')

<button class="btn btn-primary btn-sm" type="button" data-toggle="modal" data-target="#modal-add-agent">
    <i class="fa fa-plus"></i> Create Agent
</button>

<div style="padding-top: 5px"></div>

<div class="box box-primary">
    <div class="table-responsive" style="padding: 10px">
        <table class="table table-bordered datatable table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Tel</th>
                    <th>Address</th>
                    <th width="150" class="text-center">Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>


{{--    Create--}}
<div class="modal fade" id="modal-add-agent">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><i class="fa fa-user"></i> New Agent</h4>
            </div>
            <form method="post" id="frm-add-agent">
                <div class="modal-body">

                    {{csrf_field()}}

                    <div class="row">

                        <div class="form-group col-md-12">
                            <label for="Name">Name :</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-user"></i>
                                </div>
                                <input class="form-control" id="agent_name" name="agent_name" required>
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="Tel">Tel :</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-phone"></i>
                                </div>
                                <input class="form-control" id="tel" name="tel" required>
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="Address">Address :</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-home"></i>
                                </div>
                                <input class="form-control" id="address" name="address" required>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">
                        <i class="fa fa-close"></i> Close
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Save Order
                    </button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
{{--    Create--}}

{{csrf_field()}}


{{-- Update --}}
<div class="modal fade" id="modal-edit-agent">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><i class="fa fa-user"></i> New Agent</h4>
            </div>
            <form method="post" id="frm-edit-agent">
                <div class="modal-body">

                    {{csrf_field()}}

                    <div class="row">

                        <div class="form-group col-md-12">
                            <label for="Name">Name :</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-user"></i>
                                </div>
                                <input class="form-control" id="id" name="id" type="hidden">
                                <input class="form-control" id="agent_name" name="agent_name" required>
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="Tel">Tel :</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-phone"></i>
                                </div>
                                <input class="form-control" id="tel" name="tel" required>
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="Address">Address :</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-home"></i>
                                </div>
                                <input class="form-control" id="address" name="address" required>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">
                        <i class="fa fa-close"></i> Close
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Save Order
                    </button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
{{-- Update--}}

@endsection

@section('script')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
$(function() {
    let token = $('input[name="_token"]').val();

    let dataTable = $('.datatable').DataTable({
        processing: true,
        serverSide: true,
        autoWidth: false,
        pageLength: 20,
        // scrollX: true,
        "order": [
            [0, "desc"]
        ],
        ajax: '{{ route('get-agent') }}',
        columns: [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'agent_name',
                name: 'agent_name'
            },
            {
                data: 'tel',
                name: 'tel'
            },
            {
                data: 'address',
                name: 'address'
            },
            {
                data: 'Actions',
                name: 'Actions',
                orderable: false,
                serachable: false,
                sClass: 'text-center'
            },
        ]
    });

    // create
    $('#frm-add-agent').submit(function(e) {
        e.preventDefault();
        let form = $(this).serializeArray();

        $.ajax({
            type: 'post',
            url: 'agents',
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

    // show modal edit
    $(document).on('click', '#btn-edit', function() {
        let id = $(this).attr('data-id');

        $.ajax({
            type: 'get',
            url: 'agents/' + id,
            data: {
                _token: token
            },
            success: function(r) {
                $('#frm-edit-agent #id').val(id);
                $('#frm-edit-agent #agent_name').val(r.agent_name);
                $('#frm-edit-agent #tel').val(r.tel);
                $('#frm-edit-agent #address').val(r.address);
            }
        });
        $('#modal-edit-agent').modal('show');
    });

    // update

    $('#frm-edit-agent').submit(function(e) {

        e.preventDefault();

        let id = $('#frm-edit-agent #id').val();

        let form = $('#frm-edit-agent').serializeArray();

        $.ajax({
            type: 'PUT',
            url: 'agents/' + id,
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

    // Remove
    $(document).on('click', '#btn-remove', function() {
        let id = $(this).attr('data-id');

        let con = confirm('Are you sure remove ?');

        if (!con) {
            return false;
        }

        $.ajax({
            type: 'delete',
            url: 'agents/' + id,
            data: {
                id: id,
                _token: token
            },
            success: function(result) {
                if (result.error) {
                    alert(result.error);
                    return false;
                }
                location.reload();
            }
        });
    });
});
</script>
@endsection
