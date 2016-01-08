<div id="dokPKS">
    <form class="form-horizontal" role="form">
        <div class="rows">
            <div class="form-group">
                <label class="col-sm-1 control-label no-padding-right" for="form-field-1"> Periode </label>
                <div class="col-sm-2">
                    <select name="bulan" class="form-control">
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
                    <select class="form-control" name="tahun">
                        <option value=""> Tahun</option>
                        <?php
                        $year = date("Y");
                        for ($i = ($year); $i >= $year - 5; $i--) {
                            echo "<option value=$i>$i</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-1 control-label no-padding-right" for="form-field-1"> </label>
                <div class="col-sm-11">
                    <a id="cancelUpload" class="btn btn-xs btn-info">
                            <i class="ace-icon fa fa-plus bigger-110"></i>
                            Add Fastel
                        </a>
                    <a id="submitForm" class="btn btn-xs btn-info">
                            <i class="ace-icon fa fa-upload bigger-110"></i>
                            Upload Fastel
                        </a>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-1 control-label no-padding-right" for="form-field-1"> </label>
                <div class="col-sm-11">
                    <div id="notif"></div>
                    <table id="grid-table" bgcolor="#00FF00"></table>
                    <div id="grid-pager"></div>

                </div>
            </div>

            <div>
                <hr>
            </div>

            <div class="form-group">
                <label class="col-sm-1 control-label no-padding-right" for="form-field-1"> </label>
                <div class="col-sm-11">
                    <a id="cancelUpload" class="btn btn-xs btn-info">
                        <i class="ace-icon fa fa-plus bigger-110"></i>
                        Add No Akun
                    </a>
                    <a id="submitForm" class="btn btn-xs btn-info">
                        <i class="ace-icon fa fa-upload bigger-110"></i>
                        Upload No Akun
                    </a>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-1 control-label no-padding-right" for="form-field-1"> </label>
                <div class="col-sm-11">
                    <div id="notif"></div>
                    <table id="grid-table2" bgcolor="#00FF00"></table>
                    <div id="grid-pager2"></div>
                    <br>
                    Page render in <?php echo $this->benchmark->elapsed_time(); ?> seconds
                </div>
            </div>
        </div>
    </form>

</div>


<script type="text/javascript">

$(document).ready(function () {
    var grid_selector = "#grid-table";
    var pager_selector = "#grid-pager";

    //resize to fit page size
    $(window).on('resize.jqGrid', function () {
        $(grid_selector).jqGrid('setGridWidth', $("#contentJgGrid").width());
    });
    var datas = [
        { nofastel: "1234", total: "1000", abonemen: "6000", diskon: "2500", lokal: "20000", sljj: "1000", stb: "210.00", flag: "Lunas" },
        { nofastel: "2345", total: "2000", abonemen: "7000", diskon: "3500", lokal: "30000", sljj: "2000", stb: "320.00", flag: "Lunas"},
        { nofastel: "3577", total: "3000", abonemen: "8000", diskon: "4500", lokal: "40000", sljj: "3000", stb: "430.00", flag: "Lunas"}
    ];
    jQuery("#grid-table").jqGrid({
        datatype: "local",
        data: datas,
        colModel: [
            { label: 'NO FASTEL ', name: 'nofastel', width: 110, align: "left", hidden: false},
            { label: 'TOTAL TAGIHAN', name: 'total', width: 100, align: "right", editable: true},
            { label: 'ABONEMEN', name: 'abonemen', width: 100, align: "right", editable: true},
            { label: 'DISKON M4L', name: 'diskon', width: 130, align: "right", editable: true},
            { label: 'LOKAL', name: 'lokal', width: 60, align: "right", editable: true},
            { label: 'SLJJ', name: 'sljj', width: 60, align: "center", editable: true},
            { label: 'STB', name: 'stb', width: 60, align: "center", editable: true},
            { label: 'FLAG', name: 'flag', width: 100, align: "center", editable: true}

        ],
        width: '100%',
        height: '100%',
        scrollOffset: 0,
        rowNum: 10,
        viewrecords: true,
        rowList: [10, 20, 50],
        sortname: 'FASTEL', // default sorting ID
        rownumbers: true, // show row numbers
        rownumWidth: 35, // the width of the row numbers columns
        sortorder: 'asc',
        altRows: true,
        shrinkToFit: true,
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
        afterRefresh: function () {
        },
        refreshicon: 'ace-icon fa fa-refresh green',
        view: false,
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

//            multipleSearch: true,
        //           showQuery: true
        /**
         multipleGroup:true,
         showQuery: true
         */
    },
    {
        //view record form
        recreateForm: true,
        beforeShowForm: function (e) {
            var form = $(e[0]);
            form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
        }
    }
).navButtonAdd('#grid-pager', {
        caption: "",
        buttonicon: "ace-icon fa-file-excel-o green",
        position: "last",
        title: "Export To Excel",
        cursor: "pointer",
        id: "reset"
    });


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

    //resize to fit page size
    $(window).on('resize.jqGrid', function () {
        $(grid_selector).jqGrid('setGridWidth', $("#contentJgGrid").width());
    });
    var data = [
        { nofastel: "3577", total: "3000", abonemen: "8000", diskon: "4500", flag: "Lunas"},
        { nofastel: "1234", total: "1000", abonemen: "6000", diskon: "2500", flag: "Lunas" },
        { nofastel: "2345", total: "2000", abonemen: "7000", diskon: "3500", flag: "Lunas"}
    ];
    jQuery("#grid-table2").jqGrid({
        datatype: "local",
        data: data,
        colModel: [
            { label: 'NO AKUN ', name: 'nofastel', width: 110, align: "left", hidden: false},
            { label: 'TOTAL TAGIHAN', name: 'total', width: 100, align: "right", editable: true},
            { label: 'ABONEMEN', name: 'abonemen', width: 100, align: "right", editable: true},
            { label: 'DISKON', name: 'diskon', width: 130, align: "right", editable: true},
            { label: 'RESTITUSI', name: 'lokal', width: 60, align: "right", editable: true},
            { label: 'FLAG BAYAR', name: 'flag', width: 100, align: "center", editable: true}

        ],
        width: '100%',
        height: '100%',
        scrollOffset: 0,
        rowNum: 10,
        viewrecords: true,
        rowList: [10, 20, 50],
        sortname: 'FASTEL', // default sorting ID
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
        afterRefresh: function () {
        },
        refreshicon: 'ace-icon fa fa-refresh green',
        view: false,
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
).navButtonAdd('#grid-pager2', {
        caption: "",
        buttonicon: "ace-icon fa-file-excel-o green",
        position: "last",
        title: "Export To Excel",
        cursor: "pointer",
        id: "reset"
    });


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