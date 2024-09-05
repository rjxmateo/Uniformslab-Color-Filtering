jQuery(document).ready(function($) {
    var allProductsHtml = $('.products-loop').html(); // Store all products' HTML

    $('.color-checkbox').change(function() {
        var selectedColors = [];

        // Collect all selected colors
        $('.color-checkbox:checked').each(function() {
            selectedColors.push($(this).val());
        });

        // Log the currently selected colors
        console.log('Selected Colors:', selectedColors);

        if (selectedColors.length === 0) {
            // Show all products if no colors are selected
            $('.products-loop').html(allProductsHtml);
            return;
        }

        // AJAX request if there are selected colors
        $.ajax({
            url: ajax_filter_params.ajax_url,
            type: 'POST',
            data: {
                action: 'filter_by_brand_color',
                colors: selectedColors, // Send the selected colors array
            },
            success: function(response) {
                $('.products-loop').html(response); // Replace the product list with filtered results
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
            }
        });
    });
});
