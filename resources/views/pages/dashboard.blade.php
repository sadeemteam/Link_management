@extends('layouts.dashboard.dashboard')

<?php
    $user = auth()->user();
    $SA = $user->hasRole('SUPER-ADMIN');

    $overview = array(
        array(
            "icon"=>"fa-solid fa-link-simple",
            'title'=>"Total links", 
            "total"=>count($links)
        ),
        array(
            "icon"=>"fa-regular fa-eye",
            'title'=>"Links Pageview", 
            "total"=>count($analytics)
        ),
        array(
            "icon"=>"fa-solid fa-list-check",
            'title'=>"Total Projects", 
            "total"=>count($projects)
        ),
        array(
            "icon"=>"fa-regular fa-qrcode",
            'title'=>"Total QR Codes", 
            "total"=>count($qrcodes)
        ),
    );

    // Counting the total page visitor of 12 months
    $counter = [];
    foreach($analytics as $item){
        $month = $item->created_at->format('M');
        $year = $item->created_at->format('Y');
        if ($year == date("Y")) {
            array_push($counter, $month);
        }
    };

    $values = [];
    $result = array_count_values($counter);    
    $counting = ["Jan"=>0, "Feb"=>0, "Mar"=>0, "Apr"=>0, "May"=>0, "Jun"=>0, "Jul"=>0, "Aug"=>0, "Sep"=>0, "Oct"=>0, "Nov"=>0, "Dec"=>0];
    foreach ($result as $key => $value) {
        foreach ($counting as $k => $v) {
            if ($k == $key) {
                $counting[$k] = $value;
            }
        }
    }
    foreach ($counting as $key => $value) {
        array_push($values, $value);
    }

    // Counting the weekly page view
    $weeklyPageView = [0, 0, 0, 0, 0, 0, 0];
    foreach($analytics as $item){
        $day = $item->created_at->format('d');
        $year = $item->created_at->format('Y');
        $month = $item->created_at->format('m');
        
        if ($year == date("Y") && $month == date("m")) {
            for ($i=6, $j=0; $i >= 0 ; $i--, $j++) { 
                $d=strtotime("-{$i} Days");
                $countDay = date("d", $d);
                if ($countDay == $day) {
                    $weeklyPageView[$j]++;
                }
            }
        }
    };

    $lastSevenDays = [];
    for ($i=6; $i >= 0; $i--) { 
        $d=strtotime("-{$i} Days");
        $countDay = date("d M y", $d);
        array_push($lastSevenDays, $countDay);
    };
?>

@section('content')
<div class="container py-3 userDashboard">
    <input type="hidden" id="lastSevenDays" value="{{json_encode($lastSevenDays)}}">

    <div class="row">
        @foreach($overview as $item)
            <div class="col-lg-3 mb-4">
                <div class="card overview">
                    <span class="icon text-primary">
                        <i class="{{$item["icon"]}}"></i>
                    </span>
                    <p class="title">{{$item["title"]}}</p>
    
                    <div class="d-flex align-items-center justify-content-between">
                        <h4 class="total fw-bold">{{$item["total"]}}</h4>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="p-3">
                    <h6>{{__('Page view activities')}}</h6>
                </div>
                <div id="analytics"></div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="p-3">
                    <h6>{{__('Visitors')}}</h6>
                </div>
                <div id="visitors"></div>
            </div>
        </div>
    </div>

    <script>
        const lastSevenDays = document.getElementById('lastSevenDays').value;

        var options = {
            series: [
                {
                    name: "series1",
                    data: {{json_encode($weeklyPageView)}},
                },
            ],
            chart: {
                height: 300,
                type: "area",
                toolbar: {
                    show: false,
                },
            },
            dataLabels: {
                enabled: false,
            },
            stroke: {
                curve: "smooth",
            },
            xaxis: {
                categories: JSON.parse(lastSevenDays),
            },
            yaxis: {
                min: 0,
                tickAmount: 5,
            },
            grid: {
                xaxis: {
                    lines: {
                        show: false,
                    },
                },
                yaxis: {
                    lines: {
                        show: false,
                    },
                },
                padding: {
                    top: 0,
                    right: 8,
                    bottom: 0,
                    left: 10,
                },
            },
            tooltip: {
                x: {
                    format: "dd/MM/yy HH:mm",
                },
            },
        };

        var chart = new ApexCharts(document.querySelector("#analytics"), options);
        chart.render();

        var barOption = {
            series: [
                {
                    data: {{json_encode($values)}},
                },
            ],
            chart: {
                type: "bar",
                height: 300,
                toolbar: {
                    show: false,
                },
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    horizontal: false,
                    columnWidth: "50%",
                },
            },
            dataLabels: {
                enabled: false,
            },
            xaxis: {
                categories: [
                    "Jan",
                    "Feb",
                    "Mar",
                    "Apr",
                    "May",
                    "Jun",
                    "Jul",
                    "Aug",
                    "Sep",
                    "Oct",
                    "Nov",
                    "Dec",
                ],
            },
            grid: {
                xaxis: {
                    lines: {
                        show: false,
                    },
                },
                yaxis: {
                    lines: {
                        show: false,
                    },
                },
                padding: {
                    top: 0,
                    right: 16,
                    bottom: 0,
                    left: 12,
                },
            },
        };

        var visitors = document.querySelector("#visitors");
        if (visitors) {
            var barChart = new ApexCharts(visitors, barOption);
            barChart.render();
        }
    </script>
</div>
@endsection
