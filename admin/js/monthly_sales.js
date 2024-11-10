var options = {
    chart: {
        type: 'line',
        height: 400,
        zoom: {
            enabled: true,
            type: 'xy'
        },
        toolbar: {
            show: true,
            tools: {
                download: true,
                zoomin: true,
                zoomout: true,
                pan: true,
            }
        }
    },
    series: [{
        name: 'Sales',
        data: [1200, 1500, 1300, 1400, 1700, 1800, 1600, 2100, 2000, 2200, 2300, 2500], // Monthly sales data
        curve: 'smooth' // Smooth line
    }],
    xaxis: {
        categories: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        labels: {
            style: {
                fontSize: '14px',
                fontWeight: 'bold',
                colors: '#888'
            }
        }
    },
    yaxis: {
        labels: {
            formatter: function(value) {
                return value;
            }
        }
    },
    
    tooltip: {
        enabled: true,
        theme: 'dark',
        x: {
            show: true,
            format: 'MMM'
        },
        y: {
            title: 'Sales: '
        }
    },
    stroke: {
        curve: 'smooth',
        width: 3
    },
    fill: {
        type: 'gradient',
        gradient: {
            shade: 'light',
            type: 'vertical',
            shadeIntensity: 0.4,
            gradientToColors: ['#FF9F00'],
            inverseColors: false,
            opacityFrom: 0.7,
            opacityTo: 0.2,
            stops: [0, 90, 100]
        }
    },
    markers: {
        size: 6,
        colors: ['#FF4560'],
        strokeColors: '#fff',
        strokeWidth: 2,
        hover: {
            size: 10
        }
    }
};

var chart = new ApexCharts(document.querySelector("#monthly_sales_chart"), options);
chart.render();