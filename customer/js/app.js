$(document).ready(function() {



   
      
      


    $('.btnAddToCart').click(function() {
      // Sample data, replace with actual values from your PHP/Backend
        let cart_user_id = $(this).data('user_id');
        let cart_prod_id = $(this).attr('data-product_id'); 
        let cart_prod_size = $('.size-btn.bg-blue-600').data('size') || "N/A"; // Size from selected button

        var size = $('.size-btn').text(); // Check if size button has text

        if (size && cart_prod_size == "N/A") { 
            alertify.error('Select Size is Required!');
            return;
        }

        
        
        $.ajax({
            type: "POST",
            url: "backend/end-points/controller.php",
            data: { 
                cart_user_id: cart_user_id,
                cart_prod_id: cart_prod_id,
                cart_prod_size: cart_prod_size,
                requestType: "AddToCart" // Corrected here
            },
            dataType: 'json', // Corrected the syntax here
            success: function(response) {
                // Hide loading spinner
                console.log(response);
                
                if(response.status == "Added To Cart!") {
                    alertify.success('Item successfully added to the cart!');
                } else if(response.status == "Cart Updated!") {
                    alertify.success('Cart updated successfully!');
                } else {
                    alertify.error('Something went wrong, please try again.');
                }
            },
            error: function() {
                alertify.error('Error occurred during the request!');
            }
        });
    });


    $('.togglerAdd').click(function() {
        // Sample data, replace with actual values from your PHP/Backend
        let cart_user_id = $(this).data('user_id');
        let cart_prod_id = $(this).data('product_id'); 
        let cart_prod_size = $(this).data('cart_prod_size'); 
        
        console.log(cart_prod_size);
        
        $.ajax({
            type: "POST",
            url: "backend/end-points/controller.php",
            data: { 
                cart_user_id: cart_user_id,
                cart_prod_id: cart_prod_id,
                cart_prod_size: cart_prod_size,
                requestType: "AddToCart" // Corrected here
            },
            dataType: 'json', // Corrected the syntax here
            success: function(response) {
                // Hide loading spinner
                console.log(response);
                
                location.reload();
            },
            error: function() {
                alertify.error('Error occurred during the request!');
            }
        });
    });



    $('.togglerMinus').click(function() {
        // Sample data, replace with actual values from your PHP/Backend
        let cart_user_id = $(this).data('user_id');
        let cart_prod_id = $(this).data('product_id'); 
        let cart_prod_size = $(this).data('cart_prod_size'); 
        
        console.log(cart_prod_size);
        
        $.ajax({
            type: "POST",
            url: "backend/end-points/controller.php",
            data: { 
                cart_user_id: cart_user_id,
                cart_prod_id: cart_prod_id,
                cart_prod_size: cart_prod_size,
                requestType: "MinusToCart" // Corrected here
            },
            // dataType: 'json', // Corrected the syntax here
            success: function(response) {
                // Hide loading spinner
                console.log(response)
                location.reload();
            },
            error: function() {
                alertify.error('Error occurred during the request!');
            }
        });
    });

    $('.TogglerRemoveItem').click(function() {
        // Sample data, replace with actual values from your PHP/Backend
        let cart_id = $(this).data('cart_id');
        let size = $(this).data('size');
       
        
        $.ajax({
            type: "POST",
            url: "backend/end-points/controller.php",
            data: { 
                cart_id: cart_id,
                size:size,
                requestType: "RemoveItem" // Corrected here
            },
            // dataType: 'json', // Corrected the syntax here
            success: function(response) {
                // Hide loading spinner
                console.log(response)
              //  location.reload();
            },
            error: function() {
                alertify.error('Error occurred during the request!');
            }
        });
    });

    

});


// cartCount


const getOrdersCount = () => {
    $.ajax({
      url: 'backend/end-points/get_count_status.php', 
      type: 'GET',
      dataType: 'json',
      success: function(response) {
       // console.log(response); 
        let cartCount = response.cartCount;

        if (cartCount && cartCount > 0) {
            $('.cartCount').text(cartCount).show(); 
        } else {
            $('.cartCount').hide();
        }
      },
      error: function(xhr, status, error) {
          console.error("Error fetching order status counts:", error);
      }
    });
};



getOrdersCount();

  setInterval(() => {
    getOrdersCount();
  }, 1000)