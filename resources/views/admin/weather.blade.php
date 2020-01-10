@extends('layouts.add')

@section('title', '渠道管理---图形展示')

@section('content')
<h4>一周的气温展示</h4>
城市:<input type="text" name="city" placeholder="请输入城市" id="city">
<input type="submit" value="搜索"  id="weather">

        <!-- 图表容器 DOM -->
<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<!-- 引入 highcharts.js -->
<script src="https://code.highcharts.com.cn/highcharts/highcharts.js"></script>
<script src="https://code.highcharts.com.cn/highcharts/highcharts-more.js"></script>
<script src="https://code.highcharts.com.cn/highcharts/modules/exporting.js"></script>
<script src="https://img.hcharts.cn/highcharts-plugins/highcharts-zh_CN.js"></script>

 <script src="/static/admin/jquery.min.js"></script>
    <script>
        $(function(){
            //通过ajax技术将城市名称传给控制器
            $.ajax({
                method:"GET",
                url:"{{url('/admin/weatheres')}}",
                data:{city:"北京"},
                dataType:"json",
            }).done(function(res){
                wether(res.result);
            });
        })
            $(document).on("click","#weather",function(){
                var city=$("#city").val();
                if(city==''){
                    alert('城市名称不能为空');
                    return false;
                }

                //正则验证
                var reg=/^[a-zA-Z]+$|^[\u4e00-\u9fa5]+$/;
                if(!reg.test(city)){
                    alert('城市名称只能为汉字或者拼音');
                    return false;
                }

                //通过ajax技术将城市名称传给控制器
                $.ajax({
                    method:"GET",
                    url:"{{url('/admin/weatheres')}}",
                    data:{city:city},
                    dataType:"json",
                }).done(function(res){
                       wether(res.result);
                });

            })

            function wether(weatherData){
                console.log(weatherData);
                var categories=[];  //x轴日期
                var data=[];  //从x轴日期对应的最高最低气温
                $.each(weatherData,function(i,v){
                    categories.push(v.days);
                    var arr=[parseInt(v.temp_low),parseInt(v.temp_high)];
                    data.push(arr)
                })

                var chart = Highcharts.chart('container', {
                    chart: {
                        type: 'columnrange', // columnrange 依赖 highcharts-more.js
                        inverted: true
                    },
                    title: {
                        text: '一周天气气温'
                    },
                    subtitle: {
                        text: weatherData[0]['citynm']
                    },
                    xAxis: {
                        categories: categories
                    },
                    yAxis: {
                        title: {
                            text: '温度 ( °C )'
                        }
                    },
                    tooltip: {
                        valueSuffix: '°C'
                    },
                    plotOptions: {
                        columnrange: {
                            dataLabels: {
                                enabled: true,
                                formatter: function () {
                                    return this.y + '°C';
                                }
                            }
                        }
                    },
                    legend: {
                        enabled: false
                    },
                    series: [{
                        name: '温度',
                        data: data
                    }]
                });
            }


    </script>



@endsection