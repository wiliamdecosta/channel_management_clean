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
                                                    <select name="bulan" class="form-control" id="formbulan">
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
                                                    <select class="form-control" name="tahun" id="formtahun">
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
		<div class="row">
						<div class="vspace-12-sm"></div>
						<div class="col-sm-12">
							<div class="widget-box transparent">
								<div class="widget-header red widget-header-flat">
									<h4 class="widget-title lighter">
										<!--                    <i class="ace-icon fa fa-money orange"></i>-->
										Template
									</h4>
									<div class="tabbable">
										<ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="mytab">
											<li class="tab" id="detail_rinta">
												<a href="javascript:void(0)">Rincian POTS</a>
											</li>
											<li class="tab" id="fastels">
												<a href="javascript:void(0)">Rincian Data Internet</a>
											</li>								
										</ul>										
									</div>										
								</div>
									<div class="tab-content">
											<div id="main_content" style="min-height: 400px; min-width: 600px;">
											</div>
									</div>
							</div>
						</div>
					</div>

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
				if(mitra.length >0){
				$.ajax({
					url: '<?php echo site_url('cm/viewRinta');?>',
					data: $("#filterForm").serialize(),
					type: 'POST',
					success: function (data) {
						$('#main_content').html(data);
						$('#detail_rinta').addClass('active');
						$('#fastels').removeClass('active');
					}
				});
			} else
			{
				swal("perhatian","Isi terlebih form terlebih dahulu sebelum memilih","info");
			}
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
	$('.tab').click(function (e) {
            e.preventDefault();
			if( ($('#mitra').val()).length == 0 || ($('#list_cc').val()).length == 0 || ($('#formbulan').val()).length == 0 || ($('#formtahun').val()).length == 0){
				swal("Perhatian","Isi terlebih dahulu form sebelum bisa melihat isi data","info");
			} else
			{
			
			
			// jQuery('input[name="pengelola"]').val();
			
            var ctrl = $(this).attr('id');
            var pgl_ids = $('#mitra').val();
            var list_cc = $('#list_cc').val();
            var bulanvalue = $('#formbulan').val();
            var tahunvalue = $('#formtahun').val();
			var periode = tahunvalue+""+bulanvalue;
                $('.tab').removeClass('active');
                $('#' + ctrl).addClass('active');
				if(ctrl == "fastels"){
                $.ajax({ 
                    type: 'POST',
                    url: '<?php echo site_url('cm/fastels');?>',
                    data: {mitra : pgl_ids, period:periode},
                    timeout: 10000,
                    async: false,
                    success: function (data) {
                        $("#main_content").html(data);
						$('#detail_rinta').removeClass('active');
						$('#fastels').addClass('active');
                    }
                });
				} else if(ctrl == "detail_rinta"){
				$.ajax({
					url: '<?php echo site_url('cm/viewRinta');?>',
					data: $("#filterForm").serialize(),
					type: 'POST',
					success: function (data) {
						$('#main_content').html(data);
						$('#detail_rinta').addClass('active');
						$('#fastels').removeClass('active');
					}
						});
					}
			}
        })

</script>