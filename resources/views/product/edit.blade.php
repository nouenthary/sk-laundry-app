 {{-- Edit --}}
 <div class="modal fade" id="modal-edit-product">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><i class="fa fa-pencil"></i> Edit Product</h4>
            </div>
            <form method="post" id="frm-edit-product" name="frm-edit-product">
                <div class="modal-body">

                    {{ csrf_field() }}

                    <input type="hidden" id="id" name="id"/>

                    <div class="row">

                        <div class="form-group col-md-12">
                            <label for="product_name">Product :</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-tags"></i>
                                </div>
                                <input class="form-control" id="product_name" name="product_name" required>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="photo">Photo :</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-photo"></i>
                                </div>
                                <input type="file" class="form-control" id="file" name="file">
                                <input type="hidden" id="photo" name="photo"/>
                            </div>
                        </div>


                        <div class="form-group col-md-12">
                            <label for="photo">Note :</label>
                            <textarea class="form-control" id="desc" name="desc"></textarea>
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
{{-- Edit --}}
