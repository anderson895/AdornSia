$(document).ready(function() {
    function updateOrderSummary() {
        let subTotal = 0;
        let totalSavings = 0;
        let vat = 0;
        let total = 0;

        $('.product-checkbox:checked').each(function() {
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
        
            const selectedPaymentMethod = $("#paymentMethod").val(); // Get the selected payment method
            var fileInput = $('#proofOfPayment')[0]; // Get the raw DOM element of file input
            var selectedFile = fileInput.files[0]; // Get the first selected file
        
            // Check if payment method is not 'cod' and no file has been selected
            if (selectedPaymentMethod !== "cod" && selectedFile == undefined) {
                alertify.error('You are required to upload a proof of payment.');
                return; // Exit the function if the condition is met
            }
        
            alertify.success('Order Request sent successfully.');
        
            // Get the selected address
            var selectedAddress = $("#addressSelect").val();
            console.log("Selected address: " + selectedAddress);
        });
        
        
        




        updateOrderSummary();

  });