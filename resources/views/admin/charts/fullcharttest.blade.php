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
        min-height: 95vh !important;
        /* width: 100% !important; */
        /* padding: 50px; */
        /* margin-bottom: 70px; */
        /* overflow: auto; */
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
    // console.log(getAll)

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
    // tenzin testing for vertical line
    // console.log(result)
    // for(let i =0; i <)

    var option = {
        grid: {
            top: '10%',
            left: '3%',
            right: '3%',
            bottom: '10%', // Augmenter l'espace en dessous de la charte
            containLabel: true
        },
        "xAxis": [
            // first xAxis, verbatim on top
            {
                "type": "category",
                data: verbatim,
                position: 'top',
                axisLabel: {
                    rotate: 35,
                    fontSize: 18,
                    backgroundColor: '#F5F7FA',
                    padding: [3,4,5,6],
                    borderRadius: 5,
                }
                
            },
            // second xAxis, percentages
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
                            // height: 10
                        }
                    }
                },
                splitLine: {
                    show: false,
                }
            },
            // third xAxis, parent categories
            {
                type: 'category',
                position: 'bottom',
                data: final,
                offset: 65,
                axisLabel: {
                    // show: true,
                    interval: 0,
                    // rotate: 45,
                    // align: 'left',
                    formatter: function(value, index) {
                        if (index % 2 == 0) {
                            if (value !== '') {
                                return '{a|' + value + '}';
                            } else {
                                return '{b|' + value + '}';
                            }
                        } else {
                            if (value !== '') {
                                return '{c|' + value + '}';
                            } else {
                                return '{b|' + value + '}';
                            }
                        }
                    },
                    rich: {
                        a: {
                            backgroundColor: '#2ecc71',
                            color: '#fff',
                            // borderRadius: 50,
                            width: 150,
                            height: 30,
                            textAlign: 'center',
                            lineHeight: 30,
                            fontSize: 12,
                            fontWeight: 'bold'
                        },
                        b: {
                            width: 120,
                            height: 30,
                            textAlign: 'center',
                            lineHeight: 30,
                            fontSize: 12,
                            fontWeight: 'bold'
                        },
                        c: {
                            backgroundColor: '#2ecc71',
                            color: '#fff',
                            // borderRadius: 50,
                            width: 150,
                            height: 30,
                            textAlign: 'center',
                            lineHeight: 30,
                            fontSize: 12,
                            fontWeight: 'bold'
                        }
                    }
                },
                splitLine: {
                    show: true,
                    lineStyle: {
                        type: 'dashed',
                        width: 1.5
                    },
                    interval: function(index, value) {
                        // if(index === 3) {
                        //     return true;
                        // } 
                        return true
                    },
                }
            }
        ],

        "yAxis": [{
            type: 'value',
            splitLine: {
                show: false
            }
        }],
        "series": [
            {
                "type": "bar",
                "name": "Positif",
                "data": positif,
                "stack": "stack1",
                "barCategoryGap": 40,
                "barWidth": 20,
                "barMaxWidth": 50,
                "itemStyle": {
                    "color": "#3498db",
                    "barBorderRadius": 50,
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
                    "color": "#e74c3c",
                    "barBorderRadius": 50,
                    "formatter": function(params) {
                        return '-99';
                    }
                }
            }
        ]
    };

    myChart.setOption(option);

    myChart.on('click', async (e) => {
        const verbaName = e.name;

        const url = "/fullchart/popup/" + verbaName;
        
        const res = await fetch(url);
        const data = await res;
        console.log(data);
    })

</script>

</html>