@extends('master')
@section('content')

<div class="bg-gray-100">
    <canvas id="myChart"></canvas>
</div>
</div>
<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
                @foreach($categoryWithVerbatim as $key => $catWithVerb)
                '{{ $catWithVerb['title'] }}',
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
            },{
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
        plugins: [ChartDataLabels],
        options: {
            // responsive: false,
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