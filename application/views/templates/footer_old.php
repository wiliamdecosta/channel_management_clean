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

<style>
    .loading-div{
        /*position: absolute;*/
        float: left;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        min-height: 520px;
        background: rgba(0, 0, 0, 0.56);
        z-index: 999;
        /*display:none;*/
    }
    .loading-div img {
        margin-top: 20%;
        margin-left: 50%;
    }
</style>


<!--Ajax Menu-->
<script type="text/javascript">
    $(document).ajaxStart(function () {
       // $.blockUI({ message: 'Loading...' });
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
    // Spin.JS configuration
    var opts = {
        lines: 10 // The number of lines to draw
        , length: 15 // The length of each line
        , width: 14 // The line thickness
        , radius: 36 // The radius of the inner circle
        , scale: 0.1 // Scales overall size of the spinner
        , corners: 1 // Corner roundness (0..1)
        , color: '#878787' // #rgb or #rrggbb or array of colors
        , opacity: 0.25 // Opacity of the lines
        , rotate: 0 // The rotation offset
        , direction: 1 // 1: clockwise, -1: counterclockwise
        , speed: 1 // Rounds per second
        , trail: 60 // Afterglow percentage
        , fps: 20 // Frames per second when using setTimeout() as a fallback for CSS
        , zIndex: 2e9 // The z-index (defaults to 2000000000)
        , className: 'spinner' // The CSS class to assign to the spinner
        , top: '50%' // Top position relative to parent
        , left: '50%' // Left position relative to parent
        , shadow: false // Whether to render a shadow
        , hwaccel: false // Whether to use hardware acceleration
        , position: 'absolute' // Element positioning
    }
    // Ajax setup csrf token.
    var csfrData = {};
    csfrData['<?php echo $this->security->get_csrf_token_name(); ?>'] = '<?php echo
    $this->security->get_csrf_hash(); ?>';
    $.ajaxSetup({
        data: csfrData
    });
    $(document).ready(function(){
        $('.setting_nav').click(function(){
            var nav = $(this).attr('id');
            var ctrl = $(this).attr('href');

            if(!nav){
//                return false;
            }else{
                $("#nav_lvl1").removeClass('active');
                $(".setting_nav").removeClass('active');
                $(this).addClass('active');
                var title = $(this).text();
                var loading = "<?php echo $this->loading;?>";
                $("#ajaxContent").html(loading); //show loading element
                $.ajax({
                    type: 'POST',
                    url: ctrl,
                    data: {title:title},
                    success: function(data) {
                        $("#ajaxContent").html(data);
                      //  $(".loading-div").hide();
                    },
                    error: function(jqXHR, textStatus, errorThrown){
                       // alert(errorThrown);
                        $("#ajaxContent").html(errorThrown);
                    },
                    timeout: 10000 // sets timeout to 10 seconds
                })
                return false;
            }

        })
    })

</script>



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
<!--<script src="--><?php //echo base_url();?><!--assets/js/jquery-ui.custom.js"></script>-->
<script src="<?php echo base_url();?>assets/js/jquery.blockUI.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.ui.touch-punch.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.easypiechart.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.sparkline.js"></script>
<script src="<?php echo base_url();?>assets/js/flot/jquery.flot.js"></script>
<script src="<?php echo base_url();?>assets/js/flot/jquery.flot.pie.js"></script>
<script src="<?php echo base_url();?>assets/js/flot/jquery.flot.resize.js"></script>
<script src="<?php echo base_url();?>assets/js/notify.js"></script>
<script src="<?php echo base_url();?>assets/js/notify.min.js"></script>


<!-- ace scripts -->
<script src="<?php echo base_url();?>assets/js/ace/elements.scroller.js"></script>
<script src="<?php echo base_url();?>assets/js/ace/elements.colorpicker.js"></script>
<script src="<?php echo base_url();?>assets/js/ace/elements.fileinput.js"></script>
<script src="<?php echo base_url();?>assets/js/ace/elements.typeahead.js"></script>
<script src="<?php echo base_url();?>assets/js/ace/elements.wysiwyg.js"></script>
<script src="<?php echo base_url();?>assets/js/ace/elements.spinner.js"></script>
<script src="<?php echo base_url();?>assets/js/ace/elements.treeview.js"></script>
<script src="<?php echo base_url();?>assets/js/ace/elements.wizard.js"></script>
<script src="<?php echo base_url();?>assets/js/ace/elements.aside.js"></script>
<script src="<?php echo base_url();?>assets/js/ace/ace.js"></script>
<script src="<?php echo base_url();?>assets/js/ace/ace.ajax-content.js"></script>
<script src="<?php echo base_url();?>assets/js/ace/ace.touch-drag.js"></script>
<script src="<?php echo base_url();?>assets/js/ace/ace.sidebar.js"></script>
<script src="<?php echo base_url();?>assets/js/ace/ace.sidebar-scroll-1.js"></script>
<script src="<?php echo base_url();?>assets/js/ace/ace.submenu-hover.js"></script>
<script src="<?php echo base_url();?>assets/js/ace/ace.widget-box.js"></script>
<script src="<?php echo base_url();?>assets/js/ace/ace.settings.js"></script>
<script src="<?php echo base_url();?>assets/js/ace/ace.settings-rtl.js"></script>
<script src="<?php echo base_url();?>assets/js/ace/ace.settings-skin.js"></script>
<script src="<?php echo base_url();?>assets/js/ace/ace.widget-on-reload.js"></script>
<script src="<?php echo base_url();?>assets/js/ace/ace.searchbox-autocomplete.js"></script>
<script src="<?php echo base_url();?>assets/js/spin.js"></script>

<!--<script src="--><?php //echo base_url();?><!--assets/js/jquery-ui.js"></script>-->
<!--<script src="--><?php //echo base_url();?><!--assets/js/jquery.ui.touch-punch.js"></script>-->
<!--Data table-->
<script src="<?php echo base_url();?>assets/js/dataTables/jquery.dataTables.js"></script>
<script src="<?php echo base_url();?>assets/js/dataTables/jquery.dataTables.bootstrap.js"></script>
<script src="<?php echo base_url();?>assets/js/dataTables/extensions/TableTools/js/dataTables.tableTools.js"></script>
<script src="<?php echo base_url();?>assets/js/dataTables/extensions/ColVis/js/dataTables.colVis.js"></script>

<!-- JqGrid -->
<script src="<?php echo base_url();?>assets/js/date-time/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url();?>assets/js/jqGrid/jquery.jqGrid.src.js"></script>
<script src="<?php echo base_url();?>assets/js/jqGrid/i18n/grid.locale-en.js"></script>
		

<!-- high chart -->
<script src="<?php echo base_url(); ?>assets/js/Highcharts-4.0.4/js/highcharts.js"></script>
<script src="<?php echo base_url(); ?>assets/js/Highcharts-4.0.4/js/modules/exporting.js"></script>


<!-- the following scripts are used in demo only for onpage help and you don't need them -->
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace.onpage-help.css" />
<link rel="stylesheet" href="<?php echo base_url();?>docs/assets/js/themes/sunburst.css" />

<!--<script type="text/javascript"> ace.vars['base'] = '..'; </script>-->
<script src="<?php echo base_url();?>assets/js/ace/elements.onpage-help.js"></script>
<script src="<?php echo base_url();?>assets/js/ace/ace.onpage-help.js"></script>
<!--<script src="--><?php //echo base_url();?><!--docs/assets/js/rainbow.js"></script>-->
<!--<script src="--><?php //echo base_url();?><!--docs/assets/js/language/generic.js"></script>-->
<!--<script src="--><?php //echo base_url();?><!--docs/assets/js/language/html.js"></script>-->
<!--<script src="--><?php //echo base_url();?><!--docs/assets/js/language/css.js"></script>-->
<!--<script src="--><?php //echo base_url();?><!--docs/assets/js/language/javascript.js"></script>-->
</body>
</html>