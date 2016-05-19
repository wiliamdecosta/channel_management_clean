<div class="main-content">
    <div class="main-content-inner">
        <!-- #section:basics/content.breadcrumbs -->
        <div class="breadcrumbs" id="breadcrumbs">
            <script type="text/javascript">
                try {
                    ace.settings.check('breadcrumbs', 'fixed')
                } catch (e) {
                }
            </script>

            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="<?php base_url(); ?>">Home</a>
                </li>
                <li class="active">Summary</li>
            </ul><!-- /.breadcrumb -->


            <!-- /section:basics/content.searchbox -->
        </div>

        <!-- /section:basics/content.breadcrumbs -->
        <div class="page-content">
            <!-- #section:settings.box -->
            <div class="ace-settings-container" id="ace-settings-container">
                <div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
                    <i class="ace-icon fa fa-cog bigger-130"></i>
                </div>

                <div class="ace-settings-box clearfix" id="ace-settings-box">
                    <div class="pull-left width-50">
                        <!-- #section:settings.skins -->
                        <div class="ace-settings-item">
                            <div class="pull-left">
                                <select id="skin-colorpicker" class="hide">
                                    <option data-skin="no-skin" value="#438EB9">#438EB9</option>
                                    <option data-skin="skin-1" value="#222A2D">#222A2D</option>
                                    <option data-skin="skin-2" value="#C6487E">#C6487E</option>
                                    <option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option>
                                </select>
                            </div>
                            <span>&nbsp; Choose Skin</span>
                        </div>

                        <!-- /section:settings.skins -->

                        <!-- #section:settings.navbar -->
                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-navbar"/>
                            <label class="lbl" for="ace-settings-navbar"> Fixed Navbar</label>
                        </div>

                        <!-- /section:settings.navbar -->

                        <!-- #section:settings.sidebar -->
                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-sidebar"/>
                            <label class="lbl" for="ace-settings-sidebar"> Fixed Sidebar</label>
                        </div>

                        <!-- /section:settings.sidebar -->

                        <!-- #section:settings.breadcrumbs -->
                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-breadcrumbs"/>
                            <label class="lbl" for="ace-settings-breadcrumbs"> Fixed Breadcrumbs</label>
                        </div>

                        <!-- /section:settings.breadcrumbs -->

                        <!-- #section:settings.rtl -->
                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl"/>
                            <label class="lbl" for="ace-settings-rtl"> Right To Left (rtl)</label>
                        </div>

                        <!-- /section:settings.rtl -->

                        <!-- #section:settings.container -->
                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-add-container"/>
                            <label class="lbl" for="ace-settings-add-container">
                                Inside
                                <b>.container</b>
                            </label>
                        </div>

                        <!-- /section:settings.container -->
                    </div><!-- /.pull-left -->

                    <div class="pull-left width-50">
                        <!-- #section:basics/sidebar.options -->
                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-hover"/>
                            <label class="lbl" for="ace-settings-hover"> Submenu on Hover</label>
                        </div>

                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-compact"/>
                            <label class="lbl" for="ace-settings-compact"> Compact Sidebar</label>
                        </div>

                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-highlight"/>
                            <label class="lbl" for="ace-settings-highlight"> Alt. Active Item</label>
                        </div>

                        <!-- /section:basics/sidebar.options -->
                    </div><!-- /.pull-left -->
                </div><!-- /.ace-settings-box -->
            </div><!-- /.ace-settings-container -->


            <div class="row">
                <div class="col-xs-12">

                    <div class="row">
                        <div class="space-6"></div>
                        <div class="col-sm-6">
                            <div class="widget-box">
                                <div class="widget-header widget-header-flat widget-header-small">
                                    <h5 class="widget-title">
                                        <i class="ace-icon fa fa-signal"></i>
                                        Jumlah PKS Marketing Fee
                                    </h5>
                                </div>
                                <div class="widget-body">
                                    <div class="widget-main">
                                        <div id="charts" style="width: 100%; height: 200px">
                                            <?php $this->load->view('summary/chart_pks', array("aktif" => $aktif, "notaktif" => $notaktif)); ?>
                                        </div>
                                        <div class="hr hr8 hr-double"></div>

                                        <div class="clearfix">
                                            <div class="grid3">
															<span class="grey">
																Aktif
															</span>
                                                <h4 class="bigger pull-right"><?php echo $aktif; ?></h4>
                                            </div>

                                            <div class="grid3">
															<span class="grey">
																Tidak Aktif
															</span>
                                                <h4 class="bigger pull-right"><?php echo $notaktif; ?></h4>
                                            </div>

                                            <div class="grid3">
															<span class="grey">
																Total
															</span>
                                                <h4 class="bigger pull-right"><?php echo $aktif + $notaktif; ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="vspace-12-sm"></div>
                        <div class="col-sm-6">
                            <div class="widget-box transparent">
                                <div class="widget-header widget-header-flat">
                                    <h4 class="widget-title lighter">
                                        <i class="ace-icon fa fa-money orange"></i>
                                        Jumlah Marketing Fee <?php echo getStringMonth(date('m'));?>  <?php echo date('Y');?>
                                    </h4>

                                    <div class="widget-toolbar">
                                        <a href="#" data-action="collapse">
                                            <i class="ace-icon fa fa-chevron-up"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="widget-body">
                                    <div class="widget-main no-padding">
                                        <div>
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                <tr>

                                                    <th>Marketing Fee</th>
                                                    <th>Jumlah</th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                <tr>
                                                    <td>
                                                        <a href="#">FEE NON TAX</a>
                                                    </td>
                                                    <td class="align-right">Rp <?php echo numberFormat($FEE_NON_TAX,2);?></td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <a href="#">FEE TAX</a>
                                                    </td>
                                                    <td class="align-right">Rp <?php echo numberFormat($FEE_TAX,2);?></td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <a href="#">FEE TOTAL</a>
                                                    </td>
                                                    <td class="align-right">Rp <?php echo numberFormat($FEE_TOTAL,2);?></td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <a href="#">FEE TO SHARE</a>
                                                    </td>
                                                    <td class="align-right">Rp <?php echo numberFormat($FEE_TO_SHARE,2);?></td>
                                                </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="hr hr8 hr-double hr-dotted"></div>

                                        <!--<div class="row">
                                            <div class="col-sm-12 pull-left">
                                                <h4 class="pull-left">
                                                    Total :
                                                    <span class="red">Rp. 1.100.000.000,00</span>
                                                </h4>
                                            </div>
                                            <div class="col-sm-12 pull-left">Satu Miliar Seratus Juta Rupiah</div>
                                        </div>-->
                                    </div><!-- /.widget-main -->
                                </div><!-- /.widget-body -->
                            </div><!-- /.widget-box -->
                        </div><!-- /.col -->


                    </div><!-- /.row -->

                    <!-- #section:custom/extra.hr -->
                    <!--<div class="hr hr32 hr-dotted"></div>

                    <div class="row">
                        <div class="col-sm-5">
                            <div class="widget-box transparent">
                                <div class="widget-header widget-header-flat">
                                    <h4 class="widget-title lighter">
                                        <i class="ace-icon fa fa-money orange"></i>
                                        Jumlah Kontrak Sewa dan Listrik Agustus 2015
                                    </h4>

                                    <div class="widget-toolbar">
                                        <a href="#" data-action="collapse">
                                            <i class="ace-icon fa fa-chevron-up"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="widget-body">
                                    <div class="widget-main no-padding">
                                        <div>
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                <tr>
                                                    <th class="center">#</th>
                                                    <th>Produk</th>
                                                    <th>Tahun</th>
                                                    <th>Jumlah</th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                <tr>
                                                    <td class="center">1</td>

                                                    <td>
                                                        <a href="#">Kontrak Sewa</a>
                                                    </td>
                                                    <td class="hidden-xs">
                                                        2015
                                                    </td>
                                                    <td>Rp. 750.000.000,00</td>
                                                </tr>

                                                <tr>
                                                    <td class="center">2</td>

                                                    <td>
                                                        <a href="#">Listrik</a>
                                                    </td>
                                                    <td class="hidden-xs">
                                                        2015
                                                    </td>
                                                    <td>Rp. 350.000.000,00</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="hr hr8 hr-double hr-dotted"></div>

                                        <div class="row">
                                            <div class="col-sm-12 pull-left">
                                                <h4 class="pull-left">
                                                    Total :
                                                    <span class="red">Rp. 1.100.000.000,00</span>
                                                </h4>
                                            </div>
                                            <div class="col-sm-12 pull-left">Satu Miliar Seratus Juta Rupiah</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-7">
                            <div class="widget-box transparent">
                                <div class="widget-header widget-header-flat">
                                    <h4 class="widget-title lighter">
                                        <i class="ace-icon fa fa-signal"></i>
                                        Grafik Kontrak Sewa & Tagihan Listrik
                                    </h4>

                                    <div class="widget-toolbar">
                                        <a href="#" data-action="collapse">
                                            <i class="ace-icon fa fa-chevron-up"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="widget-body">
                                    <div class="widget-main padding-4">
                                        <div id="chartcolumn" style="height: 280px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->


                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->
<script type="text/javascript">
    jQuery(document).ready(function () {
        Highcharts.setOptions({
            colors: ['#007FFF', '#FF5555', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4']
        });
        $('#chartcolumn').highcharts({
            chart: {
                type: 'column'
            },
            credits: {
                enabled: false
            },
            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: [
                    'Jan',
                    'Feb',
                    'Mar',
                    'Apr',
                    'May',
                    'Jun',
                    'Jul',
                    'Aug',
                    'Sep',
                    'Oct',
                    'Nov',
                    'Dec'
                ],
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Rp '
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f} jt</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Kontrak Sewa',
                color: '#90ED7D',
                data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]

            }, {
                name: 'Tagihan Listrik',
                data: [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5, 106.6, 92.3]

            }]
        });
    });
</script>