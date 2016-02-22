<?php date_default_timezone_set('Asia/Jakarta'); ?>
<div class="row" style="margin-top:20px;display:none;" id="user_attribute_form_add_edit">
    <div class="col-xs-12">
        <div class="well well-sm"> <h4 class="blue" id="user_attribute_form_title"> Add/Edit User Attribute </h4></div>
        <form class="form-horizontal" role="form" id="user_attribute_form">           
            
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right"> Attribute Type </label>
                <div class="col-sm-8">
                    <input id="form_p_user_attribute_id" type="text" style="display:none;" placeholder="User Attribute ID">
                    
                    <input id="form_p_user_attribute_type_id" type="text"  style="display:none;">
                    <input id="form_p_user_attribute_type_code" type="text" class="col-xs-10 col-sm-5 required" placeholder="Choose Attribute Type">
                    <span class="input-group-btn">
						<button class="btn btn-warning btn-sm" type="button" id="btn_lov_user_attribute_type">
							<span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
						</button>
					</span>
                </div>
                
            </div>
            
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right"> Attribute List </label>
                <div class="col-sm-8">
                    <input id="form_p_user_attribute_list_id" type="text" style="display:none;">
                    <input id="form_p_user_attribute_list_code" type="text" class="col-xs-10 col-sm-5"  placeholder="Choose Attribute List">
                    <span class="input-group-btn">
						<button class="btn btn-warning btn-sm" type="button" id="btn_lov_user_attribute_list">
							<span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
						</button>
					</span>
                </div>
                
            </div>
            
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right"> Attribute Value </label>
                <div class="col-sm-9">
                    <input id="form_user_attribute_value" class="col-xs-10 col-sm-5 required" type="text">
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right"> Valid From </label>
                <div class="col-sm-9">
                    <div class="input-group col-xs-3">
                        <input type="text" data-date-format="dd-mm-yyyy" id="form_valid_from" class="form-control required date-picker">
                        <span class="input-group-addon">
        					<i class="fa fa-calendar bigger-110"></i>
    					</span>
					</div> 
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right"> Valid To </label>
                <div class="col-sm-9">
                    <div class="input-group col-xs-3">
                        <input type="text" data-date-format="dd-mm-yyyy" id="form_valid_to" class="form-control date-picker">
                        <span class="input-group-addon">
        					<i class="fa fa-calendar bigger-110"></i>
    					</span>
					</div> 
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right"> Description </label>
                <div class="col-sm-9">
                    <textarea id="form_description" class="col-xs-10 col-sm-5" type="text"></textarea>
                </div>
            </div>

            <?php
			    $ci =& get_instance();
	            $user_name = $ci->session->userdata('d_user_name');
			?>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right"> Created By </label>
                <div class="col-sm-9">
                    <input id="form_created_by" disabled type="text" value="<?php echo $user_name; ?>">
                    &nbsp;  <input id="form_creation_date" disabled type="text" value="<?php echo date("d-m-Y"); ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right"> Updated By </label>
                <div class="col-sm-9">
                    <input id="form_updated_by" disabled type="text" value="<?php echo $user_name; ?>">
                    &nbsp; <input id="form_updated_date" disabled type="text" value="<?php echo date("d-m-Y"); ?>">
                </div>
            </div>

           <div class="space-4"></div>

           <div class="clearfix form-actions">
		        <div class="center col-md-9">
			      	<button type="button" class="btn btn-primary btn-xs btn-round" id="user_attribute_form_btn_save">
			      		<i class="ace-icon fa fa-floppy-o bigger-120"></i>
			      		Save
			      	</button>
                    
                    <button type="reset" class="btn btn-danger btn-xs btn-round" id="user_attribute_form_btn_cancel">
                        <i class="glyphicon glyphicon-circle-arrow-left bigger-120"></i>
                        Cancel
                    </button>
			      	
			    </div>
		   </div>
       </form>
    </div>
</div>

<?php $this->load->view('parameter/lov_p_user_attribute_type.php'); ?>
<?php $this->load->view('parameter/lov_p_user_attribute_list.php'); ?>

