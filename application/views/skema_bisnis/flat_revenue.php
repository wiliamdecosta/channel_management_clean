<div class="form-group">
    <label class="col-sm-2 control-label no-padding-right"> Flat Revenue </label>
    <div class="col-sm-6">
        <input type="text" id="flat_revenue" name="flat_revenue" placeholder="Rp." value="" class="form-control"/>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label no-padding-right"></label>
    <div class="col-sm-6">
       <span id="group1">
        <a type="button" class="btn btn-white btn-info btn-bold" id="save_flat_skema">
            <i class="ace-icon fa fa-floppy-o bigger-120 green"></i>
            Save Skema Mitra
        </a>
    </span>
    </div>
</div>
<script type="text/javascript">
    $("#save_flat_skema").click(function(){
        var data =   $("#form_create_skemas").serializeArray();
        $.ajax({
            url: "<?php echo site_url('skema_bisnis/addFlatSkema');?>",
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