<div id="modal_lov_submitter" class="modal fade" tabindex="-1" style="overflow-y: scroll; z-index:1;">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- modal title -->
            <div class="modal-header no-padding">
                <div class="table-header">
                    <span class="form-add-edit-title"> KONFIRMASI PENUTUPAN PEKERJAAN </span>
                </div>
            </div>
            
            <!-- modal body -->
            <div class="modal-body">
                <form class="form-horizontal" application="form" id="form_submitter">
                    <input type="hidden" id="form_submitter_params">
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right"> Waktu Sekarang </label>
                        <div class="col-sm-3">
                            <input id="form_submitter_date" readonly name="submitter_date" class="col-xs-12" type="text">
                        </div>

                        <label class="col-sm-2 control-label no-padding-right"> Submit Oleh </label>
                        <div class="col-sm-4">
                            <input id="form_submitter_by" readonly name="submitter_by" value="<?php echo $this->session->userdata("d_user_name"); ?>" class="col-xs-12" type="text">
                        </div>

                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right"> Pekerjaan Tersedia </label>
                        <div class="col-sm-9">
                            <input id="form_submitter_available_job" readonly name="submitter_available_job" value="" type="text">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right"> Status Dok.Workflow </label>
                        <div class="col-sm-9">
                            <select id="form_submitter_status_dok_wf" disabled></select>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right"> Pesan Akan Dikirim </label>
                        <div class="col-sm-9">
                            <textarea id="form_submitter_interactive_message" rows="1" cols="52" placeholder="Ketikkan Pesan Anda"></textarea>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right green"> Pesan Berhasil Dikirim </label>
                        <div class="col-sm-9">
                            <textarea id="form_submitter_success_message" readonly="readonly" rows="1" cols="52"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right red"> Pesan Error </label>
                        <div class="col-sm-9">
                            <textarea id="form_submitter_error_message" readonly="readonly" rows="1" cols="52"></textarea>
                        </div>
                    </div>



                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right orange"> Pesan Peringatan </label>
                        <div class="col-sm-9">
                            <textarea id="form_submitter_warning_message" readonly="readonly" rows="1" cols="52"></textarea>
                        </div>
                    </div>

                </form>
            </div>

            <!-- modal footer -->
            <div class="modal-footer no-margin-top">
                <div class="bootstrap-dialog-footer">
                    <div class="bootstrap-dialog-footer-buttons col-xs-6">
                        <button class="btn btn-primary btn-xs radius-4" id="btn-submitter-submit" data-dismiss="modal">
                            <i class="ace-icon glyphicon glyphicon-upload"></i>
                            Submit
                        </button>
                        <button class="btn btn-warning btn-xs radius-4" id="btn-submitter-reject" data-dismiss="modal">
                            <i class="ace-icon fa fa-ban"></i>
                            Reject
                        </button>
                        <button class="btn btn-warning btn-xs radius-15" id="btn-submitter-back" data-dismiss="modal">
                            <i class="glyphicon glyphicon-circle-arrow-left"></i>
                            Back
                        </button>
                    </div>
                    <div class="bootstrap-dialog-footer-buttons col-xs-6">
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
    

    $(function() {
        /* submit */
        $('#btn-submitter-submit').on('click', function() {
            result = confirm('Anda yakin akan menutup pekerjaan ini ?');
            if (result) { 
                var submitter_params = $('#form_submitter_params').val();
                var messages = $('#form_submitter_interactive_message').val();

                $.ajax({
                    type: 'POST',
                    datatype: "json",
                    url: '<?php echo site_url('wf/submitter_submit');?>',
                    data: { params : submitter_params , interactive_message : messages},
                    timeout: 10000,
                    success: function(data) {
                        var response = JSON.parse(data);
                        if(response.success) {

                            $('#form_submitter_success_message').val( response.return_message );
                            $('#form_submitter_error_message').val( response.error_message );
                            $('#form_submitter_warning_message').val( response.warning );

                        }else {
                            swal("", data.message, "warning");
                        }

                        $('#btn-submitter-submit').remove();
                        $('#btn-submitter-reject').remove();
                        $('#btn-submitter-back').remove();
                    }
                });
            }
            return false;
        });

        /* reject */
        $('#btn-submitter-reject').on('click', function() {

            if( $('#form_submitter_interactive_message').val() == "" ) {
                swal("", "Ketikkan pesan Anda sebagai alasan penolakan pekerjaan", "info");  
                return false;
            }

            result = confirm('Anda yakin akan menolak pekerjaan ini ?');
            if (result) { 
                var submitter_params = $('#form_submitter_params').val();
                var messages = $('#form_submitter_interactive_message').val();

                $.ajax({
                    type: 'POST',
                    datatype: "json",
                    url: '<?php echo site_url('wf/submitter_reject');?>',
                    data: { params : submitter_params , interactive_message : messages},
                    timeout: 10000,
                    success: function(data) {
                        var response = JSON.parse(data);
                        if(response.success) {

                            $('#form_submitter_success_message').val( response.return_message );
                            $('#form_submitter_error_message').val( response.error_message );
                            $('#form_submitter_warning_message').val( response.warning );

                        }else {
                            swal("", data.message, "warning");
                        }

                        $('#btn-submitter-submit').remove();
                        $('#btn-submitter-reject').remove();
                        $('#btn-submitter-back').remove();
                    }
                });    
            }
            return false;
        });

        /* back */
        $('#btn-submitter-back').on('click', function() {
            if( $('#form_submitter_interactive_message').val() == "" ) {
                swal("", "Ketikkan pesan Anda sebagai alasan mengembalikan pekerjaan", "info");  
                return false;
            }

            result = confirm('Anda yakin akan mengembalikan pekerjaan ini ?');
            if (result) { 
                var submitter_params = $('#form_submitter_params').val();
                var messages = $('#form_submitter_interactive_message').val();

                $.ajax({
                    type: 'POST',
                    datatype: "json",
                    url: '<?php echo site_url('wf/submitter_back');?>',
                    data: { params : submitter_params , interactive_message : messages},
                    timeout: 10000,
                    success: function(data) {
                        var response = JSON.parse(data);
                        if(response.success) {

                            $('#form_submitter_success_message').val( response.return_message );
                            $('#form_submitter_error_message').val( response.error_message );
                            $('#form_submitter_warning_message').val( response.warning );

                        }else {
                            swal("", data.message, "warning");
                        }

                        $('#btn-submitter-submit').remove();
                        $('#btn-submitter-reject').remove();
                        $('#btn-submitter-back').remove();
                    }
                });
            }
            return false;
        });
    });

    function modal_lov_submitter_show(params_submit) {
        modal_lov_submitter_init(params_submit);
        $("#modal_lov_submitter").modal({backdrop: 'static'});
    }

    function modal_lov_submitter_init(params_submit) {

        $('#form_submitter_params').val( JSON.stringify(params_submit) );
        /*init date*/
        $("#form_submitter_date").datepicker({
                                format: 'yyyy-mm-dd',
                                enabled:false,
                                beforeShowDay: function (date) {
                                    return [false];
                                }
                            });
        $("#form_submitter_date").datepicker('setDate', new Date());

        /*init pekerjaan tersedia*/
        $.ajax({
            type: 'POST',
            datatype: "json",
            url: '<?php echo site_url('wf/pekerjaan_tersedia');?>',
            data: { curr_proc_id : params_submit.CURR_PROC_ID, curr_doc_type_id: params_submit.CURR_DOC_TYPE_ID },
            timeout: 10000,
            success: function(data) {
                var response = JSON.parse(data);
                $("#form_submitter_available_job").val( response.task );
            }
        });


        /*init status dokumen wf*/
        $.ajax({
            type: 'POST',
            datatype: "json",
            url: '<?php echo site_url('wf/status_dokumen_workflow');?>',
            timeout: 10000,
            success: function(data) {
                var response = JSON.parse(data);
                $("#form_submitter_status_dok_wf").html( response.opt_status );
            }
        });

    }


    
</script>