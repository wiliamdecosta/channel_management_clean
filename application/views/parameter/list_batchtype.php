<!-- #section:basics/content.breadcrumbs -->
<div class="breadcrumbs" id="breadcrumbs">
    <?=$this->breadcrumb;?>
</div>

<!-- /section:basics/content.breadcrumbs -->
<div class="page-content">


    <div class="row">
        <div class="col-xs-12" style="width: 100%;">
            <!-- PAGE CONTENT BEGINS -->
            <table id="grid-table"></table>


            <div id="grid-pager"></div>

            <script type="text/javascript">
                var $path_base = "..";//in Ace demo this will be used for editurl parameter
            </script>

            <br>

            <div id="detailsPlaceholder" style="display:none">
                <table id="jqGridDetails"></table>
                <div id="jqGridDetailsPager"></div>
            </div>
            <!-- PAGE CONTENT ENDS -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.page-content -->

<script type="text/javascript">
    $(document).ready(function () {
            var grid_selector = "#grid-table";
            var pager_selector = "#grid-pager";

            //resize to fit page size
            $(window).on('resize.jqGrid', function () {
                $(grid_selector).jqGrid( 'setGridWidth', $(".page-content").width() );
            })
         var userName = '<?php echo $this->session->userdata("d_user_name"); ?>';
         var date = '<?= date("d/m/Y");?>';
         jQuery("#grid-table").jqGrid({
                 url:'<?php echo site_url('parameter/gridBatchType');?>',
                 datatype: "json",
                 mtype: "POST",
                 colModel: [
                    // { label: 'ID', name: 'P_BATCH_TYPE_ID', key: true, width:5, sorttype:'number', editable: true,hidden:true },
                     { label: 'ID', name: 'P_BATCH_TYPE_ID', key: true, width:35, sorttype:'number',sortable:true, editable: false,hidden:false },
                     { label: 'Code', name: 'CODE', width:250, align:"left",sortable:true, editable:true,editrules : { required: true}, editoptions: {size:30,value:{Tes:'asdad'}}},
                     { label: 'Active', name: 'IS_ACTIVE', width:250, align:"left", editable:true,editrules : { required: true},edittype:'select', editoptions:{value:{Y:'Yes',N:'No'}}},
                     { label: 'Is Batch Report?', name: 'IS_BATCH_REPORT', width:250, align:"left", editable:true,editrules : { required: true},edittype:'select', editoptions:{value:{Y:'Yes',N:'No'}}},
                     { label: 'Created Date', name: 'CREATION_DATE', width:140, align:"left", editable:true,hidden:false,editrules : { required: true,edithidden:true},editoptions: {defaultValue:date,readonly: 'readonly'}},
                     { label: 'Created By', name: 'CREATED_BY', width:140, align:"left", editable:true,hidden:false,editrules : { required: true,edithidden:true},editoptions: {defaultValue:userName,readonly: 'readonly'}},
                     { label: 'Update Date', name: 'UPDATE_DATE', width:250, align:"left", editable:true,hidden:false,editrules : { required: true,edithidden:true},editoptions: {defaultValue:date,readonly: 'readonly'}},
                     { label: 'Update By', name: 'UPDATE_BY', width:300, align:"left",editable:true,hidden:false,editrules : { required: true,edithidden:true},editoptions: {defaultValue:userName,readonly: 'readonly'}}
                 ],
                 caption:"Batch Type",
                 width: '100%',
                 height: '100%',
                 scrollOffset:0,
                 rowNum:5,
                 viewrecords: true,
                 rowList:[5,10,20],
                 sortname: 'P_BATCH_TYPE_ID', // default sorting ID
                 //rownumbers: true, // show row numbers
                 rownumWidth: 35, // the width of the row numbers columns
                 sortorder: 'asc',
                 altRows: true,
                 shrinkToFit: true,
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

                editurl: '<?php echo site_url('parameter/crud_batchType');?>'


         });
    });
    //JqGrid Detail

    //navButtons grid master
    jQuery('#grid-table').jqGrid('navGrid','#grid-pager',
        { 	//navbar options
            edit: true,
            excel:true,
            editicon : 'ace-icon fa fa-pencil blue',
            add: true,
            addicon : 'ace-icon fa fa-plus-circle purple',
            del: true,
            delicon : 'ace-icon fa fa-trash-o red',
            search: true,
            searchicon : 'ace-icon fa fa-search orange',
            refresh: true,
            afterRefresh : function () {
            // some code here
                jQuery("#detailsPlaceholder").hide();
            },
            refreshicon : 'ace-icon fa fa-refresh green',
            view: false,
            viewicon : 'ace-icon fa fa-search-plus grey',
        },
        {
            // options for the Edit Dialog
            closeAfterEdit: true,
            width: 500,
            errorTextFormat: function (data) {
                return 'Error: ' + data.responseText
            },
            recreateForm: true,
            beforeShowForm : function(e) {
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
            beforeShowForm : function(e) {
                var form = $(e[0]);
                form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar')
                    .wrapInner('<div class="widget-header" />')
                style_edit_form(form);
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