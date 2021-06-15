@extends('admin.master')

@section('style')
    <link rel="stylesheet" type="text/css" href="/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
@endsection

@section('title', 'Product')

@section('content')
    <a class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modal-add-product">
        <i class="fa fa-plus"></i> New Product
    </a>

    @include('product.create')
    @include('product.edit')
    @include('product.modal_view_image')

    <div style='padding-top: 5px'></div>

    <div class="box box-primary" style="padding: 10px">
        <box class="box-body">

            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="datatable">
                    <thead>
                        <tr>
                            <th scope="col" width='10px'>Photo</th>
                            <th scope="col">Product</th>
                            <th scope="col">Noted</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($products as $row)
                            <tr data-id='{{ $row->id }}'>

                                <td>
                                    @if ($row->photo == '')
                                        <img src="https://i1.sndcdn.com/avatars-000387803255-gfwgsb-t500x500.jpg"
                                            height='25px' id="image-view" />
                                    @else
                                        <img id="image-view" src=" {{ asset('storage/products/' . $row->photo) }} "
                                            height='25px' />
                                    @endif
                                </td>
                                <td>{{ $row->product_name }}</td>
                                <td>{{ $row->desc }}</td>
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

@endsection

@section('script')
    <script src="/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">
        $(function() {
            let token = $('input[name="_token"]').val();

            $('#datatable').DataTable({});

            function UpdateLoad(ctn, form_name, ctn_preview) {
                $(ctn).change(function(e) {

                    var form = document.forms.namedItem(form_name);
                    var formData = new FormData(form);

                    $.ajax({
                        type: "post",
                        url: "/uploads",
                        contentType: false,
                        data: formData,
                        processData: false,
                        success: function(r) {
                            if (r) {
                                $(ctn_preview).val(r);
                            }
                        }
                    });
                });
            }

            UpdateLoad('#frm-add-product #file', 'frm-add-product', '#frm-add-product  #photo');
            UpdateLoad('#frm-edit-product #file', 'frm-edit-product', '#frm-edit-product #photo');

            // add products
            $(document).on('submit', '#frm-add-product', function(e) {

                e.preventDefault();

                var form = document.forms.namedItem("frm-add-product");
                var formData = new FormData(form);

                $.ajax({
                    type: "POST",
                    url: "/products",
                    contentType: false,
                    data: formData,
                    processData: false,
                    success: function(r) {
                        if (r.error) {
                            alert(r.error);
                            return false;
                        }
                        location.reload();
                    }
                });

            });

            // show product by id
            $(document).on('click', '#btn-edit', function() {
                let id = $(this).closest('tr').attr('data-id');

                $.ajax({
                    type: "get",
                    url: "/products/" + id,
                    success: function(r) {

                        if (r.error) {
                            alert(r.error);
                        }
                        let {
                            data
                        } = r;

                        $('#frm-edit-product #id').val(id);
                        $('#frm-edit-product #product_name').val(data.product_name);
                        $('#frm-edit-product #photo').val(data.photo);
                        $('#frm-edit-product #desc').val(data.desc);

                        $('#modal-edit-product').modal('show');
                    }
                });

            });

            // update
            $('#frm-edit-product').submit(function(e) {
                e.preventDefault();

                let id = $('#frm-edit-product #id').val();

                var form = $(this).serializeArray();

                $.ajax({
                    type: "PUT",
                    url: "/products/" + id,
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
                    url: "/products/" + id,
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
            });;

            // preview image
            $(document).on('click', '#image-view', function() {
                $('#modal-view-image img').attr('src', $(this).attr('src'));
                $('#modal-view-image').modal('show');
            });

        });

    </script>
@endsection
