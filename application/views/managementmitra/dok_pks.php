<?php $prv = getPrivilege($menu_id); ?>
<div id="dok_pks">
    <form class="form-horizontal" role="form">
        <div class="row">
            <div class="col-xs-12">
                <div class="form-group">
                    <div class="col-sm-4">
                        <?php echo buatcombo("list_pks", "list_pks", "P_MP_PKS", "NO_PKS", "P_MP_PKS_ID", array('P_MP_LOKASI_ID' => $P_MP_LOKASI_ID), "Pilih PKS"); ?>
                    </div>
                    <a id="cari_pks"
                       class="fm-button ui-state-default ui-corner-all fm-button-icon-right ui-reset btn btn-sm btn-info">
                        <span class="ace-icon fa fa-search"></span>Cari</a>
                </div>
                <?php if($prv['UPLOAD'] == "Y"){ ;?>
                <div id="btn_add_update" class="form-group">
                    <div class="col-sm-4">
                        <a id="add_pks" class="btn btn-white btn-sm btn-round">
                            <i class="ace-icon fa fa-plus green"></i>
                            Upload Dokumen
                        </a>
                    </div>
                    <div class="col-sm-4">
                    </div>
                </div>
                <?php };?>
                <div class="form-group">
                    <div class="col-sm-11">
                        <div class="row">
                            <div class="col-xs-12">
                                <div id="jqgrid">
                                    <table id="grid-table"></table>
                                    <div id="grid-pager"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div id="div_pks" style="display: none;">
    <div id="" style="margin-top: 20px;" class="row">
        <div class="col-xs-12">
            <div class="well well-sm"><h4 id="pks_form_title" class="blue">Add/Edit PKS</h4></div>
            <form class="form-horizontal" role="form" id="form_pks" method="post" enctype="multipart/form-data"
                  accept-charset="utf-8">
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Nomor PKS</label>
                    <div class="col-sm-8">
                        <input type="text" id="form_pks_name" name="form_pks_name" placeholder="Pilih PKS"
                               class="col-xs-10 col-sm-5 required" readonly="readonly" required>
                        <input type="hidden" id="form_p_mp_pks_id" name="form_p_mp_pks_id" readonly="readonly" required>

                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                               value="<?php echo $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" name="oper" id="oper">
                        <input type="hidden" id="form_p_pks_id" name="form_p_pks_id" required>
                    <span class="input-group-btn">
                        <button class="btn btn-warning btn-sm" type="button" id="btn_lov_pks">
                            <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                        </button>
                    </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right"> Nama Dokumen </label>
                    <div class="col-sm-9">
                        <input type="text" id="form_doc_name" name="form_doc_name" placeholder="Input Nama Dokumen"
                               class="col-xs-10 col-sm-5 required" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right"> File Dok </label>
                    <div class="col-sm-4">
                        <input type="file" id="filename" name="filename"/>
                    </div>
                    <div class="col-sm-5 help-block">*Allow File (docx|pdf|doc|xls|xlsx)</div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right"> Description </label>
                    <div class="col-sm-9">
                        <textarea id="form_description" name="form_description" class="col-xs-10 col-sm-5"
                                  type="text"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right"> Created By </label>
                    <div class="col-sm-9">
                        <input type="text" value="<?php echo $this->session->userdata('d_user_name'); ?>" disabled=""
                               id="form_created_by">
                        &nbsp; <input type="text" value="<?php echo date("d-m-Y"); ?>" disabled=""
                                      id="form_creation_date">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right"> Updated By </label>
                    <div class="col-sm-9">
                        <input type="text" value="<?php echo $this->session->userdata('d_user_name'); ?>" disabled=""
                               id="form_updated_by">
                        &nbsp; <input type="text" value="<?php echo date("d-m-Y"); ?>" disabled=""
                                      id="form_updated_date">
                    </div>
                </div>
                <div class="space-4"></div>
                <div class="clearfix form-actions">
                    <div class="col-md-offset-3 col-md-9">
                        <button class="btn btn-info" type="submit">
                            <i class="ace-icon fa fa-check bigger-110"></i>
                            Save
                        </button>
                        &nbsp; &nbsp;
                        <button class="btn" type="reset" id="back">
                            <i class="ace-icon fa fa-arrow-circle-left bigger-110"></i>
                            Back
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="lov_pks" class="lov_content"></div>

    <script type="text/javascript">
        $("#btn_lov_pks").click(function () {
            var divID = "form_p_mp_pks_id#~#form_pks_name"; // Parameter id input
            var lov_target_id = "lov_pks"; // Harus sama dengan id class lov
            var modal_id = "modal_lov_pks"; // Terserah
            var lokasi_id = '<?php echo $P_MP_LOKASI_ID;?>';
            $(".lov_content").html("");
            $.ajax({
                url: "<?php echo base_url();?>managementmitra/lovPKS",
                type: "POST",
                data: {divID: divID, lov_target_id: lov_target_id, modal_id: modal_id, lokasi_id: lokasi_id},
                success: function (data) {
                    $('#' + lov_target_id).html(data);
                    $('#' + modal_id).modal('show');
                }
            });
        });

        $("#form_pks").on('submit', (function (e) {
            e.preventDefault();
            var data = new FormData(this);
            $.ajax({
                url: "<?php echo site_url('managementmitra/crud_pks');?>",
                type: "POST",
                data: data,
                contentType: false,       // The content type used when sending data to the server.
                cache: false,             // To unable request pages to be cached
                processData: false,
                dataType: "json",
                success: function (data) {
                    if (data.success == true) {
                        swal("Sukses", data.message, "success");
                        $("#grid-table").trigger("reloadGrid", [{page: 1}]);
                        $("#div_pks").hide("slow");
                        $("#dok_pks").show("slow");
                        $('#form_pks')[0].reset();
                        var $el = $('#filename');
                        $el.wrap('<form>').closest('form').get(0).reset();
                        $el.unwrap();
                        $(".ace-file-name").removeAttr('data-title');


                    } else {
                        swal("Error", data.message, "error");

                    }
                },
                error: function (xhr, status, error) {
                    swal({title: "Error!", text: xhr.responseText, html: true, type: "error"});
                }
            });

        }));
        $('#filename').ace_file_input({
            no_file: 'No File ...',
            btn_choose: 'Choose',
            btn_change: 'Change',
            droppable: false,
            onchange: null,
            thumbnail: false
        });
    </script>


