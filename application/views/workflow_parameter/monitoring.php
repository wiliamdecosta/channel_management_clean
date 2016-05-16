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
                                    Monitoring
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
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1"> Workflow </label>
                                                <div class="col-sm-3">
                                                    <select class="form-control" id="workflow" name="workflow">
                                                        <!-- <option value="">Pilih Workflow</option> -->

                                                        <?php foreach ($result as $row){
                                                            echo "<option value='".$row->P_WORKFLOW_ID."'>".$row->DISPLAY_NAME."</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1"> No. Order </label>
                                                <div class="col-sm-3">
                                                    <input class="form-control" type="text" id="skeyword" name="skeyword" placeholder="Nomor Order" />
                                                </div>
                                                <a id="findFilter" class="fm-button ui-state-default ui-corner-all fm-button-icon-right ui-reset btn btn-sm btn-info">
                                                    <span class="ace-icon fa fa-search"></span>Find</a>
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
            var workflow = $("#workflow").val();
            var skeyword = $("#skeyword").val();

            if(!workflow){
                swal("Informasi", "Workflow belum dipilih", "info");
                return false;
            }

            $.ajax({
                url: '<?php echo site_url('workflow_parameter/processMonitoring');?>',
                data: {p_workflow_id : workflow, skeyword: skeyword},
                type: 'POST',
                success: function (data) {
                    $('#tab-content').html(data);
                }
            });

        });
    });


</script>