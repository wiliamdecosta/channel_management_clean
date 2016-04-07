<script rel="javascript" type="text/javascript" src="<?php echo base_url();?>assets/js/dataTables/fnreloadajax.js"></script>
<div id="table_id">
	<div>
											<div class="clearfix">
											</div>
											<div class="table-header" id="header_tab">
													Daftar Template
											</div>
											<div>
												<div>
													<table id="dynamic-table" class="table table-striped table-bordered table-hover">
														<thead>
														<tr>									
															<th class="center">NO</th>
															<th class="center"> Nama Dokumen</th>
															<th class="center"> Variable</th>
															<th class="center"> Action </th>
														</tr>
														</thead>
														<tbody>
						
														<?php $i = 1;
														
														 foreach ($result3 as $content)
														{
						
															?>
															<tr class="table_head" value="<?php echo $content->TEMPLATE_ID ?>" >
																<td class="center"><?php echo $i ?></td>
																<td class="center" value="1XKLI"><?php echo $content->TEMPLATE_NAME ?></td>
																<td class="class1" id="classic" value="1XKLI"><?php echo $content->VARIABLE_TEMPLATE ?></td>
																
																<td>
																	<div class="hidden-sm hidden-xs action-buttons">
																		<a class="purple" data-rel="tooltip" data-original-title="Download">
																			<i class="ace-icon fa fa-download bigger-130"></i>
																		</a>
						
																		<a id="tooltip_view" class="blue" data-rel="tooltip" data-original-title="View" onclick="view_contents1()">
																			<i class= "ace-icon fa fa-search-plus bigger-130"></i>
																		</a>
						
																		<a id="tooltip_edit" class="green" data-rel="tooltip" data-original-title="Edit Content">
																			<i class="ace-icon fa fa-pencil bigger-130"></i>
																		</a>
																		<a id="tooltip_edit_name" class="green " data-rel="tooltip" data-original-title="Edit Name" data-target="#myModal2" data-toggle="modal">
																			<i class="ace-icon fa fa-pencil-square-o bigger-130"></i>
																		</a>
																		<a id="tooltip_delete" class="red " data-rel="tooltip" data-original-title="Delete" >
																			<i class="ace-icon fa fa-trash-o bigger-130"></i>
																		</a>																		
																	</div>
						
																	<div class="hidden-md hidden-lg">
																		<div class="inline pos-rel">
																			<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
																				<i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
																			</button>
						
																			<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
																				<li>
																					<a  class="tooltip-download" data-rel="tooltip" value="" title="Download">
																										<span class="blue">
																											<i class="ace-icon fa fa-download bigger-120"></i>
																										</span>
																					</a>
																				</li>
																				</li>
						
																				<li>
																					<a id="tooltip_view" class="tooltip-view-name" data-rel="tooltip" title="View" onclick="view_contents1()">
																										<span class="blue">
																											<i class="ace-icon fa fa-search-plus bigger-120"></i>
																										</span>
																					</a>
																				</li>
						
																				<li>
																					<a id="tooltip_edit" class="tooltip-edit" data-rel="tooltip" title="Edit">
																										<span class="green">
																											<i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
																										</span>
																					</a>
																				</li>
																				
																				<li>
																					<a id="tooltip_edit_name" class="tooltip-edit" data-rel="tooltip" title="Edit Name"  data-target="#myModal2" data-toggle="modal">
																										<span class="green">
																											<i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
																										</span>
																					</a>
																				</li>
						
																				<li>
																					<a id="tooltip_delete" class="tooltip-delete" data-rel="tooltip" title="Delete" >
																										<span class="red">
																											<i class="ace-icon fa fa-trash-o bigger-120"></i>
																										</span>
																					</a>
																				</li>                                                       
						
																			</ul>
																		</div>
																	</div>
																</td>
															</tr>
															<?php
															$i++;
														}
						
														?>
														</tbody>
													</table>
												</div>
				<div class="modal fade" id="myModal2" role="dialog">
							<div class="modal-dialog">							
							  <!-- Modal content-->
							  <div class="modal-content">
								<div class="modal-header">
								  <button type="button" class="close" data-dismiss="modal">&times;</button>
								  <h4 class="modal-title">Change Document Title</h4>
								</div>
								<div class="modal-body">
								<div class="row">
									<div class="col-lg-3"></div>
										<div class="col-lg-6">
										<input id="temp_name_field"class="required form-control col-lg-4 col-md-3 col-sm-3 col-xs-6" maxlength ="40"  value="">
										</div>
									<div class="col-lg-3" id="id_name_temp"></div>
								</div>
								<div class="row"></br></div>
									<div class="modal-footer">									  
									  <button type="button" class="btn btn-default" data-dismiss="modal"id="change_name">Change</button>
									  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									</div>
							  </div>
							  
							</div>
			</div>
			</div>
	</div>
	<div id="view_content_temp">	
	</div>
