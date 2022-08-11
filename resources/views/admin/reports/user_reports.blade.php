@extends('layouts.app')

@section('content')
    <script src="https://www.chartjs.org/dist/2.8.0/Chart.min.js"></script>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">User Reports</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="col-md-12" id="get_users_by_day_chart_div">
                            {{-- <button id="chart" class="btn btn-secondary" value="bar" type="button"><i class="fa fa-bar-chart"></i></button> --}}
                         
                            <div class="text-center border-bottom border-info">
                                <h5>Daily User Report</h5>
                            </div>
                            <canvas id="get_users_by_day_chart_data" width="400" height="400"></canvas>
                            <script>
                                var chart_type = 'line';
                           
                                // var backgroundBorderColor=['#8B4513','#BC8F8F','#FF0000','#00FF00','#0000FF','#FFFF00','#00FFFF','#FF00FF','#C0C0C0','#808080','#800000','#808000','#008000','#800080','#008080','#000080','#FFC0CB','#DC143C','#FF7F50','#CD5C5C','#FFA500','#B8860B','#9ACD32','#00FA9A','#3CB371','#FFD700','#4682B4','#B0C4DE','#8A2BE2','#D2691E'];
                                var backgroundBorderColor = '#36a2eb';
                                var daily = document.getElementById('get_users_by_day_chart_data');
                                daily.height = 300;
                                $.ajax({
                                    url: "{{ route('get_users_by_day_chart_data') }}",
                                    method: "GET",
                                    dataType: 'json',
                                    success: function(data) {
                                        if (data == null || data == 'null') {} else {
                                            var get_users_by_day_chart_data =  {
                                                type: chart_type,
                                                data: {
                                                    labels: data.label,
                                                    datasets: [{
                                                        label: '# Users',
                                                        data: data.data,
                                                        backgroundColor: backgroundBorderColor,
                                                        borderColor: backgroundBorderColor,
                                                        borderWidth: 2,
                                                        fill: false,
                                                    }]
                                                },
                                                options: {
                                                    legend: {
                                                        labels: {
                                                            fontColor: "#131c2b",
                                                            fontSize: 14
                                                        }
                                                    },
                                                    responsive: true,
                                                    scales: {
                                                        xAxes: [{
                                                            ticks: {
                                                                beginAtZero: true,
                                                                fontColor: "#131c2b",
                                                            },
                                                            scaleLabel: {
                                                                display: true,
                                                                labelString: 'Last 30 Days',
                                                                fontColor: '#131c2b',
                                                            },
                                                            gridLines: {
                                                                color: "#cecece"
                                                            }
                                                        }],
                                                        yAxes: [{
                                                            ticks: {
                                                                beginAtZero: true,
                                                                fontColor: "#131c2b",
                                                            },
                                                            scaleLabel: {
                                                                display: true,
                                                                labelString: 'Users',
                                                                fontColor: '#131c2b',
                                                            },
                                                            gridLines: {
                                                                color: "#bfbfbf"
                                                            }
                                                        }]
                                                    }
                                                }
                                            };
                                          new Chart(daily,get_users_by_day_chart_data);
                                          var myChart;
    
  $("#chart").click(function(){
        
    
           if($(this).val() == 'line'){ $(this).val('bar'); $(this).html('<i class="fa fa-bar-chart"></i>');  change('line');}
        else{$(this).html('<i class="fa fa-line-chart"></i>').val('line');  change('bar') ;}
        });
                             

                                function change(newType) {
                                    var ctx = document.getElementById("get_users_by_day_chart_data").getContext("2d");
                                    // console.log(ctx);

                                    // Remove the old chart and all its event handles
                                    if (myChart) {
                                        myChart.destroy();
                                    }

                                    // Chart.js modifies the object you pass in. Pass a copy of the object so we can use the original object later
                                    var temp = jQuery.extend(true, {}, get_users_by_day_chart_data);
                                    temp.type = newType;
                                    myChart = new Chart(ctx, temp);
                                };

                                        }
                                    }
                                });
                            </script>
                        </div>
                        <div class="col-md-12 p-5" id="get_users_by_week_chart_div">
                            <div class="text-center border-bottom border-info">
                                <h5>Weekly User Report</h5>
                            </div>
                            <canvas id="get_users_by_week_chart_data" width="400" height="400"></canvas>
                            <script>
                                // var backgroundBorderColor=['#8B4513','#BC8F8F','#FF0000','#00FF00','#0000FF','#FFFF00','#00FFFF','#FF00FF','#C0C0C0','#808080','#800000','#808000','#008000','#800080','#008080','#000080','#FFC0CB','#DC143C','#FF7F50','#CD5C5C','#FFA500','#B8860B','#9ACD32','#00FA9A','#3CB371','#FFD700','#4682B4','#B0C4DE','#8A2BE2','#D2691E','#F5DEB3','#EE82EE','#40E0D0','#FF6347','#D8BFD8','#D2B48C','#6A5ACD','#2E8B57','#FA8072','#4169E1','#663399','#B0E0E6','#DB7093','#C71585','#FFFACD','#4B0082','#FF69B4','#DAA520','#B22222','#1E90FF','#2F4F4F','#7FFFD4'];
                                var backgroundBorderColor = '#36a2eb';
                                var weekly = document.getElementById('get_users_by_week_chart_data');
                                weekly.height = 330;
                                $.ajax({
                                    url: "{{ route('get_users_by_week_chart_data') }}",
                                    method: "GET",
                                    dataType: 'json',
                                    success: function(data) {
                                        if (data == null || data == 'null') {} else {
                                            var get_users_by_week_chart_data = new Chart(weekly, {
                                                type: chart_type,
                                                data: {
                                                    labels: data.label,
                                                    titles: data.title,
                                                    datasets: [{
                                                        label: '# Users',
                                                        data: data.data,
                                                        backgroundColor: backgroundBorderColor,
                                                        borderColor: backgroundBorderColor,
                                                        borderWidth: 2,
                                                        fill: false,
                                                    }]
                                                },
                                                options: {
                                                    legend: {
                                                        labels: {
                                                            fontColor: "#131c2b",
                                                            fontSize: 14
                                                        }
                                                    },
                                                    responsive: true,
                                                    scales: {
                                                        xAxes: [{
                                                            ticks: {
                                                                beginAtZero: true,
                                                                fontColor: "#131c2b",
                                                            },
                                                            scaleLabel: {
                                                                display: true,
                                                                labelString: 'Last 52 Weeks',
                                                                fontColor: '#131c2b',
                                                            },
                                                            gridLines: {
                                                                color: "#cecece"
                                                            }
                                                        }],
                                                        yAxes: [{
                                                            ticks: {
                                                                beginAtZero: true,
                                                                fontColor: "#131c2b",
                                                            },
                                                            scaleLabel: {
                                                                display: true,
                                                                labelString: 'Users',
                                                                fontColor: '#131c2b',
                                                            },
                                                            gridLines: {
                                                                color: "#bfbfbf"
                                                            }
                                                        }]
                                                    },
                                                    tooltips: {
                                                        callbacks: {
                                                            title: function(tooltipItem, data) {
                                                                // console.log(data);
                                                                return data['titles'][tooltipItem[0]['index']];
                                                            },
                                                            // label: function(tooltipItem) {
                                                            //     return "$" + Number(tooltipItem.yLabel) + " and so worth it !";
                                                            // }
                                                        }
                                                    },
                                                }
                                            });
                                        }
                                    }
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript"></script>
@endsection
