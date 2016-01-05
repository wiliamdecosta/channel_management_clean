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
                                    Create Batch ND
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
                                                <a id="show" class="fm-button ui-state-default ui-corner-all fm-button-icon-right ui-reset btn btn-sm btn-info">
                                                    <span class="ace-icon fa fa-search"></span>Show</a>
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

        </div><!-- /.page-content -->

        <!-- PAGE CONTENT ENDS -->
    </div><!-- /.col -->
</div><!-- /.row
</div><!-- /.page-content -->
</div>
<!-- #section:basics/content.breadcrumbs -->
<!--<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>-->
<script type="text/javascript">
    $(document).ready(function(){

        $('#show').click(function(){
            var mitra = $("#mitra").val();
            var tenant = $("#list_cc").val();

            if(!mitra){
                return false;
            }

            $.ajax({
                url: '<?php echo site_url('loaddata/showND');?>',
                data: {ten_id:tenant},
                type: 'POST',
                success: function (data ) {
                    $('#tab-content').html(data);
                }
            });
        })
    })

    $("#mitra").change(function(){
        jQuery("#grid-table").trigger("reloadGrid");
        // Get Value Mitra
        var mitra = $("#mitra").val();
        if(mitra){
            $.ajax({
                type: "POST",
                dataType: "html",
                url: "<?php echo site_url('cm/listTenant');?>",
                data: {id_mitra : mitra},
                success: function(msg){


//                    $("#grid-table").jqGrid('setGridParam', {
//                        postData: {"limit":'tes' }
//                    }).trigger('reloadGrid');
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
