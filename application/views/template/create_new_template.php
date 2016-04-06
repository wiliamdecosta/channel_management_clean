<script rel="javascript" type="text/javascript" src="<?php echo base_url();?>assets/js/jsPDF-master/jspdf.js"></script>
<script rel="javascript" type="text/javascript" src="<?php echo base_url();?>assets/js/jsPDF-master/plugins/from_html.js"></script>
<script rel="javascript" type="text/javascript" src="<?php echo base_url();?>assets/js/jsPDF-master/plugins/split_text_to_size.js"> </script>
<script rel="javascript" type="text/javascript" src="<?php echo base_url();?>assets/js/jsPDF-master/plugins/standard_fonts_metrics.js"></script>
<script rel="javascript" type="text/javascript" src="<?php echo base_url();?>assets/js/jsPDF-master/plugins/standard_fonts_metrics.js"></script>
<script rel="javascript" type="text/javascript" src="<?php echo base_url();?>assets/js/jsPDF-master/dist/jspdf.debug.js"></script>
<script rel="javascript" type="text/javascript" src="<?php echo base_url();?>assets/js/jsPDF-master/plugins/addimage.js.js"></script>
<script rel="javascript" type="text/javascript" src="<?php echo base_url();?>assets/js/ckfinder/ckfinder.js"></script>
<script rel="javascript" type="text/javascript" src="<?php echo base_url();?>assets/js/ckeditor/ckeditor.js"></script>


	<style>
        .divScroll {
            overflow-y:scroll;
            height:100%;
            width:320px;
			}
			#table-wrapper {
			position:relative;
			}
			#table-scroll {
			  overflow:auto;			  
			}
			.table-wrapper
{
    border: 1px;
    width: 160px;
    height: 600px;
    overflow: auto;
}
			#table-wrapper table {
			  width:100%;

			}
			#table-wrapper table * {
			  background:yellow;
			  color:black;
			}
			#table-wrapper table thead th .text {
			  position:absolute;   
			  top:-20px;
			  z-index:2;
			  height:20px;
			  width:35%;
			  border:1px solid red;
			tbody {
				width: 200px;
				height: 400px;
				overflow: auto;
}
			}
    </style>
	
