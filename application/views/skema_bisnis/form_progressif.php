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

<hr>
<div class="form-group">
    <label class="col-sm-2 control-label no-padding-right"> Revenue Value </label>
    <div class="col-sm-6">
        <input type="text" id="revenue" name="revenue" placeholder="Rp." value=""
               class="form-control"/>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label no-padding-right"></label>
    <div class="col-sm-8">
        <div class="row" id="grid_skema_custom">
            <div class="col-xs-12">
                <table id="grid-table2"></table>
                <div id="grid-pager2"></div>
            </div>
        </div>
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
    $(document).ready(function () {
        var grid = $("#grid-table2");
        var pager = $("#grid-pager2");
        //resize to fit page size
        var parent_column = grid.closest('[class*="col-"]');
        $(window).on('resize.jqGrid', function () {
            grid.jqGrid('setGridWidth', $("#grid_skema_custom").width() - 10);
        })
        //optional: resize on sidebar collapse/expand and container fixed/unfixed
        $(document).on('settings.ace.jqGrid', function (ev, event_name, collapsed) {
            if (event_name === 'sidebar_collapsed' || event_name === 'main_container_fixed') {
                grid.jqGrid('setGridWidth', parent_column.width());
            }
        })
        var width = $("#grid_skema_custom").width() - 10;
        grid.jqGrid({
            url: '<?php echo site_url('skema_bisnis/gridTierCondition');?>',
            datatype: "json",
            postData: {COMMITMENT_ID: '<?php echo $commitment_id;?>'},
            mtype: "POST",
            caption: "Tier Condition",
            colModel: [
                {
                    label: 'ID',
                    name: 'TIER_ID',
                    key: true,
                    width: 5,
                    sorttype: 'number',
                    editable: true,
                    hidden: true
                },
                {
                    label: 'TIER',
                    name: 'TIER',
                    width: 70,
                    align: "left",
                    editable: true,
                    editoptions: {
                        size: 5
                    },
                    editrules: {required: true}
                },
                {
                    label: 'Minimum Value',
                    name: 'MINIMUM_VALUE',
                    width: 150,
                    align: "left",
                    editable: true,
                    editoptions: {
                        size: 35
                    },
                    editrules: {required: true}
                },
                {
                    label: 'Maximum Value',
                    name: 'MAXIMUM_VALUE',
                    width: 150,
                    align: "left",
                    editable: true,
                    editoptions: {
                        size: 35
                    },
                    editrules: {required: true}
                },
                {
                    label: 'Persentase %',
                    name: 'PRC',
                    width: 75,
                    align: "left",
                    editable: true,
                    editoptions: {
                        size: 5
                    },
                    editrules: {
                        required: true
                    }
                }
            ],

            width: width,
            height: '100%',
            scrollOffset: 0,
            rowNum: 10,
            viewrecords: true,
            rowList: [10, 20, 50],
            sortname: 'TIER', // default sorting ID
            rownumbers: true, // show row numbers
            rownumWidth: 35,
            sortorder: 'asc',
            altRows: true,
            shrinkToFit: true,
            multiboxonly: true,
            onSortCol: clearSelection,
            onPaging: clearSelection,
            pager: '#grid-pager2',
            jsonReader: {
                root: 'Data',
                id: 'id',
                repeatitems: false
            }
            ,
            loadComplete: function () {

                var table = this;
                setTimeout(function () {
                    updatePagerIcons(table);
                    enableTooltips(table);
                }, 0);
            },
            editurl: '<?php echo site_url('skema_bisnis/crud_tier_cond');?>'

        });

        //navButtons grid master
        grid.jqGrid('navGrid', '#grid-pager2',
            { 	//navbar options
                edit: true,
                excel: false,
                editicon: 'ace-icon fa fa-pencil blue',
                add: true,
                addicon: 'ace-icon fa fa-plus-circle purple',
                del: true,
                delicon: 'ace-icon fa fa-trash-o red',
                search: true,
                searchicon: 'ace-icon fa fa-search orange',
                refresh: true,
                refreshicon: 'ace-icon fa fa-refresh green',
                view: false,
                viewicon: 'ace-icon fa fa-search-plus grey'
            },
            {
                // options for the Edit Dialog
                closeAfterEdit: true,
                width: 600,
                errorTextFormat: function (data) {
                    return 'Error: ' + data.responseText
                },
                recreateForm: true,
                beforeShowForm: function (e, form) {
                    var form = $(e[0]);
                    form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
                    style_edit_form(form);

                }
            },
            {
                //new record form
                width: 600,
                errorTextFormat: function (data) {
                    return 'Error: ' + data.responseText
                },
                closeAfterAdd: false,
                recreateForm: true,
                viewPagerButtons: false,
                beforeShowForm: function (e, form) {
                    var form = $(e[0]);
                    form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar')
                        .wrapInner('<div class="widget-header" />')
                    style_edit_form(form);
                },
                onclickSubmit: function (rowid) {
                    var COMMITMENT_ID = '<?php echo $commitment_id;?>';
                    return {COMMITMENT_ID: COMMITMENT_ID};
                }
            },
            {
                //delete record form
                recreateForm: true,
                beforeShowForm: function (e) {
                    var form = $(e[0]);
                    if (form.data('styled')) return false;

                    form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
                    style_delete_form(form);

                    form.data('styled', true);
                },
                onClick: function (e) {
                    //alert(1);
                }
            },
            {
                //search form
                // closeAfterSearch: true,
                recreateForm: true,
                afterShowSearch: function (e) {
                    var form = $(e[0]);
                    form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
                    style_search_form(form);
                },
                afterRedraw: function () {
                    style_search_filters($(this));
                }

            },
            {
                //view record form
                width: 500,
                recreateForm: true,
                beforeShowForm: function (e) {
                    var form = $(e[0]);
                    form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
                }
            });


        function clearSelection() {

        }

        function style_edit_form(form) {
            //enable datepicker on "sdate" field and switches for "stock" field
            form.find('input[name=sdate]').datepicker({format: 'yyyy-mm-dd', autoclose: true})

            form.find('input[name=stock]').addClass('ace ace-switch ace-switch-5').after('<span class="lbl"></span>');
            //don't wrap inside a label element, the checkbox value won't be submitted (POST'ed)
            //.addClass('ace ace-switch ace-switch-5').wrap('<label class="inline" />').after('<span class="lbl"></span>');


            //update buttons classes
            var buttons = form.next().find('.EditButton .fm-button');
            buttons.addClass('btn btn-sm').find('[class*="-icon"]').hide();//ui-icon, s-icon
            buttons.eq(0).addClass('btn-primary').prepend('<i class="ace-icon fa fa-check"></i>');
            buttons.eq(1).prepend('<i class="ace-icon fa fa-times"></i>')

            buttons = form.next().find('.navButton a');
            buttons.find('.ui-icon').hide();
            buttons.eq(0).append('<i class="ace-icon fa fa-chevron-left"></i>');
            buttons.eq(1).append('<i class="ace-icon fa fa-chevron-right"></i>');
        }

        function style_delete_form(form) {
            var buttons = form.next().find('.EditButton .fm-button');
            buttons.addClass('btn btn-sm btn-white btn-round').find('[class*="-icon"]').hide();//ui-icon, s-icon
            buttons.eq(0).addClass('btn-danger').prepend('<i class="ace-icon fa fa-trash-o"></i>');
            buttons.eq(1).addClass('btn-default').prepend('<i class="ace-icon fa fa-times"></i>')
        }

        function style_search_filters(form) {
            form.find('.delete-rule').val('X');
            form.find('.add-rule').addClass('btn btn-xs btn-primary');
            form.find('.add-group').addClass('btn btn-xs btn-success');
            form.find('.delete-group').addClass('btn btn-xs btn-danger');
        }

        function style_search_form(form) {
            var dialog = form.closest('.ui-jqdialog');
            var buttons = dialog.find('.EditTable')
            buttons.find('.EditButton a[id*="_reset"]').addClass('btn btn-sm btn-info').find('.ui-icon').attr('class', 'ace-icon fa fa-retweet');
            buttons.find('.EditButton a[id*="_query"]').addClass('btn btn-sm btn-inverse').find('.ui-icon').attr('class', 'ace-icon fa fa-comment-o');
            buttons.find('.EditButton a[id*="_search"]').addClass('btn btn-sm btn-purple').find('.ui-icon').attr('class', 'ace-icon fa fa-search');
        }

        function beforeDeleteCallback(e) {
            var form = $(e[0]);
            if (form.data('styled')) return false;

            form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
            style_delete_form(form);

            form.data('styled', true);
        }

        function beforeEditCallback(e) {
            var form = $(e[0]);
            form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
            style_edit_form(form);
        }


        //it causes some flicker when reloading or navigating grid
        //it may be possible to have some custom formatter to do this as the grid is being created to prevent this
        //or go back to default browser checkbox styles for the grid
        function styleCheckbox(table) {
            /**
             $(table).find('input:checkbox').addClass('ace')
             .wrap('<label />')
             .after('<span class="lbl align-top" />')


             $('.ui-jqgrid-labels th[id*="_cb"]:first-child')
             .find('input.cbox[type=checkbox]').addClass('ace')
             .wrap('<label />').after('<span class="lbl align-top" />');
             */
        }


        //unlike navButtons icons, action icons in rows seem to be hard-coded
        //you can change them like this in here if you want
        function updateActionIcons(table) {
            /**
             var replacement =
             {
                 'ui-ace-icon fa fa-pencil' : 'ace-icon fa fa-pencil blue',
                 'ui-ace-icon fa fa-trash-o' : 'ace-icon fa fa-trash-o red',
                 'ui-icon-disk' : 'ace-icon fa fa-check green',
                 'ui-icon-cancel' : 'ace-icon fa fa-times red'
             };
             $(table).find('.ui-pg-div span.ui-icon').each(function(){
						var icon = $(this);
						var $class = $.trim(icon.attr('class').replace('ui-icon', ''));
						if($class in replacement) icon.attr('class', 'ui-icon '+replacement[$class]);
					})
             */
        }

        //replace icons with FontAwesome icons like above
        function updatePagerIcons(table) {
            var replacement =
            {
                'ui-icon-seek-first': 'ace-icon fa fa-angle-double-left bigger-140',
                'ui-icon-seek-prev': 'ace-icon fa fa-angle-left bigger-140',
                'ui-icon-seek-next': 'ace-icon fa fa-angle-right bigger-140',
                'ui-icon-seek-end': 'ace-icon fa fa-angle-double-right bigger-140'
            };
            $('.ui-pg-table:not(.navtable) > tbody > tr > .ui-pg-button > .ui-icon').each(function () {
                var icon = $(this);
                var $class = $.trim(icon.attr('class').replace('ui-icon', ''));

                if ($class in replacement) icon.attr('class', 'ui-icon ' + replacement[$class]);
            })
        }

        function enableTooltips(table) {
            $('.navtable .ui-pg-button').tooltip({container: 'body'});
            $(table).find('.ui-pg-div').tooltip({container: 'body'});
        }
    });
</script>

<script type="text/javascript">
    $("#save_skema_progressif").click(function () {
        var comp = [];
        var items = $('#jqxTree').jqxTree('getCheckedItems');
        for (var i = 0; i < items.length; i++) {
            var item = items[i];
            comp[i] = item.value;
        }

        var pgl_id = $("#form_pgl_id").val();
        var skema_type = $("#form_skembis_type").val();

        var revenue = $('#revenue').val();

        $.ajax({
            url: "<?php echo site_url('skema_bisnis/addCompProgressif');?>",
            cache: false,
            type: "POST",
            data: {
                comp,
                pgl_id: pgl_id,
                skema_type: skema_type,
                revenue: revenue,
                commitment_id: <?php echo $commitment_id;?>},
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