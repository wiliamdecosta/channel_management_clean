<!-- #section:basics/content.breadcrumbs -->
<script type="text/css">
    .ui-jqgrid .ui-jqgrid-btable
    {
        table-layout:auto;
    }
</script>
<div class="row" style="margin-top:20px;" id="map_datin_attr">
    <div class="col-xs-12">
        <div class="well well-sm"> <h4 class="blue" id="pgl_acc_num_form_title"> Pilih Pengelola Dan Nama Akun </h4></div>
        <form class="form-horizontal" role="form" id="pgl_acc_num_form">       
            
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right"> Pengelola </label>
                <div class="col-sm-8">
                    <input id="form_pgl_id" type="text" style="display:none;" placeholder="PGL ID">                    
                    <input id="form_pgl_type_id" type="text"  style="display:none;">
                    <input id="form_pgl_code" type="text" class="col-xs-10 col-sm-5 required" placeholder="Pilih Pengelola">
                    <span class="input-group-btn">
						<button class="btn btn-warning btn-sm" type="button" id="btn_lov_pgl">
							<span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
						</button>
					</span>
                </div>                
            </div>                 
            
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right"> Nama Akun</label>
                <div class="col-sm-8">
                    <input id="form_nama_akun_id" type="text" style="display:none;">
                    <input id="form_nama_akun_code" type="text" class="col-xs-10 col-sm-5"  placeholder="Pilih Nama Akun">
                    <span>
						<button class="btn btn-warning btn-sm" type="button" id="btn_lov_user_acc_num">
							<span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
						</button> &nbsp; &nbsp;
					<a id="findFilter" class="fm-button ui-state-default ui-corner-all fm-button-icon-right ui-reset btn btn-sm btn-info">
					<!-- class="fm-button ui-state-default ui-corner-all fm-button-icon-right ui-reset btn btn-sm btn-info || fm-button ui-state-default ui-reset btn btn-sm btn-info center-block -->
					<span class="ace-icon fa fa-search"></span>Find</a>	
					</span>						
                </div>				
            </div>
			
       </form>
    </div>
	<div id="tab-content">            
            <br>
            <div class="col-xs-12" id="tabel_content">
                <br>
                <table id="grid-table"></table>
                <div id="grid-pager"></div>
            </div><!-- /.col -->
        </div>
</div>
<?php $this->load->view('parameter/map_datin_list_pgl.php'); ?>
<?php $this->load->view('parameter/map_datin_list_acc_num.php'); ?>

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
            <!-- PAGE CONTENT ENDS -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.page-content -->
<script type="text/javascript">
	
		$("#findFilter").click(function (){	
			var select_pgl = $("#form_pgl_id").val();
			var select_acc_num = $("#form_nama_akun_code").val();		
			if (select_acc_num.length != 0 ) {
				prepareGridTable();
				$("#tabel_content").show();
			}	
		 else
		{
			swal("Perhatian", "Isilah terlebih dahulu nama akun sebelum melakukan pencarian", "info");
		}
	})
