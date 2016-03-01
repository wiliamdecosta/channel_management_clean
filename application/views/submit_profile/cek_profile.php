<!DOCTYPE html>
<html lang="en">
    <link type="image/x-icon" href="<?php echo base_url(); ?>favicon.png" rel="shortcut icon"/>
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Cek Profile - Channel Management</title>

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
			<link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace-part2.css" class="ace-main-stylesheet" />
		<![endif]-->

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace-ie.css" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- ace settings handler -->
		<script src="<?php echo base_url();?>assets/js/ace-extra.js"></script>

		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="<?php echo base_url();?>assets/js/html5shiv.js"></script>
		<script src="<?php echo base_url();?>assets/js/respond.js"></script>
		<![endif]-->

		<!-- basic scripts -->

		<!--[if !IE]> -->
		<script type="text/javascript">
			window.jQuery || document.write("<script src='<?php echo base_url();?>assets/js/jquery.js'>"+"<"+"/script>");
		</script>

		<!-- <![endif]-->

		<!--[if IE]>
        <script type="text/javascript">
         window.jQuery || document.write("<script src='<?php echo base_url();?>assets/js/jquery1x.js'>"+"<"+"/script>");
        </script>
        <![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo base_url();?>assets/js/jquery.mobile.custom.js'>"+"<"+"/script>");
		</script>
		<script src="<?php echo base_url();?>assets/js/bootstrap.js"></script>

		<!-- page specific plugin scripts -->

		<!--[if lte IE 8]>
		  <script src="<?php echo base_url();?>assets/js/excanvas.js"></script>
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
		               <div class="inline middle blue bigger-110"> <strong> Selamat Datang, Halaman ini disediakan untuk mengecek data submit profile user. </strong> </div>
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

                    <form class="form-horizontal" id="form-cek-profile" role="form" method="post">
                        <div class="tabbable">
                            <ul class="nav nav-tabs padding-16">
                    			<li class="active">
                    				<a href="#edit-basic" data-toggle="tab">
                    					<i class="green ace-icon fa fa-pencil-square-o bigger-125"></i>
                    					Data Identitas
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
                    						<input type="hidden" id="form-field-email-user" name="email_user" value="<?php echo $email_user; ?>">
                    					    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                    					</div>
                    				</div>
                                    
                                    <!-- User name -->
                    				<div class="form-group">
                    					<label for="form-field-fullname" class="col-sm-3 control-label no-padding-right">User Name :</label>
                    					<div class="col-xs-3">
                    						<?php echo $user_name_mitra; ?>
                    					</div>
                    				</div>	
                    				<div class="space-4"></div>
                    				    				           
                                    <!-- Full name -->
                    				<div class="form-group">
                    					<label for="form-field-fullname" class="col-sm-3 control-label no-padding-right">Full Name :</label>
                    					<div class="col-xs-3">
                    						<?php echo $full_name_mitra; ?>
                    					</div>
                    				</div>	
                    				<div class="space-4"></div>
                    				         				
                    				<!-- Jenis Identitas -->
                    				<div class="form-group">
                    					<label for="form-field-fullname" class="col-sm-3 control-label no-padding-right">Jenis Identitas :</label>
                    					<div class="col-xs-3">
                    						<?php echo $jenis_identitas; ?>
                    					</div>
                    				</div>	
                    				<div class="space-4"></div>
                    				
                    				<!-- File Identitas -->
                    				<div class="form-group">
                    					<label for="form-field-fullname" class="col-sm-3 control-label no-padding-right">File Identitas :</label>
                    					<div class="col-xs-5">
                    						<img height="300" src="<?php echo base_url()."application/third_party/upload/".$file_name; ?>">
                    					</div>
                    				</div>
                    					
                    				<div class="space-4"></div>
                    				
                    				
                    				<div class="space"></div>
                    				<h4 class="header blue bolder smaller">Apakah User Profile diatas telah valid ? :</h4>
                    
                    				<div class="form-group">
                    					<div class="well well-sm"> 
                    					    Jika Anda telah yakin data yang diinputkan oleh User yang bersangkutan benar, silahkan klik tombol <span class="green"><strong>User Profile Valid</strong></span> sehingga User dapat mengakses aplikasi Channel Management. Jika data yang diinputkan oleh User salah, silahkan klik tombol <span class="red"><strong>User Profile Tidak Valid</strong></span> dan User akan diberitahukan lewat email untuk mengisi profile kembali.
                    					    
                    					    <div style="margin-top:20px;">
                    					        <input type="submit" name="btn_user_valid" value="User Profile Valid" class="btn btn-success" id="btn-user-valid" >
                                    			<input type="submit" name="btn_user_not_valid" value="User Profile Tidak Valid" class="btn btn-danger" id="btn-user-not-valid" >
                    					    </div>
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
			    		    
			    var form = $("form");
                $(":submit",form).click(function(){
                            if($(this).attr('name')) {
                                $(form).append(
                                    $("<input type='hidden'>").attr( { 
                                        name: $(this).attr('name'), 
                                        value: $(this).attr('value') })
                                );
                            }
                        });
                

                $("#form-cek-profile").on('submit', (function (e) {
                                                          
                    e.preventDefault();
                    var data = $(this).serialize();
                     
                    var ajaxOptions = {
                        url: "<?php echo site_url('submit_profile/cek_validasi_data');?>", // Url to which the request is send
                        type: "POST",             // Type of request to be send, called as method
                        data: data, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                        cache: false,             // To unable request pages to be cached
                        dataType: "json",   
                        success: function (data)   // A function to be called if request succeeds
                        {
                            
                            if (data.success == true) {
                                swal({
                                  title: "Berhasil",
                                  text: data.message,
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
                    
                            } else {
                                swal("Error",data.message,"error");
                            }
                        } 
                    };
                    
                    $.ajax({
                        beforeSend: function( xhr ) {
                            swal({
                                title: "Konfirmasi Validasi",
                                text: "Apakah Anda yakin?",
                                type: "warning",
                                showCancelButton: true,
                                showLoaderOnConfirm: true,
                                confirmButtonText: "Ya, Lakukan",
                                cancelButtonText: "Tidak, Batalkan",
                                closeOnConfirm: false,
                                closeOnCancel: true
                            },
                            function(isConfirm){
                                if(isConfirm) {
                                    $.ajax(ajaxOptions); 
                                    return true;  
                                }else {
                                    return false;   
                                }
                            });
                            return false;
                        }
                    }); 
                    
                }));
			});
            
        </script>
        
        <?php endif; ?>
</body>
</html>