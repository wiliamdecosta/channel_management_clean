<div id="content">
    <div class="breadcrumbs" id="breadcrumbs">
        <?=$this->breadcrumb;?>
    </div>
    <!-- /section:basics/content.breadcrumbs -->
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
                                    Rincian Tagihan
                                </h4>

                                <div class="widget-toolbar">
                                    <a href="#" data-action="collapse">
                                        <i class="ace-icon fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="widget-body">
                                <br>

                                <form class="form-horizontal" role="form" id="filterForm">
                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo
                                    $this->security->get_csrf_hash(); ?>">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1"> Pengelola </label>
                                                <div class="col-sm-3">
                                                    <select class="form-control" id="mitra" name="pengelola">
                                                        <option value="">Pilih Pengelola</option>
                                                        <?php foreach ($result as $content){
                                                            echo "<option value='".$content->PGL_ID."'>".$content->PGL_NAME."</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <a id="findFilter" class="fm-button ui-state-default ui-corner-all fm-button-icon-right ui-reset btn btn-sm btn-info">
                                                    <span class="ace-icon fa fa-search"></span>Find</a>
                                            </div>
                                        </div>
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <label class="col-sm-1 control-label no-padding-right" for="form-field-1"> Tenant </label>

                                                <div class="col-sm-3">
                                                    <select class="form-control" id="list_cc" name="tenant">
                                                        <option value="">Pilih Tenant</option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <label class="col-sm-1 control-label no-padding-right" for="form-field-1"> Periode </label>

                                                <div class="col-sm-2">
                                                    <select name="bulan" class="form-control">
                                                        <option selected="selected" value="">Bulan</option>
                                                        <?php
                                                        $bln=array(1=>"Januari","Februari","Maret","April","Mei","Juni","July","Agustus","September","Oktober","November","Desember");
                                                        for($bulan=1; $bulan<=12; $bulan++){
                                                            if($bulan<=9) { echo "<option value='0$bulan'>$bln[$bulan]</option>"; }
                                                            else { echo "<option value='$bulan'>$bln[$bulan]</option>"; }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-1">
                                                    <select class="form-control" name="tahun">
                                                        <option value=""> Tahun</option>
                                                        <?php
                                                        $year = date("Y");
                                                        for($i = ($year); $i >= $year-5; $i--){
                                                            echo "<option value=$i>$i</option>";
                                                        }
                                                        ?>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div><!-- PAGE CONTENT ENDS -->
                        </div>
                    </div>
                </div><!-- /.widget-box -->
            </div><!-- /.col -->



        </div><!-- /.row -->

        <div class="hr hr-double hr-dotted hr18"></div>
        <div id="tab-content"></div>

        <!-- PAGE CONTENT ENDS -->
    </div><!-- /.col -->
</div><!-- /.row
</div><!-- /.page-content -->
</div>
<!-- #section:basics/content.breadcrumbs -->

<script type="text/javascript">
    $(document).ready(function(){

        $('#findFilter').click(function(){
            //cek
            var mitra = $("#mitra").val();
            $.ajax({
                url: '<?php echo site_url('cm/viewRinta');?>',
                data: $("#filterForm").serialize(),
                type: 'POST',
                success: function (data ) {
                    $('#tab-content').html(data);
                }
            });
        })
    })

    $("#mitra").change(function(){
        // Get Value Mitra
        var mitra = $("#mitra").val();

        // Animasi loading

        if(mitra){
            $.ajax({
                type: "POST",
                dataType: "html",
                url: "<?php echo site_url('cm/listTenant');?>",
                data: {id_mitra : mitra},
                success: function(msg){
                    // jika tidak ada data
                    if(msg == ''){
                        alert('Tidak ada mitra');
                    }
                    // jika dapat mengambil data,, tampilkan di combo box kota
                    else{
                        $("#list_cc").html(msg);
                    }
                }
            });
        }else{
            $("#list_cc").html('<option value="">Pilih Tenant</option>');
        }


    });

</script>