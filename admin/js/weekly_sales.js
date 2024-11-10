var options = {
    chart: {
        type: 'bar',
        height: 400,
        toolbar: {
            show: true
        }
    },
    series: [{
        name: 'Weekly Sales',
        data: [1200, 1600, 1800, 2100, 2500, 2200, 2300]  // Sales data for each week
    }],
    xaxis: {
        categories: ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5', 'Week 6', 'Week 7'],
        labels: {
            style: {
                colors: '#333',
                fontSize: '14px',
                fontWeight: 'bold'
            }
        }
    },
    title: {
        text: 'Weekly Sales Overview',
        align: 'center',
        style: {
            fontSize: '20px',
            fontWeight: 'bold',
            color: '#333'
        }
    },
    colors: ['#2e93f9'],  // Blue color for bars
    grid: {
        show: true,
        borderColor: '#ccc',
        strokeDashArray: 4,
        xaxis: {
            lines: { show: true }
        }
    },
    plotOptions: {
        bar: {
            horizontal: false,
            columnWidth: '60%',
            endingShape: 'rounded'
        }
    },
    dataLabels: {
        enabled: false
    },
    tooltip: {
        y: {
            formatter: function (value) {
                return '$' + value + 'k';  // Format sales value as currency
            }
        }
    }
};

var chart = new ApexCharts(document.querySelector("#weekly_sales_chart"), options);
chart.render();