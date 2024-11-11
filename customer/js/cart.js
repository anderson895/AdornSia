$(document).ready(function() {
    function updateOrderSummary() {
        let subTotal = 0;
        let totalSavings = 0;
        let vat = 0;
        let total = 0;

        // Loop through all checked products and calculate subtotal, savings, and VAT
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

        vat = subTotal * 0.12; // Assuming VAT is 12%
        total = subTotal + vat - totalSavings;

        // Update the order summary
        $('#sub-total').text(subTotal.toFixed(2));
        $('#total-savings').text(totalSavings.toFixed(2));
        $('#vat').text(vat.toFixed(2));
        $('#total').text(total.toFixed(2));
    }

    // Handle "check-all" checkbox click
    $('#check-all').click(function() {
        var isChecked = $(this).prop('checked');
        $('.product-checkbox').prop('checked', isChecked);
        updateOrderSummary();
    });

    // Handle individual product checkbox click
    $('.product-checkbox').click(function() {
        updateOrderSummary();
        // If all checkboxes are selected, check the "check-all" box
        if($('.product-checkbox:checked').length === $('.product-checkbox').length) {
            $('#check-all').prop('checked', true);
        } else {
            $('#check-all').prop('checked', false);
        }
    });

    // Initialize the order summary on page load
    updateOrderSummary();
});