</div>
<script type="text/javascript">
    $('.date-picker').datepicker({
            autoclose: true,
            todayHighlight: true
        })
        //show datepicker when clicking on the icon
        .next().on(ace.click_event, function () {
        $(this).prev().focus();
    });

    $("#add_pks").click(function () {
        $("#oper").val("add");
        $("#dok_pks").hide("slow");
        $("#div_pks").show("slow");
    });
    $("#btn_edit").click(function () {
        var rowKey = $("#grid-table").jqGrid('getGridParam', 'selrow');
        if (rowKey) {

            $.post("<?php echo site_url('managementmitra/gridPKS');?>",
                {
                    P_MP_PKS_ID: rowKey
                },
                function (response) {
                    var response = JSON.parse(response);
                    var obj = response.Data[0];
                    $("#form_pks_name").val(obj.NO_PKS);
                    $("#form_pks_id").val(obj.P_PKS_ID);
                    $("#form_doc_name").val(obj.DOC_NAME);
                    $("#form_description").val(obj.DESCRIPTION);
                    $("#form_p_mp_pks_id").val(obj.P_MP_PKS_ID);

                    $("#form_created_by").val(obj.CREATED_BY);
                    $("#form_created_date").val(obj.CREATED_DATE);
                    $("#form_updated_by").val(obj.UPDATED_BY);
                    $("#form_updated_date").val(obj.UPDATED_DATE);
                }
            );

            $("#oper").val("edit");
            $("#dok_pks").hide("slow");
            $("#div_pks").show("slow");
        } else {
            swal("Warning", "Silahkan pilih row PKS !", "warning");

        }

    });

    $("#back").click(function () {
        $("#div_pks").hide("slow");
        $("#dok_pks").show("slow");
        $('#form_pks')[0].reset();
        var $el = $('#filename');
        $el.wrap('<form>').closest('form').get(0).reset();
        $el.unwrap();
        $(".ace-file-name").removeAttr('data-title');

    })

    $("#list_pks").change(function () {
        var pks_id = $("#list_pks").val();
        var grid = $("#grid-table");
        var pager = $("#grid-pager");
        var postdata = grid.jqGrid('getGridParam', 'postData');
        $.extend(postdata, {pks_id: pks_id});
        grid.trigger("reloadGrid", [{page: 1}]);


    });
    $("#cari_pks").click(function () {
        var valid_from = $("#valid_from").val();
        var valid_until = $("#valid_until").val();
        var grid = $("#grid-table");
        var pager = $("#grid-pager");
        var postdata = grid.jqGrid('getGridParam', 'postData');
        $.extend(postdata, {valid_from: valid_from, valid_until: valid_until});
        grid.trigger("reloadGrid", [{page: 1}]);
    });
</script>
<div id="upload_pks">
</div>

