@extends('master')
@section('content')


<div class="">
    <canvas id="myChart" class="w-full"></canvas>
</div>


<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
                // list of all verbatims
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
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
                borderRadius: 30,
                barThickness: 16,
                stack: 'Stack 0',
                data: [
                    @foreach($categoryWithVerbatim as $key=> $catWithVerb)
                    @foreach($catWithVerb['positif'] as $positif)
                    {{ $positif.',' }}
                    @endforeach
                    @endforeach
                ]
            },{
                label: 'Negatif',
                backgroundColor: '#c4042c',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
                borderRadius: 30,
                barThickness: 16,
                stack: 'Stack 0',
                data: [
                @foreach($categoryWithVerbatim as $key=> $catWithVerb)
                @foreach($catWithVerb['negatif'] as $negatif)
                {{ '-'.$negatif.',' }}
                @endforeach
                @endforeach
                ]
            },
        ]
        },
        options: {
            responsive: false,
            scales: {
                y: [{
                    ticks: {
                        beginAtZero: true,
                    },
                    stacked: true
                }],
                x: {
                    position:'top',
                },
            },
        }
    });

</script>



<h1>Percentage</h1>

{{-- @dd($totalEachVerbatim) --}}




@endsection