$.ajax({
    url: 'backend/end-points/ProductStockLevel.php',
    method: 'GET',
    success: function(data) {
        $('#stock_status').html(data);  // Insert the HTML response into the container
    },
    error: function(xhr, status, error) {
        $('#stock_status').html('<p class="text-sm text-red-600">An error occurred while fetching data.</p>');
    }
});



