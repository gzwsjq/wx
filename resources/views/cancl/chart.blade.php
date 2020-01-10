@extends('layouts.add')

@section('title', '渠道管理---图形展示')

@section('content')
        <!-- 图表容器 DOM -->
<div id="container" style="min-width: 400px; max-width: 600px; height: 400px; margin: 0 auto"></div>
<!-- 引入 highcharts.js -->
<script src="http://cdn.highcharts.com.cn/highcharts/highcharts.js"></script>
<script src="http://cdn.highcharts.com.cn/highcharts/highcharts-more.js"></script>
<script src="http://cdn.highcharts.com.cn/highcharts/exporting.js"></script>
<script src="http://cdn.highcharts.com.cn/highcharts/highcharts-zh_CN.js"></script>
<script>
    var chart = Highcharts.chart('container', {
        chart: {
            polar: true,
            type: 'area'
        },
        title: {
            text: '公众号关注人数统计',
            x: -80
        },
        pane: {
            size: '80%'
        },
        xAxis: {
            categories: [<?php echo $xStr ?>],
            tickmarkPlacement: 'on',
            lineWidth: 0,
            labels:{
                formatter: function() {
                    console.log(this);
                    if(this.axis.userOptions.selectedX === this.pos) {
                        return '<a href="javascript: void(0)" style="color: red">'+this.value+'</a>';
                    }
                    return '<a href="javascript:highlightCategory('+this.pos+')">' + this.value + '</a>'
                }
            }
        },
        yAxis: {
            gridLineInterpolation: 'polygon',
            lineWidth: 0,
            min: 0
        },
        tooltip: {
            shared: true,
            pointFormat: '<span style="color:{series.color}">{series.name}: <b>{point.y:,.0f}</b><br/>'
        },
        legend: {
            align: 'right',
            verticalAlign: 'top',
            y: 70,
            layout: 'vertical'
        },
        series: [{
            name: '人数',
            data: [<?php echo $ystr ?>],
            pointPlacement: 'on',
            point: {
                events: {
                    click: function() {
                        highlightCategory(this.x);
                    }
                }
            }
        }]
    });
    function highlightCategory(category) {
        let xAxis = chart.xAxis[0];
        if(xAxis.userOptions.selectedX && xAxis.userOptions.selectedX === category) {
            return false;
        }
        xAxis.update({
            selectedX: category
        });
    }
</script>
@endsection