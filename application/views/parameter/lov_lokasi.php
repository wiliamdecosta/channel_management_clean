<div id="modal_lov_lokasi" class="modal fade" tabindex="-1" style="overflow-y: scroll;">
	<div class="modal-dialog">
		<div class="modal-content">
		    <!-- modal title -->
			<div class="modal-header no-padding">
				<div class="table-header">
					<span class="form-add-edit-title"> Data Role </span>
				</div>
			</div>
            <input type="hidden" id="modal_lov_lokasi_id_val" value="" />
            <input type="hidden" id="modal_lov_lokasi_code_val" value="" />
            <input type="hidden" id="modal_lov_lokasi_plg_id" value="" />

			<!-- modal body -->
			<div class="modal-body">
			    <p>
                  <button type="button" class="btn btn-sm btn-success" id="modal_lov_lokasi_btn_blank">
  	                <span class="fa fa-pencil-square-o" aria-hidden="true"></span> BLANK
                  </button>
                 </p>

				<table id="modal_lov_lokasi_grid_selection" class="table table-striped table-bordered table-hover">
                <thead>
                  <tr>
                     <th data-column-id="P_LOCATION_ID" data-sortable="false" data-visible="false">LOCATION ID</th>
                     <th data-header-align="center" data-align="center" data-formatter="opt-edit" data-sortable="false" data-width="100">Options</th>
                     <th data-column-id="LOKASI">Nama Lokasi</th>
                     <th data-column-id="VALID_FROM">Berlaku Dari</th>
                     <th data-column-id="VALID_UNTIL">Sampai</th>
                  </tr>
                </thead>
                </table>
			</div>

			<!-- modal footer -->
			<div class="modal-footer no-margin-top">
			    <div class="bootstrap-dialog-footer">
			        <div class="bootstrap-dialog-footer-buttons">
        				<button class="btn btn-danger btn-xs radius-4" data-dismiss="modal">
        					<i class="ace-icon fa fa-times"></i>
        					Close
        				</button>
    				</div>
				</div>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.end modal -->

<script>

    jQuery(function($) {
        $("#modal_lov_lokasi_btn_blank").on(ace.click_event, function() {
            $("#"+ $("#modal_lov_lokasi_id_val").val()).val("");
            $("#"+ $("#modal_lov_lokasi_code_val").val()).val("");
            $("#modal_lov_lokasi").modal("toggle");
        });
    });

    function modal_lov_lokasi_show(the_id_field, the_code_field, the_pgl_id) {
        modal_lov_lokasi_set_field_value(the_id_field, the_code_field, the_pgl_id);
        $("#modal_lov_lokasi").modal({backdrop: 'static'});
        modal_lov_lokasi_prepare_table();
    }


    function modal_lov_lokasi_set_field_value(the_id_field, the_code_field, the_pgl_id) {
         $("#modal_lov_lokasi_id_val").val(the_id_field);
         $("#modal_lov_lokasi_code_val").val(the_code_field);
         $("#modal_lov_lokasi_plg_id").val(the_pgl_id);
    }

    function modal_lov_lokasi_set_value(the_id_val, the_code_val) {
         $("#"+ $("#modal_lov_lokasi_id_val").val()).val(the_id_val);
         $("#"+ $("#modal_lov_lokasi_code_val").val()).val(the_code_val);
         $("#modal_lov_lokasi").modal("toggle");
         
         $("#"+ $("#modal_lov_lokasi_id_val").val()).change();
    }

    function modal_lov_lokasi_prepare_table() {
      $("#modal_lov_lokasi_grid_selection").bootgrid("destroy");
        $("#modal_lov_lokasi_grid_selection").bootgrid({
    	     formatters: {
                "opt-edit" : function(col, row) {
                    return '<a href="#'+ $("#modal_lov_lokasi_code_val").val() +'" title="Set Value" onclick="modal_lov_lokasi_set_value(\''+ row.P_LOCATION_ID +'\', \''+ row.LOKASI +'\')" class="blue"><i class="ace-icon fa 	fa-pencil-square-o bigger-130"></i></a>';
                }
             },
    	     rowCount:[5,10],
    		 ajax: true,
    	     requestHandler:function(request) {
    	        if(request.sort) {
    	            var sortby = Object.keys(request.sort)[0];
    	            request.dir = request.sort[sortby];

    	            delete request.sort;
    	            request.sort = sortby;
    	        }
    	        return request;
    	     },
    	     responseHandler:function (response) {
    	        if(response.success == false) {
    	            showBootDialog(true, BootstrapDialog.TYPE_WARNING, 'Attention', response.message);
    	        }
    	        return response;
    	     },
       	   url: "<?php echo site_url('parameter/gridLovLokasi');?>",
           post: function (){
                return {
                    plg_id : $('#modal_lov_lokasi_plg_id').val()
                }
           },
    	     selection: true,
    	     sorting:true
    	});
    }

</script>