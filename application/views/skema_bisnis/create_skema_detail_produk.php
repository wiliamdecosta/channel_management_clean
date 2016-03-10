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
        <input type="text" id="PPN" name="PPN" placeholder="Diisi % benefit mitra" value="10" class="form-control"/>
        <span class="input-group-addon">%</span>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-3 control-label" for="form-field-1-1"> BPH JASTEL </label>
    <div class="col-sm-2 input-group">
        <input type="text" id="BPH_JASTEL" name="BPH_JASTEL" placeholder="Diisi % benefit mitra" value="0" class="form-control"/>
        <span class="input-group-addon">%</span>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-3 control-label" for="form-field-1-1"> MARFEE BEFORE TAX </label>
    <div class="col-sm-2 input-group">
        <input type="text" id="MARFEE_BEFORE_TAX" name="MARFEE_BEFORE_TAX" placeholder="Diisi % benefit mitra" value="0" class="form-control"/>
        <span class="input-group-addon">%</span>
    </div>
</div>
<hr>
<div class="col-xs-2"></div>
<div id="button-form" class="col-xs-2">
    <span id="group1">
        <a type="button" class="btn btn-white btn-info btn-bold" id="save_skema">
            <i class="ace-icon fa fa-floppy-o bigger-120 green"></i>
            Save Skema Mitra
        </a>
    </span>
</div>
<script type="text/javascript">
    $("#save_skema").click(function(){

            var data = $("#form_create_skemas").serializeArray();
            $.ajax({
                url: "<?php echo site_url('skema_bisnis/form_skema_bisnis');?>",
                cache: false,
                type: "POST",
                data: data,
                dataType: "json",
                success: function (data) {
                    if (data.success == true) {
                        swal("", data.message, "success");
                        $('#form_create_skemas').trigger("reset");
                        $("#form_skembis").hide("slow");
                        $("#tbl_skema").show("slow");
                        var grid = $("#grid_table_pic");
                        var pager = $("#grid_pager_pic");
                        grid.trigger("reloadGrid", [{page: 1}]);
                        $(window).on('resize.jqGrid', function () {
                        grid.jqGrid('setGridWidth', $('#tbl_skema').width());
                         });
                         $(window).on('resize.jqGrid', function () {
                        pager.jqGrid('setGridWidth', $('#tbl_skema').width());
                        });
                    } else {
                        swal("", data.message, "error");

                    }

                }

            });
            return false;
    })


</script>
