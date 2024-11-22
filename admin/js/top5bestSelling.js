
    $.ajax({
        url: 'backend/end-points/top5bestSelling.php',
        method: 'GET',            
        dataType: 'json',           
        success: function(data) {
            console.log(data);

            const productList = $('#bestSellingProducts');
            if (data.error) {
                productList.html('<li class="text-sm text-red-600">' + data.error + '</li>');
            } else {
                productList.empty(); // Clear the list before appending new data
                $.each(data, function(index, product) {
                    const listItem = $('<li>')
                        .addClass('text-sm text-gray-600')
                        .text(`${index + 1}. ${product.prod_name} - Sold: ${product.total_quantity_sold}`);
                    productList.append(listItem);
                });
            }
        },
        error: function() {
            $('#bestSellingProducts').html('<li class="text-sm text-red-600">An error occurred while fetching data.</li>');
        }
    });
