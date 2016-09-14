<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>Login Page - Channel Management</title>
    <meta name="description" content="User login page" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <!-- Favicon -->
    <link type="image/x-icon" href="<?php echo base_url(); ?>favicon.png" rel="shortcut icon"/>
    <!-- bootstrap & fontawesome -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/font-awesome.css" />
    <!-- text fonts -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace-fonts.css" />
    <!-- ace styles -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace.css" />
    <!--[if lte IE 9]>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace-part2.css" />
    <![endif]-->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace-rtl.css" />
    <!--[if lte IE 9]>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace-ie.css" />
    <![endif]-->
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="<?php echo base_url();?>assets/js/html5shiv.js"></script>
    <script src="<?php echo base_url();?>assets/js/respond.js"></script>
    <![endif]-->
</head>
<body class="login-layout light-login">
<div class="main-container">
<div class="main-content">
<div class="row">
<div class="col-sm-10 col-sm-offset-1">
<div class="login-container">
<div class="center">
    <h1>
        <!--        <i class="ace-icon fa fa-leaf green"></i>-->
        <!--        <span class="red">Ace</span>-->
        <!--        <span class="white" id="id-text2">Application</span>-->
        <img src="<?php echo base_url()?>assets/img/telkom.png">
    </h1>
    <!--    <h4 class="blue" id="id-company-text">&copy; Telkom</h4>-->
</div>

<div class="space-6"></div>
<div class="position-relative">
    <div id="login-box" class="login-box visible widget-box no-border">
        <div class="widget-body ">
            <div class="widget-main">
                <h4 class="header blue lighter bigger">
                    <i class="ace-icon fa fa-coffee green"></i>
                    Please Enter Your Information
                </h4>
                <div class="space-6"></div>
                <form id="loginForm" name="loginForm" method="post">
                    <fieldset>
                        <div class="form-group">
                            <label class="block clearfix">
                                        <span class="block input-icon input-icon-right">
                                        <input type="text" class="form-control" placeholder="User Name" id="username" name="username" required="true"/>
                                        <i class="ace-icon fa fa-user"></i>
                                        </span>
                            </label>
                        </div>

                        <label class="block clearfix">
                                        <span class="block input-icon input-icon-right">
                                        <input type="password" class="form-control" placeholder="Password" id="pwd" name="pwd" required="true" autocomplete="off"/>
                                        <i class="ace-icon fa fa-lock"></i>
                                        </span>
                        </label>
                        <div class="space"></div>
                        <div class="clearfix">
                            <label class="inline">
                                <input type="checkbox" class="ace" />
                                <span class="lbl"> Remember Me</span>
                            </label>
                            <a class="width-35 pull-right btn btn-sm btn-danger" name="login" id="login">
                                <i class="ace-icon fa fa-key"></i>
                                <span class="bigger-110">Login</span>
                            </a>
                        </div>
                        <br>
                            <div class='alert alert-danger' id="msg" style="display: none">
                            </div>
                        <div class="space-4"></div>
                    </fieldset>
                    <input type="hidden" value="<?= site_url();?>" id="host">
                    <input type="hidden" id="token" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                </form>
                <div class="space-6"></div>
            </div>
        </div>
        <!-- /.widget-body -->
    </div>
    <!-- /.signup-box -->
</div>
<!-- /.position-relative -->
<div class="navbar-fixed-top align-right">
    <br />
    &nbsp;
    <a id="btn-login-dark" href="#">Dark</a>
    &nbsp;
    <span class="blue">/</span>
    &nbsp;
    <a id="btn-login-blur" href="#">Blur</a>
    &nbsp;
    <span class="blue">/</span>
    &nbsp;
    <a id="btn-login-light" href="#">Light</a>
    &nbsp; &nbsp; &nbsp;
</div>
</div>
</div>
<!-- /.col -->
</div>
<!-- /.row -->
</div>
<!-- /.main-content -->
</div>
<!-- /.main-container -->
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
<!-- inline scripts related to this page -->
<script src="<?php echo base_url();?>assets/js/jquery.blockUI.js"></script>
<script src="<?php echo base_url();?>assets/js/login.js"></script>
<script type="text/javascript">
    jQuery(function($) {
        $(document).on('click', '.toolbar a[data-target]', function(e) {
            e.preventDefault();
            var target = $(this).data('target');
            $('.widget-box.visible').removeClass('visible');//hide others
            $(target).addClass('visible');//show target
        });
    });



    //you don't need this, just used for changing background
    jQuery(function($) {
        $('#btn-login-dark').on('click', function(e) {
            $('body').attr('class', 'login-layout');
            $('#id-text2').attr('class', 'white');
            $('#id-company-text').attr('class', 'blue');

            e.preventDefault();
        });
        $('#btn-login-light').on('click', function(e) {
            $('body').attr('class', 'login-layout light-login');
            $('#id-text2').attr('class', 'grey');
            $('#id-company-text').attr('class', 'blue');

            e.preventDefault();
        });
        $('#btn-login-blur').on('click', function(e) {
            $('body').attr('class', 'login-layout blur-login');
            $('#id-text2').attr('class', 'white');
            $('#id-company-text').attr('class', 'light-blue');

            e.preventDefault();
        });

    });
</script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
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
</script>
</body>
</html>
