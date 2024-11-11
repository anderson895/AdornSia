$(document).ready(function () {
    // Add an event listener to the "Save" button
    $(".savePlaceTogler").click(function () {
      // Reset border color for all input fields and select elements
      $("input, select, textarea").css("border-color", "");
  
      // Gather values from form elements
      var acc_id = $("#acc_id").val();
      var region = $("#region_add").val();
      var province = $("#province_add").val();
      var city = $("#city_add").val();
      var barangay = $("#brgy_add").val();
    
      var shipping = $("#Addshipping").val();

      var riderSelect = $(".riderSelect").val();

      var activeStatus = $("#activeStatus").prop("checked");
      var deliveryAllowed = $("#deliveryAllowed").prop("checked");
      var paymentfirstAllowed = $("#paymentfirstAllowed").prop("checked");
      
      if (region === "" || province === "" ||  city === "" ||  barangay === "") {
        
        alertify.error("Select address ");
      }
      
   
    //   console.log(data)
      // Create an object with the gathered values
      var data = {
        acc_id: acc_id,
        region: region,
        province: province,
        city: city,
        barangay: barangay,
        activeStatus:activeStatus,
        deliveryAllowed:deliveryAllowed,
        paymentfirstAllowed:paymentfirstAllowed,
        shipping: shipping,
        riderSelect:riderSelect
      };
  
      if (acc_id && region && province && city && barangay && shipping) {
        $.ajax({
            type: "POST", // Change the type to "POST" if needed
            url: "delivery_place/controller/insertAddress.php", // Replace with your API endpoint
            data: data,
            success: function (response) {
                // Handle success response
                console.log(response);
    
                if (response == "alreadyDeleted") {
                    // Show the initial SweetAlert with "Yes" and "Cancel" options
                    Swal.fire({
                        title: 'This barangay is already Deleted. Restore it?',
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes restore it",
                        cancelButtonText: "Cancel",
                        confirmButtonClass: "btn btn-primary",
                        cancelButtonClass: "btn btn-danger ml-1",
                        buttonsStyling: false,
                    }).then(function (result) {
                        if (result.value) {

                          var newdata = {
                            acc_id: acc_id,
                            region: region,
                            province: province,
                            city: city,
                            barangay: barangay,
                            activeStatus:activeStatus,
                            deliveryAllowed:deliveryAllowed,
                            paymentfirstAllowed:paymentfirstAllowed,
                            shipping: shipping,
                            restoration:true
                          };

                          $.ajax({
                            type: "POST", // Change the type to "POST" if needed
                            url: "delivery_place/controller/restoreAddress.php", // Replace with your API endpoint
                            data: newdata,
                            success: function (response) {

                              console.log(response)
                              location.reload();
                              
                            }
                          })
                        }
                    });
                } else if (response == "alreadyAdded")  {

                  alertify.error("Barangay is already added");
                    
                }else{
                  // console.log(response); 
                  alertify.success("Address added successfully");
                   location.reload();
                }
            },
            error: function (error) {
                // Handle error
                console.log(error);
            },
            complete: function () {
                // This block is executed regardless of success or error
            }
        });
    } else {
        // Handle case where variables are empty
        console.log("One or more variables are empty");
    }

    
    });
  });
  