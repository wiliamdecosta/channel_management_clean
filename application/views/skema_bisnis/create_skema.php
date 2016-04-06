<div id="content-mitra">
    <br>
    <form class="form-horizontal" role="form" id="form_create_skemas">
        <div class="row">
            <div class="col-xs-12">
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right"> Methods </label>
                    <div class="col-sm-6">
                        <select class="form-control" id="contract" name="form_method">
                            <option value="">Net/Gros</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Pilih Skema
                        Bisnis </label>
                    <div class="col-sm-6">
                        <?php echo buatcombo("form_skembis_type", "form_skembis_type", "P_REFERENCE_LIST", "REFERENCE_NAME", "P_REFERENCE_LIST_ID", array('P_REFERENCE_TYPE_ID' => 3), "Pilih Skema Bisnis"); ?>
                    </div>
                </div>
                <div class="form-group" id="div_benefit" style="display: none">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> <span
                            id="benefit_mitra_caption"></span> </label>
                    <div class="col-sm-6" id="list_produk_rs" >
                        <select class="form-control" id="select_benefit_mitra" name="form_benefit_mitra">
                            <option value=""> -- Pilih Benefit Mitra --</option>
                            <option value="benefit_produk_group"> Produk Group </option>
                            <option value="benefit_produk_detail"> Produk Detail </option>
                        </select>

                    </div>
                </div>
            </div>

            <div class="col-xs-12" id="benefit_mitra_detail">
            </div>

        </div>
        <input type="hidden" name="form_pgl_id" id="form_pgl_id" value="<?php echo $pgl_id; ?>">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
               value="<?php echo $this->security->get_csrf_hash(); ?>">

    </form>

</div>

<script type="text/javascript">
    jQuery(function ($) {

        $('#form_skembis_type').on('change', function () {
            $("#benefit_mitra_detail").html("");
            $('#div_benefit').hide()
            switch (this.value) {
                case '6' : // Revenue Sharing
                     $('#div_benefit').show();
                    break;

                case '10' : // Net Revenue
                    $('#div_benefit').hide();
                    $.ajax({
                        type: 'POST',
                        url: "<?php echo site_url();?>skema_bisnis/loadFlatRevenue",
                        data: {},
                        timeout: 10000,
                        success: function (data) {
                            $("#benefit_mitra_detail").html(data);
                        }

                    })
                    return false;
                    break;

                case '9' : // MTR
                    $('#div_benefit').hide();
                    $.ajax({
                        type: 'POST',
                        url: "<?php echo site_url();?>skema_bisnis/loadMTR",
                        data: {},
                        timeout: 10000,
                        success: function (data) {
                            $("#benefit_mitra_detail").html(data);
                        }

                    })
                    return false;
                    break;

                case '7' : // Custom
                    $('#div_benefit').hide();
                    $.ajax({
                        type: 'POST',
                        url: "<?php echo site_url();?>skema_bisnis/loadSkemaCustom",
                        data: {},
                        timeout: 10000,
                        success: function (data) {
                            $("#benefit_mitra_detail").html(data);
                        }

                    })
                    return false;
                    break;

                case '13' : // Rasio base
                    $('#div_benefit').hide();
                    $.ajax({
                        type: 'POST',
                        url: "<?php echo site_url();?>skema_bisnis/loadSkemaProgressif",
                        data: {},
                        timeout: 10000,
                        success: function (data) {
                            $("#benefit_mitra_detail").html(data);
                        }

                    })
                    return false;
                    break;

                case '27' : // Progressif
                    $('#div_benefit').hide();
                    $.ajax({
                        type: 'POST',
                        url: "<?php echo site_url();?>skema_bisnis/loadSkemaProgressif",
                        data: {},
                        timeout: 10000,
                        success: function (data) {
                            $("#benefit_mitra_detail").html(data);
                        }

                    })
                    return false;
                    break;

                default :
                    /*$('#select_benefit_mitra').find('option').remove();
                    break;*/
            }
        });

        function get_benefit_mitra_detail(id) {
            if (!id) {
                return false;
            } else {
                //$("#list_produk_rs").html("");
                $.ajax({
                    type: 'POST',
                    url: "<?php echo site_url();?>skema_bisnis/" + id,
                    data: {},
                    timeout: 10000,
                    success: function (data) {
                        $("#benefit_mitra_detail").html(data);
                    }

                })
                return false;
            }
        }


        $('#select_benefit_mitra').on('change', function () {
            get_benefit_mitra_detail(this.value);
        });

    });
</script>