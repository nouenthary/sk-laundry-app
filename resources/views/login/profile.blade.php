@extends('admin.master')

@section('style')
@endsection

@section('title', 'Profile')

@section('content')

    @if (Session::has('message'))
        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
    @endif

    @if (count($errors))
        @foreach ($errors->all() as $error)
            <p class="alert alert-warning">{{ $error }}</p>
        @endforeach
    @endif

    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-exchange"></i> Update Password</h3>
                </div>
                <div class="box-body">
                    <form method="post" action='/update-password'>
                        {{ csrf_field() }}
                        <!-- Date -->
                        <div class="form-group">
                            <label>Old Password:</label>

                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-lock"></i>
                                </div>
                                <input type="password" class="form-control pull-right" id="old_password"
                                    name="old_password">
                            </div>
                            <!-- /.input group -->
                        </div>
                        <!-- /.form group -->

                        <!-- Date range -->
                        <div class="form-group">
                            <label>New Password:</label>

                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-unlock"></i>
                                </div>
                                <input type="password" class="form-control pull-right" id="new_password"
                                    name="new_password">
                            </div>
                            <!-- /.input group -->
                        </div>
                        <!-- /.form group -->

                        <!-- Date and time range -->
                        <div class="form-group">
                            <label>Confirm Password:</label>

                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-unlock"></i>
                                </div>
                                <input type="password" class="form-control pull-right" id="new_password"
                                    name="new_password">
                            </div>
                            <!-- /.input group -->
                        </div>
                        <!-- /.form group -->

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-flat" id="btn-update-password">
                                <i class="fa fa-exchange"></i> Update Password
                            </button>
                        </div>
                    </form>
                </div>
                <!-- /.box-body -->
            </div>
        </div>

        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-body" style="padding: 10px">
                    <img src="/storage/profile/<?= Auth::user()->photo; ?>" height="300px" id="image-view"
                        style="width: 100%" />

                    <form id="form-upload" name="form-upload" method="POST"> 
                        {{ csrf_field() }}
                        <input type="file" id="file" name="file"  style="display: none"/>
                    </form>

                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(function() {
            $('#image-view').click(function() {
                $("#file").focus().trigger("click");
            });

            function UpdateLoad(ctn, form_name, ctn_preview) {
                $(ctn).change(function(e) {

                    var form = document.forms.namedItem(form_name);
                    var formData = new FormData(form);

                    $.ajax({
                        type: "post",
                        url: "/change-photo",
                        contentType: false,
                        data: formData,
                        processData: false,
                        success: function(r) {
                            if (r) { 
                                $(ctn_preview).attr('src', '/storage/profile/'+ r);
                            }
                        }
                    });
                });                
            }

            UpdateLoad('#file','form-upload','#image-view');
        });

    </script>
@endsection
