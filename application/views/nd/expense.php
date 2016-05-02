<?php $prv = getPrivilege($menu_id); ?>
<div id="content">
    <!-- #section:basics/content.breadcrumbs -->
    <div class="breadcrumbs" id="breadcrumbs">
        <?=$this->breadcrumb;?>
    </div>

    <!-- /section:basics/content.breadcrumbs -->
    <div class="page-content">

        <div id="table-content">
            <div class="col-xs-12">

                <div id="table">
                    <table id="grid-table"></table>
                    <div id="grid-pager"></div>
                    <br>
                    <div id="process"></div>

                    <div id="detailsPlaceholder" style="display:none">
                        <table id="jqGridDetails"></table>
                        <div id="jqGridDetailsPager"></div>
                    </div>
                </div>
                <!-- PAGE CONTENT BEGINS -->



                <!-- PAGE CONTENT ENDS -->
            </div><!-- /.col -->
        </div><!-- /.row -->


        <div id="period" style="display: none">
            <div class="col-xs-12">
                <div class="well well-sm">
                    <div class="inline middle blue bigger-150" id="application_form_title">Pilih Periode Expense</div>
                </div>
                <form class="form-horizontal" application="form" id="application_form">
                    <input type="hidden" id="batch_id" value="">
                    <input type="hidden" id="copy_batch" value="0">
                    <div class="row">
                        <div class="col-xs-4">
                            <!-- #section:plugins/date-time.datepicker -->
                            <div class="input-group">
                                <label class="control-label bolder blue">Pilih Tahun</label>
                                <select class="form-control" id="tahun">
                                    <option value=""> Pilih Tahun</option>
                                    <?php
                                    $year = date("Y");
                                    for($i = ($year); $i >= $year-5; $i--){
                                        echo "<option value=$i>$i</option>";
                                    }
                                    ?>

                                </select>
                            </div>
                        </div>
                        <div class="col-xs-8">
                            <div class='control-group'>
                                <label class="control-label bolder blue">Daftar Period</label>
                                <div id="checkbox_period">
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="clearfix form-actions">
                        <div class="center col-md-9">
                            <button type="button" class="btn btn-primary btn-round" id="save_batch">
                                <i class="ace-icon fa fa-floppy-o bigger-120"></i>
                                Submit
                            </button>

                            <button type="reset" class="btn btn-danger btn-round" id="cancel_batch">
                                <i class="glyphicon glyphicon-circle-arrow-left bigger-120"></i>
                                Cancel
                            </button>

                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- View modal ND-->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">LIST ND</h4>
                    </div>
                    <div class="modal-body">
                        <table id="gridND"></table>
                        <div id="gridNDpager"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>


    </div><!-- /.page-content -->
</div> <!-- /.content -->


