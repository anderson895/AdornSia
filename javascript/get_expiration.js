




const check_expirationlink = () => {

    $userId=$(this).attr('data-userId');
  
    $.ajax({
        type: "GET",
        url: "backend/end-points/check_expirationlink.php",
        data: {
          requestType: "getExpirationLink",
          userId: userId
        },
        success: function (response) {
          console.log(response);
      
          if (response == 'Expired') {
            // Disable the resend link button
            $('#resendLink').prop('disabled', false);
          } else {
            // Display the remaining time
            $('#TheRemainingTime').text(response);
            // Enable the resend link button (in case it's enabled earlier)
           
            $('#resendLink').prop('disabled', true);
          }
        },
      });
      

    
  };

  
  
  check_expirationlink();
  
  setInterval(() => {
    check_expirationlink();
  }, 1000)
  