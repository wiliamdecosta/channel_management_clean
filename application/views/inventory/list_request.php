<?php $prv = getPrivilege($menu_id); ?>
<div class="row">
    <div class="col-xs-12">
        &nbsp;
        <div id="list_requests">
            <table id="grid-table"></table>
            <div id="grid-pager"></div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        var grid = $("#grid-table");
        var pager = $("#grid-pager");

        var parent_column = grid.closest('[class*="col-"]');
        $(window).on('resize.jqGrid', function () {
            grid.jqGrid('setGridWidth', $("#list_requests").width() - 1);
            pager.jqGrid('setGridWidth', $("#list_requests").width() - 1);
        });

        $(document).on('settings.ace.jqGrid', function (ev, event_name, collapsed) {
            if (event_name === 'sidebar_collapsed' || event_name === 'main_container_fixed') {
                grid.jqGrid('setGridWidth', parent_column.width());
                pager.jqGrid('setGridWidth', parent_column.width());
            }
        });
        var width = $("#list_requests").width();
        grid.jqGrid({
            url: '<?php echo site_url('inventory/gridListRequest');?>',
            datatype: "json",
            mtype: "POST",
            postData: {},
            caption: "List Item",
            colModel: [
                {
                    label: 'ID',
                    name: 'PURCHASE_ORDER_ID',
                    key: true,
                    width: 200,
                    sortable: true,
                    editable: false,
                    editrules: {required: false},
                    hidden: true
                },
                {
                    label: 'P_INVENTORY_ID',
                    name: 'P_INVENTORY_ID',
                    editable: true,
                    editrules: {required: false},
                    hidden: true
                },
                {
                    label: 'Nama Item',
                    name: 'ITEM_NAME',
                    width: 200,
                    align: "left",
                    sortable: true,
                    editable: false,
                    editrules: {required: false}
                },
                {
                    label: 'Status',
                    name: 'STATUS',
                    width: 100,
                    align: "left",
                    sortable: true,
                    hidden: true,
                    editable: true,
                    edittype: 'select',
                    editrules: {required: true, edithidden: true},
                    editoptions: {dataUrl: '<?php echo site_url('inventory/listStatusReq');?>'}
                },
                {
                    label: 'Jumlah Req',
                    name: 'ORDER_QTY',
                    width: 100,
                    align: "left",
                    sortable: true,
                    editable: true,
                    hidden: false,
                    editrules: {required: false}
                    // editoptions : {readonly: 'readonly'}
                },
                {
                    label: 'Status',
                    name: 'STATUS_CODE',
                    width: 100,
                    align: "center",
                    sortable: true,
                    editable: false,
                    editrules: {required: true},
                    formatter: function (cellvalue, options, rowObject) {
                        if (cellvalue == "Waiting") {
                            return '<button class="btn btn-round btn-mini btn-grey" data-toggle="dropdown" aria-expanded="false"> ' +
                                cellvalue +
                                ' </button> ';
                        }
                        if (cellvalue == "Approve") {
                            return '<button class="btn btn-round btn-mini btn-success" data-toggle="dropdown" aria-expanded="false"> ' +
                                cellvalue +
                                ' </button> ';
                        }
                        if (cellvalue == "Reject") {
                            return '<button class="btn btn-round btn-mini btn-danger" data-toggle="dropdown" aria-expanded="false"> ' +
                                cellvalue +
                                ' </button> ';
                        }

                    }
                },
                {
                    label: 'Note',
                    name: 'NOTE',
                    width: 200,
                    align: "left",
                    sortable: true,
                    editable: true,
                    edittype: 'textarea',
                    editrules: {required: true},
                    editoptions: {
                        rows: "2",
                        cols: "30"
                    }
                },
                {
                    label: 'Approve/Reject By',
                    width: 100,
                    align: "left",
                    sortable: true,
                    editable: false,
                    formatter: function (cellvalue, options, rowObject) {
                        return rowObject.UPDATED_BY + " - " + rowObject.UPDATED_DATE;
                    }
                },
                {
                    label: 'Request By',
                    width: 100,
                    align: "left",
                    sortable: true,
                    editable: false,
                    formatter: function (cellvalue, options, rowObject) {
                        return rowObject.CREATED_BY + " - " + rowObject.CREATED_DATE;
                    }
                }

            ],
            width: width,
            height: '100%',
            scrollOffset: 0,
            rowNum: 5,
            viewrecords: true,
            rowList: [5, 10, 20],
            sortname: 'ITEM_NAME', // default sorting ID
            rownumbers: true, // show row numbers
            rownumWidth: 35, // the width of the row numbers columns
            sortorder: 'asc',
            altRows: true,
            shrinkToFit: true,
            multiboxonly: true,
            onSelectRow: function (rowid) {

            },
            onSortCol: clearSelection,
            onPaging: clearSelection,
            pager: '#grid-pager',
            jsonReader: {
                root: 'Data',
                id: 'id',
                repeatitems: false
            },
            loadComplete: function () {
                var table = this;
                setTimeout(function () {
                    updatePagerIcons(table);
                    enableTooltips(table);
                }, 0);
            },
            editurl: '<?php echo site_url('inventory/updateListReq');?>',


        });

        grid.jqGrid('navGrid', '#grid-pager',
            { 	//navbar options
                edit: <?php
                if ($prv['UBAH'] == "Y") {
                    echo 'true';
                } else {
                    echo 'false';

                }
                ?>,
                excel: true,
                editicon: 'ace-icon fa fa-pencil blue',
                add: false,
                addicon: 'ace-icon fa fa-plus-circle purple',
                del: false,
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
                viewicon: 'ace-icon fa fa-search-plus grey',
            },
            {
                // options for the Edit Dialog
                closeAfterEdit: true,
                width: 500,
                errorTextFormat: function (data) {
                    return 'Error: ' + data.responseText
                },
                recreateForm: true,
                beforeInitData: function (formid) {
                    selRowId = grid.jqGrid('getGridParam', 'selrow');
                    status = grid.jqGrid('getCell', selRowId, 'STATUS');

                    if (status != 18) {
                        swal('', 'Tidak bisa merubah data karena status bukan Waiting', 'error');
                        return false;
                    } else {
                        return true;
                    }


                },
                beforeShowForm: function (e) {
                    //var status =  $('#tr_STATUS', e).val();
                    $('#tr_ORDER_QTY', e).hide();
                    var form = $(e[0]);
                    form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
                    style_edit_form(form);
                }
            },
            {
                //new record form
                width: 500,
                postData: {tes: "aa"},
                errorTextFormat: function (data) {
                    return 'Error: ' + data.responseText
                },
                closeAfterAdd: true,
                recreateForm: true,
                viewPagerButtons: false,
                beforeShowForm: function (e) {
                    var form = $(e[0]);
                    form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar')
                        .wrapInner('<div class="widget-header" />')
                    style_edit_form(form);
                },
                beforeSubmit: function () {

                },
                onclickSubmit: function () {
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
                }

                ,
                afterRedraw: function () {
                    style_search_filters($(this));
                }

            }
            ,
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

        }

        function style_edit_form(form) {
            //enable datepicker on "sdate" field and switches for "stock" field
            //  form.find('input[name=VALID_FROM]').datepicker({format: 'yyyy-mm-dd', autoclose: true})

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

        //add tooltip for small view action buttons in dropdown menu
        $('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});

        //tooltip placement on right or left
        function tooltip_placement(context, source) {
            var $source = $(source);
            var $parent = $source.closest('table')
            var off1 = $parent.offset();
            var w1 = $parent.width();

            var off2 = $source.offset();
            //var w2 = $source.width();

            if (parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2)) return 'right';
            return 'left';
        }
    });
</script>
