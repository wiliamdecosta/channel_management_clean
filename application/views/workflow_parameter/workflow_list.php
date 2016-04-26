<?php $prv = getPrivilege($menu_id); ?>
<div class="breadcrumbs" id="breadcrumbs">
    <?= $this->breadcrumb; ?>
</div>

<!-- /section:basics/content.breadcrumbs -->
<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="row">
                <div class="col-xs-12">
                    <table id="grid-table"></table>
                    <div id="grid-pager"></div>
                </div>
            </div>
            <!-- PAGE CONTENT ENDS -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.page-content -->

<?php 
    $this->load->view('parameter/lov_document_type.php');
    $this->load->view('parameter/lov_procedure.php');
?>

<script>
    function showLovDocType(id, code) {
        modal_lov_document_type_show(id,code);
    }

    function showLovProc(id, code) {
        modal_lov_procedure_show(id,code);
    }

    jQuery(function($) {
        
        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";
        
        $(window).on('resize.jqGrid', function () {
            responsive_jqgrid(grid_selector, pager_selector);
        });
        
        $(document).on('settings.ace.jqGrid' , function(ev, event_name, collapsed) {
            if( event_name === 'sidebar_collapsed' || event_name === 'main_container_fixed' ) {
               responsive_jqgrid(grid_selector, pager_selector);
            }
        });       
        
        
        jQuery("#grid-table").jqGrid({
            url: '<?php echo site_url('workflow_parameter/grid_workflow');?>',
            datatype: "json",
            mtype: "POST",
            colModel: [
                {label: 'ID', name: 'P_WORKFLOW_ID', key: true, width: 35, sorttype: 'number', sortable: true, editable: true, hidden:true},
                {
                    label: 'Nama Workflow',
                    name: 'DOC_NAME', 
                    width: 200, 
                    sortable: true, 
                    editable: true,
                    editoptions: {
                        size: 50,
                        maxlength:64
                    },
                    editrules: {required: true}
                },                
                {
                    label: 'Nama Workflow Tercetak', 
                    name: 'DISPLAY_NAME', 
                    width: 200, 
                    sortable: true, 
                    editable: true,
                    editoptions: {
                        size: 50,
                        maxlength:96
                    },
                    editrules: {edithidden: true, required:true}
                }, 
                {
                    label: 'Jenis Dokumen', 
                    name: 'DOCUMENT_TYPE_CODE', 
                    width: 120, 
                    align: "left",  
                    editable: false
                }, 
                {
                    label: 'Jenis Dokumen',
                    name: 'P_DOCUMENT_TYPE_ID', 
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
                                elm.append('<input id="form_p_document_type_id" type="text"  style="display:none;">'+
                                        '<input id="form_p_document_type_code" disabled type="text" class="col-xs-7 jqgrid-required" placeholder="Pilih Jenis Dokumen">'+
                                        '<button class="btn btn-warning btn-sm" type="button" onclick="showLovDocType(\'form_p_document_type_id\',\'form_p_document_type_code\')">'+
                                        '   <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>'+
                                        '</button>');
                                $("#form_p_document_type_id").val(value);
                                elm.parent().removeClass('jqgrid-required');
                            }, 100);
                            
                            return elm;
                        },
                        "custom_value":function( element, oper, gridval) {
                            
                            if(oper === 'get') {
                                return $("#form_p_document_type_id").val();
                            } else if( oper === 'set') {
                                $("#form_p_document_type_id").val(gridval);
                                var gridId = this.id;
                                // give the editor time to set display
                                setTimeout(function(){
                                    var selectedRowId = $("#"+gridId).jqGrid ('getGridParam', 'selrow');
                                    if(selectedRowId != null) {
                                        var code_display = $("#"+gridId).jqGrid('getCell', selectedRowId, 'DOCUMENT_TYPE_CODE');
                                        $("#form_p_document_type_code").val( code_display );
                                    }
                                },100);
                            }
                        }
                    }
                },
                {
                    label: 'Pekerjaan Awal', 
                    name: 'PROCEDURE_CODE', 
                    width: 120, 
                    align: "left",  
                    editable: false
                },   
                {
                    label: 'Pekerjaan Awal',
                    name: 'P_PROCEDURE_ID_START', 
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
                                elm.append('<input id="form_p_procedure_id" type="text"  style="display:none;">'+
                                        '<input id="form_p_procedure_code" disabled type="text" class="col-xs-7 jqgrid-required" placeholder="Pilih Jenis Dokumen">'+
                                        '<button class="btn btn-warning btn-sm" type="button" onclick="showLovProc(\'form_p_procedure_id\',\'form_p_procedure_code\')">'+
                                        '   <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>'+
                                        '</button>');
                                $("#form_p_procedure_id").val(value);
                                elm.parent().removeClass('jqgrid-required');
                            }, 100);
                            
                            return elm;
                        },
                        "custom_value":function( element, oper, gridval) {
                            
                            if(oper === 'get') {
                                return $("#form_p_procedure_id").val();
                            } else if( oper === 'set') {
                                $("#form_p_procedure_id").val(gridval);
                                var gridId = this.id;
                                // give the editor time to set display
                                setTimeout(function(){
                                    var selectedRowId = $("#"+gridId).jqGrid ('getGridParam', 'selrow');
                                    if(selectedRowId != null) {
                                        var code_display = $("#"+gridId).jqGrid('getCell', selectedRowId, 'PROCEDURE_CODE');
                                        $("#form_p_procedure_code").val( code_display );
                                    }
                                },100);
                            }
                        }
                    }
                }, 
                {
                    label: 'Aktif ?',
                    name: 'IS_ACTIVE',
                    width: 100,
                    sortable: true,
                    // align: 'center',
                    editable: true,
                    edittype: 'select',
                    formatter: 'select',
                    editrules: {edithidden: true, required:true},
                    editoptions: {value: {'Y': 'YES', 'N': 'NO'}}
                },
                {
                    label: 'Deskripsi',
                    name: 'DESCRIPTION', 
                    width: 200, 
                    sortable: true, 
                    hidden:true, 
                    editable: true,
                    editoptions: {
                                    size: 50,
                                    maxlength:128
                    },
                    editrules: {edithidden: true, required:false}
                },
                {label: 'Tgl Pembuatan', name: 'CREATION_DATE', width: 120, align: "left", hidden:true, editable: false},
                {label: 'Dibuat Oleh', name: 'CREATED_BY', width: 120, align: "left", hidden:true, editable: false},
                {label: 'Tgl Update', name: 'UPDATED_DATE', width: 120, align: "left", hidden:true, editable: false},
                {label: 'Diupdate Oleh', name: 'UPDATED_BY', width: 120, align: "left", hidden:true, editable: false}
            ],
            height: '100%',
            autowidth: true,
            rowNum: 10,
            viewrecords: true,
            rowList: [5, 10, 20],
            rownumbers: true, // show row numbers
            rownumWidth: 35, // the width of the row numbers columns
            altRows: true,
            shrinkToFit: true,
            multiboxonly: true,
            onSelectRow: function (rowid) {
                var celValue = $('#grid-table').jqGrid('getCell', rowid, 'P_WORKFLOW_ID');
                
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
                }, 0);

            },

            //memanggil controller jqgrid yang ada di controller crud
            editurl: '<?php echo site_url('workflow_parameter/crud_workflow_list');?>',
            caption: "Daftar Workflow"
        });

        jQuery('#grid-table').jqGrid('navGrid', '#grid-pager',
            {   //navbar options
                edit: <?php
                if ($prv['UBAH'] == "Y") {
                    echo 'true';
                } else {
                    echo 'false';

                }
                ?>,
                editicon: 'ace-icon fa fa-pencil blue',
                add:  <?php
                if ($prv['TAMBAH'] == "Y") {
                    echo 'true';
                } else {
                    echo 'false';

                }
                ?>,
                addicon: 'ace-icon fa fa-plus-circle purple',
                del: <?php
                if ($prv['HAPUS'] == "Y") {
                    echo 'true';
                } else {
                    echo 'false';

                }
                ?>,
                delicon: 'ace-icon fa fa-trash-o red',
                search: true,
                searchicon: 'ace-icon fa fa-search orange',
                refresh: true,
                afterRefresh: function () {
                    // some code here
                    
                },

                refreshicon: 'ace-icon fa fa-refresh green',
                view: false,
                viewicon: 'ace-icon fa fa-search-plus grey'
            },

            {
                // options for the Edit Dialog
                closeAfterEdit: true,
                closeOnEscape:true,
                recreateForm: true,
                width: 'auto',
                errorTextFormat: function (data) {
                    return 'Error: ' + data.responseText
                },
                beforeShowForm: function (e, form) {
                    var form = $(e[0]);
                    form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
                    style_edit_form(form);
                    form.css({"height": 0.335*screen.height+"px"});
                    form.css({"width": 0.45*screen.width+"px"});
                    /*$("#USER_NAME").prop("readonly", true);*/
                },
                afterShowForm: function(form) {
                    form.closest('.ui-jqdialog').center();
                    $(".mce-widget").hide();
                },
                afterSubmit:function(response,postdata) {
                    var response = jQuery.parseJSON(response.responseText);
                    if(response.success == false) {
                        return [false,response.message,response.responseText];
                    }
                    return [true,"",response.responseText];
                }
            },
            {
                //new record form
                closeAfterAdd: false,
                clearAfterAdd : true,
                closeOnEscape:true,
                recreateForm: true,
                width: 'auto',
                errorTextFormat: function (data) {
                    return 'Error: ' + data.responseText
                },
                viewPagerButtons: false,
                beforeShowForm: function (e, form) {
                    var form = $(e[0]);
                    form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar')
                        .wrapInner('<div class="widget-header" />')
                    style_edit_form(form);
                    form.css({"height": 0.335*screen.height+"px"});
                    form.css({"width": 0.45*screen.width+"px"});
                    
                },
                afterShowForm: function(form) {
                    form.closest('.ui-jqdialog').center();
                    $(".mce-widget").hide();
                },
                afterSubmit:function(response,postdata) {
                    var response = jQuery.parseJSON(response.responseText);
                    if(response.success == false) {
                        return [false,response.message,response.responseText];
                    }
                    
                    $(".topinfo").html('<div class="ui-state-success">' + response.message + '</div>'); 
                    var tinfoel = $(".tinfo").show();
                    tinfoel.delay(3000).fadeOut();
                    
                    $("#form_p_document_type_id").val("");
                    $("#form_p_document_type_code").val("");

                    $("#form_p_procedure_id").val("");
                    $("#form_p_procedure_code").val("");

                    return [true,"",response.responseText];
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
                afterShowForm: function(form) {
                    form.closest('.ui-jqdialog').center();
                },
                onClick: function (e) {
                    //alert(1);
                },
                afterSubmit:function(response,postdata) {
                    var response = jQuery.parseJSON(response.responseText);
                    if(response.success == false) {
                        return [false,response.message,response.responseText];
                    }
                    return [true,"",response.responseText];
                }
            },
            {
                //search form
                closeAfterSearch: false,
                recreateForm: true,
                afterShowSearch: function (e) {
                    var form = $(e[0]);
                    form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
                    style_search_form(form);
                    
                    form.closest('.ui-jqdialog').center();
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
        
    }); /* end jquery onload */

    function clearSelection() {

        return null;
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

    function responsive_jqgrid(grid_selector, pager_selector) {
        var parent_column = $(grid_selector).closest('[class*="col-"]');
        $(grid_selector).jqGrid( 'setGridWidth', $(".page-content").width() );
        $(pager_selector).jqGrid( 'setGridWidth', parent_column.width() );
    }
    
</script>