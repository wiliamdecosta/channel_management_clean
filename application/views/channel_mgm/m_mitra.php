<div id="content">
    <div class="breadcrumbs" id="breadcrumbs">
        <script type="text/javascript">
            try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
        </script>

        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="#">Channel Management</a>
            </li>
            <li class="active">Management Mitra</li>
        </ul><!-- /.breadcrumb -->

        <!-- /section:basics/content.searchbox -->
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

        <!-- #section:custom/extra.hr -->
        <!--<div class="hr hr32 hr-dotted"></div>-->
        <div class="btn-group" style="margin-left:30px; margin-top: 20px;">
            <button type="button" class="btn btn-white btn-sm btn-primary" id="detailMitra">Detail Mitra</button>
            <button type="button" class="btn btn-white btn-sm btn-primary" id="dokKontrak">Dokumen PKS</button>
            <button type="button" class="btn btn-white btn-sm btn-primary" id="dokKelengkapan">Dokumen NPK</button>
        </div>

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
        $('.btn').click(function(){
            var ctrl = $(this).attr('id');
            // Cek Required field Filter
            var tmp_name = document.getElementById("nama_segment");
            var segment_name = tmp_name.options[tmp_name.selectedIndex].value;

            if(!segment_name){
                alert('Silahkan Pilih Nama Segment !!!');
                return false
            }else{

                $('#tab-content').html('<div class="throbber-loader">Loading...</div>');
                $.ajax({
                    type: 'POST',
                    url: "<?php echo site_url();?>cm/"+ctrl,
                    data: {},
                    timeout: 10000,
                    success: function(data) {
                        $("#tab-content").html(data);
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