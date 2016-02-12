<div id="tbl_pic">
    <div style="margin-bottom: 10px;">
        <button class="btn btn-white btn-sm btn-round" id="add_mitra">
            <i class="ace-icon fa fa-plus green"></i>
            Tambah Mitra
        </button>
    </div>
    <table id="grid-table"></table>
    <div id="grid-pager"></div>
</div>
<div id="form_mitra" style="display:none;">
    <div style="margin-bottom: 10px;">
        <button class="btn btn-white btn-sm btn-round" id="back">
            <i class="ace-icon fa fa-arrow-circle-left green"></i>
            Kembali
        </button>
    </div>
    <br>
    <form class="form-horizontal" role="form" id="mitraForm">
        <div class="row">
            <div class="col-xs-6">
                <div class="form-group">
                    <label class="col-sm-4 control-label no-padding-right" for="form-field-1-1">Nama Segment</label>
                    <div class="col-sm-6">
                        <input type="text" id="mitraForm_segment" class="form-control required"
                               value="" readonly>
                    </div>
                    <a type="button" class="btn btn-white btn-info btn-sm" onclick="getLovSegment()"> <i
                            class="ace-icon fa fa-search bigger-120"></i>Pilih</a>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label no-padding-right" for="form-field-1-1">Nama CC </label>
                    <div class="col-sm-6">
                        <input type="text" id="cc_name" class="form-control required"
                               value="" readonly>
                        <br>
                        <input type="text" id="cc_id" class="form-control required"
                               value="" readonly>
                    </div>
                    <a type="button" class="btn btn-white btn-info btn-sm" onclick="getLov()"> <i
                            class="ace-icon fa fa-search bigger-120"></i>Pilih</a>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label no-padding-right" for="form-field-1"> Contract
                        Type </label>
                    <div class="col-sm-6">
                        <?php echo buatcombo('contact', 'contact', 'P_REFERENCE_LIST', 'REFERENCE_NAME', 'P_REFERENCE_LIST_ID', array('P_REFERENCE_TYPE_ID' => 1), ''); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label no-padding-right" for="form-field-1-1">Nama PIC </label>

                    <div class="col-sm-6">
                        <input type="text" id="picname" placeholder="Text Field" class="form-control required"
                               value="Amirudin" readonly>
                        <br>
                        <input type="text" id="pic_id" placeholder="Text Field" class="form-control required"
                               value="" readonly>
                    </div>
                    <a type="button" class="btn btn-white btn-info btn-sm" onclick="getLovPIC()"> <i
                            class="ace-icon fa fa-search bigger-120"></i>Pilih</a>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label no-padding-right" for="form-field-1-1">Jabatan </label>

                    <div class="col-sm-6">
                        <input type="text" id="jabatan" placeholder="Text Field" class="form-control"
                               value="Direktur" readonly/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label no-padding-right" for="form-field-1-1">Alamat </label>

                    <div class="col-sm-6">
                        <textarea class="form-control limited" id="alamat" maxlength="50" readonly>Gedung Attira Lt.9 Jl.
                            Jendral Sudirman Kav 45 Jakarta</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-4 control-label no-padding-right" for="form-field-1-1">Email </label>

                    <div class="col-sm-6">
                        <input type="text" id="email" placeholder="Text Field" class="form-control"
                               value="amirudin@attira.com" readonly/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label no-padding-right" for="form-field-1-1">No HP </label>

                    <div class="col-sm-6">
                        <input type="text" id="no_hp" placeholder="Text Field" class="form-control"
                               value="021-102938" readonly/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label no-padding-right" for="form-field-1-1">Fax</label>

                    <div class="col-sm-6">
                        <input type="text" id="fax" placeholder="Text Field" class="form-control"
                               value="021-102934" readonly/>
                    </div>
                </div>
            </div>

            <div class="col-xs-6">
                <div class="form-group">
                    <label class="col-sm-4 control-label no-padding-right" for="form-field-1-1">Nama Mitra</label>
                    <div class="col-sm-6">
                        <input type="text" id="mitra_name" class="form-control required"
                               value="" readonly>
                        <br>
                        <input type="text" id="pgl_id" class="form-control required"
                               value="" readonly>
                    </div>
                    <a type="button" class="btn btn-white btn-info btn-sm" onclick="getLov()"> <i
                            class="ace-icon fa fa-search bigger-120"></i>Pilih</a>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label no-padding-right" for="form-field-1-1">Lokasi PKS </label>
                    <div class="col-sm-6">
                        <input type="text" id="lokasi_pks" class="form-control required"
                               value="" readonly>
                        <br>
                        <input type="text" id="lokasi_pks_id" class="form-control required"
                               value="" readonly>
                    </div>
                    <a type="button" class="btn btn-white btn-info btn-sm" onclick="getLov()"> <i
                            class="ace-icon fa fa-search bigger-120"></i>Pilih</a>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label no-padding-right" for="form-field-1-1">Nama EAM</label>

                    <div class="col-sm-6">
                        <input type="text" id="form-field-1-1" placeholder="Text Field" class="form-control"
                               value="Sigit"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label no-padding-right" for="form-field-1-1">NIK </label>

                    <div class="col-sm-6">
                        <input type="text" id="form-field-1-1" placeholder="Text Field" class="form-control"
                               value="740099"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label no-padding-right" for="form-field-1-1">Email </label>

                    <div class="col-sm-6">
                        <input type="text" id="email" placeholder="Text Field" class="form-control"
                               value="sigit@telkom.co.id"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label no-padding-right" for="form-field-1-1">No Hp </label>

                    <div class="col-sm-6">
                        <input type="text" id="form-field-1-1" placeholder="Text Field" class="form-control"
                               value="081290237909"/>
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <hr>
            </div>

            <div id="button-form" class="col-xs-12">
        <span id="group1" style="float: left">
            <button class="btn btn-white btn-info btn-bold">
                <i class="ace-icon fa fa-cloud-download bigger-120 green"></i>
                Download
            </button>
            <button class="btn btn-white btn-info btn-bold">
                <i class="ace-icon fa fa-print bigger-120 green"></i>
                Print
            </button>
        </span>
        <span id="group2" style="float: right">
            <a class="btn btn-white btn-info btn-bold" id="save">
                <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>
                Save
            </a>
            <a class="btn btn-white btn-warning btn-bold" id="edit">
                <i class="ace-icon fa fa-pencil-square-o bigger-120 orange"></i>
                Edit
            </a>
            <a class="btn btn-white btn-default btn-bold">
                <i class="ace-icon fa fa-times red2"></i>
                Delete
            </a>
        </span>
            </div>
        </div>
    </form>
    <script type="text/javascript">
        $('#mitraForm').find('input[type=text],select,textarea').each(function () {
            //   $(this).attr('disabled', true);
            // $('#contract').attr("disabled", true);
        });

        $("#edit").click(function () {
            $('#mitraForm').find('input[type=text],select,textarea').each(function () {
                $(this).attr('disabled', false);
                // $('#contract').attr("disabled", true);
            })
        });
        $("#save").click(function () {
            $('#mitraForm').find('input[type=text],select,textarea').each(function () {
                $(this).attr('disabled', true);
                // $('#contract').attr("disabled", true);
            })
        });


    </script>

