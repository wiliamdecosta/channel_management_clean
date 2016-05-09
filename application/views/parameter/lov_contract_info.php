<div id="modal_lov_contract_info" class="modal fade" tabindex="-1" style="overflow-y: scroll;">
	<div class="modal-dialog">
		<div class="modal-content">
		    <!-- modal title -->
			<div class="modal-header no-padding">
				<div class="table-header">
					<span class="form-add-edit-title"> Info Kontrak </span>
				</div>
			</div>
            <input type="hidden" id="modal_lov_contract_info_P_MP_PKS_ID" value="" />
            <input type="hidden" id="modal_lov_contract_info_CUST_PGL_ID" value="" />
            <input type="hidden" id="modal_lov_contract_info_CONTRACT_NO" value="" />
            <input type="hidden" id="modal_lov_contract_info_MITRA_NAME" value="" />
            <input type="hidden" id="modal_lov_contract_info_MITRA_ADDRESS" value="" />
            <input type="hidden" id="modal_lov_contract_info_CONTRACT_TYPE_ID" value="" />

			<!-- modal body -->
			<div class="modal-body">
			    <p>
                  <button type="button" class="btn btn-sm btn-success" id="modal_lov_contract_info_btn_blank">
  	                <span class="fa fa-pencil-square-o" aria-hidden="true"></span> BLANK
                  </button>
                 </p>

				<table id="modal_lov_contract_info_grid_selection" class="table table-striped table-bordered table-hover">
                <thead>
                  <tr>
                     <th data-column-id="P_MP_PKS_ID" data-sortable="false" data-visible="false"> P_MP_PKS_ID</th>
                     <th data-column-id="CUST_PGL_ID" data-sortable="false" data-visible="false"> CUST_PGL_ID</th>
                     <th data-header-align="center" data-align="center" data-formatter="opt-edit" data-sortable="false" data-width="100">Options</th>
                     <th data-column-id="CONTRACT_NO" data-width="200">No. Kontrak</th>
                     <th data-column-id="MITRA_NAME">Nama Mitra</th>
                     <th data-column-id="MITRA_ADDRESS">Alamat Mitra</th>
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
        $("#modal_lov_contract_info_btn_blank").on(ace.click_event, function() {
            $("#"+ $("#modal_lov_contract_info_P_MP_PKS_ID").val()).val("");
            $("#"+ $("#modal_lov_contract_info_CUST_PGL_ID").val()).val("");
            $("#"+ $("#modal_lov_contract_info_CONTRACT_NO").val()).val("");
            $("#"+ $("#modal_lov_contract_info_MITRA_NAME").val()).val("");
            $("#"+ $("#modal_lov_contract_info_MITRA_ADDRESS").val()).val("");
            $("#modal_lov_contract_info").modal("toggle");
        });
    });

    function modal_lov_contract_info_show(P_MP_PKS_ID, CUST_PGL_ID, CONTRACT_NO, MITRA_NAME, MITRA_ADDRESS, CONTRACT_TYPE_ID) {
        modal_lov_contract_info_set_field_value(P_MP_PKS_ID, CUST_PGL_ID, CONTRACT_NO, MITRA_NAME, MITRA_ADDRESS, CONTRACT_TYPE_ID);
        $("#modal_lov_contract_info").modal({backdrop: 'static'});
        modal_lov_contract_info_prepare_table();
    }


    function modal_lov_contract_info_set_field_value(P_MP_PKS_ID, CUST_PGL_ID, CONTRACT_NO, MITRA_NAME, MITRA_ADDRESS, CONTRACT_TYPE_ID) {
         $("#modal_lov_contract_info_P_MP_PKS_ID").val(P_MP_PKS_ID);
         $("#modal_lov_contract_info_CUST_PGL_ID").val(CUST_PGL_ID);
         $("#modal_lov_contract_info_CONTRACT_NO").val(CONTRACT_NO);
         $("#modal_lov_contract_info_MITRA_NAME").val(MITRA_NAME);
         $("#modal_lov_contract_info_MITRA_ADDRESS").val(MITRA_ADDRESS);
         $("#modal_lov_contract_info_CONTRACT_TYPE_ID").val(CONTRACT_TYPE_ID);
    }

    function modal_lov_contract_info_set_value(P_MP_PKS_ID, CUST_PGL_ID, CONTRACT_NO, MITRA_NAME, MITRA_ADDRESS) {
         $("#"+ $("#modal_lov_contract_info_P_MP_PKS_ID").val()).val(P_MP_PKS_ID);
         $("#"+ $("#modal_lov_contract_info_CUST_PGL_ID").val()).val(CUST_PGL_ID);
         $("#"+ $("#modal_lov_contract_info_CONTRACT_NO").val()).val(CONTRACT_NO);
         $("#"+ $("#modal_lov_contract_info_MITRA_NAME").val()).val(MITRA_NAME);
         $("#"+ $("#modal_lov_contract_info_MITRA_ADDRESS").val()).val(MITRA_ADDRESS);
         $("#modal_lov_contract_info").modal("toggle");
         
         $("#"+ $("#modal_lov_contract_info_P_MP_PKS_ID").val()).change();
    }

    function modal_lov_contract_info_prepare_table() {
        $("#modal_lov_contract_info_grid_selection").bootgrid("destroy");
        $("#modal_lov_contract_info_grid_selection").bootgrid({
    	     formatters: {
                "opt-edit" : function(col, row) {
                    return '<a href="#'+ $("#modal_lov_contract_info_CONTRACT_NO").val() +'" title="Set Value" onclick="modal_lov_contract_info_set_value(\''+ row.P_MP_PKS_ID +'\', \''+ row.CUST_PGL_ID +'\', \''+ row.CONTRACT_NO +'\', \''+ row.MITRA_NAME +'\', \''+ row.MITRA_ADDRESS +'\')" class="blue"><i class="ace-icon fa 	fa-pencil-square-o bigger-130"></i></a>';
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
       	   url: "<?php echo site_url('parameter/gridLovGetContract');?>",
           post: function (){
                return {
                    idd : $('#modal_lov_contract_info_CONTRACT_TYPE_ID').val()
                }
           },
    	     selection: true,
    	     sorting:true
    	});
    }

</script>