$(document).ready(function () {

  // Listen for the checkbox change event
  $(".checkStatus").on("change", function () {
    const checkbox = $(this);
    const address_name = checkbox.attr("data-address_name");
    const acc_id = $('#acc_id').val();
    const address_id = checkbox.attr("data-address_id");
    const isChecked = checkbox.is(":checked");

    const message = isChecked
      ? "Are you sure you want to enable " + address_name
      : "Are you sure you want to disable " + address_name;

    // Show the initial SweetAlert with "Yes" and "Cancel" options
    Swal.fire({
      title: "Are you sure?",
      text: message,
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes",
      cancelButtonText: "Cancel",
      confirmButtonClass: "btn btn-primary",
      cancelButtonClass: "btn btn-danger ml-1",
      buttonsStyling: false,
    }).then(function (result) {
      if (result.value) {
        // If the user clicks "Yes," proceed with the AJAX request
        $.ajax({
          url: 'delivery_place/controller/updateStatusProcess.php',
          type: 'POST',
          data: {
            acc_id: acc_id,
            address_id: address_id,
            address_status: isChecked ? 1 : 0
          },
          success: function (response) {
            // Handle the success response
            console.log(response);
            Swal.fire({
              type: "success",
              title: "Action Successful",
              text: "Unit has been " + (isChecked ? "enabled" : "disabled") + ".",
              confirmButtonClass: "btn btn-success"
            });

            alertify.success("Saved successful")
          },
          error: function (xhr, status, error) {
            // Handle the error response
            Swal.fire({
              type: "error",
              title: "Error",
              text: "An error occurred while enabling/disabling.",
              confirmButtonClass: "btn btn-danger"
            });
          }
        });
      } else {
        // If the user clicks "Cancel," handle any necessary actions (e.g., toggle the checkbox state)
        checkbox.prop('checked', !isChecked);
      }
    });
  });
});
