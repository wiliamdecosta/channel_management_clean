<div id="chart_mf">

</div>

<script type="text/javascript">
    $(function () {
        Highcharts.setOptions({
            lang: {
                numericSymbols: ["Ribu", "Juta", "G", "T", "P", "E"]
            }
        });
        $('#chart_mf').highcharts({
            credits: {
                enabled: false
            },
            title: {
                text: 'Trend MF',
                x: -20 //center
            },
            subtitle: {
                text: 'Periode: <?php echo $periode;?>',
                x: -20
            },
            xAxis: {
                categories: [<?php echo $array_periode;?>]
            },
            yAxis: {
                /*labels: {
                 format: '{value}'
                 },*/
                title: {
                    text: 'Rp'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valuePrefix: 'Rp. ',
                valueSuffix: ''
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            series: [<?php echo $series;?>]
        });
    });
</script>