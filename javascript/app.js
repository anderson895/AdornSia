$(document).ready(function () {

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
            window.location.href = "customer/index.php"; 
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



  $("#FrmRegister").submit(function (e) {
    e.preventDefault();

    $('#spinner').show();
    $('#btnRegister').prop('disabled', true);
    
    var formData = $(this).serializeArray(); 
    formData.push({ name: 'requestType', value: 'Signup' });
    var serializedData = $.param(formData);

    // Perform the AJAX request
    $.ajax({
      type: "POST",
      url: "backend/end-points/signup.php",
      data: serializedData,  
      success: function (response) {

    console.log(response);
        var data = JSON.parse(response);

        if (data.status === "success") {
          sendWelcomeEmail(data.id,data.verificationKey);  
        } else if(data.status==="EmailAlreadyExists"){
          alertify.error(data.message);

          $('#spinner').hide();
          $('#btnRegister').prop('disabled', false);

        }else {
          $('#spinner').hide();
          $('#btnRegister').prop('disabled', false);
          console.error(response); 
          alertify.error('Registration failed, please try again.');
        }
      },
      error: function () {
        $('#spinner').hide();
        $('#btnRegister').prop('disabled', false);
        alertify.error('An error occurred. Please try again.');
      }
    });
  });

  function sendWelcomeEmail(userId,verificationKey) {
    $.ajax({
      type: "POST",
      url: "mailer.php",
      data: { 
        user_id: userId,
        verificationKey:verificationKey
       },  
      success: function (emailResponse) {

        console.log(emailResponse)
        if (emailResponse === "OTPSentSuccessfully") {

          alertify.success('Email has been sent successfully!');

          setTimeout(function () {
            window.location.href = "verification.php?userId="+userId; 
          }, 1000);
        } else {
          alertify.error('Failed to send the welcome email.');
        }
        $('#spinner').hide();
        $('#btnRegister').prop('disabled', false);
      },
      error: function () {
        $('#spinner').hide();
        $('#btnRegister').prop('disabled', false);
        alertify.error('An error occurred while sending the email.');
      }
    });
  }





























  $('#resendLink').click(function() {
    var userId = $(this).attr('data-userId');
    
    // Show loading spinner
    $('#loadingSpinner').removeClass('hidden');

    // Disable the resend button during loading
    $('#resendLink').prop('disabled', true);

    $.ajax({
        type: "POST",
        url: "mailer.php",
        data: { user_id: userId },  
        success: function(response) {
            // Hide loading spinner

            console.log(response);

            $('#loadingSpinner').addClass('hidden');
            
            // Enable the resend button after request completes
            $('#resendLink').prop('disabled', false);

            if (response == 'OTPSentSuccessfully') {
                alertify.success('Verification link sent successfully!');
            } else {
                alertify.error('Error resending verification link.');
            }
        },
        error: function() {
            // Hide loading spinner
            $('#loadingSpinner').addClass('hidden');
            
            // Enable the resend button after error
            $('#resendLink').prop('disabled', false);

            alertify.error('Something went wrong. Please try again.');
        }
    });
});
































  
$("#frmForgotPassword").submit(function (e) {
  e.preventDefault();

  $('#spinner').show();
  $('#btnForgotPassword').prop('disabled', true);
  
  var formData = $(this).serializeArray(); 
  formData.push({ name: 'requestType', value: 'ForgotPassword' });
  var serializedData = $.param(formData);

  // Perform the AJAX request
  $.ajax({
    type: "POST",
    url: "backend/end-points/forgot.php",
    data: serializedData,  
    success: function (response) {

  console.log(response);
      var data = JSON.parse(response);

      if (data.status === "EmailNotExists") {

        alertify.error(data.message);

        $('#spinner').hide();
        $('#btnForgotPassword').prop('disabled', false);  
        
      } else if(data.status==="EmailExist"){

        console.log(data);
        // sendforgotEmail(data.id,data.id);  



      }else {
        $('#spinner').hide();
        $('#btnForgotPassword').prop('disabled', false);
        console.error(response); 
        alertify.error('Registration failed, please try again.');
      }
    },
    error: function () {
      $('#spinner').hide();
      $('#btnForgotPassword').prop('disabled', false);
      alertify.error('An error occurred. Please try again.');
    }
  });
});




function sendforgotEmail(userId) {
  $.ajax({
    type: "POST",
    url: "ForgotPasswordMailer.php",
    data: { 
      user_id: userId
     },  
    success: function (emailResponse) {

      console.log(emailResponse)
      if (emailResponse === "OTPSentSuccessfully") {

        alertify.success('Your New Password has been sent on your Email successfully!');

        setTimeout(function () {
          window.location.href = "login.php"; 
        }, 2000);
      } else {
        alertify.error('Failed to send the welcome email.');
      }
      $('#spinner').hide();
      $('#btnRegister').prop('disabled', false);
    },
    error: function () {
      $('#spinner').hide();
      $('#btnRegister').prop('disabled', false);
      alertify.error('An error occurred while sending the email.');
    }
  });
}






});








