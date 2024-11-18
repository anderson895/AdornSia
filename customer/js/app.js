$(document).ready(function() {


    $('.btnRefundItem').click(function() {
        $('#prod_id_refund').val($(this).attr('data-product_id'));
        $('#user_id_refund').val($(this).attr('data-user_id'));


        $('#RefundItemModal').fadeIn();
    });

    $('.closeModalBtn').click(function() {
        $('#RefundItemModal').fadeOut();
    });
  
    

    $(document).ready(function() {
        $("#frmRefund").on("submit", function(e) {
          e.preventDefault(); 
      
          var formData = $(this).serialize(); 
      
          // Send data via AJAX
          $.ajax({
            url: 'backend/end-points/controller.php',
            type: "POST",
            data: formData,
            success: function(response) {
                console.log(response);
                $("#RefundItemModal").hide();
                alertify.success("Refund request submitted successfully.");
                
                // Add a 2-second delay before reloading the page
                setTimeout(function() {
                    location.reload();  // Reload the page after 2 seconds
                }, 1000);  // Delay in milliseconds (2000ms = 2 seconds)
            },
            error: function(xhr, status, error) {
                console.error("Error:", status, error);
                alert("An error occurred while submitting the request.");
            }
        });
        

        });


        $(".closeModalBtn").on("click", function() {
          $("#RefundItemModal").hide();
        });
      });
      

   
      
      


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
                requestType: "AddToCart" 
            },
            dataType: 'json', 
            success: function(response) {
                
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
               location.reload();
            },
            error: function() {
                alertify.error('Error occurred during the request!');
            }
        });
    });





    




    $('#userProfileFrm').on('submit', function(e) {
        e.preventDefault(); 
        var formData = new FormData(this);
        $.ajax({
          url: 'backend/end-points/controller.php', 
          type: 'POST',
          data: formData,
          contentType: false,  
          processData: false,  
          success: function(response) {
            console.log(response);
            alertify.success('Profile updated successfully!');
          },
          error: function(xhr, status, error) {
            // Handle errors (e.g., show error message)
            alert('An error occurred: ' + error);
          }
        });
      });


      $('#userPasswordFrm').on('submit', function(e) {
        e.preventDefault(); 

        var newpassword =$('#newpassword').val()
        var confirmpassword =$('#confirmpassword').val()

        if(confirmpassword!=newpassword){
            alertify.error('Confirm Password Not Match');
            return;
        }

        var formData = new FormData(this);
        $.ajax({
            url: 'backend/end-points/controller.php', 
            type: 'POST',
            data: formData,
            dataType: 'json', // Corrected to dataType
            processData: false, // Prevent jQuery from processing FormData
            contentType: false, // Allow FormData to set its own content type
            success: function(response) {
                console.log(response);
                if (response.success) {
                    alertify.success(response.message); // Show success message
                } else {
                    alertify.error(response.message); // Show error message
                }
            },
            error: function(xhr, status, error) {
                console.log('AJAX error:', error); // Log the error for debugging
                console.log('XHR:', xhr); // Log the xhr object for more details
                alert('An error occurred: ' + error); // Show alert with error message
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