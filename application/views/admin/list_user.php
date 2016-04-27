<?php $prv = getPrivilege($menu_id); ?>
<div class="breadcrumbs" id="breadcrumbs">
    <?= $this->breadcrumb; ?>
</div>

<!-- /section:basics/content.breadcrumbs -->
<div class="page-content">
    <div class="row">
        <div id="notif"></div>
        <table id="grid-table"></table>
        <div id="grid-pager"></div>
    </div><!-- /.row -->

    <div class="row" id="user_attribute_row_content" style="margin-top:20px;display:none;">
        <div class="col-xs-12">
            <div class="well well-sm"><h4 class="blue" id="user_attribute_title"> User Attribute </h4></div>
            <!-- PAGE CONTENT BEGINS -->
            <div class="row">
                <div class="col-xs-12">
                    <div id="user_attribute_button_group" style="display:inline-block;float:left;">
                        <input id="form_user_id" type="text" style="display:none;" placeholder="User ID">
                        <?php
                        if ($prv['TAMBAH'] == "Y") {
                            echo '<button class="btn btn-xs btn-success btn-round" id="user_attribute_btn_add">
                            <i class="ace-icon glyphicon glyphicon-plus bigger-120"></i>
                            Add
                        </button>';
                        }
                        ?>

                        <?php
                        if ($prv['HAPUS'] == "Y") {
                            echo '<button class="btn btn-xs btn-danger btn-round" id="user_attribute_btn_delete">
                            <i class="ace-icon glyphicon glyphicon-trash bigger-120"></i>
                            Delete
                        </button>';
                        }
                        ?>

                    </div>
                    <div class="col-xs-12">
                        <table id="user_attribute_grid_selection"
                               class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th data-identifier="true" data-visible="false" data-header-align="center"
                                    data-align="center" data-column-id="P_USER_ATTRIBUTE_ID"> ID User Attribute
                                </th>
                                <th data-header-align="center" data-align="center" data-formatter="opt-edit"
                                    data-sortable="false" data-width="100">Options
                                </th>
                                <th data-column-id="TYPE_CODE">Type Code</th>
                                <th data-column-id="LIST_CODE">List Code</th>
                                <th data-column-id="LIST_NAME">List Name</th>
                                <th data-column-id="USER_ATTRIBUTE_VALUE">Value</th>
                                <th data-column-id="VALID_FROM">Valid From</th>
                                <th data-column-id="VALID_TO">Valid To</th>
                                <th data-column-id="DESCRIPTION"> Description</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <!-- PAGE CONTENT ENDS -->
        </div><!-- /.col -->
    </div><!-- /.row -->

    <?php $this->load->view('parameter/user_attribute_add_edit.php'); ?>

</div><!-- /.page-content -->

