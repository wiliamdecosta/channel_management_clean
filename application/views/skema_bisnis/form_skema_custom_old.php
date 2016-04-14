<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/fuelux/fuelux.wizard.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.validate.js"></script>

<div class="row">
    <div class="col-xs-12">
        <div class="widget-box">
            <div class="widget-header widget-header-blue widget-header-flat">
                <h4 class="widget-title lighter">Skema Custom</h4>

                <div class="widget-toolbar">
                    <label>
                        <small class="green">
                            <b>Validation</b>
                        </small>

                        <input id="skip-validation" type="checkbox" class="ace ace-switch ace-switch-4"/>
                        <span class="lbl middle"></span>
                    </label>
                </div>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <div id="fuelux-wizard-container">
                        <div>
                            <ul class="steps">
                                <li data-step="1" class="active">
                                    <span class="step">1</span>
                                    <span class="title">Input Revenue</span>
                                </li>

                                <li data-step="2">
                                    <span class="step">2</span>
                                    <span class="title">Input Tier Condition</span>
                                </li>

                                <li data-step="3">
                                    <span class="step">3</span>
                                    <span class="title">Input Component</span>
                                </li>

                                <li data-step="4">
                                    <span class="step">4</span>
                                    <span class="title">Finish</span>
                                </li>
                            </ul>
                        </div>
                        <hr/>

                        <!-- #section:plugins/fuelux.wizard.container -->
                        <div class="step-content pos-rel">
                            <div class="step-pane active" data-step="1">
                                <form class="form-horizontal" id="validation-form">
                                    <!-- #section:elements.form.input-state -->
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right">Pilih Commitment</label>
                                        <div class="col-sm-6">
                                            <?php echo buatcombo("form_commitment", "form_commitment", "P_REFERENCE_LIST", "REFERENCE_NAME", "P_REFERENCE_TYPE_ID", array('P_REFERENCE_TYPE_ID' => 4), ""); ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right"> Revenue Value </label>
                                        <div class="col-sm-6">
                                            <input type="text" id="revenue" name="revenue" placeholder="Rp." value=""
                                                   class="form-control"/>
                                        </div>
                                    </div>
                                </form>

                            </div>

                            <div class="step-pane" data-step="2">
                                <div class="row" id="grid_skema_custom">
                                    <div class="col-xs-12">
                                        <table id="grid-table"></table>
                                        <div id="grid-pager"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="step-pane" data-step="3">
                                <div class="center">
                                    <h3 class="blue lighter">This is step 3</h3>
                                </div>
                            </div>

                            <div class="step-pane" data-step="4">
                                <div class="center">
                                    <h3 class="green">Congrats!</h3>
                                    Your product is ready to ship! Click finish to continue!
                                </div>

                            </div>
                        </div>

                        <!-- /section:plugins/fuelux.wizard.container -->
                    </div>

                    <hr/>
                    <div class="wizard-actions">
                        <!-- #section:plugins/fuelux.wizard.buttons -->
                        <a class="btn btn-prev">
                            <i class="ace-icon fa fa-arrow-left"></i>
                            Prev
                        </a>

                        <a class="btn btn-success btn-next" data-last="Finish">
                            Next
                            <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
                        </a>

                        <!-- /section:plugins/fuelux.wizard.buttons -->
                    </div>

                    <!-- /section:plugins/fuelux.wizard -->
                </div><!-- /.widget-main -->
            </div><!-- /.widget-body -->
        </div>
    </div>
</div>


<input type="hidden" name="schm_fee_id" id="schm_fee_id" value="<?php echo $schm_fee_id; ?>">


<div class="form-group">
    <label class="col-sm-2 control-label no-padding-right"></label>
    <div class="col-sm-8">

    </div>

