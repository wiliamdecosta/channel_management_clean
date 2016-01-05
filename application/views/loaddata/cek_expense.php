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
                                    Cek Expense
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
                                                <label class="col-sm-1 control-label no-padding-right" for="form-field-1">Expense</label>

                                                <div class="col-sm-3">

                                                    <label>
                                                        <input name="form-field-radio" type="radio" value="olo" class="ace" checked="checked" />
                                                        <span class="lbl"> OLO</span>
                                                    </label>
                                                    &nbsp;&nbsp;&nbsp;
                                                    <label>
                                                        <input name="form-field-radio" type="radio" class="ace" value="sli">
                                                        <span class="lbl"> SLI</span>
                                                    </label>
                                                    &nbsp;&nbsp;&nbsp;
                                                    <label>
                                                        <input name="form-field-radio" type="radio" class="ace" value="in">
                                                        <span class="lbl"> IN</span>
                                                    </label>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <label class="col-sm-1 control-label no-padding-right" for="form-field-1"> Periode </label>

                                                <div class="col-sm-2">
                                                    <select name="bulan" class="form-control" id="bulan">
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
                                                    <select class="form-control" name="tahun" id="tahun">
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
<!--<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>-->
<script type="text/javascript">
    $(document).ready(function(){

        $('#findFilter').click(function(){
            var mitra = $("#mitra").val();
            var bulan = $("#bulan").val();
            var tahun = $("#tahun").val();

            if(!mitra){
                $('#mitra').effect("shake", { times:3 }, 500);
                return false;
            }

            if(!bulan){
                $('#bulan').effect("shake", { times:3 }, 500);
                return false;
            }
            if(!tahun){
                $('#tahun').effect("shake", { times:3 }, 500);
                return false;
            }
            var expense = $('input[name=form-field-radio]:checked', '#filterForm').val();
            var data = $("#filterForm").serializeArray();
            data.push({ name: "expense", value: expense });
            $.ajax({
                url: '<?php echo site_url('loaddata/cekExpenseView');?>',
                data: data,
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
        if(mitra){
            $.ajax({
                type: "POST",
                dataType: "html",
                url: "<?php echo site_url('cm/listTenant');?>",
                data: {id_mitra : mitra},
                success: function(msg){
                    // jika tidak ada data
                    if(msg == ''){
                        alert('Tidak ada tenant');
                        $("#list_cc").html('<option value="">Pilih Tenant</option>');
                    }
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