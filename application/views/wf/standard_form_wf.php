<!-- #section:basics/content.breadcrumbs -->
<div class="breadcrumbs" id="breadcrumbs">
    <?php echo getBreadcrumb(array('Workflow Summary','Standard Form WF')); ?>
</div>

<div class="page-content">
    <!-- parameter untuk kembali ke workflow summary -->
    <input type="hidden" id="TEMP_ELEMENT_ID" value="<?php echo $this->input->post('ELEMENT_ID'); ?>" />
    <input type="hidden" id="TEMP_PROFILE_TYPE" value="<?php echo $this->input->post('PROFILE_TYPE'); ?>" />
    <input type="hidden" id="TEMP_P_W_DOC_TYPE_ID" value="<?php echo $this->input->post('P_W_DOC_TYPE_ID'); ?>" />
    <input type="hidden" id="TEMP_P_W_PROC_ID" value="<?php echo $this->input->post('P_W_PROC_ID'); ?>" />
    <input type="hidden" id="TEMP_USER_ID" value="<?php echo $this->input->post('USER_ID'); ?>" />
    <input type="hidden" id="TEMP_FSUMMARY" value="<?php echo $this->input->post('FSUMMARY'); ?>" />
    <!-- end type hidden -->

    <!-- paramater untuk kebutuhan submit dan status -->
    <input type="hidden" id="CURR_DOC_ID" value="<?php echo $this->input->post('CURR_DOC_ID'); ?>">
    <input type="hidden" id="CURR_DOC_TYPE_ID" value="<?php echo $this->input->post('CURR_DOC_TYPE_ID'); ?>">
    <input type="hidden" id="CURR_PROC_ID" value="<?php echo $this->input->post('CURR_PROC_ID'); ?>">
    <input type="hidden" id="CURR_CTL_ID" value="<?php echo $this->input->post('CURR_CTL_ID'); ?>">
    <input type="hidden" id="USER_ID_DOC" value="<?php echo $this->input->post('USER_ID_DOC'); ?>">
    <input type="hidden" id="USER_ID_DONOR" value="<?php echo $this->input->post('USER_ID_DONOR'); ?>">
    <input type="hidden" id="USER_ID_LOGIN" value="<?php echo $this->input->post('USER_ID_LOGIN'); ?>">
    <input type="hidden" id="USER_ID_TAKEN" value="<?php echo $this->input->post('USER_ID_TAKEN'); ?>">
    <input type="hidden" id="IS_CREATE_DOC" value="<?php echo $this->input->post('IS_CREATE_DOC'); ?>">
    <input type="hidden" id="IS_MANUAL" value="<?php echo $this->input->post('IS_MANUAL'); ?>">
    <input type="hidden" id="CURR_PROC_STATUS" value="<?php echo $this->input->post('CURR_PROC_STATUS'); ?>">
    <input type="hidden" id="CURR_DOC_STATUS" value="<?php echo $this->input->post('CURR_DOC_STATUS'); ?>">
    <input type="hidden" id="PREV_DOC_ID" value="<?php echo $this->input->post('PREV_DOC_ID'); ?>">
    <input type="hidden" id="PREV_DOC_TYPE_ID" value="<?php echo $this->input->post('PREV_DOC_TYPE_ID'); ?>">
    <input type="hidden" id="PREV_PROC_ID" value="<?php echo $this->input->post('PREV_PROC_ID'); ?>">
    <input type="hidden" id="PREV_CTL_ID" value="<?php echo $this->input->post('PREV_CTL_ID'); ?>">
    <input type="hidden" id="SLOT_1" value="<?php echo $this->input->post('SLOT_1'); ?>">
    <input type="hidden" id="SLOT_2" value="<?php echo $this->input->post('SLOT_2'); ?>">
    <input type="hidden" id="SLOT_3" value="<?php echo $this->input->post('SLOT_3'); ?>">
    <input type="hidden" id="SLOT_4" value="<?php echo $this->input->post('SLOT_4'); ?>">
    <input type="hidden" id="SLOT_5" value="<?php echo $this->input->post('SLOT_5'); ?>">
    <input type="hidden" id="MESSAGE" value="<?php echo $this->input->post('MESSAGE'); ?>">
    <input type="hidden" id="PROFILE_TYPE" value="<?php echo $this->input->post('PROFILE_TYPE'); ?>">
    <input type="hidden" id="ACTION_STATUS" value="<?php echo $this->input->post('ACTION_STATUS'); ?>">
    <!-- end type hidden -->

    <div class="row">
        <div class="col-xs-12">
            <div class="well well-sm">
                <div class="inline middle blue bigger-150"> Standard Form </div>
            </div>
            <form class="form-horizontal" application="form" id="form_customer_order">
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right"> ORDER NO </label>
                    <div class="col-sm-9">
                        <input id="form_t_customer_order_id" name="t_customer_order_id" type="text" value="<?php echo $this->input->post('CURR_DOC_ID'); ?>" style="display:none;">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                        <input id="form_order_no" name="order_no" class="col-xs-10 col-sm-5 required" type="text">
                    </div>
                </div>

                <div class="space-4"></div>

                <div class="clearfix form-actions">
                    <div class="center col-md-9">
                        <button type="button" class="btn btn-sm btn-primary btn-round" id="form_customer_order_btn_submit">
                            <i class="ace-icon glyphicon glyphicon-upload bigger-120"></i>
                            Submit
                        </button>
                        <button type="submit" class="btn btn-sm btn-success btn-round" id="form_customer_order_btn_save">
                            <i class="ace-icon fa fa-floppy-o bigger-120"></i>
                            Simpan
                        </button>
                        <button type="button" class="btn btn-sm btn-danger btn-round" id="form_customer_order_btn_cancel">
                            <i class="glyphicon glyphicon-circle-arrow-left bigger-120"></i>
                            Kembali
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<?php $this->load->view('wf/lov_submitter.php'); ?>

