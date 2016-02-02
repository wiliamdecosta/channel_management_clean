<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modal Header</h4>
            </div>
            <div class="modal-body">
                <div id="tbl_pic">
                    <table id="grid_table_lov"></table>
                    <div id="grid_pager_lov"></div>
                    <input id="lov_value" type="text" value="<?php echo $divID;?>" hidden>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        var grid_selector = "#grid_table_lov";
        var pager_selector = "#grid_pager_lov";
        //resize to fit page size
        $(window).on('resize.jqGrid', function () {
            $(grid_selector).jqGrid('setGridWidth', '570');
        });
        $(window).on('resize.jqGrid', function () {
            $(pager_selector).jqGrid('setGridWidth', '570');
        });

        jQuery("#grid_table_lov").jqGrid({
            url: '<?php echo site_url('managementmitra/grid_lov_pic');?>',
            datatype: "json",
            mtype: "POST",
            colModel: [
                {
                    label: 'Pilih',
                    width: 40,
                    fixed: true,
                    align: "center",
                    sortable: false,
                    formatter: function (cellvalue, options, rowObject) {
                        var ID = rowObject.P_PIC_ID;
                        var PIC_NAME = rowObject.PIC_NAME;
                        var JABATAN = rowObject.JABATAN;
                        var ADDRESS_1 = rowObject.ADDRESS_1;
                        var Email = rowObject.EMAIL;
                        var NO_HP = rowObject.NO_HP;
                        var FAX = rowObject.FAX;
                        var params = ID + "#~#" + PIC_NAME + "#~#" + JABATAN + "#~#" + ADDRESS_1 + "#~#" + Email + "#~#" + NO_HP + "#~#" + FAX;
                        return "<button class='btn btn-success btn-xs' onclick='returnValue(\"" + params + "\") '> <i class='ace-icon fa fa-reply icon-only'></i></button>";
                    }
                },
                {label: 'ID', name: 'P_PIC_ID', key: true, width: 5, sorttype: 'number', editable: true, hidden: true},
                {
                    label: 'Nama PIC',
                    name: 'PIC_NAME',
                    align: "left",
                    editable: true,
                    editrules: {required: true}
                },
                {
                    label: 'Jabatan',
                    name: 'JABATAN',
                    align: "left",
                    editable: true,
                    editrules: {required: true}
                },
                {
                    label: 'Alamat',
                    name: 'ADDRESS_1',
                    align: "left",
                    editable: true,
                    editrules: {required: true}
                },
                {
                    label: 'Kota',
                    name: 'KOTA',
                    align: "left",
                    editable: true,
                    editrules: {required: true}
                },
                {
                    label: 'Email',
                    name: 'EMAIL',
                    align: "left",
                    editable: true,
                    editrules: {required: true}
                },
                {
                    label: 'No HP',
                    name: 'NO_HP',
                    align: "left",
                    editable: true,
                    editrules: {required: true},
                    editoptions: {size: 45}
                }
            ],
            width: null,
            //  AutoWidth: true,
            height: '100%',
            scrollOffset: 0,
            rowNum: 5,
            viewrecords: true,
            rowList: [5, 10, 20],
            //sortname: 'P_MAP_MIT_CC_ID', // default sorting ID
            rownumbers: true, // show row numbers
            rownumWidth: 35,
            sortorder: 'asc',
            altRows: true,
            shrinkToFit: false,
            multiboxonly: true,
            onSortCol: clearSelection,
            onPaging: clearSelection,
            pager: '#grid_pager_lov',
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
            caption: "List PIC Mitra"

        });
    });

    //navButtons grid master
    jQuery('#grid_table_lov').jqGrid('navGrid', '#grid_pager_lov',
        { 	//navbar options
            edit: false,
            excel: false,
            editicon: 'ace-icon fa fa-pencil blue',
            add: false,
            addicon: 'ace-icon fa fa-plus-circle purple',
            del: false,
            delicon: 'ace-icon fa fa-trash-o red',
            search: false,
            searchicon: 'ace-icon fa fa-search orange',
            refresh: false,
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
            beforeShowForm: function (e, form) {
                var form = $(e[0]);
                form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar')
                    .wrapInner('<div class="widget-header" />');
                style_edit_form(form);
                $("#tr_PASSWD", form).show();
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

    function beforeEditCallback(e) {
        var form = $(e[0]);
        form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />');
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
    function getRowValue(rowid) {
        jQuery('#grid_table_lov').jqGrid('setSelection', '2');
//        var grid = $("#grid_table_lov");
//
//        var rowKey = grid.jqGrid('getGridParam', 'selrow');
//        var PIC_NAME = grid.jqGrid('getCell', rowKey, 'PIC_NAME');
//        return alert(PIC_NAME);
        var grid = $('#grid_table_lov'), ID,
            selRowId = grid.jqGrid('getGridParam', 'selrow');

        if (selRowId !== null) {
            ID = grid.jqGrid('getCell', rowid, 'ID');
            if (ID != "")
                $('#txtStopGridID').val(ID);
            else
                alert("You must have a row selected on the grid before clicking the Stop button!");
        }
        else
            alert("selRowId is equal to null for btnSPStop onClick method.");

        return false;
    }

</script>