<script type="text/javascript">
    $(document).ready(function () {

        $("#user_attribute_btn_add").on(ace.click_event, function () {
            user_attribute_show_form_add();
        });

        $("#user_attribute_btn_delete").on(ace.click_event, function () {
            if ($("#user_attribute_grid_selection").bootgrid("getSelectedRows") == "") {
                //showBootDialog(true, BootstrapDialog.TYPE_INFO, 'Information', 'Tidak ada data yang dihapus');
                swal("Informasi", "Tidak ada data yang dipilih untuk dihapus", "info");
            } else {
                user_attribute_delete_records($("#user_attribute_grid_selection").bootgrid("getSelectedRows"));
            }
        });

    });

    function user_attribute_delete_records(theID) {
        /*BootstrapDialog.confirm({
         type: BootstrapDialog.TYPE_WARNING,
         title:'Delete Confirmation',
         message: 'Apakah Anda yakin untuk menghapus data tersebut ?',
         btnCancelLabel: 'Cancel',
         btnOKLabel: 'Yes, Delete',
         callback: function(result) {
         if(result) {
         $.post( "<?php echo site_url('User_attribute/crudUserAttribute/destroy');?>",
         { items: JSON.stringify(theID) },
         function( response ) {
         var response = JSON.parse(response);
         if(response.success == false) {
         showBootDialog(true, BootstrapDialog.TYPE_WARNING, 'Attention', response.message);
         }else {
         showBootDialog(true, BootstrapDialog.TYPE_SUCCESS, 'Information', response.message);
         user_attribute_prepare_table($("#form_user_id").val());
         }
         }
         );
         }
         }
         });*/

        swal({
                title: "Konfirmasi Hapus",
                text: "Apakah Anda yakin untuk menghapus data tersebut?",
                type: "warning",
                showCancelButton: true,
                showLoaderOnConfirm: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ya, Hapus",
                cancelButtonText: "Tidak, Batalkan",
                closeOnConfirm: false,
                closeOnCancel: true
            },
            function (isConfirm) {
                if (isConfirm) {
                    $.post("<?php echo site_url('user_attribute/crudUserAttribute/destroy');?>",
                        {items: JSON.stringify(theID)},
                        function (response) {
                            var response = JSON.parse(response);
                            if (response.success == false) {
                                //showBootDialog(true, BootstrapDialog.TYPE_WARNING, 'Attention', response.message);
                                swal("Perhatian", response.message, "warning");
                            } else {
                                //showBootDialog(true, BootstrapDialog.TYPE_SUCCESS, 'Information', response.message);
                                swal("Berhasil", "Data berhasil dihapus", "success");
                                user_attribute_prepare_table($("#form_user_id").val());
                            }
                        }
                    );
                }
            });
    }

    function user_attribute_prepare_table(user_id) {

        $("#form_user_id").val(user_id);
        $("#user_attribute_grid_selection").bootgrid("destroy");
        $("#user_attribute_grid_selection").bootgrid({
            formatters: {
                "opt-edit": function (col, row) {
                    return '<a href="#user_attribute_form_add_edit" title="Edit" onclick="user_attribute_show_form_edit(\'' + row.P_USER_ATTRIBUTE_ID + '\')" class="blue"><i class="ace-icon fa fa-pencil bigger-130"></i></a> &nbsp; <a href="#user_attribute_form_add_edit" title="Delete" onclick="user_attribute_delete_records(\'' + row.P_USER_ATTRIBUTE_ID + '\')" class="red"><i class="ace-icon glyphicon glyphicon-trash bigger-130"></i></a>';
                }
            },
            rowCount: [5, 10, 20],
            ajax: true,
            requestHandler: function (request) {
                if (request.sort) {
                    var sortby = Object.keys(request.sort)[0];
                    request.dir = request.sort[sortby];

                    delete request.sort;
                    request.sort = sortby;
                }
                return request;
            },
            responseHandler: function (response) {
                if (response.success == false) {
                    alert(response.message);
                }
                return response;
            },
            url: "<?php echo site_url('user_attribute/gridUserAttribute');?>",
            post: function () {
                return {user_id: user_id};
            },
            selection: true,
            multiSelect: true,
            sorting: true,
            rowSelect: true
        });

        $("#user_attribute_grid_selection").bootgrid().on("loaded.rs.jquery.bootgrid", function (e) {
            $("#user_attribute_row_content").slideDown("fast", function () {
            });
        });

    }

    $(document).ready(function () {
        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";

        //resize to fit page size
        $(window).on('resize.jqGrid', function () {
            $(grid_selector).jqGrid('setGridWidth', $("#contentJgGrid").width());
        });

        $(window).on('resize.jqGrid', function () {
            $(pager_selector).jqGrid('setGridWidth', $("#contentJgGrid").width());
        });


        $("#USER_NAME").on("keypress", function (event) {

            // Disallow anything not matching the regex pattern (A to Z uppercase, a to z lowercase and white space)
            // For more on JavaScript Regular Expressions, look here: https://developer.mozilla.org/en-US/docs/JavaScript/Guide/Regular_Expressions
            var englishAlphabetAndWhiteSpace = /[A-Za-z0-9]/g;

            // Retrieving the key from the char code passed in event.which
            // For more info on even.which, look here: http://stackoverflow.com/q/3050984/114029
            var key = String.fromCharCode(event.which);

            //alert(event.keyCode);

            // For the keyCodes, look here: http://stackoverflow.com/a/3781360/114029
            // keyCode == 8  is backspace
            // keyCode == 37 is left arrow
            // keyCode == 39 is right arrow
            // englishAlphabetAndWhiteSpace.test(key) does the matching, that is, test the key just typed against the regex pattern
            if (event.keyCode == 9 || event.keyCode == 8 || event.keyCode == 37 || event.keyCode == 39 || englishAlphabetAndWhiteSpace.test(key)) {
                return true;
            }

            // If we got this far, just return false because a disallowed key was typed.
            return false;
        });

        jQuery("#grid-table").jqGrid({
            url: '<?php echo site_url('admin/gridUser');?>',
            datatype: "json",
            mtype: "POST",
            //colNames:['Inv No','Date', 'Client', 'Amount','Tax','Total','Notes'],
            colModel: [
                {label: 'ID', name: 'USER_ID', key: true, width: 5, sorttype: 'number', editable: true, hidden: true},
                {
                    label: 'User Name',
                    name: 'USER_NAME',
                    width: 150,
                    align: "left",
                    editable: true,
                    editoptions: {
                        size: 30,
                        dataEvents: [
                            {
                                type: 'keypress',
                                fn: function (event) {
                                    var englishAlphabetAndWhiteSpace = /[A-Za-z0-9]/g;

                                    // Retrieving the key from the char code passed in event.which
                                    // For more info on even.which, look here: http://stackoverflow.com/q/3050984/114029
                                    var key = String.fromCharCode(event.which);

                                    //alert(event.keyCode);

                                    // For the keyCodes, look here: http://stackoverflow.com/a/3781360/114029
                                    // keyCode == 8  is backspace
                                    // keyCode == 37 is left arrow
                                    // keyCode == 39 is right arrow
                                    // englishAlphabetAndWhiteSpace.test(key) does the matching, that is, test the key just typed against the regex pattern
                                    if (event.keyCode == 9 || event.keyCode == 8 || event.keyCode == 37 || event.keyCode == 39 || englishAlphabetAndWhiteSpace.test(key)) {
                                        return true;
                                    }

                                    // If we got this far, just return false because a disallowed key was typed.
                                    return false;
                                }
                            }
                        ],
                        style: "text-transform: uppercase"
                    },
                    editrules: {
                        required: true
                        //custom: true,
                        // custom_func: username_rules
                    }

                },
                {
                    label: 'Full Name',
                    name: 'FULL_NAME',
                    width: 200,
                    align: "left",
                    editable: true,
                    editoptions: {
                        size: 45
                    },
                    editrules: {required: true}
                },
                {
                    label: 'Email',
                    name: 'EMAIL',
                    width: 200,
                    align: "left",
                    editable: true,
                    editoptions: {
                        size: 30
                    },
                    editrules: {required: true, email: true}
                },
                {
                    label: 'Loker',
                    name: 'LOKER',
                    width: 150,
                    align: "left",
                    editable: true, editoptions: {
                    size: 30
                }
                },
                {
                    label: 'Profile',
                    name: 'PROF_NAME',
                    width: 100,
                    sortable: true,
                    align: 'left',
                    editable: true,
                    edittype: 'select',
                    //  formatter: 'select'
                    editoptions: {dataUrl: '<?php echo site_url('admin/listProfile');?>'}
                },
                {
                    label: 'Address Street',
                    name: 'ADDR_STREET',
                    width: 250,
                    align: "left",
                    editable: true,
                    edittype: 'textarea',
                    editoptions: {
                        rows: "2",
                        cols: "40"
                    }
                },
                {
                    label: 'City', name: 'ADDR_CITY', width: 200, align: "left", editable: true, editoptions: {
                    size: 30
                }
                },
                {
                    label: 'Phone', name: 'CONTACT_NO', width: 150, align: "left", editable: true, editoptions: {
                    size: 30
                }
                },
                {
                    label: 'Password',
                    name: 'PASSWD',
                    width: 90,
                    align: "left",
                    editable: true,
                    edittype: 'password',
                    hidden: true,
                    editoptions: {
                        size: 30
                    },
                    editrules: {
                        required: true
                    }
                },
                {
                    label: 'Is Employee ?',
                    name: 'IS_EMPLOYEE',
                    width: 100,
                    sortable: true,
                    align: 'center',
                    editable: true,
                    edittype: 'select',
                    formatter: 'select',
                    editoptions: {value: {'N': 'NO', 'Y': 'YES'}}
                }
            ],
            width: 1120,
            //width: '100%',
            height: '100%',
            autowidth: true,
            rowNum: 5,
            viewrecords: true,
            rowList: [5, 10, 20],
            sortname: 'USER_NAME', // default sorting ID
            rownumbers: true, // show row numbers
            rownumWidth: 35, // the width of the row numbers columns
            sortorder: 'asc',
            altRows: true,
            shrinkToFit: false,
            //multiselect: true,
            //multikey: "ctrlKey",
            multiboxonly: true,
            onSelectRow: function (rowid) {
                var celValue = $('#grid-table').jqGrid('getCell', rowid, 'USER_ID');
                var uname = $('#grid-table').jqGrid('getCell', rowid, 'USER_NAME');

                user_attribute_toggle_main_content();
                $('#user_attribute_title').text("USER ATTRIBUTE :: " + uname);
                user_attribute_prepare_table(celValue);
            },
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
                    updatePagerIcons(table);
                    enableTooltips(table);
                }, 0);

                $("#user_attribute_row_content").hide();
                var is_submit = '<?php echo $prv['SUBMIT'];?>';
                if (is_submit == "Y") {
                    $('#reset').show();
                } else {
                    $('#reset').hide();
                }

            },
            editurl: '<?php echo site_url('admin/crud_user');?>',
            caption: "Daftar User"

        });

        /*    function listProfile(){
         $.post("<?php echo site_url('admin/listProfile');?>",
         function (response) {
         // var listProfile = JSON.parse(response);
         return response;
         }
         );
         }*/

        //navButtons grid master
        jQuery('#grid-table').jqGrid('navGrid', '#grid-pager',
            { 	//navbar options
                edit: <?php
                if ($prv['UBAH'] == "Y") {
                    echo 'true';
                } else {
                    echo 'false';

                }
                ?>,
                excel: true,
                editicon: 'ace-icon fa fa-pencil blue',
                add:  <?php
                if ($prv['TAMBAH'] == "Y") {
                    echo 'true';
                } else {
                    echo 'false';

                }
                ?>,
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
                afterRefresh: function () {
                    // some code here
                    jQuery("#detailsPlaceholder").hide();
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
                    $("#USER_NAME").prop("readonly", true);

                }
            },
            {
                //new record form
                width: 500,
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
                },
                msg: 'Penghapusan terhadap data User akan secara otomatis menghapus data User Attribute yang berkaitan.<br>Apakah Anda yakin menghapus data tersebut?',
                width: '400px'
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
            buttonicon: "ui-separator"
            // onClickButton: getSelectedRow,
//            position:"last",
//            title: "Separator",
//            cursor: "pointer",
//            id :"Separator"
        }).navButtonAdd('#grid-pager', {
            caption: "Reset Password",
            buttonicon: "ace-icon fa fa-recycle red",
            onClickButton: resetPwd,
            position: "last",
            title: "Reset Password",
            cursor: "pointer",
            id: "reset"
        });

        function resetPwd() {
            var grid = $("#grid-table");
            var rowKey = grid.jqGrid('getGridParam', 'selrow');
            var USER_NAME = $('#grid-table').jqGrid('getCell', rowKey, 'USER_NAME');

            if (rowKey) {
                var c = confirm('Reset Password ' + USER_NAME + ' ?')
                if (c == true) {
                    $.ajax({
                        url: '<?php echo site_url('admin/resetPWD');?>',
                        data: {user_id: rowKey, user_name: USER_NAME},
                        type: 'POST',
                        success: function (data) {
                            $("#notif").html("<div class='alert alert-success'> " +
                                "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>" +
                                "<strong>Sukses!</strong> " + data + " </div>");

                            $("#notif").fadeTo(2000, 500).slideUp(500, function () {
                                $("#success-alert").alert('close');
                            });
                            $('#grid-table').trigger('reloadGrid');

                        }
                    });
                } else {
                    return false;
                }

            }

            else {
                // alert("Please Select Row !!!");
                $.jgrid.viewModal("#alertmod_" + this.id, {toTop: true, jqm: true});
            }

        }


        function clearSelection() {
            //jQuery("#jqGridDetails").jqGrid('setGridParam',{url: "empty.json", datatype: 'json'}); // the last setting is for demo purpose only
            jQuery("#jqGridDetails").jqGrid('setCaption', 'Menu Child ::');
            jQuery("#jqGridDetails").trigger("reloadGrid");

        }

        function style_edit_form(form) {
            //enable datepicker on "sdate" field and switches for "stock" field
            form.find('input[name=sdate]').datepicker({format: 'yyyy-mm-dd', autoclose: true})

            form.find('input[name=stock]').addClass('ace ace-switch ace-switch-5').after('<span class="lbl"></span>');
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