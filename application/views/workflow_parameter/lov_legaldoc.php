<div id="modal_lov_legaldoc" class="modal fade" tabindex="-1" style="overflow-y: scroll;">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">DOKUMEN PENDUKUNG</h4>
            </div>
            <form role="form" id="form_legal" name="uploadfastel" method="post" enctype="multipart/form-data"
                  accept-charset="utf-8">
                <div class="modal-body">
                    <div class="row">
                        <div class="widget-main">
                            <input type="hidden" id="legaldoc_params" name="legaldoc_params">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                            &nbsp;
                            <div class="form-group">
                                <div class="col-xs-3">
                                    <label>Jenis Dokumen</label>
                                </div>
                                <div class="col-xs-9">
                                    <select name="p_legal_doc_type_id" id="p_legal_doc_type_id"></select>
                                </div>
                            </div>

                            &nbsp;
                            <div class="form-group">
                                <div class="col-xs-3">
                                    <label>File Upload</label>
                                </div>
                                <div class="col-xs-9">
                                    <!-- #section:custom/file-input -->
                                    <input type="file" id="filename" name="filename"/>
                                </div>
                            </div>

                            &nbsp;
                            <div class="form-group">
                                <div class="col-xs-3">
                                    <label>Description</label>
                                </div>
                                <div class="col-xs-9">
                                    <textarea rows="3" cols="50" id="desc" name="desc"></textarea> 
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                </div>
            </form>

        </div>
    </div>
</div><!-- /.end modal -->

<script>
    $('#filename').ace_file_input({
        no_file: 'No File ...',
        btn_choose: 'Choose',
        btn_change: 'Change',
        droppable: false,
        onchange: null,
        thumbnail: false
    });

    

    $(function() {
        /* submit */
        $("#form_legal").on('submit', (function (e) {
            e.preventDefault();   
            var data = new FormData(this);
            $.ajax({
                type: 'POST',
                dataType: "json",
                url: '<?php echo site_url('wf/save_legaldoc');?>',
                data: data,
                timeout: 10000,
                contentType: false,       // The content type used when sending data to the server.
                cache: false,             // To unable request pages to be cached
                processData: false, 
                success: function(data) {
                    if(data.success) {
                        $('#grid-table').trigger("reloadGrid");
                        $('#p_legal_doc_type_id').val(1);
                        $('#filename').ace_file_input('reset_input');
                        $('#desc').val('');
                        $('#modal_lov_legaldoc').modal('hide');
                    }else{
                        swal("", data.message, "warning");
                    }
                   
                }
            });
            return false;
        }));
        
    });

    function modal_lov_legaldoc_show(params_legaldoc) {
        modal_lov_legaldoc_init(params_legaldoc);
        $("#modal_lov_legaldoc").modal({backdrop: 'static'});
    }

    function modal_lov_legaldoc_init(params_legaldoc) {

        $('#legaldoc_params').val( JSON.stringify(params_legaldoc) );
        $('#p_legal_doc_type_id').val(1);
        $('#filename').ace_file_input('reset_input');
        $('#desc').val('');

        /*init status dokumen wf*/
        $.ajax({
            type: 'POST',
            datatype: "json",
            url: '<?php echo site_url('wf/doc_type');?>',
            timeout: 10000,
            success: function(data) {
                var response = JSON.parse(data);
                $("#p_legal_doc_type_id").html( response.opt_status );
            }
        });

    }


    
</script>