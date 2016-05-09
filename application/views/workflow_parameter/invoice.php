<?php 
$menu_id = !isset($menu_id) ? $this->input->post('menu_id') : $menu_id ;
$prv = getPrivilege($menu_id); ?>
<script type="text/css">
    .ui-jqgrid .ui-jqgrid-btable
    {
        table-layout:auto;
    }
</script>
<div class="breadcrumbs" id="breadcrumbs">
    <?php echo getBreadcrumb(array('Workflow Parameter','Invoice')); ?>
</div>

<!-- /section:basics/content.breadcrumbs -->
<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
            <div class="tabbable">
                <ul class="nav nav-tabs padding-18 tab-size-bigger tab-color-blue">
                    <li class="active">
                        <a href="#" data-toggle="tab" aria-expanded="true" id="tab-1">
                            <i class="blue bigger-120"></i>
                            <strong>Invoice</strong>
                        </a>
                    </li>
                </ul>
                <!-- <input type="hidden" id="t_invoice_id" value="">
                <input type="hidden" id="tab_chart_proc_code" value=""> -->
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

                <!-- PAGE CONTENT BEGINS -->
                <div class="row">
                    <div class="col-xs-12">
                        <table id="grid-table"></table>
                        <div id="grid-pager"></div>
                    </div>
                </div>
                <!-- PAGE CONTENT ENDS -->
            </div>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.page-content -->

<?php 
    $this->load->view('parameter/lov_contract_info.php');
?>

