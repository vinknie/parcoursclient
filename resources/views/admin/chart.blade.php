@extends('dashboard')

@section('content')




<div class="" style="overflow-x: scroll;">
    <canvas id="myChart" height="700"></canvas>
</div>



<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June'],
            datasets: [{
                label: 'Dataset 1',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
                stack: 'Stack 0',
                data: [10, 20, -30, 40, -50, 60]
            },
            {
                label: 'Dataset 2',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                stack: 'Stack 0',
                data: [-10, -20, 30, -40, 50, -60]
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                    },
                    stacked: true
                }]
            }
        }
    });


</script>
@endsection