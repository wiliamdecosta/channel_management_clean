<div id="calculate_mf">
    <div class="row">
        <div class="col-xs-12">
            <form class="form-horizontal" role="form" id="form_calculate_mf">
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-2 col-xs-12 control-label no-padding-right"> Periode </label>
                        <div class="col-sm-2 col-xs-6">
                            <?php echo bulan('', date('m')); ?>
                        </div>
                        <div class="col-sm-2 col-xs-6">
                            <?php echo tahun('', date('Y')); ?>
                        </div>
                        <input type="hidden" id="input_pgl_id" value="<?php echo $pgl_id; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-2 col-xs-4">
                            <label class="col-xs-12 control-label no-padding-right"> Pilih Skema </label>
                        </div>
                        <div class="col-sm-4 col-xs-4">
                            <select name="opt_npk_fee_id" class="col-xs-12" id="opt_npk_fee_id">
                            </select>
                        </div>

                        <div class="col-sm-2 col-xs-4">
                            <a class="btn btn-sm btn-primary" id="btn_view_skema">
                            <i class="ace-icon fa fa-eye align-top bigger-125"></i>
                            Lihat NPK
                            </a>
                        </div>

                    </div>
                </div>

            </form>
        </div>
    </div>
    
    <div class="row" style="margin:5px;">
        <div class="col-xs-12" id="report_npk" style="display:none;padding:5px;border:1px solid #C0C0C0;">
            <div>
                <a class="btn btn-sm btn-success" id="btn_export_excel_rinta">
                <i class="ace-icon ace-icon fa fa-print align-top bigger-125"></i>
                Excel RINTA
                </a>
                
                <a class="btn btn-sm btn-success" id="btn_export_excel_npk">
                <i class="ace-icon ace-icon fa fa-print align-top bigger-125"></i>
                Export to Excel
                </a>
                
                <a class="btn btn-sm btn-danger" id="btn_lock_skema">
                <i class="ace-icon ace-icon fa fa-lock align-top bigger-125"></i>
                    Lock Skema
                </a>
            </div>
            <div class="col-xs-12" id="content_npk"></div>
        </div>
    </div>
</div>
<script type="text/javascript">


    $(function() { /* on ready*/

        fillSelectOptionSkema(getPeriod());
        
        $('#bulan').on('change', function (e) {
            fillSelectOptionSkema(getPeriod());
            clearNPKReport();
        });

        $('#tahun').on('change', function (e) {
            fillSelectOptionSkema(getPeriod());
            clearNPKReport();
        });
        
        $('#btn_view_skema').on('click', function (e) {
            if( $('#opt_npk_fee_id').val() == "" ) return;
            clearNPKReport();
            fillNPKReport();
        });
        
        $('#btn_export_excel_npk').on('click', function (e) {
            exportExcelNPKReport();        
        });
        
        $('#btn_export_excel_rinta').on('click', function (e) {
            exportExcelRINTAReport();           
        });
        
        
        $('#btn_lock_skema').on('click', function (e) {
            lockSkema();     
        });
    });
    
    function clearNPKReport() {
        $('#content_npk').html(""); 
        $('#report_npk').hide();
    }
    
    function getPeriod() {
        var bulan = $("#bulan").val();
        var tahun = $("#tahun").val();

        var period = tahun + "" + bulan;
        return period;    
    }
    
    
    function cekLockedSkema() {
         $.ajax({
            url: "<?php echo base_url();?>skema_bisnis/isSkemaLock",
            type: "POST",
            data: { npk_fee_id: $('#opt_npk_fee_id').val() },
            success: function (data) {
                if(data == "")
                    $('#btn_lock_skema').show();
                else
                    $('#btn_lock_skema').hide();
                
                $('#report_npk').show();
            }
        });
    }
    
    function fillNPKReport() {
        $.ajax({
            url: "<?php echo base_url();?>skema_bisnis/htmlNPKReport",
            type: "POST",
            data: { npk_fee_id: $('#opt_npk_fee_id').val(),
                    period : getPeriod(),
                    bulan : $("#bulan option:selected").text(),
                    tahun : $("#tahun option:selected").text(),
                    schm_fee_name : $("#opt_npk_fee_id option:selected").text()
                  },
            success: function (data) {
                $('#content_npk').html("");
                $('#content_npk').html(data);
                cekLockedSkema();
            }
        });
    }
    
    function exportExcelNPKReport() {
        var url = "<?php echo base_url();?>skema_bisnis/excelNPKReport?";
        url += "npk_fee_id=" + $('#opt_npk_fee_id').val();
        url += "&period=" + getPeriod();
        url += "&bulan=" + $("#bulan option:selected").text();
        url += "&tahun=" + $("#tahun option:selected").text();
        url += "&schm_fee_name=" + $("#opt_npk_fee_id option:selected").text();
        url += "&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>";
        window.location = url;
    }
    
    function exportExcelRINTAReport() {
        $.ajax({
            url: "<?php echo site_url(); ?>skema_bisnis/rintasheet/"+$("#input_pgl_id").val()+"/"+getPeriod(),
            data: {},
            type: 'POST',
            success: function (response) {
                var output = $.parseJSON(response);
                if (output.redirect !== undefined && output.redirect) {
                    window.location.href = output.redirect_url;
                }
            },
            error: function(jqXHR, textStatus, errorThrown){
                swal("Perhatian", response.message, errorThrown);
            }
        });
        
    }
    
    function fillSelectOptionSkema(period) {
        $.ajax({
                // async: false,
            url: "<?php echo base_url();?>skema_bisnis/getSkemaSelectOption",
            type: "POST",
            data: {period: period, pgl_id: '<?php echo $pgl_id; ?>'},
            success: function (data) {
                $('#opt_npk_fee_id').html("");
                $('#opt_npk_fee_id').html(data);
            }
        });
    }
    
    function lockSkema() {
        swal({
            title: "Konfirmasi Lock Skema",
            text: "Apakah Anda yakin untuk mengunci skema berikut?",
            type: "warning",
            showCancelButton: true,
            showLoaderOnConfirm: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, Lock Skema",
            cancelButtonText: "Tidak, Batalkan",
            closeOnConfirm: false,
            closeOnCancel: true
        },
        function (isConfirm) {
            if (isConfirm) {
                $.post("<?php echo base_url();?>skema_bisnis/lockSkemaNPK",
                    { npk_fee_id: $('#opt_npk_fee_id').val() },
                    function (response) {
                        var response = JSON.parse(response);
                        if (response.success == false) {
                            swal("Perhatian", response.message, "warning");
                        } else {
                            swal("Berhasil", response.message, "success");
                            fillNPKReport();
                        }
                    }
                );
            }
        });    

    }

</script>