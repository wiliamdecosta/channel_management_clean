<?php 
$menu_id = !isset($menu_id) ? $this->input->post('menu_id') : $menu_id ;
$prv = getPrivilege($menu_id); ?>
<div class="breadcrumbs" id="breadcrumbs">
    <?php echo getBreadcrumb(array('Workflow Parameter','Daftar Pekerjaan Workflow')); ?>
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
    					    		<strong>Pekerjaan Workflow</strong>
    					    	</a>
    					    </li>
    					    <li class="">
    					    	<a href="#" data-toggle="tab" aria-expanded="true" id="tab-2">
    					    		<i class="blue bigger-120"></i>
    					    		<strong>Role Prosedur</strong>
    					    	</a>
    					    </li>
    		            </ul>
    		            <input type="hidden" id="tab_procedure_id" value="">
    		            <input type="hidden" id="tab_procedure_code" value="">
    		        </div>
    		        
    		        <div class="tab-content no-border">
    		            <div class="row">
                            <div class="col-xs-12">       
                               <table id="grid-table"></table>
                               <div id="grid-pager"></div>    
                            </div>
                        </div>    
    		        </div>
    		    </div>    
    	    </div>
    	    <!-- PAGE CONTENT ENDS -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.page-content -->

<?php $this->load->view('parameter/lov_p_procedure.php'); ?>

