$(document).ready(function() {
    // AJAX request to fetch the monthly sales data
    $.ajax({
        url: 'backend/end-points/getMonthlySales.php',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.error) {
                console.error(response.error);
                return;
            }

            // Prepare the data from the response
            var months = [];
            var sales = [];

            // Assuming the response is in the format: [{month: "January", sales: 1200}, ...]
            response.forEach(function(item) {
                months.push(item.month);
                sales.push(item.sales);
            });

            // Define chart options
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
                    data: sales, // Monthly sales data dynamically fetched
                    curve: 'smooth' // Smooth line
                }],
                xaxis: {
                    categories: months, // Months from the fetched data
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

            // Create and render the chart
            var chart = new ApexCharts(document.querySelector("#monthly_sales_chart"), options);
            chart.render();
        },
        error: function(xhr, status, error) {
            console.error("Error fetching sales data: ", status, error);
        }
    });
});
