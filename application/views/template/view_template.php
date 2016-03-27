<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.custom.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/chosen.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/datepicker.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-timepicker.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/daterangepicker.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-datetimepicker.css" />
<script rel="javascript" type="text/javascript" src="<?php echo base_url();?>assets/js/ckfinder/ckfinder.js"></script>
<script rel="javascript" type="text/javascript" src="<?php echo base_url();?>assets/js/ckeditor/ckeditor.js"></script>
<script rel="javascript" type="text/javascript" src="<?php echo base_url();?>assets/js/jsPDF-master/jspdf.js"></script>
<script rel="javascript" type="text/javascript" src="<?php echo base_url();?>assets/js/jsPDF-master/plugins/from_html.js"></script>
<script rel="javascript" type="text/javascript" src="<?php echo base_url();?>assets/js/jsPDF-master/plugins/split_text_to_size.js"> </script>
<script rel="javascript" type="text/javascript" src="<?php echo base_url();?>assets/js/jsPDF-master/plugins/standard_fonts_metrics.js"></script>
<script rel="javascript" type="text/javascript" src="<?php echo base_url();?>assets/js/jsPDF-master/plugins/standard_fonts_metrics.js"></script>
<script rel="javascript" type="text/javascript" src="<?php echo base_url();?>assets/js/jsPDF-master/dist/jspdf.debug.js"></script>
<script rel="javascript" type="text/javascript" src="<?php echo base_url();?>assets/js/jsPDF-master/plugins/addimage.js.js"></script>