<script>
    jQuery(function($) {
        $("#user_attribute_form_btn_cancel").on(ace.click_event, function() {
            user_attribute_toggle_main_content();
        });
    
        $("#user_attribute_form_btn_save").on(ace.click_event, function() {
            user_attribute_save();
        });
        
        $("#btn_lov_user_attribute_type").on(ace.click_event, function() {
            modal_lov_user_attribute_type_show("form_p_user_attribute_type_id","form_p_user_attribute_type_code");
        });
        
        $("#btn_lov_user_attribute_list").on(ace.click_event, function() {
            if( $("#form_p_user_attribute_type_id").val() == "") {
                //showBootDialog(true, BootstrapDialog.TYPE_WARNING, 'Attention', 'Inputkan Attribute Type Terlebih Dahulu');
                swal("Informasi", "Inputkan Attribute Type Terlebih Dahulu", "info");
                return;
            }
            $("#modal_lov_user_attribute_list_grid_selection").bootgrid("destroy");
            modal_lov_user_attribute_list_prepare_table();
            modal_lov_user_attribute_list_show("form_p_user_attribute_list_id","form_p_user_attribute_list_code");
        });
        
        $('#form_p_user_attribute_type_id').on('change',function(){
            $('#form_p_user_attribute_list_id').val("");   
            $('#form_p_user_attribute_list_code').val("");
        });
        
        $("#form_valid_from").datepicker({ autoclose: true, todayHighlight: true });
        $("#form_valid_to").datepicker({ autoclose: true, todayHighlight: true });
    });

    function user_attribute_toggle_main_content() {
        $("#user_attribute_form")[0].reset();
        
        $("#user_attribute_form_add_edit").hide();
        $("#user_attribute_row_content").toggle("slow");
    }

    function user_attribute_show_form_add() {
        user_attribute_toggle_main_content();
        $("#user_attribute_form_add_edit").show("slow");
        $("#user_attribute_form_title").html("Add User Attribute");
    }

    function user_attribute_show_form_edit(theID) {
        user_attribute_toggle_main_content();
        $("#user_attribute_form_add_edit").show("slow");
        $("#user_attribute_form_title").html("Edit User Attribute");
        
        $("#form_p_user_attribute_id").val(theID);
        $.post( "<?php echo site_url('user_attribute/gridUserAttribute');?>",
            {
                p_user_attribute_id : $("#form_p_user_attribute_id").val()
            },
            function( response ) {
                var response = JSON.parse(response);
                if(response.success == false) {
                    //showBootDialog(true, BootstrapDialog.TYPE_WARNING, 'Attention', response.message);
                    swal("Perhatian", response.message, "warning");
                }else {
        	        var obj = response.rows[0];
        	        
        	        $("#form_p_user_attribute_id").val(obj.P_USER_ATTRIBUTE_ID);
        	        $("#form_user_id").val(obj.USER_ID);
        	        $("#form_p_user_attribute_type_id").val(obj.P_USER_ATTRIBUTE_TYPE_ID);
                    $("#form_p_user_attribute_list_id").val(obj.P_USER_ATTRIBUTE_LIST_ID);
                    $("#form_p_user_attribute_type_code").val(obj.TYPE_CODE);
                    $("#form_p_user_attribute_list_code").val(obj.LIST_CODE);
                    $("#form_user_attribute_value").val(obj.USER_ATTRIBUTE_VALUE);
                    $("#form_valid_from").datepicker("update", obj.VALID_FROM);
        	        $("#form_valid_to").datepicker("update", obj.VALID_TO);                     
                    $("#form_description").val(obj.DESCRIPTION)
        	        
        	        $("#form_created_by").val(obj.CREATED_BY);
        	        $("#form_creation_date").val(obj.CREATION_DATE);
        	        $("#form_updated_by").val(obj.UPDATED_BY);
        	        $("#form_updated_date").val(obj.UPDATED_DATE);
        	        
                }
            }
        );
        
    }

    function user_attribute_save() {
        var action_execute = "";

        //jika ID kosong, panggil method create. Jika ID ada, maka panggil method update
        action_execute = ( $("#form_p_user_attribute_id").val() == "") ? "create" : "update";
        $.post( "<?php echo site_url('user_attribute/crudUserAttribute');?>" + "/" + action_execute,
            {items: JSON.stringify({
                    P_USER_ATTRIBUTE_ID     : $("#form_p_user_attribute_id").val(),
                    USER_ID                 : $("#form_user_id").val(),
                    P_USER_ATTRIBUTE_TYPE_ID : $("#form_p_user_attribute_type_id").val(),
                    P_USER_ATTRIBUTE_LIST_ID : $("#form_p_user_attribute_list_id").val(),
                    USER_ATTRIBUTE_VALUE : $("#form_user_attribute_value").val(),
                    VALID_FROM           : $("#form_valid_from").val(),
                    VALID_TO             : $("#form_valid_to").val(),                         
                    DESCRIPTION         : $("#form_description").val()
                })
            },
            function( response ) {
                
                var response = JSON.parse(response);
                if(response.success == false) {
                    //showBootDialog(true, BootstrapDialog.TYPE_WARNING, 'Attention', response.message);
                    swal({title: "Perhatian",text: response.message, html: true, type : 'warning'});
                }else {
        	        //showBootDialog(true, BootstrapDialog.TYPE_SUCCESS, 'Information', response.message);
        	        swal("Berhasil", response.message, "success");
        	        user_attribute_toggle_main_content();
        	        user_attribute_prepare_table($("#form_user_id").val());
                }
            }
        );
    }
</script>