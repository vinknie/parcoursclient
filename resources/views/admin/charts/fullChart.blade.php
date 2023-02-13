<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Parcours Client') }}</title>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- JqueryUI -->
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>

    {{-- manual javascript --}}
    <script src="{{ asset('js/app.js') }}" defer></script>

    {{-- Chart Js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.0/dist/chart.umd.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.2.0/chartjs-plugin-datalabels.min.js"
        integrity="sha512-JPcRR8yFa8mmCsfrw4TNte1ZvF1e3+1SdGMslZvmrzDYxS69J7J49vkFL8u6u8PlPJK+H3voElBtUCzaXj+6ig=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    @vite('resources/css/app.css')
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            display: grid;
            place-items: center;
            min-height: 100vh;
        }

        .chartContainer {
            /* background: rgb(189, 189, 189); */
            /* width: 80%;
            overflow-x: scroll;
            height: 100vh; */
            /* max-height: 1200px; */
        }

        .chartContainerBody {
            width: 100vw;
            /* max-height: 1200px; */
        }

        #myChart {
            height: 95vh !important;
            width: 100vw !important;
        }
    </style>
</head>

<body class="relative">
    <a href="{{ URL::previous() }}"><i
            class="fa-solid fa-xmark fixed z-10 top-0 right-0 text-4xl text-gray-500 cursor-pointer"></i></a>
    <div class="chartContainer border-4">
        <div class="chartContainerBody">
            <canvas id="myChart" class="m-2"></canvas>
        </div>
    </div>

    {{-- @php
    $test = 0;
    @endphp

    @foreach($verbatimCountByCategory as $countByCategory)
    @php $test += $countByCategory->total_by_cat @endphp
    {{ $test}}
    @endforeach --}}

    {{-- @php
    $test = 0;
    @endphp
    @foreach($verbatimCountByCategory as $countByCategory)
    @php
    $test += $countByCategory->total_by_cat;
    @endphp
    @endforeach --}}
    <script>
        // multiple labels Plugin
    const subLabels = {
        id: 'subLabels',
        afterDatasetsDraw(chart, args, pluginOptions) {
            const { ctx, chartArea: {left, right, top, bottom, width, height}} = chart;
            ctx.save();

            @foreach($categoryWithVerbatim as $key => $catWithVerb)
                subLabelText("{!! $catWithVerb['title'] !!}", width / {{ count($categoryWithVerbatim) }}  * {{ $catWithVerb['catPosition'][0]}})
            @endforeach

            function subLabelText(text, x) {
                ctx.font = 'bolder 12px sans-serif';
                ctx.textAlign = 'center';
                ctx.fillStyle = 'rgba(102,102,102,1)';
                ctx.fillText(text, x + left, top + 10);
            }
        }
    }

   // arbitaryLine Plugin
    // const arbitaryLine = {
    //     id : 'arbitaryLine',
    //     beforeDraw(chart, args, options) {
    //         const {ctx, chartArea : {top, right, bottom, left, width, height}, scales: {x, y}} = chart;
    //         ctx.save();

    //         // how to draw
    //         ctx.strokeStyle = options.arbitaryLineColor;
    //         ctx.strokeRect(x.getPixelForValue(options.xPosition), top, 0, bottom);
            
    //         // where to draw
    //         ctx.restore();
    //     }
    // }

    // data block
    const data = {
        labels: [
            @foreach($categoryWithVerbatim as $key => $catWithVerb)
                @foreach($catWithVerb['verbatim'] as $verbatim)
                    '{{ $verbatim }}',
                @endforeach
            @endforeach
        ],
        datasets: [
            {
                label: 'Positif',
                backgroundColor: '#3c7cc4',
                borderRadius: 30,
                barThickness: 16,
                stack: 'Stack 0',
                data: [
                    @foreach($categoryWithVerbatim as $key=> $catWithVerb)
                        @foreach($catWithVerb['positif'] as $positif)
                            {{ $positif.',' }}
                        @endforeach
                        @endforeach
                ],
                datalabels: {
                anchor: 'end',
                align: 'top'
                }
            },
            {
                label: 'Negatif',
                backgroundColor: '#c4042c',
                borderRadius: 30,
                barThickness: 16,
                stack: 'Stack 0',
                data: [
                    @foreach($categoryWithVerbatim as $key=> $catWithVerb)
                        @foreach($catWithVerb['negatif'] as $negatif)
                            {{ '-'.$negatif.',' }}
                        @endforeach
                    @endforeach
                ],
                datalabels: {
                    anchor: 'start',
                    align: 'bottom',
                }
            },
        ]
    }
   
    // config block
    const config = {
        type: 'bar',
        data: data,
        plugins: [ChartDataLabels, subLabels],
        options: {
            responsive: true,
            maintainAspectRatio: false,
             layout: {
                padding: 50
            },
            scales: {
                y: {
                    max: {{ $highestLowest->highest + 4}},
                    min: -{{ $highestLowest->lowest + 2}},
                    ticks: {
                        beginAtZero: true,
                        stepSize: 0.5
                    },
                    stacked: true,
                    grid: {
                        drawOnChartArea: false,
                    },
                    display: false 
                },
                x: {
                    position:'top',
                    grid: {
                        display:false,
                    },
                },
            },
            plugins : {
                arbitaryLine: {
                    arbitaryLineColor : 'blue',
                    xPosition: 2
                }
            },
        }
    }

    const myChart = new Chart(document.getElementById('myChart'), config);

    const chartContainerBody = document.querySelector('.chartContainerBody');
    const totalLabels  = myChart.data.labels.length 
        if(totalLabels > 7) {
            const newWidth = '100vw' + ((totalLabels - 7) * 100)
            chartContainerBody.style.width = newWidth + 'vw'
        }
    </script>


</body>

</html>