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
                                    <!--                    <i class="ace-icon fa fa-money orange"></i>-->
                                    Daftar Mitra
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
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Nama Segment </label>

                                                <div class="col-sm-6">
                                                    <select class="form-control" id="nama_segment">
                                                        <option value="">Pilih Segment</option>
                                                        <option value="2">Segment 2</option>
                                                        <option value="3">Segment 3</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Nama Mitra </label>

                                                <div class="col-sm-6">
                                                    <select class="form-control" id="mitra">
                                                        <option value="">Pilih Mitra</option>
                                                        <?php foreach ($result as $content){
                                                            echo "<option value='".$content->PGL_ID."'>".$content->PGL_NAME."</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label no-padding-right" for="form-field-1"> Nama CC </label>

                                                <div class="col-sm-6">
                                                    <select class="form-control" id="list_cc">
                                                        <option>Pilih CC</option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label no-padding-right" for="form-field-1-1">Sewa </label>

                                                <div class="col-sm-6">
                                                    <input type="text" id="form-field-1-1" placeholder="Text Field" class="form-control" />
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

        <div class="tabbable">
            <ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="mytab">
                <li class="tab" id="createSkema">
                    <a href="javascript:void(0)">Create Skema</a>
                </li>

                <li class="tab" id="calculateMF">
                    <a href="javascript:void(0)">Calculate MF</a>
                </li>

                <li class="tab" id="createBARekon">
                    <a href="javascript:void(0)">Create BA Rekon</a>
                </li>
                <li class="tab" id="createPerhitunganBillco">
                    <a href="javascript:void(0)">Create Perhitungan Billco</a>
                </li>
                <li class="tab" id="createNPK">
                    <a href="javascript:void(0)">Create NPK</a>
                </li>
                <li class="tab" id="evaluasiMitra">
                    <a href="javascript:void(0)">Evaluasi Mitra</a>
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
    $(document).ready(function(){
        $('.tab').click(function(e){
            e.preventDefault();
            //var position = $(document).scrollTop();
           // alert(position);
            var ctrl = $(this).attr('id');
            // Cek Required field Filter
            var tmp_name = document.getElementById("nama_segment");
            var segment_name = tmp_name.options[tmp_name.selectedIndex].value;

            if(!segment_name){
                alert('Silahkan Pilih Nama Segment !!!');
                return false
            }else{
                $('.tab').removeClass('active');
                $('#'+ctrl).addClass('active');
                $.ajax({
                    type: 'POST',
                    url: "<?php echo site_url();?>skema_bisnis/"+ctrl,
                    data: {},
                    timeout: 10000,
                    //async: false,
                    success: function(data) {
                        $("#main_content").html(data);
                      //  $(document).scrollTop(position)
                    }
                })
                return false;

            }

        })
    })

    $("#mitra").change(function(){
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
                        alert('Tidak ada tenant');
                    }
                    else{
                        $("#list_cc").html(msg);
                    }
                }
            });
        }else{
            $("#list_cc").html('<option> Pilih CC </option>');
        }
    });

</script>