<script type="text/javascript">
    $(document).ready(function () {
        var grid = $("#grid-table");
        var pager = $("#grid-pager");

        var parent_column = grid.closest('[class*="col-"]');
        $(window).on('resize.jqGrid', function () {
            grid.jqGrid('setGridWidth', $("#jqgrid").width() - 1);
            grid2.jqGrid('setGridWidth', $("#jqgrid").width() - 1);
        })
        //optional: resize on sidebar collapse/expand and container fixed/unfixed
        $(document).on('settings.ace.jqGrid', function (ev, event_name, collapsed) {
            if (event_name === 'sidebar_collapsed' || event_name === 'main_container_fixed') {
                grid.jqGrid('setGridWidth', parent_column.width());
                pager.jqGrid('setGridWidth', parent_column.width());
            }
        })
        var width = $("#jqgrid").width();

        grid.jqGrid({
            url: '<?php echo site_url('managementmitra/gridPKS');?>',
            datatype: "json",
            mtype: "POST",
            postData: {P_MP_LOKASI_ID:<?php echo $P_MP_LOKASI_ID;?>},
            caption: "Dokumen PKS",
            colModel: [
                {
                    label: 'ID',
                    name: 'P_PKS_ID',
                    key: true,
                    width: 200,
                    sortable: true,
                    editable: true,
                    editrules: {required: true},
                    hidden: true
                },
                {
                    label: 'Nama Dokumen',
                    name: 'DOC_NAME',
                    width: 200,
                    align: "left",
                    sortable: true,
                    editable: true,
                    editrules: {required: true}
                },
                {
                    label: 'No PKS',
                    name: 'NO_PKS',
                    width: 200,
                    align: "left",
                    sortable: true,
                    editable: true,
                    editrules: {required: true}
                },
                {
                    label: 'Tgl mulai PKS',
                    name: 'VALID_FROM',
                    width: 150,
                    align: "left",
                    sortable: true,
                    editable: true,
                    editrules: {required: true}
                },
                {
                    label: 'Tgl berakhir PKS',
                    name: 'VALID_UNTIL',
                    width: 150,
                    align: "left",
                    sortable: true,
                    editable: true,
                    editrules: {required: true}
                },
                {
                    label: 'File Path',
                    name: 'FILE_PATH',
                    width: 100,
                    align: "left",
                    sortable: true,
                    editable: false,
                    hidden: true,
                },
                {
                    label: 'Deskripsi',
                    name: 'DESCRIPTION',
                    width: 400,
                    align: "left",
                    sortable: true,
                    editable: false,
                    hidden: false
                },
                {
                    label: 'Action',
                    width: 70,
                    align: "left",
                    sortable: true,
                    editable: false,
                    hidden: false,
                    formatter: function (cellvalue, options, rowObject) {
                        var file_name = rowObject.FILE_PATH;
                        return '<div class="hidden-sm hidden-xs action-buttons">'
                            + '<a class="purple" href="<?php echo site_url('managementmitra/downloadPKS');?>/' + file_name + '" data-rel="tooltip" data-original-title="Download">'
                            + ' <i class="ace-icon fa fa-download bigger-130"></i>'
                            + '</a>'
                            + '<a class="blue" href="<?php echo base_url();?>application/third_party/upload/pks/' + file_name + '" target="_blank" data-rel="tooltip" data-original-title="Print">'
                            + '<i class="ace-icon fa fa-print bigger-130"></i></a>'
                            + '</div>';
                    }
                }
            ],
            width: width,
            height: '100%',
            scrollOffset: 0,
            rowNum: 5,
            viewrecords: true,
            rowList: [5, 10, 20],
            sortname: 'P_PKS_ID', // default sorting ID
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
                var table = this;
                setTimeout(function () {
                    //  styleCheckbox(table);

                    //  updateActionIcons(table);
                    updatePagerIcons(table);
                    enableTooltips(table);
                }, 0);
            },
            editurl: '<?php echo site_url('managementmitra/crud_pks');?>'


        });


        //navButtons grid master
        grid.jqGrid('navGrid', '#grid-pager',
            { 	//navbar options
                edit: false,
                excel: true,
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
                search: false,
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
                    var form = $(e[0]);
                    form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
                    style_edit_form(form);
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

                },
                onclickSubmit: function () {
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

        //add tooltip for small view action buttons in dropdown menu
        $('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});

        //tooltip placement on right or left
        function tooltip_placement(context, source) {
            var $source = $(source);
            var $parent = $source.closest('table')
            var off1 = $parent.offset();
            var w1 = $parent.width();

            var off2 = $source.offset();
            //var w2 = $source.width();

            if (parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2)) return 'right';
            return 'left';
        }
    });
</script>