</div>
<div class="form-group">
    <label class="col-sm-2 control-label no-padding-right"></label>
    <div class="col-sm-6">
        <a type="button" class="btn btn-white btn-info btn-bold" id="save_skema_custom">
            <i class="ace-icon fa fa-floppy-o bigger-120 green"></i>
            Save Skema Mitra
        </a>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        var grid = $("#grid-table");
        var pager = $("#grid-pager");
        //resize to fit page size
        var parent_column = grid.closest('[class*="col-"]');
        $(window).on('resize.jqGrid', function () {
            grid.jqGrid('setGridWidth', $("#grid_skema_custom").width() - 10);
        })
        //optional: resize on sidebar collapse/expand and container fixed/unfixed
        $(document).on('settings.ace.jqGrid', function (ev, event_name, collapsed) {
            if (event_name === 'sidebar_collapsed' || event_name === 'main_container_fixed') {
                grid.jqGrid('setGridWidth', parent_column.width());
            }
        })
        var width = $("#grid_skema_custom").width() - 10;
        grid.jqGrid({
            url: '<?php echo site_url('skema_bisnis/gridCompSkemaCustom');?>',
            datatype: "json",
            postData: {schm_fee_id:<?php echo $schm_fee_id;?>},
            mtype: "POST",
            caption: "Daftar Komponen",
            colModel: [
                {
                    label: 'ID',
                    name: 'SCHM_FEE_PK_ID',
                    key: true,
                    width: 5,
                    sorttype: 'number',
                    editable: true,
                    hidden: true
                },
                {
                    label: 'Nama Komponen',
                    name: 'CF_NAME',
                    width: 200,
                    align: "left",
                    editable: true,
                    edittype: 'select',
                    editoptions: {dataUrl: '<?php echo site_url('skema_bisnis/getListComponent');?>'},
                    editrules: {required: true}
                },
                {
                    label: 'Persentase',
                    name: 'PERCENTAGE',
                    width: 100,
                    align: "left",
                    editable: true,
                    editoptions: {
                        size: 15

                        /*dataInit: function (element) {
                         $(element).keypress(function(e){
                         if (e.keyCode != 39 && e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) ) {
                         return false;
                         }
                         });
                         }*/
                    },
                    editrules: {
                        required: true
                    }
                }
            ],

            width: width,
            height: '100%',
            scrollOffset: 0,
            rowNum: 10,
            viewrecords: true,
            rowList: [10, 20, 50],
            sortname: 'CF_NAME', // default sorting ID
            rownumbers: true, // show row numbers
            rownumWidth: 35,
            sortorder: 'asc',
            altRows: true,
            shrinkToFit: true,
            multiboxonly: true,
            onSortCol: clearSelection,
            onPaging: clearSelection,
            pager: '#grid-pager',
            jsonReader: {
                root: 'Data',
                id: 'id',
                repeatitems: false
            }
            ,
            loadComplete: function () {

                var table = this;
                setTimeout(function () {
                    updatePagerIcons(table);
                    enableTooltips(table);
                }, 0);
            },
            editurl: '<?php echo site_url('skema_bisnis/crud_skema_custom');?>'


        });

        //navButtons grid master
        grid.jqGrid('navGrid', '#grid-pager',
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
                closeAfterAdd: false,
                recreateForm: true,
                viewPagerButtons: false,
                beforeShowForm: function (e, form) {
                    var form = $(e[0]);
                    form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar')
                        .wrapInner('<div class="widget-header" />')
                    style_edit_form(form);
                },
                onclickSubmit: function (rowid) {
                    var SCHM_FEE_ID = '<?php echo $schm_fee_id;?>';
                    var pgl_id = $('#form_pgl_id').val();
                    var skema_id = $('#form_skembis_type').val();
                    return {SCHM_FEE_ID: SCHM_FEE_ID, pgl_id: pgl_id, skema_id: skema_id};
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
    });
</script>


<script type="text/javascript">
    $("#save_skema_custom").click(function () {

        $('#form_create_skemas').trigger("reset");
        $("#form_skembis").hide("slow");
        $("#tbl_skema").show("slow");
        $("#div_benefit").hide();
        var grid = $("#grid_table_pic");
        var pager = $("#grid_pager_pic");
        grid.trigger("reloadGrid", [{page: 1}]);
        $(window).on('resize.jqGrid', function () {
            grid.jqGrid('setGridWidth', $('#tbl_skema').width());
        });
        $(window).on('resize.jqGrid', function () {
            pager.jqGrid('setGridWidth', $('#tbl_skema').width());
        });
    })


</script>

<script type="text/javascript">
    jQuery(function ($) {
        var $validation = true;
        $('#fuelux-wizard-container')
            .ace_wizard({
                //step: 2 //optional argument. wizard will jump to step "2" at first
                //buttons: '.wizard-actions:eq(0)'
            })
            .on('actionclicked.fu.wizard', function (e, info) {
                if (info.step == 1 && $validation) {
                    if (!$('#validation-form').valid()) e.preventDefault();
                }
            })
            .on('finished.fu.wizard', function (e) {
                bootbox.dialog({
                    message: "Thank you! Your information was successfully saved!",
                    buttons: {
                        "success": {
                            "label": "OK",
                            "className": "btn-sm btn-primary"
                        }
                    }
                });
            }).on('stepclick.fu.wizard', function (e) {
            //e.preventDefault();//this will prevent clicking and selecting steps
        });


        $('#validation-form').validate({
            errorElement: 'div',
            errorClass: 'help-block',
            focusInvalid: false,
            ignore: "",
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 5
                },
                password2: {
                    required: true,
                    minlength: 5,
                    equalTo: "#password"
                },
                name: {
                    required: true
                },
                phone: {
                    required: true,
                    phone: 'required'
                },
                url: {
                    required: true,
                    url: true
                },
                comment: {
                    required: true
                },
                state: {
                    required: true
                },
                platform: {
                    required: true
                },
                subscription: {
                    required: true
                },
                gender: {
                    required: true
                },
                agree: {
                    required: true
                },
                revenue: {
                    required: true,
                    number: true
                }
            },

            messages: {
                email: {
                    required: "Please provide a valid email.",
                    email: "Please provide a valid email."
                },
                password: {
                    required: "Please specify a password.",
                    minlength: "Please specify a secure password."
                },
                state: "Please choose state",
                subscription: "Please choose at least one option",
                gender: "Please choose gender",
                agree: "Please accept our policy",
                revenue: {
                    required: "Revenue Value harus diisi !",
                    number: " Value tidak valid !"
                }
            },


            highlight: function (e) {
                $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
            },

            success: function (e) {
                $(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
                $(e).remove();
            },

            errorPlacement: function (error, element) {
                if (element.is('input[type=checkbox]') || element.is('input[type=radio]')) {
                    var controls = element.closest('div[class*="col-"]');
                    if (controls.find(':checkbox,:radio').length > 1) controls.append(error);
                    else error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
                }
                else if (element.is('.select2')) {
                    error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));
                }
                else if (element.is('.chosen-select')) {
                    error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
                }
                else error.insertAfter(element.parent());
            },

            submitHandler: function (form) {
            },
            invalidHandler: function (form) {
            }
        });

    })
</script>