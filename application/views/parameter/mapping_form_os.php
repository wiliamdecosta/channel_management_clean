<div style="margin-bottom: 10px;">
<div style="margin-bottom: 10px;">
    <button class="btn btn-white btn-sm btn-round" id="back">
        <i class="ace-icon fa fa-arrow-circle-left green"></i>
        Kembali
    </button>
</div>
<form class="form-horizontal" role="form" id="mitraForm">
    <h4 class="header blue bolder smaller">Mapping Acc - PGL</h4>
    <div class="row">
        <div class="col-xs-6">
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right">Data Source</label>
                <div class="col-sm-8">
                    <input type="text" id="dts_code" name="dts_code" class="col-sm-10 required"
                           placeholder="Pilih Data Source"
                           value="" readonly required>
					 <input type="hidden" id="dts_id" name="dts_id" class="form-control required" required>
                    <span class="input-group-btn">
                        <button class="btn btn-warning btn-sm" type="button" id="btn_lov_dts">
                            <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                        </button>
                    </span>
                </div>

            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">Nama ACC-MDIID</label>
                <div class="col-sm-8">
                    <input type="text" id="acc_name" name="acc_name" class="col-sm-10 required" placeholder="Pilih CC"
                          readonly required>
                    <input type="hidden" id="acc_id" name="acc_id" class="form-control required" required>
                    <span class="input-group-btn">
                        <button class="btn btn-warning btn-sm" type="button" id="btn_lov_acc">
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
					 <input type="hidden" id="p_mp_pgl_acc_id" name="p_mp_pgl_acc_id" required>
                    <input type="text" id="mitra_name" name="mitra_name" class="col-sm-10 required"
                           placeholder="Pilih Mitra" readonly required>
                    <input type="hidden" id="mitra_id" name="mitra_id" class="form-control required" required>
                     <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                           value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <input type="hidden" name="action" id="action" value="<?php echo $action; ?>">
					<span class="input-group-btn">
                        <button class="btn btn-warning btn-sm" type="button" id="btn_lov_mitra">
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
<div id="lov_datasrc" class="lov_content"></div>
<div id="lov_acc" class="lov_content"></div>
<div id="lov_mitra" class="lov_content"></div>
<div id="lov_eam" class="lov_content"></div>

<script type="text/javascript">
    $("#btn_lov_dts").click(function () {
        var divID = "dts_id#~#dts_code"; // Parameter id input
        var lov_target_id = "lov_datasrc"; // Harus sama dengan id class lov
        var modal_id = "modal_lov_dts"; // Terserah
        $(".lov_content").html("");

        $.ajax({
            async: false,
            url: "<?php echo base_url();?>parameter/lov_datasrc",
            type: "POST",
            data: {divID: divID, lov_target_id: lov_target_id, modal_id: modal_id},
            success: function (data) {
				// alert($("#dts_id").val());
                $('#' + lov_target_id).html(data);
                $('#' + modal_id).modal('show');
            }
        });
    });

    $("#btn_lov_acc").click(function () {
        var divID = "acc_id#~#acc_name"; // Parameter id input
        var lov_target_id = "lov_acc"; // Harus sama dengan id class lov
        var modal_id = "modal_lov_acc"; // Terserah
        $(".lov_content").html("");
        var dtsrc = $("#dts_code").val();
        if (dtsrc) {
            $.ajax({
                url: "<?php echo base_url();?>parameter/lov_accmdi",
                type: "POST",
                data: {divID: divID, lov_target_id: lov_target_id, modal_id: modal_id, dts_code: dtsrc},
                success: function (data) {
                    $('#' + lov_target_id).html(data);
                    $('#' + modal_id).modal('show');
                }
            });
        } else {
            swal("Note", "Data Source belum diisi !", "warning");
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

  
    $("#mitraForm").on('submit', (function (e) {
        e.preventDefault();
        var data = $(this).serializeArray();
        $.ajax({
            url: "<?php echo site_url('parameter/crud_mapping_par_mdacc');?>",
            type: "POST",
            data: data,
            dataType: "json",
            success: function (data) {
                if (data.success == true) {
                    swal("Sukses",data.message,"success");
                    $("#form_mitra").hide("slow");
                    $("#tbl_pic").show("slow");
                    $("#grid-table1").trigger("reloadGrid", [{page: 1}]);

                } else {
                    swal("Error",data.message,"error");

                }
            },
            error: function (xhr, status, error) {
                swal({title: "Error!", text: xhr.responseText, html: true, type: "error"});
            }
        });

    }));
    $("#back").click(function(){
        $("#form_mitra").hide("slow");
        $("#tbl_pic").show("slow");

    })


</script>

