<div class="breadcrumbs" id="breadcrumbs">
    <?= $this->breadcrumb; ?>
</div>
<?php
$prv = getPrivilege($this->menu_id); ?>

<!-- /section:basics/content.breadcrumbs -->
<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <table id="grid-table"></table>
            <div id="grid-pager"></div>
        </div><!-- /.col -->
    </div><!-- /.row -->
    <br>

    <div class="row">
        <div class="col-xs-12">
            <div id="detailsPlaceholder" style="display:none">
                <table id="jqGridDetails"></table>
                <div id="jqGridDetailsPager"></div>
            </div>
        </div>

    </div>
</div><!-- /.page-content -->

<script type="text/javascript">
    $(document).ready(function () {
        var grid = $("#grid-table");
        var pager = $("#grid-pager");

        var grid2 = $("#jqGridDetails");
        var pager2 = $("#jqGridDetailsPager");

        //resize to fit page size
        var parent_column = grid.closest('[class*="col-"]');
        $(window).on('resize.jqGrid', function () {
            grid.jqGrid('setGridWidth', $(".page-content").width() - 1);
            grid2.jqGrid('setGridWidth', $(".page-content").width() - 1);
        });
        //optional: resize on sidebar collapse/expand and container fixed/unfixed
        $(document).on('settings.ace.jqGrid', function (ev, event_name, collapsed) {
            if (event_name === 'sidebar_collapsed' || event_name === 'main_container_fixed') {
                grid.jqGrid('setGridWidth', parent_column.width());
                grid2.jqGrid('setGridWidth', parent_column.width());
            }
        });
        var width = $(".page-content").width();
        grid.jqGrid({
            url: '<?php echo site_url('admin/gridmenu');?>',
            datatype: "json",
            mtype: "POST",
            colModel: [
                {label: 'ID', name: 'MENU_ID', key: true, width: 5, sorttype: 'number', editable: true, hidden: true},
                {
                    label: 'Nama Menu',
                    name: 'MENU_NAME',
                    width: 140,
                    align: "left",
                    editable: true,
                    editrules: {required: true}
                },
                {
                    label: 'Menu Parent',
                    name: 'MENU_PARENT',
                    width: 140,
                    align: "left",
                    editable: true,
                    hidden: true,
                    editrules: {required: true, edithidden: true},
                    editoptions: {defaultValue: '0', readonly: 'readonly'}
                },
                {label: 'Icon', name: 'MENU_ICON', width: 145, align: "left", editable: true},
                {label: 'Desc', name: 'MENU_DESC', width: 165, align: "left", editable: true}
            ],
            width: width,
            //width: '100%',
            height: '100%',
            // autowidth: true,
            rowNum: 5,
            page: 1,
            viewrecords: true,
            rowList: [5, 10, 20],
            sortname: 'MENU_NAME ', // default sorting ID
            rownumbers: true, // show row numbers
            rownumWidth: 35, // the width of the row numbers columns
            sortorder: 'asc',
            altRows: true,
            shrinkToFit: true,
            //multiselect: true,
            //multikey: "ctrlKey",
            multiboxonly: true,

            onSelectRow: function (rowid) {
                var celValue = $('#grid-table').jqGrid('getCell', rowid, 'MENU_NAME');
                var grid_id = $("#jqGridDetails");
                if (rowid != null) {
                    grid_id.jqGrid('setGridParam', {
                        url: "<?php echo site_url('admin/gridMenuchild');?>/" + rowid,
                        datatype: 'json',
                        postData: {parent_id: rowid},
                        userData: {row: rowid}
                    });
                    grid_id.jqGrid('setCaption', 'Menu Child :: ' + celValue);
                    $("#detailsPlaceholder").show();
                    $("#jqGridDetails").trigger("reloadGrid");
                }
            }, // use the onSelectRow that is triggered on row click to show a details grid
            onSortCol: clearSelection,
            onPaging: clearSelection,
            //#pager merupakan div id pager
            pager: '#grid-pager',
            jsonReader: {
                root: 'Data',
                id: 'id',
                repeatitems: false
            },
            loadComplete: function () {
                var table = this;
                setTimeout(function () {
                    //  styleCheckbox(table);

                    //  updateActionIcons(table);
                    updatePagerIcons(table);
                    enableTooltips(table);
                }, 0);

            },
            //memanggil controller jqgrid yang ada di controller crud

            editurl: '<?php echo site_url('admin/menuCRUD');?>',
            caption: "Menu Parent"

        });


        //navButtons grid master
        $('#grid-table').jqGrid('navGrid', '#grid-pager',
            { 	//navbar options
                edit: <?php if (isset($prv['UBAH'])) {
                            if ($prv['UBAH'] == "Y") {
                                echo 'true';
                            }else{
                                echo 'false';
                            }
                        }
                ?>,
                excel: true,
                editicon: 'ace-icon fa fa-pencil blue',
                add: true,
                addicon: 'ace-icon fa fa-plus-circle purple',
                del: true,
                delicon: 'ace-icon fa fa-trash-o red',
                search: true,
                searchicon: 'ace-icon fa fa-search orange',
                refresh: true,
                afterRefresh: function () {
                    // some code here
                    jQuery("#detailsPlaceholder").hide();
                },
                refreshicon: 'ace-icon fa fa-refresh green',
                view: false,
                viewicon: 'ace-icon fa fa-search-plus grey'
            },
            {
                // options for the Edit Dialog
                closeAfterEdit: true,
                width: 500,
                errorTextFormat: function (data) {
                    return 'Error: ' + data.responseText
                },
                recreateForm: true,
                beforeShowForm: function (e) {
                    var form = $(e[0]);
                    form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />');
                    style_edit_form(form);
                }
            },
            {
                //new record form
                width: 400,
                errorTextFormat: function (data) {
                    return 'Error: ' + data.responseText
                },
                closeAfterAdd: true,
                recreateForm: true,
                viewPagerButtons: false,
                beforeShowForm: function (e) {
                    var form = $(e[0]);
                    form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar')
                        .wrapInner('<div class="widget-header" />');
                    style_edit_form(form);
                }
            },
            {
                //delete record form
                recreateForm: true,
                beforeShowForm: function (e) {
                    var form = $(e[0]);
                    if (form.data('styled')) return false;

                    form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />');
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
                    form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />');
                    style_search_form(form);
                },
                afterRedraw: function () {
                    style_search_filters($(this));
                }

//            multipleSearch: true,
                //           showQuery: true
                /**
                 multipleGroup:true,
                 showQuery: true
                 */
            },
            {
                //view record form
                recreateForm: true,
                beforeShowForm: function (e) {
                    var form = $(e[0]);
                    form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
                }
            }
        );

        //JqGrid Detail
        $("#jqGridDetails").jqGrid({
            mtype: "POST",
            datatype: "json",
            colModel: [
                {label: 'Menu ID', name: 'MENU_ID', key: true, autowidth: true, editable: true, hidden: true},
                // { label: 'Parent', name: 'MENU_PARENT', width: 65, editable: true, hidden:false,editoptions: {size:30, maxlength: 15} },
                {label: 'Nama Menu', name: 'MENU_NAME', editable: true},
                {label: 'Controller', name: 'MENU_LINK', editable: true},
                {label: 'View', name: 'FILE_NAME', editable: true}
            ],
            width: width,
            height: '100%',
            rowNum: 5,
            page: 1,
            shrinkToFit: true,
            rownumbers: true,
            rownumWidth: 35, // the width of the row numbers columns
            viewrecords: true,
            sortname: 'MENU_NAME ', // default sorting ID
            caption: 'Menu Child',
            sortorder: 'asc',
            pager: "#jqGridDetailsPager",
            jsonReader: {
                root: 'Data',
                id: 'id',
                repeatitems: false
            },
            loadComplete: function () {
                var table = this;
                setTimeout(function () {
                    //  styleCheckbox(table);

                    //  updateActionIcons(table);
                    updatePagerIcons(table);
                    enableTooltips(table);
                }, 0);
            },
            editurl: '<?php echo site_url('admin/crud_detail');?>'
        });

        //navButtons Grid Detail
        $('#jqGridDetails').jqGrid('navGrid', '#jqGridDetailsPager',
            { 	//navbar options
                edit: true,
                excel: true,
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
                editData: {
                    MENU_PARENT: function () {
                        var data = jQuery("#jqGridDetails").jqGrid('getGridParam', 'postData');
                        return data.parent_id;
                    }
                },
                closeAfterEdit: true,
                width: 500,
                errorTextFormat: function (data) {
                    return 'Error: ' + data.responseText
                },
                recreateForm: true,
                beforeShowForm: function (e) {
                    var form = $(e[0]);
                    form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />');
                    style_edit_form(form);
                }
            },
            {

                editData: {
                    MENU_PARENT: function () {
                        var data = jQuery("#jqGridDetails").jqGrid('getGridParam', 'postData');
                        return data.parent_id;
                    }
                },
                onClickButton: function () {
                    alert('sss');
                },
                //new record form
                width: 400,
                errorTextFormat: function (data) {
                    return 'Error: ' + data.responseText
                },
                closeAfterAdd: true,
                recreateForm: true,
                viewPagerButtons: false,
                beforeShowForm: function (e) {
                    var form = $(e[0]);
                    form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar')
                        .wrapInner('<div class="widget-header" />');
                    style_edit_form(form);
                }

            },
            {
                //delete record form
                recreateForm: true,
                beforeShowForm: function (e) {
                    var form = $(e[0]);
                    if (form.data('styled')) return false;

                    form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />');
                    style_delete_form(form);

                    form.data('styled', true);
                },
                onClick: function (e) {
                    //alert(1);
                }
            },
            {
                //search form
                //closeAfterSearch: true,
                recreateForm: true,
                afterShowSearch: function (e) {
                    var form = $(e[0]);
                    form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />');
                    style_search_form(form);
                },
                afterRedraw: function () {
                    style_search_filters($(this));
                }

                // multipleSearch: true
                /**
                 multipleGroup:true,
                 showQuery: true
                 */
            },
            {
                //view record form
                recreateForm: true,
                beforeShowForm: function (e) {
                    var form = $(e[0]);
                    form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
                }
            }
        );

        function clearSelection() {
            //jQuery("#jqGridDetails").jqGrid('setGridParam',{url: "empty.json", datatype: 'json'}); // the last setting is for demo purpose only
            var jqGridDetail = $("#jqGridDetails");
            // jqGridDetail.jqGrid('setCaption', 'Menu Child ::');
            jqGridDetail.jqGrid("clearGridData");
        }

        function style_edit_form(form) {
            //enable datepicker on "sdate" field and switches for "stock" field
            form.find('input[name=sdate]').datepicker({format: 'yyyy-mm-dd', autoclose: true});

            form.find('input[name=stock]').addClass('ace ace-switch ace-switch-5').after('<span class="lbl"></span>');
            //don't wrap inside a label element, the checkbox value won't be submitted (POST'ed)
            //.addClass('ace ace-switch ace-switch-5').wrap('<label class="inline" />').after('<span class="lbl"></span>');


            //update buttons classes
            var buttons = form.next().find('.EditButton .fm-button');
            buttons.addClass('btn btn-sm').find('[class*="-icon"]').hide();//ui-icon, s-icon
            buttons.eq(0).addClass('btn-primary').prepend('<i class="ace-icon fa fa-check"></i>');
            buttons.eq(1).prepend('<i class="ace-icon fa fa-times"></i>');

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
            var buttons = dialog.find('.EditTable');
            buttons.find('.EditButton a[id*="_reset"]').addClass('btn btn-sm btn-info').find('.ui-icon').attr('class', 'ace-icon fa fa-retweet');
            buttons.find('.EditButton a[id*="_query"]').addClass('btn btn-sm btn-inverse').find('.ui-icon').attr('class', 'ace-icon fa fa-comment-o');
            buttons.find('.EditButton a[id*="_search"]').addClass('btn btn-sm btn-purple').find('.ui-icon').attr('class', 'ace-icon fa fa-search');
        }

        function beforeDeleteCallback(e) {
            var form = $(e[0]);
            if (form.data('styled')) return false;

            form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />');
            style_delete_form(form);

            form.data('styled', true);
        }

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