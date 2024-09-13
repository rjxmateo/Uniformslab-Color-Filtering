jQuery(document).ready(function ($) {
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
    console.log("Selected Colors:", selectedColors);
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

  function updateParentCheckbox(parentCheckboxId) {
    var parentCheckbox = document.getElementById(parentCheckboxId);
    var selectAllCheckbox = document.getElementById(
      "select-all-" + parentCheckboxId.replace("color-checkbox-", "")
    );

    if (parentCheckbox) {
      var isChecked = parentCheckbox.checked;
      selectAllCheckbox.checked = isChecked;

      // Automatically check/uncheck child checkboxes
      var childCheckboxes = document.querySelectorAll(
        "#modal-" +
          parentCheckboxId.replace("color-checkbox-", "") +
          " .child-checkbox"
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

  // Make functions globally accessible if needed
  window.toggleAll = toggleAll;
  window.showModal = showModal;
  window.hideModal = hideModal;
  window.updateParentCheckbox = updateParentCheckbox;
});
