<!-- #section:basics/content.breadcrumbs -->
<script type="text/css">
    .ui-jqgrid .ui-jqgrid-btable
    {
        table-layout:auto;
    }
</script>
<div class="breadcrumbs" id="breadcrumbs">
    <?= $this->breadcrumb; ?>
</div>

<!-- /section:basics/content.breadcrumbs -->
<div class="page-content">


    <div class="row">
        <div class="col-xs-12" style="width: 100%;">
            <!-- PAGE CONTENT BEGINS -->
            <table id="grid-table"></table>


            <div id="grid-pager"></div>

            <script type="text/javascript">
                var $path_base = "..";//in Ace demo this will be used for editurl parameter
            </script>

            <br>

            <div id="detailsPlaceholder" style="display:none">
                <table id="jqGridDetails"></table>
                <div id="jqGridDetailsPager"></div>
            </div>
            <!-- PAGE CONTENT ENDS -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.page-content -->

<script type="text/javascript">
    $(document).ready(function () {
        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";

        //resize to fit page size
        $(window).on('resize.jqGrid', function () {
            $(grid_selector).jqGrid('setGridWidth', $(".page-content").width());
        })
        
        jQuery("#grid-table").jqGrid({
            url: '<?php echo site_url('parameter/gridCustPGL');?>',
            datatype: "json",
            mtype: "POST",
            colModel: [
                {
                    label: 'ID',
                    name: 'PGL_ID',
                    key: true,
                    width: 35,
                    sorttype: 'number',
                    sortable: true,
                    editable: false,
                    hidden: true
                },
                {
                    label: 'Nama Mitra',
                    name: 'PGL_NAME',
                    width: 250,
                    align: "left",
                    sortable: true,
                    editable: true,
                    editrules: {required: true},
                    editoptions: {size: 45, value: {Tes: 'asdad'}}
                },
                {
                    label: 'Alamat',
                    name: 'PGL_ADDR',
                    width: 250,
                    align: "left",
                    editable: true,
                    edittype:"textarea",
                    editoptions: {rows:"5",cols:"45", value: {Tes: 'asdad'}}
                },
                {
                    label: 'No Telp/HP',
                    name: 'PGL_CONTACT_NO',
                    width: 250,
                    align: "left",
                    sortable: true,
                    editable: true,
                    editoptions: {size: 45, value: {Tes: 'asdad'}}
                },
                {   
                    label :'Fee ?',
                    name : 'ENABLE_FEE',
                    width:200,
                    sortable:true,
                    align:'center',
                    editable:true,
                    edittype: 'select', 
                    formatter: 'select',
                    editoptions:{value: {'0' : 'TIDAK', '1' : 'YA'}}
                }
                     
            ],
            caption: "MITRA",
            width: 1120,
            height: '100%',
            scrollOffset: 0,
            rowNum: 5,
            viewrecords: true,
            rowList: [5, 10, 20],
            sortname: 'PGL_NAME', // default sorting ID
            rownumbers: true, // show row numbers
            rownumWidth: 35, // the width of the row numbers columns
            sortorder: 'asc',
            altRows: true,
            shrinkToFit: true,
            //multiselect: true,
            //multikey: "ctrlKey",
            multiboxonly: true,

            onSelectRow: function (rowid) {
                var celValue = $('#grid-table').jqGrid('getCell', rowid, 'PGL_NAME');
                var grid_id = jQuery("#jqGridDetails");
                if (rowid != null) {
                    grid_id.jqGrid('setGridParam', {
                        url: "<?php echo site_url('parameter/gridCustTEN');?>/" + rowid,
                        datatype: 'json',
                        postData: {parent_id: rowid},
                        userData: {row: rowid}
                    });
                    grid_id.jqGrid('setCaption', 'TENAN :: ' + celValue);
                    jQuery("#detailsPlaceholder").show();
                    jQuery("#jqGridDetails").trigger("reloadGrid");
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
            editurl: '<?php echo site_url('parameter/crud_cust_pgl');?>'
        });
    });
    //JqGrid Detail

    //navButtons grid master
    jQuery('#grid-table').jqGrid('navGrid', '#grid-pager',
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
            beforeShowForm: function (e) {
                var form = $(e[0]);
                form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
                style_edit_form(form);
            },
            
            afterSubmit: function (response) {
                
                var response = JSON.parse(response.responseText);
                if(response.success == false) {
                    showBootDialog(true, BootstrapDialog.TYPE_WARNING, 'Attention', response.message);
                }
                
                return [true, '', response.responseText];
            }
        },
        {
            //new record form
            width: 500,
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
            afterSubmit: function (response) {
                
                var response = JSON.parse(response.responseText);
                if(response.success == false) {
                    showBootDialog(true, BootstrapDialog.TYPE_WARNING, 'Attention', response.message);
                }
                
                return [true, '', response.responseText];
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
    )


    function clearSelection() {
        //jQuery("#jqGridDetails").jqGrid('setGridParam',{url: "empty.json", datatype: 'json'}); // the last setting is for demo purpose only
        jQuery("#jqGridDetails").jqGrid('setCaption', 'Menu Child ::');
        jQuery("#jqGridDetails").trigger("reloadGrid");

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


    //----------------------------------------------------------------------------------------------------------//
    //JqGrid Detail
    $("#jqGridDetails").jqGrid({
        mtype: "POST",
        datatype: "json",
        colModel: [
            {
                label: 'ID',
                name: 'TEN_ID',
                key: true,
                width: 35,
                sorttype: 'number',
                sortable: true,
                editable: false,
                hidden: true
            },
            {
                label: 'NCLI',
                name: 'NCLI',
                width: 250,
                align: "left",
                sortable: true,
                editable: true,
                editrules: {required: true},
                editoptions: {size: 45, value: {Tes: 'asdad'}}
            },
            {
                label: 'Nama Tenan',
                name: 'TEN_NAME',
                width: 250,
                align: "left",
                editable: true,
                editrules: {required: true},
                editoptions: {size: 45, value: {Tes: 'asdad'}}
            },
            {
                label: 'Alamat',
                name: 'TEN_ADDR',
                width: 250,
                align: "left",
                editable: true,
                edittype:"textarea",
                editoptions: {rows:"5",cols:"45", value: {Tes: 'asdad'}}
            },
            {
                label: 'No Telp/HP',
                name: 'TEN_CONTACT_NO',
                width: 250,
                align: "left",
                editable: true,
                editoptions: {size: 45, value: {Tes: 'asdad'}}
            }
        ],
        //width: '100%',
        height: '100%',
        width: 1120,
        page: 1,
        //height: '100%',
        rowNum: 5,
        shrinkToFit: true,
        rownumbers: true,
        rownumWidth: 35, // the width of the row numbers columns
        viewrecords: true,
        sortname: 'TEN_NAME', // default sorting ID
        caption: 'Daftar Tenan',
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
        editurl: '<?php echo site_url('parameter/crud_cust_ten');?>',
        subGrid: true, // set the subGrid property to true to show expand buttons for each row
        subGridRowExpanded: showTenanNDGrid, // javascript function that will take care of showing the child grid
        subGridOptions : {
            // load the subgrid data only once
            // and the just show/hide
            reloadOnExpand :false,
            // select the row when the expand column is clicked
            selectOnExpand : false,
            plusicon : "ace-icon fa fa-plus center bigger-110 blue",
            minusicon  : "ace-icon fa fa-minus center bigger-110 blue"
           // openicon : "ace-icon fa fa-chevron-right center orange"
        }
        
    });
    
    function showTenanNDGrid(parentRowID, parentRowKey) {
        var childGridID = parentRowID + "_table";
        var childGridPagerID = parentRowID + "_pager";

        // send the parent row primary key to the server so that we know which grid to show
        var childGridURL = "<?php echo site_url('parameter/gridTenND');?>/"
                
        
        // add a table and pager HTML elements to the parent grid row - we will render the child grid here
        $('#' + parentRowID).append('<table id="' + childGridID + '"></table><div id="' + childGridPagerID + '" class="scroll"></div>');

        $("#" + childGridID).jqGrid({
            url: childGridURL,
            mtype: "POST",
            datatype: "json",
            page: 1,
            rowNum: 5,
            rownumbers: true, // show row numbers
            rownumWidth: 35,
            shrinkToFit: false,
            postData:{parent_id:encodeURIComponent(parentRowKey)},
            colModel: [
                { label: 'ID', name: 'ND', key: true, width:125, sorttype:'number', editable: false,hidden:false },
                { label: 'NCLI', name: 'NCLI', width:125, align:"left", editable:false},
                { label: 'NDOS', name: 'NDOS', width:80, align:"left", editable:false},
                { label: 'AKTIF', name: 'AKTIF', width:80, align:"left", editable:false},
                { label: 'CPROD', name: 'CPROD', width:80, align:"left", editable:false},
                { label: 'VALID FROM', name: 'VALID_FROM', width:100, align:"left", editable:false},
                { label: 'VALID TO', name: 'VALID_TO', width:100, align:"left", editable:false}
            ],
            width: '100%',
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
            pager:childGridPagerID
        });
        
        jQuery("#"+childGridID).jqGrid('navGrid',"#"+childGridPagerID,{   
            edit:false,
            add:false,
            del:false,
            search:true,
            searchicon: 'ace-icon fa fa-search orange',
            refresh: true,
            refreshicon: 'ace-icon fa fa-refresh green',
            view: false,
            viewicon: 'ace-icon fa fa-search-plus grey'
        });
        
    }


    //navButtons Grid Detail -- P_REFERENCE_LIST
    jQuery('#jqGridDetails').jqGrid('navGrid', '#jqGridDetailsPager',
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
                PARENT_ID: function () {
                    var data = jQuery("#jqGridDetails").jqGrid('getGridParam', 'postData');
                    var parent_id = data.parent_id;
                    return parent_id;
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
                form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
                style_edit_form(form);
            }
        },
        {

            editData: {
                PARENT_ID: function () {
                    var data = jQuery("#jqGridDetails").jqGrid('getGridParam', 'postData');
                    var parent_id = data.parent_id;
                    return parent_id;
                }
            },
            onClickButton: function () {
                alert('sss');
            },
            //new record form
            width: 500,
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
            },
            msg: 'Penghapusan terhadap data Tenan akan secara otomatis menghapus data Tenan ND yang berkaitan. <br>Apakah Anda yakin menghapus data tersebut?',
            width:'400px'
        },
        {
            //search form
            //closeAfterSearch: true,
            recreateForm: true,
            afterShowSearch: function (e) {
                var form = $(e[0]);
                form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
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
    )
</script>