<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>ECharts</title>
    <!-- including ECharts file -->
    <script src="https://cdn.jsdelivr.net/npm/echarts@4.9.0/dist/echarts.min.js"></script>
</head>
<style>
    #main {
        height: 85vh !important;
        width: 100% !important;
        /* padding: 50px; */
        /* margin-bottom: 70px; */
        overflow: auto;
    }
</style>

<body>
    <!-- prepare a DOM container with width and height -->
    <div id="main" style=""></div>
</body>

<script>
    // based on prepared DOM, initialize echarts instance
    var myChart = echarts.init(document.getElementById('main'));

    let getAll = {!! json_encode($totalEachVerbatim) !!};
    console.log(getAll)

    const verbatim = getAll.map(el => el.verbatim);
    const positif = getAll.map(el => el.positif);
    const negatif = getAll.map(el => '-' + el.negatif);
    const percent = getAll.map(el => el.percent.toFixed(2) + '%')
    const category = getAll.map(el => el.title);
    // console.log(uniqueCat)
    const uniqueCat = [...new Set(category)];
    const result = [];

    uniqueCat.forEach(value => {
        const duplicates = category.filter(item => item === value);
        result.push(duplicates);
    });

    const final = [];
    for (let i = 0; i < result.length; i++) {
        let position = Math.floor(result[i].length / 2);
        for (let j = 0; j < result[i].length; j++) {
            if (j === position) {
                final.push(result[i][j]);
            } else {
                final.push("");
            }
        }
    }

    var option = {
        grid: {
            top: '10%',
            left: '3%',
            right: '3%',
            bottom: '5%', // Augmenter l'espace en dessous de la charte
            containLabel: true
        },
        "xAxis": [{
                "type": "category",
                data: verbatim,
                position: 'top',
                axisTick: {
                    show: false
                },
                "axisTick": {
                    show: false
                }
            },
            {
                type: 'category',
                position: 'bottom',
                data: percent,
                offset: 10,
                axisLabel: {
                    formatter: function(value, index) {
                        return '{a|' + value + '}\n{b| }';
                    },
                    rich: {
                        a: {
                            backgroundColor: '#3498db',
                            color: '#fff',
                            borderRadius: 50,
                            width: 55,
                            height: 55,
                            textAlign: 'center',
                            lineHeight: 30,
                            fontSize: 12,
                            fontWeight: 'bold'
                        },
                        b: {
                            height: 10
                        }
                    }
                },
            },
            {
                type: 'category',
                position: 'bottom',
                data: final,
                offset: 65,
                axisLabel: {
                    show: true,
                    interval: 0,
                    formatter: function(value, index) {
                        if (index % 2 == 0) {
                            return '{a|' + value + '}';
                        } else {
                            return '{b|' + value + '}';
                        }
                    },
                    rich: {
                        a: {
                            backgroundColor: '#2ecc71',
                            color: '#fff',
                            borderRadius: 50,
                            width: 120,
                            height: 30,
                            textAlign: 'center',
                            lineHeight: 30,
                            fontSize: 12,
                            fontWeight: 'bold'
                        },
                        b: {
                            backgroundColor: '#e74c3c',
                            color: '#fff',
                            borderRadius: 50,
                            width: 120,
                            height: 30,
                            textAlign: 'center',
                            lineHeight: 30,
                            fontSize: 12,
                            fontWeight: 'bold'
                        },
                    }
            //         textStyle: {
            //     backgroundColor: 'red',
            //     borderRadius: 2
            // }
                },
                splitLine: {
                    show: true
                },
            }],

        "yAxis": [{
            type: 'value',
            splitLine: {
                show: false
            }
        }],
        "series": [{
                "type": "bar",
                "name": "Positif",
                "data": positif,
                "stack": "stack1",
                "barCategoryGap": "40%",
                "barWidth": "30%",
                "barMaxWidth": 50,

                "itemStyle": {
                    "color": "#3498db",

                }
            },
            {
                "type": "bar",
                "name": "Negatif",
                "data": negatif,
                "stack": "stack1",
                "barCategoryGap": "40%",
                "barWidth": "30%",
                "barMaxWidth": 50,
                "itemStyle": {
                    "color": "#e74c3c"
                }
            }

        ]
    };

   
    myChart.setOption(option);

</script>

</html>