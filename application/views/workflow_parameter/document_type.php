<!-- #section:basics/content.breadcrumbs -->
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

<script>
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
            url: '<?php echo site_url('workflow_parameter/grid_document_type');?>',
            datatype: "json",
            mtype: "POST",
            colModel: [
                {label: 'ID',name: 'P_DOCUMENT_TYPE_ID', key: true, width: 35, sorttype: 'number', sortable: true, editable: true, hidden:true},
                {label: 'Nama Dokumen',name: 'DOC_NAME', width: 200, sortable: true, editable: true,
                    editoptions: {
                        size: 50,
                        maxlength:64
                    },
                    editrules: {required: true}
                },
                
                {label: 'Nama Dokumen Tercetak',name: 'DISPLAY_NAME', width: 200, sortable: true, hidden:true, editable: true,
                    editoptions: {
                        size: 50,
                        maxlength:96
                    },
                    editrules: {edithidden: true, required:true}
                },

                {label: 'No Urut Prioritas',name: 'LISTING_NO', width: 200, sortable: true, hidden:true, editable: true,
                    editoptions: {
                        size: 20,
                        maxlength:2
                    },
                    editrules: {edithidden: true, number:true, required:true}
                },
                
                {label: 'Table Utama Dokumen',name: 'TDOC', width: 200, sortable: true, editable: true,
                    editrules: {required: true},
                    edittype: 'select',
                    editoptions: {style: "width: 370px", dataUrl: '<?php echo site_url("workflow_parameter/html_select_options_reference_list/TDOC"); ?>'}
                },
                {label: 'Table Kontrol Inbox',name: 'TCTL', width: 200, sortable: true, editable: true,
                    editrules: {required: true},
                    edittype: 'select',
                    editoptions: {style: "width: 370px", dataUrl: '<?php echo site_url("workflow_parameter/html_select_options_reference_list/TCTL"); ?>'}
                },
                
                {label: 'Tabel Kontrol User',name: 'TUSER', width: 200, sortable: true, hidden:true, editable: true,
                    editrules: {edithidden: true, required: true},
                    edittype: 'select',
                    editoptions: {style: "width: 370px", dataUrl: '<?php echo site_url("workflow_parameter/html_select_options_reference_list/TUSER"); ?>'}
                },
                
                {label: 'Package',name: 'PACKAGE_NAME', width: 200, sortable: true, editable: true,
                    editrules: {required: true},
                    edittype: 'select',
                    editoptions: {style: "width: 370px", dataUrl: '<?php echo site_url("workflow_parameter/html_select_options_reference_list/TPACKNAME"); ?>'}
                },
                
                {label: 'Fungsi Layout Profile Inbox',name: 'F_PROFILE', width: 200, sortable: true, hidden:true, editable: true,
                    editrules: {edithidden: true, required: true},
                    edittype: 'select',
                    editoptions: {style: "width: 370px", dataUrl: '<?php echo site_url("workflow_parameter/html_select_options_reference_list/TPROFILE"); ?>'}
                },
                
                {label: 'Form Summary Inbox',name: 'PROFILE_SOURCE', width: 200, sortable: true, hidden:true, editable: true,
                    editrules: {edithidden: true, required: true},
                    edittype: 'select',
                    editoptions: {style: "width: 370px", dataUrl: '<?php echo site_url("workflow_parameter/html_select_options_reference_list/TFORMSUMINBOX"); ?>'}
                },
                
                {label: 'Fungsi Deteksi Fraud',name: 'F_APP_FRAUD_ENGINE', width: 200, sortable: true, hidden:true, editable: true,
                    editoptions: {
                        size: 50,
                        maxlength:64
                    },
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
                var celValue = $('#grid-table').jqGrid('getCell', rowid, 'P_DOCUMENT_TYPE_ID');
                
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
            editurl: '<?php echo site_url('workflow_parameter/crud_document_type');?>',
            caption: "Daftar Jenis Workflow"
        });

        jQuery('#grid-table').jqGrid('navGrid', '#grid-pager',
            {   //navbar options
                edit: true,
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
    
</script>