</div>
<div id="lov_pic" class="lov_content"></div>
<div id="lov_segment" class="lov_content"></div>
<div id="lov_cc" class="lov_content"></div>
<div id="lov_mitra" class="lov_content"></div>
<div id="lov_lokasi_pks" class="lov_content"></div>

<script type="text/javascript">
    function getLovPIC() {
        var divID = "pic_id#~#picname#~#jabatan#~#alamat#~#email#~#no_hp#~#fax"; // Parameter id input
        var lov_target_id = "lov_pic"; // Harus sama dengan id class lov
        var modal_id = "modal_lov_pic"; // Terserah
        $(".lov_content").html("");
        $.ajax({
            // async: false,
            url: "<?php echo base_url();?>managementmitra/lovPIC",
            type: "POST",
            data: {divID: divID,lov_target_id:lov_target_id,modal_id:modal_id},
            success: function (data) {
                $('#'+lov_target_id).html(data);
                $('#'+modal_id).modal('show');
            }
        });
    }

    function getLovSegment() {
        var divID = "mitraForm_segment"; //// Parameter id input
        var lov_target_id = "lov_segment"; // Harus sama dengan id class lov
        var modal_id = "modal_lov_segment"; // Terserah
        $(".lov_content").html("");
        $.ajax({
             async: false,
            url: "<?php echo base_url();?>managementmitra/lovSegment",
            type: "POST",
            data: {divID: divID,lov_target_id:lov_target_id,modal_id:modal_id},
            success: function (data) {
                $('#'+lov_target_id).html(data);
                $('#'+modal_id).modal('show');
            }
        });
    }

