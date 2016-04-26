<?php $prv = getPrivilege( $this->input->post('menu_id') ); ?>
<div class="breadcrumbs" id="breadcrumbs">
    <?php echo getBreadcrumb(array('Workflow Parameter','Daemon')); ?>
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
    					    <li class="">
    					    	<a href="#" data-toggle="tab" aria-expanded="true" id="tab-1">
    					    		<i class="blue bigger-120"></i>
    					    		<strong>Aliran Workflow</strong>
    					    	</a>
    					    </li>
    					    <li class="active">
    					    	<a href="#" data-toggle="tab" aria-expanded="true" id="tab-3">
    					    		<i class="blue bigger-120"></i>
    					    		<strong>Daemon</strong>
    					    	</a>
    					    </li>
    		            </ul>
    		            <input type="hidden" id="tab_chart_proc_id" value="<?php echo $this->input->post('p_w_chart_proc_id');?>">
    		            <input type="hidden" id="tab_chart_proc_code" value="<?php echo $this->input->post('workflow_name');?>">
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

<script>
    
    jQuery(function($) {
        $( "#tab-1" ).on( "click", function() {
            loadContentWithParams("workflow_parameter-chart_proc.php", {
                menu_id : <?php echo $this->input->post('menu_id'); ?>
            });
        });
    });
    
    
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
            url: '<?php echo site_url('workflow_parameter/grid_daemon');?>',
            postData : {p_w_chart_proc_id : $("#tab_chart_proc_id").val()},
            datatype: "json",
            mtype: "POST",
            colModel: [
                {
                    label: 'ID',
                    name: 'P_W_DAEMON_PROC_ID', 
                    key: true, 
                    width: 35, 
                    sorttype: 'number', 
                    sortable: true, 
                    editable: true, 
                    hidden:true
                },
                {
                    label: 'ID',
                    name: 'P_W_CHART_PROC_ID', 
                    width: 35, 
                    sorttype: 'number', 
                    sortable: true, 
                    editable: true, 
                    hidden:true
                },
                {
                    label: 'Nama Syarat Perpindahan',
                    name: 'DAEMON_NAME', 
                    width: 300, 
                    sortable: true, 
                    editable: true,
                    editoptions: {
                        size: 50,
                        maxlength:96
                    },
                    editrules: {required: true}
                },
                {
                    label: 'Ekspresi / Formula Syarat',
                    name: 'EXPRESSION_RULE', 
                    width: 300, 
                    sortable: true, 
                    editable: true,
                    editoptions: {
                        size: 50,
                        maxlength:96
                    },
                    editrules: {required: true}
                },
                {
                    label: 'Mulai Berlaku',
                    name: 'VALID_FROM',
                    width: 150,
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
                    width: 150,
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
                    label: 'Deskripsi',
                    name: 'DESCRIPTION', 
                    width: 200, 
                    sortable: true, 
                    editable: true,
                    editoptions: {
                                    size: 50,
                                    maxlength:128
                    },
                    editrules: {edithidden: true, required:false}
                },
                {label: 'Tgl Pembuatan', name: 'CREATION_DATE', width: 120, align: "left", editable: false, hidden: true},
                {label: 'Dibuat Oleh', name: 'CREATED_BY', width: 120, align: "left", editable: false, hidden: true},
                {label: 'Tgl Update', name: 'UPDATED_DATE', width: 120, align: "left", editable: false, hidden: true},
                {label: 'Diupdate Oleh', name: 'UPDATED_BY', width: 120, align: "left", editable: false, hidden: true}
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
            editurl: '<?php echo site_url('workflow_parameter/crud_daemon');?>',
            caption: "Workflow :: " + $("#tab_chart_proc_code").val()
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
                    
                    /*$("#USER_NAME").prop("readonly", true);*/
                },
                afterShowForm: function(form) {
                    form.closest('.ui-jqdialog').center();
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
                editData: {
                    P_W_CHART_PROC_ID: function() {
                        return $("#tab_chart_proc_id").val();
                    }
                },
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
                },
                afterShowForm: function(form) {
                    form.closest('.ui-jqdialog').center();
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