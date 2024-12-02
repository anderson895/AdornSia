$(document).ready(function() {


    $('.btnRefundItem').click(function() {

        $('#item_id_refund').val($(this).attr('data-item_id'));
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
                
                setTimeout(function() {
                    location.reload(); 
                }, 1000);  
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
      

      $('.btnAddToWishlist').click(function() {
        // Sample data, replace with actual values from your PHP/Backend
          let cart_user_id = $(this).data('user_id');
          let cart_prod_id = $(this).attr('data-product_id'); 
  
          $.ajax({
              type: "POST",
              url: "backend/end-points/controller.php",
              data: { 
                  cart_user_id: cart_user_id,
                  cart_prod_id: cart_prod_id,
                  requestType: "AddToWishlist" 
              },
              dataType: 'json', 
              success: function(response) {
                  console.log(response);
                  
                  if(response.status == "Added To Wishlist!") {
                      alertify.success('Item successfully added to the wish');
                  } else if(response.status == "Cart Updated!") {
                      alertify.success('Wishlist updated successfully!');
                  } else {
                      alertify.error(response.status);
                  }
              },
              error: function() {
                    
                  alertify.error('Error occurred during the request!');
              }
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
                console.log(response);
                
                if(response.status == "Added To Cart!") {
                    alertify.success('Item successfully added to the cart!');
                } else if(response.status == "Cart Updated!") {
                    alertify.success('Cart updated successfully!');
                } else {
                    alertify.error(response.status);
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
        
        let shouldShowLoading = true;

        window.onload = function() {
        if (shouldShowLoading) {
            // Set a 1-second delay before hiding the loading screen
            setTimeout(function() {
            document.getElementById('loadingScreen').style.opacity = '0';
            setTimeout(function() {
                document.getElementById('loadingScreen').style.display = 'none';
            }, 1000); // Hide after the opacity transition is complete
            }, 1000); // Show for 1 second
        }
        };
        
        $.ajax({
            type: "POST",
            url: "backend/end-points/controller.php",
            data: { 
                cart_user_id: cart_user_id,
                cart_prod_id: cart_prod_id,
                cart_prod_size: cart_prod_size,
                requestType: "AddToCart" 
            },
            dataType: 'json', // Corrected the syntax here
            success: function(response) {
                // Hide loading spinner and update flag
                console.log(response);
                shouldShowLoading = false;  // Prevent loading screen after reload
                location.reload();  // Reload the page
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
        
        let shouldShowLoading = true;

        window.onload = function() {
        if (shouldShowLoading) {
            // Set a 1-second delay before hiding the loading screen
            setTimeout(function() {
            document.getElementById('loadingScreen').style.opacity = '0';
            setTimeout(function() {
                document.getElementById('loadingScreen').style.display = 'none';
            }, 1000); // Hide after the opacity transition is complete
            }, 1000); // Show for 1 second
        }
        };
        
        $.ajax({
            type: "POST",
            url: "backend/end-points/controller.php",
            data: { 
                cart_user_id: cart_user_id,
                cart_prod_id: cart_prod_id,
                cart_prod_size: cart_prod_size,
                requestType: "MinusToCart" 
            },
            success: function(response) {
                // Hide loading spinner and update flag
                console.log(response);
                shouldShowLoading = false;  // Prevent loading screen after reload
                location.reload();  // Reload the page
            },
            error: function() {
                alertify.error('Error occurred during the request!');
            }
        });
    });


    

    $('.TogglerRemoveItem').click(function() {
        let cart_id = $(this).data('cart_id');
        let size = $(this).data('size');
       
        
        $.ajax({
            type: "POST",
            url: "backend/end-points/controller.php",
            data: { 
                cart_id: cart_id,
                size:size,
                requestType: "RemoveItem"
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





    $('.removeFromWish').click(function() {
        let wish_id = $(this).data('wish_id');
       
        console.log(wish_id);
        
        $.ajax({
            type: "POST",
            url: "backend/end-points/controller.php",
            data: { 
                wish_id: wish_id,
                requestType: "RemoveFromWish"
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
            setTimeout(function() {
              location.reload();
            }, 1000);  // 1000 milliseconds = 1 second
          },
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
    //    console.log(response); 
        let cartCount = response.cartCount;
        let wishlistCount = response.wishlistCount;
        
        if (cartCount && cartCount > 0) {
            $('.cartCount').text(cartCount).show(); 
            // wishlistCount
        } else {
            $('.cartCount').hide();
        }

        if (wishlistCount && wishlistCount > 0) {
            $('.wishlistCount').text(wishlistCount).show(); 
            // wishlistCount
        } else {
            $('.wishlistCount').hide();
        }
      },
    });
};


getOrdersCount();

  setInterval(() => {
    getOrdersCount();
  }, 1000)