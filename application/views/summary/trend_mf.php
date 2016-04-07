<script src="<?php echo base_url(); ?>assets/js/date-time/moment.js"></script>
<script src="<?php echo base_url(); ?>assets/js/date-time/daterangepicker.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/daterangepicker.css"/>

<div id="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="vspace-12-sm"></div>
                <div class="col-sm-12">
                    <div class="widget-box transparent">
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
                                        <!--<div class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right"> Periode </label>
                                            <div class="col-sm-3">
                                                <?php /*echo bulan('', date('m')); */ ?>
                                            </div>
                                            <div class="col-sm-3">
                                                <?php /*echo tahun('', date('Y')); */ ?>
                                            </div>
                                        </div>-->
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right"> Periode </label>
                                            <div class="col-sm-6">
                                                <div class="input-group">
																	<span class="input-group-addon">
																		<i class="fa fa-calendar bigger-110"></i>
																	</span>
                                                    <input type="text" id="periode"
                                                           name="periode" class="form-control">
                                                </div>

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right"></label>
                                            <div class="col-sm-4">
                                                <a class="btn btn-sm btn-primary" id="btn_filter">
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
    <div class="row" id="trend_mf_chart">

    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#periode').daterangepicker(
            {
                autoUpdateInput: false,
                locale: {
                }
            }
        );
        $('#periode').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYYMM') + ' - ' + picker.endDate.format('YYYYMM'));
        });

        $('#periode').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

        $('#btn_filter').click(function () {
            var startdate = $('#periode').data('daterangepicker').startDate.format('DD-MM-YYYY');
            var enddate = $('#periode').data('daterangepicker').endDate.format('DD-MM-YYYY');
            var periode = $('#periode').val();
            var segment = $('#segment').val();
            var skema_id = $('#form_skembis_type').val();

            $.ajax({
                type: 'POST',
                url: "<?php echo site_url("summary/filterTrendMF");?>",
                data: {
                    periode : periode,
                    segment: segment,
                    skema_id: skema_id,
                    startdate:startdate,
                    enddate:enddate

                },
                timeout: 10000,
                success: function (data) {
                    $("#trend_mf_chart").html(data);
                }
            })
        });
    });
</script>