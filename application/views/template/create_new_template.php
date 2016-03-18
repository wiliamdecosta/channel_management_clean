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
		<div id="notif_success"></div>
		<form id="text_editor" method="post">
			 <?php			
			echo '<div class="table-responsive"><table><tr><td>';
			echo '<textarea id="editor2"></textarea>';
			$baseUrl = base_url().'/assets/js/ckfinder/userfiles/';			
			echo '</td><td><div id="table-scroll" class="table-wrapper"><table align="top" width="80%"><tbody>';
			foreach($result as $content){
				echo	'<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>'.$content->HASHTAG;
				echo	'</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td><td>';
				echo	$content->NAME.'</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>';
				};
			echo '</tbody></table></div></td></tr></table></div>'; ?>
	<div id="notif_success"></div>
		<form id="text_editor" method="post"> 
			</br>	   
			<div class="col-xs-3">
				<label for="email">Document Name:</label>
				<input type="email" class="col-xs-10 col-sm-5 required form-control" id="docx_name" name="docx_nama" placeholder="Tulis nama file disini">
			</div>
			<div class="col-xs-6">
				<label for="pwd">Description:</label>
				<input type="text"  class="col-xs-10 col-sm-5 required form-control" id="docx_descript" name="docx_deskrip" placeholder="Tulis deskripsi disini">
			</div></br></br></br></br>
			<div id="Bahasa" class="col-sm-4">
				<select id="Bhs" class="form-control" name="Languages">
					<option value=""> Pilih Bahasa </option>
					<option value="4">BAHASA INDONESIA</option>
					<option value="3">BAHASA INGGRIS</option>
					<option value="2">BILINGUAL</option>
					<option value="1">CUSTOM</option>
				</select>
			</div></br></br></br></br>
			<div>
				<button type="button" class="btn btn-primary btn-xs" id="dwnld_pdf" >Convert and Download PDF</button>&nbsp; 
				<button type="button" class="btn btn-primary btn-xs" id="Finishing_Edit" >Finish Edit</button>
			</div>
			
</form>
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
			
</script>
