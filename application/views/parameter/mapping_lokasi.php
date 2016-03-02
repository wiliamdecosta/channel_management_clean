<div class="col-sm-12">
    <!-- #section:elements.tab -->
    <div class="tabbable">
        <ul class="nav nav-tabs" id="myTab">
            <li class="">
                <a href="#" id="mapping_mitra_tab">
                    <i class="green ace-icon fa fa-users bigger-120"></i>
                    Mitra
                </a>
            </li>
            <li class="active">
                <a href="#">
                    <i class="green ace-icon fa fa-map-marker bigger-120"></i>
                    Lokasi
                </a>
            </li>
            <li class="">
                <a href="#" id="mapping_pic">
                    <i class="green ace-icon fa fa-user bigger-120"></i>
                    PIC
                </a>
            </li>

        </ul>

        <div class="tab-content">
            <div id="home" class="tab-pane fade active in">
                <div id="tbl_pic">
                    <table id="grid_table_lokasi"></table>
                    <div id="grid_pager_lokasi"></div>
                </div>
                <br>
                <div class="row">
                    <div class="col-xs-12">
                        <div id="detailsPlaceholder" style="display:none">
                            <table id="grid_table_pks"></table>
                            <div id="grid_pager_pks"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /section:elements.tab -->
    </div>

    <script type="text/javascript">
        $(function () {
            $('#mapping_mitra_tab').click(function () {
                $.ajax({
                    type: 'POST',
                    url: "<?php echo site_url();?>parameter/mapping_mitra",
                    timeout: 10000,
                    success: function (data) {
                        $("#mappingmitra").html("");
                        $("#mappingmitra").html(data);
                    }
                });
            });
            $('#mapping_pic').click(function () {
                var lokasi_id = $("#grid_table_lokasi").jqGrid('getGridParam', 'selrow');
                if (lokasi_id) {
                    $.ajax({
                        type: 'POST',
                        url: "<?php echo site_url();?>parameter/mapping_pic",
                        data: {P_MP_LOKASI_ID: lokasi_id,P_MAP_MIT_CC_ID: <?php echo $p_map_mit_cc_id;?>},
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
            var grid = $("#grid_table_lokasi");
            var pager = $("#grid_pager_lokasi");
            var grid_pks = $("#grid_table_pks");
            var pager_pks = $("#grid_pager_pks");
            grid.jqGrid({
                url: '<?php echo site_url('parameter/gridMapMitraLokasi');?>',
                datatype: "json",
                mtype: "POST",
                colModel: [
                    {
                        label: 'ID',
                        name: 'P_MP_LOKASI_ID',
                        key: true,
                        width: 5,
                        sorttype: 'number',
                        editable: false,
                        hidden: true
                    },
                    {
                        label: 'P_MAP_MIT_CC_ID',
                        name: 'P_MAP_MIT_CC_ID',
                        width: 5,
                        sorttype: 'number',
                        editable: false,
                        hidden: true
                    },
                    {
                        label: 'Lokasi',
                        name: 'LOKASI',
                        width: 200,
                        align: "left",
                        editable: true,
                        editrules: {required: true},
                        editoptions: {size: 45}
                    },
                    {
                        label: 'Valid From',
                        name: 'VALID_FROM',
                        width: 150,
                        align: "left",
                        editable: true,
                        editrules: {required: true},
                        editoptions: {
                            dataInit: function (element) {
                                $(element).datepicker({
                                    autoclose: true,
                                    format: 'dd-mm-yyyy',
                                    orientation: 'bottom'
                                });
                            }
                        }
                    },
                    {
                        label: 'Valid Until',
                        name: 'VALID_UNTIL',
                        width: 150,
                        align: "left",
                        editable: true,
                        editrules: {required: true},
                        editoptions: {
                            dataInit: function (element) {
                                $(element).datepicker({
                                    autoclose: true,
                                    format: 'dd-mm-yyyy',
                                    orientation: 'bottom'
                                });
                            }
                        }
                    }
                ],
                postData: {P_MAP_MIT_CC_ID: <?php echo $p_map_mit_cc_id;?>},
                width: '1090',
                AutoWidth: true,
                height: '100%',
                scrollOffset: 0,
                rowNum: 5,
                viewrecords: true,
                rowList: [5, 10, 20],
                sortname: 'P_MP_LOKASI_ID', // default sorting ID
                rownumbers: true, // show row numbers
                rownumWidth: 35,
                sortorder: 'asc',
                altRows: true,
                shrinkToFit: true,
                multiboxonly: true,
                onSortCol: clearSelection,
                onPaging: clearSelection,
                pager: '#grid_pager_lokasi',
                jsonReader: {
                    root: 'Data',
                    id: 'id',
                    repeatitems: false
                },
                onSelectRow: function (rowid) {
                    var celValue = grid.jqGrid('getCell', rowid, 'LOKASI');
                    if (rowid != null) {
                        grid_pks.jqGrid('setGridParam', {
                            url: "<?php echo site_url('parameter/gridMapPKS');?>",
                            datatype: 'json',
                            postData: {P_MP_LOKASI_ID: rowid}
                        });
                        grid_pks.jqGrid('setCaption', 'List PKS Lokasi @' + celValue);
                        $("#detailsPlaceholder").show();
                        grid_pks.trigger("reloadGrid");
                    }
                },
                loadComplete: function () {
                    $(window).on('resize.jqGrid', function () {
                        grid.jqGrid('setGridWidth', 1090);
                    });
                    $(window).on('resize.jqGrid', function () {
                        pager.jqGrid('setGridWidth', 1090);
                    });

                    var table = this;
                    setTimeout(function () {
                        updatePagerIcons(table);
                        enableTooltips(table);
                    }, 0);
                },
                editurl: '<?php echo site_url('parameter/crud_lokasimitra');?>',
                caption: "List Lokasi Mitra"

            });

            //navButtons grid master
            grid.jqGrid('navGrid', '#grid_pager_lokasi',
                { 	//navbar options
                    edit: true,
                    excel: false,
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
                    viewicon: 'ace-icon fa fa-search-plus grey',
                    afterRefresh: function () {
                        // some code here
                        $("#detailsPlaceholder").hide();
                    }
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
                        return {P_MAP_MIT_CC_ID: <?php echo $p_map_mit_cc_id;?>};
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
                })


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


            /* ------------------- Grid Lokasi ------------------------*/
            //JqGrid Detail
            grid_pks.jqGrid({
                mtype: "POST",
                datatype: "json",
                caption: "List PKS",
                colModel: [
                    {label: 'ID', name: 'P_MP_PKS_ID', key: true, autowidth: true, editable: true, hidden: true},
                    {label: 'P_MP_LOKASI_ID', name: 'P_MP_LOKASI_ID', hidden: true},
                    {
                        label: 'NO PKS',
                        name: 'NO_PKS',
                        width: 200,
                        align: "left",
                        editable: true,
                        editrules: {required: true},
                        editoptions: {size: 45}
                    },
                    {
                        label: 'Valid From',
                        name: 'VALID_FROM',
                        width: 150,
                        align: "left",
                        editable: true,
                        editrules: {required: true},
                        editoptions: {
                            dataInit: function (element) {
                                $(element).datepicker({
                                    autoclose: true,
                                    format: 'dd-mm-yyyy',
                                    orientation: 'bottom'
                                });
                            }
                        }
                    },
                    {
                        label: 'Valid Until',
                        name: 'VALID_UNTIL',
                        width: 150,
                        align: "left",
                        editable: true,
                        editrules: {required: true},
                        editoptions: {
                            dataInit: function (element) {
                                $(element).datepicker({
                                    autoclose: true,
                                    format: 'dd-mm-yyyy',
                                    orientation: 'bottom'
                                });
                            }
                        }
                    }
                ],
                width: 1090,
                height: '100%',
                rowNum: 5,
                page: 1,
                shrinkToFit: true,
                rownumbers: true,
                rownumWidth: 35, // the width of the row numbers columns
                viewrecords: true,
                sortname: 'P_MP_PKS_ID ', // default sorting ID
                sortorder: 'asc',
                pager: "#grid_pager_pks",
                jsonReader: {
                    root: 'Data',
                    id: 'id',
                    repeatitems: false
                },
                loadComplete: function () {
                    $(window).on('resize.jqGrid', function () {
                        grid_pks.jqGrid('setGridWidth', 1090);
                    });
                    $(window).on('resize.jqGrid', function () {
                        pager_pks.jqGrid('setGridWidth', 1090);
                    });
                    var table = this;
                    setTimeout(function () {
                        //  styleCheckbox(table);

                        //  updateActionIcons(table);
                        updatePagerIcons(table);
                        enableTooltips(table);
                    }, 0);
                },
                editurl: '<?php echo site_url('parameter/crud_pks');?>'
            });

            //navButtons Grid Detail
            grid_pks.jqGrid('navGrid', '#grid_pager_pks',
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
                    /* editData: {
                     MENU_PARENT: function () {
                     var data = jQuery("#jqGridDetails").jqGrid('getGridParam', 'postData');
                     return data.parent_id;
                     }
                     },*/
                    closeAfterEdit: true,
                    width: 500,
                    errorTextFormat: function (data) {
                        return 'Error: ' + data.responseText
                    },
                    recreateForm: true,
                    beforeShowForm: function (e) {
                        var form = $(e[0]);
                        form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />');
                        style_edit_form(form);
                    },
                    afterSubmit: function (response, postdata) {
                        var responseText = response.responseText;
                        var responses = JSON.parse(responseText);
                        if (responses.success == true) {
                            return [true, '', ''];
                        } else {
                            return [false, responses.message];
                        }
                    }
                },
                {
                    //new record form
                    /*editData: {
                     MENU_PARENT: function () {
                     var data = grid_pks.jqGrid('getGridParam', 'postData');
                     return data.parent_id;
                     }
                     },*/
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
                            .wrapInner('<div class="widget-header" />');
                        style_edit_form(form);
                    },
                    beforeSubmit: function () {
                        var rowKeyLokasi = grid.jqGrid('getGridParam', 'selrow');
                        if (rowKeyLokasi) {
                            return [true];
                        } else {
                            return [false, 'Silahkan pilih row lokasi mitra !'];
                        }

                    },
                    onclickSubmit: function () {
                        var rowKeyLokasi = grid.jqGrid('getGridParam', 'selrow');
                        return {P_MP_LOKASI_ID: rowKeyLokasi};

                    },
                    afterSubmit: function (response, postdata) {
                        var responseText = response.responseText;
                        var responses = JSON.parse(responseText);
                        if (responses.success == true) {
                            return [true, '', ''];
                        } else {
                            return [false, responses.message];
                        }
                    }
                },
                {
                    //delete record form
                    recreateForm: true,
                    beforeShowForm: function (e) {
                        var form = $(e[0]);
                        if (form.data('styled')) return false;

                        form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />');
                        style_delete_form(form);

                        form.data('styled', true);
                    }

                    ,
                    onClick: function (e) {
                        //alert(1);
                    }
                }
                ,
                {
                    //search form
                    //closeAfterSearch: true,
                    recreateForm: true,
                    afterShowSearch: function (e) {
                        var form = $(e[0]);
                        form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />');
                        style_search_form(form);
                    }

                    ,
                    afterRedraw: function () {
                        style_search_filters($(this));
                    }

                    // multipleSearch: true
                    /**
                     multipleGroup:true,
                     showQuery: true
                     */
                }
                ,
                {
                    //view record form
                    recreateForm: true,
                    beforeShowForm: function (e) {
                        var form = $(e[0]);
                        form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
                    }
                }
            )
            ;

            function clearSelection() {
                grid_pks.jqGrid("clearGridData");
            }

            function style_edit_form(form) {
                //enable datepicker on "sdate" field and switches for "stock" field
                form.find('input[name=sdate]').datepicker({format: 'yyyy-mm-dd', autoclose: true});

                form.find('input[name=stock]').addClass('ace ace-switch ace-switch-5').after('<span class="lbl"></span>');
                //don't wrap inside a label element, the checkbox value won't be submitted (POST'ed)
                //.addClass('ace ace-switch ace-switch-5').wrap('<label class="inline" />').after('<span class="lbl"></span>');


                //update buttons classes
                var buttons = form.next().find('.EditButton .fm-button');
                buttons.addClass('btn btn-sm').find('[class*="-icon"]').hide();//ui-icon, s-icon
                buttons.eq(0).addClass('btn-primary').prepend('<i class="ace-icon fa fa-check"></i>');
                buttons.eq(1).prepend('<i class="ace-icon fa fa-times"></i>');

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
                var buttons = dialog.find('.EditTable');
                buttons.find('.EditButton a[id*="_reset"]').addClass('btn btn-sm btn-info').find('.ui-icon').attr('class', 'ace-icon fa fa-retweet');
                buttons.find('.EditButton a[id*="_query"]').addClass('btn btn-sm btn-inverse').find('.ui-icon').attr('class', 'ace-icon fa fa-comment-o');
                buttons.find('.EditButton a[id*="_search"]').addClass('btn btn-sm btn-purple').find('.ui-icon').attr('class', 'ace-icon fa fa-search');
            }

            function beforeDeleteCallback(e) {
                var form = $(e[0]);
                if (form.data('styled')) return false;

                form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />');
                style_delete_form(form);

                form.data('styled', true);
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

            function enableTooltips(table) {
                $('.navtable .ui-pg-button').tooltip({container: 'body'});
                $(table).find('.ui-pg-div').tooltip({container: 'body'});
            }
        });
    </script>