<script>
    function showLovContractInfo(P_MP_PKS_ID, CUST_PGL_ID, CONTRACT_NO, MITRA_NAME, MITRA_ADDRESS) {
        var idd = $('#CONTRACT_TYPE_ID').val();
        modal_lov_contract_info_show(P_MP_PKS_ID, CUST_PGL_ID, CONTRACT_NO, MITRA_NAME, MITRA_ADDRESS, idd);
    }

    function submitWF(T_CUSTOMER_ORDER_ID, ORDER_NO) {        
        result = confirm('Submit No. Order : ' + ORDER_NO);
        if (result) { 

            $.ajax({
                type: 'POST',
                datatype: "json",
                url: '<?php echo site_url('workflow_parameter/submitWF');?>',
                data: { T_CUSTOMER_ORDER_ID : T_CUSTOMER_ORDER_ID },
                timeout: 10000,
                success: function(data) {
                    var response = JSON.parse(data);
                    if(response.success) {
                        jQuery('#grid-table').trigger("reloadGrid");
                        swal("", "Submit Berhasil", "success");          
                    }else {
                        swal("", data.message, "warning");
                    }
                }
            });
        }
        return false;
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
            url: '<?php echo site_url('workflow_parameter/grid_invoice');?>',
            datatype: "json",
            mtype: "POST",
            colModel: [
                {label: 'ID', name: 'T_CUSTOMER_ORDER_ID', key: true, width: 35, sorttype: 'number', sortable: true, editable: true, hidden:true},
                {
                    label: 'Submit',
                    name: 'T_CUSTOMER_ORDER_ID',
                    width: 70, 
                    align: "center",
                    editable: false,
                    formatter: function(cellvalue, options, rowObject) {
                        var order = String(rowObject.ORDER_NO);
                        return '<button type="button" class="btn btn-white btn-sm btn-primary" onclick="submitWF('+cellvalue+',\''+order+'\');">Submit</button>';
                    }
                },
                {
                    label: 'No. Order',
                    name: 'ORDER_NO', 
                    width: 200, 
                    sortable: true, 
                    editable: true,
                    editoptions: {
                        size: 20,
                        maxlength:64,
                        readonly: "readonly"
                    },
                    editrules: {required: false}
                },
                {   
                    label: 'Jenis Permohonan',
                    name: 'P_RQST_TYPE_ID', 
                    width: 200, 
                    hidden:true,
                    sortable: true, 
                    editable: true,
                    editrules: {edithidden: true, required: true},
                    edittype: 'select',
                    editoptions: {
                        style: "width: 270px", 
                        dataUrl: '<?php echo site_url("workflow_parameter/html_select_options_rqst_type"); ?>'
                    }
                },
                {   
                    label: 'Jenis Permohonan',
                    name: 'RQST_TYPE_CODE', 
                    width: 130, 
                    sortable: true, 
                    editable: false
                },
                {   
                    label: 'Status Permohonan',
                    name: 'P_ORDER_STATUS_ID', 
                    width: 200, 
                    sortable: true, 
                    editable: true,
                    hidden:true,
                    editrules: {edithidden: true, required: true},
                    edittype: 'select',
                    editoptions: {
                        style: "width: 200px", 
                        dataUrl: '<?php echo site_url("workflow_parameter/html_select_options_order_status"); ?>'
                    }
                },
                {   
                    label: 'Jenis Permohonan',
                    name: 'ORDER_STATUS_CODE', 
                    width: 200, 
                    sortable: true, 
                    editable: false,
                    hidden: true
                },
                {
                    label: 'Tgl. Permohonan', 
                    name: 'ORDER_DATE', 
                    width: 130, 
                    editable: true,
                    edittype:"text",
                    editrules: {required: true},
                    editoptions: {
                        dataInit: function (element) {
                           $(element).datepicker({
                                autoclose: true,
                                format: 'yyyy-mm-dd',
                                orientation : 'top',
                                todayHighlight : true
                            });
                        }
                    }
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
                {
                    label: 'No. Invoice',
                    name: 'INVOICE_NO', 
                    width: 200, 
                    sortable: true, 
                    editable: true,
                    editoptions: {
                        size: 20,
                        maxlength:64
                    },
                    editrules: {required: true}
                },
                {   
                    label: 'Jenis Kontrak',
                    name: 'CONTRACT_TYPE_ID', 
                    width: 200, 
                    sortable: true, 
                    editable: true,
                    hidden:true,
                    editrules: {edithidden: true, required: true},
                    edittype: 'select',
                    editoptions: {
                        style: "width: 200px", 
                        dataUrl: '<?php echo site_url("workflow_parameter/html_select_options_reference"); ?>'
                    }
                },
                {
                    label: 'No. Kontrak',
                    name: 'CONTRACT_NO', 
                    width: 200, 
                    sortable: true, 
                    editable: true,
                    hidden: true,
                    editrules: {edithidden: true, required:true},
                    edittype: 'custom',
                    editoptions: {
                        "custom_element":function( value  , options) {                            
                            var elm = $('<span></span>');
                                                        
                            // give the editor time to initialize
                            setTimeout( function() {
                                elm.append('<input id="form_contract_no" type="text" class="col-xs-4 jqgrid-required">'+
                                        '<button class="btn btn-warning btn-sm" type="button" onclick="showLovContractInfo(\'P_MP_PKS_ID\',\'CUST_PGL_ID\',\'form_contract_no\',\'MITRA_NAME\',\'MITRA_ADDRESS\')">'+
                                        '   <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>'+
                                        '</button>');

                                
                                elm.parent().removeClass('jqgrid-required');
                            }, 100);
                            
                            return elm;
                        },
                        "custom_value":function( element, oper, gridval) {
                            
                            if(oper === 'get') {
                                return $("#form_contract_no").val();
                            } else if( oper === 'set') {
                                $("#form_contract_no").val(gridval);
                                var gridId = this.id;
                                // give the editor time to set display
                                setTimeout(function(){
                                    var selectedRowId = $("#"+gridId).jqGrid ('getGridParam', 'selrow');
                                    if(selectedRowId != null) {                                        
                                        var code_display = $("#"+gridId).jqGrid('getCell', selectedRowId, 'CONTRACT_NO');
                                        $("#form_contract_no").val( code_display );
                                    }

                                },100);
                            }
                        }
                    }
                },
                {
                    label: 'T_INVOICE_ID',
                    name: 'T_INVOICE_ID', 
                    width: 200, 
                    sortable: true, 
                    editable: true,
                    hidden:true,
                    editoptions: {
                        size: 10,
                        maxlength:64
                    },
                    editrules: {required: false}
                },
                {
                    label: 'P_MP_PKS_ID',
                    name: 'P_MP_PKS_ID', 
                    width: 200, 
                    sortable: true, 
                    editable: true,
                    hidden:true,
                    editoptions: {
                        size: 10,
                        maxlength:64
                    },
                    editrules: {required: false}
                },
                {
                    label: 'CUST_PGL_ID',
                    name: 'CUST_PGL_ID', 
                    width: 200, 
                    sortable: true, 
                    editable: true,
                    hidden:true,
                    editoptions: {
                        size: 10,
                        maxlength:64
                    },
                    editrules: {required: false}
                },
                {
                    label: 'Nama Mitra',
                    name: 'MITRA_NAME', 
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
                    label: 'Alamat Mitra',
                    name: 'MITRA_ADDRESS', 
                    width: 200, 
                    sortable: true, 
                    editable: true,
                    hidden: true,
                    editoptions: {
                        size: 60,
                        maxlength:64
                    },
                    editrules: {edithidden: true, required: true}
                },
                {
                    label: 'Mitra PIC',
                    name: 'MITRA_PIC', 
                    width: 200, 
                    sortable: true, 
                    editable: true,
                    hidden: true,
                    editoptions: {
                        size: 40,
                        maxlength:64
                    },
                    editrules: {edithidden: true, required: false}
                },
                {
                    label: 'Telephone PIC',
                    name: 'PIC_PHONE', 
                    width: 200, 
                    sortable: true, 
                    editable: true,
                    hidden: true,
                    editoptions: {
                        size: 30,
                        maxlength:64
                    },
                    editrules: {edithidden: true, required: false}
                },
                {
                    label: 'NPWP Mitra',
                    name: 'MITRA_NPWP', 
                    width: 200, 
                    sortable: true, 
                    editable: true,
                    hidden: true,
                    editoptions: {
                        size: 45,
                        maxlength:64
                    },
                    editrules: {edithidden: true, required: false}
                },
                {
                    label: 'Jumlah Tagihan',
                    name: 'INVOICE_AMOUNT', 
                    width: 200, 
                    sortable: true, 
                    editable: true,
                    hidden: true,
                    editoptions: {
                        size: 30,
                        maxlength:32
                    },
                    editrules: {edithidden: true, required: true}
                },
                {
                    label: 'Pajak',
                    name: 'VAT_AMOUNT', 
                    width: 200, 
                    sortable: true, 
                    editable: true,
                    hidden: true,
                    editoptions: {
                        size: 30,
                        maxlength:32
                    },
                    editrules: {edithidden: true, required: false}
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
                // var celValue = $('#grid-table').jqGrid('getCell', rowid, 'P_WORKFLOW_ID');
                
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
            editurl: '<?php echo site_url('workflow_parameter/crud_invoice');?>',
            caption: "Invoice"
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
                    form.css({"height": 0.60*screen.height+"px"});
                    form.css({"width": 0.50*screen.width+"px"});
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
                    form.css({"height": 0.60*screen.height+"px"});
                    form.css({"width": 0.50*screen.width+"px"});
                    setTimeout( function() {    
                        $('#P_MP_PKS_ID').val('');
                        $('#CUST_PGL_ID').val('');
                        $('#MITRA_NAME').val('');
                        $('#MITRA_ADDRESS').val('');
                        $('#form_contract_no').val('');
                    }, 150);
                    
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