<script>
    
    $(function() {

        /* parameter kembali ke workflow summary */
        params_back_summary = {};
        params_back_summary.ELEMENT_ID = $('#TEMP_ELEMENT_ID').val();
        params_back_summary.PROFILE_TYPE = $('#TEMP_PROFILE_TYPE').val();
        params_back_summary.P_W_DOC_TYPE_ID = $('#TEMP_P_W_DOC_TYPE_ID').val();
        params_back_summary.P_W_PROC_ID = $('#TEMP_P_W_PROC_ID').val();
        params_back_summary.USER_ID = $('#TEMP_USER_ID').val();
        params_back_summary.FSUMMARY = $('#TEMP_FSUMMARY').val();
        /* end parameter */

        /*ketika link 'workflow summary' diklik, maka kembali ke summary */
        $("a").on('click', function(e) {
            var txt = $(e.target).text();
            if( txt.toLowerCase() == 'workflow summary' ) {
                loadContentWithParams( $('#TEMP_FSUMMARY').val() , params_back_summary );
            }
        });

        /*ketika tombol cancel diklik, maka kembali ke summary*/
        $("#form_customer_order_btn_cancel").on('click', function() {
            loadContentWithParams( $('#TEMP_FSUMMARY').val() , params_back_summary );
        });



        /* cek jika tipe view */
        if (  $('#ACTION_STATUS').val() == 'VIEW' ) {
            $('#form_customer_order_btn_submit').remove();
            $('#form_customer_order_btn_save').remove();
        }

        /* mengisi form customer order */
        $.ajax({
            type: 'POST',
            datatype: "json",
            url: '<?php echo site_url('workflow_parameter/grid_customer_order');?>',
            data: { t_customer_order_id : $("#CURR_DOC_ID").val(), page:1, rows:1 },
            timeout: 10000,
            success: function(data) {
                var response = JSON.parse( data );
                var items = response.Data[0];
                
                $("#form_order_no").val( items.ORDER_NO );
            }
        });

        /*menyimpan data customer order */
        $("#form_customer_order").on('submit', (function (e) {
            e.preventDefault();
            var data = $(this).serialize();
           // data.append('ten_id', ten_id);
            $.ajax({
                url: "<?php echo site_url('workflow_parameter/setCustomerOrder');?>", // Url to which the request is send
                type: "POST",             // Type of request to be send, called as method
                data: data, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                cache: false,             // To unable request pages to be cached
                dataType: "json",
                success: function (data)   // A function to be called if request succeeds
                {
                    if (data.success == true) {
                        swal("", data.msg, "success");
                    } else {
                        swal("", data.msg, "error");
                    }
                }
            });
            return false;
        }));
        

        /* ketika button submit diklik, tampilkan lov submitter diikuti parameter-parameternya */
        $("#form_customer_order_btn_submit").on('click',function(){
            var params_submit = {};
            
            params_submit.CURR_DOC_ID         = $('#CURR_DOC_ID').val();  
            params_submit.CURR_DOC_TYPE_ID    = $('#CURR_DOC_TYPE_ID').val();
            params_submit.CURR_PROC_ID        = $('#CURR_PROC_ID').val();
            params_submit.CURR_CTL_ID         = $('#CURR_CTL_ID').val();
            params_submit.USER_ID_DOC         = $('#USER_ID_DOC').val();
            params_submit.USER_ID_DONOR       = $('#USER_ID_DONOR').val();
            params_submit.USER_ID_LOGIN       = $('#USER_ID_LOGIN').val();
            params_submit.USER_ID_TAKEN       = $('#USER_ID_TAKEN').val();
            params_submit.IS_CREATE_DOC       = $('#IS_CREATE_DOC').val();
            params_submit.IS_MANUAL           = $('#IS_MANUAL').val();
            params_submit.CURR_PROC_STATUS    = $('#CURR_PROC_STATUS').val();
            params_submit.CURR_DOC_STATUS     = $('#CURR_DOC_STATUS').val();
            params_submit.PREV_DOC_ID         = $('#PREV_DOC_ID').val();
            params_submit.PREV_DOC_TYPE_ID    = $('#PREV_DOC_TYPE_ID').val();
            params_submit.PREV_PROC_ID        = $('#PREV_PROC_ID').val();
            params_submit.PREV_CTL_ID         = $('#PREV_CTL_ID').val();
            params_submit.SLOT_1              = $('#SLOT_1').val();    
            params_submit.SLOT_2              = $('#SLOT_2').val(); 
            params_submit.SLOT_3              = $('#SLOT_3').val();    
            params_submit.SLOT_4              = $('#SLOT_4').val();  
            params_submit.SLOT_5              = $('#SLOT_5').val();    
            params_submit.MESSAGE             = $('#MESSAGE').val();    
            params_submit.PROFILE_TYPE        = $('#PROFILE_TYPE').val();
            params_submit.ACTION_STATUS       = $('#ACTION_STATUS').val();

            modal_lov_submitter_show(params_submit, params_back_summary);    
        });

    });
</script>