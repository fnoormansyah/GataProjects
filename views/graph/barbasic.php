<script type="text/javascript">

        $('#container<?php echo $graph_model->getName() ?>').highcharts({
            chart: {
                type: 'bar'
            },
            title: {
                text: '<?php echo $graph_model->getTitle() ?>'
            },
            subtitle: {
                text: '<?php echo $graph_model->getSubtitle() ?>'
            },
            xAxis: {
                categories: [<?php echo $graph_model->getXaxiscategories()?>],
                title: {
                    text: '<?php echo $graph_model->getXaxistitle()?>',
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: ' <?php echo $graph_model->getYaxistitle()?>',
                    align: 'high'
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                valueSuffix: '<?php echo $graph_model->getTooltips()?>'
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -100,
                y: 100,
                floating: true,
                borderWidth: 1,
                backgroundColor: '#FFFFFF',
                shadow: true
            },
            credits: {
                enabled: false
            },
            series: <?php echo $graph_model->getSeries(); ?>
        });
    

</script>

<div id="container<?php echo $graph_model->getName() ?>" ></div>
