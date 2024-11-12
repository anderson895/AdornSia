$(document).ready(function() {
  // Open modal
  $('#setAddressModal').click(function() {
      $('#addressModal').fadeIn();
  });





 // Save address with AJAX
$('#addressSelect').change(function(event) { 
  event.preventDefault(); 


  var address_id = $(this).find('option:selected').data('address_id'); 

  // console.log(address_id); 

  $.ajax({
      url: 'backend/end-points/controller.php',
      type: 'POST',
      data: {
        address_id: address_id, 
        requestType: 'UpdateAddress'
      },
      dataType: 'json',
      success: function(response) {
          console.log(response);
          if (response.status == '200') {
              alertify.success('Update Delivery Address Successfully!');

              setTimeout(function() {
                location.reload();
              }, 1500);
          } else {
              // Handle error case in response
              alertify.error('Error: ' + response.message);
          }
      },
      error: function(jqXHR, textStatus, errorThrown) {
          // Handle AJAX request error (network issues, etc.)
          console.error('Error details: ', textStatus, errorThrown);
          alertify.error('There was an error with the request. Please try again later.');
      },
      statusCode: {
          404: function() {
              // Handle 404 (Not Found) error
              alertify.error('Requested page not found.');
          },
          500: function() {
              // Handle 500 (Internal Server Error) error
              alertify.error('Internal Server Error. Please try again later.');
          }
      },
  });
});




  // Save address with AJAX
  $('#btnSaveAddress').click(function(event) {
      event.preventDefault(); // Prevent the default form submission

      // Show loading spinner and disable button
      $('.loadingSpinner').show();  // Use .loadingSpinner if it’s a class
      $('#btnSaveAddress').prop('disabled', true);


      var StreetName=$('#StreetName').val();
      // Get the form data
      var complete_address_add = $('#complete_address_add').val();
      var streetName = $('#StreetName').val();
      var barangay = $('#complete_Address_code').val();

      $.ajax({
          url: 'backend/end-points/controller.php',
          type: 'POST',
          data: {
              barangay: barangay,
              street_name: streetName,
              complete_address_add: complete_address_add+' '+StreetName,
              requestType: 'SaveAddress'
          },
          dataType: 'json',
          success: function(response) {
              if (response.status == '200') {
                  alertify.success('Address saved successfully!');
                  $('#addressModal').fadeOut();
                  setTimeout(function() {
                      location.reload();
                  }, 1500); // Delay of 1.5 seconds
              }else if(response.status == '409'){
                alertify.error('Address Already Existi!');
                setTimeout(function() {
                    location.reload();
                }, 1500);
              }else if(response.status == '201'){
                alertify.error('Server Error!');
                setTimeout(function() {
                    location.reload();
                }, 1500);
              }
          },
          error: function() {
              alertify.error('Failed to save address.');
          },
          complete: function() {
              // Hide loading spinner and enable button after AJAX call completes
              $('.loadingSpinner').hide();
              $('#btnSaveAddress').prop('disabled', false);
          }
      });
  });

  // Close modal
  $('.closeModal').click(function() {
      $('#addressModal').fadeOut();
  });
});
