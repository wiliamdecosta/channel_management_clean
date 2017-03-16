<?php $prv = getPrivilege($menu_id);?>
<div class="breadcrumbs" id="breadcrumbs">
    <?= $this->breadcrumb; ?>
</div>
<br>
<div class="col-sm-12">
    <!-- #section:elements.tab -->
    <div class="tabbable" style="margin-top:30px;">
        <ul class="nav nav-tabs"  id="myTab">
            <li class="active">
                <a data-toggle="tab" href="#" aria-expanded="true">
                    <i class="green ace-icon fa fa-users bigger-120"></i>
                    Acc X PGL
                </a>
            </li>
        </ul>

        <div class="tab-content">
            <div id="home" class="tab-pane fade active in">
                <div id="tbl_pic">
                    <?php if ($prv['TAMBAH'] == "Y") {
                        echo '<button class="btn btn-white btn-sm btn-round" id="add_mitra" style="margin-bottom:10px">
                        <i class="ace-icon fa fa-plus green"></i>
                        Tambah Mapping
                    </button>';
                    }
                    ?>

                    &nbsp;
                    <div class="row">
                        <div class="col-xs-12">
                            <table id="grid-table1"></table>
                            <div id="grid-pager"></div>
                        </div>
                    </div>


                </div>
                <div id="form_mitra" style="display: none;">
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function () {
                var grid = $("#grid-table1");
                var pager = $("#grid-pager");

                //resize to fit page size
                var parent_column = grid.closest('[class*="col-"]');
                $(window).on('resize.jqGrid', function () {
                    grid.jqGrid('setGridWidth', $(".tab-content").width() - 10);
                })
                //optional: resize on sidebar collapse/expand and container fixed/unfixed
                $(document).on('settings.ace.jqGrid', function (ev, event_name, collapsed) {
                    if (event_name === 'sidebar_collapsed' || event_name === 'main_container_fixed') {
                        grid.jqGrid('setGridWidth', parent_column.width());
                    }
                });

				// P_MP_PGL_ACC_ID NUMBER (1) 
				// PGL_ID          NUMBER (10) 
				// PGL_NAME        VARCHAR2 (100) 
				// MDIID           VARCHAR2 (40) 
				// NAMEINVOICE     VARCHAR2 (255) 
				// DATA_SOURCE_ID  NUMBER
				// CODE            VARCHAR2 (7) 
				    // CREATE_BY
					// CREATE_DATE
				
                var width = $(".tab-content").width() - 10;
                grid.jqGrid({
                    url: '<?php echo site_url('parameter/gridMapDataAcc');?>',
                    datatype: "json",
                    mtype: "POST",
                    colModel: [
						 {
                            label: 'PGL_ID',
                            name: 'PGL_ID',
                            key: true,
                            width: 5,
                            sorttype: 'number',
                            editable: true,
                            hidden: true
                        },
						 {
                            label: 'MDIID',
                            name: 'MDIID',
                            key: true,
                            width: 5,
                            sorttype: 'number',
                            editable: true,
                            hidden: true
                        },
							 {
                            label: 'DATA_SOURCE_ID',
                            name: 'DATA_SOURCE_ID',
                            key: true,
                            width: 5,
                            sorttype: 'number',
                            editable: true,
                            hidden: true
                        },
						{
                            label: 'ID',
                            name: 'P_MP_PGL_ACC_ID',
                            key: true,
                            width: 5,
                            sorttype: 'number',
                            editable: true,
                            hidden: true
                        },
                        {
                            label: 'Nama Mitra',
                            name: 'PGL_NAME',
                            width: 350,
                            align: "left",
                            editable: true,
                            editrules: {required: true}
                        },
                        {
                            label: 'Nama Acc-MDIID',
                            name: 'NAMEINVOICE',
                            width: 350,
                            align: "left",
                            editable: true,
                            editrules: {required: true}
                        },
                        {
                            label: 'Data Source',
                            name: 'CODE',
                            width: 90,
                            align: "left",
                            editable: true,
                            editrules: {required: true}
                        },
                        {label: 'Dibuat Oleh',
                            width: 150,
                            align: "left",
                            formatter : function(cellvalue,option,rowObject){
                                return rowObject.CREATE_BY + ' - ' + rowObject.CREATE_DATE;
                            }
                        },
                        {label: 'Diubah Oleh',
                            width: 150,
                            align: "left",
                            formatter : function(cellvalue,option,rowObject){
                                return rowObject.UPDATE_BY + ' - ' + rowObject.UPDATE_DATE;
                            }
                        }
                    ],
                    //postData: data,
                    width: width,
                    // AutoWidth: true,
                    height: '100%',
                    scrollOffset: 0,
                    rowNum: 5,
                    viewrecords: true,
                    rowList: [5, 10, 20],
                    sortname: 'P_MP_PGL_ACC_ID', // default sorting ID
                    rownumbers: true, // show row numbers
                    rownumWidth: 35,
                    sortorder: 'asc',
                    altRows: true,
                    shrinkToFit: false,
                    multiboxonly: true,
                    onSortCol: clearSelection,
                    onPaging: clearSelection,
                    pager: '#grid-pager',
                    jsonReader: {
                        root: 'Data',
                        id: 'id',
                        repeatitems: false
                    },
                    loadComplete: function () {

                        var ubah = '<?php echo $prv['UBAH'];?>';
                        if (ubah == "Y") {
                            $('#edit').show();
                        } else {
                            $('#edit').hide();
                        }

                        var table = this;
                        setTimeout(function () {
                            updatePagerIcons(table);
                            enableTooltips(table);
                        }, 0);
                    },
                    editurl: '<?php echo site_url('parameter/crud_mapping_par_mdacc');?>',
                    caption: "List Mapping Acc - MDIID"

                });


                //navButtons grid master
                grid.jqGrid('navGrid', '#grid-pager',
                    { 	//navbar options
                        edit: false,
                        excel: false,
                        editicon: 'ace-icon fa fa-pencil blue',
                        add: false,
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
                            form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
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

                    },
                    {
                        //view record form
                        width: 500,
                        recreateForm: true,
                        beforeShowForm: function (e) {
                            var form = $(e[0]);
                            form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
                        }
                    }).navButtonAdd('#grid-pager', {
                    caption: "",
                    buttonicon: "ace-icon fa fa-pencil blue",
                    onClickButton: edit,
                    position: "first",
                    title: "Edit Record",
                    cursor: "pointer",
                    id: "edit"
                });

                function edit() {
                    var rowKey = grid.jqGrid('getGridParam', 'selrow');
                    var P_MP_PGL_ACC_ID = grid.jqGrid('getCell', rowKey, 'P_MP_PGL_ACC_ID');

                    if (rowKey) {
                        $.ajax({
                            // async: false,
                            url: "<?php echo base_url();?>parameter/editmappingdatacc",
                            type: "POST",
                            data: {action: "edit"},
                            success: function (data) {
                                $("#form_mitra").html(data);

                                $.post("<?php echo site_url('parameter/gridMapDataAcc');?>",
                                    {
                                        P_MP_PGL_ACC_ID: P_MP_PGL_ACC_ID
                                    },
                                    function (response) {
                                        var response = JSON.parse(response);
                                        var obj = response.Data[0];
                                        $("#p_mp_pgl_acc_id").val(P_MP_PGL_ACC_ID);
                                        $("#dts_code").val(obj.CODE);
                                        $("#acc_name").val(obj.NAMEINVOICE);
                                        $("#mitra_name").val(obj.PGL_NAME);
										
											// P_MP_PGL_ACC_ID NUMBER (1) 
											// PGL_ID          NUMBER (10) 
											// PGL_NAME        VARCHAR2 (100) 
											// MDIID           VARCHAR2 (40) 
											// NAMEINVOICE     VARCHAR2 (255) 
											// DATA_SOURCE_ID  NUMBER
											// CODE            VARCHAR2 (7) 
												// CREATE_BY
												// CREATE_DATE
										
										$("#mitra_id").val(obj.PGL_ID);
										$("#dts_id").val(obj.DATA_SOURCE_ID);
										$("#acc_id").val(obj.MDIID);
										
                                    }
                                );

                                $("#tbl_pic").hide("slow");
                                $("#form_mitra").show("slow");
                            }
                        });
                    }

                    else {
                        // alert("Please Select Row !!!");
                        $.jgrid.viewModal("#alertmod_" + this.id, {toTop: true, jqm: true});
                    }

                }

                function clearSelection() {

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
            });
        </script>
        <script>
            $("#add_mitra").click(function () {
                $.ajax({
                    // async: false,
                    url: "<?php echo base_url();?>parameter/mapping_form_os",
                    type: "POST",
                    data: {action: "add"},
                    success: function (data) {
                        $("#form_mitra").html(data);
                        $("#tbl_pic").hide("slow");
                        $("#form_mitra").show("slow");
                    }
                });
            });

        </script>

        <!-- /section:elements.tab -->
    </div>
</div>
