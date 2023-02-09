@extends('master')
@section('content')
<div class="border-4 ">
    <canvas id="myChart" class="bg-red-100 m-2"></canvas>
</div>

{{-- @php
echo '
<pre>';
foreach($categoryWithVerbatim as $test) {
    var_dump($test['title']);
};
echo '</pre>'; --}}
{{-- @endphp --}}
{{-- @foreach($categoryWithVerbatim as $catWithVerb)
{{ $catWithVerb['title'] }} |
@endforeach --}}

<script>
    // the category names
    const subLabels = {
        id: 'subLabels',
        afterDatasetsDraw(chart, args, pluginOptions) {
            const { ctx, chartArea: {left, right, top, bottom, width, height}} = chart;
            ctx.save();

            @foreach($categoryWithVerbatim as $key => $catWithVerb)
            console.log('{{$catWithVerb['title']}}')
                subLabelText("{{$catWithVerb['title']}}", width / {{count($categoryWithVerbatim)}}  * {{$key}})
            @endforeach

            function subLabelText(text, x) {
                ctx.font = 'bolder 12px sans-serif';
                ctx.textAlign = 'center';
                ctx.fillText(text, x + left, bottom + 20);
            }
        }
    }
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
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
        },
        plugins: [ChartDataLabels, subLabels],
        options: {
            // responsive: false,
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
                    // max: 12,
                    position:'top',
                    grid: {
                        display:false,
                    }
                },
            },  
        }
    });
</script>
@endsection