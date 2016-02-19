<!DOCTYPE html>
<html lang="en">
    <link type="image/x-icon" href="<?php echo base_url(); ?>favicon.png" rel="shortcut icon"/>
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Submit Profile - Channel Management</title>

		<meta name="description" content="overview &amp; stats" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.css" />
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/font-awesome.css" />

		<!-- page specific plugin styles -->

		<!-- text fonts -->
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace-fonts.css" />

		<!-- ace styles -->
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace.css" class="ace-main-stylesheet" id="main-ace-style" />


		<!--[if lte IE 9]>
			<link rel="stylesheet" href="<?php echo BS_CSS_PATH; ?>ace-part2.css" class="ace-main-stylesheet" />
		<![endif]-->

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="<?php echo BS_CSS_PATH; ?>ace-ie.css" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- ace settings handler -->
		<script src="<?php echo base_url();?>assets/js/ace-extra.js"></script>

		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="<?php echo BS_JS_PATH; ?>html5shiv.js"></script>
		<script src="<?php echo BS_JS_PATH; ?>respond.js"></script>
		<![endif]-->

		<!-- basic scripts -->

		<!--[if !IE]> -->
		<script type="text/javascript">
			window.jQuery || document.write("<script src='<?php echo base_url();?>assets/js/jquery.js'>"+"<"+"/script>");
		</script>

		<!-- <![endif]-->

		<!--[if IE]>
        <script type="text/javascript">
         window.jQuery || document.write("<script src='<?php echo BS_JS_PATH; ?>jquery1x.js'>"+"<"+"/script>");
        </script>
        <![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo base_url();?>assets/js/jquery.mobile.custom.js'>"+"<"+"/script>");
		</script>
		<script src="<?php echo base_url();?>assets/js/bootstrap.js"></script>

		<!-- page specific plugin scripts -->

		<!--[if lte IE 8]>
		  <script src="<?php echo BS_JS_PATH; ?>excanvas.js"></script>
		<![endif]-->
		
        <!-- Sweet Alert Dialog -->
		<script src="<?php echo base_url();?>assets/swal/sweetalert.min.js"></script>
        <script src="<?php echo base_url();?>assets/swal/sweetalert-dev.js"></script>
        <link rel="stylesheet" href="<?php echo base_url();?>assets/swal/sweetalert.css" />
        
        <script src="<?php echo base_url();?>assets/js/jquery.blockUI.js"></script>
        
        
	</head>

	<body class="no-skin">
		<!-- #section:basics/navbar.layout -->
		<div id="navbar" class="navbar navbar-default">
			<script type="text/javascript">
				try{ace.settings.check('navbar' , 'fixed')}catch(e){}
			</script>

			<div class="navbar-container" id="navbar-container">

				<!-- /section:basics/sidebar.mobile.toggle -->
				<div class="navbar-header pull-left">
                    <!-- #section:basics/navbar.layout.brand -->
                    <a class="navbar-brand" href="#">
                        <small>
                            <i class="fa fa-leaf"></i>
                            Channel Management
                        </small>
                    </a>
                
                    <!-- /section:basics/navbar.layout.brand -->
                
                    <!-- #section:basics/navbar.toggle -->
                
                    <!-- /section:basics/navbar.toggle -->
                </div>

				<!-- /section:basics/navbar.dropdown -->
			</div><!-- /.navbar-container -->
		</div>

		<!-- /section:basics/navbar.layout -->
		<div class="main-container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>


            <div class="">
               <div class="">
                   <div class="well well-sm">
		               <div class="inline middle blue bigger-110"> <strong> Selamat Datang, Halaman ini disediakan untuk mendaftarkan profile Anda. Silahkan mengisi formulir di bawah ini. Terima Kasih </strong> </div>
		           </div>
               </div>
            </div>
            
            <?php if(!empty($error_message)) :?>
                <script>
                    jQuery(function($) {
                        swal("Perhatian", "<?php echo $error_message; ?>", "warning");
                    });            
                </script>
            <?php else: ?>
            <div id="main-content">
                
                <div class="col-sm-offset-1 col-sm-10">

                    <form class="form-horizontal" id="form-upload-profile" role="form" method="post" enctype="multipart/form-data" action="<?php echo site_url('submit_profile/upload_data');?>" accept-charset="utf-8">
                        <div class="tabbable">
                            <ul class="nav nav-tabs padding-16">
                    			<li class="active">
                    				<a href="#edit-basic" data-toggle="tab">
                    					<i class="green ace-icon fa fa-pencil-square-o bigger-125"></i>
                    					Data Identitas
                    				</a>
                    			</li>
                    			<li>
                    				<a href="#edit-password" data-toggle="tab">
                    					<i class="blue ace-icon fa fa-key bigger-125"></i>
                    					Setting Password
                    				</a>
                    			</li>
                    		</ul>
                    		<div class="tab-content profile-edit-tab-content">
                    		    <div class="tab-pane in active" id="edit-basic">
                    				<h4 class="header blue bolder smaller">Identitas</h4>
                    				
                    				<!-- user id -->
                    				<div class="form-group">
                    					<div class="col-sm-9">
                    						<input type="hidden" id="form-field-user-id-mitra" name="id_mitra" value="<?php echo $user_id_mitra; ?>">
                    						<input type="hidden" id="form-field-user-id-admin" name="id_admin"  value="<?php echo $user_id_admin; ?>">
                    						<input type="hidden" id="form-field-email-admin" name="email_admin" value="<?php echo $email_admin; ?>">
                    					    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                    					</div>
                    				</div>
                    				                    				                    				
                    				<!-- Jenis Identitas -->
                    				<div class="form-group">
                    					<label for="form-field-fullname" class="col-sm-3 control-label no-padding-right">Jenis Identitas</label>
                    					<div class="col-xs-3">
                    						<select id="form-field-jenis-identitas" name="jenis_identitas" class="form-control">
                                                <option value="">Pilih Jenis Identitas</option>
                                            	<option value="KTP">KTP</option>
                                            	<option value="SIM">SIM</option>
                                            </select>
                    					</div>
                    				</div>	
                    				<div class="space-4"></div>
                    				
                    				<!-- File Identitas -->
                    				<div class="form-group">
                    					<label for="form-field-fullname" class="col-sm-3 control-label no-padding-right">File Identitas </label>
                    					<div class="col-xs-5">
                    						<input  type="file" id="form-field-file-name" name="file_name"/>
                    					</div>
                    				</div>
                    					
                    				<div class="space-4"></div>
                    				
                    				
                    				
                    				<div class="space"></div>
                    				<h4 class="header blue bolder smaller">Confidentiality Agreement</h4>
                    
                    				<div class="form-group">
                    					<div class="well well-sm"> 
                    					    Dokumen, informasi/catatan, dan Data Billing yang terkandung di dalamnya 
                    					    hanya digunakan untuk kepentingan Para Pihak (Telkom dan Mitra). 
                    					    Setiap yang mengakibatkan kandungan informasi tersebut diketahui oleh Pihak lain yang tidak berhak, 
                    					    dapat dikenakan sanksi sesuai dengan peraturan yang berlaku.
                    					    <br><br>
                    					    <div class="form-group">
                    					        <div class="col-xs-5">
                                					<label class="middle">
        											    <input type="checkbox" id="form-field-chekbox-agreement" class="ace">
        											    <span class="lbl"> <strong>Ya, Saya menyetujuinya ! </strong></span>
        											</label>        
    										    </div>           					
                    				        </div>
                    					    
                    					    <div>
                    					        <button type="button" class="btn btn-info" id="btn-upload" style="display:none;">
                                    				<i class=""></i>
                                    				Upload Profile
                                    			</button>    
                    					    </div>
                    					</div>
                    					
                    				</div>
                    				
                    			</div>
                    		    <div class="tab-pane" id="edit-password">
                    				<div class="space-10"></div>
                    				<div class="form-group">
                    				    <p class="green"><strong>Silahkan tentukan password Anda untuk dapat login pada aplikasi Channel Management.</strong></p>
                    				    
                    				</div>
                    				
                                    <div class="form-group">
                    					<label for="form-field-username" class="col-sm-3 control-label no-padding-right">Username Anda</label>
                    
                    					<div class="col-sm-9">
                    						<input type="text" id="form-field-username" name="user_name" value="<?php echo $USER_NAME; ?>" readonly>
                    					</div>
                    				</div>
                                    <div class="form-group">
                    					<label for="form-field-pass1" class="col-sm-3 control-label no-padding-right">Password</label>
                    
                    					<div class="col-sm-9">
                    						<input type="password" id="form-field-pass1" name="user_password" maxlength="8"> *Min. 6 Karakter
                    					</div>
                    				</div>
                    
                    				<div class="space-4"></div>
                    
                    				<div class="form-group">
                    					<label for="form-field-pass2" class="col-sm-3 control-label no-padding-right">Konfirmasi Password</label>
                    
                    					<div class="col-sm-9">
                    						<input type="password" id="form-field-pass2" maxlength="8">
                    					</div>
                    				</div>
                    			</div>
                    		</div> <!-- /.tab-content -->						
                        </div> <!-- /.tabbabel -->
                        
                    														
                    </form> <!-- /.form-horizontal -->		            
                </div>
                                
                
		    </div>
		    
		    <?php endif; ?>
	    </div>


		</div><!-- /.main-container -->


		<!-- ace scripts -->
		<script src="<?php echo base_url();?>assets/js/ace-elements.js"></script>
        <script src="<?php echo base_url();?>assets/js/ace.js"></script>
		<script src="<?php echo base_url();?>assets/js/jquery.form.js"></script>
        
        
        <?php if(empty($error_message)) :?>
        
		<script type="text/javascript">
            
            
            $(document).ajaxStart(function () {
                //Global Jquery UI Block
                $(document).ajaxStart($.blockUI({
                    message:  '<img src="<?php echo base_url();?>assets/img/loading.gif" /> Loading...',
                    css: {
                            border: 'none',
                            padding: '5px',
                            backgroundColor: '#000',
                            '-webkit-border-radius': '10px',
                            '-moz-border-radius': '10px',
                            opacity: .6,
                            color: '#fff'
                        }
        
                })).ajaxStop($.unblockUI);
            });
    
			jQuery(function($) {
                var $form = $('#form-upload-profile');
				//you can have multiple files, or a file input with "multiple" attribute
				var file_input = $form.find('input[type=file]');
				var upload_in_progress = false;

				file_input.ace_file_input({
					style : 'well',
					btn_choose : 'Pilih file gambar dengan format JPG/PNG (Ukuran file maksimal 1 MB).',
					btn_change: null,
					droppable: false,
					thumbnail: 'large',
					maxSize: 1048576,//bytes
					allowExt: ["jpeg", "jpg", "png"],
					allowMime: ["image/jpg", "image/jpeg", "image/png"],

					before_remove: function() {
						if(upload_in_progress)
							return false;//if we are in the middle of uploading a file, don't allow resetting file input
						return true;
					},

					preview_error: function(filename , code) {
						//code = 1 means file load error
						//code = 2 image load error (possibly file is not an image)
						//code = 3 preview failed
					}
				})
				file_input.on('file.error.ace', function(ev, info) {
					if(info.error_count['ext'] || info.error_count['mime']) swal("Perhatian", "Invalid tipe file! Silahkan pilih file gambar!", "info");
					if(info.error_count['size']) swal("Perhatian", "Ukuran file tidak valid ! Maksimum 1MB", "info");
					
					//you can reset previous selection on error
					//ev.preventDefault();
					//file_input.ace_file_input('reset_input');
				});
				
				$('#form-upload-profile')[0].reset();
				/* on check menyetujui */
				$("#form-field-chekbox-agreement").change(function() {
                    if(this.checked) {
                        $("#btn-upload").show("slow");
                    }else {
                        $("#btn-upload").hide();
                    }
                });
                
                $("#btn-upload").click(function() {
                    
                    if(cekValidForm()) {
                        submitForm();
                    }                   
                });
			});
            
            function submitForm() {
                
                var options = { 
                    success:       onSuccessSubmit  // post-submit callback 
                }; 
                // bind to the form's submit event 
                $('#form-upload-profile').ajaxSubmit(options);
                return false;
                
            }
            
            function onSuccessSubmit(responseText, statusText, xhr, $form) {
                var response = $.parseJSON(responseText);
                if(response.success) {
                    
                    swal({
                      title: "Berhasil",
                      text: response.message,
                      type: "success",
                      showCancelButton: false,
                      confirmButtonText: "OK",
                      closeOnConfirm: true
                    },
                    function(isConfirm){
                        if (isConfirm) {
                            $(location).attr('href', "<?php echo base_url();?>");
                        }
                    });
                    
                }else {
                    swal("Perhatian", response.message, "warning");
                }
            
            }
            
            function cekValidForm() {
                                
                var jenis_identitas = $("#form-field-jenis-identitas").val();
                var file_name = $("#form-field-file-name");
                
                var pass1 = $("#form-field-pass1").val();
                var pass2 = $("#form-field-pass2").val();
                
                if(jenis_identitas.trim() == "") {
                    swal("Perhatian", "Jenis identitas belum dipilih", "info");
                    return false;    
                }
                                
                var files = file_name.data('ace_input_files');
			    if( !files || files.length == 0 ) { //no files selected
					swal("Perhatian", "File identitas belum dipilih", "info");
                    return false;
                }
                
                if(pass1.trim() == "") {
                    swal("Perhatian", "Password belum diisi", "info");
                    return false;
                }
                
                if(pass1.trim() != pass2.trim()) {
                    swal("Perhatian", "Password tidak sama", "info");
                    return false;
                }
                
                if(pass1.trim().length < 6) {
                    swal("Perhatian", "Password Minimum 6 karakter", "info");
                    return false;
                }
                
                return true;
            }
        </script>
        
        <?php endif; ?>
</body>
</html>