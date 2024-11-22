// jQuery AJAX request to fetch weekly sales data
$.ajax({
    url: 'backend/end-points/top5bestSelling.php',  // Your PHP endpoint for weekly sales data
    type: 'GET',
    // dataType: 'json',
    success: function(data) {
        
        // Loop through the response data and prepare the arrays
        data.forEach(function(item) {
            weeklySalesData.push(item.sales);  // Add weekly sales to the data array
            weeks.push(item.week);  // Add the week labels to the categories
        });

       
    },
    error: function(xhr, status, error) {
        console.error('Error fetching weekly sales data:', error);
    }
});
