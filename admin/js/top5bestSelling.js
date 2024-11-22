$.ajax({
    url: 'backend/end-points/top5bestSelling.php',
    method: 'GET',
    success: function(data) {
       
    },
    error: function(xhr, status, error) {
       
        $('#bestSellingProducts').html('<li class="text-sm text-red-600">An error occurred while fetching data.</li>');
    }
});
