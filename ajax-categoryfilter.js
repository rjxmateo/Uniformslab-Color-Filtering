jQuery(document).ready(function ($) {
  console.log("Category dropdown script loaded successfully.");

  // Handle click on parent categories to toggle dropdown
  $("#categoryList").on("click", ".category-item > a", function (e) {
    var $parentItem = $(this).closest("li");
    var $childList = $parentItem.find(".child-category-list");

    if ($childList.length > 0) {
      e.preventDefault(); // Prevent the default link behavior
      $childList.toggleClass("d-none"); // Toggle dropdown visibility

      // Optionally, toggle dropdown arrow direction (if using an arrow icon)
      $(this).find(".dropdown-toggle").toggleClass("expanded");
    }
  });

  // Handle AJAX request for category filter
  $("#category-filter").change(function () {
    var categorySlug = $(this).val(); // Get selected category slug

    console.log("Selected category slug:", categorySlug); // Log the selected category

    $.ajax({
      url: ajaxurl, // URL for the AJAX request
      type: "POST",
      data: {
        action: "filter_by_category",
        category_slug: categorySlug,
      },
      success: function (response) {
        console.log("AJAX response:", response); // Log the response from the server
        $("#product-list").html(response); // Update the product list container
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log("AJAX request failed:", textStatus, errorThrown); // Log errors if the request fails
      },
    });
  });

  // Handle "Show More" functionality
  $("#showMoreBtn").on("click", function () {
    $(".category-item.d-none").removeClass("d-none");
    $(this).remove(); // Remove the "Show More" button after expanding
  });
});
