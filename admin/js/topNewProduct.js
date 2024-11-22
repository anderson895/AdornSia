$.ajax({
    url: 'backend/end-points/topNewProduct.php',
    method: 'GET',
    success: function(data) {
        $('#NewProduct').html(data);  // Insert the HTML response into the container
    },
    error: function(xhr, status, error) {
        $('#NewProduct').html('<p class="text-sm text-red-600">An error occurred while fetching data.</p>');
    }
});



