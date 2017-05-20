
<script type="text/javascript">
        $('#container<?php echo $graph_model->getName() ?>').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: '<?php echo $graph_model->getTitle() ?> '
            },
            tooltip: {
            	percentageDecimals: 2,
        	pointFormat: ' {point.y:,.0f}, <b>{point.percentage:.2f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: '#000000',
                        connectorColor: '#000000',
                        formatter: function() {
                            return '<b>'+ this.point.name +'</b>: '+ this.y + ' <?php echo $graph_model->getTooltips()?>';
                        }
                    }
                }
            },
            series: <?php echo $graph_model->getSeries(); ?>
            
        });
    
</script>
<div id="container<?php echo $graph_model->getName() ?>" >ini contoh</div>
