$(document).ready(function () {

  $('.togglerDeleteUserAdmin').click(function (e) { 
    var admin_id =$(this).data('admin_id');
    
    $('#remove_admin_id').val(admin_id);
    e.preventDefault();
    $('#deleteUserModal').fadeIn();
  });  

  $('.togglerremoveUserClose').click(function (e) { 
    e.preventDefault();
    $('#deleteUserModal').fadeOut();
  });  


  $("#deleteuserForm").submit(function (e) {
    e.preventDefault();
    
    var formData = $(this).serializeArray();
    formData.push({ name: 'requestType', value: 'DeleteUser' });
    var serializedData = $.param(formData);
  
    $.ajax({
      type: "POST",
      url: "backend/end-points/controller.php",
      data: serializedData,
      success: function (response) {
        if (response == "200") {
          alertify.success('Delete Account Successful');
          $('#deleteUserModal').fadeOut();
          setTimeout(function () {
            location.reload(); 
          }, 1000); 
        } else {
          console.log(response);
          alertify.error('Delete Failed. Please check the details.');
        }
      },
    });
    
  });


  
  $('.togglerUpdateUserAdmin').click(function (e) { 
    var admin_id =$(this).data('admin_id');
    var admin_username =$(this).data('admin_username');
    var admin_fullname =$(this).data('admin_fullname');
    console.log(admin_id);

    $('#update_admin_id').val(admin_id)
    $('#update_admin_fullname').val(admin_fullname)
    $('#update_admin_username').val(admin_username)
    
    e.preventDefault();
    $('#updateUserModal').fadeIn();
  });  

  $('.togglerUpdateUserClose').click(function (e) { 
    e.preventDefault();
    $('#updateUserModal').fadeOut();
  });  



  
  $('#adduserButton').click(function (e) { 
    e.preventDefault();
    $('#addUserModal').fadeIn();
  });  


  $('.addUserModalClose').click(function (e) { 
    e.preventDefault();
    $('#addUserModal').fadeOut();
  });  


  $('.togglerActionRefund').click(function (e) { 
    e.preventDefault();

    $('#ref_id').val($(this).data('ref_id'));
    $('#new_status').val($(this).data('new_status'));

    $('#ordercodeText').text($(this).data('ordercode'))
    ('#returnActionText').text($(this).data('new_status'))


    $('#RefundModal').fadeIn();
  });  
  
  $('.closeModal').click(function (e) { 
    e.preventDefault();
    $('#RefundModal').fadeOut();
  });  
  
  $("#frmRefund").submit(function (e) {
    e.preventDefault();
    
    var formData = $(this).serializeArray();
    formData.push({ name: 'requestType', value: 'RefundProduct' });
    var serializedData = $.param(formData);
  
    $.ajax({
      type: "POST",
      url: "backend/end-points/controller.php",
      data: serializedData,
      success: function (response) {
        if (response == "200") {
          alertify.success('Refund Successful');
          $('#RefundModal').fadeOut();
          setTimeout(function () {
            location.reload(); 
          }, 1000); 
        } else {
          console.log(response);
          alertify.error('Refund Failed. Please check the details.');
        }
      },
    });
    
  });
  




  






// 

$("#updateuserForm").submit(function (e) {
  e.preventDefault();
  
  var formData = $(this).serializeArray();
  formData.push({ name: 'requestType', value: 'Updateuser' });
  var serializedData = $.param(formData);

  $.ajax({
    type: "POST",
    url: "backend/end-points/controller.php",
    data: serializedData,
    success: function (response) {
      if (response == "200") {
        alertify.success('Update Successful');
        $('#addUserModal').fadeOut();
        setTimeout(function () {
          location.reload(); 
        }, 1000); 
      } else {
        console.log(response);
        alertify.error('Update Failed. Please check the details.');
      }
    },
  });
  
});



  $("#adduserForm").submit(function (e) {
    e.preventDefault();
    
    var formData = $(this).serializeArray();
    formData.push({ name: 'requestType', value: 'Adduser' });
    var serializedData = $.param(formData);
  
    $.ajax({
      type: "POST",
      url: "backend/end-points/controller.php",
      data: serializedData,
      success: function (response) {
        if (response == "200") {
          alertify.success('Added Successful');
          $('#addUserModal').fadeOut();
          setTimeout(function () {
            location.reload(); 
          }, 1000); 
        } else {
          console.log(response);
          alertify.error('Added Failed. Please check the details.');
        }
      },
    });
    
  });
  











$(document).on("change", ".UpdateOrderStatus", function () {
  const $select = $(this); 
  const orderId = $select.data("orderid");
  const initialStatus = $select.data("initial-status"); 
  const newStatus = $select.val(); 


  if(newStatus==""){
    console.log("select new status"); 
    return;
  }
  if (newStatus === initialStatus) {
      console.log("No changes made to the order status."); 
      return; 
  }

  $select.prop("disabled", true);

  $.ajax({
      url: "backend/end-points/controller.php",
      method: "POST",
      data: {
          orderId: orderId,
          orderStatus: newStatus,
          requestType: 'UpdateOrderStatus'
      },
      success: function (response) {
        console.log(response);
        if (response == "200") {
            alertify.success("Order Status Updated Successfully");
    
            // Delay the reload by 1 second (1000 milliseconds)
            setTimeout(function() {
                location.reload();
            }, 1000);
        } else {
            alertify.error(response);
        }
    },
      complete: function () {
          $select.prop("disabled", false);
      }
  });
});






    $("#frmLogin").submit(function (e) {
      e.preventDefault();
  
      $('#spinner').show();
      $('#btnLogin').prop('disabled', true);
      
      var formData = $(this).serializeArray(); 
      formData.push({ name: 'requestType', value: 'Login' });
      var serializedData = $.param(formData);
  
      // Perform the AJAX request
      $.ajax({
        type: "POST",
        url: "backend/end-points/login.php",
        data: serializedData,
        dataType: 'json',
        success: function (response) {

          console.log(response.status)

          if (response.status === "success") {
            alertify.success('Login Successful');

            setTimeout(function () {
              window.location.href = "dashboard.php"; 
            }, 1000);

          } else {
            $('#spinner').hide();
            $('#btnLogin').prop('disabled', false);
            console.log(response); 
            alertify.error(response.message);
          }
        },
        error: function () {
          $('#spinner').hide();
          $('#btnLogin').prop('disabled', false);
          alertify.error('An error occurred. Please try again.');
        }
      });
    });



    $(document).ready(function() {
      $('#frmAddProduct').on('submit', function(e) {
          e.preventDefault();
          var category = $('#productCategory').val();
          if (category === null) {
              alert("Please select a category.");
              return; 
          }
           var productImage = $('#productImage').val();
           if (productImage === "") {
               alert("Please upload an image.");
               return; 
           }
           
          $('.spinner').show();
          $('#frmAddProduct').prop('disabled', true);
  
          // Create a new FormData object
          var formData = new FormData(this);
          formData.append('requestType', 'AddProduct'); 
  
          // Perform the AJAX request
          $.ajax({
              type: "POST",
              url: "backend/end-points/controller.php",
              data: formData,
              contentType: false,
              processData: false, 
              success: function(response) {
                console.log(response)
                  if(response==200){
                    $('#AddproductModal').hide();
                    $('.spinner').hide();
                    $('#frmAddProduct').prop('disabled', false);
                    location.reload();
                  }
              },
              error: function(xhr, status, error) {
                  alert('Error: ' + error);
              }
          });
      });
  });






  $(document).ready(function() {
    $('#frmUpdateProduct').on('submit', function(e) {
        e.preventDefault();
        var category = $('#product_Category_update').val();
        if (category === null) {
            alert("Please select a category.");
            return; 
        }
         
         
        $('.spinner').show();
        $('#frmUpdateProduct').prop('disabled', true);

        // Create a new FormData object
        var formData = new FormData(this);
        formData.append('requestType', 'UpdateProduct'); 

        // Perform the AJAX request
        $.ajax({
            type: "POST",
            url: "backend/end-points/controller.php",
            data: formData,
            contentType: false,
            processData: false, 
            success: function(response) {
              console.log(response)
                if(response==200){
                  $('#UpdateProductModal').hide();
                  $('.spinner').hide();
                  $('#frmUpdateProduct').prop('disabled', false);

                  location.reload();
                }
            },
            error: function(xhr, status, error) {
                alert('Error: ' + error);
            }
        });
    });
  });
  


    $('#frmUpdateStock').on('submit', function(e) {
        e.preventDefault();
        var stockin_qty = $('#stockin_qty').val();
        if (stockin_qty === null) {
            alert("Please Enter Quantity.");
            return; 
        }
         
         
        $('.spinner').show();
        $('#frmUpdateStock').prop('disabled', true);

        // Create a new FormData object
        var formData = new FormData(this);
        formData.append('requestType', 'StockIn'); 

        // Perform the AJAX request
        $.ajax({
            type: "POST",
            url: "backend/end-points/controller.php",
            data: formData,
            contentType: false,
            processData: false, 
            success: function(response) {
              console.log(response)
                if(response==200){
                  $('#StockInModal').hide();
                  $('.spinner').hide();
                  $('#frmUpdateStock').prop('disabled', false);

                  location.reload();
                }
            },
            error: function(xhr, status, error) {
                alert('Error: ' + error);
            }
        });
    });




  // Show the modal when Add Product button is clicked
$('#addProductButton').click(function() {
  $('#AddproductModal').fadeIn(200);  // Use fadeIn for smoother appearance
});
  // Show the modal when Add Product button is clicked
$('#addProductButton').click(function() {
  $('#AddproductModal').fadeIn(200);  // Use fadeIn for smoother appearance
});

// Hide the modal when Cancel button is clicked
$('#closeModalButton').click(function() {
  $('#AddproductModal').fadeOut(200);  // Use fadeOut for smoother disappearance
});






$(document).ready(function(){
  // Open modal on button click

  $('.stockInToggler').click(function(){
    $('#product_id_stockin').val($(this).attr('data-prod_id'))
    $('#product_name_stockin').val($(this).data('prod_name'))
    
    $('#product_stocks').text($(this).attr('data-product_stocks'))
    $('#stockinTarget').text($(this).attr('data-prod_name'))
    $('#StockInModal').fadeIn()
  });

  $('#StockInModalClose').click(function(){
    $('#StockInModal').fadeOut()
  });
  

  $('.updateProductToggler').click(function(){

   
    
    $('#product_id_update').val($(this).attr('data-prod_id'))
    $('#product_Code_update').val($(this).attr('data-prod_code'))
    $('#product_Name_update').val($(this).attr('data-prod_name'))
    $('#product_Price_update').val($(this).attr('data-prod_currprice'))
    $('#critical_Level_update').val($(this).attr('data-prod_critical'))
    $('#product_Category_update').val($(this).attr('data-prod_category_id'))
    $('#product_Description_update').val($(this).attr('data-prod_description'))
    $('#product_Promo_update').val($(this).attr('data-prod_promo_id'))
    $('#product_Stocks_update').val($(this).attr('data-product_stocks'))

      $('#UpdateProductModal').fadeIn();
  });
  
  // Close modal on button click
  $('.closeModal').click(function(){
      $('#UpdateProductModal').fadeOut();
  });
  
  // Optional: Close modal if clicking outside of the modal content
  $('#UpdateProductModal').click(function(event){
      if($(event.target).is('#UpdateProductModal')) {
          $('#UpdateProductModal').fadeOut();
      }
  });
});


// Hide the modal when clicking outside the modal
$(document).click(function(event) {
  if ($(event.target).closest('#AddproductModal, #addProductButton').length === 0) {
      $('#AddproductModal').fadeOut(200);  // Use fadeOut for smoother disappearance
  }
});

  
    






$('#addPromoBtn').click(function(){
  $('#addPromoModal').fadeIn()
});









    // Open modal when "Update" button is clicked
    $(".togglerUpdatePromo").on("click", function() {
      var promo_id = $(this).data("promo_id"); 
      var promo_name = $(this).data("promo_name"); 
      var promo_description = $(this).data("promo_description"); 
      var promo_rate = $(this).data("promo_rate"); 
      var promo_rate = $(this).data("promo_rate"); 
      var promo_expiration = $(this).data("promo_expiration"); 
      

      // Pre-fill the modal with promo data
      $("#promo_id").val(promo_id);
      $("#promo_name").val(promo_name);
      $("#promo_description").val(promo_description);
      $("#promo_rate").val(promo_rate);
      $("#promo_expiration").val(promo_expiration);

      // Show the modal
      $("#promoModal").fadeIn();
    });

    // Close modal when "Close" button is clicked
    $(".closeModal").on("click", function() {
      $("#promoModal").fadeOut();
    });

    // Handle form submission (Save Promo)
    $("#promoUpdateForm").on("submit", function(e) {
      e.preventDefault(); 
  
        var formData = new FormData(this); 
    
        formData.append("requestType", 'updatePromo');  
    
        // Send the form data via AJAX
        $.ajax({
          url: "backend/end-points/controller.php", 
          method: 'POST',
          data: formData,
          processData: false, 
          contentType: false,
          success: function(response) {
              alertify.success("Promo updated successfully!");
              $("#promoModal").fadeOut();
      
              // Add delay before reload
              setTimeout(function() {
                  location.reload();
              }, 1000); // Delay in milliseconds (2000 ms = 2 seconds)
          },
          error: function(error) {
              alert("Error updating promo.");
          }
      });
      
    });
  






 // Handle form submission (Save Promo)
 $("#addPromoForm").on("submit", function(e) {
  e.preventDefault(); 

    var formData = new FormData(this); 

    formData.append("requestType", 'addPromo');  

    // Send the form data via AJAX
    $.ajax({
        url: "backend/end-points/controller.php", 
        method: 'POST',
        data: formData,
        processData: false, 
        contentType: false,
        success: function(response) {
            alertify.success("Promo Added successfully!");
            $("#addPromoModal").fadeOut();
            location.reload();
        },
        error: function(error) {
            alert("Error updating promo.");
        }
    });
});








$(".removeProduct").on("click", function() {
  var prod_id = $(this).data("prod_id"); 
 console.log(prod_id);
 // Confirm before deleting
 if (confirm("Are you sure you want to delete this product?")) {
     // Send AJAX request
     $.ajax({
         url: "backend/end-points/controller.php", 
         type: "POST",
         data: { prod_id: prod_id, requestType:'removeProduct'},
         success: function(response) {
                 console.log(response);
                 if (response == "200") {
                     alertify.success("Product deleted successfully!");
                     location.reload(); // Reload the page to reflect changes
                 } else {
                   console.log(response);
                 }
           
         },
         error: function(xhr, status, error) {
             alert("AJAX error: " + error);
         }
     });
 }
});


    $(".togglerRemovePromo").on("click", function() {
       var promo_id = $(this).data("promo_id"); 
      
      // Confirm before deleting
      if (confirm("Are you sure you want to delete this promo?")) {
          // Send AJAX request
          $.ajax({
              url: "backend/end-points/controller.php", 
              type: "POST",
              data: { promo_id: promo_id, requestType:'RemovePromo'},
              success: function(response) {
                      console.log(response);
                      if (response == "200") {
                          alertify.success("Promo deleted successfully!");
                          location.reload(); // Reload the page to reflect changes
                      } else {
                        console.log(response);
                      }
                
              },
              error: function(xhr, status, error) {
                  alert("AJAX error: " + error);
              }
          });
      }
  });
  
  });
  