</script>
<script type="text/javascript">
    $(document).ready(function () {
        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";
        //resize to fit page size
        $(window).on('resize.jqGrid', function () {
            $(grid_selector).jqGrid('setGridWidth', $("#tbl_pic").width());
        });
        $(window).on('resize.jqGrid', function () {
            $(pager_selector).jqGrid('setGridWidth', $("#tbl_pic").width());
        });

        var ccid = '<?php echo $ccid;?>';
        var mitra = '<?php echo $mitra;?>';
        var lokasisewa = '<?php echo $lokasisewa;?>';
        var segment = '<?php echo $segment;?>';
        var data = {ccid: ccid, mitra: mitra, lokasisewa: lokasisewa, segment: segment};
        jQuery("#grid-table").jqGrid({
            url: '<?php echo site_url('managementmitra/gridPIC');?>',
            datatype: "json",
            mtype: "POST",
            colModel: [
                {label: 'ID', name: 'ID_MITRA', key: true, width: 5, sorttype: 'number', editable: true, hidden: true},
                {
                    label: 'Nama Mitra',
                    name: 'PGL_NAME',
                    width: 200,
                    align: "left",
                    editable: true,
                    editrules: {required: true}
                },
                {
                    label: 'Nama CC',
                    name: 'CC_NAME',
                    width: 200,
                    align: "left",
                    editable: true,
                    editrules: {required: true}
                },
                {
                    label: 'Segment',
                    name: 'SEGMENT',
                    width: 90,
                    align: "left",
                    editable: true,
                    editrules: {required: true}
                },
                {label: 'Lokasi PKS', name: 'LOKASI', align: "left", editable: true, editrules: {required: true}},
                {label: 'No PKS', name: 'NO_PKS', align: "left", editable: true, editrules: {required: true}},
                {
                    label: 'Nama PIC',
                    name: 'PIC_NAME',
                    width: 150,
                    align: "left",
                    editable: true,
                    editrules: {required: true}
                },
                {
                    label: 'Contact Type',
                    name: 'CODE',
                    width: 150,
                    align: "left",
                    editable: true,
                    editrules: {required: true},
                    editoptions: {size: 45}
                },
                {label: 'Jabatan', name: 'JABATAN', width: 150, align: "left", editable: true},
                {label: 'Alamat', name: 'ADDRESS_1', width: 300, align: "left", editable: true},
                {label: 'Kota', name: 'KOTA', width: 150, align: "left", editable: true},
                {label: 'Zip Code', name: 'ZIP_CODE', width: 100, align: "left", editable: true},
                {label: 'Email', name: 'EMAIL_PIC', width: 150, align: "left", editable: true},
                {label: 'No Hp', name: 'NO_HP_PIC', width: 100, align: "left", editable: true},
                {label: 'No Telp', name: 'NO_TELP', width: 100, align: "left", editable: true},
                {label: 'Fax', name: 'FAX', width: 100, align: "left"},
                {label: 'Valid From', name: 'VALID_FROM', width: 100, align: "left"},
                {label: 'Valid Until', name: 'VALID_T0', width: 100, align: "left"},
                {label: 'NAMA EAM', name: 'AM_NAME', width: 150, align: "left"},
                {label: 'NIK', name: 'NIK', width: 100, align: "left"},
                {label: 'EMAIL AM', name: 'EMAIL_AM', width: 150, align: "left"},
                {label: 'NO HP AM', name: 'NO_HP_AM', width: 150, align: "left"}
            ],
            postData: data,
            width: '100%',
            AutoWidth: true,
            height: '100%',
            scrollOffset: 0,
            rowNum: 5,
            viewrecords: true,
            rowList: [5, 10, 20],
            sortname: 'P_MAP_MIT_CC_ID', // default sorting ID
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
                var table = this;
                setTimeout(function () {
                    updatePagerIcons(table);
                    enableTooltips(table);
                }, 0);
            },
            editurl: '<?php echo site_url('admin/crud_user');?>',
            caption: "List PIC Mitra"

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
                refreshicon: 'ace-icon fa fa-refresh green',
                view: true,
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
                    $("#tr_PASSWD", form).show();
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
    });
</script>
<script>
    $("#add_mitra").click(function () {
        $("#tbl_pic").hide("slow");
        $("#form_mitra").show("slow");
    });

    $("#back").click(function () {
        $("#form_mitra").hide("fast");
        $("#tbl_pic").show("slow");

    });

</script>
