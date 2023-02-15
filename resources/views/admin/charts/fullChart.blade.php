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
    <a href="{{ URL::previous() }}">
        <i class="fa-solid fa-xmark fixed z-10 top-0 right-0 text-4xl text-gray-500 cursor-pointer"></i>
    </a>
    <div class="chartContainer border-4">
        <div class="chartContainerBody">
            <canvas id="myChart" class="m-2"></canvas>
        </div>
    </div>


    <script>
        // multiple labels Plugin
    let verbatimCountByCategory = {!! json_encode($verbatimCountByCategory) !!};
    let categoryWithVerbatim = {!! json_encode($categoryWithVerbatim) !!}
    // const subLabels = {
    //     id: 'subLabels',
    //     afterDatasetsDraw(chart, args, pluginOptions) {
    //         const { ctx, chartArea: {left, right, top, bottom, width, height}} = chart;

    //         let xPosition = [];
    //         verbatimCountByCategory.forEach((num) => {
    //             xPosition.push( width / num['total_by_cat']);
    //         })
            
    //         ctx.save();

    //         // displaying category names (calling subLabelText())
    //         for(const key in categoryWithVerbatim) {
    //             subLabelText(categoryWithVerbatim[key]['title'], width / Object.keys(categoryWithVerbatim).length  * categoryWithVerbatim[key]['catPosition'][0])
    //         }

    //         function subLabelText(text, x) {
    //             ctx.font = 'bolder 12px sans-serif';
    //             ctx.textAlign = 'center';
    //             ctx.fillStyle = 'rgba(102,102,102,1)';
    //             // verbatimCountByCategory.forEach(num => {
    //             //     ctx.fillText(text, x +  num['total_by_cat'], top + 10);
    //             // })
    //             ctx.fillText(text, x +  left, top + 10);
    //         }
    //         // end of displaying category names
            
    //         ctx.strokeStyle  = 'lightgray';
    //         [left, right].forEach(x => {
    //             ctx.beginPath();
    //             ctx.moveTo(x, 100);
    //             ctx.lineTo(x, top + 20);
    //             ctx.stroke();
    //         });
            
    //         // console.log(xPosition)
    //         xPosition.forEach(x => {
    //             console.log(x)
    //             ctx.beginPath();
    //             // verbatimCountByCategory.forEach(num => {

    //             ctx.moveTo(x, top);
    //             ctx.lineTo(x, top + 20);
    //             ctx.stroke();
    //         })
    //         ctx.restore();
    //     }
    // }


    // const percentageLabels = {
    //     id: 'percentageLabels',
    //     afterDatasetsDraw(chart, args, pluginOptions) {
    //         const { ctx, chartArea: {left, right, top, bottom, width, height}} = chart;

    //         let percentData = [
    //             @foreach($totalEachVerbatim as $test)
    //                 '{{number_format((float) $test->percent , 2, '.', '')}}',
    //             @endforeach
    //         ];

    //         const xCenter = (left + right) / 2;
    //         const yCenter = bottom + 20;

    //         ctx.save();
    //         ctx.textBaseline = 'middle';
    //         ctx.textAlign = 'center';

    //         // console.log(percentData.length)
    //         for (let i = 0; i < percentData.length; i++) {
    //             const x = xCenter + (i - percentData.length / 2 + 0.5) * 120;
    //             const y = yCenter;

    //             // Draw circle
    //             ctx.beginPath();
    //             ctx.arc(x, y, 15, 0, 2 * Math.PI);
    //             ctx.fillStyle = 'blue';
    //             ctx.fill();

    //             // Draw text
    //             ctx.fillStyle = 'white';
    //             ctx.fillText(percentData[i], x, y);
    //         }
    //         ctx.restore();
    //     }
    // }

    // data block
    const data = {
        // labels: [
        //     @foreach($categoryWithVerbatim as $key => $catWithVerb)
        //         @foreach($catWithVerb['verbatim'] as $verbatim)
        //             '{{ $verbatim }}',
        //         @endforeach
        //     @endforeach
        // ],
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
        plugins: [ChartDataLabels],
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
                    labels: [
                        @foreach($categoryWithVerbatim as $key => $catWithVerb)
                            @foreach($catWithVerb['verbatim'] as $verbatim)
                                '{{ $verbatim }}',
                            @endforeach
                        @endforeach
                            ],
                    position:'top',
                    grid: {
                        display:false,
                    },
                },

                // percentage labels
                x2: {
                    labels: [
                        @foreach($totalEachVerbatim as $test)
                            '{{number_format((float) $test->percent , 2, '.', '')}}',
                        @endforeach
                    ],
                    grid: {
                        display: false,
                    },
                    ticks: {
                        font : {
                            size: 12
                        },
                    }
                },
                // category labels
                x3: {
                    labels: [
                        @foreach($categoryWithVerbatim as $catWithVerb)
                            @foreach($catWithVerb['verbatim'] as $test)
                            '{{ $catWithVerb['title'] }}', 
                            @endforeach
                        @endforeach
                    ],
                    grid: {
                        // display: false
                    },
                    barPercentage: 5,
                    categoryPercentage: 21
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
    
    console.log(config.options.scales.x2.ticks)
    const myChart = new Chart(document.getElementById('myChart'), config);

    const chartContainerBody = document.querySelector('.chartContainerBody');
    // const totalLabels  = myChart.data.labels.length 
    //     if(totalLabels > 7) {
    //         const newWidth = '100vw' + ((totalLabels - 7) * 100)
    //         chartContainerBody.style.width = newWidth + 'vw'
    //     }

        
    const numXLabels = config.options.scales.x.labels.length;

    </script>


</body>

</html>