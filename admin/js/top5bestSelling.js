$.ajax({
    url: 'backend/end-points/top5bestSelling.php',
    method: 'GET',
    success: function(data) {
        $('#bestSellingProducts').html(data);  // Insert the HTML response into the container
    },
    error: function(xhr, status, error) {
        $('#bestSellingProducts').html('<p class="text-sm text-red-600">An error occurred while fetching data.</p>');
    }
});