<div id="tbl_pic">
    <div class="row">

        <div class="profile-user-info profile-user-info-striped">
            <div class="profile-info-row">
                <div class="profile-info-name"> Nama AM</div>

                <div class="profile-info-value">
                    <span class="editable"><b>Syahrizal</b></span>
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name"> NIK</div>

                <div class="profile-info-value">
                    <span class="editable"><b>00989013</b></span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name"> Email</div>

                <div class="profile-info-value">
                    <span class="editable"><b>syahrizal@yahoo.com</b></span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name">No Hp</div>
                <div class="profile-info-value">
                    <span class="editable" id="username"><b>PKS 1003-TEL-2015</b></span>
                </div>
            </div>

        </div>
    </div>

    &nbsp;
    <table id="grid-table"></table>
    <div id="grid-pager"></div>

</div>
<div id="form_mitra" style="display: none;"></div>

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
            caption: "List PIC Mitra",
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
                    label: 'Alamat',
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
            postData: data,
            width: '100%',
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
            editurl: '<?php echo site_url('admin/crud_user');?>'


        });


        //navButtons grid master
        jQuery('#grid-table').jqGrid('navGrid', '#grid-pager',
            { 	//navbar options
                edit: false,
                excel: true,
                editicon: 'ace-icon fa fa-pencil blue',
                add: false,
                addicon: 'ace-icon fa fa-plus-circle purple',
                del: false,
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
        $.ajax({
            // async: false,
            url: "<?php echo base_url();?>managementmitra/mitra_form",
            type: "POST",
            data: {action: "add"},
            success: function (data) {
                $("#form_mitra").html(data);
                $("#tbl_pic").hide("slow");
                $("#form_mitra").show("slow");
            }
        });

    });

    $("#back").click(function () {
        $("#form_mitra").hide("fast");
        $("#tbl_pic").show("slow");

    });

</script>
