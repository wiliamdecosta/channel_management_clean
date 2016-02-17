<div style="margin-bottom: 10px;">
    <button class="btn btn-white btn-sm btn-round" id="back">
        <i class="ace-icon fa fa-arrow-circle-left green"></i>
        Kembali
    </button>
</div>
<form class="form-horizontal" role="form" id="mitraForm">
    <h4 class="header blue bolder smaller">Mitra</h4>
    <div class="row">
        <div class="col-xs-6">
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right">Nama Segment</label>
                <div class="col-sm-8">
                    <input type="text" id="mitraForm_segment" name="segment_code" class="col-sm-10 required"
                           placeholder="Pilih Segment"
                           value="" required>
                    <span class="input-group-btn">
                        <button class="btn btn-warning btn-sm" type="button" id="btn_lov_segment">
                            <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                        </button>
                    </span>
                </div>

            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">Nama CC </label>
                <div class="col-sm-8">
                    <input type="text" id="cc_name" name="cc_name" class="col-sm-10 required" placeholder="Pilih CC"
                           required>
                    <input type="hidden" id="cc_id" name="cc_id" class="form-control required" required>
                    <span class="input-group-btn">
                        <button class="btn btn-warning btn-sm" type="button" id="btn_lov_cc">
                            <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                        </button>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-xs-6">
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">Nama Mitra</label>
                <div class="col-sm-8">
                    <input type="text" id="mitra_name" name="mitra_name" class="col-sm-10 required"
                           placeholder="Pilih Mitra" required>
                    <input type="hidden" id="mitra_id" name="mitra_id" class="form-control required" required>
                    <span class="input-group-btn">
                        <button class="btn btn-warning btn-sm" type="button" id="btn_lov_mitra">
                            <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                        </button>
                    </span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">Lokasi PKS </label>
                <div class="col-sm-9">
                    <input type="text" id="lokasi_pks" name="lokasi_pks" class="col-sm-10 required"
                           placeholder="Input Lokasi PKS"
                           required>
                </div>

            </div>
        </div>
    </div>
    <h4 class="header blue bolder smaller">PIC</h4>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right">Nama PIC </label>
                <div class="col-sm-8">
                    <input type="text" id="pic_name" name="pic_name" placeholder="Pilih PIC" class="col-sm-10 required">
                    <input type="hidden" id="pic_id" name="pic_id" class="form-control required">
                    <span class="input-group-btn">
                        <button class="btn btn-warning btn-sm" type="button" id="btn_lov_pic">
                            <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                        </button>
                    </span>
                </div>

            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right"> Contract Type </label>
                <div class="col-sm-8">
                    <?php echo buatcombo('contact', 'contact', 'P_REFERENCE_LIST', 'REFERENCE_NAME', 'P_REFERENCE_LIST_ID', array('P_REFERENCE_TYPE_ID' => 1), ''); ?>
                </div>
            </div>
        </div>
    </div>
    <h4 class="header blue bolder smaller">AM</h4>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right">Nama EAM</label>
                <div class="col-sm-8">
                    <input type="text" id="eam_name" name="eam_name" placeholder="Pilih EAM" class="col-sm-10 required">
                    <input type="hidden" id="eam_id" name="eam_id" required>
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                           value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <input type="hidden" name="action" id="action" value="<?php echo $action; ?>">
                    <span class="input-group-btn">
                        <button class="btn btn-warning btn-sm" type="button" id="btn_lov_eam">
                            <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                        </button>
                    </span>
                </div>

            </div>
        </div>
    </div>
    <div class="clearfix form-actions">
        <div class="col-md-offset-3 col-md-9">
            <button class="btn btn-info" type="submit">
                <i class="ace-icon fa fa-check bigger-110"></i>
                Save
            </button>

            &nbsp; &nbsp;
            <button class="btn" type="reset" id="reset">
                <i class="ace-icon fa fa-undo bigger-110"></i>
                Reset
            </button>
        </div>
    </div>
</form>
<div id="lov_pic" class="lov_content"></div>
<div id="lov_segment" class="lov_content"></div>
<div id="lov_cc" class="lov_content"></div>
<div id="lov_mitra" class="lov_content"></div>
<div id="lov_eam" class="lov_content"></div>

