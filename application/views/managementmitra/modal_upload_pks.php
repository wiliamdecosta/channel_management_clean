<div id="modal_upload_pks" class="modal fade" role="dialog" style="z-index:1">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Upload Doc PKS</h4>
            </div>
            <form role="form" id="uploadform_fastel" name="uploadfastel" method="post" enctype="multipart/form-data"
                  accept-charset="utf-8">
                <div class="modal-body">
                    <div class="row">
                        <div class="widget-main">
                            <div class="form-group">
                                <div id="label" class="col-xs-3">
                                    <label>No PKS</label>
                                </div>
                                <div class="col-xs-9">
                                    <input type="text" id="no_pks" name="no_pks" class="form-control" required>
                                </div>
                            </div>
                            &nbsp;
                            <div class="form-group">
                                <div id="label" class="col-xs-3">
                                    <label>Nama Dokumen</label>
                                </div>
                                <div class="col-xs-9">
                                    <input type="text" id="doc_name" name="doc_name" class="form-control" required>
                                </div>
                            </div>
                            &nbsp;
                            <div class="form-group">
                                <div id="label" class="col-xs-3">
                                    <label>Tgl Mulai PKS</label>
                                </div>
                                <div class="col-xs-9">
                                    <input type="text" id="start_date_pks" name="start_date_pks"
                                           class="col-xs-10 col-sm-5 date-picker" data-date-format="dd-mm-yyyy"
                                           required>
                                </div>
                            </div>
                            &nbsp;
                            <div class="form-group">
                                <div id="label" class="col-xs-3">
                                    <label>Tgl Berakhir PKS</label>
                                </div>
                                <div class="col-xs-9">
                                    <input type="text" id="end_date_pks" name="end_date_pks"
                                           class="col-xs-10 col-sm-5 date-picker" data-date-format="dd-mm-yyyy"
                                           required>
                                </div>
                            </div>
                            &nbsp;
                            <div class="form-group">
                                <div class="col-xs-3">
                                    <label>File</label>
                                </div>
                                <div class="col-xs-9">
                                    <!-- #section:custom/file-input -->
                                    <input type="file" id="filename" name="filename" required/>
                                </div>
                            </div>
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                                   value="<?php echo
                                   $this->security->get_csrf_hash(); ?>">
                            <br>
                            <div id="output" class="row">
                            </div>
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
</div>
<script type="text/javascript">
    $('.date-picker').datepicker({
            autoclose: true,
            todayHighlight: true
        })
        //show datepicker when clicking on the icon
        .next().on(ace.click_event, function () {
        $(this).prev().focus();
    });
</script>
<script type="text/javascript">
    $('#filename').ace_file_input({
        no_file: 'No File ...',
        btn_choose: 'Choose',
        btn_change: 'Change',
        droppable: false,
        onchange: null,
        thumbnail: false
    });

    $("#uploadform_fastel").on('submit', (function (e) {
        e.preventDefault();
        var data = new FormData(this);
       // data.append('ten_id', ten_id);
        $.ajax({
            url: "<?php echo site_url('managementmitra/pks_uploaddo');?>", // Url to which the request is send
            type: "POST",             // Type of request to be send, called as method
            data: data, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData: false,        // To send DOMDocument or non processed data file it is set to false
            dataType: "json",
            success: function (data)   // A function to be called if request succeeds
            {
                if (data.success == true) {
                    var grid = jQuery("#grid-table");
                    alert(data.msg);
                    grid.trigger("reloadGrid", [{page: 1}]);
                    $("#modal_upload_pks").modal("hide");

                } else {
                    $("#output").html(data.msg);
                }
            }
        });

    }));

</script>