<div id="content">
    <div class="breadcrumbs" id="breadcrumbs">
        <?= $this->breadcrumb; ?>
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
                                    Skema Bisnis
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
                                                <label class="col-sm-3 control-label no-padding-right"
                                                       for="form-field-1"> Nama Segment </label>

                                                <div class="col-sm-6">
                                                    <select class="form-control" id="nama_segment">
                                                        <option value="">Pilih Segment</option>
                                                        <option value="2">Segment 2</option>
                                                        <option value="3">Segment 3</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right"
                                                       for="form-field-1-1"> Nama Mitra </label>

                                                <div class="col-sm-6">
                                                    <select class="form-control" id="mitra">
                                                        <option value="">Pilih Mitra</option>
                                                        <?php foreach ($result as $content) {
                                                            echo "<option value='" . $content->PGL_ID . "'>" . $content->PGL_NAME . "</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label no-padding-right"
                                                       for="form-field-1"> Nama CC </label>

                                                <div class="col-sm-6">
                                                    <select class="form-control" id="list_cc">
                                                        <option>Pilih CC</option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label no-padding-right"
                                                       for="form-field-1-1">Sewa </label>

                                                <div class="col-sm-6">
                                                    <input type="text" id="form-field-1-1" placeholder="Text Field"
                                                           class="form-control"/>
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
        </div>
    </div>
</div>
</div>

