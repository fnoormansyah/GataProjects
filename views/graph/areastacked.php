<script type="text/javascript">
        $('#container<?php echo $graph_model->getName() ?>').highcharts({
            chart: {
                type: 'area'
            },
            title: {
                text: '<?php echo $graph_model->getTitle() ?>'
            },
            subtitle: {
                text: '<?php echo $graph_model->getSubtitle() ?>'
            },
            xAxis: {
                categories: [<?php echo $graph_model->getXaxiscategories()?>],
                tickmarkPlacement: 'on',
                title: {
                    text: '<?php echo $graph_model->getXaxistitle()?>',
                    enabled: false
                }
            },
            yAxis: {
                title: {
                    text: '<?php echo $graph_model->getYaxistitle()?>',
                }
            },
            tooltip: {
                shared: true,
                valueSuffix: ' <?php echo $graph_model->getTooltips()?>'
            },
            plotOptions: {
                area: {
                    stacking: 'normal',
                    lineColor: '#666666',
                    lineWidth: 1,
                    marker: {
                        lineWidth: 1,
                        lineColor: '#666666'
                    }
                }
            },
            series: <?php echo $graph_model->getSeries(); ?>

        });
</script>    

<div id="container<?php echo $graph_model->getName() ?>" ></div>
