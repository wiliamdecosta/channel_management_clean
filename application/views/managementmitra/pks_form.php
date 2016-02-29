<div id="mapping_pic_form" style="margin-top: 20px;" class="row">
    <div class="col-xs-12">
        <div class="well well-sm"><h4 id="pic_form_title" class="blue">Add/Edit PIC</h4></div>
        <form class="form-horizontal" role="form" id="form_mapping_pic">
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right"> Nama PIC </label>
                <div class="col-sm-8">
                    <input type="text" id="pic_name" name="pic_name" placeholder="Pilih PIC"
                           class="col-xs-10 col-sm-5 required" required>
                    <input type="hidden" id="pic_id" name="pic_id" class="form-control required" required>

                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                           value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <input type="hidden" name="oper" id="oper" value="<?php echo $action; ?>">
                    <input type="hidden" id="p_mp_lokasi_id" name="p_mp_lokasi_id" value="<?php echo $P_MP_LOKASI_ID;?>" required>
                    <input type="hidden" id="p_mp_pic_id" name="p_mp_pic_id">
                    <span class="input-group-btn">
                        <button class="btn btn-warning btn-sm" type="button" id="btn_lov_pic">
                            <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                        </button>
                    </span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right"> Contract Type </label>
                <div class="col-sm-4">
                    <?php echo buatcombo('contact', 'contact', 'P_REFERENCE_LIST', 'REFERENCE_NAME', 'P_REFERENCE_LIST_ID', array('P_REFERENCE_TYPE_ID' => 1), ''); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right"> Created By </label>
                <div class="col-sm-9">
                    <input type="text" value="<?php echo $this->session->userdata('d_user_name'); ?>" disabled=""
                           id="form_created_by">
                    &nbsp; <input type="text" value="<?php echo date("d-m-Y"); ?>" disabled="" id="form_creation_date">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right"> Updated By </label>
                <div class="col-sm-9">
                    <input type="text" value="<?php echo $this->session->userdata('d_user_name'); ?>" disabled=""
                           id="form_updated_by">
                    &nbsp; <input type="text" value="<?php echo date("d-m-Y"); ?>" disabled="" id="form_updated_date">
                </div>
            </div>
            <div class="space-4"></div>
            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button class="btn btn-info" type="submit">
                        <i class="ace-icon fa fa-check bigger-110"></i>
                        Save
                    </button>
                    &nbsp; &nbsp;
                    <button class="btn" type="reset" id="back">
                        <i class="ace-icon fa fa-arrow-circle-left bigger-110"></i>
                        Back
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="lov_pic" class="lov_content"></div>

<script type="text/javascript">

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

    $("#form_mapping_pic").on('submit', (function (e) {
        e.preventDefault();
        var data = $(this).serializeArray();
        $.ajax({
            url: "<?php echo site_url('parameter/crud_pic_mapping');?>",
            type: "POST",
            data: data,
            dataType: "json",
            success: function (data) {
                if (data.success == true) {
                    swal("Sukses", data.message, "success");
                    $("#form_pic").hide("slow");
                    $("#tbl_pic").show("slow");
                    $("#grid_table_pic").trigger("reloadGrid", [{page: 1}]);

                } else {
                    swal("Error", data.message, "error");

                }
            },
            error: function (xhr, status, error) {
                swal({title: "Error!", text: xhr.responseText, html: true, type: "error"});
            }
        });

    }));

    $("#back").click(function () {
        $("#form_pic").hide("slow");
        $("#tbl_pic").show("slow");

    })
</script>

