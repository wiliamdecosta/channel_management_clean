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
                                    Template
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
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Jenis Dokumen </label>

                                                <div class="col-sm-6">
                                                    <?php echo buatcombo('doc_type','doc_type','DOC_TYPE','DOC_TYPE_NAME','DOC_TYPE_ID',null,'Pilih Dok');?>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Pilih Template </label>

                                                <div class="col-sm-6">
                                                    <?php echo buatcombo('doc_lang','doc_lang','DOC_LANG','DESCRIPTION','DOC_LANG_ID',null,'Pilih Template');?>
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
                <li class="tab" id="list_template">
                    <a href="javascript:void(0)">Data</a>
                </li>

                <li class="tab" id="dokPKS">
                    <a href="javascript:void(0)">Create New Templete</a>
                </li>

                <li class="tab" id="create_user">
                    <a href="javascript:void(0)">Create User</a>
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
            var ctrl = $(this).attr('id');

            $('.tab').removeClass('active');
            $('#'+ctrl).addClass('active');
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url();?>template/"+ctrl,
                data: {},
                timeout: 10000,
                //async: false,
                success: function(data) {
                    $("#main_content").html(data);
                }
            })
            return false;
        })
    })

</script>