<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Parcours Client</title>
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

        .chartContainerBody {
            width: 100vw;
        }

        #myChart {
            height: 95vh !important;
            width: 100vw !important;
        }

        .chartContainer img:first-child {
            top: 320px;
        }

        .chartContainer img:nth-child(2) {
            top: 50px;
        }

        .chartContainer img:last-of-type {
            bottom: 230px
        }

        @media(min-height: 750px) {
            .chartContainer img:nth-child(2) {
                top: 90px;
            }
        }
    </style>
</head>

<body class="relative">

    {{-- @foreach($categoryWithVerbatim as $key => $catWithVerb)
    @foreach($catWithVerb['verbatim'] as $key => $verbatim)
    '{{ $key }}',
    @endforeach
    @endforeach --}}



    <a href="{{ URL::previous() }}">
        <i class="fa-solid fa-xmark fixed z-10 top-0 right-0 text-4xl text-gray-500 cursor-pointer"></i>
    </a>

    {{-- chart js --}}
    <div class="chartContainer border-4 relative">
        <div class="chartContainerBody">
            <canvas id="myChart" class="m-2"></canvas>
        </div>
        <div class="flex flex-col justify-center absolute top-0 bottom-0 left-2">
            <img src="{{ asset('images/happy.png')}}" alt="happy emoji" class="w-7 absolute">
            <img src="{{ asset('images/neutral.png')}}" alt="neutral emoji" class="w-7 relative">
            <img src="{{ asset('images/sad.png')}}" alt="sad emoji" class="w-7 absolute">
        </div>
    </div>


    <script>
        // multiple labels Plugin
        let verbatimCountByCategory = {!! json_encode($verbatimCountByCategory) !!};
        let categoryWithVerbatim    = {!! json_encode($categoryWithVerbatim) !!}

        // data block
        const data = {
            labels: [
                @foreach($categoryWithVerbatim as $key => $catWithVerb)
                    @foreach($catWithVerb['verbatim'] as $key => $verbatim)
                        '{{ $key }}',
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
            plugins: [ChartDataLabels],
            options: {
                responsive: false,
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
                            stepSize: 0.5,
                            display: false
                        },
                        stacked: true,
                        grid: {
                            // drawOnChartArea: false,
                            drawBorder: false,
                            color: function(context) {
                                if (context.tick.value === 0) {
                                return 'rgba(0,0,0,0.2)'; // Set color for grid line at zero value
                                }
                            },
                            lineWidth: function(context) {
                                if (context.tick.value === 0) {
                                return 1; // Set line width for grid line at zero value
                                } else {
                                return 0; // Hide other grid lines
                                }
                            },
                            zeroLineColor: 'black', // Set color for zero line
                            zeroLineWidth: 1, // Set line width for zero line
                        },
                        // display: false,
                    },

                    // top phrase labales
                    x: {
                        labels: [
                            @foreach($categoryWithVerbatim as $key => $catWithVerb)
                                @foreach($catWithVerb['verbatim'] as $verbatim)
                                    "{!! $verbatim !!}",
                                @endforeach
                            @endforeach
                            ],
                        position:'top',
                        grid: {
                            display:false,
                        },
                        ticks: {
                        }
                    },

                    // percentage labels
                    x2: {
                        labels: [
                            @foreach ($totalEachVerbatim as $test)
                                "{!! number_format((float) $test->percent, 2, '.', '') !!} %",
                            @endforeach
                        ],
                        grid: {
                            display: false,
                        },
                        ticks: {
                            font: {
                                size: 12,
                                family: 'FontAwesome',
                            },
                            showLabelBackdrop: true,
                            backdropPadding: 6,
                            backdropColor: function(value) {
                                var percent = parseFloat(value.tick.label);
                                if (typeof percent === 'number' && !isNaN(percent)) {
                                    var alpha = percent / 100;
                                    return 'rgba(30, 144, 255, ' + alpha + ')';
                                } else {
                                    return 'gray';
                                }
                            },
                        },
                    },
                    // category labels
                    x3: {
                        labels: [
                            @foreach($categoryWithVerbatim as $catWithVerb)
                            "{!! $catWithVerb['title'] !!} ",
                            @endforeach
                        ],
                        grid: {
                            display: false,
                        },
                        border: {
                            display: true,
                            color: '#7dba80',
                            width: 2
                        },
                        ticks: {
                            showLabelBackdrop: true,
                            backdropColor: ['#7dba80', '#c6cfc7'],
                            backdropPadding: 9,
                            color:['white', 'black'],
                        },
                    }, 
                },
            }
        }
        const ctx = document.getElementById('myChart');
        const myChart = new Chart(ctx, config);

        const chartContainerBody = document.querySelector('.chartContainerBody');

        
        const clickableBar = (canvas, click) => {
            const points = myChart.getElementsAtEventForMode(click, 'nearest', { intersect: true }, true);
            if(points.length) {
                const firstPoint = points[0];

                const id_verbatim = myChart.data.labels[firstPoint.index];
                const url = "/fullchart/popup/" + id_verbatim ;
                location.href = url
                // console.log(url)
            }
        }

        ctx.addEventListener('click', e => clickableBar(ctx, e))
    </script>

    <div id="pop_up" style="height: 250px; width: 500px; background: rgba(0,0,0,0.5)">dsf</div>
</body>

</html>