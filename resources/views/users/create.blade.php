@extends('admin.master')

@section('style')

@endsection

@section('title', 'Create User')

@section('content')

    <div class="box box-primary">
        <div class="box-body">
            <form method="post" id="frm-add-user">
                <div class="modal-body">

                    {{ csrf_field() }}

                    <div class="row">

                        <div class="form-group col-md-12">
                            <label for="Name">Username :</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-user"></i>
                                </div>
                                <input class="form-control" id="username" name="username" required>
                            </div>
                        </div>
                        

                        <div class="form-group col-md-12">
                            <label for="Tel">Password :</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-tags"></i>
                                </div>
                                <input class="form-control" id="password" name="password" required>
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="Name">Role :</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-inbox"></i>
                                </div>
                                <input class="form-control" id="username" name="username" required>
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
                            <div class="">                               
                                <textarea class="form-control" id="address" name="address"></textarea>
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
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        $(function() {
            let token = $('input[name="_token"]').val();
        });

    </script>
@endsection
