<div id="content">
    <div class="breadcrumbs" id="breadcrumbs">
        <?=$this->breadcrumb;?>
    </div>
    <div class="page-content">

        <div class="row">
            <div class="col-sm-5">
                <div class="widget-box">
                    <div class="widget-header widget-header-flat widget-header-small">
                        <h5 class="widget-title">
                            <i class="ace-icon fa fa-signal"></i>
                            Jumlah Kontrak Tahun <?php echo $data_chart[0]->TAHUN; ?>
                        </h5>

                        
                    </div>

                    <div class="widget-body">
                        <div class="widget-main">
                            <!-- #section:plugins/charts.flotchart -->
                            <div id="piechart-placeholder"></div>

                            <!-- /section:plugins/charts.flotchart -->
                            <div class="hr hr8 hr-double"></div>

                            <div class="clearfix">
                                <!-- #section:custom/extra.grid -->
                                <div class="grid3">
                                    <span class="grey">
                                        <?php echo $data_chart[0]->STATUS; ?>
                                    </span>
                                    <h4 class="bigger pull-right"><?php echo $data_chart[0]->PCT; ?> %</h4>
                                </div>

                                <div class="grid3">
                                    <span class="grey">
                                        <?php echo $data_chart[1]->STATUS; ?>
                                    </span>
                                    <h4 class="bigger pull-right"><?php echo $data_chart[1]->PCT; ?> %</h4>
                                </div>

                                <div class="grid3">
                                    <span class="grey">
                                        <?php echo $data_chart[2]->STATUS; ?>
                                    </span>
                                    <h4 class="bigger pull-right"><?php echo $data_chart[2]->PCT; ?> %</h4>
                                </div>

                                <!-- /section:custom/extra.grid -->
                            </div>
                        </div><!-- /.widget-main -->
                    </div><!-- /.widget-body -->
                </div><!-- /.widget-box -->
            </div>

            <div class="col-xs-7">
                <div class="row">
                    <div class="table-header" id="month_header">
                        
                    </div>
                </div>
                <div class="row">  
                    <table class="table table-bordered summary-table" style="margin-bottom:0px;">
                        <thead>
                            <tr>
                                <th width="30">Status Proses</th>
                                <th width="80" style="text-align:right">Kuantitas Invoice</th>
                                <th width="80" style="text-align:right">Jumlah Nilai Invoice</th>
                            </tr>
                        </thead>
                        
                        <tbody id="summary_current_month">
                        
                        </tbody>
                    </table>
                </div>

                <br>
                <div class="row">
                    <div class="table-header" id="year_header">
                        <!-- 2016 -->
                    </div>
                </div>
                 <div class="row">  
                    <table class="table table-bordered summary-table" style="margin-bottom:0px;">
                        <thead>
                            <tr>
                                <th rowspan="2">Bulan</th>
                                <th colspan="2" style="text-align:center">Input</th>
                                <th colspan="2" style="text-align:center">Proses</th>
                                <th colspan="2" style="text-align:center">Selesai</th>
                            </tr>
                            <tr>
                                <th style="text-align:right">Qty</th>
                                <th style="text-align:right">Nilai</th>
                                <th style="text-align:right">Qty</th>
                                <th style="text-align:right">Nilai</th>
                                <th style="text-align:right">Qty</th>
                                <th style="text-align:right">Nilai</th>
                            </tr>
                        </thead>
                        
                        <tbody id="summary_current_year">
                        
                        </tbody>
                    </table>
                </div>  

            </div>
 
        </div> 

        
     
    </div>
</div>

<script type="text/javascript">

var placeholder = $('#piechart-placeholder').css({'width':'90%' , 'min-height':'150px'});
var data = [
{ label: "<?php echo $data_chart[0]->STATUS; ?>",  data: "<?php echo $data_chart[0]->PCT; ?>", color: "#2091CF"},
{ label: "<?php echo $data_chart[1]->STATUS; ?>",  data: "<?php echo $data_chart[1]->PCT; ?>", color: "#68BC31"},
{ label: "<?php echo $data_chart[2]->STATUS; ?>",  data: "<?php echo $data_chart[2]->PCT; ?>", color: "#DA5430"},
]
function drawPieChart(placeholder, data, position) {
  $.plot(placeholder, data, {
    series: {
        pie: {
            show: true,
            tilt:0.8,
            highlight: {
                opacity: 0.25
            },
            stroke: {
                color: '#fff',
                width: 2
            },
            startAngle: 2
        }
    },
    legend: {
        show: true,
        position: position || "ne", 
        labelBoxBorderColor: null,
        margin:[-30,15]
    }
    ,
    grid: {
        hoverable: true,
        clickable: true
    }
 })
}
drawPieChart(placeholder, data);
placeholder.data('chart', data);
placeholder.data('draw', drawPieChart);

var $tooltip = $("<div class='tooltip top in'><div class='tooltip-inner'></div></div>").hide().appendTo('body');
var previousPoint = null;
            
placeholder.on('plothover', function (event, pos, item) {
    if(item) {
        if (previousPoint != item.seriesIndex) {
            previousPoint = item.seriesIndex;
            var tip = item.series['label'] + " : " + Math.round(item.series['percent'])+'%';
            $tooltip.show().children(0).text(tip);
        }
        $tooltip.css({top:pos.pageY + 10, left:pos.pageX + 10});
    } else {
        $tooltip.hide();
        previousPoint = null;
    }

});

//month
$.ajax({
    type: 'POST',
    dataType: 'json',
    url: '<?php echo site_url('contract/summary_current_month');?>',
    data: {},
    timeout: 10000,
    success: function(data) {
         $("#summary_current_month").html(data.contents);
         $("#month_header").html(data.header);
        
    },
    error: function(xhr, textStatus, errorThrown){
        swal("Perhatian", "Tidak ada data Summary Month", "warning");
    }
});

//year
$.ajax({
    type: 'POST',
    dataType: 'json',
    url: '<?php echo site_url('contract/summary_current_year');?>',
    data: {},
    timeout: 10000,
    success: function(data) {
         $("#summary_current_year").html(data.contents);
         $("#year_header").html(data.header);
        
    },
    error: function(xhr, textStatus, errorThrown){
        swal("Perhatian", "Tidak ada data Summary Year", "warning");
    }
});

</script>