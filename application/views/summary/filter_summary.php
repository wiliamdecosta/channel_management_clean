<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/datepicker.css"/>
<div id="content">
    <div class="breadcrumbs" id="breadcrumbs">
        <?= $this->breadcrumb; ?>
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
                                    Summary
                                </h4>

                                <div class="widget-toolbar">
                                    <a href="#" data-action="collapse">
                                        <i class="ace-icon fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="widget-body">
                                <br>

                                <form class="form-horizontal" role="form">
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right"
                                                       for="form-field-1"> Nama Segmen </label>
                                                <div class="col-sm-8">
                                                    <?php echo combo_segmen(); ?>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right"
                                                       for="form-field-1-1"> Skema Bisnis </label>
                                                <div class="col-sm-6">
                                                    <?php echo buatcombo("form_skembis_type", "form_skembis_type", "P_REFERENCE_LIST", "REFERENCE_NAME", "P_REFERENCE_LIST_ID", array('P_REFERENCE_TYPE_ID' => 3), "Pilih Skema Bisnis"); ?>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right"> Periode </label>
                                                <div class="col-sm-3">
                                                    <?php echo bulan('', date('m')); ?>
                                                </div>
                                                <div class="col-sm-3">
                                                    <?php echo tahun('', date('Y')); ?>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right"></label>
                                                <div class="col-sm-4">
                                                    <a class="btn btn-sm btn-primary" id="btn_calculate">
                                                        Filter
                                                    </a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- PAGE CONTENT ENDS -->
                        </div>
                    </div>
                </div>
                <!-- /.widget-box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="tabbable">
            <ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="mytab">
                <li class="tab" id="trend_mf">
                    <a href="javascript:void(0)">Trend &Sigma; MF</a>
                </li>

                <li class="tab" id="mitra">
                    <a href="javascript:void(0)">&Sigma; Mitra</a>
                </li>

                <li class="tab" id="inventory">
                    <a href="javascript:void(0)">Inventory</a>
                </li>

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
    $('.date-picker').datepicker({
            autoclose: true,
            todayHighlight: true
        })
        //show datepicker when clicking on the icon
        .next().on(ace.click_event, function () {
        $(this).prev().focus();
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.tab').click(function (e) {
            e.preventDefault();
            var ctrl = $(this).attr('id');

            $('.tab').removeClass('active');
            $('#' + ctrl).addClass('active');
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url();?>summary/" + ctrl,
                data: {},
                timeout: 10000,
                //async: false,
                success: function (data) {
                    $("#main_content").html(data);
                }
            })
            return false;
        })
    })

</script>