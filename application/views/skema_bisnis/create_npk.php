<div id="calculate_mf">
    <div class="row">
        <div class="col-xs-12">
            <form class="form-horizontal" role="form" id="form_calculate_mf">
                <div class="form-group">
                    <div class="row">
                        <div class="row">
                            <label class="col-xs-1"> Periode </label>
                            <div class="col-xs-2">
                                <?php echo bulan('', date('m')); ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-2">
                        <?php echo tahun('', date('Y')); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-1 control-label no-padding-right"></label>
                    <div class="col-sm-11" id="gridCalculate">
                        <!--                        --><?php //$this->load->view('skema_bisnis/grid_skembis_calculate'); ?>
                    </div>

                </div>
                <a class="btn btn-sm btn-success" id="view_calculate">
                    <i class="ace-icon fa fa-eye align-top bigger-125"></i>
                    Lihat Skema
                </a>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    //  $('#gridCalculate').show();

    $('#btn_calculate').click(function () {
        var skema_id = $('#form_skema').val();
        var bulan = $('#bulan').val();
        var tahun = $('#tahun').val();
        var pgl_id = '<?php echo $pgl_id;?>';
        if (skema_id) {
            $.ajax({
                // async: false,
                url: "<?php echo base_url();?>skema_bisnis/proses_calculate",
                type: "POST",
                dataType: "json",
                data: {skema_id: skema_id, bulan: bulan, tahun: tahun, pgl_id: pgl_id},
                success: function (data) {
                    if (data.success == true) {
                        swal('', data.message, 'success');
                        $("#gridCalculate").load("<?php echo base_url('skema_bisnis/grid_skembis_calculate'); ?>", {
                            skema_id: skema_id,
                            pgl_id: pgl_id
                        }, function () {
                        });

                    } else {
                        swal('', 'Error ', 'error')
                    }

                }
            });
        } else {
            swal('', 'Skema belum dipilih !', 'warning');
            return false;
        }
    });

    $('#view_calculate').click(function () {
        var skema_id = $('#form_skema').val();
        var pgl_id = '<?php echo $pgl_id;?>';
        var bulan = $('#bulan').val();
        var tahun = $('#tahun').val();
        if (skema_id) {
            $("#gridCalculate").load("<?php echo base_url('skema_bisnis/grid_skembis_calculate'); ?>", {
                    skema_id: skema_id,
                    pgl_id: pgl_id,
                    bulan: bulan,
                    tahun: tahun
                },
                function () {
                });
        } else {
            swal('', 'Skema belum dipilih !', 'warning');
            return false;
        }

    });


</script>