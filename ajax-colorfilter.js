
jQuery(document).ready(function ($) {
  console.log("AJAX Color Filter script loaded successfully asadasda.");
  var allProductsHtml = $(".products-loop").html();

  function updateSelectAllCheckbox(modalId) {
    var modal = $("#" + modalId);
    var selectAllCheckbox = $(
      "#" + "select-all-" + modalId.replace("modal-", "")
    );

    // Check if all child checkboxes are checked
    var allChecked =
      modal.find(".child-checkbox").length ===
      modal.find(".child-checkbox:checked").length;
    selectAllCheckbox.prop("checked", allChecked);
  }

  function getSelectedColors() {
    var selectedColors = [];
    $(".color-checkbox:checked").each(function () {
      selectedColors.push($(this).val());
    });
    return selectedColors;
  }

  function filterProductsByColors(selectedColors) {
    if (selectedColors.length === 0) {
      $(".products-loop").html(allProductsHtml);
      return;
    }

    $.ajax({
      url: ajax_filter_params.ajax_url,
      type: "POST",
      data: {
        action: "filter_by_brand_color",
        colors: selectedColors,
      },
      success: function (response) {
        $(".products-loop").html(response);
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error:", error);
      },
    });
  }

  
  // Event delegation for checkbox changes
  $(document).on("change", ".color-checkbox", function () {
    var selectedColors = getSelectedColors();
    console.log("Selected Colors:");
    filterProductsByColors(selectedColors);
  });

  // Update 'Select All' checkbox state when a child checkbox changes
  $(".custom-modal .color-checkbox").change(function () {
    var modalId = $(this).closest(".custom-modal").attr("id");
    updateSelectAllCheckbox(modalId);
  });

  
  // Move these functions inside the document ready function
  function toggleAll(parentColor) {
    var selectAllCheckbox = document.getElementById(
      "select-all-" + parentColor
    );
    var childCheckboxes = document.querySelectorAll(
      "#modal-" + parentColor + " .child-checkbox"
    );

    childCheckboxes.forEach(function (checkbox) {
      checkbox.checked = selectAllCheckbox.checked;
    });

    // Trigger change event to update filters
    $(childCheckboxes).trigger("change");
  }

  function showModal(parentColor) {
    var modal = document.getElementById("modal-" + parentColor);
    if (modal) {
      console.log("Showing modal with ID:", "modal-" + parentColor);
      modal.style.display = "block";
    } else {
      console.error("Modal not found:", "modal-" + parentColor);
    }
  }

  function hideModal(parentColor) {
    var modal = document.getElementById("modal-" + parentColor);
    if (modal) {
      console.log("Hiding modal with ID:", "modal-" + parentColor);
      modal.style.display = "none";
    }
  }

  // Updated function to automatically check/uncheck "select all" checkbox and child checkboxes when parent color checkbox is checked/unchecked
  function updateParentCheckbox(parentCheckboxId) {
    var parentCheckbox = document.getElementById(parentCheckboxId);
    var parentColor = parentCheckboxId.replace("color-checkbox-", "");
    var selectAllCheckbox = document.getElementById(
      "select-all-" + parentColor
    );

    if (parentCheckbox) {
      var isChecked = parentCheckbox.checked;

      // Check/uncheck the "select all" checkbox
      selectAllCheckbox.checked = isChecked;

      // Automatically check/uncheck all child checkboxes
      var childCheckboxes = document.querySelectorAll(
        "#modal-" + parentColor + " .child-checkbox"
      );
      childCheckboxes.forEach(function (checkbox) {
        checkbox.checked = isChecked;
      });

      // Trigger change event to update filters
      $(childCheckboxes).trigger("change");
    }
  }

  // Attach the window.onclick event handler inside the document ready function
  $(window).on("click", function (event) {
    var modals = document.querySelectorAll(".custom-modal");
    modals.forEach(function (modal) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    });
  });


  var page = 1;
  var loading = false; // Flag to prevent multiple requests

  

  jQuery(document).on('click', 'a.page-numbers', function (e) {
    e.preventDefault(); // Prevent the default link behavior
    
    var href = jQuery(this).attr('href');
    var pagedMatch = href.match(/paged=(\d+)/);
    var paged = pagedMatch ? pagedMatch[1] : 1;
    var selectedColors = getSelectedColors(); // Get selected colors from your filter form or UI
  
    console.log("Pagination link clicked. Page:", paged, "Selected Colors:", selectedColors);
  
    var data = {
      action: 'filter_by_brand_color',
      paged: paged,
      colors: selectedColors
    };
  
    jQuery.post(ajax_filter_params.ajax_url, data, function (response) {
  
      jQuery('.products-loop').html(response);
    }).fail(function (xhr, status, error) {
      console.error("Pagination AJAX Error:", error);
    });
  });

  //For the pagination of results
  

  // Make functions globally accessible if needed
  window.toggleAll = toggleAll;
  window.showModal = showModal;
  window.hideModal = hideModal;
  window.updateParentCheckbox = updateParentCheckbox;
});
