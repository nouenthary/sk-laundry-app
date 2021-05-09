@extends('admin.master')

@section('style')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
@endsection

@section('title', 'Order')

@section('content')

{{--    {{$agent_invoices[0]}}--}}

    <div style="padding-top: 5px"></div>

    <div class="box box-primary">
        <div class="box-body">
            <div class="form-group">
                <label>Agent Phone</label>
                <select class="form-control" name="agent_id" id="agent_id">
                    <option value="">-- Choose Agent --</option>
                    @foreach($agents as $row)
                        <option value="{{$row->id}}">{{$row->tel}}</option>
                    @endforeach
                </select>
            </div>

            <form id="form-add-order">
                {{csrf_field()}}
                <input type="hidden" id="agent_invoice_id" name="agent_invoice_id" value="{{$agent_invoice_id}}">

                <div class="form-group">
                    <label>Category</label>
                    <select class="form-control" id="category_id" name="category_id" required>
                        <option value="">-- Choose Category --</option>
                        @foreach($categories as $row)
                            <option value="{{$row->id}}">{{$row->category_name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Product</label>
                    <select class="form-control" id="product_id" name="product_id" required>
                        <option value="">-- Choose Product --</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Service</label>
                    <select class="form-control" id="service_id" name="service_id" required>
                        <option value="">-- Choose Service --</option>
                        @foreach($service as $row)
                            <option value="{{$row->id}}">{{$row->service_name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Qty</label>
                    <input class="form-control" id="qty" name="qty" required>
                </div>

                <div class="form-group">
                    <label>Weight</label>
                    <input class="form-control" id="weight" name="weight" required>
                </div>

                <div class="pull-right">
                    <button class="btn btn-primary btn-sm">Add Now</button>
                </div>

            </form>

            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Service</th>
                    <th>Category</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Discount</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($agent_invoices as $row)
                    <tr data-id="{{$row->id}}">
                        <td>{{$row->service_name}}</td>
                        <td>{{$row->category_name}}</td>
                        <td>{{$row->product_name}}</td>
                        <td>{{$row->price}} R</td>
                        <td>{{$row->discount}} %</td>
                        <td>{{$row->total}} R</td>
                        <td>
                            <a class="btn btn-primary btn-xs" id="btn-edit"><i class="fa fa-pencil"></i></a>
                            <a class="btn btn-danger btn-xs" id="btn-remove"><i class="fa fa-minus"></i></a>
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
                    <th>{{$total_row}} R</th>
                    <th></th>
                </tr>
                </tfoot>
            </table>

        </div>
    </div>


    {{csrf_field()}}

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

            //
            $('#category_id').change(function () {
                let id = $(this).val();

                $.ajax({
                   type: 'post',
                   url: '/product-by-category',
                   data: {
                       _token: token, id: id
                   },
                   success: function (r) {
                      if(r){

                          $('#product_id').empty();

                          $.each(r, function (i, item) {
                              $('#product_id').append($('<option>', {
                                  value: item.id,
                                  text : item.product_name
                              }));
                          });
                      }
                   }
                });
            });

            // add now
            $('#form-add-order').submit(function (e) {
                e.preventDefault();

                let agent_id = $('#agent_id').val();

                let form = $('#form-add-order').serializeArray();

                form.push({name: 'agent_id', value: agent_id});
                console.log(form);

                $.ajax({
                    type: 'post',
                    url: '{{Route('orders.store')}}',
                    data: form,
                    success: function (r) {
                        console.log(r);
                    }
                });

            })


            // remove
            $(document).on('click','#btn-remove',function (e) {
                let id = $(this).closest('tr').attr('data-id');
                alert(id)
            });
        });
    </script>
@endsection

