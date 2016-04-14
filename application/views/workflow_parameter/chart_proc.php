<!-- #section:basics/content.breadcrumbs -->
<script type="text/css">
    .ui-jqgrid .ui-jqgrid-btable
    {
        table-layout:auto;
    }
</script>
<div class="breadcrumbs" id="breadcrumbs">
    <?php echo getBreadcrumb(array('Workflow Parameter','Daftar Workflow')); ?>
</div>

<!-- /section:basics/content.breadcrumbs -->

<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="row">
                <div class="col-xs-12">
                    <div class="tabbable">
                        <ul class="nav nav-tabs padding-18 tab-size-bigger tab-color-blue">
                            <li class="active">
                                <a href="#" data-toggle="tab" aria-expanded="true" id="tab-1">
                                    <i class="blue bigger-120"></i>
                                    <strong>Aliran Prosedur</strong>
                                </a>
                            </li>
                        </ul>
                        <input type="hidden" id="tab_chart_proc_id" value="">
                        <input type="hidden" id="tab_chart_proc_code" value="">
                    </div>
                    
                    <div class="tab-content no-border">
                        <div class="row">
                            <div class="col-xs-12">       
                               <table id="grid-table"></table>
                               <div id="grid-pager"></div>

                               <script type="text/javascript">
                                    var $path_base = "..";//in Ace demo this will be used for editurl parameter
                                </script>    
                            </div>
                        </div>

                        <br>
    
                        <div class="row">
                            <div class="col-sm-3" id="detailsPlaceholder" style="display:none">
                                <table id="jqGridDetailPrev"></table>
                                <div id="jqGridDetailsPagerPrev"></div>
                            </div>
                            <div class="col-sm-1"></div>
                            <div class="col-sm-7" id="detailsPlaceholderNext" style="display:none;">
                                <table id="jqGridDetailNext"></table>
                                <div id="jqGridDetailsPagerNext"></div>
                            </div>
                        </div>

                    </div>
                </div>    
            </div>
            <!-- PAGE CONTENT ENDS -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.page-content -->

<?php 
    $this->load->view('parameter/lov_procedure.php');
?>

