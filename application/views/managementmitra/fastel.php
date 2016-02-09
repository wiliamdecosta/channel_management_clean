<div id="dokPKS">
    <form class="form-horizontal" role="form">
        <div class="row form-group">
            <div class="col-sm-12">
                <div class="col-sm-2">
                    <select name="bulan" class="form-control" id="bulan">
                        <option selected="selected" value="">Bulan</option>
                        <?php
                        $bln = array(1 => "Januari", "Februari", "Maret", "April", "Mei", "Juni", "July", "Agustus", "September", "Oktober", "November", "Desember");
                        for ($bulan = 1; $bulan <= 12; $bulan++) {
                            if ($bulan <= 9) {
                                echo "<option value='0$bulan'>$bln[$bulan]</option>";
                            } else {
                                echo "<option value='$bulan'>$bln[$bulan]</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="col-sm-1">
                    <select class="form-inline" name="tahun" id="tahun">
                        <option value=""> Tahun</option>
                        <?php
                        $year = date("Y");
                        for ($i = ($year); $i >= $year - 5; $i--) {
                            echo "<option value=$i>$i</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-sm-1">
                    <a class="fm-button ui-state-default ui-corner-all fm-button-icon-right ui-reset btn btn-sm btn-info"
                       id="filter_cari">
                        <span class="ace-icon fa fa-search"></span>Cari</a>
                </div>
                <!--                <div class="col-sm-8">-->
                <!--                    <div id="btn_add_update" style="float: right;">-->
                <!--                        <a id="add_fastel" class="btn btn-white btn-sm btn-round">-->
                <!--                            <i class="ace-icon fa fa-plus green"></i>-->
                <!--                            Add Fastel-->
                <!--                        </a>-->
                <!--                        <a id="update_fastel" class="btn btn-white btn-sm btn-round">-->
                <!--                            <i class="ace-icon fa fa-upload green"></i>-->
                <!--                            Update Fastel-->
                <!--                        </a>-->
                <!--                    </div>-->
                <!--                </div>-->
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-11">
                <div id="notif"></div>
                <table id="grid-table" bgcolor="#00FF00"></table>
                <div id="grid-pager"></div>

            </div>
        </div>
        <hr>
        <div class="form-group">
            <div class="col-sm-11">
                <table id="grid-table2" bgcolor="#00FF00"></table>
                <div id="grid-pager2"></div>
            </div>
        </div>
    </form>
</div>


<script type="text/javascript">

    $(document).ready(function () {

        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";

        jQuery("#grid-table").jqGrid({
            url: "<?php echo site_url(); ?>managementmitra/gridFastel/<?php echo $periode;?>/261/2933",
            datatype: "json",
            mtype: "POST",
            colModel: [
                //{ label: 'ID', name: 'USER_ID', key: true, width:5, sorttype:'number', editable: true,hidden:true },
                {
                    label: 'ND',
                    name: 'ND1',
                    width: 110,
                    frozen: true,
                    align: "left",
                    editable: true,
                    editrules: {required: true}
                },
                {label: 'Created Date', name: 'CREATED_DATE', width: 100, align: "right", editable: true},
                {label: 'Valid From', name: 'VALID_FROM', width: 100, align: "right", editable: true},
                {
                    label: 'Status',
                    name: 'CPROD',
                    width: 110,
                    frozen: true,
                    align: "left",
                    editable: true,
                    formatter: function (cellvalue, options, rowObject) {
                        var status = rowObject.CPROD;
                        if (status == '1') {
                            return "Aktif";
                        }
                        else {
                            return "Tidak Aktif";
                        }
                    }
                },
                {
                    label: 'NAMA PLG',
                    name: 'NOM',
                    width: 250,
                    frozen: true,
                    align: "left",
                    editable: true,
                    editrules: {required: true}
                },
                {label: 'ABONEMEN', name: 'ABONEMEN', formatter: 'integer', width: 100, align: "right", editable: true},
                {label: 'KREDIT', name: 'MNT_TCK_C', formatter: 'integer', width: 100, align: "right", editable: true},
                {label: 'DEBET', name: 'MNT_TCK_D', formatter: 'integer', width: 100, align: "right", editable: true},
                {label: 'LOKAL', name: 'LOKAL', formatter: 'integer', width: 100, align: "right", editable: true},
                {
                    label: 'INTERLOKAL',
                    name: 'INTERLOKAL',
                    formatter: 'integer',
                    width: 100,
                    align: "right",
                    editable: true
                },
                {label: 'SLJJ', name: 'SLJJ', formatter: 'integer', width: 100, align: "right", editable: true},
                {label: 'SLI007', name: 'SLI007', formatter: 'integer', width: 100, align: "right", editable: true},
                {label: 'SLI001', name: 'SLI001', formatter: 'integer', width: 100, align: "right", editable: true},
                {label: 'SLI008', name: 'SLI008', formatter: 'integer', width: 100, align: "right", editable: true},
                {label: 'SLI009', name: 'SLI009', formatter: 'integer', width: 100, align: "right", editable: true},
                {
                    label: 'TELKOM GLOBAL 017',
                    name: 'SLI_017',
                    formatter: 'integer',
                    width: 100,
                    align: "right",
                    editable: true
                },
                {
                    label: 'TELKOMNET INSTAN',
                    name: 'TELKOMNET_INSTAN',
                    formatter: 'integer',
                    width: 100,
                    align: "right",
                    editable: true
                },
                {label: 'STB', name: 'STB', formatter: 'integer', width: 100, align: "right", editable: true},
                {label: 'STB TSL', name: 'STB_TSL', formatter: 'integer', width: 100, align: "right", editable: true},
                {label: 'STB EXL', name: 'STB_EXL', formatter: 'integer', width: 100, align: "right", editable: true},
                {label: 'STB HCP', name: 'STB_HCP', formatter: 'integer', width: 100, align: "right", editable: true},
                {label: 'STB INM', name: 'STB_INM', formatter: 'integer', width: 100, align: "right", editable: true},
                {
                    label: 'STB OTHERS',
                    name: 'STB_OTHERS',
                    formatter: 'integer',
                    width: 100,
                    align: "right",
                    editable: true
                },
                {
                    label: 'EXPENSE SLI',
                    name: 'EXPENSE_SLI',
                    formatter: 'integer',
                    width: 100,
                    align: "right",
                    editable: true
                },
                {
                    label: 'EXPENSE IN',
                    name: 'EXPENSE_IN',
                    formatter: 'integer',
                    width: 100,
                    align: "right",
                    editable: true
                },
                {label: 'PAY TV', name: 'PAY_TV', formatter: 'integer', width: 100, align: "right", editable: true},
                {label: 'JAPATI', name: 'JAPATI', formatter: 'integer', width: 100, align: "right", editable: true},
                {
                    label: 'SPEEDY USAGE',
                    name: 'USAGE_SPEEDY',
                    formatter: 'integer',
                    width: 100,
                    align: "right",
                    editable: true
                },
                {
                    label: 'NON JASTEL',
                    name: 'NON_JASTEL',
                    formatter: 'integer',
                    width: 100,
                    align: "right",
                    editable: true
                },
                {
                    label: 'ISDN DATA',
                    name: 'ISDN_DATA',
                    formatter: 'integer',
                    width: 100,
                    align: "right",
                    editable: true
                },
                {
                    label: 'ISDN VOICE',
                    name: 'ISDN_VOICE',
                    formatter: 'integer',
                    width: 100,
                    align: "right",
                    editable: true
                },
                {label: 'KONTEN', name: 'KONTEN', formatter: 'integer', width: 100, align: "right", editable: true},
                {
                    label: 'PORTWHOLESALES',
                    name: 'PORTWHOLESALES',
                    formatter: 'integer',
                    width: 100,
                    align: "right",
                    editable: true
                },
                {label: 'METERAI', name: 'METERAI', formatter: 'integer', width: 100, align: "right", editable: true},
                {label: 'PPN', name: 'PPN', formatter: 'integer', width: 100, align: "right", editable: true},
                {
                    label: 'LAIN LAIN',
                    name: 'LAIN_LAIN',
                    formatter: 'integer',
                    width: 100,
                    align: "right",
                    editable: true
                },
                {
                    label: 'TOTAL RINCIAN',
                    name: 'TOTAL',
                    formatter: 'integer',
                    width: 150,
                    align: "right",
                    editable: true
                },
                {
                    label: 'GRAND TOTAL',
                    name: 'GRAND_TOTAL',
                    formatter: 'integer',
                    width: 150,
                    align: "right",
                    editable: true
                },
                {label: 'KURS', name: 'KURS', width: 100, align: "left", editable: true},
                {label: 'STATUS PEMBAYARAN', name: 'STATUS_PEMBAYARAN', width: 120, align: "left", editable: true},
                {label: 'TGL BAYAR', name: 'TGL_BYR', width: 100, align: "left", editable: true}
            ],
            //width: '100%',
            height: '100%',
            scrollOffset: 0,
            rowNum: 10,
            viewrecords: true,
            rowList: [10, 20, 50],
            sortname: 'ND1', // default sorting ID
            rownumbers: true, // show row numbers
            rownumWidth: 35, // the width of the row numbers columns
            sortorder: 'asc',
            altRows: true,
            shrinkToFit: false,
            multiboxonly: true,
            onSortCol: clearSelection,
            onPaging: clearSelection,
            //#pager merupakan div id pager
            pager: '#grid-pager',
            jsonReader: {
                root: 'Data',
                id: 'id',
                repeatitems: false
            },
            loadComplete: function () {
                $(grid_selector).jqGrid('setGridWidth', $("#main_content").width());
                $(pager_selector).jqGrid('setGridWidth', $("#main_content").width());
                var table = this;
                setTimeout(function () {
                    //  styleCheckbox(table);

                    //  updateActionIcons(table);
                    updatePagerIcons(table);
                    enableTooltips(table);
                }, 0);
            },
            caption: "Fastel Phone"

        });
    });
    //navButtons grid master
    jQuery('#grid-table').jqGrid('navGrid', '#grid-pager',
        { 	//navbar options
            edit: false,
            editicon: 'ace-icon fa fa-pencil blue',
            add: false,
            addicon: 'ace-icon fa fa-plus-circle purple',
            del: false,
            delicon: 'ace-icon fa fa-trash-o red',
            search: true,
            searchicon: 'ace-icon fa fa-search orange',
            refresh: false,
            afterRefresh: function () {
            },
            refreshicon: 'ace-icon fa fa-refresh green',
            view: true,
            viewicon: 'ace-icon fa fa-search-plus grey'
        },
        {
            // options for the Edit Dialog
            closeAfterEdit: true,
            width: 500,
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
            width: 500,
            recreateForm: true,
            afterShowSearch: function (e) {
                var form = $(e[0]);
                form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
                style_search_form(form);
            },
            afterRedraw: function () {
                style_search_filters($(this));
            }

//            multipleSearch: true,
            //           showQuery: true
            /**
             multipleGroup:true,
             showQuery: true
             */
        },
        {
            //view record form
            width: 500,
            recreateForm: true,
            beforeShowForm: function (e) {
                var form = $(e[0]);
                form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
            }
        }
    );


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

</script>
<script type="text/javascript">
    $(document).ready(function () {
        var grid_selector = "#grid-table2";
        var pager_selector = "#grid-pager2";

        var data = [
            {nofastel: "3577", total: "3000", abonemen: "8000", diskon: "4500", flag: "Lunas"},
            {nofastel: "1234", total: "1000", abonemen: "6000", diskon: "2500", flag: "Lunas"},
            {nofastel: "2345", total: "2000", abonemen: "7000", diskon: "3500", flag: "Lunas"}
        ];
        jQuery("#grid-table2").jqGrid({
            datatype: "local",
            data: data,
            colModel: [
                {label: 'NO AKUN ', name: 'nofastel', width: 200, align: "left", hidden: false},
                {label: 'TOTAL TAGIHAN', name: 'total', width: 200, align: "right", editable: true},
                {label: 'ABONEMEN', name: 'abonemen', width: 200, align: "right", editable: true},
                {label: 'DISKON', name: 'diskon', width: 200, align: "right", editable: true},
                {label: 'RESTITUSI', name: 'lokal', width: 200, align: "right", editable: true},
                {label: 'FLAG BAYAR', name: 'flag', width: 200, align: "center", editable: true}

            ],
            //width: '100%',
            height: '100%',
            scrollOffset: 0,
            rowNum: 10,
            viewrecords: true,
            rowList: [10, 20, 50],
            sortname: 'nofastel', // default sorting ID
            rownumbers: true, // show row numbers
            rownumWidth: 35, // the width of the row numbers columns
            sortorder: 'asc',
            altRows: true,
            shrinkToFit: false,
            multiboxonly: true,
            onSortCol: clearSelection,
            onPaging: clearSelection,
            //#pager merupakan div id pager
            pager: '#grid-pager2',
            jsonReader: {
                root: 'Data',
                id: 'id',
                repeatitems: false
            },
            loadComplete: function () {
                $(grid_selector).jqGrid('setGridWidth', $("#main_content").width());
                $(pager_selector).jqGrid('setGridWidth', $("#main_content").width());
                var table = this;
                setTimeout(function () {
                    //  styleCheckbox(table);

                    //  updateActionIcons(table);
                    updatePagerIcons(table);
                    enableTooltips(table);
                }, 0);
            },
            caption: "Fastel Datin"

        });
    });
    //navButtons grid master
    jQuery('#grid-table2').jqGrid('navGrid', '#grid-pager2',
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
            refresh: false,
            afterRefresh: function () {
            },
            refreshicon: 'ace-icon fa fa-refresh green',
            view: true,
            viewicon: 'ace-icon fa fa-search-plus grey'
        },
        {
            // options for the Edit Dialog
            closeAfterEdit: true,
            width: 500,
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
            recreateForm: true,
            beforeShowForm: function (e) {
                var form = $(e[0]);
                form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
            }
        }
    );


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



</script>
<script>
    $("#filter_cari").click(function(){
        var grid = jQuery("#grid-table");
        var bulan = $("#bulan").val();
        var tahun = $("#tahun").val();
        var periode = tahun+""+bulan;
        if(bulan && tahun){
            var postdata = grid.jqGrid('getGridParam','postData');
            $.extend(postdata,{periode:periode});
            //grid.jqGrid('setGridParam', { search: text.length>0, postData: postdata });
            grid.trigger("reloadGrid",[{page:1}]);
        }else{
            alert('Bulan dan tahun harus dipilih !');
            return false;
        }
    });

</script>