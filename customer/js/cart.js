$(document).ready(function() {
    function updateOrderSummary() {
        let subTotal = 0;
        let vat = 0;
        let total = 0;
        var sf = 0;

        $('.product-checkbox:checked').each(function() {

            const price = $(this).data('price'); 
            
            const productTotal = price;
            subTotal += productTotal;
            sf = 50;
            vat = subTotal * 0.12; 
            total = subTotal + vat + sf;
         
        });
        
        $('#shipping-fee').text(sf.toFixed(2));
        $('#sub-total').text(subTotal.toFixed(2));
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

           
            var sf = $('#shipping-fee').text();
            // Retrieve values for subtotal, VAT, and total
            var subtotal = $('#sub-total').text();
            var vat = $('#vat').text();
            var total = $('#total').text();
        
            // Retrieve selected payment method and file input
            var selectedPaymentMethod = $("#paymentMethod option:selected").data('ename');

            var fileInput = $('#proofOfPayment')[0];
            var selectedFile = fileInput.files[0];
        
            console.log(selectedPaymentMethod)
            // If payment method is not 'COD' and no file is selected, show error
            if (selectedPaymentMethod !== "cod" && selectedFile == undefined) {
                alertify.error('You are required to upload a proof of payment.');
                return;
            }
        
            // Validate file type and size if a file is selected
            if (selectedFile) {
                const fileSizeLimit = 10 * 1024 * 1024; // 10MB limit
                const fileSize = selectedFile.size;
                const fileType = selectedFile.type;
        
                if (!fileType.startsWith('image/')) {
                    alertify.error('Please upload a valid image file.');
                    return;
                }
                if (fileSize > fileSizeLimit) {
                    alertify.error('The image file size should not exceed 10MB.');
                    return;
                }
            }
        
            // Check if a valid address is selected
            var selectedAddress = $("#addressSelect").val();
            if (selectedAddress === null) {
                alertify.error('Please set an address first.');
                return;
            }

         
            // Collect selected products' data from checkboxes
            var selectedProducts = [];
            $('.product-checkbox:checked').each(function() {
                selectedProducts.push({
                    productId: $(this).data('product-id'),
                    originalPrice: $(this).data('originalprice'),  // Use $(this) to get data for the current checkbox
                    price: $(this).data('price'),
                    size: $(this).data('size'),
                    qty: $(this).data('qty'),
                    promoName: $(this).data('promoname'),
                    promoRate: $(this).data('promorate')
                });
            
                // Log the 'originalprice' for the current checkbox
                console.log($(this).data('originalprice'));  // Logs the 'data-originalprice' value of the selected checkbox
            });
            
            // Ensure at least one product is selected
            if (selectedProducts.length === 0) {
                alertify.error('Please select at least one product.');
                return;
            }
        
            // Prepare form data for AJAX
            var formData = new FormData();
            formData.append("selectedAddress", selectedAddress);
            formData.append("selectedPaymentMethod", selectedPaymentMethod);
            if (selectedFile) formData.append("selectedFile", selectedFile); // Only if file is selected
            formData.append("subtotal", subtotal);
            formData.append("sf", sf);
            formData.append("vat", vat);
            formData.append("total", total);
            formData.append("selectedProducts", JSON.stringify(selectedProducts));
            formData.append("requestType", "OrderRequest");
        
            $.ajax({
                type: "POST",
                url: "backend/end-points/controller.php",
                data: formData,
                processData: false, // Prevent jQuery from processing the data
                contentType: false, // Prevent jQuery from setting content type
                dataType: "json", // Set data type to JSON
                beforeSend: function() {
                    $(".loadingSpinner").fadeIn();
                },
                
                success: function(response) {
                    console.log(response);
                
                    if (response.status == 'success') {
                        $(".loadingSpinner").fadeOut();
                        console.log(response); // Response is already parsed as JSON
                        alertify.success('Order Request sent successfully.');
                        location.reload();
                        $("#checkoutModal").fadeOut();
                    } else if (response.status == 'error') { // Use '==' for comparison
                        alertify.error('Order Request Failed.');
                    }
                },
                
                error: function(xhr, status, error) {
                    $(".loadingSpinner").fadeOut();
                    console.log('Status:', status);
                    console.log('Error:', error);
                    alertify.error('Error occurred during the request!');
                }
                
            });
            
        });
        
        
        
        
        
        
        




        updateOrderSummary();

  });