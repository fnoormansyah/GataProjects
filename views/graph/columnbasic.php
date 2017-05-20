<script type="text/javascript">
        $('#container<?php echo $graph_model->getName() ?>').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: '<?php echo $graph_model->getTitle() ?>'
            },
            subtitle: {
                text: '<?php echo $graph_model->getSubtitle() ?>'
            },
            xAxis: {
                categories: [<?php echo $graph_model->getXaxiscategories()?>],
            },
            yAxis: {
                min: 0,
                title: {
                    text: '<?php echo $graph_model->getYaxistitle()?>',
                }
            },
            tooltip: {
                valueSuffix: ' <?php echo $graph_model->getTooltips()?>'
            },

            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: <?php echo $graph_model->getSeries(); ?>
        });
</script>

<div id="container<?php echo $graph_model->getName() ?>" ></div>
