<?php $prv = getPrivilege($menu_id); ?>
<div id="content">
<!-- #section:basics/content.breadcrumbs -->
<div class="breadcrumbs" id="breadcrumbs">
    <?=$this->breadcrumb;?>
</div>

<!-- /section:basics/content.breadcrumbs -->
<div class="page-content">

<div id="new_batch">
    <div class="col-sm-6">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">Upload ND</h4>

                <div class="widget-toolbar">
                    <a href="#" data-action="collapse">
                        <i class="ace-icon fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <form role="form" id="uploadform" name="upload" method="post" enctype="multipart/form-data" accept-charset="utf-8">
                        <div class="form-group">
                            <div class="col-xs-3">
                                <label>Pengelola</label>
                            </div>
                            <div class="col-xs-9">
                                <!-- #section:custom/file-input -->
                                <select class="form-control" id="pgl" name="pgl">
                                    <option value="">Pilih Pengelola</option>
                                    <?php foreach ($result as $content){
                                        echo "<option value='".$content->PGL_ID."'>".$content->PGL_NAME."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        &nbsp;
                        <div class="form-group">
                            <div class="col-xs-3">
                                <label>Tenant</label>
                            </div>
                            <div class="col-xs-9">
                                <select class="form-control" id="ten_id" name="ten_id">
                                    <option value="">Pilih Tenant</option>
                                </select>
                            </div>
                        </div>
                        &nbsp;
                        &nbsp;
                        <div class="form-group">
                            <div class="col-xs-3">
                                <label>Produk</label>
                            </div>
                            <div class="col-xs-9">
                                <select class="form-control" id="cprod" name="cprod">
                                    <?php foreach ($product as $k => $v){
                                        echo "<option value='".$k."'>".$v."</option>";
                                    }
                                    ?>
                                </select> </div>
                        </div>
                        &nbsp;
                        <div class="form-group" style="display:none;">
                            <div id="label" class="col-xs-3">
                                <label>Pre-upload Action</label>
                            </div>
                            <div id="radio" class="col-xs-9">
                                <div class="radio">
                                    <label>
                                        <input name="pu_action" type="radio" class="ace" checked="checked" value="1"/>
                                        <span class="lbl"> Backup to current period</span>
                                    </label>
                                </div>

                                <div class="radio">
                                    <label>
                                        <input name="pu_action" type="radio" class="ace" value="2"/>
                                        <span class="lbl"> Backup to previous period</span>
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input name="pu_action" type="radio" class="ace" value="3"/>
                                        <span class="lbl"> No Backup</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        &nbsp;
                        <div class="form-group">
                            <div class="col-xs-3">
                                <label>File Name</label>
                            </div>
                            <div class="col-xs-9">
                                <!-- #section:custom/file-input -->
                                <input type="file" id="filename" name="filename"/>
                            </div>
                        </div>
                        &nbsp;

                        <div class="form-group">
                            <div class="col-xs-3">

                            </div>
                            <div class="col-xs-9">
                                <?php if($prv['UPLOAD'] == "Y"){;?>
                                <button class="btn btn-xs btn-primary" id="submitForm" type="submit">
                                    <i class="ace-icon fa fa-upload bigger-110"></i>
                                    Upload
                                </button>
                                <?php };?>
                                <a class="btn btn-xs btn-warning" id="cancelUpload">
                                    <i class="ace-icon fa fa-refresh bigger-110"></i>
                                    Reset
                                </a>
                            </div>
                        </div>
                        &nbsp;
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo
                        $this->security->get_csrf_hash(); ?>">
                    </form>
                    <div id="message"></div>
                </div>
            </div>
        </div>
    </div>
    <div id="output" class="col-sm-6"></div>
</div>

</div><!-- /.page-content -->
</div> <!-- /.content -->

<script type="text/javascript">
    jQuery('#cancelUpload').click(function(){
       $('#uploadform').trigger("reset");
       $("#ten_id").html('<option value=""> Pilih Tenant </option>');
       $(".remove").trigger('click');
        $("#output").html('');
    })

    $('#filename').ace_file_input({
        no_file:'No File ...',
        btn_choose:'Choose',
        btn_change:'Change',
        droppable:false,
        onchange:null,
        thumbnail:false
    });

    $("#uploadform").on('submit',(function(e) {
        $("#output").html('');
        e.preventDefault();
        $.ajax({
            url: "<?php echo site_url('parameter/nduploaddo');?>", // Url to which the request is send
            type: "POST",             // Type of request to be send, called as method
            data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData:false,        // To send DOMDocument or non processed data file it is set to false
            success: function(data)   // A function to be called if request succeeds
            {
                var output = $.parseJSON(data);
                if(output.status == 'F'){
                    $("#output").html(output.msg);
                }else{
                    $("#output").html(output.msg);
                    $('#uploadform').trigger("reset");
                    $("#ten_id").html('<option value=""> Pilih Tenant </option>');
                    $(".remove").trigger('click');
                }
            }
        });
    }));

    $("#pgl").change(function(){
        var mitra = $("#pgl").val();
        if(mitra){
            $.ajax({
                type: "POST",
                dataType: "html",
                url: "<?php echo site_url('cm/listTenant');?>",
                data: {id_mitra : mitra},
                success: function(msg){
                    if(msg == ''){
                        alert('Tidak ada tenant');
                    }
                    else{
                        $("#ten_id").html(msg);

                    }
                }
            });
        }else{
            $("#ten_id").html('<option value=""> Pilih Tenant </option>');
        }
    });
</script>