jQuery(document).ready(function($) {
    console.log('Swatches Single Product script loaded successfully.'); // Log message to confirm the script has loaded successfully
    
    // Parse the colors data from the localized script object
    var colors = JSON.parse(colorData.colors);

    // Loop through each color item and apply the corresponding colors
    colors.forEach(function(color) {
        var colorName = color.childcolor_name.toLowerCase().replace(/\s+/g, '-'); // Convert color name to lowercase and replace spaces with hyphens
        var hexColor1 = color.childcolor_hex ? '#' + color.childcolor_hex : ''; // Add the # symbol for hex color 1
        var hexColor2 = color.childcolor_hex2 ? '#' + color.childcolor_hex2 : ''; // Add the # symbol for hex color 2
        var hexColor3 = color.childcolor_hex3 ? '#' + color.childcolor_hex3 : ''; // Add the # symbol for hex color 3

        // Find the matching color item in the DOM and apply the color(s)
        var colorItem = $('.color-variable-item[data-value="' + colorName + '"]');
        if (colorItem.length > 0) {
            var span = colorItem.find('.variable-item-span-color');
            if (span.length > 0) {
                // Apply the primary hex color or a gradient of colors if available
                if (color.swatch_type === 'multicolor' && hexColor1 && hexColor2 && hexColor3) {
                    span.css('background', 'linear-gradient(to right, ' + hexColor1 + ', ' + hexColor2 + ', ' + hexColor3 + ')');
                } else if (hexColor1) {
                    span.css('background-color', hexColor1);
                }
            }
        }
    });
});
