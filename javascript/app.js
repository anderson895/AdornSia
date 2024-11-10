$(document).ready(function () {

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
        var data = JSON.parse(response);

        if (data.status === "success") {
          sendWelcomeEmail(data.id);  
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

  function sendWelcomeEmail(userId) {
    $.ajax({
      type: "POST",
      url: "mailer.php",
      data: { user_id: userId },  
      success: function (emailResponse) {
        if (emailResponse === "OTPSentSuccessfully") {

          alertify.success('Email has been sent successfully!');

          setTimeout(function () {
            window.location.href = "verification.php"; 
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

});
