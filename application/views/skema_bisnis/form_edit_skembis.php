<div class="row">
    <form name="form_edit_skembis" class="form-horizontal" role="form" id="form_edit_skembis">
        <?php foreach ($comp as $comp_fee) {
            ; ?>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="form-field-1-1"> <?php echo $comp_fee['CF_NAME']; ?> </label>
                <div class="col-sm-2 input-group">
                    <input type="text" id="<?php echo $comp_fee['CF_NAME']; ?>"
                           name="<?php echo $comp_fee['CF_NAME']; ?>"
                           placeholder="Diisi % benefit mitra" class="form-control"/>
                    <span class="input-group-addon">%</span>
                </div>
            </div>
            <?php
        }; ?>
        <div class="form-group">
            <label class="col-sm-3 control-label" for="form-field-1-1"> PPN </label>
            <div class="col-sm-2 input-group">
                <input type="text" id="PPN" name="PPN" placeholder="Diisi % benefit mitra" value="10"
                       class="form-control"/>
                <span class="input-group-addon">%</span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label" for="form-field-1-1"> BPH JASTEL </label>
            <div class="col-sm-2 input-group">
                <input type="text" id="BPH_JASTEL" name="BPH_JASTEL" placeholder="Diisi % benefit mitra" value="0"
                       class="form-control"/>
                <span class="input-group-addon">%</span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label" for="form-field-1-1"> MARFEE BEFORE TAX </label>
            <div class="col-sm-2 input-group">
                <input type="text" id="MARFEE_BEFORE_TAX" name="MARFEE_BEFORE_TAX" placeholder="Diisi % benefit mitra"
                       value="0" class="form-control"/>
                <span class="input-group-addon">%</span>
            </div>
        </div>
        <hr>
        <div class="col-xs-2"></div>

        <div id="button-form" class="col-xs-12">
            <div class="col-xs-2">

            </div>
            <span id="group1">
                <a type="button" class="btn btn-white btn-info btn-bold" id="save_edit_skema">
                    <i class="ace-icon fa fa-floppy-o bigger-120 green"></i>
                    Save Skema Mitra
                </a>
                <a type="button" class="btn btn-white btn-info btn-bold" id="back_gridskema">
                    <i class="ace-icon fa fa-arrow-circle-left bigger-120 red"></i>
                    Kembali
                </a>
            </span>
        </div>
        <input type="hidden" name="PGL_ID" id="PGL_ID" value="<?php echo $PGL_ID;?>">
        <input type="hidden" name="SCHM_FEE_ID" id="SCHM_FEE_ID" value="<?php echo $SCHM_FEE_ID;?>">
        <input type="hidden" name="CF_ID" id="CF_ID" value="<?php echo $CF_ID;?>">
        <input type="hidden" name="METHOD_ID" id="METHOD_ID" value="<?php echo $METHOD_ID;?>">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
               value="<?php echo $this->security->get_csrf_hash(); ?>">
    </form>
</div>
<script type="text/javascript">
    $("#save_edit_skema").click(function () {

        var data = $("#form_edit_skembis").serializeArray();
        $.ajax({
            url: "<?php echo site_url('skema_bisnis/edit_action_skembis');?>",
            cache: false,
            type: "POST",
            data: data,
            dataType: "json",
            success: function (data) {
                if (data.success == true) {
                    swal("", data.message, "success");
                    $( "#back_gridskema" ).trigger( "click" );
                } else {
                    swal("", data.message, "error");

                }

            }

        });
        return false;
    })

    $("#back_gridskema").click(function () {
        $.ajax({
            url: "<?php echo site_url('skema_bisnis/skembis');?>",
            type: "POST",
            data: {mitra:<?php echo $PGL_ID;?> },
            timeout: 10000,
            success: function (data) {
                $("#main_content").html(data);
            }
        });
    })
    var arr = <?php echo $comp_json;?>;
    for(var i = 0; i < arr.length; i++) {
        var obj = arr[i];
        $('#'+obj.CF_NAME).val(obj.PERCENTAGE);
    }
</script>
