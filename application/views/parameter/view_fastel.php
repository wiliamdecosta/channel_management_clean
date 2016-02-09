<div id="content">
    <div class="breadcrumbs" id="breadcrumbs">
        <?= $this->breadcrumb; ?>
    </div>
    <!-- /section:basics/content.breadcrumbs -->
    <div class="page-content">

        <div class="row">
            <div class="col-xs-12">

                <div class="row">
                    <div class="vspace-12-sm"></div>
                    <div class="col-sm-12">
                        <div class="widget-box transparent">
                            <div class="widget-header red widget-header-flat">
                                <h4 class="widget-title lighter">
                                    FASTEL
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
                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                                           value="<?php echo
                                           $this->security->get_csrf_hash(); ?>">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <label class="col-sm-1 control-label no-padding-right"
                                                       for="form-field-1-1"> Pengelola </label>
                                                <div class="col-sm-3">
                                                    <select class="form-control" id="mitra" name="pengelola">
                                                        <option value="">Pilih Pengelola</option>
                                                        <?php foreach ($result as $content) {
                                                            echo "<option value='" . $content->PGL_ID . "'>" . $content->PGL_NAME . "</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <!--                                                <a id="show"-->
                                                <!--                                                   class="fm-button ui-state-default ui-corner-all fm-button-icon-right ui-reset btn btn-sm btn-info">-->
                                                <!--                                                    <span class="ace-icon fa fa-search"></span>Show</a>-->
                                            </div>
                                        </div>
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <label class="col-sm-1 control-label no-padding-right"
                                                       for="form-field-1"> Tenant </label>

                                                <div class="col-sm-3">
                                                    <select class="form-control" id="list_cc" name="tenant">
                                                        <option value="">Pilih Tenant</option>
                                                    </select>
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
        <div id="tab-content">
            <div class="col-sm-8">
                <div id="btn_add_update" style="float: left;">
                    <a id="add_fastel" class="btn btn-white btn-sm btn-round">
                        <i class="ace-icon fa fa-plus green"></i>
                        Add Fastel
                    </a>
                    <a id="update_fastel" class="btn btn-white btn-sm btn-round">
                        <i class="ace-icon fa fa-upload green"></i>
                        Update Fastel
                    </a>
                </div>
            </div>
            <br>
            <div class="col-xs-12" id="tabel_content">
                <br>
                <table id="grid-table"></table>
                <div id="grid-pager"></div>
            </div><!-- /.col -->
        </div>
    </div><!-- /.col -->
</div><!-- /.row
</div><!-- /.page-content -->
<div id="upload_fastel">

</div>

<!-- #section:basics/content.breadcrumbs -->
<!--<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>-->
<script type="text/javascript">
    $(document).ready(function () {

        $('#show').click(function () {
            var mitra = $("#mitra").val();
            var tenant = $("#list_cc").val();

            if (!mitra) {
                return false;
            }

            $.ajax({
                url: '<?php echo site_url('parameter/show_fastel');?>',
                data: {ten_id: tenant},
                type: 'POST',
                success: function (data) {
                    $('#tab-content').html(data);
                }
            });
        })
    })

    $("#mitra").change(function () {
        var mitra = $("#mitra").val();
        if (mitra) {
            $.ajax({
                type: "POST",
                dataType: "html",
                url: "<?php echo site_url('cm/listTenant');?>",
                data: {id_mitra: mitra},
                success: function (msg) {
                    if (msg == '') {
                        alert('Tidak ada tenant');
                        $("#list_cc").html('<option value="">Pilih Tenant</option>');

                    }
                    else {
                        $("#list_cc").html(msg);
                        var grid = jQuery("#grid-table");
                        var ten_id = $("#list_cc").val();
                        var postdata = grid.jqGrid('getGridParam', 'postData');
                        $.extend(postdata, {ten_id: ten_id});
                        grid.trigger("reloadGrid", [{page: 1}]);

                    }
                }
            });
        } else {
            $("#list_cc").html('<option value="">Pilih Tenant</option>');
        }

    });

    $("#list_cc").change(function () {
        var ten_id = $("#list_cc").val();
        if (ten_id) {
            var grid = jQuery("#grid-table");
            var ten_id = $("#list_cc").val();
            var postdata = grid.jqGrid('getGridParam', 'postData');
            $.extend(postdata, {ten_id: ten_id});
            grid.trigger("reloadGrid", [{page: 1}]);
        } else {
            alert('Tenant tidak ada');
            return false;
        }
    });

    $("#add_fastel").click(function () {
        $.ajax({
            // async: false,
            url: "<?php echo base_url();?>parameter/modalUploadFastel",
            type: "POST",
            data: {upload_param:1},
            success: function (data) {
                $('#upload_fastel').html(data);
                $('#modal_upload_fastel').modal('show');
            }
        });
    })
    $("#update_fastel").click(function () {
        $.ajax({
            // async: false,
            url: "<?php echo base_url();?>parameter/modalUploadFastel",
            type: "POST",
            data: {upload_param:2},
            success: function (data) {
                $('#upload_fastel').html(data);
                $('#modal_upload_fastel').modal('show');
            }
        });
    })
</script>

<script type="text/javascript">
    $(document).ready(function () {
        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";
        var ten_id = $("#list_cc").val();
        var date = '<?= date("d/m/Y");?>';
        jQuery("#grid-table").jqGrid({
            postData: {ten_id: ten_id},
            url: '<?php echo site_url('parameter/gridFastel');?>',
            datatype: "json",
            mtype: "POST",
            caption: "List Fastel",
            colModel: [
                {
                    label: 'ND',
                    name: 'ND',
                    key: true,
                    width: 200,
                    sortable: true,
                    editable: true,
                    editrules: {required: true},
                    hidden: false
                },
                {
                    label: 'TEN_ID',
                    name: 'TEN_ID',
                    width: 200,
                    sortable: true,
                    editable: false,
                    hidden: true
                },
                {
                    label: 'Aktif',
                    name: 'AKTIF',
                    width: 100,
                    align: "left",
                    sortable: true,
                    editable: true,
                    editrules: {required: true},
                    edittype: "select",
                    editoptions: {
                        value: "1:Aktif;0:Tidak aktif"
                    }
                },
                {
                    label: 'Valid From',
                    name: 'VALID_FROM',
                    width: 100,
                    align: "left",
                    sortable: true,
                    // sorttype: "date",
                    editable: true,
                    editoptions: {
                        // dataInit is the client-side event that fires upon initializing the toolbar search field for a column
                        // use it to place a third party control to customize the toolbar
                        dataInit: function (element) {
                            $(element).datepicker({
                                autoclose: true,
                                format: 'dd-M-yy',
                                orientation: 'bottom',
                                todayHighlight: true,
                            });
                        },
                        // readonly: "readonly"
                    },
                    hidden: false
                },
                {
                    label: 'Valid To',
                    name: 'VALID_TO',
                    width: 100,
                    align: "left",
                    sortable: true,
                    editable: true,
                    editoptions: {
                        // dataInit is the client-side event that fires upon initializing the toolbar search field for a column
                        // use it to place a third party control to customize the toolbar
                        dataInit: function (element) {
                            $(element).datepicker({
                                autoclose: true,
                                format: 'dd-M-yy',
                                //format: 'yyyy-mm-dd',
                                orientation: 'bottom',
                                todayHighlight: true,
                            });
                        },
                        // readonly: "readonly"
                    },
                    hidden: false
                },
                {
                    label: 'Tanggal Diubah',
                    name: 'CREATED_DATE',
                    width: 105,
                    align: "left",
                    sortable: true,
                    editable: false,
                    hidden: false
                },
                {
                    label: 'Diubah Oleh',
                    name: 'CREATED_BY',
                    width: 110,
                    align: "left",
                    sortable: true,
                    editable: false,
                    hidden: false
                },
                {
                    label: 'TEN_ID',
                    name: 'TEN_ID',
                    width: 90,
                    align: "left",
                    editable: true,
                    hidden: true,
                    editoption: {}
                }
            ],
            // width: '100%',
            height: '100%',
            scrollOffset: 0,
            rowNum: 5,
            viewrecords: true,
            rowList: [5, 10, 20],
            sortname: 'ND', // default sorting ID
            rownumbers: true, // show row numbers
            rownumWidth: 35, // the width of the row numbers columns
            sortorder: 'asc',
            altRows: true,
            shrinkToFit: true,
            multiboxonly: true,
            onSelectRow: function (rowid) {

            }, // use the onSelectRow that is triggered on row click to show a details grid
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
                $(grid_selector).jqGrid('setGridWidth', $("#tabel_content").width());
                $(pager_selector).jqGrid('setGridWidth', $("#tabel_content").width());

                var table = this;
                setTimeout(function () {
                    //  styleCheckbox(table);

                    //  updateActionIcons(table);
                    updatePagerIcons(table);
                    enableTooltips(table);
                }, 0);
            },
            editurl: '<?php echo site_url('parameter/crud_fastel');?>'


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
                // some code here
                jQuery("#detailsPlaceholder").hide();
            },
            refreshicon: 'ace-icon fa fa-refresh green',
            view: false,
            viewicon: 'ace-icon fa fa-search-plus grey',
        },
        {
            // options for the Edit Dialog
            closeAfterEdit: true,
            width: 500,
            errorTextFormat: function (data) {
                return 'Error: ' + data.responseText
            },
            recreateForm: true,
            beforeShowForm: function (e) {
                $("#TEN_ID").prop("readonly", true);
                var form = $(e[0]);
                form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
                style_edit_form(form);
                $("#ND").prop("readonly", true);
            }
        },
        {
            //new record form
            width: 500,
            postData: {tes: "aa"},
            errorTextFormat: function (data) {
                return 'Error: ' + data.responseText
            },
            closeAfterAdd: true,
            recreateForm: true,
            viewPagerButtons: false,
            beforeShowForm: function (e) {
                var form = $(e[0]);
                form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar')
                    .wrapInner('<div class="widget-header" />')
                style_edit_form(form);
            },
            beforeSubmit: function () {
                var ten_id = $("#list_cc").val();
                if (ten_id) {
                    return [true];
                } else {
                    return [false, 'Tenant belum dipilih !'];
                }

            },
            onclickSubmit: function () {
                var ten_id = $("#list_cc").val();
                return {TEN_ID: ten_id};
            }
        },
        {
            //delete record form
            recreateForm: true,
           // msg : "tes",
           // width : 700,
            beforeShowForm: function (e) {
                var form = $(e[0]);
                if (form.data('styled')) return false;

                form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
                style_delete_form(form);

                form.data('styled', true);
            },
            onclickSubmit: function () {
                var gr = jQuery("#grid-table").jqGrid('getGridParam', 'selrow');
                var ten_id = jQuery('#grid-table').jqGrid('getCell', gr, 'TEN_ID');
                var nd = jQuery('#grid-table').jqGrid('getCell', gr, 'ND');
                return {TEN_ID: ten_id, ND: nd};

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
            }

            ,
            afterRedraw: function () {
                style_search_filters($(this));
            }

//            multipleSearch: true,
            //           showQuery: true
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


    function clearSelection() {
        //jQuery("#jqGridDetails").jqGrid('setGridParam',{url: "empty.json", datatype: 'json'}); // the last setting is for demo purpose only
        jQuery("#jqGridDetails").jqGrid('setCaption', 'Menu Child ::');
        jQuery("#jqGridDetails").trigger("reloadGrid");

    }

    function style_edit_form(form) {
        //enable datepicker on "sdate" field and switches for "stock" field
        //  form.find('input[name=VALID_FROM]').datepicker({format: 'yyyy-mm-dd', autoclose: true})

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