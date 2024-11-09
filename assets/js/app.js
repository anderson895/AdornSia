$(document).ready(function () {





$("#tsFrmRate").submit(function (e) {
  e.preventDefault();
  var id = $("#ts-frm-Id").val();
  var star = $("#tsfrmStar").val();
  var review = $("#tsFrmModalReview").val();
  var tsReviewName = $(".tsReviewName").text();

  // Show the loading spinner and hide the form content
  $('#loadingSpinner').show();
  $('#formContent').hide();

  $.ajax({
    type: "POST",
    url: "backend/end-points/rate.php",
    data: {
      requestType: "Rate",
      id: id,
      star: star,
      review: review,
      tsReviewName: tsReviewName,
    },
    success: function (response) {
      // Hide the loading spinner and show the form content
      $('#loadingSpinner').hide();
      $('#formContent').show();

      if (response == "200") {
        alertify.success('Thanks for rating!');
        setTimeout(() => {
          window.location.reload();
        }, 1000);
      } else {
        alertify.error('Failed to rate');
      }
    },
    error: function () {
      // Hide the loading spinner and show the form content on error
      $('#loadingSpinner').hide();
      $('#formContent').show();
      alertify.error('An error occurred. Please try again.');
    }
  });
});




});








