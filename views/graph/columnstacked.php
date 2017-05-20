<script type="text/javascript">
        $('#container<?php echo $graph_model->getName() ?>').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: '<?php echo $graph_model->getTitle() ?>'
            },
            xAxis: {
                categories: [<?php echo $graph_model->getXaxiscategories()?>],
            },
            yAxis: {
                min: 0,
                title: {
                    text: '<?php echo $graph_model->getYaxistitle()?>',
                },
                stackLabels: {
                    enabled: true,
                    style: {
                        fontWeight: 'bold',
                        color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                    }
                }
            },
            legend: {
                align: 'right',
                x: -100,
                verticalAlign: 'top',
                y: 20,
                floating: true,
                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColorSolid) || 'white',
                borderColor: '#CCC',
                borderWidth: 1,
                shadow: false
            },
            tooltip: {
                formatter: function() {
                    return '<b>'+ this.x +'</b><br/>'+
                        this.series.name +': '+ this.y +' <?php echo $graph_model->getTooltips()?> <br/> '+
                        'Total: '+ this.point.stackTotal + ' <?php echo $graph_model->getTooltips()?>';
                }
            },

            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true,
                        color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
                    }
                }
            },
            series: <?php echo $graph_model->getSeries(); ?>
        });
</script>

<div id="container<?php echo $graph_model->getName() ?>" ></div>

