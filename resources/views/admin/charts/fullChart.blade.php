@extends('master')
@section('content')
<div class="border-4 ">
    <canvas id="myChart" class="bg-red-100 m-2"></canvas>
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
                subLabelText("{!! $catWithVerb['title'] !!}", width / 5.3  * {{ $catWithVerb['catPosition'][0]}})
            @endforeach

            function subLabelText(text, x) {
                ctx.font = 'bolder 12px sans-serif';
                ctx.textAlign = 'center';
                ctx.fillStyle = 'rgba(102,102,102,1)';
                ctx.fillText(text, x + left, bottom + 20);
            }
        }
    }

   // arbitaryLine Plugin
    const arbitaryLine = {
        id : 'arbitaryLine',
        beforeDraw(chart, args, options) {
            const {ctx, chartArea : {top, right, bottom, left, width, height}, scales: {x, y}} = chart;
            ctx.save();

            // how to draw
            ctx.strokeStyle = options.arbitaryLineColor;
            ctx.strokeRect(x.getPixelForValue(options.xPosition), top, 0, bottom);
            
            // where to draw
            ctx.restore();
        }
    }

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
        plugins: [ChartDataLabels, subLabels, arbitaryLine],
        options: {
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
            }
        }
    }

    const myChart = new Chart(document.getElementById('myChart'), config);
   
</script>
@endsection
