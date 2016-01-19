<div id="content">
    <div class="row" id="trend_mf_chart">

    </div>
</div>

<script type="text/javascript">

    $(function () {
        $('#trend_mf_chart').highcharts({
            credits: {
                enabled: false
            },
            title: {
                text: 'Trend MF',
                x: -20 //center
            },
            subtitle: {
                text: 'Periode: Januari - Juli 2015',
                x: -20
            },
            xAxis: {
                categories: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni','Juli']
            },
            yAxis: {
                title: {
                    text: 'Juta Rupiah'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valueSuffix: 'Juta Rupiah'
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            series: [{
                name: 'Other',
                data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5]
            }, {
                name: 'OTC',
                data: [17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6]
            }, {
                name: 'Wholesale',
                data: [ 8.4, 13.5, 17.0, 18.6, 17.9, 14.3, 9.0]
            }, {
                name: 'Rev Sharing',
                data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0]
            }]
        });
    });
</script>