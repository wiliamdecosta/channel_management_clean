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
                    <input type="text" id="mitraForm_segment" class="col-sm-10 required" placeholder="Pilih Segment"
                           value="">
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
                    <input type="text" id="cc_name" class="col-sm-10 required" placeholder="Pilih CC" value="">
                    <input type="hidden" id="cc_id" class="form-control required" value="">
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
                    <input type="text" id="mitra_name" class="col-sm-10 required" placeholder="Pilih Mitra" value="">
                    <input type="hidden" id="pgl_id" class="form-control required" value="">
                    <span class="input-group-btn">
                        <button class="btn btn-warning btn-sm" type="button" id="btn_lov_mitra">
                            <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                        </button>
                    </span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">Lokasi PKS </label>
                <div class="col-sm-8">
                    <input type="text" id="lokasi_pks" class="col-sm-10 required" placeholder="Pilih Lokasi" value="">
                    <input type="hidden" id="lokasi_pks_id" class="form-control required" value="">
                    <span class="input-group-btn">
                        <button class="btn btn-warning btn-sm" type="button" id="btn_lov_mitra">
                            <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                        </button>
                    </span>
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
                    <input type="text" id="picname" placeholder="Text Field" class="col-sm-10 required">
                    <input type="hidden" id="pic_id" placeholder="Text Field" class="form-control required" value="">
                    <span class="input-group-btn">
                        <button class="btn btn-warning btn-sm" type="button" id="btn_lov_pic" onclick="getLovPIC()">
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
                    <input type="text" id="form-field-1-1" placeholder="Pilih PIC" class="col-sm-10 required" value=""/>
                    <input type="hidden" id="form-field-1-1" id="pic_id" name="pic_id" value=""/>
                    <span class="input-group-btn">
                        <button class="btn btn-warning btn-sm" type="button" id="btn_lov_pic" onclick="getLovPIC()">
                            <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                        </button>
                    </span>
                </div>

            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right">NIK </label>
                <div class="col-sm-8">
                    <input type="text" id="nik" class="col-sm-10 required" value="" readonly>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix form-actions">
        <div class="col-md-offset-3 col-md-9">
            <button class="btn btn-info" type="button">
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
<div id="lov_lokasi_pks" class="lov_content"></div>

<script type="text/javascript">

    $("#mitraForm").click(function () {
        //swal("yihaa");
        // $('#mitraForm')[0].reset();
        // $(this).closest('form').find("input[type=text], textarea").val("");
    });

    function getLovSegment() {
        var divID = "mitraForm_segment"; //// Parameter id input
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
            }
        });
    }

    function getLovPIC() {
        var divID = "pic_id#~#picname#~#jabatan#~#alamat#~#email#~#no_hp#~#fax"; // Parameter id input
        var lov_target_id = "lov_pic"; // Harus sama dengan id class lov
        var modal_id = "modal_lov_pic"; // Terserah
        $(".lov_content").html("");
        $.ajax({
            // async: false,
            url: "<?php echo base_url();?>managementmitra/lovPIC",
            type: "POST",
            data: {divID: divID, lov_target_id: lov_target_id, modal_id: modal_id},
            success: function (data) {
                $('#' + lov_target_id).html(data);
                $('#' + modal_id).modal('show');
            }
        });
    }
</script>
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
                data: {divID: divID, lov_target_id: lov_target_id, modal_id: modal_id,cc_name:cc},
                success: function (data) {
                    $('#' + lov_target_id).html(data);
                    $('#' + modal_id).modal('show');
                }
            });
        }else{
            swal("Note","Segment belum diisi !","warning");
        }
    });


    $('#mitraForm').find('input[type=text],select,textarea').each(function () {
        //   $(this).attr('disabled', true);
        // $('#contract').attr("disabled", true);
    });

    $("#edit").click(function () {
        $('#mitraForm').find('input[type=text],select,textarea').each(function () {
            $(this).attr('disabled', false);
            // $('#contract').attr("disabled", true);
        })
    });
    $("#save").click(function () {
        $('#mitraForm').find('input[type=text],select,textarea').each(function () {
            $(this).attr('disabled', true);
            // $('#contract').attr("disabled", true);
        })
    });


</script>

