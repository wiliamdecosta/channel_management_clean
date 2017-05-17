<div id="dokPKS">
        <div class="form-group">
            <div class="row">
                <div class="col-xs-12">
                    <div id="nonpot">
                        <table id="grid-table2" bgcolor="#00FF00"></table>
                        <div id="grid-pager2"></div>
                    </div>
                </div>
            </div>
        </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        var grid2 = $("#grid-table2");
        var pager2 = $("#grid-pager2");

        var parent_column = grid2.closest('[class*="col-"]');
        $(window).on('resize.jqGrid', function () {
            grid2.jqGrid('setGridWidth', $("#nonpot").width() - 1);
            pager2.jqGrid('setGridWidth', $("#nonpot").width() - 1);
        })
        //optional: resize on sidebar collapse/expand and container fixed/unfixed
        $(document).on('settings.ace.jqGrid', function (ev, event_name, collapsed) {
            if (event_name === 'sidebar_collapsed' || event_name === 'main_container_fixed') {
                grid2.jqGrid('setGridWidth', parent_column.width());
                pager2.jqGrid('setGridWidth', parent_column.width());
            }
        })
        var width2 = $("#nonpot").width();
        var bulanform = $('#formbulan').val();
        var tahunform = $('#formtahun').val();
		
		/*
		IDNUMBER	 VARCHAR2(57)
		NPER         VARCHAR2 (6) 
		CA           VARCHAR2 (36) 
		NIPNAS       VARCHAR2 (30) 
		BPNAME       VARCHAR2 (120) 
		PRODUK       VARCHAR2 (20) 
		UBIS         VARCHAR2 (6) 
		SEGMEN       VARCHAR2 (10) 
		SUBSEGMEN    VARCHAR2 (10) 
		BISNIS_AREA  VARCHAR2 (90) 
		DIVISI       VARCHAR2 (8) 
		WITEL        VARCHAR2 (64) 
		BILL_PERIOD  VARCHAR2 (6) 
		DUE_DATE     VARCHAR2 (8) 
		BILL_ELEMENT VARCHAR2 (90) 
		ACCOUNT      VARCHAR2 (7) 
		BILL_AMOUNT NUMBER
		BILL LC AMOUNT NUMBER
		*/


        grid2.jqGrid({
            // url: "<?php echo site_url(); ?>cm/gridTunggakanDt",
            url: "<?php echo site_url(); ?>cm/gridTunggakanDt/<?php echo $period;?>/<?php echo $pgl_id;?>/<?php echo $ten_id;?>",
            // postData: {pgl_id: <?php echo $pgl_id;?>, bulan: bulanform, tahun: tahunform},
            datatype: "json",
            mtype: "POST",
            colModel: [
                {label: 'IDNUMBER', name: 'IDNUMBER', width: 150, align: "left", hidden: false},
                {label: 'NPER', name: 'NPER', width: 150, align: "left", hidden: false},
                {label: 'CA', name: 'CA', width: 150, align: "left", hidden: false},
                {label: 'NIPNAS', name: 'NIPNAS', width: 150, align: "left", hidden: false},
                {label: 'BPNAME', name: 'BPNAME', width: 150, align: "left", hidden: false},
                {label: 'PRODUK', name: 'PRODUK', width: 150, align: "left", hidden: false},
                {label: 'UBIS', name: 'UBIS', width: 150, align: "left", hidden: false},
                {label: 'SEGMEN', name: 'SEGMEN', width: 150, align: "left", hidden: false},
                {label: 'BISNIS_AREA', name: 'BISNIS_AREA', width: 150, align: "left", hidden: false},
                {label: 'DIVISI', name: 'DIVISI', width: 150, align: "left", hidden: false},
                {label: 'WITEL', name: 'WITEL', width: 150, align: "left", hidden: false},
                {label: 'BILL_PERIOD', name: 'BILL_PERIOD', width: 150, align: "left", hidden: false},
                {label: 'DUE_DATE', name: 'DUE_DATE', width: 150, align: "left", hidden: false},
                {label: 'BILL_ELEMENT', name: 'BILL_ELEMENT', width: 150, align: "left", hidden: false},
                {label: 'ACCOUNT', name: 'ACCOUNT', width: 150, align: "left", hidden: false},
                {
                    label: 'BILL_AMOUNT',
                    name: 'BILL_AMOUNT',
                    width: 200,
                    align: "right",
                    editable: true,
                    formatter: 'integer',
                },
				{label: 'ALAMAT', name: 'ALAMAT', width: 150, align: "left", hidden: false},
            ],
            width: width2,
            height: '100%',
            scrollOffset: 0,
            rowNum: 10,
            viewrecords: true,
            rowList: [10, 20, 50],
            // sortname: 'nofastel',
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
				if($(this).jqGrid("getGridParam", "page") == 0){
						$("#reset").hide();
				}
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

        //navButtons grid master
        grid2.jqGrid('navGrid', '#grid-pager2',
            { 	//navbar options
                edit: false,
                excel: false,
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
		$("#grid-table2").navButtonAdd('#grid-pager2',{
            caption:"Export To Excel",
            buttonicon:"ace-icon fa-file-excel-o green",
            position:"last",
            title: "Export To Excel",
            cursor: "pointer",
            onClickButton: toExcel,
            id :"reset"
			});
			function toExcel() {
				var c = confirm('Export to Excel ?')
				if(c == true){
					$.ajax({
						  url: "<?php echo site_url(); ?>cm/tunggakanDTSheet/<?php echo $pgl_id;?>/<?php echo $ten_id;?>/<?php echo $period;?>",
						data: {},
						type: 'POST',
						success: function (response) {
							var output = $.parseJSON(response);
							if (output.redirect !== undefined && output.redirect) {
								window.location.href = output.redirect_url;
							}
						},
						error: function(jqXHR, textStatus, errorThrown){
							// alert(errorThrown);
							 $("#ajaxContent").html(errorThrown);
						}
					});

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

    });
</script>
<script>
    $("#filter_cari").click(function () {
        var grid_pot = jQuery("#grid-table");
        var grid_nonpot = jQuery("#grid-table2");
        var bulan = $("#bulan").val();
        var tahun = $("#tahun").val();
        if (bulan && tahun) {
            var postdata = grid_pot.jqGrid('getGridParam', 'postData');
            $.extend(postdata, {bulan: bulan,tahun:tahun});
            grid_pot.trigger("reloadGrid", [{page: 1}]);

            var postdata2 = grid_nonpot.jqGrid('getGridParam', 'postData');
            $.extend(postdata2, {bulan: bulan,tahun:tahun});
            grid_nonpot.trigger("reloadGrid", [{page: 1}]);
        } else {
            swal('Warning', 'Bulan dan tahun harus dipilih !', 'warning');
            return false;
        }
    });

</script>