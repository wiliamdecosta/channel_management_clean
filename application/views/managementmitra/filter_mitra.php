<div class="breadcrumbs" id="breadcrumbs">
    <?= $this->breadcrumb; ?>
</div>
<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
            <br>
            <form class="form-horizontal" role="form">
                <div class="row">
                    <div class="col-xs-6">
                        <label class="col-sm-3 control-label no-padding-right"
                               for="form-field-1"> Nama Segment </label>
                        <div class="form-group" id="segmen_notif">
                            <div class="col-sm-8">
                                <?php echo combo_segmen(); ?>
                            </div>
                        </div>
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
                            Nama CC </label>
                        <div class="form-group">
                            <div class="col-sm-8">
                                <select class="form-control" id="list_cc">
                                    <option value="">Pilih CC</option>

                                </select>
                            </div>

                        </div>
                    </div>
                    <div class="col-xs-6">
                        <label class="col-sm-3 control-label no-padding-right"
                               for="form-field-1-1"> Nama Mitra </label>
                        <div class="form-group">
                            <div class="col-sm-8">
                                <select class="form-control" id="mitra">
                                    <option value="">Pilih Mitra</option>
                                </select>
                            </div>
                        </div>
                        <label class="col-sm-3 control-label no-padding-right"
                               for="form-field-1-1">Nama Lokasi PKS </label>
                        <div class="form-group">
                            <div class="col-sm-8">
                                <select class="form-control" id="lokasisewa">
                                    <option value="">Pilih Lokasi PKS</option>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>

<!--    --><?php //$this->load->view('managementmitra/mm_tab');?>
<!--</div> --> <!-- div pindah ke tab-->


<script>
    function checkFilter() {
        v_str = "";
        if ($("#segment").val() == "") {
            v_str += "* Segmen belum dipilih\n";
        }
        if ($("#list_cc").val() == "") {
            v_str += "* CC belum dipilih\n";
        }
        if ($("#mitra").val() == "") {
            v_str += "* Mitra belum dipilih\n";
        }
        if ($("#lokasisewa").val() == "") {
            v_str += "* Lokasi PKS belum dipilih\n";
        }

        if (v_str != "") {
            swal("", v_str, "warning");
            return false;
        }
        else {
            return true;
        }
    }
</script>
<script>
    $(document).ready(function () {
        function empty_cc() {
            $('#list_cc').html('<option value=""> Pilih CC </option>');
            $("#main_content").html("");
        }

        function empty_mitra() {
            $('#mitra').html('<option value=""> Pilih Mitra </option>');
            $("#main_content").html("");
        }

        function empty_lokasi() {
            $('#lokasisewa').html('<option value=""> Pilih Lokasi Sewa </option>');
            $("#main_content").html("");
        }

//        ----------------------------------------------------------------------------
        $("#segment").change(function () {
            empty_cc();
            empty_mitra();
            empty_lokasi();
            var segmen = $('#segment').val();
            if (segmen) {
                loadcc();
            } else {
                empty_cc();
                empty_mitra();
                empty_lokasi();
            }
        });
//     -----------------------------------------------------------------------------

        $("#list_cc").change(function () {
            empty_mitra();
            empty_lokasi();
            var list_cc = $('#list_cc').val();
            if (list_cc) {
                loadmitra();
            } else {
                empty_mitra();
                empty_lokasi();
            }

        });

//        ------------------------------------------------------------------
        $("#mitra").change(function () {
            empty_lokasi();
            var mitra = $('#mitra').val();
            if (mitra) {
                loadlokasi();
            } else {
                empty_lokasi();
            }

        });

    });
</script>
<script type="text/javascript">
    function loadcc() {
        var segmen = $("#segment").val();
        $.ajax({
            // async: false,
            cache: false,
            url: "<?php echo base_url();?>managementmitra/listCC",
            type: "POST",
            data: {segmen: segmen},
            beforeSend: function () {

            },
            success: function (data) {
                $('#list_cc').html(data);

            }
        });
    }
</script>
<script type="text/javascript">
    function loadmitra() {
        var ccid = $("#list_cc").val();
        $.ajax({
            //async: false,
            url: "<?php echo base_url();?>managementmitra/listMitra",
            type: "POST",
            data: {ccid: ccid},
            success: function (data) {
                $('#mitra').html(data);

            }
        });
    }
</script>
<script type="text/javascript">
    function loadlokasi() {
        var mitra = $("#mitra").val();
        $.ajax({
            //async: false,
            url: "<?php echo base_url();?>managementmitra/listLokasiSewa",
            type: "POST",
            data: {mitra: mitra},
            success: function (data) {
                $('#lokasisewa').html(data);

            }
        });
    }
</script>