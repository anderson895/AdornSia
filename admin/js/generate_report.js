$(document).ready(function() {
    $('#report_type').change(function() {
        var yearRangeDiv = $('#year_range');
        if ($(this).val() === 'yearly') {
            yearRangeDiv.removeClass('hidden');
        } else {
            yearRangeDiv.addClass('hidden');
        }
    });
});