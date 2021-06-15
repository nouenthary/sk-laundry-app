 {{-- Create --}}
 <div class="modal fade" id="modal-add-service">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
                 <h4 class="modal-title"><i class="fa fa-plus"></i> New Service</h4>
             </div>
             <form method="post" id="frm-add-service">
                 <div class="modal-body">

                     {{ csrf_field() }}

                     <div class="row">

                         <div class="form-group col-md-6">
                             <label for="service_type">Service :</label>
                             <div class="input-group">
                                 <div class="input-group-addon">
                                     <i class="fa fa-inbox"></i>
                                 </div>
                                 <select class="form-control" id="service_name" name="service_name" required>
                                     <option value="">-- Choose Service --</option>
                                     @foreach ($service_type as $row)
                                         <option value="{{ $row }}">{{ $row }}</option>
                                     @endforeach
                                 </select>
                             </div>
                         </div>

                         <div class="form-group col-md-6">
                             <label for="type">Type :</label>
                             <div class="input-group">
                                 <div class="input-group-addon">
                                     <i class="fa fa-cube"></i>
                                 </div>
                                 <select class="form-control" id="type" name="type" required>
                                     <option value="">-- Choose Type --</option>
                                     <option value="Customer">Customer</option>
                                     <option value="Agent">Agent</option>
                                     <option value="Contact">Contact</option>
                                     <option value="Online">Online</option>
                                 </select>
                             </div>
                         </div>


                         <div class="form-group col-md-6">
                             <label for="unit_type">Unit Type :</label>
                             <div class="input-group">
                                 <div class="input-group-addon">
                                     <i class="fa fa-sitemap"></i>
                                 </div>
                                 <select class="form-control" id="unit_type" name="unit_type" required>
                                     <option value="">-- Choose Unit Type --</option>
                                     <option value="Kg">Kg</option>
                                     <option value="Pcs">Pcs</option>
                                 </select>
                             </div>
                         </div>

                         <div class="form-group col-md-6">
                             <label for="unit">Unit :</label>
                             <div class="input-group">
                                 <div class="input-group-addon">
                                     <i class="fa fa-tags"></i>
                                 </div>
                                 <input class="form-control" id="unit" value="1" readonly  name="unit" required>
                             </div>
                         </div>

                         <div class="form-group col-md-6">
                             <label for="price">Price :</label>
                             <div class="input-group">
                                 <div class="input-group-addon">
                                     <i class="fa fa-money"></i>
                                 </div>
                                 <input class="form-control" id="price" name="price" required>
                             </div>
                         </div>

                         <div class="form-group col-md-6">
                             <label for="discount">Discount :</label>
                             <div class="input-group">
                                 <div class="input-group-addon">
                                     <i class="fa fa-diamond"></i>
                                 </div>
                                 <input class="form-control" id="discount" name="discount" required>
                             </div>
                         </div>

                         <div class="form-group col-md-6">
                             <label for="start_date">Start Date :</label>
                             <div class="input-group">
                                 <div class="input-group-addon">
                                     <i class="fa fa-calendar-plus-o"></i>
                                 </div>
                                 <input type="date" class="form-control" id="start_date" name="start_date">
                             </div>
                         </div>

                         <div class="form-group col-md-6">
                             <label for="end_date">End Date :</label>
                             <div class="input-group">
                                 <div class="input-group-addon">
                                     <i class="fa fa-calendar-plus-o"></i>
                                 </div>
                                 <input type="date" class="form-control" id="end_date" name="end_date">
                             </div>
                         </div>

                     </div>

                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-default pull-left btn-flat" data-dismiss="modal">
                         <i class="fa fa-close"></i> Close
                     </button>
                     <button type="submit" class="btn btn-primary btn-flat">
                         <i class="fa fa-save"></i> Save Close
                     </button>
                 </div>
             </form>
         </div>
         <!-- /.modal-content -->
     </div>
     <!-- /.modal-dialog -->
 </div>
 <!-- /.modal -->
 {{-- Create --}}