<script>
    
    jQuery(function($) {
        $( "#tab-2" ).on( "click", function() {
            var the_id = $("#tab_procedure_id").val();
            var the_code = $("#tab_procedure_code").val();
            if(the_id == "") {
                swal("Informasi", "Silahkan Pilih Salah Satu Baris Data", "info");
                return false;
            }
            
            loadContentWithParams("workflow_parameter-procedure_role.php", {
                procedure_id: the_id,
                procedure_code : the_code,
                menu_id : <?php echo $menu_id; ?>
            });
        });
    });
    
    function showFilePekerjaan(procedure_id) {
        var procedure_code = $("#grid-table").jqGrid ('getCell', procedure_id, 'PROC_NAME');
        loadContentWithParams("workflow_parameter-procedure_files.php", {
            procedure_id: procedure_id,
            procedure_code : procedure_code,
            menu_id : <?php echo $menu_id; ?>
        });
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
            url: '<?php echo site_url('workflow_parameter/grid_procedure');?>',
            datatype: "json",
            mtype: "POST",
            colModel: [
                {label: 'ID',name: 'P_PROCEDURE_ID', key: true, width: 35, sorttype: 'number', sortable: true, editable: true, hidden:true},
                {label: 'File Pekerjaan',name: 'P_PROCEDURE_ID',width: 120, align: "center",editable: false,
                    formatter: function(cellvalue, options, rowObject) {
                        return '<a href="#" onclick="showFilePekerjaan('+cellvalue+');"> <i class="ace-icon fa fa-folder bigger-130"></i> </a>';
                    }
                },
                {label: 'Pekerjaan',name: 'PROC_NAME', width: 200, sortable: true, editable: true,
                    editoptions: {
                        size: 50,
                        maxlength:96
                    },
                    editrules: {required: true}
                },
                
                {label: 'Nama Pekerjaan',name: 'DISPLAY_NAME', width: 200, sortable: true, editable: true,
                    editoptions: {
                        size: 50,
                        maxlength:128
                    },
                    editrules: {required:true}
                },

                {label: 'Induk Pekerjaan',name: 'PROC_NAME_PARENT', width: 200, sortable: true, editable: false},
                {label: 'Induk Pekerjaan',name: 'PARENT_ID', width: 100, sortable: true,  hidden:true, editable: true,
                    editrules: {edithidden: true, number:true, required:false},
                    edittype: 'custom',
                    editoptions: {
                        "custom_element":function( value  , options) {                            
                            var elm = $('<span></span>');
                            
                            // give the editor time to initialize
                            setTimeout( function() {
                                elm.append('<input id="form_parent_id" type="text"  style="display:none;">'+
                                        '<input id="form_parent_name" type="text" disabled class="col-xs-5 jqgrid-required" placeholder="Pilih Induk Pekerjaan">'+
                                        '<button class="btn btn-warning btn-sm" type="button" onclick="showLovPekerjaan(\'form_parent_id\',\'form_parent_name\')">'+
                                        '   <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>'+
                                        '</button>');
                                $("#form_parent_id").val(value);
                                elm.parent().removeClass('jqgrid-required');
                            }, 100);
                            
                            return elm;
                        },
                        "custom_value":function( element, oper, gridval) {
                            
                            if(oper === 'get') {
                                return $("#form_parent_id").val();
                            } else if( oper === 'set') {
                                $("#form_parent_id").val(gridval);
                                var gridId = this.id;
                                // give the editor time to set display
                                setTimeout(function(){
                                    var selectedRowId = $("#"+gridId).jqGrid ('getGridParam', 'selrow');
                                    if(selectedRowId != null) {
                                        var code_display = $("#"+gridId).jqGrid('getCell', selectedRowId, 'PROC_NAME_PARENT');
                                        $("#form_parent_name").val( code_display );
                                    }
                                },100);
                            }
                        }
                    }
                },
                {label: 'Aktif ?',name: 'IS_ACTIVE', width: 100, sortable: true, editable: true,
                    align: 'center',
                    edittype: 'select',
                    formatter: 'select',
                    editoptions: {value: {'Y': 'YA', 'N': 'TIDAK'}},
                    editrules: {required:true}
                },
                {label: 'Standar Lama Pekerjaan',name: 'SEQNO', width: 200, sortable: true, hidden:true, editable: true,
                    editoptions: {
                        size: 20,
                        maxlength:2
                    },
                    editrules: {edithidden: true, number:true, required:true}
                },
                {label: 'Fungsi Sebelum Submit',name: 'F_BEFORE', width: 200, sortable: true, hidden:true, editable: true,
                    editoptions: {
                        size: 50,
                        maxlength:64
                    },
                    editrules: {edithidden: true}
                },
                {label: 'Fungsi Setelah Submit',name: 'F_AFTER', width: 200, sortable: true, hidden:true, editable: true,
                    editoptions: {
                        size: 50,
                        maxlength:64
                    },
                    editrules: {edithidden: true}
                },
                {label: 'Kirim Notifikasi SMS ?',name: 'IS_SEND_SMS', width: 100, hidden:true, sortable: true, editable: true,
                    align: 'center',
                    edittype: 'select',
                    formatter: 'select',
                    editoptions: {value: {'N': 'TIDAK', 'Y': 'YA'}},
                    editrules: {edithidden: true}
                },
                {label: 'Isi Notifikasi SMS',name: 'SMS_CONTENT', width: 200, hidden:true, sortable: true, hidden:true, editable: true,
                    edittype:"textarea",
                    editoptions: {rows:"5",cols:"45"},
                    editrules: {edithidden: true}
                },
                {label: 'Kirim Notifikasi Email ?',name: 'IS_SEND_EMAIL', width: 100, hidden:true, sortable: true, editable: true,
                    align: 'center',
                    edittype: 'select',
                    formatter: 'select',
                    editoptions: {value: {'N': 'TIDAK', 'Y': 'YA'}},
                    editrules: {edithidden: true}
                },
                {label: 'Isi Notifikasi Email',name: 'EMAIL_CONTENT', width: 200, sortable: true, hidden:true, editable: true,
                    edittype:"textarea",
                    editoptions: {rows:"5",cols:"45"},
                    editrules: {edithidden: true, required:false}
                },
                {label: 'Deskripsi',name: 'DESCRIPTION', width: 200, sortable: true, hidden:true, editable: true,
                    editoptions: {
                        size: 50,
                        maxlength:128
                    },
                    editrules: {edithidden: true, required:false}
                },
                {label: 'Tgl Pembuatan', name: 'CREATION_DATE', width: 120, align: "left", editable: false},
                {label: 'Dibuat Oleh', name: 'CREATED_BY', width: 120, align: "left", editable: false},
                {label: 'Tgl Update', name: 'UPDATED_DATE', width: 120, align: "left", editable: false},
                {label: 'Diupdate Oleh', name: 'UPDATED_BY', width: 120, align: "left", editable: false}
            ],
            height: '100%',
            autowidth: true,
            rowNum: 10,
            viewrecords: true,
            rowList: [5, 10, 20],
            rownumbers: true, // show row numbers
            rownumWidth: 35, // the width of the row numbers columns
            altRows: true,
            shrinkToFit: false,
            multiboxonly: true,
            onSelectRow: function (rowid) {
                var celValue = $('#grid-table').jqGrid('getCell', rowid, 'P_PROCEDURE_ID');
                var celCode = $('#grid-table').jqGrid('getCell', rowid, 'PROC_NAME');
         
                $('#tab_procedure_id').val(celValue);
                $('#tab_procedure_code').val(celCode);
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
            editurl: '<?php echo site_url('workflow_parameter/crud_procedure');?>',
            caption: "Daftar Pekerjaan Workflow"
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
                    form.css({"height": 0.50*screen.height+"px"});
                    form.css({"width": 0.60*screen.width+"px"});
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
                    form.css({"height": 0.50*screen.height+"px"});
                    form.css({"width": 0.60*screen.width+"px"});
                    
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

    function showLovPekerjaan(id, code) {
        modal_lov_p_procedure_show(id,code);
    }
    
</script>