<script type="text/javascript">
    function showLovProc(id, code) {
        modal_lov_procedure_show(id,code);
    }

    function showDaemon(idd) {        
        var code = $("#jqGridDetailNext").jqGrid ('getCell', idd, 'DOC_NAME');
        // alert(code);
        loadContentWithParams("workflow_parameter-chart_proc_daemon.php", {
            p_w_chart_proc_id: idd,
            workflow_name : code
        });
    }

    $(document).ready(function () {
        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";

        //resize to fit page size
        // $(window).on('resize.jqGrid', function () {
        //     $(grid_selector).jqGrid('setGridWidth', $(".page-content").width());
        // })
        $(window).on('resize.jqGrid', function () {
            responsive_jqgrid(grid_selector, pager_selector);
        });
        
        $(document).on('settings.ace.jqGrid' , function(ev, event_name, collapsed) {
            if( event_name === 'sidebar_collapsed' || event_name === 'main_container_fixed' ) {
               responsive_jqgrid(grid_selector, pager_selector);
            }
        });
        
        jQuery("#grid-table").jqGrid({
            url: '<?php echo site_url('workflow_parameter/grid_workflow_list');?>',
            datatype: "json",
            mtype: "POST",
            colModel: [
                {label: 'ID', name: 'P_WORKFLOW_ID', key: true, width: 35, sorttype: 'number', sortable: true, editable: true, hidden:true},
                {
                    label: 'Nama Dokumen',
                    name: 'LDOCUMENT', 
                    width: 200, 
                    sortable: true, 
                    editable: true
                }, 
                {
                    label: 'Nama Workflow', 
                    name: 'LWORKFLOW', 
                    width: 200, 
                    sortable: true, 
                    editable: true
                },                
                {
                    label: 'Aktif?', 
                    name: 'LACTIVE', 
                    width: 60, 
                    sortable: true, 
                    editable: true
                }, 
                {
                    label: 'Jumlah Transisi', 
                    name: 'CABANG', 
                    width: 60, 
                    sortable: true, 
                    editable: true
                }
            ],
            caption: "Daftar Workflow",
            width: 1120,
            height: '100%',
            scrollOffset: 0,
            rowNum: 5,
            viewrecords: true,
            rowList: [5, 10, 20],
            rownumbers: true, // show row numbers
            rownumWidth: 35, // the width of the row numbers columns
            altRows: true,
            shrinkToFit: true,
            multiboxonly: true,

            onSelectRow: function (rowid) {
                var grid_id = jQuery("#jqGridDetailPrev");
                if (rowid != null) {
                    grid_id.jqGrid('setGridParam', {
                        url: "<?php echo site_url('workflow_parameter/gridChartProcPrev');?>/" + rowid,
                        datatype: 'json',
                        postData: {P_WORKFLOW_ID: rowid},
                        userData: {row: rowid}
                    });
                    grid_id.jqGrid('setCaption', 'Daftar Aliran Prosedur');
                    jQuery("#detailsPlaceholder").show();
                    jQuery("#detailsPlaceholderNext").hide();
                    jQuery("#jqGridDetailPrev").trigger("reloadGrid");
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
            editurl: '<?php echo site_url('parameter/crud_user_attribute_type');?>'
        });
    });
    //JqGrid Detail

    //navButtons grid master
    jQuery('#grid-table').jqGrid('navGrid', '#grid-pager',
        { 	//navbar options
            edit: false,
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
                jQuery("#detailsPlaceholderNext").hide();
            },
            refreshicon: 'ace-icon fa fa-refresh green',
            view: false,
            viewicon: 'ace-icon fa fa-search-plus grey',
        },
        {}, // settings for edit
        {}, // settings for add
        {}, // settings for delete
        {
            //search form
            closeAfterSearch: true,
            recreateForm: true,
            onSearch: function (){
                jQuery("#detailsPlaceholder").hide();
                jQuery("#detailsPlaceholderNext").hide();
            },
            onReset: function () {
                jQuery("#detailsPlaceholder").hide();
                jQuery("#detailsPlaceholderNext").hide();
            },
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

    function responsive_jqgrid(grid_selector, pager_selector) {
        var parent_column = $(grid_selector).closest('[class*="col-"]');
        $(grid_selector).jqGrid( 'setGridWidth', $(".page-content").width() );
        $(pager_selector).jqGrid( 'setGridWidth', parent_column.width() );
    }


    //----------------------------------------------------------------------------------------------------------//
    //JqGrid Detail
    $("#jqGridDetailPrev").jqGrid({
        mtype: "POST",
        datatype: "json",
        colModel: [
            {
                label: 'P_WORKFLOW_ID',
                name: 'P_WORKFLOW_ID',
                width: 35,
                sorttype: 'number',
                sortable: true,
                editable: false,
                hidden: true
            },            
            {
                label: 'Prosedur Sebelum', 
                name: 'PROC_DISPLAY_PREV', 
                width: 330, 
                align: "left",  
                editable: false
            },   
            {
                label: 'Pekerjaan Sebelum',
                name: 'P_PROCEDURE_ID_PREV', 
                width: 200, 
                sortable: true, 
                key: true,
                editable: true,
                hidden: true,
                editrules: {edithidden: true, number:true, required:true},
                edittype: 'custom',
                editoptions: {
                    "custom_element":function( value  , options) {                            
                        var elm = $('<span></span>');
                        
                        // give the editor time to initialize
                        setTimeout( function() {
                            elm.append('<input id="form_p_procedure_id_prev" type="text"  style="display:none;">'+
                                    '<input id="form_p_procedure_code" disabled type="text" class="col-xs-9 jqgrid-required" placeholder="Pilih Jenis Dokumen">'+
                                    '<button class="btn btn-warning btn-sm" type="button" onclick="showLovProc(\'form_p_procedure_id_prev\',\'form_p_procedure_code\')">'+
                                    '   <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>'+
                                    '</button>');
                            $("#form_p_procedure_id_prev").val(value);
                            elm.parent().removeClass('jqgrid-required');
                        }, 100);
                        
                        return elm;
                    },
                    "custom_value":function( element, oper, gridval) {
                        
                        if(oper === 'get') {
                            return $("#form_p_procedure_id_prev").val();
                        } else if( oper === 'set') {
                            $("#form_p_procedure_id_prev").val(gridval);
                            var gridId = this.id;
                            // give the editor time to set display
                            setTimeout(function(){
                                var selectedRowId = $("#"+gridId).jqGrid ('getGridParam', 'selrow');
                                if(selectedRowId != null) {
                                    var code_display = $("#"+gridId).jqGrid('getCell', selectedRowId, 'PROC_DISPLAY_PREV');
                                    $("#form_p_procedure_code").val( code_display );
                                }
                            },100);
                        }
                    }
                }
            },
            {
                label: 'Prosedur Sesudah', 
                name: 'PEKERJAAN_NEXT', 
                width: 250, 
                align: "left",  
                editable: false,
                hidden: true
            },   
            {
                label: 'Pekerjaan Sesudah',
                name: 'P_PROCEDURE_ID_NEXT', 
                width: 200, 
                sortable: true, 
                editable: true,
                hidden: true,
                editrules: {edithidden: true, number:true},
                edittype: 'custom',
                editoptions: {
                    "custom_element":function( value  , options) {                            
                        var elm = $('<span></span>');
                        
                        // give the editor time to initialize
                        setTimeout( function() {
                            elm.append('<input id="form_p_procedure_id_next" type="text"  style="display:none;">'+
                                    '<input id="form_pekerjaan_next" disabled type="text" class="col-xs-9 jqgrid" placeholder="Pilih Jenis Dokumen">'+
                                    '<button class="btn btn-warning btn-sm" type="button" onclick="showLovProc(\'form_p_procedure_id_next\',\'form_pekerjaan_next\')">'+
                                    '   <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>'+
                                    '</button>');
                            $("#form_p_procedure_id_next").val(value);
                            elm.parent().removeClass('jqgrid-required');
                        }, 100);
                        
                        return elm;
                    },
                    "custom_value":function( element, oper, gridval) {
                        
                        if(oper === 'get') {
                            return $("#form_p_procedure_id_next").val();
                        } else if( oper === 'set') {
                            $("#form_p_procedure_id_next").val(gridval);
                            var gridId = this.id;
                            // give the editor time to set display
                            setTimeout(function(){
                                var selectedRowId = $("#"+gridId).jqGrid ('getGridParam', 'selrow');
                                if(selectedRowId != null) {
                                    var code_display = $("#"+gridId).jqGrid('getCell', selectedRowId, 'PEKERJAAN_NEXT');
                                    $("#form_pekerjaan_next").val( code_display );
                                }
                            },100);
                        }
                    }
                }
            },
            {
                label: 'Alternate (Dispatcher)', 
                name: 'PEKERJAAN_ALT', 
                width: 250, 
                align: "left",  
                editable: false,
                hidden: true
            },   
            {
                label: 'Alternate (Dispatcher)',
                name: 'P_PROCEDURE_ID_ALT', 
                width: 200, 
                sortable: true, 
                editable: true,
                hidden: true,
                editrules: {edithidden: true, number:true},
                edittype: 'custom',
                editoptions: {
                    "custom_element":function( value  , options) {                            
                        var elm = $('<span></span>');
                        
                        // give the editor time to initialize
                        setTimeout( function() {
                            elm.append('<input id="form_p_procedure_id_alt" type="text"  style="display:none;">'+
                                    '<input id="form_pekerjaan_alt" disabled type="text" class="col-xs-9 jqgrid" placeholder="Pilih Jenis Dokumen">'+
                                    '<button class="btn btn-warning btn-sm" type="button" onclick="showLovProc(\'form_p_procedure_id_alt\',\'form_pekerjaan_alt\')">'+
                                    '   <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>'+
                                    '</button>');
                            $("#form_p_procedure_id_alt").val(value);
                            elm.parent().removeClass('jqgrid-required');
                        }, 100);
                        
                        return elm;
                    },
                    "custom_value":function( element, oper, gridval) {
                        
                        if(oper === 'get') {
                            return $("#form_p_procedure_id_alt").val();
                        } else if( oper === 'set') {
                            $("#form_p_procedure_id_alt").val(gridval);
                            var gridId = this.id;
                            // give the editor time to set display
                            setTimeout(function(){
                                var selectedRowId = $("#"+gridId).jqGrid ('getGridParam', 'selrow');
                                if(selectedRowId != null) {
                                    var code_display = $("#"+gridId).jqGrid('getCell', selectedRowId, 'PEKERJAAN_ALT');
                                    $("#form_pekerjaan_alt").val( code_display );
                                }
                            },100);
                        }
                    }
                }
            }, 
            {
                label: 'Level Pembatalan Workflow',
                name: 'IMPORTANCE_LEVEL',
                width: 100,
                sortable: true,
                editable: true,
                edittype: 'select',
                formatter: 'select',
                editrules: {edithidden: true, required:true},
                editoptions: {value: {'O': 'OPSIONAL', 'M': 'WAJIB'}},
                hidden: true
            },
            {
                label: 'Fungsi Init',
                name: 'F_INIT',
                width: 300,
                align: "left",
                sortable: true,
                editable: true,
                editoptions: {
                    size: 55,
                    maxlength:64
                },
                editrules: {edithidden: true},
                hidden: true
            },
            {
                label: 'No.',
                name: 'SEQUENCE_NO',
                width: 70,
                align: "center",
                sortable: true,
                editable: true,
                sorttype: 'number',
                editoptions: {
                    size: 10,
                    maxlength:5
                },
                editrules: {edithidden: true, required: false},
                hidden: true
            },
            {
                label: 'Mulai Berlaku',
                name: 'VALID_FROM',
                width: 250,
                editable: true,
                editrules: {edithidden: true, required: true},
                edittype:"text",
                editoptions: {
                    // dataInit is the client-side event that fires upon initializing the toolbar search field for a column
                    // use it to place a third party control to customize the toolbar
                    dataInit: function (element) {
                       $(element).datepicker({
                            autoclose: true,
                            format: 'dd-mm-yyyy',
                            orientation : 'bottom'
                        });
                    }
                },
                hidden: true
            },
            {
                label: 'Akhir Berlaku',
                name: 'VALID_TO',
                width: 250,
                editable: true,
                editrules: {edithidden: true},
                edittype:"text",                
                editoptions: {
                    // dataInit is the client-side event that fires upon initializing the toolbar search field for a column
                    // use it to place a third party control to customize the toolbar
                    dataInit: function (element) {
                       $(element).datepicker({
                            autoclose: true,
                            format: 'dd-mm-yyyy',
                            orientation : 'bottom'
                        });
                    }
                },
                hidden: true
            },
            {
                label: 'Tanggal Dibuat',
                name: 'CREATION_DATE',
                width: 250,
                align: "left",
                sortable: true,
                editable: false,
                hidden: true
            },
            {
                label: 'Dibuat Oleh',
                name: 'CREATED_BY',
                width: 250,
                align: "left",
                sortable: true,
                editable: false,
                hidden: true
            },
            {
                label: 'Tanggal Diubah',
                name: 'UPDATED_DATE',
                width: 250,
                align: "left",
                sortable: true,
                editable: false,
                hidden: true
            },
            {
                label: 'Diubah Oleh',
                name: 'UPDATED_BY',
                width: 250,
                align: "left",
                sortable: true,
                editable: false,
                hidden: true
            },
        ],
        width: '100%',
        height: '100%',
        // width: 1120,
        page: 1,
        rowNum: 5,
        shrinkToFit: true,
        rownumbers: true,
        rownumWidth: 35, // the width of the row numbers columns
        viewrecords: false,
        caption: 'Daftar Aliran Prosedur',
        pager: "#jqGridDetailsPagerPrev",
        jsonReader: {
            root: 'Data',
            id: 'id',
            repeatitems: false
        },
        onSelectRow: function (rowid) {
            var pw_id = $('#jqGridDetailPrev').jqGrid('getCell', rowid, 'P_WORKFLOW_ID');
            var dis_prev = $('#jqGridDetailPrev').jqGrid('getCell', rowid, 'PROC_DISPLAY_PREV');
            var grid_id = jQuery("#jqGridDetailNext");
            if (rowid != null) {
                grid_id.jqGrid('setGridParam', {
                    url: "<?php echo site_url('workflow_parameter/gridChartProcNext');?>/" + rowid,
                    datatype: 'json',
                    postData: {P_PROCEDURE_ID_PREV: rowid, PROC_DISPLAY_PREV: dis_prev, P_WORKFLOW_ID: pw_id},
                    userData: {row: rowid}
                });
                grid_id.jqGrid('setCaption', 'Daftar Aliran Prosedur Sesudah');
                jQuery("#detailsPlaceholderNext").show();
                jQuery("#jqGridDetailNext").trigger("reloadGrid");
            }
        }, // use the onSelectRow that is triggered on row click to show a details grid
        loadComplete: function () {
            var table = this;
            setTimeout(function () {
                //  styleCheckbox(table);

                //  updateActionIcons(table);
                updatePagerIcons(table);
                enableTooltips(table);
            }, 0);
        },
        editurl: '<?php echo site_url('workflow_parameter/crud_chart_proc_prev');?>'
    });

    //navButtons Grid Detail -- P_REFERENCE_LIST
    jQuery('#jqGridDetailPrev').jqGrid('navGrid', '#jqGridDetailsPagerPrev',
        {   //navbar options
            edit: false,
            excel: true,
            editicon: 'ace-icon fa fa-pencil blue',
            add: true,
            addicon: 'ace-icon fa fa-plus-circle purple',
            del: false,
            delicon: 'ace-icon fa fa-trash-o red',
            search: false,
            searchicon: 'ace-icon fa fa-search orange',
            refresh: true,
            afterRefresh: function () {
                // some code here
                jQuery("#detailsPlaceholderNext").hide();
            },
            refreshicon: 'ace-icon fa fa-refresh green',
            view: false,
            viewicon: 'ace-icon fa fa-search-plus grey'
        },
        {
            // options for the Edit Dialog
        },
        {
            // options for the Edit Dialog
            editData: {
                P_WORKFLOW_ID: function () {
                    var data = jQuery("#jqGridDetailPrev").jqGrid('getGridParam', 'postData');
                    var P_WORKFLOW_ID = data.P_WORKFLOW_ID;
                    return P_WORKFLOW_ID;
                }
            },
            //new record form
            width: 700,
            errorTextFormat: function (data) {
                return 'Error: ' + data.responseText
            },
            closeAfterAdd: true,
            recreateForm: true,
            viewPagerButtons: false,
            beforeShowForm: function (e) {
                var form = $(e[0]);
                form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
                style_edit_form(form);
            },
            afterSubmit: function (response) {  
                console.log(response);
                var response = JSON.parse(response.responseText);
                if(response.success == false) {
                    //showBootDialog(true, BootstrapDialog.TYPE_WARNING, 'Attention', response.message);
                    swal("Perhatian", response.message, "warning");
                }
                
                return [true, '', response.responseText];
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
    )

    //----------------------------------------------------------------------------------------------------------//
    //JqGrid Detail Next
    $("#jqGridDetailNext").jqGrid({
        mtype: "POST",
        datatype: "json",
        colModel: [
            {
                label: 'ID',
                name: 'P_W_CHART_PROC_ID_NEXT',                
                width: 35,
                key: true,
                sorttype: 'number',
                sortable: true,
                editable: true,
                hidden: true
            },
            {
                label: 'Daemon',
                name: 'P_W_CHART_PROC_ID_NEXT',
                width: 140, 
                align: "center",
                editable: false,
                formatter: function(cellvalue, options, rowObject) {
                    return '<a href="#" onclick="showDaemon('+cellvalue+');"> <i class="ace-icon fa fa-folder bigger-130"></i> </a>';
                }
            },
            {
                label: 'Nama Dokumen',
                name: 'DOC_NAME',                
                width: 35,
                sortable: true,
                editable: false,
                hidden: true
            },
            {
                label: 'P_WORKFLOW_ID',
                name: 'P_WORKFLOW_ID',                
                width: 35,
                sorttype: 'number',
                sortable: true,
                editable: false,
                hidden: true
            },            
            {
                label: 'Prosedur Sebelum', 
                name: 'PROC_DISPLAY_PREV', 
                width: 300, 
                align: "left",  
                editable: false,
                hidden: true
            },   
            {
                label: 'Pekerjaan Sebelum',
                name: 'P_PROCEDURE_ID_PREV', 
                width: 200, 
                sortable: true, 
                editable: true,
                hidden: true,
                editrules: {edithidden: true, number:true, required:true},
                edittype: 'custom',
                editoptions: {
                    "custom_element":function( value  , options) {                            
                        var elm = $('<span></span>');
                        
                        // give the editor time to initialize
                        setTimeout( function() {
                            elm.append('<input id="form_p_procedure_id_prev" type="text"  style="display:none;">'+
                                    '<input id="form_p_procedure_code" disabled type="text" class="col-xs-9 jqgrid-required" placeholder="Pilih Jenis Dokumen">'+
                                    '<button id="btn-lov" class="btn btn-warning btn-sm" type="button" onclick="showLovProc(\'form_p_procedure_id_prev\',\'form_p_procedure_code\')">'+
                                    '   <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>'+
                                    '</button>');
                            $("#form_p_procedure_id_prev").val(value);
                            elm.parent().removeClass('jqgrid-required');
                        }, 100);
                        
                        return elm;
                    },
                    "custom_value":function( element, oper, gridval) {
                        
                        if(oper === 'get') {
                            return $("#form_p_procedure_id_prev").val();
                        } else if( oper === 'set') {
                            $("#form_p_procedure_id_prev").val(gridval);
                            var gridId = this.id;
                            // give the editor time to set display
                            setTimeout(function(){
                                var selectedRowId = $("#"+gridId).jqGrid ('getGridParam', 'selrow');
                                if(selectedRowId != null) {
                                    var code_display = $("#"+gridId).jqGrid('getCell', selectedRowId, 'PROC_DISPLAY_PREV');
                                    $("#form_p_procedure_code").val( code_display );
                                }
                            },100);
                        }
                    }
                }
            },
            {
                label: 'Prosedur Sesudah', 
                name: 'PROC_DISPLAY_NEXT', 
                width: 350, 
                align: "left",  
                editable: false
            },   
            {
                label: 'Pekerjaan Sesudah',
                name: 'P_PROCEDURE_ID_NEXT', 
                width: 200, 
                sortable: true,                 
                editable: true,
                hidden: true,
                editrules: {edithidden: true, number:true},
                edittype: 'custom',
                editoptions: {
                    "custom_element":function( value  , options) {                            
                        var elm = $('<span></span>');
                        
                        // give the editor time to initialize
                        setTimeout( function() {
                            elm.append('<input id="form_p_procedure_id_next" type="text"  style="display:none;">'+
                                    '<input id="form_pekerjaan_next" disabled type="text" class="col-xs-9 jqgrid" placeholder="Pilih Jenis Dokumen">'+
                                    '<button class="btn btn-warning btn-sm" type="button" onclick="showLovProc(\'form_p_procedure_id_next\',\'form_pekerjaan_next\')">'+
                                    '   <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>'+
                                    '</button>');
                            $("#form_p_procedure_id_next").val(value);
                            elm.parent().removeClass('jqgrid-required');
                        }, 100);
                        
                        return elm;
                    },
                    "custom_value":function( element, oper, gridval) {
                        
                        if(oper === 'get') {
                            return $("#form_p_procedure_id_next").val();
                        } else if( oper === 'set') {
                            $("#form_p_procedure_id_next").val(gridval);
                            var gridId = this.id;
                            // give the editor time to set display
                            setTimeout(function(){
                                var selectedRowId = $("#"+gridId).jqGrid ('getGridParam', 'selrow');
                                if(selectedRowId != null) {
                                    var code_display = $("#"+gridId).jqGrid('getCell', selectedRowId, 'PEKERJAAN_NEXT');
                                    $("#form_pekerjaan_next").val( code_display );
                                }
                            },100);
                        }
                    }
                }
            },
            {
                label: 'Alternate (Dispatcher)', 
                name: 'PEKERJAAN_ALT', 
                width: 250, 
                align: "left",  
                editable: false,
                hidden: true
            },   
            {
                label: 'Alternate (Dispatcher)',
                name: 'P_PROCEDURE_ID_ALT', 
                width: 200, 
                sortable: true, 
                editable: true,
                hidden: true,
                editrules: {edithidden: true, number:true},
                edittype: 'custom',
                editoptions: {
                    "custom_element":function( value  , options) {                            
                        var elm = $('<span></span>');
                        
                        // give the editor time to initialize
                        setTimeout( function() {
                            elm.append('<input id="form_p_procedure_id_alt" type="text"  style="display:none;">'+
                                    '<input id="form_pekerjaan_alt" disabled type="text" class="col-xs-9 jqgrid" placeholder="Pilih Jenis Dokumen">'+
                                    '<button class="btn btn-warning btn-sm" type="button" onclick="showLovProc(\'form_p_procedure_id_alt\',\'form_pekerjaan_alt\')">'+
                                    '   <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>'+
                                    '</button>');
                            $("#form_p_procedure_id_alt").val(value);
                            elm.parent().removeClass('jqgrid-required');
                        }, 100);
                        
                        return elm;
                    },
                    "custom_value":function( element, oper, gridval) {
                        
                        if(oper === 'get') {
                            return $("#form_p_procedure_id_alt").val();
                        } else if( oper === 'set') {
                            $("#form_p_procedure_id_alt").val(gridval);
                            var gridId = this.id;
                            // give the editor time to set display
                            setTimeout(function(){
                                var selectedRowId = $("#"+gridId).jqGrid ('getGridParam', 'selrow');
                                if(selectedRowId != null) {
                                    var code_display = $("#"+gridId).jqGrid('getCell', selectedRowId, 'PEKERJAAN_ALT');
                                    $("#form_pekerjaan_alt").val( code_display );
                                }
                            },100);
                        }
                    }
                }
            }, 
            {
                label: 'Level Pembatalan Workflow',
                name: 'IMPORTANCE_LEVEL',
                width: 100,
                sortable: true,
                editable: true,
                edittype: 'select',
                formatter: 'select',
                editrules: {edithidden: true, required:true},
                editoptions: {value: {'O': 'OPSIONAL', 'M': 'WAJIB'}},
                hidden: true
            },
            {
                label: 'Fungsi Init',
                name: 'F_INIT',
                width: 300,
                align: "left",
                sortable: true,
                editable: true,
                editoptions: {
                    size: 55,
                    maxlength:64
                },
                editrules: {edithidden: true},
                hidden: true
            },
            {
                label: 'No.',
                name: 'SEQUENCE_NO',
                width: 70,
                align: "center",
                sortable: true,
                editable: true,
                sorttype: 'number',
                editoptions: {
                    size: 10,
                    maxlength:5
                },
                editrules: {edithidden: true, required: false},
                hidden: true
            },
            {
                label: 'Init Sub?', 
                name: 'LINITCHILD', 
                width: 250, 
                align: "left",  
                editable: false
            }, 
            {
                label: 'Valid?', 
                name: 'LVALID', 
                width: 250, 
                align: "left",  
                editable: false
            }, 
            {
                label: 'Mulai Berlaku',
                name: 'VALID_FROM',
                width: 250,
                editable: true,
                editrules: {edithidden: true, required: true},
                edittype:"text",
                editoptions: {
                    // dataInit is the client-side event that fires upon initializing the toolbar search field for a column
                    // use it to place a third party control to customize the toolbar
                    dataInit: function (element) {
                       $(element).datepicker({
                            autoclose: true,
                            format: 'dd-mm-yyyy',
                            orientation : 'bottom'
                        });
                    }
                }
            },
            {
                label: 'Akhir Berlaku',
                name: 'VALID_TO',
                width: 250,
                editable: true,
                editrules: {edithidden: true},
                edittype:"text",
                editoptions: {
                    // dataInit is the client-side event that fires upon initializing the toolbar search field for a column
                    // use it to place a third party control to customize the toolbar
                    dataInit: function (element) {
                       $(element).datepicker({
                            autoclose: true,
                            format: 'dd-mm-yyyy',
                            orientation : 'bottom'
                        });
                    }
                }
            },
            {
                label: 'Tanggal Dibuat',
                name: 'CREATION_DATE',
                width: 250,
                align: "left",
                sortable: true,
                editable: false,
                hidden: true
            },
            {
                label: 'Dibuat Oleh',
                name: 'CREATED_BY',
                width: 250,
                align: "left",
                sortable: true,
                editable: false,
                hidden: true
            },
            {
                label: 'Tanggal Diubah',
                name: 'UPDATED_DATE',
                width: 250,
                align: "left",
                sortable: true,
                editable: false,
                hidden: true
            },
            {
                label: 'Diubah Oleh',
                name: 'UPDATED_BY',
                width: 250,
                align: "left",
                sortable: true,
                editable: false,
                hidden: true
            },
        ],
        // width: '70%',
        height: '100%',
        width: 750,
        page: 1,
        rowNum: 5,
        shrinkToFit: true,
        rownumbers: true,
        rownumWidth: 35, // the width of the row numbers columns
        viewrecords: true,
        caption: 'Daftar Aliran Prosedur',
        pager: "#jqGridDetailsPagerNext",
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
        editurl: '<?php echo site_url('workflow_parameter/crud_chart_proc_prev');?>'
    });

    //navButtons Grid Detail -- Next
    jQuery('#jqGridDetailNext').jqGrid('navGrid', '#jqGridDetailsPagerNext',
        {   //navbar options
            edit: true,
            excel: true,
            editicon: 'ace-icon fa fa-pencil blue',
            add: true,
            addicon: 'ace-icon fa fa-plus-circle purple',
            del: true,
            delicon: 'ace-icon fa fa-trash-o red',
            search: false,
            searchicon: 'ace-icon fa fa-search orange',
            refresh: true,
            refreshicon: 'ace-icon fa fa-refresh green',
            view: false,
            viewicon: 'ace-icon fa fa-search-plus grey'
        },
        {
            // options for the Edit Dialog
            editData: {
                P_WORKFLOW_ID: function () {
                    var data = jQuery("#jqGridDetailNext").jqGrid('getGridParam', 'postData');
                    var P_WORKFLOW_ID = data.P_WORKFLOW_ID;
                    return P_WORKFLOW_ID;
                }
            },
            closeAfterEdit: true,
            width: 700,
            errorTextFormat: function (data) {
                return 'Error: ' + data.responseText
            },
            recreateForm: true,
            beforeShowForm: function (e) {
                var form = $(e[0]);
                form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
                style_edit_form(form);

                setTimeout( function() {                    
                    var selectedRowId = $("#jqGridDetailPrev").jqGrid ('getGridParam', 'selrow');
                    var proc_id = $("#jqGridDetailPrev").jqGrid('getCell', selectedRowId, 'P_PROCEDURE_ID_PREV');
                    var dis_prev = $("#jqGridDetailPrev").jqGrid('getCell', selectedRowId, 'PROC_DISPLAY_PREV');

                    var selectedRowIdNext = $("#jqGridDetailNext").jqGrid ('getGridParam', 'selrow');
                    var procNextId = $("#jqGridDetailNext").jqGrid('getCell', selectedRowIdNext, 'P_PROCEDURE_ID_NEXT');
                    var procNext = $("#jqGridDetailNext").jqGrid('getCell', selectedRowIdNext, 'PROC_DISPLAY_NEXT');
                    
                    $("#jqGridDetailNext").jqGrid('getCell', selectedRowIdNext, 'P_PROCEDURE_ID_NEXT');

                    $("#form_p_procedure_id_prev").val(proc_id);
                    $("#form_p_procedure_code").val(dis_prev);

                    if(!procNextId){
                        $("#form_p_procedure_id_next").val("");
                        $("#form_pekerjaan_next").val("");
                    }else{
                        $("#form_p_procedure_id_next").val(procNextId);
                        $("#form_pekerjaan_next").val(procNext);
                    }

                    $("#form_p_procedure_id_alt").val("");
                    $("#form_pekerjaan_alt").val("");
                    $('#btn-lov').hide();
                }, 150);

            },
            afterSubmit: function (response) {
                
                var response = JSON.parse(response.responseText);
                if(response.success == false) {
                    //showBootDialog(true, BootstrapDialog.TYPE_WARNING, 'Attention', response.message);
                    swal("Perhatian", response.message, "warning");
                }
                
                return [true, '', response.responseText];
            }
        },
        {
            // options for the Edit Dialog
            editData: {
                P_WORKFLOW_ID: function () {
                    var data = jQuery("#jqGridDetailNext").jqGrid('getGridParam', 'postData');
                    var P_WORKFLOW_ID = data.P_WORKFLOW_ID;
                    return P_WORKFLOW_ID;
                }
            },
            //new record form
            width: 700,
            errorTextFormat: function (data) {
                return 'Error: ' + data.responseText
            },
            closeAfterAdd: true,
            recreateForm: true,
            viewPagerButtons: false,
            beforeShowForm: function (e) {               
                var form = $(e[0]);
                    form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
                    style_edit_form(form);

                setTimeout( function() {                    
                    var selectedRowId = $("#jqGridDetailPrev").jqGrid ('getGridParam', 'selrow');
                    var proc_id = $("#jqGridDetailPrev").jqGrid('getCell', selectedRowId, 'P_PROCEDURE_ID_PREV');
                    var dis_prev = $("#jqGridDetailPrev").jqGrid('getCell', selectedRowId, 'PROC_DISPLAY_PREV');

                    $("#form_p_procedure_id_prev").val(proc_id);
                    $("#form_p_procedure_code").val(dis_prev);

                    $("#form_p_procedure_id_next").val("");
                    $("#form_pekerjaan_next").val("");

                    $("#form_p_procedure_id_alt").val("");
                    $("#form_pekerjaan_alt").val("");
                }, 150);
            },
            afterSubmit: function (response) {  
                var response = JSON.parse(response.responseText);
                if(response.success == false) {
                    //showBootDialog(true, BootstrapDialog.TYPE_WARNING, 'Attention', response.message);
                    swal("Perhatian", response.message, "warning");
                }
                
                return [true, '', response.responseText];
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
    )
</script>