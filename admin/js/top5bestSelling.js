$.ajax({
    url: 'backend/end-points/top5bestSelling.php',
    method: 'GET',
    dataType: 'json',
    success: function(data) {
       
    },
    error: function(xhr, status, error) {
        console.error('AJAX Error:', status, error);  // Log error details
        console.log('Response Text:', xhr.responseText); // Log the raw response
        $('#bestSellingProducts').html('<li class="text-sm text-red-600">An error occurred while fetching data.</li>');
    }
});
