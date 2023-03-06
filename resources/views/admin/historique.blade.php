@extends('master')
@section('content')

<div class="mt-28">
    <div class="flex justify-around">
        {{-- left chart --}}
        <div class="w-full mx-5">
            <form action="{{ route('admin.historiqueByMonth') }}" method="POST" id="chart_form1">
                <div class="flex items-center justify-between pb-2 px-5 border-b-2 border-gray-400 rounded-lg">
                    @csrf
                    <label for="choose_month1" class="tracking-wide font-semibold">Choisissez un mois</label>
                    <div>
                        <select name="chart_month1" id="choose_month1"
                            class="rounded w-60 py-1 px-3 border-0 border-b-1">
                            @foreach ($historique_monthYear as $key => $month)
                            <option value="{{ $month->month_year }}">
                                {{$month->month_year}}
                            </option>
                            @endforeach
                        </select>
                        <button class="bg-gray-800 text-slate-200 px-2 py-1 rounded">GO</button>
                    </div>
                </div>
            </form>

            <div class="">
                <div class="">
                    <canvas id="myChart1" class="m-2 w-full"></canvas>
                </div>
            </div>


        </div>
        {{-- <div style=" width: 1px; height: 80vh; background: rgba(203, 202, 202, 0.744)"> --}}
            {{-- </div> --}}

        {{-- right chart --}}
        <div class="w-full mx-5">
            <div class="flex items-center justify-between pb-2 px-5 border-b-2 border-gray-400 rounded-lg">
                <label for="choose_month" class="tracking-wide font-semibold">Choisissez un mois</label>
                <div>
                    <select name="chart_month1" id="choose_month" class="rounded w-60 py-1 px-3">
                        @foreach ($historique_monthYear as $month)
                        <option value="{{ $month->month_year }}">{{$month->month_year}}</option>
                        @endforeach
                    </select>
                    <button class="bg-gray-800 text-slate-200 px-2 py-1 rounded">GO</button>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    const historique_by_month = {!! json_encode($historique_by_month) !!}

    // data block
    const data = {
        labels: [
            @foreach ($historique_by_month as $hbm)
                '{{ $hbm['verbatim'] }}',
            @endforeach
        ],
        datasets: [{
                label: 'Positif',
                backgroundColor: '#3c7cc4',
                borderRadius: 30,
                barThickness: 16,
                stack: 'Stack 0',
                data: [
                    @foreach ($historique_by_month as $hbm)
                        {{ $hbm['positif'] }},
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
                    @foreach ($historique_by_month as $hbm)
                        {{ '-' . $hbm['negatif'] . ',' }}
                    @endforeach
                ],
                datalabels: {
                    anchor: 'start',
                    align: 'bottom',
                }
            },
        ]
    }


    const config = {
        type: 'bar',
        data: data,
        plugins: [ChartDataLabels],
        options: {
            // indexAxis: 'y',
            responsive: false,
            maintainAspectRatio: false,
            layout: {
                padding: 50
            },

            scales: {
                y: {
                    max: {{ $highestLowest->highest + 4 }},
                    min: -{{ $highestLowest->lowest + 4 }},
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
                    // display: true,
                },

                // top phrase labales
                x: {
                    labels: historique_by_month.map(hbm => hbm.verbatim),
                    position: 'top',
                    grid: {
                        display: false,
                    },
                    ticks: {}
                },

                // category labels
                x3: {
                    labels: historique_by_month.map(hbm => hbm.title),
                    grid: {
                        display: true,
                    },
                    border: {
                        display: true,
                        color: '#7dba80',
                        width: 2
                    },
                    ticks: {
                        showLabelBackdrop: true,
                        backdropColor: ['#7dba80'],
                        backdropPadding: 9,
                        color: ['white'],
                    },
                },
            },
        }
    }

    const ctx = document.getElementById('myChart1');
    console.log(ctx)
    const myChart = new Chart(ctx, config);
</script>
@endsection