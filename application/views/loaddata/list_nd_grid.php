<div class="page-content">
    <div class="row">
        <div id="notif"></div>
        <table id="grid-table" bgcolor="#00FF00"></table>
        <div id="grid-pager"></div>
        Load in <?php  echo $this->benchmark->elapsed_time(); ?> seconds
    </div>
    <div id="outerDiv" style="margin: 5px;">
        <table id="list"></table>
    </div>
</div>
<script type="text/javascript">
    var grid_selector = "#grid-table";
    var pager_selector = "#grid-pager";
    $(window).on('resize.jqGrid', function () {
        $(grid_selector).jqGrid( 'setGridWidth', $("#contentJgGrid").width() );
    });

    var $grid = $("#grid-table"),
        cbColModel;
    idsOfSelectedRows = [];
    selectedND = []
    var datas = <?php  echo $record; ?> ;
    $grid.jqGrid({
        datatype: "local",
        data : datas,
        colModel: [
            { label: 'ID', name: 'ID', key: true, width:5, sorttype:'number', editable: true,hidden:true },
            { label: 'ND ', name: 'ND', width:110, align:"left",sorttype:'string',searchoptions:{sopt:['cn','eq']}}
        ],
        width: 600,
        height: 250,
        scrollOffset:0,
        rowNum:10,
        viewrecords: true,
        // rowList:[10,20,50],
        sortname: 'ND', // default sorting ID
        rownumbers: true, // show row numbers
        rownumWidth: 35, // the width of the row numbers columns
        sortorder: 'DESC',
        gridview: true,
        // altRows: true,
        shrinkToFit: true,
        // multiselect: true,
        multiPageSelection: true,
        //multiSort : true,
        // multikey: "ctrlKey",
        loadonce: true,
        // multiboxonly: true,
        pager: '#grid-pager',
        jsonReader: {
            root: 'Data',
            id: 'id',
            repeatitems: false
        },
        onSelectRow: function (rowid,isSelected) {
            var p = this.p, item = p.data[p._index[rowid]], i = $.inArray(rowid, idsOfSelectedRows);
            item.cb = isSelected;
            if (!isSelected && i >= 0) {
                idsOfSelectedRows.splice(i,1); // remove id from the list
                selectedND.splice(i,1);
            } else if (i < 0) {
                idsOfSelectedRows.push(rowid);
                selectedND.push($grid.jqGrid ('getCell', rowid, 'ND'));
              //  var selectedND  = ;
            }
        },
        loadComplete : function() {
			 //$("#cb_" + this.id).click();
			 
		 
            var p = this.p, data = p.data, item, $this = $(this), index = p._index, rowid;
            for (rowid in index) {
                if (index.hasOwnProperty(rowid)) {
                    item = data[index[rowid]];
                    if (typeof (item.cb) === "boolean" && item.cb) {
                        $this.jqGrid('setSelection', rowid, false);
                    }
                }
            }
            var table = this;
            setTimeout(function(){
                //  styleCheckbox(table);
                //  updateActionIcons(table);
                updatePagerIcons(table);
                enableTooltips(table);
            }, 0);
        },
        caption:"List ND"
    });
    jQuery("#grid-table").jqGrid('filterToolbar',{searchOperators : true});

   //  $("#cb_" + $grid[0].id).hide();
	
	// $("#cb_" + $grid[0].id).click(function () {
		   // var tot_rows=$("#grid-table").jqGrid('getGridParam', 'records');
		   // var grid = $("#grid-table");
		   // grid.jqGrid('resetSelection');
			// var ids = grid.getDataIDs();
			// for (var i=0, il=tot_rows.length; i < il; i++) {
				
				// alert(ids.length);
				// $("#jqg_grid-table_" + ids[i]).click();
			//	grid.jqGrid('setSelection',ids[i], true);
			// }
	// });	
	
	
   // $("#jqgh_" + $grid[0].id + "_cb").addClass("ui-jqgrid-sortable");
    cbColModel = $grid.jqGrid('getColProp', 'cb');
    cbColModel.sortable = true;
    cbColModel.sorttype = function (value, item) {
        return typeof (item.cb) === "boolean" && item.cb ? 1 : 0;
    };
    //navButtons grid master
    $grid.jqGrid('navGrid','#grid-pager',
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
    ).navButtonAdd('#grid-pager',{
            caption:"Create Batch X",
            buttonicon:"ace-icon fa-pencil green",
            position:"last",
            title: "Create Batch",
            cursor: "pointer",
            onClickButton: createBatchND,
            id :"reset"
        });

	// $(".select_continent").click(function () {
	  // alert(this.attr('value'));
	// });	
		
    function createBatchND() {
            $.ajax({
                url: '<?php echo site_url('loaddata/createBatchND');?>',
                data: {mitra:$("#mitra").val(),id_ten:$("#list_cc").val()},
                type: 'POST',
                success: function ( data ) {
                    $("#create_batch").notify("Success",
                        {className :"success",
                            globalPosition: 'right',
                            position: 'right',
                            autoHideDelay: 2000
                        }
                    );
                    $('#grid-table').trigger( 'reloadGrid' );
                }
            });
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