<script type="text/javascript">
        $('#container<?php echo $graph_model->getName() ?>').highcharts({
            chart: {
                type: 'bar'
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
                    text: ' <?php echo $graph_model->getYaxistitle()?>',
                }
            },
            legend: {
                backgroundColor: '#FFFFFF',
                reversed: true
            },
            tooltip: {
                valueSuffix: ' <?php echo $graph_model->getTooltips()?>'
            },
            plotOptions: {
                series: {
                    stacking: 'normal'
                }
            },
            series: <?php echo $graph_model->getSeries(); ?>
        });
    

</script>

<div id="container<?php echo $graph_model->getName() ?>" ></div>