<div id="content">
    <div class="breadcrumbs" id="breadcrumbs">
        <?=$this->breadcrumb;?>
    </div>

    <div class="page-content">

        <div class="row">
            <div class="col-xs-12">

                <div class="row">
                    <div class="vspace-12-sm"></div>
                    <div class="col-sm-12">
                        <div class="widget-box transparent">
                            <div class="widget-header red widget-header-flat">
                                <h4 class="widget-title lighter">
                                    <!--                    <i class="ace-icon fa fa-money orange"></i>-->
                                    Template
                                </h4>

                                <div class="widget-toolbar">
                                    <a href="#" data-action="collapse">
                                        <i class="ace-icon fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="widget-body">
                                <br>
									
						<div id="list_template"> <!--harusnya dokPKS -->
							<form class="form-horizontal" role="form">
								<div class="rows">
									<div class="form-group" id="all_table">
										
										<div class="col-xs-12">
													<div class="row">
														<form class="form-horizontal" role="form" id="myform">
														<div class="col-xs-6">
															<div id="notif">
												
															</div>
															
															<div class="form-group">
																<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Nama Segmen </label>
												
																<div class="col-sm-6">
																	 <?php echo combo_segmen(); ?>
																</div>
															</div>
															<div class="form-group">
																<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Nama CC </label>
												
																<div class="col-sm-6">
																	<select class="form-control" id="list_cc">
																		<option>Pilih CC</option>
												
																	</select>
																</div>
															</div>
															<div class="form-group">
																<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Nama Mitra </label>
												
																<div class="col-sm-6">
																	<select class="form-control" id="mitra">
																		<option value="">Pilih Mitra</option>
																	</select>
																</div>
															</div>
												
															<div class="form-group">
																<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Nama Lokasi PKS </label>
												
																<div class="col-sm-6">
																	  <select class="form-control" id="lokasisewa">
																			<option value="">Pilih Lokasi PKS</option>
																		</select>
																</div>
															</div>
														</div>
														<div class="col-xs-6">
															<div id="notif">
												
															</div>
												
															<div class="form-group">
																<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tipe Dokumen </label>
												
																<div class="col-sm-6">
																	<select class="form-control" id="tipe_doc">
																		<option value="">Pilih Tipe Dokumen</option>
																		<?php foreach ($result2 as $content) {
																			echo "<option value='" . $content->LISTING_NO . "'>" . $content->CODE . "</option>";
																		}
																		?>
																	</select>
																</div>
															</div>
															<div class="form-group">
																<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Nama Dokumen </label>
												
																<div class="col-sm-6">
																	<input type="text" class="col-xs-10 col-sm-5 required form-control" id="docx_name" name="docx_nama" placeholder="Tulis nama file disini">
																</div>
															</div>
															<div class="form-group">
																<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">Deskripsi </label>
																<div class="col-sm-6">
																	<input type="text"  class="col-xs-10 col-sm-5 required form-control" id="docx_descript" name="docx_deskrip" placeholder="Tulis deskripsi disini">
																</div>
															</div> 
															<div class="form-group">
																<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Bahasa </label>
												
																<div class="col-sm-6">
																	<select class="form-control" id="Bhs">
																		<option>Pilih Bahasa</option>
																		<?php foreach ($result3 as $content) {
																			echo "<option value='" . $content->LISTING_NO . "'>" . $content->CODE . "</option>";
																		}
																		?>
												
																	</select>
																</div>
															</div>
														<div class="form-group">
																<label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> </label>
																<div class="col-sm-6">
																	<a id="submitform" class="fm-button ui-state-default ui-corner-all fm-button-icon-right ui-reset btn btn-sm btn-info">
																		Simpan
																		</a>
																	</div>
															</div> 
														</div>
														</form>
													</div>
												
												
										</div>
										
										<div class="col-xs-12">
												<div class="clearfix">
												</div>
												<div class="table-header">
													Daftar Template
												</div>
												<div>
													<table id="dynamic-table" class="table table-striped table-bordered table-hover">
														<thead>
														<tr>									
															<th class="center">NO</th>
															<th class="center"> Nama Dokumen</th>
															<th class="center"> Jenis Dokumen</th>
															<th class="center"> Deskripsi</th>
															<th class="center"> Jenis Bahasa</th>
															<th class="center"> Lokasi</th>
															<th class="center"> Periode</th>
															<th class="center"> Action </th>
														</tr>
														</thead>
														<tbody>
						
														<?php $i = 1;
														
														foreach ($result1 as $content){
						
															?>
															<tr value="<?php echo $content->DOC_ID; ?>" data-id="<?php echo $content->DOC_NAME;?>" class="table_head">
																<td class="center"><?php echo $i; ?> </td>
																<td><?php echo $content->DOC_NAME; ?></td>
																<td class="center" value="1XKLI"> <?php echo $content->DOC_TYPE_NAME; ?> </td>
																<td> <?php echo $content->DESCRIPTION; ?> </td>
																<td class="class1" id="classic" value="1XKLI"> <?php echo $content->LANG; ?> </td>
																<td> <?php foreach ($result4 as $content2){
																	if($content->LOKASI_ID == $content2->P_MP_LOKASI_ID){
																		echo $content2->LOKASI;
																	}
																}  ?> </td>
																<td class="class1" id="classic" value="1XKLI"> <?php echo $content->PERIODE; ?> </td>
																<td>
																	<div class="hidden-sm hidden-xs action-buttons">
																		<a class="purple" data-rel="tooltip" data-original-title="Download">
																			<i class="ace-icon fa fa-download bigger-130"></i>
																		</a>
						
																		<a class="blue" data-rel="tooltip" data-original-title="View" onClick="Back()">
																			<i class= "ace-icon fa fa-search-plus bigger-130"></i>
																		</a>
						
																		<a class="green" data-rel="tooltip" data-original-title="Edit" onClick="Back2()">
																			<i class="ace-icon fa fa-pencil bigger-130"></i>
																		</a>
						
																		<a class="red " data-rel="tooltip" data-original-title="Delete" >
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
																											<i class="ace-icon fa fa-download bigger-120">ss</i>
																										</span>
																					</a>
																				</li>
						
																				<li>
																					<a class="tooltip-info" data-rel="tooltip" title="View" onClick="Back()">
																										<span class="blue">
																											<i class="ace-icon fa fa-search-plus bigger-120"></i>
																										</span>
																					</a>
																				</li>
						
																				<li>
																					<a  class="tooltip-success" data-rel="tooltip" title="Edit" onClick="Back2()">
																										<span class="green">
																											<i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
																										</span>
																					</a>
																				</li>
						
																				<li>
																					<a class="tooltip-error" data-rel="tooltip" title="Delete" >
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
											</div>
									</div>
								</div>
							</form>
						</div>
						<div id="all_view">
							<div id="texteditorOne">
								<textarea id="textarea1" readonly>
								</textarea>
							</div>
							<div id="texteditorTwo">
								<textarea id="textarea2">
								</textarea>
							</div></br>
							<div id="buttonOne">
								<a id="submitform" class="fm-button ui-state-default ui-corner-all fm-button-icon-right ui-reset btn btn-sm btn-info" value="" onClick="showTable()"><span>
								Back</span></a>
							</div>
							<div id="hiddenval" style="display: none;"><input type="text" id="test3" value="LALALALA"></div>
						</div>
                               
                            </div><!-- PAGE CONTENT ENDS -->
                        </div>
                    </div>
                </div><!-- /.widget-box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
</div>

<script type="text/javascript">
    $('.date-picker').datepicker({
        autoclose: true,
        todayHighlight: true
    })
        //show datepicker when clicking on the icon
        .next().on(ace.click_event, function(){
            $(this).prev().focus();
        });
		
</script>
<script type="text/javascript">
jQuery(function($) {
    //initiate dataTables plugin
    var oTable1 =
        $('#dynamic-table')
            //.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
            .dataTable( {
				// "columnDefs": [
				// { className: "hide_column", "targets": [ 0 ] }
				// ]
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
	
	$(document).on('click', '#dynamic-table .tooltip-download', function(e) {
		
		var id_DOC = $(this).closest('tr').attr('value');
		var name = $(this).closest('tr').attr('data-id');
		// test1 = $(this).closest('a').attr('value');
		// var rowData = this.cells;
		// var ccf = rowData[0].firstChild.value;
		
		$.ajax({
                type: "POST",
				url: "<?php echo base_url(); ?>"+"template/POST_idDOC",
                data:  {id_doc: id_DOC},
				dataType:"text",
				success: function(data){
					if (data.length > 0){
						var docpdf = new jsPDF('p', 'pt', 'letter');
						margins = { top: 20, bottom: 20, left: 20, width: 595 };
						var elmtHandler = 
						{
							'#CreateReport' : function (elmtHandler, renderer){
							return true;	
						},
							'#PrintReport' : function (elmtHandler, renderer){
							return true;	
						},
						'#ignorePDF': function (element, renderer) {
						return true;}
						};				
						docpdf.fromHTML(
						data,margins.left,margins.top,
							{
							'width':margins.width, 'elementHandlers' : elmtHandler 
							}, 
							function(dispose){docpdf.save(name);}, margins);
					}
                }
		});
		
    });
	
	$(document).on('click', '#dynamic-table .tooltip-error', function(e) {
		var id_DOC = $(this).closest('tr').attr('value');
		var aPos = oTable1.fnGetPosition( $(this).closest('tr').get(0) );
		oTable1.fnDeleteRow(aPos);		
		$.ajax({
                type: "POST",
				url: "<?php echo base_url(); ?>"+"template/delete_DOC",
                data:  {id_doc: id_DOC},
				dataType:"text",
				success: function(data){
					swal("Sukses","Data template berhasil dihapus","success");					
                }
		});
    });


    //And for the first simple table, which doesn't have TableTools or dataTables
    //select/deselect all rows according to table header checkbox
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
        var $parent = $source.closest('table')
        var off1 = $parent.offset();
        var w1 = $parent.width();

        var off2 = $source.offset();
        //var w2 = $source.width();

        if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
        return 'left';
    }

    $(function() {
       // $( document ).tooltip();
    });
	
})
  var editor = CKEDITOR.replace( 'textarea1', {
        height: 350,
		toolbar : 'Custom',
		toolbar_Custom: [],
        filebrowserBrowseUrl : '<?php echo base_url();?>assets/js/ckfinder/ckfinder.html',
        filebrowserImageBrowseUrl : '<?php echo base_url();?>assets/js/ckfinder/ckfinder.html?type=Images',
        filebrowserFlashBrowseUrl : '<?php echo base_url();?>assets/js/ckfinder/ckfinder.html?type=Flash',
        filebrowserUploadUrl : '<?php echo base_url();?>assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
        filebrowserImageUploadUrl : '<?php echo base_url();?>assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
        filebrowserFlashUploadUrl : '<?php echo base_url();?>assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
     });
     CKFinder.setupCKEditor( editor, '../' );
	   var editor2 = CKEDITOR.replace( 'textarea2', {
        height: 350,
        filebrowserBrowseUrl : '<?php echo base_url();?>assets/js/ckfinder/ckfinder.html',
        filebrowserImageBrowseUrl : '<?php echo base_url();?>assets/js/ckfinder/ckfinder.html?type=Images',
        filebrowserFlashBrowseUrl : '<?php echo base_url();?>assets/js/ckfinder/ckfinder.html?type=Flash',
        filebrowserUploadUrl : '<?php echo base_url();?>assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
        filebrowserImageUploadUrl : '<?php echo base_url();?>assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
        filebrowserFlashUploadUrl : '<?php echo base_url();?>assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
     });
     CKFinder.setupCKEditor( editor, '../' );
$(document).ready(function () {
	var edit = true;
		jQuery("#texteditorOne").hide();
		jQuery("#buttonOne").hide();		
		jQuery("#texteditorTwo").hide();		
    });

	
	function deltemplate(){
		$('#dynamic-table tbody').on('click', 'tr', function () {
			var id_DOC = $(this).attr('value');			
			$.ajax({
                type: "POST",
				url: "<?php echo base_url(); ?>"+"template/deltemplate",
                data:  {id_doc: id_DOC},
				dataType:"text",
				success: function(data){
				CKEDITOR.instances["textarea1"].setData(data);
                }
                });
		});	
	}
	
	function Back(){
		edit = false;
		$('#submitform span').text('Back to table');
		jQuery("#all_table").hide(1000);
		jQuery("#texteditorOne").show(1000);		
		jQuery("#buttonOne").show(1000);
		$('#dynamic-table tbody').on('click', 'tr', function () {
			var id_DOC = $(this).attr('value');			
			$.ajax({
                type: "POST",
				url: "<?php echo base_url(); ?>"+"template/POST_idDOC",
                data:  {id_doc: id_DOC},
				dataType:"text",
				success: function(data){
				CKEDITOR.instances["textarea1"].setData(data);
                }
                });
		});	
	}
	
	
	function showTable(){
		jQuery("#texteditorOne").hide(1000);
		jQuery("#texteditorTwo").hide(1000);		
		jQuery("#buttonOne").hide(1000);
		jQuery("#all_table").show(1000);
			    DOC_content = CKEDITOR.instances["textarea2"].getData();
				// encode to base 64 // mar 28032016 
				DOC_content = btoa(DOC_content);
			// var res = str.replace("&zenzenzenzenzen", "'");
			if (edit){
				ID = $('#submitform').val();				
				$.ajax({
                type: "POST",
				url: "<?php echo base_url(); ?>"+"template/update_Content",
                data:  {docx_contents: DOC_content, idx : ID},
				dataType:"text",
				success: function(data){
					swal("Sukses","Data template berhasil diupdate","success");
                }					
                });
			}			
	}
	function Back2(){
		edit = true;
		$('#submitform span').text('Finish Edit');
		jQuery("#all_table").hide(1000);
		jQuery("#texteditorTwo").show(1000);		
		jQuery("#buttonOne").show(1000);
		$('#dynamic-table tbody').on('click', 'tr', function () {
			var id_DOC = $(this).attr('value');			
			$.ajax({
                type: "POST",
				url: "<?php echo base_url(); ?>"+"template/POST_idDOC",
                data:  {id_doc: id_DOC},
				dataType:"text",
				success: function(data){
				CKEDITOR.instances["textarea2"].setData(data);
				$('#submitform').val(id_DOC);				
                }
                });
		});	
	}
	

	  $("#mitra").change(function () {
        var mitra = $("#mitra").val();

        // Animasi loading

        if (mitra) {
            $.ajax({
                type: "POST",
                dataType: "html",
                url: "<?php echo site_url('cm/listTenant');?>",
                data: {id_mitra: mitra},
                success: function (msg) {
                    // jika tidak ada data
                    if (msg == '') {
                        alert('Tidak ada tenant');
                    }
                    else {
                        $("#list_cc").html(msg);
                    }
                }
            });
        } else {
            $("#list_cc").html('<option> Pilih CC </option>');
        }
    });
	
</script>

<script>
    function checkFilter() {
        v_str = "";
        if ($("#segment").val() == "") {
            v_str += "* Segmen belum dipilih\n";
        }
        if ($("#list_cc").val() == "") {
            v_str += "* CC belum dipilih\n";
        }
        if ($("#mitra").val() == "") {
            v_str += "* Mitra belum dipilih\n";
        }
        if ($("#lokasisewa").val() == "") {
            v_str += "* Lokasi PKS belum dipilih\n";
        }

        if (v_str != "") {
            swal("", v_str, "warning");
            return false;
        }
        else {
            return true;
        }
    }
</script>
<script>
    $(document).ready(function () {
		$('#submitform').click(function(){
			var cek = checkFilter();
			if (cek) {
                var doc_nama = $("#docx_name").val();
				var doc_dscrpt = $("#docx_descript").val();
				var username_session = "<?php echo $this->session->userdata('d_user_name') ?>";
				var lang_option = $('#Bhs').val();
				var	update_dt = "<?php echo date("d/m/Y"); ?>";
				var lokasi_pks = $('#lokasisewa').val();
				var doc_type = $('#tipe_doc').val();
				
				if ( doc_nama.length == 0  || doc_dscrpt.length == 0  || lang_option.length == 0 ){
						swal("Perhatian","Harap cek kelengkapan data","warning");
					}else{						
					$.ajax({				
						type: "POST",
					   dataType: "html",
						url: "<?php echo site_url('template/addTemplate');?>",
						data: {
								nama:doc_nama, desc:doc_dscrpt,
								userid: username_session, bahasa: lang_option, update_date: update_dt,
								lokasi_pks:lokasi_pks, doc_type:doc_type
							},
							success: function (data) {
								swal("Sukses","Data berhasil tersimpan","success");
							
							}						, 
							error: function(data, xhr, ajaxOptions, thrownError){						
							swal("Error",xhr.status+"  "+ thrownError,"error");
							}
					});
					}
				
            }else{
				checkFilter();
			}
			// reload page
			$('#list_template').click();
			//-----------------------------//
			
		});
		
		
		
        function empty_cc() {
            $('#list_cc').html('<option value=""> Pilih CC </option>');
        }

        function empty_mitra() {
            $('#mitra').html('<option value=""> Pilih Mitra </option>');
        }

        function empty_lokasi() {
            $('#lokasisewa').html('<option value=""> Pilih Lokasi Sewa </option>');
        }

//        ----------------------------------------------------------------------------
        $("#segment").change(function () {
            empty_cc();
            empty_mitra();
            empty_lokasi();
            var segmen = $('#segment').val();
            if (segmen) {
                loadcc();
            } else {
                empty_cc();
                empty_mitra();
                empty_lokasi();
            }
        });
//     -----------------------------------------------------------------------------

        $("#list_cc").change(function () {
            empty_mitra();
            empty_lokasi();
            var list_cc = $('#list_cc').val();
            if (list_cc) {
                loadmitra();
            } else {
                empty_mitra();
                empty_lokasi();
            }

        });

//        ------------------------------------------------------------------
        $("#mitra").change(function () {
            empty_lokasi();
            var mitra = $('#mitra').val();
            if (mitra) {
                loadlokasi();
            } else {
                empty_lokasi();
            }

        });

    });
</script>
<script type="text/javascript">
    function loadcc() {
        var segmen = $("#segment").val();
        $.ajax({
            // async: false,
            cache: false,
            url: "<?php echo base_url();?>managementmitra/listCC",
            type: "POST",
            data: {segmen: segmen},
            beforeSend: function () {

            },
            success: function (data) {
                $('#list_cc').html(data);

            }
        });
    }
</script>
<script type="text/javascript">
    function loadmitra() {
        var ccid = $("#list_cc").val();
        $.ajax({
            //async: false,
            url: "<?php echo base_url();?>managementmitra/listMitra",
            type: "POST",
            data: {ccid: ccid},
            success: function (data) {
                $('#mitra').html(data);

            }
        });
    }
</script>
<script type="text/javascript">
    function loadlokasi() {
        var mitra = $("#mitra").val();
        $.ajax({
            //async: false,
            url: "<?php echo base_url();?>managementmitra/listLokasiSewa",
            type: "POST",
            data: {mitra: mitra},
            success: function (data) {
                $('#lokasisewa').html(data);

            }
        });
    }
</script>