<div id="create_template"><form>
	<?php 
		$this->load->library('ckeditor');
	?>	
		<div class="row">
			<div id="disappear_immediately" class="col-lg-6"> 
				<label for="email"> Document Name  :  </label>
				<div class="row">
					<div class="col-lg-6" >
						<input type="email" id="doc_name_field"class="required form-control col-lg-4 col-md-3 col-sm-3 col-xs-6" maxlength ="40"  placeholder="Tulis nama file disini">
					</div>
					<div class="col-lg-3">
						<a class="btn btn-white btn-sm btn-round" id="create_template_btn"><i class="ace-icon fa fa-plus blue"></i>Create Template</a>
					</div>
					<div class="col-lg-3">
						<a class="btn btn-white btn-sm btn-round" id="view_template_btn"><i class="ace-icon fa fa-plus blue"></i>View Template Available</a>
					</div>
				</div>				
			</div>
			<div class="col-lg-4">			
			</div>
		</div>		
		</br>
		<div class="row" id="button_temp">
			<div class="col-lg-3"></div>
			<div class="col-lg-8">
					<!-- <a id="add_template" class="btn btn-white btn-sm btn-round">
							<i class="ace-icon fa fa-plus blue"></i>
							Add Template</a> -->
			</div>
		</div>
		</br>
		<div class="row" id="pilih_temp">
			<div class="col-xs-11">
				<select onchange="getval(this);">
				<option>Pilih Template</option>
				<?php
				foreach ($result3 as $content){
					echo '<option value="'.$content->TEMPLATE_ID.'">';
					echo $content->TEMPLATE_NAME;
					echo'</option>';
				}
				?>
				</select>
			</div>
		</div>
		<div class="row" id="edit_menu">
			<div class="row" id="all_ckedit" class="col-xs-12">
				<div class="col-xs-9">
					<form id="text_editor" method="post">
					<div class="table-responsive">					
						<textarea id="editor2" class="edit1"></textarea>					
					</div>
				</div>
				<div class="col-xs-3">
				<div class="widget-box">
											<div class="widget-header widget-header-flat widget-header-small">
												<h5 class="widget-title">
													<i class="ace-icon fa fa-signal"></i>
													Variable 
												</h5>

												<div class="widget-toolbar no-border">
													<div class="inline dropdown-hover">
														<button class="btn btn-minier btn-primary">
															Table Name
															<i class="ace-icon fa fa-angle-down icon-on-right bigger-110"></i>
														</button>														
													</div>
												</div>
											</div>

											<div class="widget-body">
												<div class="widget-main" id="var_main">

														<!-- /section:custom/extra.grid -->
													</div>
												</div><!-- /.widget-main -->
						</div><!-- /.widget-body -->
				</div>
			</div>
			</br>
			<div class="row">
				<div class="col-lg-9"></div>
				<div class="col-lg-3">
						<a id="add_variable" class="btn btn-white btn-sm btn-round" value="" data-target="#myModal" data-toggle="modal">
								<i class="ace-icon glyphicon glyphicon-plus green"></i>
								Add Variable</a>			
						<a id="save_temp" class="btn btn-white btn-sm btn-round" value="">
								<i class="ace-icon fa fa-floppy-o blue"></i>
								Save Template</a>
				<div id="num_of_var"></div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-9"></div>
				<div class="col-lg-3">
						<a id="cancel_temp" class="btn btn-white btn-sm btn-round">
								<i class="ace-icon fa fa-times red2"></i>
								Cancel</a>
				</div>
			</div>
		</div>
		<div>
		<div class="col-xs-12" id="table_temp_content">
		</div>
		<div class="row">
			<div id="view_contents2">
				<div id="view_contents3">
				</div>				
				<div>
						<a id="cancel_temp2" class="btn btn-white btn-sm btn-round">
									<i class="ace-icon fa fa-times red2"></i>
									Close</a>
				</div>
			</div>
		</div>
		<div>
			<div class="modal fade" id="myModal" role="dialog">
							<div class="modal-dialog">							
							  <!-- Modal content-->
							  <div class="modal-content">
								<div class="modal-header">
								  <button type="button" class="close" data-dismiss="modal">&times;</button>
								  <h4 class="modal-title">Modal Header</h4>
								</div>
								<div class="modal-body">
									<div class="row">
										<div id="disappear_immediately" class="col-lg-4"> 
											<div>
												<select id="select_table"></select>
											</div>		
										</div>
										<div class="col-lg-4">
												<a class="btn btn-white btn-sm btn-round" id="variable_btn"><i class="ace-icon fa fa-plus blue"></i>Refresh</a>
										</div>		
									</div>
									<div id="variable_adder" class="row">
									</div>
								</div>
									<div class="modal-footer">
									  <button type="button" class="btn btn-default" data-dismiss="modal"id="tambah_var">Add</button>
									  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									</div>
							  </div>
							  
							</div>
			</div>
		</div>
