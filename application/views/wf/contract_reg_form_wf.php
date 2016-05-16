<!-- #section:basics/content.breadcrumbs -->
<div class="breadcrumbs" id="breadcrumbs">
    <?php echo getBreadcrumb(array('Workflow Summary','Kontrak Form WF')); ?>
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
        <div class="widget-box">
            <div class="widget-header widget-header-blue widget-header-flat">
                <h4 class="widget-title lighter"> Kontrak Form </h4>
            </div>


            <div class="widget-body">
                <div class="widget-main">
                    <div id="fuelux-wizard-container">
                        <div>
                            <ul class="steps">
                                <li data-step="1" class="active">
                                    <span class="step">1</span>
                                    <span class="title">Permohonan</span>
                                </li>

                                <li data-step="2">
                                    <span class="step">2</span>
                                    <span class="title">Log Aktifitas</span>
                                </li>

                                <li data-step="3">
                                    <span class="step">3</span>
                                    <span class="title">Dokumen Pendukung</span>
                                </li>
                            </ul>

                        </div>

                        <hr />

                        <div class="step-content pos-rel">
                            <div class="step-pane active" data-step="1">
                                <div class="center">
                                    <h3 class="blue lighter">Form Permohonan</h3>
                                </div>
                                <hr>
                                <form class="form-horizontal" id="sample-form">

                                    <input id="form_t_customer_order_id" name="t_customer_order_id" type="text" value="<?php echo $this->input->post('CURR_DOC_ID'); ?>" style="display:none;">
                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                    <div class="form-group">
                                        <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="name">Nama Dokumen:</label>
                                        <div class="col-xs-12 col-sm-9">
                                            <div class="clearfix">
                                                <input type="text" id="doc_name" name="doc_name" class="col-xs-12 col-sm-5" readonly />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="name">No. Order:</label>
                                        <div class="col-xs-12 col-sm-9">
                                            <div class="clearfix">
                                                <input type="text" id="order_no" name="order_no" class="col-xs-12 col-sm-3" readonly />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="name">Tanggal Order:</label>
                                        <div class="col-xs-12 col-sm-9">
                                            <div class="clearfix">
                                                <input type="text" id="order_date" name="order_date" class="col-xs-12 col-sm-2" readonly />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="name">No. Kontrak:</label>
                                        <div class="col-xs-12 col-sm-9">
                                            <div class="clearfix">
                                                <input type="text" id="contract_no" name="contract_no" class="col-xs-12 col-sm-3" readonly />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="name">Nama Mitra:</label>
                                        <div class="col-xs-12 col-sm-9">
                                            <div class="clearfix">
                                                <input type="text" id="pgl_name" name="pgl_name" class="col-xs-12 col-sm-5" readonly />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="name">Alamat:</label>
                                        <div class="col-xs-12 col-sm-9">
                                            <div class="clearfix">
                                                <textarea class="col-xs-12 col-sm-5" rows="3" id="pgl_addr" name="pgl_addr" readonly></textarea>
                                                <!-- <input type="text" id="pgl_addr" name="pgl_addr" class="col-xs-12 col-sm-5" readonly /> -->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="name">Lokasi:</label>
                                        <div class="col-xs-12 col-sm-9">
                                            <div class="clearfix">
                                                <input type="text" id="lokasi" name="lokasi" class="col-xs-12 col-sm-5" readonly />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="name">Berlaku Dari:</label>
                                        <div class="col-xs-12 col-sm-9">
                                            <div class="clearfix">
                                                <input type="text" id="valid_from" name="valid_from" class="col-xs-12 col-sm-2" readonly />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="name">Sampai:</label>
                                        <div class="col-xs-12 col-sm-9">
                                            <div class="clearfix">
                                                <input type="text" id="valid_to" name="valid_to" class="col-xs-12 col-sm-2" readonly />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="name">Deskripsi:</label>
                                        <div class="col-xs-12 col-sm-9">
                                            <div class="clearfix">
                                                <input type="text" id="description" name="description" class="col-xs-12 col-sm-5" readonly />
                                            </div>
                                        </div>
                                    </div>

                                </form>
                               
                            </div>

                            <div class="step-pane" data-step="2">
                                <div class="center">
                                    <h3 class="blue lighter">Log Aktifitas</h3>
                                </div>
                                <hr>
                                <div style="padding-bottom: 10px">
                                    <a id="add_log" class="btn btn-white btn-sm btn-round">
                                        <i class="ace-icon fa fa-plus green"></i>
                                        Add Log Aktifitas
                                    </a>
                                </div>
                                <table id="grid-log" class="table table-striped table-bordered table-hover">
                                    <thead>
                                      <tr>
                                            <th data-column-id="T_CUSTOMER_ORDER_ID" data-visible="false">ID</th>
                                            <th data-column-id="LOG_DATE" data-width="100" data-header-align="center" data-align="center">Tanggal</th>
                                            <th data-column-id="LOG_HOUR" data-width="100" data-header-align="center" data-align="center">Jam</th>
                                            <th data-column-id="ACTIVITY">Aktifitas</th>                                            
                                      </tr>
                                    </thead>
                                </table>

                            </div>

                            <div class="step-pane" data-step="3">
                                <div class="center">
                                    <h3 class="blue lighter">Dokumen Pendukung</h3>
                                </div>
                                <hr>

                                 <div style="padding-bottom: 10px">
                                    <a id="add_legal_doc" class="btn btn-white btn-sm btn-round">
                                        <i class="ace-icon fa fa-plus green"></i>
                                        Add Dokumen Pendukung
                                    </a>
                                </div>

                                <table id="grid-legal" class="table table-striped table-bordered table-hover">
                                    <thead>
                                      <tr>
                                            <th data-column-id="T_CUST_ORDER_LEGAL_DOC_ID" data-visible="false">ID</th>
                                            <th data-column-id="LEGAL_DOC_DESC" data-width="150">Jenis Dokumen</th>
                                            <th data-column-id="origin" data-formatter="origin" data-width="200">Nama File</th>
                                            <th data-column-id="DESCRIPTION">Keterangan</th>
                                            <th data-column-id="action" data-formatter="action" data-width="100" data-sortable="false"data-header-align="center" data-align="center">Aksi</th>
                                      </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>

                    </div>

                    <hr />
                    <div class="wizard-actions">
                        <button class="btn btn-prev">
                            <i class="ace-icon fa fa-arrow-left"></i>
                            Prev
                        </button>

                        <button class="btn btn-primary btn-next" data-last="Finish">
                            Next
                            <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
                        </button>

                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<?php 
    $this->load->view('wf/lov_submitter.php'); 
    $this->load->view('wf/lov_legaldoc.php'); 
    $this->load->view('wf/lov_log.php'); 
