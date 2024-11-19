// jQuery AJAX request to fetch weekly sales data
$.ajax({
    url: 'backend/end-points/getWeeklySales.php',  // Your PHP endpoint for weekly sales data
    type: 'GET',
    dataType: 'json',
    success: function(data) {
        // console.log(data)
        // Prepare the data for the chart
        let weeklySalesData = [];
        let weeks = [];

        // Loop through the response data and prepare the arrays
        data.forEach(function(item) {
            weeklySalesData.push(item.sales);  // Add weekly sales to the data array
            weeks.push(item.week);  // Add the week labels to the categories
        });

        // Now render the chart with the dynamic data
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
                data: weeklySalesData  // Use the dynamic weekly sales data
            }],
            xaxis: {
                categories: weeks,  // Use the dynamic weeks for the categories
                labels: {
                    style: {
                        colors: '#333',
                        fontSize: '14px',
                        fontWeight: 'bold'
                    }
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
                        return '₱' + value.toLocaleString();  // Format sales value as currency
                    }
                }
            }
        };

        // Render the chart
        var chart = new ApexCharts(document.querySelector("#weekly_sales_chart"), options);
        chart.render();
    },
    error: function(xhr, status, error) {
        console.error('Error fetching weekly sales data:', error);
    }
});
