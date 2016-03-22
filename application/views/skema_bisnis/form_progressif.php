<style>
    li[class*="item-"] {
        border: 0px solid #DDD !important;
        border-left-width: 3px;
    }
</style>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/jqwidgets/styles/jqx.base.css" type="text/css"/>
<!--<link rel="stylesheet" href="--><?php //echo base_url();?><!--assets/js/jqwidgets/styles/jqx.energyblue.css" type="text/css" />-->
<!--<link rel="stylesheet" href="--><?php //echo base_url();?><!--assets/js/jqwidgets/styles/jqx-all.css" type="text/css" />-->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jqwidgets/jqxcore.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jqwidgets/jqxbuttons.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jqwidgets/jqxscrollbar.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jqwidgets/jqxpanel.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jqwidgets/jqxtree.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jqwidgets/jqxcheckbox.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jqwidgets/jqxdata.js"></script>

<div class="form-group">
    <label class="col-sm-2 control-label no-padding-right">Pilih Commitment</label>
    <div class="col-sm-6">
        <?php echo buatcombo("form_commitment", "form_commitment", "V_COMMITMENT_MTR", "VALUE", "COMMITMENT_ID", array('COMMITMENT_METHOD' => 12), ""); ?>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label no-padding-right"></label>
    <div class="col-sm-6">
        <div id="tree_comp">
            <div class="widget-box widget-color-blue">
                <div class="widget-header">
                    <h4 class="widget-title lighter smaller">Daftar Menu</h4>
                </div>

                <div style="margin-left:10px;">
                    <input type="checkbox" name="all" id="all" value="">All<br>
                    <!--                    <a class="btn btn-sm btn-primary" id="save">Save</a></div>-->

                    <div class="widget-body">
                        <div class="widget-main padding-8">
                            <div id='jqxTree' style='visibility: hidden;'>

                            </div>
                            <!--  <div>
                            <input type="hidden" name="prof_id" id="prof_id" value="<? /*= $prof_id;*/ ?>">
                        </div>-->
                        </div>
                    </div>

                </div>
                <script type="text/javascript">
                    $(document).ready(function () {

                        $('#jqxTree').css('visibility', 'visible');
                        $('#save').click(function () {
                            var str = [];
                            var items = $('#jqxTree').jqxTree('getCheckedItems');
                            for (var i = 0; i < items.length; i++) {
                                var item = items[i];
                                str[i] = item.value;
                            }
                            //alert("The checked items are " + str);
                            $.ajax({
                                type: 'POST',
                                url: '<?php echo site_url('skema_bisnis/saveCompMRT');?>',
                                data: {check_val: str},
                                timeout: 10000,
                                success: function (data) {
                                    $("#menutreAjax").html(data);
                                }
                            })
                        });
                        $('#selectall').click(function (event) {
                            $('#jqxTree').jqxTree('checkAll');
                        });
                        $('#all').on('change', function (event) {
                            if ($(this).is(':checked')) {
                                $('#jqxTree').jqxTree('checkAll');
                            } else {
                                $('#jqxTree').jqxTree('uncheckAll');
                            }

                        });
                        $('#jqxTree').on('checkChange', function (event) {

                            var args = event.args;
                            var checked = args.checked;
                            var element = args.element;
                            var items_check = $('#jqxTree').jqxTree('getCheckedItems');
                            var items_uncheck = $('#jqxTree').jqxTree('getUncheckedItems');
                            var item = items_check[0];
                            var checkString = checked ? 1 : 0; // 1:checked , 0:unchecked


                            // alert(checkString + ''  + items_check);
                            return false;
                            if (checkString == '1') {

                                item = items_check[0].value;
                            } else {

                                item = items_uncheck[0].value;
                            }
                        });

                    });
                </script>
                <script type="text/javascript">
                    $(document).ready(function () {
                        // prepare the data
                        var source =
                        {
                            datatype: "json",
                            datafields: [
                                {name: 'id'},
                                {name: 'parentid'},
                                {name: 'text'},
                                {name: 'value'}
                                //  { name: 'checked' }
                                //  { name: 'app_menu_profile_id' }
                            ],
                            id: 'id',
                            url: '<?php echo site_url('skema_bisnis/getTreeComp');?>',
                            async: false
                        };
                        // create data adapter.
                        var dataAdapter = new $.jqx.dataAdapter(source);
                        // perform Data Binding.
                        dataAdapter.dataBind();
                        // get the tree items. The first parameter is the item's id. The second parameter is the parent item's id. The 'items' parameter represents
                        // the sub items collection name. Each jqxTree item has a 'label' property, but in the JSON data, we have a 'text' field. The last parameter
                        // specifies the mapping between the 'text' and 'label' fields.
                        var records = dataAdapter.getRecordsHierarchy('id', '', 'items', [{
                            name: 'text',
                            map: 'label'
                        }]);
                        $('#jqxTree').jqxTree({
                            source: records,
                            checkboxes: true,
                            height: '300px'
//            hasThreeStates: true,
//            theme: 'energyblue'
                        });


                    });
                </script>

            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label no-padding-right"></label>
    <div class="col-sm-6">
        <a type="button" class="btn btn-white btn-info btn-bold" id="save_skema_progressif">
            <i class="ace-icon fa fa-floppy-o bigger-120 green"></i>
            Save Skema Mitra
        </a>
    </div>
</div>


<script type="text/javascript">
    $("#save_skema_progressif").click(function () {
        var comp = [];
        var items = $('#jqxTree').jqxTree('getCheckedItems');
        for (var i = 0; i < items.length; i++) {
            var item = items[i];
            comp[i] = item.value;
        }

        var pgl_id = $("#form_pgl_id").val();
        var commitment_id = $("#form_commitment").val();
        var skema_type = $("#form_skembis_type").val();

        $.ajax({
            url: "<?php echo site_url('skema_bisnis/addCompProgressif');?>",
            cache: false,
            type: "POST",
            data: {comp, pgl_id: pgl_id, commitment_id: commitment_id, skema_type: skema_type},
            dataType: "json",
            success: function (data) {
                if (data.success == true) {
                    swal("", data.message, "success");
                    $('#form_create_skemas').trigger("reset");
                    $("#form_skembis").hide("slow");
                    $("#tbl_skema").show("slow");
                    $("#benefit_mitra_detail").html("");
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