<script type="text/javascript">
    $("#btn_lov_segment").click(function () {
        var divID = "mitraForm_segment"; // Parameter id input
        var lov_target_id = "lov_segment"; // Harus sama dengan id class lov
        var modal_id = "modal_lov_segment"; // Terserah
        $(".lov_content").html("");

        $.ajax({
            async: false,
            url: "<?php echo base_url();?>managementmitra/lovSegment",
            type: "POST",
            data: {divID: divID, lov_target_id: lov_target_id, modal_id: modal_id},
            success: function (data) {
                $('#' + lov_target_id).html(data);
                $('#' + modal_id).modal('show');

                $("#cc_id").val("");
                $("#cc_name").val("");
            }
        });
    });

    $("#btn_lov_cc").click(function () {
        var divID = "cc_id#~#cc_name"; // Parameter id input
        var lov_target_id = "lov_cc"; // Harus sama dengan id class lov
        var modal_id = "modal_lov_cc"; // Terserah
        $(".lov_content").html("");
        var cc = $("#mitraForm_segment").val();
        if (cc) {
            $.ajax({
                url: "<?php echo base_url();?>managementmitra/lovCC",
                type: "POST",
                data: {divID: divID, lov_target_id: lov_target_id, modal_id: modal_id, cc_name: cc},
                success: function (data) {
                    $('#' + lov_target_id).html(data);
                    $('#' + modal_id).modal('show');
                }
            });
        } else {
            swal("Note", "Segment belum diisi !", "warning");
        }
    });

    $("#btn_lov_mitra").click(function () {
        var divID = "mitra_id#~#mitra_name"; // Parameter id input
        var lov_target_id = "lov_mitra"; // Harus sama dengan id class lov
        var modal_id = "modal_lov_mitra"; // Terserah
        $(".lov_content").html("");
        $.ajax({
            url: "<?php echo base_url();?>managementmitra/lovMitra",
            type: "POST",
            data: {divID: divID, lov_target_id: lov_target_id, modal_id: modal_id},
            success: function (data) {
                $('#' + lov_target_id).html(data);
                $('#' + modal_id).modal('show');
            }
        });
    });

    $("#btn_lov_pic").click(function () {
        var divID = "pic_id#~#pic_name"; // Parameter id input
        var lov_target_id = "lov_pic"; // Harus sama dengan id class lov
        var modal_id = "modal_lov_pic"; // Terserah
        $(".lov_content").html("");
        $.ajax({
            url: "<?php echo base_url();?>managementmitra/lovPIC",
            type: "POST",
            data: {divID: divID, lov_target_id: lov_target_id, modal_id: modal_id},
            success: function (data) {
                $('#' + lov_target_id).html(data);
                $('#' + modal_id).modal('show');
            }
        });
    });

    $("#btn_lov_eam").click(function () {
        var divID = "eam_id#~#eam_name"; // Parameter id input
        var lov_target_id = "lov_eam"; // Harus sama dengan id class lov
        var modal_id = "modal_lov_eam"; // Terserah
        $(".lov_content").html("");
        $.ajax({
            url: "<?php echo base_url();?>managementmitra/lovEAM",
            type: "POST",
            data: {divID: divID, lov_target_id: lov_target_id, modal_id: modal_id},
            success: function (data) {
                $('#' + lov_target_id).html(data);
                $('#' + modal_id).modal('show');
            }
        });
    });

    $("#mitraForm").on('submit', (function (e) {
        e.preventDefault();
        var data = $(this).serializeArray();
        $.ajax({
            url: "<?php echo site_url('managementmitra/crud_detailmitra');?>",
            type: "POST",
            data: data,
            // contentType: false,
            // cache: false,
            // processData: false,
            dataType: "json",
            success: function (data) {
                if (data.success == true) {
                    //var grid = jQuery("#grid-table");
                    swal(data.message);
                    // grid.trigger("reloadGrid", [{page: 1}]);
                    // $("#modal_upload_fastel").modal("hide");

                } else {
                    swal(data.message);
                    //$("#output").html(data.msg);
                    // $("#modal_upload_fastel").modal("hide");
                }
            },
            error: function (xhr, status, error) {
                // var message = JSON.parse(xhr.responseText)
                // swal("Error",xhr.responseText,"error");
                swal({title: "Error!", text: xhr.responseText, html: true, type: "error"});
            }
        });

    }));

</script>

