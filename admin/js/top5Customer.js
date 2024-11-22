$.ajax({
    url: 'backend/end-points/top5Customer.php',
    method: 'GET',
    success: function(data) {
        $('#top_customer').html(data);  // Insert the HTML response into the container
    },
    error: function(xhr, status, error) {
        $('#top_customer').html('<p class="text-sm text-red-600">An error occurred while fetching data.</p>');
    }
});



