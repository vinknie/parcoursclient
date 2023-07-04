<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>ECharts</title>
    <!-- including ECharts file -->
    <script src="https://cdn.jsdelivr.net/npm/echarts@4.9.0/dist/echarts.min.js"></script>


    @vite('resources/css/app.css')
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- custom css --}}
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>

<body class="relative">
    <a href="{{ URL::previous() }}"
        style="position: absolute; top: 0; right: 10px; font-size: 38px; z-index: 100">&times;</a>
    <!-- prepare a DOM container with width and height -->
    <div id="main" style="box-shadow: 10px 5px 5px rgb(141, 141, 141);"></div>
</body>

<script>
    // based on prepared DOM, initialize echarts instance
    var myChart = echarts.init(document.getElementById('main'));
    let getAll = {!! json_encode($totalEachVerbatim) !!};
    const verbatim = getAll.map(el => el.verbatim);
    const positif = getAll.map(el => el.positif);
    const negatif = getAll.map(el => '-' + el.negatif);
    const percent = getAll.map(el => el.percent.toFixed(2) + '%')
    const category = getAll.map(el => el.title);
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
    
    const test = result.map(item => item.length * 200).reverse();
    // console.log(test);
    const rich = {
        a: {
            backgroundColor: '#2ecc71',
            color: '#fff',
            // borderRadius: 50,
            width: 0,
            height: 30,
            // textAlign: 'center',
            lineHeight: 30,
            fontSize: 12,
            fontWeight: 'bold'
        },
        b: {
            width: 0,
            height: 30,
            // textAlign: 'center',
            lineHeight: 30,
            fontSize: 12,
            fontWeight: 'bold'
        },
        c: {
            color: '#555',
            // borderRadius: 50,
            width: 0,
            height: 30,
            // textAlign: '',
            lineHeight: 30,
            fontSize: 12,
            fontWeight: 'bold'
        }
    };
    const richWithWidth = Object.entries(rich).map(([key, value], index) => {
        return {
            [key]: {
            ...value,
            width: test[index] // use dynamic width from array
            }
        };
    });
    // merge updated widths back into rich object
    const updatedRich = Object.assign({}, ...richWithWidth);
    console.log(test);

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
                    rich: updatedRich,
                },
                splitLine: {
                    show: true,
                    lineStyle: {
                        type: 'dashed',
                        width: 1.5
                    },
                    interval: function(index, value) {
                        if(index == 3) {
                            console.log(index);
                            return true;
                        }
                        // return true
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
        const verbaId = getAll.find(item => item.verbatim === verbaName)?.id_verbatim ?? null;
        const url = "/fullchart/popup/" + verbaId;
        const response = await fetch(url);
        const data = await response.text();
        const popup = document.createElement('div');
        popup.classList.add('dialogue-popup', 'flex', 'items-center', 'justify-center', 'fixed',
            'left-0', 'bottom-0', 'w-full', 'h-full', 'bg-gray-800', 'relative');
        const dialogueContent = document.createElement('div');
        dialogueContent.classList.add('dialogue-content', 'bg-white', 'w-2/3', 'lg:max-w-lg', 'mx-auto', 'rounded', 'shadow-lg', 'z-50', 'overflow-y-auto', 'relative');
        
        const jsonData = JSON.parse(data);
        // Parcourir les dialogues et construire le HTML pour chaque dialogue
        let dialogueHtml = '';
        dialogueHtml += `<h1 class="text-xl font-bold text-gray-800 m-4 text-center">${jsonData[0] ? jsonData[0].verbatim : 'Pas de dialogue'}</h1>`;
        jsonData.forEach(dialogue => {
            var sentimentIcon = '';
            if (dialogue.positif > 0) {
                sentimentIcon += '<span class="inline-flex items-center justify-center h-6 w-6 rounded-full bg-green-500 text-white flex-shrink-0 mr-2">+</span>';
            } else if (dialogue.neutre > 0) {
                sentimentIcon += '<span class="inline-flex items-center justify-center h-6 w-6 rounded-full bg-gray-500 text-white flex-shrink-0 mr-2">=</span>';
            } else if (dialogue.negatif > 0) {
                sentimentIcon += '<span class="inline-flex items-center justify-center h-6 w-6 rounded-full bg-red-500 text-white flex-shrink-0 mr-2">-</span>';
            }
            dialogueHtml += '<div class="bg-white shadow-md rounded px-8 py-6 m-4">';
            dialogueHtml += '<div class="flex items-center mb-4">' + sentimentIcon + '<h2 class="text-lg font-medium text-gray-800">' + dialogue.dialogue + '</h2></div>';
            dialogueHtml += '</div>';
        });
        dialogueHtml += '<button class="close-button absolute top-0 right-0 m-4 text-gray-600 hover:text-gray-800">&times;</button>';
        dialogueContent.innerHTML = dialogueHtml;
        popup.appendChild(dialogueContent);
        document.body.appendChild(popup);
        popup.style.display = "block";
        document.querySelector(".close-button").addEventListener("click", function(e) {
            document.querySelector(".dialogue-popup").remove();
        });
        popup.addEventListener("click", function(e) {
            document.querySelector(".dialogue-popup").remove();
            
        });
    })
</script>

</html>