<script>		
		$('#Finishing_Edit').click(function () {
			var doc_nama = $("#docx_name").val();
			var doc_dscrpt = $("#docx_descript").val();
			var username_session = "<?php echo $this->session->userdata('d_user_name') ?>";
			var lang_option = $('#Bhs').val();
			var	update_dt = "<?php echo date("d/m/Y") ?>";
			var source = CKEDITOR.instances.editor2.getData().trim();
			
			if ( doc_nama.length == 0  || doc_dscrpt.length == 0  || lang_option == 0 || source == 0 ){
					swal("Gagal","Template Tidak Berhasil Tersimpan. Coba cek apakah semua box sudah terinput.","error");
				}else{						
				$.ajax({				
					type: "POST",
				   dataType: "html",
					url: "<?php echo site_url('template/parseBackTemplate');?>",
					data: {
							title1:doc_nama, title2:doc_dscrpt, title3:source,
							title4: username_session, title5: lang_option, title6: update_dt
						},
						success: function (data) {
					 		swal("Sukses","Template Berhasil Tersimpan","success");
						
						}						, 
						error: function(data, xhr, ajaxOptions, thrownError){						
						swal("Error",xhr.status+"  "+ thrownError,"error");
						}
				});
				}
				
			})		
		$('#dwnld_pdf').click (function(){
			var source = CKEDITOR.instances.editor2.getData();
			if (source.length > 0)
			{
					var docpdf = new jsPDF('p', 'pt', 'letter');
					margins = { top: 60, bottom: 60, left: 40, width: 500 };
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
					source,margins.left,margins.top,
						{
						'width':margins.width, 'elementHandlers' : elmtHandler 
						}, 
						function(dispose){docpdf.output("dataurlnewwindow");}, margins);
					//docpdf.output("dataurlnewwindow");
			}							
				else {
				swal("Perhatian","Isi terlebih dahulu sebelum diconvert ke PDF","info");
				}
		})
		$('#add_template').click (function(){
			$('#edit_menu').show(1000);
			$('#button_temp').hide(1000);
			edit_or_add = false;
		});
		$('#cancel_temp2').click (function(){
			$('#edit_menu').show(1000);
			$('#view_contents3').hide(1000);
			$('#cancel_temp2').hide(1000);
			edit_or_add = false;
		});
		$('#tambah_var').click (function(){
			j = $('#num_of_var').val();
			alert(j);
			for (var i = 0; i < j+1; i++){
			dataAddedA = $('#btn_val'+ i).text();
			dataAdded = String(dataAddedA);
			dataAddedB = $('#tablet_val'+ i).text();
			dataAdded2 = String(dataAddedB);
			if(dataAdded.length >0 ){
				$('#var_main').prepend($('<div onclick="insert_ckeditor(\''+i+'\')" id="insert'+i+'" value="'+dataAdded+'||'+dataAdded2+'"><a btn btn-sm btn-default>Add</a><div id="numdat'+i+'">'+dataAdded+'||'+dataAdded2+'</div></div>'));
				}
			}
		});
		function insert_ckeditor(val){
			CKEDITOR.instances['editor2'].insertText($("#numdat"+val).text());
		}
		$('#add_variable').click(function(){
			$('#select_table').children().remove();
			$('#variable_adder').children().remove();
			$('#select_table').children().prepend('<select id="select_table"></select>');
			$.ajax({				
					type: "POST",
				   dataType: "json",
				   data:{},
					url: "<?php echo site_url('template/get_table_name_var');?>",					
						success: function (data) {						
							for (var i = 0; i < data.length; i++) {
								$('#select_table').prepend($('<option value='+ data[i].TABLE_NAME +'>'+ data[i].TABLE_NAME +'</option>'
									));								
							}
							$('#num_of_var').val(data.length);
							alert($('#num_of_var').val());
							$('#select_table').prepend($('<option>Pilih tabel</option>'));
						}, 
						error: function(data, xhr, ajaxOptions, thrownError){						
						swal("Error",xhr.status+"  "+ thrownError,"error");
						} 
			});
		});
		
		$('#create_template_btn').click (function(){
			var doc_title = $('#doc_name_field').val();
			$.ajax({				
					type: "POST",
				   dataType: "html",
				   data:{t_name: doc_title},
					url: "<?php echo site_url('template/get_table_template');?>",					
						success: function (data) {
							$('#disappear_immediately').hide(1000);
					 		$("#table_temp_content").html(data);
						}, 
						error: function(data, xhr, ajaxOptions, thrownError){						
						swal("Error",xhr.status+"  "+ thrownError,"error");
						} 
				});
		});
		$('#view_template_btn').click (function(){			
			$.ajax({				
					type: "POST",
				   dataType: "html",
				   data:{},
					url: "<?php echo site_url('template/get_table_temp');?>",					
						success: function (data) {
							$('#disappear_immediately').hide(1000);
					 		$("#table_temp_content").html(data);
						}, 
						error: function(data, xhr, ajaxOptions, thrownError){						
						swal("Error",xhr.status+"  "+ thrownError,"error");
						} 
				});
		});
		
		$('#cancel_temp').click (function(){
			$('#edit_menu').hide(1000);
			$('#table_id').show(1000);			
		} );
		$('#cancel_temp2').click (function(){
			$('#edit_menu').hide(1000);
			$('#table_id').show(1000);			
		} );
		$('#variable_btn').click (function(){
			value_table	= $("#select_table option:selected").text();
			$.ajax({
					type:"POST",
				   dataType: "json",
				   data: {val_table : value_table},
					url: "<?php echo site_url('template/get_variable_content');?>",
						success: function (data) {
							// CKEDITOR.instances['editor2'].setData(data);
							j = 0;
							for (var i = 0; i < data.length; i++) {
								$('#variable_adder').prepend($('<div class="row margin-top-20"><div class="col-lg-4">'
									+'<button class="btn btn-sm btn-default btn-block disabled" id="btn_val'+j+'">'+ data[i].VARIABLE_NAME +'</button></div>'
									+'<div class="col-lg-4"><button class="btn btn-sm btn-default btn-block disabled" id="tablet_val'+j+'">'+ $("#select_table option:selected").text() +'</button></div>'
									+'<div class="col-lg-4"><a id="hidwing'+j+'" onclick="hide1(\''+j+'\')" val="1" class="btn btn-primary btn-sm">Delete</a>'
									+'</div></div>'
									));
							j++;	
							}
						},						
						error: function(data, xhr, ajaxOptions, thrownError){						
						// swal("Error",xhr.status+"  "+ thrownError,"error");
						}
			});				
		} );
		
		function hide1(val){
			$('#hidwing'+val).parent().parent().remove();
		}
		$('#edit_template').click (function(){
			$('#pilih_temp').show(1000);
			edit_or_add = true;
			$.ajax({				
				   dataType: "json",
					url: "<?php echo site_url('template/get_content');?>",
						success: function (data) {				 		
							// CKEDITOR.instances['editor2'].setData(data);
						},						
						error: function(data, xhr, ajaxOptions, thrownError){						
						// swal("Error",xhr.status+"  "+ thrownError,"error");
						}
				});	
		});
		function getval(sel) {
			// alert(sel.value);
			$.ajax({				
					type: "POST",
				   dataType: "html",
				   data:{id:sel.value},
					url: "<?php echo site_url('template/get_content_template');?>",					
						success: function (data) {
					 		CKEDITOR.instances['editor2'].setData(data);
							$('#edit_menu').show();
						}, 
						error: function(data, xhr, ajaxOptions, thrownError){						
						swal("Error",xhr.status+"  "+ thrownError,"error");
						} 
				});	
			}
		var edit_or_add = true;
		$('#save_temp').click (function(){		
		var template_id = $('#save_temp').val();
		alert(template_id);
		var template_content = CKEDITOR.instances['editor2'].getData();
		var var_collection = new Array();
		j = $('#num_of_var').val();
		alert(j);
			 $('div','#var_main').each(function(){
                 var_collection.push($(this).attr('value'));
			});
			inputxxxx_value = var_collection.toString();
			alert(inputxxxx_value);
			$('div','#var_main').each(function(){
                 $(this).remove();
			});
		if (edit_or_add){
			$.ajax({				
					type: "POST",
				   dataType: "html",
					url: "<?php echo site_url('template/setUpdateTemplate');?>",
					data: {
							t_name : template_id, t_content : template_content, var_c : var_collection
						},
						success: function (data) {
					 		swal("Sukses","Template Berhasil Tersimpan","success");
							$('#edit_menu').hide(1000);
							$('#table_id').show(1000);
						}, 
						error: function(data, xhr, ajaxOptions, thrownError){						
						swal("Error",xhr.status+"  "+ thrownError,"error");
						}
				});			
		} else{
		if(($('#docx_name').val()).length == 0 || (CKEDITOR.instances['editor2'].getData()).length == 0){
			swal("Peringatan","Masukkan terlebih dahulu kelengkapan dokumen","error");
		} else {
		$.ajax({				
					type: "POST",
				   dataType: "html",
					url: "<?php echo site_url('template/saveNewTemplate');?>",
					data: {
							t_name : template_name, t_content : template_content
						},
						success: function (data) {
					 		swal("Sukses","Template Berhasil Tersimpan","success");
							// CKEDITOR.instances['editor2'].setData("");
						}, 
						error: function(data, xhr, ajaxOptions, thrownError){						
						swal("Error",xhr.status+"  "+ thrownError,"error");
						}
				});
			$('#edit_menu').hide(1000);
			$('#button_temp').show(1000);
		};
		}
		});
 $(document).ready(function () {
	var editor = CKEDITOR.replace( 'editor2', {
        height: 350,
        filebrowserBrowseUrl : '<?php echo base_url();?>assets/js/ckfinder/ckfinder.html',
        filebrowserImageBrowseUrl : '<?php echo base_url();?>assets/js/ckfinder/ckfinder.html?type=Images',
        filebrowserFlashBrowseUrl : '<?php echo base_url();?>assets/js/ckfinder/ckfinder.html?type=Flash',
        filebrowserUploadUrl : '<?php echo base_url();?>assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
        filebrowserImageUploadUrl : '<?php echo base_url();?>assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
        filebrowserFlashUploadUrl : '<?php echo base_url();?>assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
     });
     CKFinder.setupCKEditor( editor, '../' );
	$('#text_editor').hide();
	$('#backtoback').hide();
	$('#pilih_temp').hide();
	$('#edit_menu').hide();
	$('#view_contents2').hide();
	// $('.edit1').hide();
 });
</script>
