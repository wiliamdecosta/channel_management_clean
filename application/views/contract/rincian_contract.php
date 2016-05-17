<div id="content">
    <div class="breadcrumbs" id="breadcrumbs">
        <?=$this->breadcrumb;?>
    </div>
    <div class="page-content">

        <div class="row">
            <div class="col-xs-12">

                <div class="row">
                    <div class="vspace-12-sm"></div>
                    <div class="col-sm-12">
                        <div class="widget-box transparent">
                            <div class="widget-header red widget-header-flat">
                                <h4 class="widget-title lighter">
                                    Rincian Kontrak
                                </h4>

                                <div class="widget-toolbar">
                                    <a href="#" data-action="collapse">
                                        <i class="ace-icon fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="widget-body">
                                <br>

                                <form class="form-horizontal" role="form" id="filterForm">
                                    <div class="row">
                                        <div class="col-xs-12">                                            
                                            <div class="form-group">
                                                <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1"> No. Kontrak </label>
                                                <div class="col-sm-3">
                                                    <input class="form-control" type="text" id="contract_no" name="contract_no" placeholder="Nomor Kontrak" />
                                                </div>
                                                <a id="findFilter" class="fm-button ui-state-default ui-corner-all fm-button-icon-right ui-reset btn btn-sm btn-info">
                                                    <span class="ace-icon fa fa-search"></span>Find</a>
                                                <a class="btn btn-sm btn-success" id="btn_export_excel">
                                                <i class="ace-icon ace-icon fa fa-print align-top bigger-125"></i>
                                                Export to Excel
                                                </a>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1"> Nama Mitra </label>
                                                <div class="col-sm-3">
                                                    <input class="form-control" type="text" id="mitra_name" name="mitra_name" placeholder="Nama Mitra" />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1"> Status </label>
                                                <div class="col-sm-3">
                                                    <select class="form-control" id="status" name="status">
                                                        <option value="">Pilih Status</option>

                                                        <?php foreach ($result as $row){
                                                            echo "<option value='".$row->P_ORDER_STATUS_ID."'>".$row->CODE."</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-1 control-label no-padding-right" for="form-field-1">Tgl. Order </label>
                                                <div class="col-sm-2">
                                                    <input class="form-control" type="text" id="awal" name="awal" placeholder="Awal" data-date-format="dd-mm-yyyy" /> 
                                                </div>
                                                <div class="col-sm-1">
                                                    Sampai Tgl.
                                                </div>
                                                <div class="col-sm-2">
                                                    <input class="form-control" type="text" id="akhir" name="akhir" placeholder="Akhir" data-date-format="dd-mm-yyyy" />
                                                </div>
                                            </div>                                           

                                        </div>
                                    </div>
                                </form>
                            </div><!-- PAGE CONTENT ENDS -->
                        </div>
                    </div>
                </div><!-- /.widget-box -->
            </div><!-- /.col -->



        </div><!-- /.row -->

        <div class="hr hr-double hr-dotted hr18"></div>

        <div class="row">
            <div class="col-xs-12">       
               <table id="grid-table"></table>
               <div id="grid-pager"></div>    
            </div>
        </div> 

        <!-- PAGE CONTENT ENDS -->
    </div><!-- /.col -->
</div><!-- /.row
</div><!-- /.page-content -->
</div>
<!-- #section:basics/content.breadcrumbs -->
<!--<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>-->
<script type="text/javascript">

    jQuery(function($) {

        $('#awal').datepicker({
            autoclose: true,
            todayHighlight: true
        });

        $('#akhir').datepicker({
            autoclose: true,
            todayHighlight: true
        });

        $('#btn_export_excel').on('click', function (e) {
            exportExcelRicianReport();        
        });

        $('#findFilter').click(function(){
            var contract_no = $("#contract_no").val();
            var mitra_name = $("#mitra_name").val();
            var status = $("#status").val();
            var awal = $("#awal").val();
            var akhir = $("#akhir").val();

            $("#grid-table").jqGrid('setGridParam', { 
                postData:{ 
                    s_contract_no : contract_no,
                    s_mitra_name : mitra_name,
                    s_status : status,
                    s_awal : awal,
                    s_akhir : akhir
                }
            }).trigger("reloadGrid");
        });
        
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
            url: '<?php echo site_url('contract/grid_detail_contract');?>',
            datatype: "json",
            mtype: "POST",
            colModel: [
                {label: 'ID',name: 'T_CUSTOMER_ORDER_ID', key: true, width: 35, sorttype: 'number', sortable: true, editable: true, hidden:true},
                {
                    label: 'No. Order',
                    name: 'ORDER_NO', 
                    width: 100, 
                    sortable: true, 
                    editable: false
                },                
                {
                    label: 'Tgl. Order',
                    name: 'ORDER_DATE', 
                    width: 100, 
                    sortable: true, 
                    editable: false
                },                
                {
                    label: 'No. Kontrak',
                    name: 'CONTRACT_NO', 
                    width: 250, 
                    sortable: true, 
                    editable: false
                },                             
                {
                    label: 'Nama Mitra',
                    name: 'MITRA_NAME', 
                    width: 300, 
                    sortable: true, 
                    editable: false
                },                
                {
                    label: 'Lokasi',
                    name: 'LOKASI', 
                    width: 250, 
                    sortable: true, 
                    editable: false
                },    
                {
                    label: 'Berlaku Dari',
                    name: 'VALID_FROM', 
                    width: 100, 
                    sortable: true, 
                    align: 'right',
                    editable: false
                },    
                {
                    label: 'Sampai',
                    name: 'VALID_TO', 
                    width: 100, 
                    sortable: true, 
                    align: 'right',
                    editable: false
                },                
                {
                    label: 'Status',
                    name: 'STATUS', 
                    width: 70, 
                    sortable: true, 
                    editable: false
                },                
                {
                    label: 'Posisi Terakhir',
                    name: 'LAST_PROCESS', 
                    width: 250, 
                    sortable: true, 
                    editable: false
                }
               
            ],
            height: '100%',
            autowidth: true,
            rowNum: 5,
            viewrecords: true,
            rowList: [5, 10, 20],
            rownumbers: true, // show row numbers
            rownumWidth: 35, // the width of the row numbers columns
            altRows: true,
            shrinkToFit: false,
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
            // editurl: '<?php echo site_url('workflow_parameter/crud_procedure');?>',
            caption: "Rincian Kontrak"
        });

        jQuery('#grid-table').jqGrid('navGrid', '#grid-pager',
            {   //navbar options
                edit: false,
                editicon: 'ace-icon fa fa-pencil blue',
                add: false,
                addicon: 'ace-icon fa fa-plus-circle purple',
                del: false,
                delicon: 'ace-icon fa fa-trash-o red',
                search: false,
                searchicon: 'ace-icon fa fa-search orange',
                refresh: false,
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

    function exportExcelRicianReport() {
        var url = "<?php echo base_url();?>contract/excelRincianReport?";
        url += "s_contract_no=" + $('#contract_no').val();
        url += "&s_mitra_name=" + $('#mitra_name').val();
        url += "&s_status=" + $('#status').val();
        url += "&s_awal=" + $('#awal').val();
        url += "&s_akhir=" + $('#akhir').val();
        url += "&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>";
        window.location = url;
    }


</script>