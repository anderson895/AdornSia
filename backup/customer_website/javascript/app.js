$(document).ready(function () {
  var isNavOpen = false;
  var search = "";
  var category = "All";
  var isProfileDDOpen = false;


  // cart count
  const cartCount = () => {
    $.ajax({
      type: "GET",
      url: "backend/end-points/random.php",
      data: {
        requestType: "GetCartCount",
      },
      success: function (response) {
        $("#cart-count").text(response);
      },
    });
  }

  cartCount();

  setInterval(() => {
    cartCount();
  }, 1000)





  const getOrdersCount = () => {
    $.ajax({
      url: 'backend/end-points/get_count_status.php', 
      type: 'GET',
      dataType: 'json',
      success: function(response) {
        console.log(response); 
          let pendingCount = response.Pending;
          let acceptedCount = response.Accepted;
          let readyForDeliveryCount = response.ReadyForDelivery;
          let shippedCount = response.Shipped;
          let deliveredCount = response.Delivered;
          let collectedCount = response.collectedCount;
          let rejected = response.Rejected;
          let cancelled = response.Cancelled;
          $('#pendingCount').text(pendingCount);
          $('#acceptedCount').text(acceptedCount);
          $('#readyForDeliveryCount').text(readyForDeliveryCount);
          $('#shippedCount').text(shippedCount);
          $('#deliveredCount').text(deliveredCount);
          $('#collectedCount').text(collectedCount);
          $('#rejectedCount').text(rejected);
            $('#cancelledCount').text(cancelled);
      
      },
      error: function(xhr, status, error) {
          console.error("Error fetching order status counts:", error);
      }
  });
};

  // 

  $(document).click(function (e) {
    if (!$(e.target).closest("#btnProfileDropdown").length) {
      $('#dropDownItems').hide();
      isProfileDDOpen = false;
    }
  });

  $("#btnProfileDropdown").click(function (e) {
    if (isProfileDDOpen) {
      $('#dropDownItems').hide();
    } else {
      $('#dropDownItems').show();
    }

    isProfileDDOpen = !isProfileDDOpen;
  });

  //   Side Bar
  $("#btnToggleSideBar").click(function (e) {
    e.preventDefault();
    if (isNavOpen) {
      $(".side-nav").css("transform", "translateX(-100%)");
    } else {
      $(".side-nav").css("transform", "translateX(0)");
    }

    isNavOpen = !isNavOpen;
  });

  $(window).resize(function () {
    var windowWidth = $(window).width();
    if (windowWidth > 800) {
      isNavOpen = true;
      $(".side-nav").css("transform", "translateX(0)");
    } else {
      isNavOpen = false;
      $(".side-nav").css("transform", "translateX(-100%)");
    }
  });
  //   End of Side Bar

  //   Functions
  const showAlert = (alertType, text) => {
    $(alertType).text(text).css("opacity", "1");
    setTimeout(() => {
      $(alertType).css("opacity", "0");
    }, 1000);
  };

  const displayProduct = (search, category) => {
    $.ajax({
      type: "GET",
      url: "backend/end-points/get-all-products.php",
      data: {
        requestType: "getAllProducts",
        search: search,
        category: category,
      },
      success: function (response) {

        
        $("#allProductsContainer").html(response);
      },
    });
  };


  const displayMessage = () => {
    $.ajax({
      type: "GET",
      url: "backend/end-points/get-all-messages.php",
      data: {
        requestType: "getAllMessages",
      },
      success: function (response) {

        // console.log(response);

        $("#allMessagesContainer").html(response);
      },
    });
  };


  displayMessage();
  getOrdersCount();

  setInterval(() => {
    displayMessage();
  }, 1000)


  const displayCartItems = () => {
    $.ajax({
      type: "GET",
      url: "backend/end-points/get-cart-items.php",
      data: {
        requestType: "getAllCartItems",
      },
      success: function (response) {
        $("#cartItemsContainer").html(response);

        

      },
    });
  };


  const closeModal = () => {
    $(".modal").modal("hide");
  };

  const getPaymentTypes = (callback) => {
    var data = [];

    $.ajax({
      type: "GET",
      url: "backend/end-points/random.php",
      data: {
        requestType: "GetPaymentTypes",
      },
      success: function (response) {
        data = JSON.parse(response);
        callback(data);
      },
    });
  };

  const previewImage = (input) => {
    var reader = new FileReader();
    var preview = $("#imagePreview");

    reader.onload = function () {
      preview.attr("src", reader.result);
      preview.show();
    };

    if (input.files && input.files[0]) {
      reader.readAsDataURL(input.files[0]);
    }
  };

  //   End of functions

  //   Close Modal
  $(".btnCloseModal").click(function (e) {
    // e.preventDefault();
    closeModal();
  });

  // View Product
$(document).on("click", ".btnViewProduct", function (e) {
  e.preventDefault();

 
  

  
  const $this = $(this);
  const productID = $this.data("id");

  $('#rate_prod_id').val(productID)


  
  // Construct product name
  const productName = [
    $this.data("name"),
    $this.data("mg") > 0 ? `${$this.data("mg")}mg` : "",
    $this.data("g") > 0 ? `${$this.data("g")}g` : "",
    $this.data("ml") > 0 ? `${$this.data("ml")}ml` : ""
  ].filter(Boolean).join(" ");

  // Construct available stock message
  const availableStock = $this.data("stock");
  const displayStock = availableStock > 0
    ? `${availableStock}${$this.data("unittype")} available`
    : "Out of Stock";

  // Update stock class
  $("#viewProductStocks").toggleClass("text-danger", displayStock === "Out of Stock")
                          .toggleClass("text-success", displayStock !== "Out of Stock");

  // Display product data
  $("#viewProductName").text(productName);
  $("#viewProductPicture").attr("src", `../upload_prodImg/${$this.data("image")}`);
  $("#viewProductDescription").text($this.data("description"));
  $("#viewProductStocks").text(displayStock);
  $("#viewProductPrice").text(`PHP ${$this.data("price")}`);
  $("#btnViewProdAddToCart").data("prodid", productID);





  //start Fetch product photos
  $.ajax({
    url: 'backend/end-points/fetchProductPhotos.php',
    type: 'POST',
    dataType: 'json',
    data: { productID: productID },
    success: function (photos) {
 
      $('#productPhotos-modal-sm-img-container').empty();

      photos.forEach(photo => {
        $('#productPhotos-modal-sm-img-container').append(`
          <img src="../product_photos/${photo}" class="product-photo-sm" />
        `);
      });


      if (photos.length > 0) {
        $("#viewProductPicture").attr("src", `../product_photos/${photos[0]}`);
      }


        // Serialize photos array into a comma-separated string
    const photosString = encodeURIComponent(photos.join(','));

    // Get the stock value
    let stock = $this.data('stock');
    stock = isNaN(parseInt(stock, 10)) ? 0 : parseInt(stock, 10);

    // Prepare data for the URL
    const queryParams = $.param({
      id: $this.data('id'),
      productName: productName,
      stock: stock,
      image: $this.data('image'),
      description: $this.data('description'),
      price: $this.data('price'),
      photos: photosString
    });

    // Redirect to the product view page with the data in the URL
    window.location.href = 'Product_view.php?' + queryParams;

      
    },
    error: function (xhr, status, error) {
      console.error('AJAX Error:', status, error);
    }
  });
  //end Fetch product photos

  // $("#viewProductModal").modal("show");

  // Handle the click event for the small product photos
  $(document).on("click", "#productPhotos-modal-sm-img-container .product-photo-sm", function () {
    const src = $(this).attr("src");
    $("#viewProductPicture").attr("src", src);
  });

});


  // Sent Messages

  // File input change event
$("#fileInput").change(function() {
  var file = this.files[0];
  if (file) {
      $("#fileName").text("Selected File: " + file.name);
      $("#fileDisplay").show();

      // Preview the image
      var reader = new FileReader();
      reader.onload = function(e) {
          $("#imagePreview").attr("src", e.target.result);
          $("#imagePreviewContainer").show();
      };
      reader.readAsDataURL(file);
  }
});

// Optional: For the remove file button
$("#removeFile").click(function() {
  $("#fileInput").val(''); // Clear the file input
  $("#fileName").text("Selected File: ");
  $("#imagePreviewContainer").hide(); // Hide image preview
  $("#fileDisplay").hide(); // Hide file display
});

// Send message button click event
$("#btnSentMessage").click(function(e) {
  e.preventDefault();

  var mess_sender_id = $("#mess_sender_id").val();
  var sender_Messages = $("#sender_Messages").val();
  var fileInput = $('#fileInput')[0]; // Get the file input element
  
  
  // Input validation
  if (sender_Messages.trim() === '' && fileInput.files.length === 0) {
      showAlert(".alert-danger", "Message cannot be empty!");
      return;
  }

  // Prepare FormData
  var formData = new FormData();
  formData.append("requestType", "SentMessage");
  formData.append("mess_sender_id", mess_sender_id);
  formData.append("sender_Messages", sender_Messages);

  // Check for file input and append if available
  if (fileInput.files.length > 0) {
      var file = fileInput.files[0];
      var maxFileSize = 10 * 1024 * 1024; // 10 MB limit
      if (file.size > maxFileSize) {
          showAlert(".alert-danger", "File size must be less than 10MB!");
          return;
      }
      formData.append("file", file); // Append the file
  }

  // Show spinner and disable button
  $("#spinner").show();
  $("#btnSentMessage i").hide();
  $("#btnSentMessage").prop('disabled', true);

  // AJAX request
  $.ajax({
      type: "POST",
      url: "backend/end-points/SentMessage.php",
      data: formData,
      contentType: false, // Important for FormData
      processData: false, // Important for FormData
      success: function(response) {
          console.log(response);
          if (response.error) {
              // Assuming your backend returns a JSON object with an 'error' key
              showAlert(".alert-danger", response.error);
          } else {
              showAlert(".alert-success", response.success);
              $('#sender_Messages').val(''); // Clear message input
              $('#fileInput').val(''); // Clear file input
              $('#imagePreviewContainer').hide(); // Hide image preview
              $('#fileDisplay').hide(); // Hide file display
          }
      },
      error: function(jqXHR, textStatus, errorThrown) {
          showAlert(".alert-danger", "An error occurred: " + textStatus);
      },
      complete: function() {
          $("#spinner").hide(); // Hide spinner
          $("#btnSentMessage i").show(); // Show button icon
          $("#btnSentMessage").prop('disabled', false); // Enable button
      }
  });
});











  //   Add To Cart
  $("#btnViewProdAddToCart").click(function (e) {
    e.preventDefault();
    var productId = $(this).data("prodid");

    $.ajax({
      type: "POST",
      url: "backend/end-points/product.php",
      data: {
        requestType: "AddToCart",
        productId: productId,
      },
      success: function (response) {
        $("#viewProductModal").modal("hide");
        if (response == "400") {
          showAlert(".alert-danger", "Add To Cart Unsuccessful!");
        } else {
          showAlert(".alert-success", response);
        }
      },
    });
  });

  // Search Product
  $("#searchProduct").on("input", function (e) {
    e.preventDefault();
    search = $(this).val();

    $("#productCategory").val("All");
    displayProduct(search, category);
  });

  $("#productCategory").change(function (e) {
    e.preventDefault();
    $("#searchProduct").val("");
    search = "";
    category = $(this).val();
    displayProduct(search, category);
  });

  // Cart
  $(document).on("click", ".minusCartQty", function (e) {
    e.preventDefault();
    var id = $(this).data("id");
    $.ajax({
      type: "POST",
      url: "backend/end-points/cart.php",
      data: {
        requestType: "updateCartQtyMinus",
        id: id,
      },
      success: function (response) {
        displayCartItems();
      },
    });
  });

  $(document).on("click", ".addCartQty", function (e) {
    e.preventDefault();
    var id = $(this).data("id");
    $.ajax({
      type: "POST",
      url: "backend/end-points/cart.php",
      data: {
        requestType: "updateCartQtyAdd",
        id: id,
      },
      success: function (response) {
        displayCartItems();
      },
    });
  });

  $(document).on("blur", ".inputChangeCartItemQty", function (e) {
    e.preventDefault();
    var id = $(this).data("id");
    var inputQty = $(this).val();
    var inputQty = parseInt($(this).val(), 10);
    console.log(inputQty);
    if (inputQty == 0 || isNaN(inputQty) || !Number.isInteger(inputQty) || inputQty < 1) {
      inputQty = 1;
      $(this).val(inputQty);
      console.log("Invalid Input!");
    }

    $.ajax({
      type: "POST",
      url: "backend/end-points/cart.php",
      data: {
        requestType: "updateCartQty",
        id: id,
        inputQty: inputQty,
      },
      success: function (response) {
        displayCartItems();
      },
    });
  });

  $(document).on("click", ".btnDeleteCartItem", function (e) {
    e.preventDefault();
    var id = $(this).data("id");

    $("#deleteCartItemQDisplay").text(
      "Are you sure that you want to delete this product in your cart?"
    );
    $("#btnDeleteCartItem").data("prodid", id);
    $("#deleteCartItemModal").modal("show");
  });

  $("#deleteAllItemsInCart").click(function (e) {
    e.preventDefault();
    $("#deleteCartItemQDisplay").text(
      "Are you sure that you want to delete all products in your cart?"
    );
    $("#btnDeleteCartItem").data("prodid", "All");
    $("#deleteCartItemModal").modal("show");
  });

  $("#btnDeleteCartItem").click(function (e) {
    e.preventDefault();
    var id = $(this).data("prodid");
    if (id == "All") {
      $.ajax({
        type: "POST",
        url: "backend/end-points/cart.php",
        data: {
          requestType: "deleteAllCartItem",
        },
        success: function (response) {
          closeModal();
          if (response == "200") {
            showAlert(".alert-success", "Items Deleted!");
          } else {
            showAlert(".alert-success", "Something went wrong!");
          }
          displayCartItems();
        },
      });
    } else {
      $.ajax({
        type: "POST",
        url: "backend/end-points/cart.php",
        data: {
          requestType: "deleteCartItem",
          id: id,
        },
        success: function (response) {
          closeModal();
          if (response == "200") {
            showAlert(".alert-success", "Item Deleted!");
          } else {
            showAlert(".alert-success", "Something went wrong!");
          }
          displayCartItems();
        },
      });
    }
  });

  // $(document).on("change", ".cartSelect", function (e) {
  //   e.preventDefault();
  //   var totalAmount = 0;

  //   $(".cartSelect:checked").each(function () {
  //     var amount = $(this).data("amount");

  //     if (!isNaN(amount)) {
  //       totalAmount += amount;
  //     }
  //   });

  //   $("#totalSelectedItems").text(totalAmount.toFixed(2));

  // });

    // Handle "Check All" checkbox change
    $(document).on("change", "#checkAll", function () {
        // Set the checked state of all individual checkboxes to match "Check All"
        $('.cartSelect').prop('checked', $(this).prop('checked'));
        calculateTotal();
    });

    // Handle individual cart item checkbox changes
    $(document).on("change", ".cartSelect", function () {
        // Check if all individual checkboxes are checked
        let allChecked = $('.cartSelect:checked').length === $('.cartSelect').length;
        // Update the "Check All" checkbox based on the individual checkbox status
        $('#checkAll').prop('checked', allChecked);
        calculateTotal();
    });

    // Function to calculate the total amount of selected items
    function calculateTotal() {
        let totalAmount = 0;

        // Iterate through each checked checkbox and sum their data-amount
        $(".cartSelect:checked").each(function () {
            let amount = parseFloat($(this).data("amount"));
            if (!isNaN(amount)) {
                totalAmount += amount;
            }
        });

        // Update the total amount display
        $("#totalSelectedItems").text(totalAmount.toFixed(2));
    }


  // Check Out
  var items = [];
  $(document).on("click", "#btnCheckOut", function (e) {
    e.preventDefault();

    var sf = $(this).data("sf");
    items = [];

    var hasInvalidQty = false;
    $(".cartSelect:checked").each(function () {
      var stock = $(this).data("stock");
      var inputQty = $(this).data("inputqty");

      data = {
        productId: $(this).data("id"),
        productImage: $(this).data("image"),
        productName: $(this).data("name"),
        productPrice: $(this).data("price"),
        productUnitType: $(this).data("unittype"),
        productAmount: $(this).data("amount"),
        productVat: $(this).data("itemvat"),
        qty: inputQty,
      };

      if (inputQty > stock) {
        hasInvalidQty = true;
      } else {
        items.push(data);
      }
    });

    if (hasInvalidQty) {
      showAlert(".alert-danger", "Please check your input quantity!");
    } else {
      if (items.length > 0) {
        var subtotal = 0;
        var vat = 0;
        var total = 0;

        $("#placeOrderItemsContainer").html("");
        items.forEach((element) => {
          var tr = $("<tr>");
          $(tr).append(
            "<td class='prod-img-td'><img src='../upload_prodImg/" +
            element.productImage +
            "'></td>"
          );
          $(tr).append("<td>" + element.productName + "</td>");
          $(tr).append(
            "<td>" +
            element.qty +
            element.productUnitType +
            " x " +
            element.productPrice +
            "</td>"
          );

          $(tr).append("<td> ₱ " + element.productAmount.toFixed(2) + "</td>");

          subtotal += element.productAmount;
          vat += element.productVat;
          $("#placeOrderItemsContainer").append(tr);
        });

        // Computation
        $("#checkOutSubtotal").text(subtotal.toFixed(2));
        $("#checkOutVat").text(vat.toFixed(2));

        if (sf == "Invalid") {
          $("#checkOutShipping")
            .text("Address out of coverage!")
            .addClass("text-danger");
          $("#btnPlaceOrder").prop("disabled", true);


          $('.payment_type_container').hide();
        } else {
          $("#checkOutShipping").text("₱ " + sf.toFixed(2));
          total += sf;
        }

        total += subtotal;
        // total += vat;
        $("#checkOutTotal").text(total.toFixed(2));

        $("#PlaceOrderModal").modal("show");
      } else {
        showAlert(".alert-danger", "Please select items.");
      }
    }
  });

  // Payment Type
  $("#checkOutPaymentTypesSelect").change(function (e) {
    e.preventDefault();

    $("#btnPlaceOrder").prop("disabled", false);

    var selectedOption = $(this).find("option:selected");
    $("#paymentTypeImgInput").val(null);
    $("#imagePreview").attr("src", "#");
    $("#imagePreview").hide();

    if ($(this).val() == "cod") {
      $("#paymentNumberContainer").text("");
      $("#paymentImgContainer").attr("src", "");
      $(".upload-payment-container").css("display", "none");
    } else {
      $("#btnPlaceOrder").prop("disabled", true);
      $("#paymentNumberContainer").text(selectedOption.data("number"));
      $("#paymentImgContainer").attr(
        "src",
        "../upload_system/" + selectedOption.data("img")
      );

      $(".upload-payment-container").css("display", "flex");
    }
  });

  $("#pofTermsAgree").change(function (e) {

    var shipping_status = $("#checkOutShipping").text()

    console.log(shipping_status);

    if ($("#pofTermsAgree").is(':checked')&& shipping_status !=="Address out of coverage!") {
      $("#btnPlaceOrder").prop("disabled", false);
    } else {
      $("#btnPlaceOrder").prop("disabled", true);
    }
  });

  $("#paymentTypeImgInput").change(function () {
    previewImage(this);
  });

  // Place Order
$("#btnPlaceOrder").click(function (e) {
  e.preventDefault();

  // Disable the button and show the spinner
 
  var paymentType = $("#checkOutPaymentTypesSelect").val();
  if (paymentType == "cod") {
    $(this).prop("disabled", true); 
    $(".spinner").show(); 

    
    $.ajax({
      type: "POST",
      url: "backend/end-points/place-order.php",
      data: {
        requestType: "PlaceOrder",
        paymentType: paymentType,
        items: JSON.stringify(items),
      },
      success: function (response) {
        closeModal("PlaceOrderModal");
        displayCartItems();
        if (response == "200") {
          showAlert(".alert-success", "Order Placed!");
        } else {
          showAlert(".alert-danger", "Something Went Wrong!");
        }
      },
      complete: function () {
        // Re-enable the button and hide the spinner
        $("#btnPlaceOrder").prop("disabled", false); // Re-enable the button
        $(".spinner").hide(); // Hide the spinner
      }
    });
  } else {
    if ($("#paymentTypeImgInput")[0].files.length === 0) {
      showAlert(".alert-danger", "Please Upload Proof of Payment!");
      $("#btnPlaceOrder").prop("disabled", false); // Re-enable the button if no file is uploaded
      $("#spinner").hide(); // Hide the spinner
    } else {
      var formData = new FormData();

      var paymentTypeImgInput = $("#paymentTypeImgInput")[0].files[0];
      formData.append("requestType", "PlaceOrder");
      formData.append("paymentType", paymentType);
      formData.append("items", JSON.stringify(items));
      formData.append("proofOfPayment", paymentTypeImgInput);

      $(this).prop("disabled", true); 
      $(".spinner").show(); 
    

      $.ajax({
        type: "POST",
        url: "backend/end-points/place-order.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          closeModal("PlaceOrderModal");
          displayCartItems();
          if (response == "200") {
            showAlert(".alert-success", "Order Placed!");
          } else {
            showAlert(".alert-danger", "Something Went Wrong!");
          }
        },
        error: function (xhr, status, error) {
          console.error(xhr.responseText);
        },
        complete: function () {
          // Re-enable the button and hide the spinner
          $("#btnPlaceOrder").prop("disabled", false); // Re-enable the button
          $("#spinner").hide(); // Hide the spinner
        }
      });
    }
  }
});
// End of Place Order


  // Orders.php
  $("#orderSelectPage").change(function (e) {
    e.preventDefault();
    window.location.href = "orders.php?page=" + $(this).val();
  });
  // End of Orders.php

  // View-Order.php


  
  $(".CancelModal").click(function (e) { 
    e.preventDefault();

    console.log('click');

    $('#cancelModal').modal('show');

    var order_id = $(this).attr("data-id");

    $('#btnCancelOrder').attr("data-id", order_id); // Corrected this line
});



  $("#btnCancelOrder").click(function (e) {
    e.preventDefault();
    

    if(!$('#cancelReason').val()){
      showAlert(".alert-danger", "Select Reason For Cancellation is Required");
      return;
    }


    $.ajax({
      type: "POST",
      url: "backend/end-points/orders.php",
      data: {
        requestType: "CancelOrder",
        id: $(this).data("id"),
        cancelReason:$('#cancelReason').val(),
      },
      success: function (response) {
        console.log(response);
        if (response == "200") {
          showAlert(".alert-success", "Order Cancelled!");
          window.location.reload();
        } else {
          showAlert(".alert-danger", "Something Went Wrong!");
        }
      },
    });
  });
  // End of View-Order.php

  // Profile
  $("#btnEditProfile").click(function (e) {
    e.preventDefault();

   

    $('#editFName').val($(this).data("fname"));
    $('#editLName').val($(this).data("lname"));
    $('#editBday').val($(this).data("bday"));
    $('#editUsername').val($(this).data("uname"));
    $('#editEmail').val($(this).data("email"));
    $('#editContact').val($(this).data("contact"));

    $("#editProfileModal").modal('show');
    $("#modalUpdateChoices").modal("hide");
  })

  $("#frmEditProfile").submit(function (e) {
    e.preventDefault();

    var formData = $(this).serialize();

    $.ajax({
      type: "POST",
      url: "backend/end-points/random.php",
      data: formData,
      success: function (response) {
        console.log(response);
        closeModal("editProfileModal");
        if (response == "200") {
          showAlert(".alert-success", "Edited!");
          setInterval(() => {
            window.location.reload();
          }, 1000)
        } else {
          showAlert(".alert-danger", "Something Went Wrong!");
        }
      },
      error: function (xhr, status, error) {
        console.error(xhr.responseText);
      },
    });
  })
  // End of Profile

  // Function Call
  displayProduct(search, category);
  displayCartItems();

  // Put Payment Types in Select
  getPaymentTypes((data) => {
    data.forEach((type) => {
      $("#checkOutPaymentTypesSelect").append(
        `<option value="${type.payment_id}" data-img="${type.payment_image}" data-number="${type.payment_number}">${type.payment_name}</option>`
      );
    });
  });

  $(".btnEditAddress").click(function (e) {
    e.preventDefault();
    $(".editAddressModal").modal("show");
    $("#modalUpdateChoices").modal("hide");


    $(".PlaceOrderModal").modal("hide");
    
    
  });


  $("#btnProfileImgModal").click(function (e) {
    e.preventDefault();

    $("#editProfileImgModal").modal("show");
    $("#modalUpdateChoices").modal("hide");
});



$("#btnEditPassword").click(function (e) {
  e.preventDefault();

  $("#editPassModal").modal("show");
  $("#modalUpdateChoices").modal("hide");
});
$(document).ready(function() {
  $('#userPasswordFRM').on('submit', function(e) {
      e.preventDefault(); // Prevent the default form submission behavior

      // Get form values
      var currpass = $('#currpass').val().trim();
      var newpass = $('#newpass').val().trim();
      var confpass = $('#confpass').val().trim();

      // Validate form fields
      if (!currpass) {
          $('#currpass').addClass('is-invalid');
          return;
      } else {
          $('#currpass').removeClass('is-invalid');
      }

      if (!newpass) {
          $('#newpass').addClass('is-invalid');
          return;
      } else {
          $('#newpass').removeClass('is-invalid');
      }

      if (!confpass) {
          $('#confpass').addClass('is-invalid');
          return;
      } else {
          $('#confpass').removeClass('is-invalid');
      }

      // Check if new password matches confirmation password
      if (newpass !== confpass) {
          alertify.error('Passwords do not match.');
          $('#newpass, #confpass').addClass('is-invalid');
          return;
      }

      // Serialize the form data
      var formData = $(this).serialize() + '&requestType=updatePass'; // Append requestType

      // AJAX request
      $.ajax({
          url: 'backend/end-points/updatepass.php', // Backend URL
          type: 'POST', // Request method
          data: formData, // Serialized form data with requestType
          success: function(response) {
              console.log(response); // Log the response for debugging

              switch (response) {
                  case 'currentPassErr':
                      alertify.error('Current password is incorrect.');
                      $('#currpass').addClass('is-invalid');
                      $('#newpass, #confpass').removeClass('is-invalid');
                      break;

                  case 'NotMatch':
                      alertify.error('Passwords do not match.');
                      $('#currpass').removeClass('is-invalid');
                      $('#newpass, #confpass').addClass('is-invalid');
                      break;

                  case 'updatePassSuccess':
                      alertify.success('Password updated successfully.');
                      $('#currpass, #newpass, #confpass').removeClass('is-invalid').val('');
                      break;

                  default:
                      alertify.error('Unexpected response.');
                      break;
              }
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText); // Log error response for debugging
              alert('Something went wrong. Please try again.');
          }
      });
  });

  // Close modal on button click
  $('.btnCloseModal').on('click', function() {
      $('#editPassModal').modal('hide');
  });
});