?>

<script src="<?php echo base_url(); ?>assets/js/fuelux/fuelux.wizard.js"></script>
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

        $('#fuelux-wizard-container').ace_wizard().on('finished.fu.wizard', function(e) {
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

            if (  $('#ACTION_STATUS').val() != 'VIEW' ) {
                modal_lov_submitter_show(params_submit, params_back_summary); 
            } else {
                loadContentWithParams( $('#TEMP_FSUMMARY').val() , params_back_summary );
            }
        }); 

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
            $('#add_legal_doc').hide();
            $('#add_log').hide();
        }

        /* mengisi form customer order join contract registration */
        $.ajax({
            type: 'POST',
            datatype: "json",
            url: '<?php echo site_url('workflow_parameter/grid_customer_order_contract_reg');?>',
            data: { t_customer_order_id : $("#CURR_DOC_ID").val(), 
                    p_w_proc_id : $('#TEMP_P_W_PROC_ID').val(),
                    page:1, 
                    rows:1 
            },
            timeout: 10000,
            success: function(data) {
                var response = JSON.parse( data );
                var items = response.Data[0];
                
                $("#order_no").val( items.ORDER_NO );
                $("#doc_name").val( items.DOC_NAME );
                $("#order_date").val( items.ORDER_DATE );
                $("#contract_no").val( items.CONTRACT_NO );
                $("#pgl_name").val( items.PGL_NAME );
                $("#pgl_addr").val( items.PGL_ADDR );
                $("#lokasi").val( items.LOKASI );
                $("#valid_from").val( items.VALID_FROM );
                $("#valid_to").val( items.VALID_TO );
                $("#description").val( items.DESCRIPTION );
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
        

        $("#add_log").on('click',function(){
            var params_log = {};
            params_log.code = "TAMBAH LOG AKTIFITAS";
            params_log.CURR_DOC_ID         = $('#CURR_DOC_ID').val();  
            params_log.CURR_DOC_TYPE_ID    = $('#CURR_DOC_TYPE_ID').val();
            params_log.CURR_PROC_ID        = $('#CURR_PROC_ID').val();
            params_log.CURR_CTL_ID         = $('#CURR_CTL_ID').val();
            params_log.USER_ID_DOC         = $('#USER_ID_DOC').val();
            params_log.USER_ID_DONOR       = $('#USER_ID_DONOR').val();
            params_log.USER_ID_LOGIN       = $('#USER_ID_LOGIN').val();
            params_log.USER_ID_TAKEN       = $('#USER_ID_TAKEN').val();
            params_log.IS_CREATE_DOC       = $('#IS_CREATE_DOC').val();
            params_log.IS_MANUAL           = $('#IS_MANUAL').val();
            params_log.CURR_PROC_STATUS    = $('#CURR_PROC_STATUS').val();
            params_log.CURR_DOC_STATUS     = $('#CURR_DOC_STATUS').val();
            params_log.PREV_DOC_ID         = $('#PREV_DOC_ID').val();
            params_log.PREV_DOC_TYPE_ID    = $('#PREV_DOC_TYPE_ID').val();
            params_log.PREV_PROC_ID        = $('#PREV_PROC_ID').val();
            params_log.PREV_CTL_ID         = $('#PREV_CTL_ID').val();
            params_log.SLOT_1              = $('#SLOT_1').val();    
            params_log.SLOT_2              = $('#SLOT_2').val(); 
            params_log.SLOT_3              = $('#SLOT_3').val();    
            params_log.SLOT_4              = $('#SLOT_4').val();  
            params_log.SLOT_5              = $('#SLOT_5').val();    
            params_log.MESSAGE             = $('#MESSAGE').val();    
            params_log.PROFILE_TYPE        = $('#PROFILE_TYPE').val();
            params_log.ACTION_STATUS       = $('#ACTION_STATUS').val();

            modal_lov_log_show(params_log);
        });

        $("#add_legal_doc").on('click',function(){
            var params_legaldoc = {};
            params_legaldoc.code = "TAMBAH LOG AKTIFITAS";
            params_legaldoc.CURR_DOC_ID         = $('#CURR_DOC_ID').val();  
            params_legaldoc.CURR_DOC_TYPE_ID    = $('#CURR_DOC_TYPE_ID').val();
            params_legaldoc.CURR_PROC_ID        = $('#CURR_PROC_ID').val();
            params_legaldoc.CURR_CTL_ID         = $('#CURR_CTL_ID').val();
            params_legaldoc.USER_ID_DOC         = $('#USER_ID_DOC').val();
            params_legaldoc.USER_ID_DONOR       = $('#USER_ID_DONOR').val();
            params_legaldoc.USER_ID_LOGIN       = $('#USER_ID_LOGIN').val();
            params_legaldoc.USER_ID_TAKEN       = $('#USER_ID_TAKEN').val();
            params_legaldoc.IS_CREATE_DOC       = $('#IS_CREATE_DOC').val();
            params_legaldoc.IS_MANUAL           = $('#IS_MANUAL').val();
            params_legaldoc.CURR_PROC_STATUS    = $('#CURR_PROC_STATUS').val();
            params_legaldoc.CURR_DOC_STATUS     = $('#CURR_DOC_STATUS').val();
            params_legaldoc.PREV_DOC_ID         = $('#PREV_DOC_ID').val();
            params_legaldoc.PREV_DOC_TYPE_ID    = $('#PREV_DOC_TYPE_ID').val();
            params_legaldoc.PREV_PROC_ID        = $('#PREV_PROC_ID').val();
            params_legaldoc.PREV_CTL_ID         = $('#PREV_CTL_ID').val();
            params_legaldoc.SLOT_1              = $('#SLOT_1').val();    
            params_legaldoc.SLOT_2              = $('#SLOT_2').val(); 
            params_legaldoc.SLOT_3              = $('#SLOT_3').val();    
            params_legaldoc.SLOT_4              = $('#SLOT_4').val();  
            params_legaldoc.SLOT_5              = $('#SLOT_5').val();    
            params_legaldoc.MESSAGE             = $('#MESSAGE').val();    
            params_legaldoc.PROFILE_TYPE        = $('#PROFILE_TYPE').val();
            params_legaldoc.ACTION_STATUS       = $('#ACTION_STATUS').val();

            modal_lov_legaldoc_show(params_legaldoc);
        });
    });

     $("#grid-log").bootgrid({
        ajax: true,
        post: function ()
        {
            return {
                "t_customer_order_id": $("#CURR_DOC_ID").val()
            };
        },
        url: "<?php echo site_url('wf/getLogKronologi');?>",
        navigation:0
    }); 

    $("#grid-legal").bootgrid({
        ajax: true,
        post: function ()
        {
            return {
                "t_customer_order_id": $("#CURR_DOC_ID").val()
            };
        },
        url: "<?php echo site_url('wf/getLegalDoc');?>",
        navigation:0,
        formatters: {
            "origin": function(column, row)
            {
               return "<a href=\"<?php echo base_url(); ?>"+row.FILE_FOLDER+"/"+row.FILE_NAME+"\">"+row.ORIGIN_FILE_NAME+"</a> ";
            },
            "action": function(column, row)
            {
                if (  $('#ACTION_STATUS').val() == 'VIEW' ) {
                    return '<button type="button" class="btn btn-xs btn-default command-delete"><span class="ace-icon glyphicon glyphicon-trash"></span></button>';
                }else{
                    return '<button type="button" class="btn btn-xs btn-danger command-delete" onclick="deleteLegal('+ row.T_CUST_ORDER_LEGAL_DOC_ID +')"><span class="ace-icon glyphicon glyphicon-trash"></span></button>'
                }
            }

        }
    }); 

    function deleteLegal(idd){
        /*delete table legal doc*/
        $.ajax({
            type: 'POST',
            datatype: "json",
            url: '<?php echo site_url('wf/delete_legaldoc');?>',
            timeout: 10000,
            data: { t_cust_order_legal_doc_id : idd},
            success: function(data) {
                 $('#grid-legal').bootgrid('reload');
            }
        });
    }
</script>