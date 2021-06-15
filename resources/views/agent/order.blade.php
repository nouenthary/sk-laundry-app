@extends('admin.master')

@section('style')
@endsection

@section('title', 'Order')

@section('content')
    {{-- {{$agent_invoices[0]}} --}}

    <div style="padding-top: 5px"></div>

    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="agent_id">Agent Phone</label>
                    <select {{ $status == 'Done' ? 'disabled' : '' }} class="form-control" name="agent_id" id="agent_id">
                        <option value="">-- Choose Agent --</option>
                        @foreach ($agents as $row)
                            @if ($row->id == $agent_id)
                                <option value="{{ $row->id }}" selected>{{ $row->tel }}</option>
                            @else
                                <option value="{{ $row->id }}">{{ $row->tel }}</option>
                            @endif

                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label for="agent_name">Agent Name</label>
                    <select class="form-control" name="agent_name" id="agent_name" disabled>
                        <option value="">-- Choose Name --</option>
                        @foreach ($agents as $row)
                            @if ($row->id == $agent_id)
                                <option value="{{ $row->id }}" selected>{{ $row->agent_name }}</option>
                            @else
                                <option value="{{ $row->id }}">{{ $row->agent_name }}</option>
                            @endif

                        @endforeach
                    </select>
                </div>
            </div>

            <button class="btn btn-default btn-sm btn-flat" data-toggle="modal" data-target="#modal-add-item"
                {{ $status == 'Done' ? 'disabled' : '' }}>
                <i class="fa fa-plus"></i>
                Add Item
            </button>

            <hr />

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Service</th>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Weight</th>
                        <th>Price</th>
                        <th>Discount</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($agent_invoices as $row)
                        <tr data-id="{{ $row->id }}">
                            <td>{{ $row->service_name }}</td>
                            <td>{{ $row->product_name }}</td>
                            <td>{{ $row->qty }} Pcs</td>
                            <td>{{ $row->weight }} Kg</td>
                            <td>{{ $row->price }} R</td>
                            <td>{{ $row->discount }} %</td>
                            <td>{{ $row->total }} R</td>
                            <td>
                                <button class="btn btn-primary btn-xs btn-flat" id="btn-edit"
                                    {{ $status == 'Done' ? 'disabled' : '' }}>
                                    <i class="fa fa-pencil"></i>
                                </button>

                                <button class="btn btn-danger btn-xs btn-flat" id="btn-remove"
                                    {{ $status == 'Done' ? 'disabled' : '' }}>
                                    <i class="fa fa-minus"></i>
                                </button>
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
                        <th>{{ $total_row }} R</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>

            <br />

            <a class="btn btn-default btn-sm btn-flat" href="/orders">
                <i class="fa  fa-undo"></i> Back
            </a>

            <a class="btn btn-default btn-sm pull-right btn-flat" href="/print/{{ $agent_invoice_id }}" target="_blank">
                <i class="fa fa-print"></i> Print Invoice
            </a>
            <button {{ $status == 'Done' ? 'disabled' : '' }} class="btn btn-success btn-sm btn-flat pull-right"
                data-toggle="modal" data-target="#modal-form-payment">
                <i class="fa fa-credit-card"></i>
                Payment Now
            </button>

        </div>
    </div>

    {{ csrf_field() }}

    {{-- Create --}}
    <div class="modal fade" id="modal-add-item">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">
                        <i class="fa fa-plus"></i> New Item
                    </h4>
                </div>
                <form method="post" id="frm-add-order">
                    <div class="modal-body">

                        {{ csrf_field() }}
                        <input type="hidden" id="agent_invoice_id" name="agent_invoice_id"
                            value="{{ $agent_invoice_id }}">

                        <div class="row">

                            <div class="form-group col-md-12">
                                <label for="product_id">Product :</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-tag"></i>
                                    </div>
                                    <select class="form-control" id="product_id" name="product_id" required>
                                        <option value="">-- Choose Product --</option>
                                        @foreach ($products as $row)
                                            <option value="{{ $row->id }}">{{ $row->product_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="service_id">Service :</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-inbox"></i>
                                    </div>
                                    <select class="form-control" id="service_id" name="service_id" required>
                                        <option value="">-- Choose Service --</option>
                                        @foreach ($service as $row)
                                            <option value="{{ $row->id }}">{{ $row->service_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="Tel">Qty :</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-cubes"></i>
                                    </div>
                                    <input class="form-control" id="qty" name="qty" onkeyup="this.value=this.value.replace(/[^\d]/,'')" required>
                                </div>
                            </div>


                            <div class="form-group col-md-12">
                                <label for="weight">Weight :</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-balance-scale"></i>
                                    </div>
                                    <input class="form-control" id="weight" name="weight" required>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left btn-flat" data-dismiss="modal">
                            <i class="fa fa-close"></i> Close
                        </button>
                        <button type="submit" class="btn btn-primary btn-flat">
                            <i class="fa fa-save"></i> Save Order
                        </button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{-- Create --}}

    {{-- Edit --}}
    <div class="modal fade" id="modal-edit-item">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">
                        <i class="fa fa-pencil"></i> Edit Item
                    </h4>
                </div>
                <form method="post" id="frm-edit-order">
                    <div class="modal-body">

                        {{ csrf_field() }}

                        <input type="hidden" id="id" name="id" />

                        <div class="row">

                            <div class="form-group col-md-12">
                                <label for="Tel">Product :</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-tag"></i>
                                    </div>
                                    <select class="form-control" id="product_id" name="product_id" required>
                                        <option value="">-- Choose Product --</option>
                                        @foreach ($products as $row)
                                            <option value="{{ $row->id }}">{{ $row->product_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="service_id">Service :</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-inbox"></i>
                                    </div>
                                    <select class="form-control" id="service_id" name="service_id" required>
                                        <option value="">-- Choose Service --</option>
                                        @foreach ($service as $row)
                                            <option value="{{ $row->id }}">{{ $row->service_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="Tel">Qty :</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-cubes"></i>
                                    </div>
                                    <input class="form-control" id="qty" name="qty" onkeyup="this.value=this.value.replace(/[^\d]/,'')" required>
                                </div>
                            </div>


                            <div class="form-group col-md-12">
                                <label for="weight">Weight :</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-balance-scale"></i>
                                    </div>
                                    <input class="form-control" id="weight" name="weight" required>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left btn-flat" data-dismiss="modal">
                            <i class="fa fa-close"></i> Close
                        </button>
                        <button type="submit" class="btn btn-primary btn-flat">
                            <i class="fa fa-save"></i> Save Order
                        </button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{-- Edit --}}

    {{-- Payment --}}
    <div class="modal fade modal-success" id="modal-form-payment">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">
                        <i class="fa fa-credit-card"></i> Form Payment
                    </h4>
                </div>
                <form method="post" id="frm-payment">
                    <div class="modal-body">

                        {{ csrf_field() }}

                        <input type="hidden" id="order_id" name="order_id" value="{{ $agent_invoice_id }}" />

                        <div class="row">

                            <div class="form-group col-md-6">
                                <label for="Tel">Amount Riel :</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-money"></i>
                                    </div>
                                    <input class="form-control" id="amount_riel" value="0" name="amount_riel" required>
                                </div>
                            </div>


                            <div class="form-group col-md-6">
                                <label for="weight">Amount Dollar :</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-money"></i>
                                    </div>
                                    <input class="form-control" id="amount_dollar" value="0" name="amount_dollar" required
                                        disabled>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="pay_type">Payment Type :</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-tag"></i>
                                    </div>
                                    <select class="form-control" id="pay_type" name="pay_type" required>
                                        <option value="Cash">Cash</option>
                                        <option value="Bank">Bank</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left btn-flat" data-dismiss="modal">
                            <i class="fa fa-close"></i> Close
                        </button>
                        <button type="submit" class="btn btn-primary btn-flat">
                            <i class="fa fa-send"></i> Payment Now
                        </button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{-- Payment --}}

@endsection

@section('script')
    <script type="text/javascript">
        $(function() {
            let token = $('input[name="_token"]').val();

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
            
            InputOnlyPrice('#frm-payment #amount_riel');
           // InputOnlyPrice('#frm-add-order #qty');
            InputOnlyPrice('#frm-add-order #weight');
           // InputOnlyPrice('#frm-edit-order #qty');
            InputOnlyPrice('#frm-edit-order #weight');

            // agent id no change
            $('#agent_id').change(function(e) {
                e.preventDefault();
                let agent_id = $(this).val();

                $.ajax({
                    type: "post",
                    url: "/orders/set-agent-invoice",
                    data: {
                        agent_id: agent_id,
                        _token: token,
                        agent_invoice_id: {{ $agent_invoice_id }}
                    },
                    success: function(r) {
                        $('#agent_name').val(agent_id);
                    }
                });

            });

            // add now
            $('#frm-add-order').submit(function(e) {
                e.preventDefault();

                let agent_id = $('#agent_id').val();

                if (!agent_id) {
                    alert('choose phone number...');
                    return false;
                }

                let form = $('#frm-add-order').serializeArray();

                form.push({
                    name: 'agent_id',
                    value: agent_id
                });
                //console.log(form);

                $.ajax({
                    type: 'post',
                    url: '{{ Route('orders.store') }}',
                    data: form,
                    success: function(r) {
                        if (r.error) {
                            alert(r.error);
                            return false;
                        }
                        location.reload();
                    }
                });

            })

            // edit
            $(document).on('click', '#btn-edit', function() {
                let id = $(this).closest('tr').attr('data-id');

                $.ajax({
                    type: "get",
                    url: "/orders/" + id,
                    success: function(r) {
                        if (r) {

                            $('#frm-edit-order #id').val(id);
                            $('#frm-edit-order #product_id').val(r.product_id);
                            $('#frm-edit-order #service_id').val(r.service_id);
                            $('#frm-edit-order #qty').val(r.qty);
                            $('#frm-edit-order #weight').val(r.weight);

                            $('#modal-edit-item').modal('show');
                        }
                    }
                });

            });

            // on edit submit
            $('#frm-edit-order').submit(function(e) {
                e.preventDefault();

                let id = $('#frm-edit-order #id').val();

                let form = $(this).serializeArray();

                $.ajax({
                    type: "put",
                    url: "/orders/" + id,
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
            $(document).on('click', '#btn-remove', function(e) {
                let id = $(this).closest('tr').attr('data-id');

                let con = confirm('Are you sure remove?');

                if (!con) {
                    return false;
                }

                $.ajax({
                    type: "delete",
                    url: "/orders/" + id,
                    data: {
                        _token: token
                    },
                    success: function(response) {
                        if (response.error) {
                            alert(response.error);
                            return false;
                        }
                        location.reload();
                    }
                });
            });

            // payments
            $('#frm-payment').submit(function(e) {
                e.preventDefault();
                let form = $(this).serializeArray();
                console.log(form);

                $.ajax({
                    type: 'post',
                    url: '/agent/payment',
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
        });

    </script>
@endsection
