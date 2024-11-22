$.ajax({
    url: 'backend/end-points/top5bestSelling.php',
    method: 'GET',
    success: function(data) {
        $('#bestSellingProducts').html(data);  // Insert the returned HTML into the container
    },
    error: function(xhr, status, error) {
        // If there's an error, display an error message
        $('#bestSellingProducts').html('<li class="text-sm text-red-600">An error occurred while fetching data.</li>');
    }
});
