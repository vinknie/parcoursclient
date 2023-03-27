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
    const flatResult = result.flat();

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
                            height: 10
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
                            borderRadius: 50,
                            width: 120,
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
                            backgroundColor: '#FF875B',
                            color: '#fff',
                            borderRadius: 50,
                            width: 120,
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
                        if(!this._executed) {
                            const counts = {};
                            for (let i = 0; i < flatResult.length; i++) {
                                const element = flatResult[i];
                                counts[element] = counts[element] ? counts[element] + 1 : 1;
                            }
                            const intervals = Object.values(counts)
                            // const uniqueValues = [...new Set(flatResult)];
                            console.log(intervals)
                            let count = 0;
                            for (let i = 0; i < intervals.length; i++) {
                                count += intervals[i];
                                if (count <= index) {
                                    continue;
                                }
                                this._executed = true;
                                return true;
                            }
                            return false;
                        }
                        _executed = false
                    }
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
                }
            }
        ]
    };

    myChart.setOption(option);
</script>

</html>