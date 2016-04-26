<?php $prv = getPrivilege($menu_id); ?>
<div class="col-sm-12">
    <div class="tabbable">
        <ul class="nav nav-tabs" id="myTab">
            <li class="">
                <a href="#" id="mapping_mitra_tab">
                    <i class="green ace-icon fa fa-users bigger-120"></i>
                    Mitra
                </a>
            </li>
            <li class="">
                <a href="#" id="mapping_lokasi">
                    <i class="green ace-icon fa fa-map-marker bigger-120"></i>
                    Lokasi
                </a>
            </li>
            <li class="active">
                <a href="#">
                    <i class="green ace-icon fa fa-user bigger-120"></i>
                    PIC
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div id="home" class="tab-pane fade active in">
                <div class="row">
                    <div class="col-xs-12">
                        <?php if ($prv['TAMBAH'] == "Y") {
                            echo '<button class="btn btn-white btn-sm btn-round" id="add_pic" style="margin-bottom:10px">
                            <i class="ace-icon fa fa-plus green"></i>
                            Tambah PIC
                        </button>';
                        }
                        ?>

                        &nbsp;
                        <div id="tbl_pic">
                            <table id="grid_table_pic"></table>
                            <div id="grid_pager_pic"></div>
                        </div>

                    </div>
                    <div id="form_pic" style="display: none;">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(function () {
            var menu_id = '<?php echo $menu_id;?>';
            $('#mapping_mitra_tab').click(function () {
                $.ajax({
                    type: 'POST',
                    url: "<?php echo site_url();?>parameter/mapping_mitra",
                    data: {menu_id: menu_id},
                    timeout: 10000,
                    success: function (data) {
                        $("#mappingmitra").html("");
                        $("#mappingmitra").html(data);
                    }
                });
            });
            $('#mapping_lokasi').click(function () {
                var P_MAP_MIT_CC_ID = <?php echo $p_map_mit_cc_id;?>;
                if (P_MAP_MIT_CC_ID) {
                    $.ajax({
                        type: 'POST',
                        url: "<?php echo site_url();?>parameter/mapping_lokasi",
                        data: {
                            P_MAP_MIT_CC_ID: <?php echo $p_map_mit_cc_id;?>,
                            menu_id: menu_id
                        },
                        timeout: 10000,
                        success: function (data) {
                            $("#mappingmitra").html(data);
                        }
                    });
                } else {
                    swal("Perhatian", "Tidak ada row lokasi mitra yang dipilih !", "warning");
                }
            })
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            var grid = $("#grid_table_pic");
            var pager = $("#grid_pager_pic");

            var parent_column = grid.closest('[class*="col-"]');
            $(window).on('resize.jqGrid', function () {
                grid.jqGrid('setGridWidth', $("#tbl_pic").width() - 1);
                pager.jqGrid('setGridWidth', $("#tbl_pic").width() - 1);
            });
            //optional: resize on sidebar collapse/expand and container fixed/unfixed
            $(document).on('settings.ace.jqGrid', function (ev, event_name, collapsed) {
                if (event_name === 'sidebar_collapsed' || event_name === 'main_container_fixed') {
                    grid.jqGrid('setGridWidth', parent_column.width());
                    pager.jqGrid('setGridWidth', parent_column.width());
                }
            });
            var width = $("#tbl_pic").width();

            grid.jqGrid({
                url: '<?php echo site_url('parameter/gridMapPIC');?>',
                datatype: "json",
                mtype: "POST",
                colModel: [
                    {
                        label: 'ID',
                        name: 'P_MP_PIC_ID',
                        key: true,
                        width: 5,
                        sorttype: 'number',
                        editable: false,
                        hidden: true
                    },
                    {
                        label: 'P_MP_LOKASI_ID',
                        name: 'P_MP_LOKASI_ID',
                        width: 5,
                        sorttype: 'number',
                        editable: false,
                        hidden: true
                    },
                    {
                        label: 'P_PIC_ID',
                        name: 'P_PIC_ID',
                        width: 200,
                        align: "left",
                        editable: true,
                        hidden: true
                    },
                    {
                        label: 'P_CONTACT_TYPE_ID',
                        name: 'P_CONTACT_TYPE_ID',
                        width: 200,
                        align: "left",
                        editable: true,
                        hidden: true
                    },
                    {
                        label: 'Nama PIC',
                        name: 'PIC_NAME',
                        width: 200,
                        align: "left",
                        editable: true,
                        editrules: {required: true},
                        editoptions: {size: 45}
                    },
                    {
                        label: 'Jenis Kontak',
                        name: 'CODE',
                        width: 200,
                        align: "left",
                        editable: true,
                        editrules: {required: true},
                        editoptions: {size: 45}
                    },
                    {
                        label: 'Alamat 1',
                        name: 'ADDRESS_1',
                        width: 250,
                        align: "left",
                        editable: true,
                        editoptions: {size: 45, value: {Tes: 'asdad'}}
                    },
                    {
                        label: 'Kota',
                        name: 'KOTA',
                        width: 100,
                        align: "left",
                        sortable: true,
                        editable: true,
                        editoptions: {size: 45, value: {Tes: 'asdad'}},
                        hidden: false
                    },
                    {
                        label: 'Kode Pos',
                        name: 'ZIP_CODE',
                        width: 70,
                        align: "left",
                        sortable: true,
                        editable: true,
                        editrules: {number: true},
                        hidden: false
                    },
                    {
                        label: 'Email',
                        name: 'EMAIL',
                        width: 150,
                        align: "left",
                        sortable: true,
                        editable: true,
                        editoptions: {size: 45, value: {Tes: 'asdad'}},
                        hidden: false
                    },
                    {
                        label: 'No. HP',
                        name: 'NO_HP',
                        width: 100,
                        align: "left",
                        sortable: true,
                        editable: true,
                        editoptions: {size: 45, value: {Tes: 'asdad'}},
                        hidden: false
                    },
                    {
                        label: 'Fax',
                        name: 'FAX',
                        width: 100,
                        align: "left",
                        sortable: true,
                        editable: true,
                        editoptions: {size: 45, value: {Tes: 'asdad'}},
                        hidden: false
                    }
                ],
                postData: {P_MP_LOKASI_ID: <?php echo $P_MP_LOKASI_ID;?>},
                width: width,
                AutoWidth: true,
                height: '100%',
                scrollOffset: 0,
                rowNum: 5,
                viewrecords: true,
                rowList: [5, 10, 20],
                sortname: 'P_MP_PIC_ID', // default sorting ID
                rownumbers: true, // show row numbers
                rownumWidth: 35,
                sortorder: 'asc',
                altRows: true,
                shrinkToFit: true,
                multiboxonly: true,
                onSortCol: clearSelection,
                onPaging: clearSelection,
                pager: '#grid_pager_pic',
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
                editurl: '<?php echo site_url('parameter/crud_pic_mapping');?>',
                caption: "List Lokasi Mitra"

            });


            //navButtons grid master
            grid.jqGrid('navGrid', '#grid_pager_pic',
                { 	//navbar options
                    edit: false,
                    excel: false,
                    editicon: 'ace-icon fa fa-pencil blue',
                    add: false,
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
                    width: 600,
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
                    },
                    onclickSubmit: function () {
                        //var ten_id = $("#list_cc").val();

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
                }).navButtonAdd('#grid_pager_pic', {
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
                var P_MP_PIC_ID = grid.jqGrid('getCell', rowKey, 'P_MP_PIC_ID');

                if (rowKey) {
                    $.ajax({
                        // async: false,
                        url: "<?php echo base_url();?>parameter/edit_mapping_pic",
                        type: "POST",
                        data: {action: "edit"},
                        success: function (data) {
                            $("#form_pic").html(data);
                            $.post("<?php echo site_url('parameter/gridMapPIC');?>",
                                {
                                    P_MP_PIC_ID: P_MP_PIC_ID
                                },
                                function (response) {
                                    var response = JSON.parse(response);
                                    var obj = response.Data[0];
                                    $("#pic_name").val(obj.PIC_NAME);
                                    $("#pic_id").val(obj.P_PIC_ID);
                                    $("#contact").val(obj.P_REFERENCE_LIST_ID);
                                    $("#p_mp_lokasi_id").val(obj.P_MP_LOKASI_ID);
                                    $("#p_mp_pic_id").val(obj.P_MP_PIC_ID);

                                    $("#form_created_by").val(obj.CREATED_BY);
                                    $("#form_creation_date").val(obj.CREATE_DATE);
                                    $("#form_updated_by").val(obj.UPDATE_BY);
                                    $("#form_updated_date").val(obj.UPDATE_DATE);
                                }
                            );

                            $("#tbl_pic").hide("slow");
                            $("#form_pic").show("slow");


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
        $("#add_pic").click(function () {
            $.ajax({
                // async: false,
                url: "<?php echo base_url();?>parameter/add_pic",
                type: "POST",
                data: {action: "add", P_MP_LOKASI_ID:<?php echo $P_MP_LOKASI_ID;?>},
                success: function (data) {
                    $("#form_pic").html(data);
                    $("#tbl_pic").hide("slow");
                    $("#form_pic").show("slow");
                }
            });
        });

    </script>
</div>