<script type="text/javascript">
        $('#container<?php echo $graph_model->getName() ?>').highcharts({
            chart: {
                type: 'line',
                marginRight: 130,
                marginBottom: 25
            },
            title: {
                text: '<?php echo $graph_model->getTitle() ?>',
                x: -20 //center
            },
            subtitle: {
                text: '<?php echo $graph_model->getSubtitle() ?>',
                x: -20
            },
            xAxis: {
                categories: [<?php echo $graph_model->getXaxiscategories()?>],
            },
            yAxis: {
                title: {
                    text: '<?php echo $graph_model->getYaxistitle()?>',
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valueSuffix: ' <?php echo $graph_model->getTooltips()?>'
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -10,
                y: 100,
                borderWidth: 0
            },
            series: <?php echo $graph_model->getSeries(); ?>
        });
    

</script>

<div id="container<?php echo $graph_model->getName() ?>" ></div>
