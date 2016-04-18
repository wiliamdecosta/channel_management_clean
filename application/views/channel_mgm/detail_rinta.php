<!-- /section:basics/content.breadcrumbs -->
<div class="page-content">
    <div class="row">
        <div id="notif"></div>
            <table id="grid-table" bgcolor="#00FF00"></table>
            <div id="grid-pager"></div>
    </div><!-- /.row -->
</div><!-- /.page-content -->

<script type="text/javascript">
    $(document).ready(function () {
            var grid_selector = "#grid-table";
            var pager_selector = "#grid-pager";

            //resize to fit page size
            $(window).on('resize.jqGrid', function () {
                $(grid_selector).jqGrid( 'setGridWidth', $("#contentJgGrid").width() );
            });
        $(window).on('resize.jqGrid', function () {
            $(pager_selector).jqGrid( 'setGridWidth', $("#contentJgGrid").width() );
        });
         jQuery("#grid-table").jqGrid({
                 url: "<?php echo site_url(); ?>cm/gridRinta/<?php echo $period;?>/<?php echo $pgl_id;?>/<?php echo $ten_id;?>",
                 datatype: "json",
                 mtype: "POST",
                 //colNames:['Inv No','Date', 'Client', 'Amount','Tax','Total','Notes'],
                 colModel: [
                     //{ label: 'ID', name: 'USER_ID', key: true, width:5, sorttype:'number', editable: true,hidden:true },
                     { label: 'ND', name: 'ND1', width:110, frozen:true, align:"left", editable:true,editrules : { required: true}},
                     { label: 'M4L', name: 'FLAG', width:110, frozen:true, align:"left", editable:true,editrules : { required: true}},
                     {
                         label: 'Status',
                         name: 'AKTIF',
                         width: 110,
                         frozen: true,
                         align: "left",
                         editable: true,
                         formatter: function (cellvalue, options, rowObject) {
                             var status = rowObject.AKTIF;
                             if (status == '1') {
                                 return "Aktif";
                             }
                             else {
                                 return "Tidak Aktif";
                             }
                         }
                     },
                     { label: 'Alamat', name: 'ADDRESS', width:280, frozen:true, align:"left", editable:true,editrules : { required: true}},
                     { label: 'NAMA PLG', name: 'NOM', width:250, frozen:true, align:"left", editable:true,editrules : { required: true}},
                     { label: 'ABONEMEN', name: 'ABONEMEN',formatter:'integer', width:100, align:"right", editable:true},
                     { label: 'KREDIT', name: 'MNT_TCK_C',formatter:'integer', width:100, align:"right", editable:true},
                     { label: 'DEBET', name: 'MNT_TCK_D',formatter:'integer', width:100, align:"right", editable:true},
                     { label: 'LOKAL', name: 'LOKAL',formatter:'integer', width:100, align:"right", editable:true},
                     { label: 'INTERLOKAL', name: 'INTERLOKAL',formatter:'integer', width:100, align:"right", editable:true},
                     { label: 'SLJJ', name: 'SLJJ',formatter:'integer', width:100, align:"right", editable:true},
                     { label: 'SLI007', name: 'SLI007',formatter:'integer', width:100, align:"right", editable:true},
                     { label: 'SLI001', name: 'SLI001',formatter:'integer', width:100, align:"right", editable:true},
                     { label: 'SLI008', name: 'SLI008',formatter:'integer', width:100, align:"right", editable:true},
                     { label: 'SLI009', name: 'SLI009',formatter:'integer', width:100, align:"right", editable:true},
                     { label: 'TELKOM GLOBAL 017', name: 'SLI_017',formatter:'integer', width:100, align:"right", editable:true},
                     { label: 'TELKOMNET INSTAN', name: 'TELKOMNET_INSTAN',formatter:'integer', width:100, align:"right", editable:true},
                     { label: 'STB', name: 'STB',formatter:'integer', width:100, align:"right", editable:true},
                     { label: 'STB TSL', name: 'STB_TSL',formatter:'integer', width:100, align:"right", editable:true},
                     { label: 'STB EXL', name: 'STB_EXL',formatter:'integer', width:100, align:"right", editable:true},
                     { label: 'STB HCP', name: 'STB_HCP',formatter:'integer', width:100, align:"right", editable:true},
                     { label: 'STB INM', name: 'STB_INM',formatter:'integer', width:100, align:"right", editable:true},
                     { label: 'STB OTHERS', name: 'STB_OTHERS',formatter:'integer', width:100, align:"right", editable:true},
                     { label: 'EXPENSE SLI', name: 'EXPENSE_SLI',formatter:'integer', width:100, align:"right", editable:true},
                     { label: 'EXPENSE IN', name: 'EXPENSE_IN',formatter:'integer', width:100, align:"right", editable:true},
                     { label: 'PAY TV', name: 'PAY_TV',formatter:'integer', width:100, align:"right", editable:true},
                     { label: 'JAPATI', name: 'JAPATI',formatter:'integer', width:100, align:"right", editable:true},
                     { label: 'SPEEDY USAGE', name: 'USAGE_SPEEDY',formatter:'integer', width:100, align:"right", editable:true},
                     { label: 'NON JASTEL', name: 'NON_JASTEL',formatter:'integer', width:100, align:"right", editable:true},
                     { label: 'ISDN DATA', name: 'ISDN_DATA',formatter:'integer', width:100, align:"right", editable:true},
                     { label: 'ISDN VOICE', name: 'ISDN_VOICE',formatter:'integer', width:100, align:"right", editable:true},
                     { label: 'KONTEN', name: 'KONTEN',formatter:'integer', width:100, align:"right", editable:true},
                     { label: 'PORTWHOLESALES', name: 'PORTWHOLESALES',formatter:'integer', width:100, align:"right", editable:true},
                     { label: 'METERAI', name: 'METERAI',formatter:'integer', width:100, align:"right", editable:true},
                     { label: 'PPN', name: 'PPN',formatter:'integer', width:100, align:"right", editable:true},
                     { label: 'LAIN LAIN', name: 'LAIN_LAIN',formatter:'integer', width:100, align:"right", editable:true},
                     { label: 'TOTAL RINCIAN', name: 'TOTAL',formatter:'integer', width:150, align:"right", editable:true},
                     { label: 'GRAND TOTAL', name: 'GRAND_TOTAL',formatter:'integer', width:150, align:"right", editable:true},
                     { label: 'KURS', name: 'KURS', width:100, align:"left", editable:true},
                     { label: 'STATUS PEMBAYARAN', name: 'STATUS_PEMBAYARAN', width:120, align:"left", editable:true},
                     { label: 'TGL BAYAR', name: 'TGL_BYR', width:100, align:"left", editable:true}

                 ],
                 width: 1120,
                 height: '100%',
                  scrollOffset:0,
                 rowNum:10,
                 viewrecords: true,
                 rowList:[10,20,50],
                 sortname: 'USER_NAME', // default sorting ID
                 rownumbers: true, // show row numbers
                 rownumWidth: 35, // the width of the row numbers columns
                 sortorder: 'asc',
                 altRows: true,
                 shrinkToFit: false,
                 //multiselect: true,
                 //multikey: "ctrlKey",
                 multiboxonly: true,
                onSortCol : clearSelection,
                onPaging : clearSelection,
                //#pager merupakan div id pager
                pager: '#grid-pager',
                jsonReader: {
                    root: 'Data',
                    id: 'id',
                    repeatitems: false
                },
                loadComplete : function() {
                    var table = this;
                    setTimeout(function(){
                      //  styleCheckbox(table);

                      //  updateActionIcons(table);
                        updatePagerIcons(table);
                        enableTooltips(table);
                    }, 0);
                },
                //memanggil controller jqgrid yang ada di controller crud
                //editurl: '<?php echo site_url('admin/crud_user');?>',
                caption:"Rincian Tagihan"

         });
    });
    jQuery("#grid-table").jqGrid('setFrozenColumns');

    //navButtons grid master
    jQuery('#grid-table').jqGrid('navGrid','#grid-pager',
        { 	//navbar options
            edit: false,
            excel:true,
            editicon : 'ace-icon fa fa-pencil blue',
            add: false,
            addicon : 'ace-icon fa fa-plus-circle purple',
            del: false,
            delicon : 'ace-icon fa fa-trash-o red',
            search: false,
            searchicon : 'ace-icon fa fa-search orange',
            refresh: false,
            afterRefresh : function () {
            // some code here
                jQuery("#detailsPlaceholder").hide();
            },
            refreshicon : 'ace-icon fa fa-refresh green',
            view: false,
            viewicon : 'ace-icon fa fa-search-plus grey'
        },
        {
            // options for the Edit Dialog
            closeAfterEdit: true,
            width: 500,
            errorTextFormat: function (data) {
                return 'Error: ' + data.responseText
            },
            recreateForm: true,
            beforeShowForm : function(e,form) {
                var form = $(e[0]);
                form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
                style_edit_form(form);
                $("#NIK").prop("readonly",true);

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
            beforeShowForm : function(e,form) {
                var form = $(e[0]);
                form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar')
                    .wrapInner('<div class="widget-header" />')
                style_edit_form(form);
                $("#tr_PASSWD",form).show();
            }
        },
        {
            //delete record form
            recreateForm: true,
            beforeShowForm : function(e) {
                var form = $(e[0]);
                if(form.data('styled')) return false;

                form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
                style_delete_form(form);

                form.data('styled', true);
            },
            onClick : function(e) {
                //alert(1);
            }
        },
        {
            //search form
           // closeAfterSearch: true,
            recreateForm: true,
            afterShowSearch: function(e){
                var form = $(e[0]);
                form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
                style_search_form(form);
            },
            afterRedraw: function(){
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
            beforeShowForm: function(e){
                var form = $(e[0]);
                form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
            }
        }
    )
	.navButtonAdd('#grid-pager',{
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
                url: "<?php echo site_url(); ?>cm/fastelsheet/<?php echo $pgl_id;?>/<?php echo $ten_id;?>/<?php echo $period;?>",
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
        //jQuery("#jqGridDetails").jqGrid('setGridParam',{url: "empty.json", datatype: 'json'}); // the last setting is for demo purpose only
        jQuery("#jqGridDetails").jqGrid('setCaption', 'Menu Child ::');
        jQuery("#jqGridDetails").trigger("reloadGrid");

    }

    function style_edit_form(form) {
        //enable datepicker on "sdate" field and switches for "stock" field
        form.find('input[name=sdate]').datepicker({format:'yyyy-mm-dd' , autoclose:true})

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
        if(form.data('styled')) return false;

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
            'ui-icon-seek-first' : 'ace-icon fa fa-angle-double-left bigger-140',
            'ui-icon-seek-prev' : 'ace-icon fa fa-angle-left bigger-140',
            'ui-icon-seek-next' : 'ace-icon fa fa-angle-right bigger-140',
            'ui-icon-seek-end' : 'ace-icon fa fa-angle-double-right bigger-140'
        };
        $('.ui-pg-table:not(.navtable) > tbody > tr > .ui-pg-button > .ui-icon').each(function(){
            var icon = $(this);
            var $class = $.trim(icon.attr('class').replace('ui-icon', ''));

            if($class in replacement) icon.attr('class', 'ui-icon '+replacement[$class]);
        })
    }

    function enableTooltips(table) {
        $('.navtable .ui-pg-button').tooltip({container:'body'});
        $(table).find('.ui-pg-div').tooltip({container:'body'});
    }

</script>