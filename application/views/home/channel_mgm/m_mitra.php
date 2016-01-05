<!-- #section:basics/content.breadcrumbs -->
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
                                <select class="form-control" id="form-field-select-1">
                                    <option value="">Pilih Segment</option>
                                    <option value="2">Segment 2</option>
                                    <option value="3">Segment 3</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Nama Mitra </label>

                            <div class="col-sm-6">
                                <select class="form-control" id="form-field-select-1">
                                    <option value="">Pilih Mitra</option>
                                    <?php foreach ($result as $content){
                                        echo "<option value='1'>".$content->PGL_NAME."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label class="col-sm-4 control-label no-padding-right" for="form-field-1"> Nama Lokasi Kontrak </label>

                            <div class="col-sm-6">
                                <select class="form-control" id="form-field-select-1">
                                    <option value="">Pilih Lokasi</option>
                                    <option value="1">Segment 1</option>
                                    <option value="2">Segment 2</option>
                                    <option value="3">Segment 3</option>
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
        <button type="button" class="btn btn-white btn-sm btn-primary" id="detail-mitra">Detail Mitra</button>
        <button type="button" class="btn btn-white btn-sm btn-primary" id="dok-kontrak">Dokumen Kontrak</button>
        <button type="button" class="btn btn-white btn-sm btn-primary" id="kelengkapan-dok">Kelengkapan Dokumen</button>
    </div>

    <div class="hr hr-double hr-dotted hr18"></div>
    <div id="tab-content"></div>

<!-- PAGE CONTENT ENDS -->
</div><!-- /.col -->
</div><!-- /.row
</div><!-- /.page-content -->
<script type="text/javascript">
    $(document).ready(function(){
        $('.btn').click(function(){
            //$(".loading-div").show();
            var id = $(this).attr('id');
            var loading = "<?php echo $this->loading;?>";
            $("#tab-content").html(loading); //show loading element
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('cm/detailmitra');?>',
                data: {},
                timeout: 10000,
                success: function(data) {
                    $("#tab-content").html(data);
                    $(".loading-div").hide();
                }
            })
            return false;
        })
    })
</script>