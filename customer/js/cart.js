$(document).ready(function() {
    function updateOrderSummary() {
        let subTotal = 0;
        let totalSavings = 0;
        let vat = 0;
        let total = 0;

        $('.product-checkbox:checked').each(function() {

            const productId = parseFloat($(this).data('product-id'));
            

            const price = parseFloat($(this).data('price'));
            
            const qty = parseInt($(this).data('qty'));
            const discountRate = parseFloat($(this).data('discount'));
            const hasPromo = $(this).data('has-promo');

            const productTotal = price * qty;
            subTotal += productTotal;

            if (hasPromo) {
                const discountAmount = productTotal * discountRate;
                totalSavings += discountAmount;
            }
        });

        vat = subTotal * 0.12; 
        total = subTotal + vat - totalSavings;

        $('#sub-total').text(subTotal.toFixed(2));
        $('#total-savings').text(totalSavings.toFixed(2));
        $('#vat').text(vat.toFixed(2));
        $('#total').text(total.toFixed(2));
    }

    $('#check-all').click(function() {
        var isChecked = $(this).prop('checked');
        $('.product-checkbox').prop('checked', isChecked);
        updateOrderSummary();
    });

    $('.product-checkbox').click(function() {
        updateOrderSummary();

        if($('.product-checkbox:checked').length === $('.product-checkbox').length) {
            $('#check-all').prop('checked', true);
        } else {
            $('#check-all').prop('checked', false);
        }
    });





    $(".btnCheckOut").click(function () {
      $("#checkoutModal").fadeIn();
    });
    $(".closeModal").click(function () {
        $("#checkoutModal").fadeOut();
    });
    
    $("#closeModal").click(function () {
            $("#checkoutModal").addClass("hidden");
    });




        $("#paymentMethod").change(function () {
            const selectedPaymentMethod = $(this).val();
            const selectedOption = $(this).find("option:selected");
    
            $("#paymentDetails").addClass("hidden");
            $("#qrCode").addClass("hidden");
            $("#proofOfPaymentSection").removeClass("hidden").find("input").removeAttr("required");
            $("#qrCode img").attr("src", ""); 

            if (selectedPaymentMethod !== "cod") {
                $("#paymentDetails").removeClass("hidden");
                
                const qrImagePath = selectedOption.data('img');
                
                if (qrImagePath) {

                    $("#qrCode").removeClass("hidden").find("img").attr("src", "../ewallet/" + qrImagePath);
                }
    
                $("#proofOfPaymentSection").find("input").attr("required", true);
            }

            else {
                $("#paymentDetails").addClass("hidden");
                $("#qrCode").addClass("hidden");
                $("#proofOfPaymentSection").find("input").removeAttr("required").val('');
            }
        });




        $('#btnConfirmCheckout').click(function (e) {
            e.preventDefault();
        
            // Get the selected payment method
            const selectedPaymentMethod = $("#paymentMethod").val();
        
            // Get the file input and check if a file is selected
            var fileInput = $('#proofOfPayment')[0];
            var selectedFile = fileInput.files[0];
        
            // Check if payment method is not 'cod' and no file has been selected
            if (selectedPaymentMethod !== "cod" && selectedFile == undefined) {
                alertify.error('You are required to upload a proof of payment.');
                return; // Exit the function if the condition is met
            }
        
            // Validate if the file is an image and its size is below 10MB
            if (selectedFile) {
                const fileSize = selectedFile.size; // File size in bytes
                const fileType = selectedFile.type; // File MIME type
        
                // Check if the file is an image
                if (!fileType.startsWith('image/')) {
                    alertify.error('Please upload a valid image file.');
                    return;
                }
        
                // Check if the file size is greater than 10MB (10MB = 10 * 1024 * 1024 bytes)
                if (fileSize > 10 * 1024 * 1024) {
                    alertify.error('The image file size should not exceed 10MB.');
                    return;
                }
            }
        
            // Get the selected address
            var selectedAddress = $("#addressSelect").val();
            console.log("Selected address: " + selectedAddress);
        
            // Collect the product data from the checked checkboxes
            var selectedProducts = [];
            $('.product-checkbox:checked').each(function() {
                const productId = $(this).data('product-id');
                const price = $(this).data('price');
                const size = $(this).data('size');
                const qty = $(this).data('qty');
                const discount = $(this).data('discount');
                const hasPromo = $(this).data('has-promo');
        
                // Create an object with all the data for each selected product
                selectedProducts.push({
                    productId: productId,
                    price: price,
                    size: size,
                    qty: qty,
                    discount: discount,
                    hasPromo: hasPromo
                });
            });
        
            // Check if at least one product is selected
            if (selectedProducts.length === 0) {
                alertify.error('Please select at least one product.');
                return; // Exit the function if no product is selected
            }
        
            // Log the selected products array (you can send this data to your backend or use it as needed)
            console.log("Selected Products: ", selectedProducts);
        
            alertify.success('Order Request sent successfully.');
            $("#checkoutModal").fadeOut();
        });
        
        
        
        
        
        




        updateOrderSummary();

  });