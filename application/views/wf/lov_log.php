<div id="modal_lov_log" class="modal fade" tabindex="-1" style="overflow-y: scroll;">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"> LOG AKTIFITAS </h4>
            </div>
            <form role="form" name="uploadfastel" method="post" enctype="multipart/form-data"
                  accept-charset="utf-8">
                <div class="modal-body">
                    <div class="row">
                        <div class="widget-main">
                            <input type="hidden" id="log_params">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                            &nbsp;
                            <div class="form-group">
                                <div class="col-xs-3">
                                    <label>Aktifitas</label>
                                </div>
                                <div class="col-xs-9">
                                    <input type="text" id="activity" name="activity"/>
                                </div>
                            </div>
                            
                            &nbsp;
                            <div class="form-group">
                                <div class="col-xs-3">
                                    <label>Description</label>
                                </div>
                                <div class="col-xs-9">
                                    <textarea rows="3" cols="50" id="description" name="description"></textarea> 
                                </div>
                            </div>
                            &nbsp;

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-primary" id="btn_submit">Submit</button>
                </div>
            </form>

        </div>
    </div>
</div><!-- /.end modal -->

<script>
    

    $(function() {
        /* submit */
        $('#btn_submit').on('click', function() {
            var log_params = $('#log_params').val();           
            var description = $('#description').val();           
            var activity = $('#activity').val();           

            $.ajax({
                type: 'POST',
                datatype: "json",
                url: '<?php echo site_url('wf/save_log');?>',
                data: { params : log_params, description: description, activity: activity },
                timeout: 10000,
                success: function(data) {
                    // console.log(data);
                    var response = JSON.parse(data);
                    if(response.success) {
                        $('#grid-log').bootgrid('reload');
                        $('#modal_lov_log').modal('hide');
                    }else{
                        swal("", data.message, "warning");
                    }
                   
                }
            });
            return false;
        });
    });

    function modal_lov_log_show(params_log) {
        modal_lov_log_init(params_log);
        $("#modal_lov_log").modal({backdrop: 'static'});
    }

    function modal_lov_log_init(params_log) {

        $('#log_params').val( JSON.stringify(params_log) );
        $('#description').val('');
        $('#activity').val('');

    }


    
</script>