</div>
				
<script>
jQuery(function($) {
    //initiate dataTables plugin
    var oTable1 =
        $('#dynamic-table')
            //.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
            .dataTable( {
				"columnDefs": [
				{ "width": "5%", "targets": 0 },							
				{ "width": "20%", "targets": 3 }				
				// { className: "hide_column", "targets": [ 0 ] }
				 ]
				// "aoColumnDefs": [{ "bVisible": false, "aTargets": [1] }]
            } );
    //TableTools settings
    TableTools.classes.container = "btn-group btn-overlap";
    TableTools.classes.print = {
        "body": "DTTT_Print",
        "info": "tableTools-alert gritter-item-wrapper gritter-info gritter-center white",
        "message": "tableTools-print-navbar"
    }
    //initiate TableTools extension
    var tableTools_obj = new $.fn.dataTable.TableTools( oTable1, {
        "sSwfPath": "../assets/js/dataTables/extensions/TableTools/swf/copy_csv_xls_pdf.swf", //in Ace demo ../assets will be replaced by correct assets path

        "sRowSelector": "td:not(:last-child)",
        "sRowSelect": "multi",
        "fnRowSelected": function(row) {
            //check checkbox when row is selected
            try { $(row).find('input[type=checkbox]').get(0).checked = true }
            catch(e) {}
        },
        "fnRowDeselected": function(row) {
            //uncheck checkbox
            try { $(row).find('input[type=checkbox]').get(0).checked = false }
            catch(e) {}
        },

        "sSelectedClass": "success",
        "aButtons": [
            {
                "sExtends": "copy",
                "sToolTip": "Copy to clipboard",
                "sButtonClass": "btn btn-white btn-primary btn-bold",
                "sButtonText": "<i class='fa fa-copy bigger-110 pink'></i>",
                "fnComplete": function() {
                    this.fnInfo( '<h3 class="no-margin-top smaller">Table copied</h3>\
									<p>Copied '+(oTable1.fnSettings().fnRecordsTotal())+' row(s) to the clipboard.</p>',
                        1500
                    );
                }
            },

            {
                "sExtends": "csv",
                "sToolTip": "Export to CSV",
                "sButtonClass": "btn btn-white btn-primary  btn-bold",
                "sButtonText": "<i class='fa fa-file-excel-o bigger-110 green'></i>"
            },

            {
                "sExtends": "pdf",
                "sToolTip": "Export to PDF",
                "sButtonClass": "btn btn-white btn-primary  btn-bold",
                "sButtonText": "<i class='fa fa-file-pdf-o bigger-110 red'></i>"
            },

            {
                "sExtends": "print",
                "sToolTip": "Print view",
                "sButtonClass": "btn btn-white btn-primary  btn-bold",
                "sButtonText": "<i class='fa fa-print bigger-110 grey'></i>",
                "sMessage": "<div class='navbar navbar-default'><div class='navbar-header pull-left'><a class='navbar-brand' href='#'><small>Optional Navbar &amp; Text</small></a></div></div>",
                "sInfo": "<h3 class='no-margin-top'>Print view</h3>\
									  <p>Please use your browser's print function to\
									  print this table.\
									  <br />Press <b>escape</b> when finished.</p>"
            }
        ]
    } );
    //we put a container before our table and append TableTools element to it
    $(tableTools_obj.fnContainer()).appendTo($('.tableTools-container'));

    //also add tooltips to table tools buttons
    //addding tooltips directly to "A" buttons results in buttons disappearing (weired! don't know why!)
    //so we add tooltips to the "DIV" child after it becomes inserted
    //flash objects inside table tools buttons are inserted with some delay (100ms) (for some reason)
    setTimeout(function() {
        $(tableTools_obj.fnContainer()).find('a.DTTT_button').each(function() {
            var div = $(this).find('> div');
            if(div.length > 0) div.tooltip({container: 'body'});
            else $(this).tooltip({container: 'body'});
        });
    }, 200);

    //ColVis extension
    var colvis = new $.fn.dataTable.ColVis( oTable1, {
        "buttonText": "<i class='fa fa-search'></i>",
        "aiExclude": [0, 6],
        "bShowAll": true,
        //"bRestore": true,
        "sAlign": "right",
        "fnLabel": function(i, title, th) {
            return $(th).text();//remove icons, etc
        }

    });

    //style it
    $(colvis.button()).addClass('btn-group').find('button').addClass('btn btn-white btn-info btn-bold')

    //and append it to our table tools btn-group, also add tooltip
    $(colvis.button())
        .prependTo('.tableTools-container .btn-group')
        .attr('title', 'Show/hide columns').tooltip({container: 'body'});

    //and make the list, buttons and checkboxed Ace-like
    $(colvis.dom.collection)
        .addClass('dropdown-menu dropdown-light dropdown-caret dropdown-caret-right')
        .find('li').wrapInner('<a href="javascript:void(0)" />') //'A' tag is required for better styling
        .find('input[type=checkbox]').addClass('ace').next().addClass('lbl padding-8');



    /////////////////////////////////
    //table checkboxes
    $('th input[type=checkbox], td input[type=checkbox]').prop('checked', false);

    //select/deselect all rows according to table header checkbox
    $('#dynamic-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
        var th_checked = this.checked;//checkbox inside "TH" table header

        $(this).closest('table').find('tbody > tr').each(function(){
            var row = this;
            if(th_checked) tableTools_obj.fnSelect(row);
            else tableTools_obj.fnDeselect(row);
        });
    });

    //select/deselect a row when the checkbox is checked/unchecked
    $('#dynamic-table').on('click', 'td input[type=checkbox]' , function(){
        var row = $(this).closest('tr').get(0);
        if(!this.checked) tableTools_obj.fnSelect(row);
        else tableTools_obj.fnDeselect($(this).closest('tr').get(0));
    });
    $(document).on('click', '#dynamic-table .dropdown-toggle', function(e) {
        e.stopImmediatePropagation();
        e.stopPropagation();
        e.preventDefault();
    });
	
	$(document).on('click', '#dynamic-table #tooltip_view', function(e) {		
		var id_DOC = $(this).closest('tr').attr('value');		
		$.ajax({
                type: "POST",
				url: "<?php echo base_url(); ?>"+"template/get_content_template",
                data:  {id: id_DOC},
				dataType:"text",
				success: function(data){
					if (data != ""){
						$('#view_contents3').html(data);
						$('#view_contents2').show(1000);
						$('#table_id').hide(1000);
						
					} else
					{
						swal("Perhatian","Template belum ada memiliki isi content","info");
					}
				}
		});		
    });
	
	$(document).on('click', '#dynamic-table #tooltip_edit_name', function(e) {
		var id_DOC = $(this).closest('tr').attr('value');
		// var aPos = oTable1.fnGetPosition( $(this).closest('tr').get(0) );
		// oTable1.fnDeleteRow(aPos);		
		$.ajax({
                type: "POST",
				url: "<?php echo base_url(); ?>"+"template/Name_Temp",
                data:  {id_doc: id_DOC},
				dataType:"json",
				success: function(data){
					$('#temp_name_field').val(data[0].TEMPLATE_NAME);
					$('#id_name_temp').val(id_DOC);
                }
		});
    })
	$(document).on('click', '#change_name', function(e) {
	// $('#change_name').click(function(){
		var id_DOC = $('#id_name_temp').val();
		var name_field = $('#temp_name_field').val();
		// var aPos = oTable1.fnGetPosition( $(this).closest('tr').get(0) );
		// oTable1.fnDeleteRow(aPos);		
		$.ajax({
                type: "POST",
				url: "<?php echo base_url(); ?>"+"template/save_name",
                data:  {id_doc: id_DOC, nm_field : name_field },
				dataType:"json",
				success: function(data){
					swal("Berhasil","Data telah berhasil diubah","success");					
                }, 
				error: function(data, xhr, ajaxOptions, thrownError){
					// swal("Gagal","Database error","error");
				}
		});
		$('#temp_name_field').val("");
		oTable1.fnReloadAjax();
    })
	
	$(document).on('click', '#dynamic-table #tooltip_delete', function(e) {
		var id_DOC = $(this).closest('tr').attr('value');
		var aPos = oTable1.fnGetPosition( $(this).closest('tr').get(0) );
		oTable1.fnDeleteRow(aPos);		
		$.ajax({
                type: "POST",
				url: "<?php echo base_url(); ?>"+"template/delete_Temp",
                data:  {id_doc: id_DOC},
				dataType:"text",
				success: function(data){
					swal("Sukses","Data template berhasil dihapus","success");					
                }
		});
    });
	
	$(document).on('click', '#dynamic-table #tooltip_edit', function(e) {
		var id_DOC = $(this).closest('tr').attr('value');
		$('#save_temp').val(id_DOC);
		$('#edit_menu').show(1000);
		$('#table_id').hide(1000);
		$('#var_main').empty();
		$('#var_main').val(0);
		var_reccur = $('#var_main').val();
		$.ajax({
                type: "POST",
				url: "<?php echo base_url(); ?>"+"template/get_content_template",
                data:  {id: id_DOC},
				dataType:"text",
				success: function(data){
					if (data != ""){
						CKEDITOR.instances['editor2'].setData(data);
					} else
					{
						swal("Perhatian","Template error","info");
					}
				}
		});
		$.ajax({
                type: "POST",
				url: "<?php echo base_url(); ?>"+"template/get_content_variable",
                data:  {id: id_DOC},
				dataType:"json",
				success: function(data){
					for (var i = 0; i < data.length; i++) {
								if(data[i].length >0 ){
									$('#var_main').prepend($('<div id="var_total'+ i + var_reccur +'"><div class="row">'
									+	'<div onclick="insert_ckeditor(\''+i + var_reccur +'\')" id="insert'+ i + var_reccur +'" value="'+data[i]+'" class="col-lg-2">'
									+	'<a class="btn btn-white btn-sm btn-round">Add</a></div>'
									+	'<div onclick="delete_var_all(\''+i + var_reccur +'\')" id="del_var_existing" class="col-lg-2">'
									+	'<a class="btn btn-white btn-sm btn-round">Delete</a>'
									+	'</div>'
									+'</div>'
									+'<div class="row">'
									+	'<div class="col-lg-12" id="numdat'+ i + var_reccur+'">'+data[i]+'</div>'
									+'</div></div>'));
									}
					}
					$('#var_main').val( $('#var_main').val() +  data.length  + 1 );
				}
		});		
    });
	 var active_class = 'active';
    $('#simple-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
        var th_checked = this.checked;//checkbox inside "TH" table header

        $(this).closest('table').find('tbody > tr').each(function(){
            var row = this;
            if(th_checked) $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
            else $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
        });
    });

    //select/deselect a row when the checkbox is checked/unchecked
    $('#simple-table').on('click', 'td input[type=checkbox]' , function(){
        var $row = $(this).closest('tr');		
        if(this.checked) $row.addClass(active_class);
        else $row.removeClass(active_class);		
    });



    /********************************/
        //add tooltip for small view action buttons in dropdown menu
    $('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});

    //tooltip placement on right or left
    function tooltip_placement(context, source) {
        var $source = $(source);
        var $parent = $source.closest('table');
        var off1 = $parent.offset();
        var w1 = $parent.width();
        var off2 = $source.offset();
        //var w2 = $source.width();

        if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
        return 'left';
    }
	
	function view_contents1(){
		 // alert("test 1234");
		$('#dynamic-table tbody').on('click', 'tr', function () {
			var id_DOC = $(this).attr('value');
		// alert(id_DOC);
		});
	}
});
	
</script>