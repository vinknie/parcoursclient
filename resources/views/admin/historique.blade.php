@extends('master')
@section('content')

<div class="mt-28">
    <div class="">
        {{-- left chart --}}
        <div class="w-full">
            <div class="w-1/2 flex items-center justify-between pb-2 px-5">
                <select name="chart_month1" id="choose_month1" class="rounded w-60 py-1 px-3 border-0 shadow">
                    <option value="">Choisissez un mois</option>
                    @foreach ($historique_monthYear as $month)
                    <option value="{{ $month->month_year }}">{{$month->month_year}}</option>
                    @endforeach
                </select>
            </div>
            <div class="">
                <div class="">
                    <canvas id="myChart1" class="m-2 w-full hidden"></canvas>
                </div>
            </div>
        </div>


        {{-- right chart --}}
        <div class="w-full">
            <div class="w-1/2 flex items-center justify-between pb-2 px-5 ">
                <select name="chart_month2" id="choose_month2" class="rounded w-60 py-1 px-3 border-0 shadow">
                    <option value="">Choisissez un mois</option>
                    @foreach ($historique_monthYear as $month)
                    <option value="{{ $month->month_year }}">{{$month->month_year}}</option>
                    @endforeach
                </select>
            </div>
            <div class="">
                <div class="">
                    <canvas id="myChart2" class="m-2 w-full hidden"></canvas>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    function destroy() {
        return [];
    }
    function loadChart(selectId, chartId) {
        let myChart;
        
        jQuery(selectId).on('change',function(){
            if(myChart) {
            myChart.destroy();
        }
            // const currentUserId = {{Auth::user()->id}};
            const month_year = jQuery(this).val();
            if(month_year) {
                jQuery.ajax({
                    url : '/dashboard/historique/fetchChart/' +month_year,
                    type : "GET",
                    dataType : "json",
                    success:function(chartData)
                    {
                        console.log(chartData)
                        // ===============C H A R T   J S================
                        const data = {
                            labels: chartData.map(d => d.verbatim),
                            datasets: [{
                                    label: 'Positif',
                                    backgroundColor: '#3c7cc4',
                                    borderRadius: 30,
                                    barThickness: 16,
                                    stack: 'Stack 0',
                                    data: chartData.map(d => d.positif),
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
                                    data: chartData.map(d => '-' + d.negatif),
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
                                        max: 30,
                                        min: -30,
                                        beginAtZero: true,
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
                                        labels: chartData.map(hbm => hbm.verbatim),
                                        position: 'top',
                                        grid: {
                                            display: false,
                                        },
                                        ticks: {}
                                    },
                                    // category labels
                                    x3: {
                                        labels: chartData.map(hbm => hbm.title),
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

                        
                        const ctx = document.getElementById(chartId);
                        myChart = new Chart(ctx, config);
                       
                        // =======================================================
                    }
                });
            } else {
                alert('hi');
            }
        });
    }
    jQuery(document).ready(function() {
        loadChart('#choose_month1', 'myChart1');
        loadChart('#choose_month2', 'myChart2');
    })
</script>

@endsection