<script type="text/javascript">
    // Hide Show
    jQuery('#create_batch').click(function(){
       // $('#table-content').hide("drop", { direction: "down" }, "fast");
        $('#table-content').hide("slow");
       // $('#new_batch').show("drop", { direction: "top" }, "slow");
        $('#new_batch').show("slow");
    });
    // Hide Show Cancel
    jQuery('#cancelUpload').click(function(){
        //$('#new_batch').hide("drop", { direction: "top" }, "fast");
        $('#new_batch').hide("fast");
        //$('#table-content').show("drop", { direction: "down" }, "slow");
        $('#table-content').show("slow");
        //$('#filename').();
        $(".remove").trigger('click');
    });
    // Hide cancel period
    jQuery('#cancel_batch').click(function(){
        $('#period').hide("fast");
        $('#table-content').show("slow");
        $("#copy_batch").val(0); // Set state to insert periode

    });
    $('#filename').ace_file_input({
        no_file:'No File ...',
        btn_choose:'Choose',
        btn_change:'Change',
        droppable:false,
        onchange:null,
        thumbnail:false //| true | large
        //whitelist:'gif|png|jpg|jpeg'
        //blacklist:'exe|php'
        //onchange:''
        //
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
            var grid_selector = "#grid-table";
            var pager_selector = "#grid-pager";

            //resize to fit page size
            $(window).on('resize.jqGrid', function () {
                $(grid_selector).jqGrid( 'setGridWidth', $(".page-content").width() );
            })

         jQuery("#grid-table").jqGrid({
                 url:'<?php echo site_url('nd/gridBatchND');?>',
                 datatype: "json",
                 mtype: "POST",
                 //colNames:['Inv No','Date', 'Client', 'Amount','Tax','Total','Notes'],
                 colModel: [
                     { label: 'ID', name: 'BATCH_CONTROL_ID', key: true, width:10, sorttype:'number', editable: false,hidden:true },
                     { label: 'Tanggal Batch', name: 'START_DATE', width:125, align:"left", editable:false},
                     { label: 'P_PROCESS_STATUS_ID', name: 'P_PROCESS_STATUS_ID', width:125, align:"left", editable:false,hidden:true},
                     { label: 'Proses', name: 'JOB_CODE', width:155, align:"left", editable:false},
                     { label: 'Status Proses', name: 'STATUS_CODE', width:125, align:"left", editable:false},
                     { label: 'Diproses Oleh', name: 'UPDATE_BY', width:135, align:"left", editable:false},
                     { label: 'Awal Proses', name: 'START_PROCESS', width:135, align:"left", editable:false},
                     { label: 'Akhir Proses', name: 'END_PROCESS', width:135, align:"left", editable:false},
                     { label: 'Deskripsi', name: 'DESCRIPTION', width:165, align:"left", editable:false}
                 ],
                 width: 1120,
                 //width: '100%',
                 height: '100%',
                 autowidth: true,
                 rowNum:5,
                 viewRecords: true,
                 rowList:[5,10,20],
                 sortname: 'BATCH_CONTROL_ID ', // default sorting ID
                 rownumbers: true, // show row numbers
                 rownumWidth: 35, // the width of the row numbers columns
                 sortorder: 'DESC',
                 altRows: true,
                 shrinkToFit: true,
                 //multiselect: true,
                 //multikey: "ctrlKey",
                 multiboxonly: true,

                    // Show hide button process
                 beforeSelectRow: function (rowid) {
                     var selRowId = $(this).getGridParam('selrow'),
                         tr = $(this.rows.namedItem(rowid)),
                         celValue = $('#grid-table').jqGrid ('getCell', rowid, 'P_PROCESS_STATUS_ID');
                         thisId = $.jgrid.jqID(this.id);

                     if (celValue == 5) {
                         $("#process_btn").show();
                         //$("#saparator").show();
                         $("#period_btn").show();
                         $("#copy_btn").hide();
                        // $("#edit_" + thisId).removeClass('ui-state-disabled');
                     } else {
                        // alert('dalam proses');
                         $("#process_btn").hide();
                        // $("#saparator").hide();
                         $("#period_btn").hide();
                         $("#copy_btn").show();

                        // $("#del_" + thisId).addClass('ui-state-disabled');
                     }
                     return true; // allow selection or unselection
                 },

                 subGrid: true, // set the subGrid property to true to show expand buttons for each row
                 subGridRowExpanded: showChildGrid, // javascript function that will take care of showing the child grid
                 subGridOptions : {
                     // load the subgrid data only once
                     // and the just show/hide
                     reloadOnExpand :false,
                     // select the row when the expand column is clicked
                     selectOnExpand : false,
                     plusicon : "ace-icon fa fa-plus center bigger-110 blue",
                     minusicon  : "ace-icon fa fa-minus center bigger-110 blue"
                    // openicon : "ace-icon fa fa-chevron-right center orange"
                 },

                 onSelectRow: function(rowid) {
                    var celValue = $('#grid-table').jqGrid ('getCell', rowid, 'JOB_CODE');
                    var grid_id = jQuery("#jqGridDetails");
                     var gridND_id = jQuery("#gridND");
                    if(rowid != null) {
                        grid_id.jqGrid('setGridParam',{url:"<?php echo site_url('loaddata/LogProcess');?>/"+rowid,datatype: 'json',postData:{batch_id:rowid}, userData:{tes:rowid}});
                        grid_id.jqGrid('setCaption', 'Laporan Batch Detail :: '+celValue);

                        gridND_id.jqGrid('setGridParam',{url:"<?php echo site_url('nd/gridND');?>",datatype: 'json',postData:{batch_id:rowid}});
                       // gridND_id.jqGrid('setCaption', 'Tenant');

                        jQuery("#detailsPlaceholder").show();
                        grid_id.trigger("reloadGrid");
                        jQuery("#gridND").trigger("reloadGrid");
                        $("#batch_id").val(rowid);

                    }
                }, // use the onSelectRow that is triggered on row click to show a details grid
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
                    $("#process_btn").show();

                    var table = this;
                    setTimeout(function(){
                      //  styleCheckbox(table);

                      //  updateActionIcons(table);
                        updatePagerIcons(table);
                        enableTooltips(table);
                    }, 0);
                },
                //memanggil controller jqgrid yang ada di controller crud
                caption:"Proses Expense"

         });

    });
    function showChildGrid(parentRowID, parentRowKey) {
        var childGridID = parentRowID + "_table";
        var childGridPagerID = parentRowID + "_pager";

        // send the parent row primary key to the server so that we know which grid to show
        var childGridURL = "<?php echo site_url('loaddata/job_control');?>/" + encodeURIComponent(parentRowKey)

        // add a table and pager HTML elements to the parent grid row - we will render the child grid here
        $('#' + parentRowID).append('<table id=' + childGridID + '></table><div id=' + childGridPagerID + ' class=scroll></div>');

        $("#" + childGridID).jqGrid({
            url: childGridURL,
            mtype: "POST",
            datatype: "json",
            page: 1,
            rownumbers: true, // show row numbers
            rownumWidth: 35,
            shrinkToFit: false,
//            scrollbar : false,
            postData:{batch_id:encodeURIComponent(parentRowKey)},
            colModel: [
                { label: 'ID', name: 'JOB_CONTROL_ID', key: true, width:10, sorttype:'number', editable: false,hidden:true },
                { label: 'Periode', name: 'PERIODE', width:125, align:"left", editable:false},
                { label: 'Job Code', name: 'JOB_CODE', width:205, align:"left", editable:false},
                { label: 'Status', name: 'CODE', width:155, align:"left", editable:false}
            ],
//            loadonce: true,
            width: 600,
            height: '100%',
            jsonReader: {
                root: 'Data',
                id: 'id',
                repeatitems: false
            }
//            pager: "#" + childGridPagerID
        });

    }


    //JqGrid Detail
    $("#jqGridDetails").jqGrid({
        mtype: "POST",
        datatype: "json",
        page: 1,
        colModel: [
           // { label: 'ID', name: 'BATCH_ID', key: true, width: 35, editable: true,hidden:true },
           // { label: 'Parent', name: 'MENU_PARENT', width: 65, editable: true, hidden:false,editoptions: {size:30, maxlength: 15} },
            { label: 'Log Date', name: 'LOG_DATE', width: 140 },
            { label: 'Log Message', name: 'LOG_MSG', width: 145, editable: true },
            { label: 'Code', name: 'CODE', width: 145, editable: true }
        ],
        width: 1120,
        height: '100%',
//        scrollOffset: 0,
        rowNum: 5,
        shrinkToFit: true,
//        loadonce: true,
        rownumbers: true,
        rownumWidth: 35, // the width of the row numbers columns
        viewrecords: true,
        sortname: 'COUNTER ', // default sorting ID
       // caption: 'Menu Child',
        sortorder: 'asc',
        pager: "#jqGridDetailsPager",
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
        editurl: '<?php echo site_url('admin/crud_detail');?>'
    });

    //navButtons grid master
    jQuery('#grid-table').jqGrid('navGrid','#grid-pager',

        { 	//navbar options
            edit: false,
            excel:false,
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
    ).navButtonAdd('#grid-pager',{
            caption:" ",
            buttonicon:"ace-icon fa fa-list-alt green",
            onClickButton: viewND,
            position:"firts",
            title: "View ND",
            cursor: "pointer",
            id :"viewND_btn"
    }).navButtonAdd('#grid-pager',{
            caption:"",
            buttonicon:"ui-separator",
            id:"saparator"
    })<?php if($prv['SUBMIT'] == 'Y'){;?>
        .navButtonAdd('#grid-pager',{
            caption:" ",
            buttonicon:"ace-icon fa fa-gear purple",
            onClickButton: getSelectedRow,
            position:"last",
            title: "process",
            cursor: "pointer",
            id :"process_btn"
        })
    <?php };?>
   .navButtonAdd('#grid-pager',{
            caption:" ",
            buttonicon:"ace-icon fa fa-calendar red",
            onClickButton: insertPeriod,
            position:"last",
            title: "Insert Period",
            cursor: "pointer",
            id :"period_btn"
    }).navButtonAdd('#grid-pager',{
            caption:" ",
            buttonicon:"ace-icon fa fa-files-o green",
            onClickButton: copyBatch,
            position:"last",
            title: "Copy Batch",
            cursor: "pointer",
            id :"copy_btn"
    });

    function viewND(){
        var rowKey =  $("#grid-table").jqGrid('getGridParam','selrow');
        if (rowKey){
            $('#myModal').modal('show');
        }
        else{
            // alert("Please Select Row !!!");
            $.jgrid.viewModal("#alertmod_" + this.id, {toTop: true, jqm: true});
        }

    }

    // Fn insert period
    function insertPeriod() {
        var grid = $("#grid-table");
        var rowKey = grid.jqGrid('getGridParam','selrow');

        if (rowKey){
            $("#copy_batch").val(0);
            $('#table-content').hide("slow");
            $('#period').show("fast");
        }
        else{
            // alert("Please Select Row !!!");
            $.jgrid.viewModal("#alertmod_" + this.id, {toTop: true, jqm: true});
        }

    }
    // Fn copy period
    function copyBatch() {
        var grid = $("#grid-table");
        var rowKey = grid.jqGrid('getGridParam','selrow');

        if (rowKey){
            $("#copy_batch").val(1);
            $('#table-content').hide("slow");
            $('#period').show("fast");
        }
        else{
            // alert("Please Select Row !!!");
            $.jgrid.viewModal("#alertmod_" + this.id, {toTop: true, jqm: true});
        }

    }

    function getSelectedRow() {
        var grid = $("#grid-table");
        var rowKey = grid.jqGrid('getGridParam','selrow');
        if(rowKey){
            var c = confirm('Apakah anda akan melakukan process batch?');
            if(c == true){
                // Cek Periode
                var chk = checkPeriod(rowKey);
                if(chk >0){
                    $.ajax({
                        url: '<?php echo site_url('loaddata/processBatch');?>',
                        data: {batch_id:rowKey},
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
                            $('#jqGridDetails').trigger( 'reloadGrid' );

                        }
                    });
                }
                else{
                    alert("Periode belum ada, Silahkan isi periode terlebih dahulu.");
                }

            }else{
                return false;
            }
        }
        else{
            $.jgrid.viewModal("#alertmod_" + this.id, {toTop: true, jqm: true});
        }

    }

    // Function checkPeriod
    function checkPeriod(rowKey){
        var response = null;
        $.ajax({
            url: '<?php echo site_url('nd/checkPeriod');?>',
            data: {batch_id:rowKey},
            type: 'POST',
            //dataType: 'text',
            async: false,
            success: function (data ) {
                response = data;
            }
        });
        return response;
    }



    //navButtons Grid Detail
    jQuery('#jqGridDetails').jqGrid('navGrid','#jqGridDetailsPager',
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
            editData: {MENU_PARENT: function (){
                var data =  jQuery("#jqGridDetails").jqGrid('getGridParam', 'postData');
                var parent_id  = data.parent_id;
                return parent_id;
            }},
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

            editData: {MENU_PARENT: function (){
                var data =  jQuery("#jqGridDetails").jqGrid('getGridParam', 'postData');
                var parent_id  = data.parent_id;
                return parent_id;
            }},
            onClickButton : function() {
                alert('sss');
            },
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
            //closeAfterSearch: true,
            recreateForm: true,
            afterShowSearch: function(e){
                var form = $(e[0]);
                form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
                style_search_form(form);
            },
            afterRedraw: function(){
                style_search_filters($(this));
            }

           // multipleSearch: true
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
    );

    function clearSelection() {
        //jQuery("#jqGridDetails").jqGrid('setGridParam',{url: "empty.json", datatype: 'json'}); // the last setting is for demo purpose only
       // jQuery("#jqGridDetails").jqGrid('setCaption', 'Menu Child ::');
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

    // Grid List ND
    jQuery("#gridND").jqGrid({
        datatype: "json",
        mtype: "POST",
        //colNames:['Inv No','Date', 'Client', 'Amount','Tax','Total','Notes'],
        colModel: [
            { label: 'ID', name: 'ND', key: true, width:10, sorttype:'number', editable: false,hidden:true },
            { label: 'TEN_ID', name: 'TEN_ID', width:75, align:"left", editable:false},
            { label: 'ND', name: 'ND', width:155, align:"left", editable:false},
            { label: 'VALID_FROM', name: 'VALID_FROM', width:125, align:"left", editable:false},
            { label: 'VALID_TO', name: 'VALID_TO', width:125, align:"left", editable:false}
        ],
        width: '550',
        //width: '100%',
        height: '350',
        //autoWidth: true,
        rowNum:10,
        rowList:[10,30,50],
        sortname: 'ND ', // default sorting ID
        rownumbers: true, // show row numbers
        rownumWidth: 35, // the width of the row numbers columns
        sortorder: 'DESC',
        altRows: true,
        shrinkToFit: false,
        //multiselect: true,
        //multikey: "ctrlKey",
        multiboxonly: true,
        viewRecords: true,
        onSelectRow: function() {
        },
        onSortCol : clearSelection,
        onPaging : clearSelection,
        pager: '#gridNDpager',
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
        }

    });

    //navButtons grid master
    jQuery('#gridND').jqGrid('navGrid','#gridNDpager',

        { 	//navbar options
            edit: false,
            excel:false,
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

</script>
<script type="text/javascript">

    $(document).ready(function() {
        $('#tahun').change(function() {
            var nilai = $(this).val();
            if(!nilai){
                // Remove checkbox content
                $('#checkbox_period').html("");
            }else{
                addCheckbox(nilai);
            }
        });
    });

    function addCheckbox(name) {
        var container = $('#checkbox_period');
        var inputs = container.find('input');
        var id = inputs.length+1;

        var i;
        var input = '';
        var tgl = ''
        for (i = 1; i <= 12; i++) {
            if(i<10){
                tgl = '0'+i;
            }else{
                tgl = i;
            }

            input += "<div class='checkbox'><label> <input name='form-field-checkbox[]' id='check_id' type='checkbox' class='ace' value="+name+""+tgl+"><span class='lbl'> "+name+""+tgl+"</span></label>";
            //container.html($('<input />', { type: 'checkbox', id: 'cb'+id, value: name }));
            //container.html( $('<label />', { 'for': 'cb'+id, text: name }));
        }

        container.html(input);
        //  container.html( $('<label />', { 'for': 'cb'+id, text: name }));

    }
    jQuery("#save_batch" ).click(function() {


        // Get value checked
        var val = [];
        $(':checkbox:checked').each(function(i){
            val[i] = $(this).val();

        });
        // Cek Apakah tahun sudah dipilih
        var thn = $('#tahun').val();
        if(!thn) {
            alert ('Silahkan pilih tahun !!!');
            return false;
        }
        if(val.length == 0){
            alert ('Silahkan pilih periode !!!');
            return false;
        }

        var c =  confirm('Apakah Anda yakin menambahkan periode ?');
        if(c == true){

            var batch_id = $("#batch_id").val();
            var copy_val = $("#copy_batch").val();
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('nd/expensePeriod');?>',
                data: {periode:val,batch_id:batch_id,copy:copy_val},
                success: function(data) {
                    $('#period').hide("fast");
                    $('#table-content').show("slow");
                    $("#copy_batch").val(0); // Set state to insert periode
                    $('#application_form')[0].reset(); // Reset value form
                    $('#checkbox_period').html(""); // Clear checkbox
                    jQuery("#grid-table").trigger("reloadGrid");
                    jQuery("#jqGridDetails").trigger("reloadGrid");
                },
                error: function(jqXHR, textStatus, errorThrown){
                    // alert(errorThrown);
                    $("#ajaxContent").html(errorThrown);
                    $("#copy_batch").val(0); // Set state to insert periode
                },
                timeout: 10000 // sets timeout to 10 seconds
            })
            return false;

        }

    });
</script>