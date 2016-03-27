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

                               
                            </div><!-- PAGE CONTENT ENDS -->
                        </div>
                    </div>
                </div><!-- /.widget-box -->
            </div><!-- /.col -->
        </div><!-- /.row -->

        <div class="tabbable">
            <ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="mytab">
                <li class="tab" id="list_template">
                    <a href="javascript:void(0)">Data</a>
                </li>

                <li class="tab" id="create_template" disabled>
                    <a href="javascript:void(0)">Body</a>
                </li>
				<li class="tab" id="variable_template" disabled>
                    <a href="javascript:void(0)">Variable</a>
                </li>
                <!-- <li class="tab" id="create_user">
                    <a href="javascript:void(0)">Create User</a>
                </li> -->

            </ul>

            <div class="tab-content">
                <div id="main_content" style="min-height: 400px;">
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- #section:basics/content.breadcrumbs -->
<script type="text/javascript">
 /*   $(document).ready(function(){
        $('.tab').click(function(e){
            e.preventDefault();
            var ctrl = $(this).attr('id');

            $('.tab').removeClass('active');
            $('#'+ctrl).addClass('active');
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url();?>template/"+ctrl,
                data: {},
                timeout: 10000,
                //async: false,
                success: function(data) {
                    $("#main_content").html(data);
                }
            })
            return false;
        })
    })
			var JDok = document.getElementById("doc_type");
			var JDokHasil = JDok.options[JDok.selectedIndex].text;
			var PilTemp = document.getElementById("doc_lang");
			var PilTempHasil = PilTemp.options[PilTemp.selectedIndex].text;
	$('#Finishing_Edit').click(function () {
        $.ajax({
            type: "POST",
           dataType: "html",
            url: "<?php echo site_url('template/parseBackTemplate');?>",
            data: {title1:document.getElementById('docx_name').value, title2:document.getElementById('docx_descript').value},
            success: function (data) {
               alert(data[1]);
			   alert(data[2]);
            }
        });
		})*/
</script>
