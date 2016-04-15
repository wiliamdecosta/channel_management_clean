</div> <!-- #ajax content -->
</div><!-- /.main-content -->
</div><!-- /.main-content-inner -->

<!-- Footer -->
<div class="footer">
    <div class="footer-inner">
        <!-- #section:basics/footer -->
        <div class="footer-content">
						<span class="bigger-120">
							<span class="blue bolder">PT. Telekomunikasi Indonesia, Tbk</span>
                            &copy; 2015
						</span>

            &nbsp; &nbsp;

        </div>

        <!-- /section:basics/footer -->
    </div>
</div>
<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
    <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
</a>
</div><!-- /.main-container -->

<!--Ajax Menu-->
<script type="text/javascript">
    $(document).ajaxStart(function () {
        //Global Jquery UI Block
        $(document).ajaxStart($.blockUI({
            message: '<img src="<?php echo base_url();?>assets/img/loading.gif" /> Loading...',
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

    $(document).ready(function () {
        // Ajax setup csrf token.
        var csfrData = {};
        csfrData['<?php echo $this->security->get_csrf_token_name(); ?>'] = '<?php echo
        $this->security->get_csrf_hash(); ?>';
        $.ajaxSetup({
            data: csfrData,
            cache: false
        });

        $('.setting_nav').click(function () {
            var nav = $(this).attr('id');
            var ctrl = $(this).attr('href');
            if (!nav) {
//                return false;
            } else {
                $("#nav_lvl1").removeClass('active');
                $(".setting_nav").removeClass('active');
                $(this).addClass('active');
                var title = $(this).text();
                $.ajax({
                    type: 'POST',
                    url: ctrl,
                    data: {title: title},
                    success: function (data) {
                        $("#ajaxContent").html(data);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        if (textStatus === 'timeout') {
                            swal('Oops..Time Out', 'Please reload this page', 'warning');
                        }
                        $("#ajaxContent").html(errorThrown);
                    },
                    timeout: 10000// sets timeout to 10 seconds
                });
                return false;
            }

        });
        
        $('#user-profile-button').click(function(){
            $("#nav_lvl1").removeClass('active');
            $(".setting_nav").removeClass('active');
            
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url();?>auth/profile",
                success: function(data) {
                    $("#ajaxContent").html(data);
                },
                error: function(jqXHR, textStatus, errorThrown){
                    if(textStatus === 'timeout'){
                        swal('Oops..Time Out','Please reload this page','warning');
                    }
                    $("#ajaxContent").html(errorThrown);
                },
                timeout: 10000// sets timeout to 10 seconds
            });

        });
        
        $('#workflow-inbox').click(function(){
            loadContentWithParams('wf-inbox',{});    
        });
        
    })
    
    function loadContentWithParams(id, params) {
        $.post( "<?php echo base_url('dynamic_content/load_content');?>/" + id,
            params,
            function( data ) {
                $( "#ajaxContent" ).html( data );
            }
        );
        
	}
			
</script>

<!-- basic scripts -->

<!--[if !IE]> -->
<script type="text/javascript">
    window.jQuery || document.write("<script src='<?php echo base_url();?>assets/js/jquery.js'>" + "<" + "/script>");
</script>

<!-- <![endif]-->

<!--[if IE]>
<script type="text/javascript">
    window.jQuery || document.write("<script src='<?php echo base_url();?>assets/js/jquery1x.js'>" + "<" + "/script>");
</script>
<![endif]-->
<script type="text/javascript">
    if ('ontouchstart' in document.documentElement) document.write("<script src='<?php echo base_url();?>assets/js/jquery.mobile.custom.js'>" + "<" + "/script>");
</script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>

<!-- page specific plugin scripts -->
<!-- Sweet alert -->
<script src="<?php echo base_url(); ?>assets/swal/sweetalert.min.js"></script>
<script src="<?php echo base_url(); ?>assets/swal/sweetalert-dev.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/swal/sweetalert.css"/>

<!--<script src="--><?php //echo base_url();?><!--assets/js/jquery-ui.custom.js"></script>-->
<script src="<?php echo base_url(); ?>assets/js/jquery.blockUI.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.ui.touch-punch.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.easypiechart.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.sparkline.js"></script>
<script src="<?php echo base_url(); ?>assets/js/flot/jquery.flot.js"></script>
<script src="<?php echo base_url(); ?>assets/js/flot/jquery.flot.pie.js"></script>
<script src="<?php echo base_url(); ?>assets/js/flot/jquery.flot.resize.js"></script>
<script src="<?php echo base_url(); ?>assets/js/notify.js"></script>
<script src="<?php echo base_url(); ?>assets/js/notify.min.js"></script>

<!-- ace scripts -->
<script src="<?php echo base_url(); ?>assets/js/ace/elements.scroller.js"></script>
<script src="<?php echo base_url(); ?>assets/js/ace/elements.colorpicker.js"></script>
<script src="<?php echo base_url(); ?>assets/js/ace/elements.fileinput.js"></script>
<script src="<?php echo base_url(); ?>assets/js/ace/elements.typeahead.js"></script>
<script src="<?php echo base_url(); ?>assets/js/ace/elements.wysiwyg.js"></script>
<script src="<?php echo base_url(); ?>assets/js/ace/elements.spinner.js"></script>
<script src="<?php echo base_url(); ?>assets/js/ace/elements.treeview.js"></script>
<script src="<?php echo base_url(); ?>assets/js/ace/elements.wizard.js"></script>
<script src="<?php echo base_url(); ?>assets/js/ace/elements.aside.js"></script>
<script src="<?php echo base_url(); ?>assets/js/ace/ace.js"></script>
<script src="<?php echo base_url(); ?>assets/js/ace/ace.ajax-content.js"></script>
<script src="<?php echo base_url(); ?>assets/js/ace/ace.touch-drag.js"></script>
<script src="<?php echo base_url(); ?>assets/js/ace/ace.sidebar.js"></script>
<script src="<?php echo base_url(); ?>assets/js/ace/ace.sidebar-scroll-1.js"></script>
<script src="<?php echo base_url(); ?>assets/js/ace/ace.submenu-hover.js"></script>
<script src="<?php echo base_url(); ?>assets/js/ace/ace.widget-box.js"></script>
<script src="<?php echo base_url(); ?>assets/js/ace/ace.settings.js"></script>
<script src="<?php echo base_url(); ?>assets/js/ace/ace.settings-rtl.js"></script>
<script src="<?php echo base_url(); ?>assets/js/ace/ace.settings-skin.js"></script>
<script src="<?php echo base_url(); ?>assets/js/ace/ace.widget-on-reload.js"></script>
<script src="<?php echo base_url(); ?>assets/js/ace/ace.searchbox-autocomplete.js"></script>
<script src="<?php echo base_url(); ?>assets/js/spin.js"></script>

<!--<script src="--><?php //echo base_url();?><!--assets/js/jquery-ui.js"></script>-->
<!--<script src="--><?php //echo base_url();?><!--assets/js/jquery.ui.touch-punch.js"></script>-->
<!--Data table-->
<script src="<?php echo base_url(); ?>assets/js/dataTables/jquery.dataTables.js"></script>
<script src="<?php echo base_url(); ?>assets/js/dataTables/jquery.dataTables.bootstrap.js"></script>
<script src="<?php echo base_url(); ?>assets/js/dataTables/extensions/TableTools/js/dataTables.tableTools.js"></script>
<script src="<?php echo base_url(); ?>assets/js/dataTables/extensions/ColVis/js/dataTables.colVis.js"></script>


<!-- JqGrid -->
<script src="<?php echo base_url(); ?>assets/js/date-time/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jqGrid/jquery.jqGrid.src.js"></script>
<!--<script src="--><?php //echo base_url();?><!--assets/js/jqGrid/jquery.jqGrid.js"></script>-->
<!--<script src="--><?php //echo base_url();?><!--assets/js/jqGrid/jquery.jqGrid.min.js"></script>-->
<script src="<?php echo base_url(); ?>assets/js/jqGrid/i18n/grid.locale-en.js"></script>


<!-- high chart -->
<script src="<?php echo base_url(); ?>assets/js/Highcharts-4.0.4/js/highcharts.js"></script>
<script src="<?php echo base_url(); ?>assets/js/Highcharts-4.0.4/js/modules/exporting.js"></script>


<!-- the following scripts are used in demo only for onpage help and you don't need them -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ace.onpage-help.css"/>
<link rel="stylesheet" href="<?php echo base_url(); ?>docs/assets/js/themes/sunburst.css"/>

<!--<script type="text/javascript"> ace.vars['base'] = '..'; </script>-->
<script src="<?php echo base_url(); ?>assets/js/ace/elements.onpage-help.js"></script>
<script src="<?php echo base_url(); ?>assets/js/ace/ace.onpage-help.js"></script>

<script src="<?php echo base_url(); ?>assets/js/jquery.form.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootgrid/jquery.bootgrid.css"/>
<script src="<?php echo base_url(); ?>assets/bootgrid/jquery.bootgrid.min.js"></script>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootdialog/bootstrap-dialog.min.css"/>
<script src="<?php echo base_url(); ?>assets/bootdialog/bootstrap-dialog.min.js"></script>
<script>
    function showBootDialog(bootclosable, boottype, boottitle, bootmessage) {
        BootstrapDialog.show({
            closable: bootclosable,
            type: boottype,
            title: boottitle,
            message: bootmessage
        });
    }
    
    jQuery.fn.center = function () {
                
        if(this.width() > $(window).width()) {
            this.css("width", $(window).width()-40);        
        }
        this.css("top",($(window).height() - this.height() ) / 2+$(window).scrollTop() + "px");
        this.css("left",( $(window).width() - this.width() ) / 2+$(window).scrollLeft() + "px");
        
        return this;
    }
    
</script>

<script src="<?php echo base_url(); ?>assets/js/lov.js"></script>

<script src="<?php echo base_url(); ?>assets/js/accounting/accounting.js"></script>
<script src="<?php echo base_url(); ?>assets/js/accounting/accounting.min.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.validate.js"></script>

</body>
</html>