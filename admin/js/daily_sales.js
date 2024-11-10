  var options = {
            chart: {
                type: 'line',
                height: 400,
                zoom: {
                    enabled: true
                },
                toolbar: {
                    show: true
                }
            },
            series: [{
                name: 'Sales',
                data: [100, 200, 150, 400, 250, 500, 300, 450, 550, 600, 650, 700]
            }],
            xaxis: {
                categories: ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5', 'Day 6', 'Day 7', 'Day 8', 'Day 9', 'Day 10', 'Day 11', 'Day 12'],
                labels: {
                    rotate: -45,
                    style: {
                        colors: '#333',
                        fontSize: '12px',
                        fontWeight: 'bold'
                    }
                }
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            markers: {
                size: 5,
                colors: ['#FF5733'],
                strokeColor: '#fff',
                strokeWidth: 2
            },
            grid: {
                borderColor: '#ddd'
            },
            tooltip: {
                shared: true,
                intersect: false,
                y: {
                    formatter: function (value) {
                        return '$' + value + 'k';
                    }
                }
            },
            colors: ['#28a745']
        };

        var chart = new ApexCharts(document.querySelector("#daily_sales_chart"), options);
        chart.render();