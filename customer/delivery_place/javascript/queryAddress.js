$(document).ready(function () {
    var acc_id = $("#acc_id").val();


    // Check if DataTable is already initialized
var dataTable = $('.datanew').DataTable();
if (!$.fn.dataTable.isDataTable('.datanew')) {
  // DataTable is not initialized, proceed with initialization
  dataTable = $('.datanew').DataTable({
    // Add DataTable initialization options here, if needed
    "paging": true,   // Enable pagination
    "ordering": true, // Enable sorting
    // Add other DataTable initialization options here
  });
}

// Loop through addressData and generate rows


$.each(addressData, function (index, item) {
    var address_name = item.address_complete_name;
    var shipping = item.address_rate;


    var riderName=item.acc_fname+" "+item.acc_lname;

    var riderId=item.acc_id;



    var address_code = item.address_code;
    var status = item.address_status;
    var address_id = item.address_id;
    var address_cod = item.address_cod;
    var address_paynow = item.address_paynow;

    var isChecked = status === "1" ? 'checked' : '';
    var labelText = isChecked ? 'checked' : '';
    var togler_status_ship = status === "1" ? 'enable' : 'disable';

    // Create the row HTML
    var statusToggle =
        '<div class="status-toggle d-flex justify-content-between align-items-center">' +
        '<input ' +
        isChecked +
        ' type="checkbox" class="row-checkbox checkStatus check ' +
        togler_status_ship +
        '" data-address_id="' +
        address_id +
        '" data-address_name="' +
        address_name +
        '"  id="user' + index + '">' +
        '<label for="user' + index + '" class="checktoggle">' + labelText + '</label>' +
        '</div>';

     



  var togler_cod = address_cod === "1" ? 'AllowedCod' : 'NotAllowedCod';
  var labelTextCod = address_cod === "1" ? 'Allowed' : 'Not Allowed';
  var colorCod =
    address_cod === "1" ? 'class="badges bg-lightgreen"' : 'class="badges bg-lightred"';
  var statusToggleCod = '<span ' + colorCod + ' >' + labelTextCod + '</span>';

  var togler_paynow = address_paynow === "1" ? 'AllowedPayFirst' : 'NotAllowedPayFirst';
  var labelTextPayNow = address_paynow === "1" ? 'Allowed' : 'Not Allowed';
  var colorPnow =
    address_paynow === "1" ? 'class="badges bg-lightgreen"' : 'class="badges bg-lightred"';
  var statusTogglePaynow = '<span ' + colorPnow + ' >' + labelTextPayNow + '</span>';

//   var newRow =
//     '<tr>' +
//     '<td><label hidden class="checkboxs"><input type="checkbox" class="row-checkbox"><span class="checkmarks"></span></label></td>' +
//     '<td>' + address_code + '</td>' +
//     '<td>' + address_name + '</td>' +
//     '<td>' + shipping + '</td>' +
//     '<td>' + statusToggle + '</td>' +
//     '<td><a class="' + togler_cod + '" data-address_id="' + address_id + '" data-address_cod="' + togler_cod + '">' + statusToggleCod + '</a></td>' +
//     '<td><a class="' + togler_paynow + '" data-address_id="' + address_id + '" data-address_cod="' + togler_paynow + '">' + statusTogglePaynow + '</a></td>' +
//     '<td>' +
//     '<center>' +
//     '<a class="me-3 editShipping" data-bs-toggle="modal" data-address_name="' + address_name + '" data-address_id="' + address_id + '" data-shipping="' + shipping + '"  data-bs-target="#editShipping"><img src="assets/img/icons/edit.svg" alt="img"></a>' +
//     '<a class="me-3 removeShipping" data-address_name="' + address_name + '" data-address_id="' + address_id + '"  ><img src="assets/img/icons/delete.svg" alt="img"></a>' +
//     '</center>' +
//     '</td>' +
//     '</tr>';

var newRow =
    '<tr>' +
    '<td><label hidden class="checkboxs"><input type="checkbox" class="row-checkbox"><span class="checkmarks"></span></label></td>' +
    '<td>' + address_code + '</td>' +
    '<td>' + address_name + '</td>' +
    '<td>' + shipping + '</td>' +
    '<td>' + riderName + '</td>' +
    '<td>' + statusToggle + '</td>' +
    '<td>' +
    '<center>' +
    '<a class="me-3 editShipping" data-bs-toggle="modal" data-rider_id="'+riderId+'" data-address_name="' + address_name + '" data-address_id="' + address_id + '" data-shipping="' + shipping + '"  data-bs-target="#editShipping"><img src="assets/img/icons/edit.svg" alt="img"></a>' +
    '<a class="me-3 removeShipping" data-address_name="' + address_name + '" data-address_id="' + address_id + '"  ><img src="assets/img/icons/delete.svg" alt="img"></a>' +
    '</center>' +
    '</td>' +
    '</tr>';

  dataTable.row.add($(newRow)).draw();
});







//start modal remove
$(".removeShipping").on("click", function () {

    const address_name = $(this).attr("data-address_name");
    const acc_id = $('#acc_id').val();
    const address_id = $(this).attr("data-address_id");

    console.log(address_id)
  
   
    // Show the initial SweetAlert with "Yes" and "Cancel" options
    Swal.fire({
      title: "Are you sure to remove?",
      text: address_name,
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
          url: 'delivery_place/controller/removeAddress.php',
          type: 'POST',
          data: {
            address_id: address_id,
            acc_id:acc_id
          },
          success: function (response) {
            // Handle the success response
            console.log(response);
            location.reload();
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
     
      }
    });
  });
//end modal remove








$(".AllowedCod").on("click", function() { 
    let address_id = $(this).attr("data-address_id");
    let currentStatus = $(this).attr("data-address_cod");
    let newStatus = currentStatus === "AllowedCod" ? "NotAllowedCod" : "AllowedCod";
    let status_cod = newStatus === "AllowedCod" ? "1" : "0"; // Assuming 0 represents allowed and 1 represents not allowed
    
    console.log(address_id)
    $.ajax({
        url: 'delivery_place/controller/updateCodStatusProcess.php',
        type: 'POST',
        data: {
            acc_id: acc_id,
            address_id: address_id,
            status_cod: status_cod
        },
        success: function(response) {
            // Handle the response as needed
            console.log(response);
            
            // Update the badge color and text based on the new status
            let badgeElement = $(this).find("span");
            badgeElement.removeClass("bg-lightgreen bg-lightred");
            badgeElement.addClass(newStatus === "AllowedCod" ? "bg-lightgreen" : "bg-lightred");
            badgeElement.text(newStatus === "AllowedCod" ? "Allowed" : "Not Allowed");
        }.bind(this), // Bind 'this' to access the clicked element in the success callback
        error: function(error) {
            // Handle errors if the AJAX request fails
            console.error(error);
        }
    });

    // Update the button data attribute based on the new status
    $(this).attr("data-address_cod", newStatus);
});



  
$(".NotAllowedCod").on("click", function() { 
    let address_id = $(this).attr("data-address_id");
    let currentStatus = $(this).attr("data-address_cod");
    let newStatus = currentStatus === "AllowedCod" ? "NotAllowedCod" : "AllowedCod";
    let status_cod = newStatus === "AllowedCod" ? "1" : "0"; // Assuming 0 represents allowed and 1 represents not allowed
    
    $.ajax({
        url: 'delivery_place/controller/updateCodStatusProcess.php',
        type: 'POST',
        data: {
            acc_id: acc_id,
            address_id: address_id,
            status_cod: status_cod
        },
        success: function(response) {
            // Handle the response as needed
            console.log(response);
            
            // Update the badge color and text based on the new status
            let badgeElement = $(this).find("span");
            badgeElement.removeClass("bg-lightgreen bg-lightred");
            badgeElement.addClass(newStatus === "AllowedCod" ? "bg-lightgreen" : "bg-lightred");
            badgeElement.text(newStatus === "AllowedCod" ? "Allowed" : "Not Allowed");
        }.bind(this), // Bind 'this' to access the clicked element in the success callback
        error: function(error) {
            // Handle errors if the AJAX request fails
            console.error(error);
        }
    });

    // Update the button data attribute based on the new status
    $(this).attr("data-address_cod", newStatus);
});

  















$(".editShipping").on("click", function() {
  let rider_id = $(this).attr("data-rider_id");
  let address_id = $(this).attr("data-address_id");
  let shipping = $(this).attr("data-shipping");
  let address_name = $(this).attr("data-address_name");

  // Set the selected option based on rider_id
  $("#riderSelect").val(rider_id);

  $("#AddressName").text(address_name);

  $("#address_id").val(address_id);
  $("#shipping").val(shipping);
});


  $("#savePlace").on("click", function() {

  let address_id = $("#address_id").val();
  let shipping = $("#shipping").val();
  let rider_id = $("#riderSelect").val();
  console.log(acc_id)

  $.ajax({
      url: 'delivery_place/controller/updateShippingProcess.php',
      type: 'POST',
      data: {
           acc_id: acc_id,
           address_id: address_id,
          shipping: shipping,
          rider_id:rider_id
      },
      success: function(response) {
               
            location.reload()
          console.log(response)
          
    
  },
  });
});












$(".AllowedPayFirst").on("click", function() {
    let address_id = $(this).attr("data-address_id");
    let currentStatus = $(this).attr("data-address_cod");
    let newStatus = currentStatus === "AllowedPayFirst" ? "NotAllowedPayFirst" : "AllowedPayFirst";
    let status_cod = newStatus === "AllowedPayFirst" ? "1" : "0"; // Assuming 0 represents allowed and 1 represents not allowed

    $.ajax({
        url: 'delivery_place/controller/updatePayFirstStatusProcess.php',
        type: 'POST',
        data: {
            acc_id: acc_id,
            address_id: address_id,
            address_paynow: status_cod
        },
        success: function(response) {
            // Handle the response as needed
            console.log(response);

            // Update the badge color and text based on the new status
            let badgeElement = $(this).find("span");
            badgeElement.removeClass("bg-lightgreen bg-lightred");
            badgeElement.addClass(newStatus === "AllowedPayFirst" ? "bg-lightgreen" : "bg-lightred");
            badgeElement.text(newStatus === "AllowedPayFirst" ? "Allowed" : "Not Allowed");
        }.bind(this), // Bind 'this' to access the clicked element in the success callback
        error: function(error) {
            // Handle errors if the AJAX request fails
            console.error(error);
        }
    });

    // Update the button data attribute based on the new status
    $(this).attr("data-address_cod", newStatus);
});




  
$(".NotAllowedPayFirst").on("click", function() { 
    let address_id = $(this).attr("data-address_id");
    let currentStatus = $(this).attr("data-address_cod");
    let newStatus = currentStatus === "AllowedPayFirst" ? "NotAllowedPayFirst" : "AllowedPayFirst";
    let status_cod = newStatus === "AllowedPayFirst" ? "1" : "0"; // Assuming 0 represents allowed and 1 represents not allowed
    
    $.ajax({
        url: 'delivery_place/controller/updatePayFirstStatusProcess.php',
        type: 'POST',
        data: {
            acc_id: acc_id,
            address_id: address_id,
            address_paynow: status_cod
        },
        success: function(response) {
            // Handle the response as needed
            console.log(response);
            
            // Update the badge color and text based on the new status
            let badgeElement = $(this).find("span");
            badgeElement.removeClass("bg-lightgreen bg-lightred");
            badgeElement.addClass(newStatus === "AllowedPayFirst" ? "bg-lightgreen" : "bg-lightred");
            badgeElement.text(newStatus === "AllowedPayFirst" ? "Allowed" : "Not Allowed");
        }.bind(this), // Bind 'this' to access the clicked element in the success callback
        error: function(error) {
            // Handle errors if the AJAX request fails
            console.error(error);
        }
    });

    // Update the button data attribute based on the new status
    $(this).attr("data-address_cod", newStatus);
});



});