</script>
<script type="text/javascript">

	function prepareGridTable() {
		delete $("#grid-table");
		$("#grid-table").GridUnload("#grid-table");
		
		var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";		
		var select_pgl = $("#form_pgl_type_id").val();
		var pg = $("#form_pgl_code").val();
		var select_acc_num = $("#form_nama_akun_code").val();			
        //resize to fit page size
        $(window).on('resize.jqGrid', function () {
            $(grid_selector).jqGrid('setGridWidth', $(".page-content").width());
        })
        jQuery("#grid-table").jqGrid({
			postData: {pgl_id: select_pgl, account_num: select_acc_num },
			url: '<?php echo site_url('parameter/gridCustMapDatin');?>',
            datatype: "json",
            mtype: "POST",
			caption: "Daftar Data Internet Pengelola-Nomor Akun",
            colModel: [
                {
                    label: 'ID',
                    name: 'PGID',
                    // key: true,
                    width: 35,
                    sorttype: 'number',
                    sortable: true,
                    editable: true,
                    hidden: true,
					editrules: {required: true},
                    //edittype: "select",
					// formatter:{defaultValue: $("#form_pgl_code").val()},
					editoptions: {value: $("#form_pgl_type_id").val()+":"+$("#form_pgl_type_id").val(), defaultValue:$("#form_pgl_type_id").val()},
                },
				{
                    label: 'ACNM',
                    name: 'ANNM',
                    // key: true,
                    width: 35,
                    sorttype: 'number',
                    sortable: true,
                    editable: true,
                    hidden: true,
					editrules: {required: true},
					editoptions: {value: $("#form_nama_akun_code").val()+":"+$("#form_nama_akun_code").val(), defaultValue:$("#form_nama_akun_code").val()},
                },
				
				{
                    label: 'PMD',
                    name: 'PMD',
                    key: true,
                    width: 35,
                    sorttype: 'number',
                    sortable: true,
                    editable: true,
                    hidden: true,					
                },
                {
                    label: 'Created By',
                    name: 'CB',
                    width: 250,
                    align: "left",
                    editable: false,                                      
                },
				{
                    label: 'Updated By',
                    name: 'UB',
                    width: 250,
                    align: "left",
                    editable: false,                                     
                },
				{
                    label: 'Valid From',
                    name: 'VF',
                    width: 250,
                    align: "left",
                    editable: true,                    
                    editoptions: {
						dataInit: function (element) 
						{
                       $(element).datepicker({
			    			autoclose: true,
			    			format: 'dd-mm-yyyy',
			    			orientation : 'bottom'
							});
						}						
					}
                },
                {
                    label: 'Valid Until',
                    name: 'VU',
                    width: 250,
                    align: "left",
                    editable: true,                    
                    editoptions: {
						dataInit: function (element) {
                       $(element).datepicker({
			    			autoclose: true,
			    			format: 'dd-mm-yyyy',
			    			orientation : 'bottom'
                        });
                    }
						
					}
                },
				{
                    label: 'Creation Date',
                    name: 'CD',
                    width: 250,
                    align: "left",
                    sortable: true,
                    editable: true,
                    editoptions: {
						dataInit: function (element) {
                       $(element).datepicker({
			    			autoclose: true,
			    			format: 'dd-mm-yyyy',
			    			orientation : 'bottom'
                        });
                    }
						
					}
                },
                {   
                    label :'Update Date',
                    name : 'UD',
                    width:200,
                    sortable:true,
                    align:'left',
                    editable:true,
                    editoptions: {
						dataInit: function (element) {
                       $(element).datepicker({
			    			autoclose: true,
			    			format: 'dd-mm-yyyy',
			    			orientation : 'bottom'
                        });
                    }
						
					}
                }                     
            ],
            caption: "List Mapping Data Internet",
            width: 1120,
            height: '100%',
            scrollOffset: 0,
            rowNum: 5,
            viewrecords: true,
            rowList: [5, 10, 20],
            //sortname: 'PGL_NAME', // default sorting ID
            rownumbers: true, // show row numbers
            rownumWidth: 35, // the width of the row numbers columns
            sortorder: 'asc',
            altRows: true,
            shrinkToFit: true,
            //multiselect: true,
            //multikey: "ctrlKey",
            multiboxonly: true,
            onSelectRow: function (rowid) {
                var celValue = $('#grid-table').jqGrid('getCell', rowid, 'PGL_NAME');
                var grid_id = jQuery("#jqGridDetails");
                if (rowid != null) {
                    grid_id.jqGrid('setGridParam', {
                        url: "<?php echo site_url('parameter/gridCustTEN');?>/" + rowid,
                        datatype: 'json',
                        postData: {parent_id: rowid},
                        userData: {row: rowid}
                    });
                    grid_id.jqGrid('setCaption', 'TENAN :: ' + celValue);
                    jQuery("#detailsPlaceholder").show();
                    jQuery("#jqGridDetails").trigger("reloadGrid");
                }
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
				$(grid_selector).jqGrid('setGridWidth', $("#tabel_content").width());
                $(pager_selector).jqGrid('setGridWidth', $("#tabel_content").width());
                var table = this;
                setTimeout(function () {
                    //  styleCheckbox(table);

                    //  updateActionIcons(table);
                    updatePagerIcons(table);
                    enableTooltips(table);
                }, 0);
            },
            //memanggil controller jqgrid yang ada di controller crud
            editurl: '<?php echo site_url('parameter/crud_map_datin');?>'
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
					$("#form_pgl_type_id").prop("readonly", true);
					var form = $(e[0]);
					form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
					style_edit_form(form);
					$("#form_nama_akun_code").prop("readonly", true);
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
				beforeShowForm: function (e) {
					var form = $(e[0]);
					form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar')
						.wrapInner('<div class="widget-header" />')
					style_edit_form(form);
				},				
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
				onClickSubmit: function () {
					var gr = jQuery("#grid-table").jqGrid('getGridParam', 'selrow');
					var pmds = jQuery('#grid-table').jqGrid('getCell', gr, 'PMD');			
					return {PMD: pmd};
					
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

				//multipleSearch: true,
				//showQuery: true
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
		)
		
	}	
    $(document).ready(function () {
		
        prepareGridTable();
		$("#tabel_content").hide();
    });
    //JqGrid Detail

    


    function clearSelection() {
        //jQuery("#jqGridDetails").jqGrid('setGridParam',{url: "empty.json", datatype: 'json'}); // the last setting is for demo purpose only
        jQuery("#jqGridDetails").jqGrid('setCaption', 'Menu Child ::');
        jQuery("#jqGridDetails").trigger("reloadGrid");

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

	
// ---------------------------------------- LovGrid Attribute ----------------------------------------
jQuery(function($) {
        $("#user_attribute_form_btn_cancel").on(ace.click_event, function() {
            user_attribute_toggle_main_content();
        });    
        $("#user_attribute_form_btn_save").on(ace.click_event, function() {
            alert("test save");
			//user_attribute_save();
        });        
        $("#btn_lov_pgl").on(ace.click_event, function() {
            modal_lov_map_datin_show("form_pgl_type_id","form_pgl_code");
        });        
        $("#btn_lov_user_acc_num").on(ace.click_event, function() {
            if( $("#form_pgl_type_id").val() == "") {
                //showBootDialog(true, BootstrapDialog.TYPE_WARNING, 'Attention', 'Inputkan Attribute Type Terlebih Dahulu');
                swal("Informasi", "Inputkan Nama Pengelola Terlebih Dahulu", "info");
                return;
            }
            $("#modal_lov_acc_num_grid_selection").bootgrid("destroy");
            modal_lov_map_datin_acc_prepare_table();
            modal_lov_map_datin_acc_show("form_nama_akun_id","form_nama_akun_code");
        });        
        $("#form_valid_from").datepicker({ autoclose: true, todayHighlight: true });
        $("#form_valid_to").datepicker({ autoclose: true, todayHighlight: true });
    });      
	
	$("#add_fastel").click(function () {
        alert($("#form_pgl_type_id").val());
    })
	$("#update_fastel").click(function () {
        alert($("#form_nama_akun_code").val());
    })
</script>
