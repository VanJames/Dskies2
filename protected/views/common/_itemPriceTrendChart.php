<?php if ($data): ?>
    <?php
    $x = array();
    $y = array();
    $tmpy = 0;
    $i = 0;
    foreach ($data as $date => $value) {
        $x[] = $date;
        $y[$i]['y'] = (int) $value;
        if ($tmpy != 0 && $tmpy != $value) {
            $y[$i]['marker'] = array('enabled' => true);
            $y[$i - 1]['marker'] = array('enabled' => true);
        } else {
            $y[$i]['marker'] = array('enabled' => false);
        }
        $tmpy = $value;
        $i++;
    }
    $dataX = implode(',', $x);
    $dataY = implode(',', $y);
    ?>
    <div id="chart" data-x="<?php echo $dataX; ?>" data-y="<?php echo $dataY; ?>" ></div>
    <script src="<?php echo Yii::app()->baseUrl; ?>/js/highcharts/highcharts.js"></script>
    <script>

        $(function() {
            var chart = $('#chart'), dataX = chart.attr('data-x').split(','), newDataY = [], dataUrl = chart
                    .attr('data-url');
            newDataY = '<?php echo json_encode($y) ?>';
            newDataY = JSON.parse(newDataY);
            chart.highcharts({
                chart: {
                    type: 'line',
                    events: {
                        load: function() {
                            this.renderer.image(baseUrl + '/images/icon/chart-icon.png', this.chartWidth / 2 - 54, this.chartHeight / 2 - 32, 108, 64)
                                    .attr({
                                zIndex: 7
                            })
                                    .add();
                        }
                    }
                },
                title: {
                    text: ''
                },
                subtitle: {
                    text: ''
                },
                xAxis: {
                    type: 'datetime',
                    labels: {
                        step: 5,
                        rotation: -45
                    },
                    categories: dataX
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: null
                    },
                },
                legend: {
                    enabled: false  //设置图例不可见 
                },
                tooltip: {
                    crosshairs: true,
                    shared: true
                },
                plotOptions: {
                    spline: {
                        marker: {
                            radius: 4,
                            lineColor: '#666666',
                            lineWidth: 1
                        }
                    }
                },
                series: [{
                        name: '価格',
                        data: newDataY
                    }]
            });
        });
        Highcharts.setOptions({
            colors: ['#ED561B']
        });
    </script>
<?php else: ?>
    <?php echo Util::t('No Data'); ?>
<?php endif; ?>