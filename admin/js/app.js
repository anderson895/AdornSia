$(document).ready(function () {

  $('.togglerApproveRefund').click(function (e) { 
    e.preventDefault();
  
    $('#ref_id').val($(this).data('ref_id'));
    $('#new_status').val($(this).data('new_status'));
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
        console.log(response)
        if(response=="200"){
          alertify.success("Order Status Updated Successfully");
        }else{
          alertify.error(response);
        }
         
         
      },
      error: function (xhr, status, error) {
          console.error("Error updating order status:", error);
          console.error(xhr.responseText); 
          console.log("Failed to update the order status. Please try again.");
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

  
    
  
  });
  