<div id="tbl_skema_calculate">
    <div class="row">
        <div class="col-xs-12">
            <table id="grid_calculate"></table>
            <div id="pager_calculate"></div>
        </div>

    </div>
    <br>
    <?php
    if ($method_id == 7 || $method_id == 9 || $method_id == 13) {
        $this->load->view('skema_bisnis/grid_tier', array("method_id" => $method_id, "commitment_id" => $commitment_id));
    }
    ?>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        /*var method_id = '<?php echo $method_id;?>';
         if(method_id == 7 || method_id == 9 || method_id == 13){
         alert('ada tier');
         }*/
        var grid = $("#grid_calculate");
        var pager = $("#pager_calculate");

        var parent_column = grid.closest('[class*="col-"]');
        $(window).on('resize.jqGrid', function () {
            grid.jqGrid('setGridWidth', $("#tbl_skema_calculate").width() - 5);
            pager.jqGrid('setGridWidth', $("#tbl_skema_calculate").width() - 5);
        })
        //optional: resize on sidebar collapse/expand and container fixed/unfixed
        $(document).on('settings.ace.jqGrid', function (ev, event_name, collapsed) {
            if (event_name === 'sidebar_collapsed' || event_name === 'main_container_fixed') {
                grid.jqGrid('setGridWidth', parent_column.width());
                pager.jqGrid('setGridWidth', parent_column.width());
            }
        })
        var width = $("#tbl_skema_calculate").width() - 5;
        grid.jqGrid({
            url: '<?php echo site_url('skema_bisnis/gridSkembis');?>',
            datatype: "json",
            mtype: "POST",
            postData: {
                pgl_id: <?php echo $pgl_id;?>,
                skema_id: <?php echo $skema_id;?>,
                periode: '<?php echo $periode;?>'
            },
            caption: "Skema bisnis calculate",
            colModel: [
                {
                    label: 'ID',
                    name: '',
                    key: true,
                    width: 5,
                    sorttype: 'number',
                    editable: false,
                    hidden: true
                },
                {
                    label: 'SCHM_FEE_ID',
                    name: 'SCHM_FEE_ID',
                    width: 5,
                    sorttype: 'number',
                    editable: false,
                    hidden: true
                },
                {
                    label: 'PGL_ID',
                    name: 'PGL_ID',
                    width: 5,
                    sorttype: 'number',
                    editable: false,
                    hidden: true
                },
                {
                    label: 'CF_ID',
                    name: 'CF_ID',
                    width: 5,
                    sorttype: 'number',
                    editable: false,
                    hidden: true
                },
                {
                    label: 'FLAG_CAL',
                    name: 'FLAG_CAL',
                    width: 5,
                    sorttype: 'number',
                    editable: false,
                    hidden: true
                },
                {
                    label: 'METHOD_ID',
                    name: 'METHOD_ID',
                    width: 5,
                    sorttype: 'number',
                    editable: false,
                    hidden: true
                },
                {
                    label: 'Nama Skema',
                    name: 'NAME',
                    width: 200,
                    align: "left",
                    editable: true
                },
                {
                    label: 'Nama Komponen',
                    name: 'CF_NAME',
                    width: 100,
                    align: "left",
                    editable: true,
                    editrules: {required: true},
                    editoptions: {size: 45}
                },
                {
                    label: 'Persentasi %',
                    name: 'PERCENTAGE',
                    width: 50,
                    align: "center",
                    // formatter: 'integer',
                    formatter: function (cellvalue, options, rowObject) {
                        var CF_NAME = rowObject.CF_NAME;
                        var PERCENTAGE = rowObject.PERCENTAGE;
                        if (CF_NAME == 'JML_FASTEL' || CF_NAME == 'NET_ARPU') {
                            return " - ";
                        }
                        else {
                            return Number(PERCENTAGE) + " %";
                        }
                    },
                    //formatoptions: {suffix: ' %'},
                    editoptions: {size: 45}
                },
                /* {
                 label: 'Jenis Skema',
                 name: 'REFERENCE_NAME',
                 width: 100,
                 align: "left",
                 sortable: true,
                 editable: true,
                 editoptions: {size: 45, value: {Tes: 'asdad'}},
                 hidden: false
                 },*/
                {
                    label: 'Net Revenue Skema',
                    name: 'NET_REVENUE',
                    width: 100,
                    align: "right",
                    //formatter: 'number',
                    formatter: function (cellvalue, options, rowObject) {
                        var CF_NAME = rowObject.CF_NAME;

                        if (CF_NAME == 'JML_FASTEL' || CF_NAME == 'NET_ARPU') {
                            return accounting.formatNumber(cellvalue, 0, "");
                        }
                        else {
                            //return  accounting.formatColumn(cellvalue,"Rp. ");
                            return accounting.formatMoney(cellvalue, "Rp. ", 2, ".", ",");
                        }
                    },

                    // formatter: 'currency',
                    // formatoptions: {prefix: 'Rp. ', thousandsSeparator:'.',decimalSeparator:',', decimalPlaces: 2},
                    sortable: true,
                    editable: true,
                    editoptions: {size: 45},
                    hidden: false
                },
                {
                    label: 'Gross Revenue',
                    name: 'GROSS_REVENUE',
                    width: 100,
                    align: "right",
                    summaryType: 'sum',
                    formatter: function (cellvalue, options, rowObject) {
                        Number.prototype.format = function (n, x, s, c) {
                            var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
                                num = this.toFixed(Math.max(0, ~~n));

                            return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
                        };

                        var CF_NAME = rowObject.CF_NAME;
                        if (CF_NAME == 'JML_FASTEL' || CF_NAME == 'NET_ARPU') {
                            return cellvalue;
                        }
                        else {
                            //return  accounting.formatColumn(cellvalue,"Rp. ");
                            return accounting.formatMoney(cellvalue, "Rp. ", 2, ".", ",");
                        }
                    },
                    // formatter: 'currency',
                    //formatoptions: {prefix: 'Rp. ', thousandsSeparator:'.',decimalSeparator:',', decimalPlaces: 2},
                    sortable: true,
                    editable: true,
                    editoptions: {size: 45},
                    hidden: false
                },
                {
                    label: 'Dibuat Oleh',
                    name: 'CREATED_BY',
                    width: 70,
                    align: "center",
                    sortable: true,
                    editable: true,
                    editrules: {number: true},
                    hidden: false
                },
                {
                    label: 'Tgl Buat',
                    name: 'CREATED_DATE',
                    width: 70,
                    align: "center",
                    sortable: true,
                    editable: true,
                    editrules: {number: true},
                    hidden: false
                }
            ],

            width: width,
            height: '100%',
            scrollOffset: 0,
            rowNum: 30,
            viewrecords: true,
            //rowList: [10, 25, 50],
            sortname: 'CF_ID', // default sorting ID
            //rownumbers: true, // show row numbers
            rownumWidth: 35,
            sortorder: 'asc',
            altRows: true,
            shrinkToFit: true,
            multiboxonly: true,
            onSortCol: clearSelection,
            onPaging: clearSelection,
            pager: '#pager_calculate',
            jsonReader: {
                root: 'Data',
                id: 'id',
                repeatitems: false
            },
            loadComplete: function () {
                grid.jqGrid('setGridWidth', $("#tbl_skema_calculate").width());
                pager.jqGrid('setGridWidth', $("#tbl_skema_calculate").width());
                var table = this;
                setTimeout(function () {
                    updatePagerIcons(table);
                    enableTooltips(table);
                }, 0);
            },
            grouping: true,
            groupingView: {
                groupField: ["NAME"],
                groupColumnShow: [false],
                groupText: ["<b>{0}</b>"],
                groupOrder: ["asc"],
                groupSummary: [false],
                groupCollapse: false

            }


        });


        //navButtons grid master
        grid.jqGrid('navGrid', '#pager_calculate',
            { 	//navbar options
                edit: false,
                excel: false,
                editicon: 'ace-icon fa fa-pencil blue',
                add: false,
                addicon: 'ace-icon fa fa-plus-circle purple',
                del: false,
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
            var PGL_ID = grid.jqGrid('getCell', rowKey, 'PGL_ID');
            var SCHM_FEE_ID = grid.jqGrid('getCell', rowKey, 'SCHM_FEE_ID');
            var CF_ID = grid.jqGrid('getCell', rowKey, 'CF_ID');
            var METHOD_ID = grid.jqGrid('getCell', rowKey, 'METHOD_ID');
            var FLAG_CAL = grid.jqGrid('getCell', rowKey, 'FLAG_CAL');
            /*alert(FLAG_CAL);
             return false;*/
            if (rowKey) {
                if (FLAG_CAL == 'Y') {
                    swal('', 'Data ini tidak bisa diedit karena sudah diproses !', 'warning')
                } else {
                    $.ajax({
                        // async: false,
                        url: "<?php echo base_url();?>skema_bisnis/edit_skemabisnis",
                        type: "POST",
                        data: {PGL_ID: PGL_ID, SCHM_FEE_ID: SCHM_FEE_ID, CF_ID: CF_ID, METHOD_ID: METHOD_ID},
                        success: function (data) {
                            $("#main_content").html(data);
                            /*$.post("<?php echo site_url('parameter/gridMapPIC');?>",
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
                             );*/

                            $("#tbl_pic").hide("slow");
                            $("#form_pic").show("slow");


                        }
                    });
                }

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