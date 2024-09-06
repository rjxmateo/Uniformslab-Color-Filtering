jQuery(document).ready(function($) {
    var allProductsHtml = $('.products-loop').html();


    function updateParentCheckbox(modalId) {
        var modal = $('#' + modalId);
        var parentCheckboxId = modalId.replace('modal-', 'color-checkbox-');
        var parentCheckbox = $('#' + parentCheckboxId);
        
        var isChecked = modal.find('.color-checkbox:checked').length > 0;
        parentCheckbox.prop('checked', isChecked);
    }


    function getSelectedColors() {
        var selectedColors = [];
        $('.color-checkbox:checked').each(function() {
            selectedColors.push($(this).val());
        });
        return selectedColors;
    }


    function filterProductsByColors(selectedColors) {
        if (selectedColors.length === 0) {
            $('.products-loop').html(allProductsHtml); 
            return;
        }

        $.ajax({
            url: ajax_filter_params.ajax_url,
            type: 'POST',
            data: {
                action: 'filter_by_brand_color',
                colors: selectedColors, 
            },
            success: function(response) {
                $('.products-loop').html(response); 
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
            }
        });
    }

 
    $('.custom-modal .color-checkbox').change(function() {
        var modalId = $(this).closest('.custom-modal').attr('id');
        updateParentCheckbox(modalId);
    });

   
    $('.color-checkbox').change(function() {
        var selectedColors = getSelectedColors();
        console.log('Selected Colors:', selectedColors);
        filterProductsByColors(selectedColors);
    });
});
