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
                            <option value="1">...</option>
                            <option value="2">....</option>
                            <option value="3">.....</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Pilih Skema
                        Bisnis </label>
                    <div class="col-sm-6">
                        <?php echo buatcombo("form_skembis_type","form_skembis_type","P_REFERENCE_LIST","REFERENCE_NAME","P_REFERENCE_LIST_ID",array('P_REFERENCE_TYPE_ID' => 3),"Pilih Skema Bisnis");?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> <span
                            id="benefit_mitra_caption">Benefit Mitra</span> </label>
                    <div class="col-sm-6">
                        <select class="form-control" id="select_benefit_mitra" name="form_benefit_mitra">
                            <option value="">Pilih Benefit Mitra </option>
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
        function get_benefit_mitra_detail(id) {
            if (id == "") {
                $("#benefit_mitra_detail").html(" <option value=''>Pilih Benefit Mitra </option>");
                return false;
            } else {
                $("#benefit_mitra_detail").empty();
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

        $('#form_skembis_type').on('change', function () {
            $("#benefit_mitra_detail").html("");


            switch (this.value) {

                case '6' :
                    $('#benefit_mitra_caption').val('Benefit Mitra');
                    $('#select_benefit_mitra').find('option').remove();
                    $('#select_benefit_mitra').append('<option value=""> -- Pilih Benefit Mitra --</option>');
                    $('#select_benefit_mitra').append('<option value="benefit_product"> Produk </option>');
                    $('#select_benefit_mitra').append('<option value="benefit_blended"> Blended </option>');
                    break;

                case 'wholesale' :
                    $('#benefit_mitra_caption').val('Type Wholesale');
                    $('#select_benefit_mitra').find('option').remove();
                    $('#select_benefit_mitra').append('<option value=""> -- Pilih Benefit Mitra --</option>');
                    $('#select_benefit_mitra').append('<option value="createSkemaRC100"> Revenue Commitment = 100%  </option>');
                    $('#select_benefit_mitra').append('<option value="createSkemaRCGreater100"> Revenue Commitment > 100%  </option>');
                    $('#select_benefit_mitra').append('<option value="createSkemaPAYG"> Pay as you grow (PAYG)  </option>');
                    break;

                default :
                    $('#select_benefit_mitra').find('option').remove();
                    break;
            }
        });

    });
</script>