$('#profileImgFRM').on('submit', function(e) {
  e.preventDefault(); // Prevent the default form submission

  // Create a FormData object
  var formData = new FormData();

  // Get the file input element and append the selected file to the FormData object
  var fileInput = $('#profileAttachementImg')[0].files[0];
  if (fileInput) {
      formData.append('profileAttachementImg', fileInput);
  }

  // Show loading indicator
  $('#loader').show();

  // Set a delay before sending the AJAX request
  var delay = 500; // 500ms delay, adjust as needed
  setTimeout(function() {
      // Send the AJAX request
      $.ajax({
          url: "backend/end-points/update_img.php",
          type: 'POST',
          data: formData,
          contentType: false, // Prevent jQuery from overriding the Content-Type header
          processData: false, // Prevent jQuery from converting the FormData object to a query string
          success: function(response) {
              // Handle success response
              console.log(response);

              // Show success message
              alertify.success('Image uploaded successfully.');
          },
          error: function(jqXHR, textStatus, errorThrown) {
              // Handle error response
              console.error(textStatus, errorThrown);

              // Show error message
              alertify.error('Failed to upload image. Please try again.');
          },
          complete: function() {
              // Always hide the loading indicator
              $('#loader').hide();

              // Reload the page after the upload is complete
              location.reload();
          }
      });
  }, delay); // Delay the AJAX request
});




  // Pick address

  const getAddressId = (id, addressType, callback) => {
    $.ajax({
      url: "../Main/controller/register/get_address_id.php",
      type: "GET",
      data: {
        addressType: addressType,
        id: id,
      },
      success: function (response) {
        // Call the callback function with the response
        // console.log("start-" + response + "-end");
        callback(response);
      },
      error: function (xhr, status, error) {
        console.error("Error:", status, error);
        // Call the callback function with an error value (if needed)
        callback(null);
      }
    });
  }

  $.getJSON('../ph-json/region.json', function (data) {
    var regionDropdown = $('#regionDropDown');

    // regionDropdown.empty(); // Clear existing options

    // Loop through the data from JSON and add them as options to the dropdown
    regionDropdown.append('<option value="">Select Region</option>');
    $.each(data.data, function (key, value) {
      var checkResponse;
      getAddressId(value.region_code, 'reg_code', function (response) {
        checkResponse = response;
        if (checkResponse == 1) {
          regionDropdown.append('<option value="' + value.region_code + '">' + value.region_name + '</option>')
        }
      });
    });
  });

  $('#regionDropDown').on('change', function () {
    var selectedRegionCode = $(this).val();
    var provinceDropdown = $('#provinceDropDown');

    provinceDropdown.empty(); // Clear existing options

    $.getJSON('../ph-json/province.json', function (data) {
      var provincesInRegion = data.data.filter(function (province) {
        return province.region_code === selectedRegionCode;
      });

      provinceDropdown.append('<option value="">Select Province</option>');
      $.each(provincesInRegion, function (key, value) {
        var checkResponse;
        getAddressId(value.province_code, 'prov_code', function (response) {
          checkResponse = response;
          if (checkResponse == 1) {
            provinceDropdown.append('<option value="' + value.province_code + '">' + value.province_name + '</option>');
          }
        });
      });
    });
  });

  $('#provinceDropDown').on('change', function () {
    var selectedProvinceCode = $(this).val();
    var cityDropdown = $('#cityDropDown');

    cityDropdown.empty(); // Clear existing options

    $.getJSON('../ph-json/city.json', function (data) {
      var citiesInProvince = data.data.filter(function (city) {
        return city.province_code === selectedProvinceCode;
      });

      cityDropdown.append('<option value="">Select City</option>');
      $.each(citiesInProvince, function (key, value) {
        var checkResponse;
        getAddressId(value.city_code, 'muni_code', function (response) {
          checkResponse = response;
          if (checkResponse == 1) {
            cityDropdown.append('<option value="' + value.city_code + '">' + value.city_name + '</option>');
          }
        });
      });
    });
  });

  $('#cityDropDown').on('change', function () {
    var selectedCityCode = $(this).val();
    var barangayDropdown = $('#barangayDropDown');

    barangayDropdown.empty(); // Clear existing options

    $.getJSON('../ph-json/barangay.json', function (data) {
      var barangaysInCity = data.data.filter(function (barangay) {
        return barangay.city_code === selectedCityCode;
      });

      barangayDropdown.append('<option value="">Select Barangay</option>');
      $.each(barangaysInCity, function (key, value) {
        var checkResponse;
        getAddressId(value.brgy_code, 'address_code', function (response) {
          checkResponse = response;
          if (checkResponse == 1) {
            barangayDropdown.append('<option value="' + value.brgy_code + '">' + value.brgy_name + '</option>');
          }
        });
      });
    });
  });

  $("#frmEditAddress").submit(function (e) {
    e.preventDefault();
    var accCode = $("#editAddressAccCode").val();
    var userFullName = $("#userFullName").val();
    var userEmail = $("#userEmail").val();
    var userPhone = $("#userPhone").val();

    var barangayCode = $("#barangayDropDown").val();

    var regionName = $("#regionDropDown option:selected").text();
    var provinceName = $("#provinceDropDown option:selected").text();
    var cityName = $("#cityDropDown option:selected").text();
    var barangayName = $("#barangayDropDown option:selected").text();
    var streetName = $("#streetName").val();

    console.log(accCode)
    console.log(userFullName)
    console.log(userEmail)
    console.log(userPhone)
    console.log(barangayCode)
    console.log(streetName + " " + barangayName + " " + cityName + " " + provinceName + " " + regionName);

    $.ajax({
      type: "POST",
      url: "backend/end-points/address.php",
      data: {
        requestType: "EditAddress",
        accCode: accCode,
        userFullName: userFullName,
        userEmail: userEmail,
        userPhone: userPhone,
        barangayCode: barangayCode,
        completeAddress: regionName + " " + provinceName + " " + cityName + " " + barangayName + " " + streetName
      },
      success: function (response) {
        console.log("response: " + response)
        if (response == "200") {
          showAlert(".alert-success", "Success!");
          setInterval(() => {
            window.location.reload();
          }, 1000)
        } else {
          showAlert(".alert-danger", "Something Went Wrong!");
        }
      }
    });
  });









  $(".rateToggler").click(function (e) { 
    e.preventDefault();

    $('#rateTsModal').show();
    $('.modal-backdrop').hide();  // Hide the backdrop

    var prod_id = $(this).attr("data-prod_id");
    var prod_name = $(this).attr("data-prod_name");

    $('#ts-frm-Id').val(prod_id);
    $('#tsReviewName').text(prod_name);

    console.log(prod_name);
});




// rate and reviews
$(".btnTsFrmStar").click(function () {
  var clickedId = $(this).data("id");
  $(".btnTsFrmStar").removeClass("active"); // Remove active class from all buttons
  $(".btnTsFrmStar:lt(" + clickedId + ")").addClass("active"); // Add active class to buttons up to the clicked one
  $("#tsfrmStar").val(clickedId);
});












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








