<div id="sidebarfilter" class="shop-filters flex-shrink-0 border-end d-block py-4">

  <?php
    $shop_url = esc_url(wc_get_page_permalink('shop'));
    $current_url = home_url(add_query_arg(array(), $_SERVER['REQUEST_URI']));
    $is_active = strpos($current_url, $shop_url) === 0;
    ?>

  <li class="list-group-item border-0 p-0 mx-4 mb-2">
    <a href="<?php echo $shop_url; ?>"
      class="d-flex align-items-center gap-6 list-group-item-action text-dark px-3 py-6 rounded-1 <?php echo $is_active ? 'active' : ''; ?>">
      <i class="ti ti-circles fs-5"></i>
      All Products
    </a>
  </li>


  <!-- Filter by Category -->
  <ul class="list-group pt-2 border-bottom rounded-0" id="categoryList">
    <h6 class="my-3 mx-4 fw-semibold" id="filterTitle">Filter by Category</h6>

    <?php
        $product_categories = get_terms(array(
            'taxonomy' => 'product_cat',
            'hide_empty' => false,
        ));

        $categories_by_parent = array();

        foreach ($product_categories as $category) {
            $categories_by_parent[$category->parent][] = $category;
        }

        // Define icons for specific categories
        $category_icons = array(
            'uncategorized'           => 'ti ti-question-mark fs-5',
            'accessories'             => 'ti ti-hanger fs-5',
            'clothing'                => 'ti ti-hanger-2 fs-5',
            'decor'                   => 'ti ti-question-mark fs-5',
            'hoodies'                 => 'ti ti-clothes-rack fs-5',
            'music'                   => 'ti ti-music fs-5',
            'tshirts'                 => 'ti ti-shirt fs-5',
            't-shirt'                 => 'ti ti-shirt fs-5',
            '1-2-1-4-zip'             => 'ti ti-zip fs-5',
            '3-in-1'                  => 'ti ti-refresh fs-5',
            'activewear'              => 'ti ti-run fs-5',
            'aprons'                  => 'ti ti-chef-hat fs-5',
            'athletic-warm-ups'       => 'ti ti-run fs-5',
            'backpacks'               => 'ti ti-backpack fs-5',
            'briefcases-messengers'   => 'ti ti-briefcase fs-5',
            'camp-shirts'             => 'ti ti-shirt fs-5',
        );

        function render_category_list($categories, $categories_by_parent, $batch_size, &$index)
        {
            global $category_icons;
            foreach ($categories as $category) {
                $category_link = get_term_link($category);
                if (is_wp_error($category_link)) {
                    continue;
                }

                $category_slug = $category->slug;
                $category_name = esc_html($category->name);
                $icon_class = isset($category_icons[$category_slug]) ? $category_icons[$category_slug] : 'ti ti-point fs-5'; // Default icon
                $hidden_class = $index >= $batch_size ? 'd-none' : '';

                // Check if the category has children
                $has_children = isset($categories_by_parent[$category->term_id]);
                ?>
    <li class="list-group-item border-0 p-0 mx-4 mb-2 category-item <?php echo $hidden_class; ?>">
      <a href="<?php echo esc_url($category_link); ?>"
        class="d-flex align-items-center gap-6 list-group-item-action text-dark px-3 py-6 rounded-1">
        <i class="<?php echo esc_attr($icon_class); ?>"></i> <!-- Category-specific icon -->
        <?php echo $category_name; ?>
        <?php if ($has_children): ?>
        <i class="dropdown-toggle ms-auto"></i> <!-- Dropdown arrow for parent categories with children -->
        <?php endif; ?>
      </a>

      <?php if ($has_children): ?>
      <ul class="list-group child-category-list d-none">
        <?php
                            render_category_list($categories_by_parent[$category->term_id], $categories_by_parent, $batch_size, $index);
                            ?>
      </ul>
      <?php endif; ?>
    </li>
    <?php
                $index++;
            }
        }

        $batch_size = 5;
        $index = 0;
        render_category_list($categories_by_parent[0], $categories_by_parent, $batch_size, $index);
    ?>

    <?php if (count($product_categories) > $batch_size) : ?>
    <a id="showMoreBtn" class="underline mx-4 my-2 text-center cursor-pointer" role="button">Show More</a>
    <?php endif; ?>
  </ul>






  <!-- Sort By -->
  <ul class="list-group pt-2 border-bottom rounded-0" id="sortList">
    <h6 class="my-3 mx-4 fw-semibold" id="filterTitle">Sort By</h6>
    <?php
        $current_url = home_url(add_query_arg(null, null));
        ?>
    <li class="list-group-item border-0 p-0 mx-4 mb-2">
      <a href="<?php echo esc_url(add_query_arg('orderby', 'date', $current_url)); ?>"
        class="d-flex align-items-center gap-6 list-group-item-action text-dark px-3 py-6 rounded-1"><i
          class="ti ti-timeline fs-5"></i>Newest</a>
    </li>
    <li class="list-group-item border-0 p-0 mx-4 mb-2">
      <a href="<?php echo esc_url(add_query_arg('orderby', 'price', $current_url)); ?>"
        class="d-flex align-items-center gap-6 list-group-item-action text-dark px-3 py-6 rounded-1"><i
          class="ti ti-tag fs-5"></i>Price: Low-High</a>
    </li>
    <li class="list-group-item border-0 p-0 mx-4 mb-2">
      <a href="<?php echo esc_url(add_query_arg('orderby', 'price-desc', $current_url)); ?>"
        class="d-flex align-items-center gap-6 list-group-item-action text-dark px-3 py-6 rounded-1"><i
          class="ti ti-tag-off fs-5"></i>Price: High-Low</a>
    </li>
    <li class="list-group-item border-0 p-0 mx-4 mb-2">
      <a href="<?php echo esc_url(add_query_arg('orderby', 'rating', $current_url)); ?>"
        class="d-flex align-items-center gap-6 list-group-item-action text-dark px-3 py-6 rounded-1"><i
          class="ti ti-graph fs-5"></i>Rating</a>
    </li>
    <li class="list-group-item border-0 p-0 mx-4 mb-2">
      <a href="<?php echo esc_url(add_query_arg('orderby', 'popularity', $current_url)); ?>"
        class="d-flex align-items-center gap-6 list-group-item-action text-dark px-3 py-6 rounded-1"><i
          class="ti ti-chart-area-line fs-5"></i>Popularity</a>
    </li>
  </ul>


  <!-- By Pricing -->
  <div class="by-price border-bottom rounded-0">
    <h6 class="mt-4 mb-3 mx-4 fw-semibold" id="filterTitle">Filter by Price</h6>
    <div style="max-width:200px;margin:auto;margin-top:30px">
      <?php echo do_shortcode('[facetwp facet="price_range"]'); ?>
    </div>

  </div>


  <?php
    // Sidebar filter for color

    // JSON file
    $json_file_path = get_template_directory() . '/woocommerce/ulab_lookup_colors.json';


    // Read and decode the JSON file
    $json_data = file_get_contents($json_file_path);
    $colors_data = json_decode($json_data, true); // Decode JSON into an associative array

    $parent_colors = [];

    foreach ($colors_data as $color) {
        $parent_color_name = $color['parentcolor_name'];
        $child_color_name = $color['childcolor_name'];
        $child_color_hex = $color['childcolor_hex'];

        // Add child color details to the parent color mapping
        if (!isset($parent_colors[$parent_color_name])) {
            $parent_colors[$parent_color_name] = [];
        }

        $parent_colors[$parent_color_name][$child_color_name] = [
            'name' => $child_color_name,
            'hex' => $child_color_hex,
            'sku' => $color['childcolor_sku'],
            'swatch_filename' => $color['swatch_filename']
        ];
    }

  ?>

  <?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>



  <ul class="list-group pt-2 border-bottom rounded-0" id="sortColor">
    <?php foreach ($parent_colors as $parent_color => $details): ?>
    <li class="list-group-item border-0 p-0 mx-4 mb-2 color-item">
      <!-- Trigger modal to show child colors -->
      <div class="d-flex align-items-center gap-6 list-group-item-action text-dark px-3 py-6 rounded-1" role="button"
        onclick="showModal('<?php echo esc_attr(strtolower($parent_color)); ?>')">
        <input type="checkbox" class="color-checkbox" name="<?php echo esc_attr(strtolower($parent_color)); ?>"
          value="<?php echo esc_attr(strtolower($parent_color)); ?>"
          id="color-checkbox-<?php echo esc_attr(strtolower($parent_color)); ?>">

        <span class="color-swatch" style="background-color: <?php echo esc_attr($parent_color); ?>;"></span>
        <span class="color-name"><?php echo esc_html($parent_color); ?></span>
      </div>
    </li>

    <!-- Modal for child colors under the parent color -->
    <div class="custom-modal" id="modal-<?php echo esc_attr(strtolower($parent_color)); ?>">
      <div class="modal-content">
        <span class="close" onclick="hideModal('<?php echo esc_attr(strtolower($parent_color)); ?>')">&times;</span>
        <div class="modal-header">
          <!-- <h5 class="modal-title">Select Colors</h5> -->
          <input type="checkbox" id="select-all-<?php echo esc_attr(strtolower($parent_color)); ?>"
            onclick="toggleAll('<?php echo esc_attr(strtolower($parent_color)); ?>')" />
          <label for="select-all-<?php echo esc_attr(strtolower($parent_color)); ?>">Select All</label>
        </div>
        <div class="color-grid">
          <?php foreach ($details as $child_color): ?>
          <div class="color-item">
            <input type="checkbox" class="color-checkbox child-checkbox" name="filter_colors[]"
              value="<?php echo esc_attr($child_color['name']); ?>">
            <span class="color-swatch"
              style="background-color: <?php echo esc_attr('#' . $child_color['hex']); ?>;"></span>
            <span class="color-name"><?php echo esc_html($child_color['name']); ?></span>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </ul>

  <div class="p-4">
    <a href="<?php echo esc_url($shop_url); ?>" class="btn btn-primary w-100 text-white">Reset Filters</a>
  </div>



</div>






<style>
/*
Modal for the color swatch
*/

.custom-modal {
  display: none;
  position: fixed;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  z-index: 1000;
}

.modal-content {
  position: relative;
  background-color: #fff;
  margin: 15% auto;
  padding: 40px;
  border: 1px solid #888;
  max-width: 600px;
}

.close {
  position: absolute;
  color: #aaa;
  right: 10px;
  top: -5px;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}

.color-checkbox {
  width: 20px;
  height: 20px;
  margin-right: 10px;
}

.color-swatch {
  border-radius: 50%;
  width: 20px;
  height: 20px;
  display: inline-block;
  margin-right: 10px;

}

.color-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  /* Creates 3 equal-width columns */
  gap: 1rem;
  /* Adds space between grid items */
  padding: 0;
  list-style: none;
}

.color-item {
  margin: 0;
  /* Removes any default margin */
}

.color-grid a {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  text-decoration: none;
}
</style>


<script>
/*
Js for color swatch
*/

function showModal(modalId) {
  var modal = document.getElementById('modal-' + modalId);
  if (modal) {
    modal.style.display = 'block';
  }
}

function hideModal(modalId) {
  var modal = document.getElementById('modal-' + modalId);
  if (modal) {
    modal.style.display = 'none';
  }
}

// Close modal when clicking outside of it
window.onclick = function(event) {
  var modals = document.getElementsByClassName('custom-modal');
  for (var i = 0; i < modals.length; i++) {
    if (event.target == modals[i]) {
      modals[i].style.display = 'none';
    }
  }
}















// Own codeeee ----------------------------
document.addEventListener('DOMContentLoaded', function() {
  // Function to handle parent color checkbox change
  function handleParentCheckboxChange(event) {
    const parentColor = event.target.value;
    const isChecked = event.target.checked;

    // Get the modal element related to the parent color
    const modalId = `modal-${parentColor}`;
    const modal = document.getElementById(modalId);

    if (modal) {
      // Find the select-all checkbox and child checkboxes within the modal
      const selectAllCheckbox = modal.querySelector(`#select-all-${parentColor}`);
      const childCheckboxes = modal.querySelectorAll('.child-checkbox');

      if (selectAllCheckbox) {
        selectAllCheckbox.checked = isChecked;

        // Check or uncheck all child checkboxes based on the parent checkbox
        childCheckboxes.forEach(function(childCheckbox) {
          childCheckbox.checked = isChecked;
        });
      }
    }
  }

  // Function to handle select-all checkbox change
  function handleSelectAllCheckboxChange(event) {
    const selectAllCheckbox = event.target;
    const parentColor = selectAllCheckbox.id.split('-')[2];
    const isChecked = selectAllCheckbox.checked;

    // Get the modal element related to the parent color
    const modalId = `modal-${parentColor}`;
    const modal = document.getElementById(modalId);

    if (modal) {
      // Find parent color checkbox
      const parentCheckbox = document.querySelector(`.color-checkbox[value="${parentColor}"]`);

      // Find child checkboxes within the modal
      const childCheckboxes = modal.querySelectorAll('.child-checkbox');

      // Check or uncheck all child checkboxes based on the select-all checkbox
      childCheckboxes.forEach(function(childCheckbox) {
        childCheckbox.checked = isChecked;
      });

      // Uncheck parent color checkbox if select-all is unchecked
      if (parentCheckbox && !isChecked) {
        parentCheckbox.checked = false;
      }
    }
  }

  // Attach event listeners to parent color checkboxes
  document.querySelectorAll('.color-checkbox').forEach(function(checkbox) {
    checkbox.addEventListener('change', handleParentCheckboxChange);
  });

  // Attach event listeners to select-all checkboxes
  document.querySelectorAll('.modal-content .select-all').forEach(function(selectAllCheckbox) {
    selectAllCheckbox.addEventListener('change', handleSelectAllCheckboxChange);
  });
});

























document.addEventListener('DOMContentLoaded', () => {
  // Function to handle the "Select All" checkbox
  function toggleAll(parentColor) {
    const selectAllCheckbox = document.querySelector(`#select-all-${parentColor}`);
    const childCheckboxes = document.querySelectorAll(`#modal-${parentColor} .child-checkbox`);
    const parentCheckbox = document.querySelector(`#color-checkbox-${parentColor}`);

    // Toggle all child checkboxes based on "Select All" checkbox state
    childCheckboxes.forEach(checkbox => {
      checkbox.checked = selectAllCheckbox.checked;
    });

    // Set the parent checkbox state to match the "Select All" checkbox state
    parentCheckbox.checked = selectAllCheckbox.checked;
  }

  // Function to handle changes in child checkboxes
  function handleChildCheckboxChange(event) {
    const parentColor = event.target.closest('.custom-modal').id.replace('modal-', '');
    const parentCheckbox = document.querySelector(`#color-checkbox-${parentColor}`);
    const childCheckboxes = document.querySelectorAll(`#modal-${parentColor} .child-checkbox`);

    // Ensure parent checkbox remains checked if any child checkbox is checked
    if (Array.from(childCheckboxes).some(checkbox => checkbox.checked)) {
      parentCheckbox.checked = true;
    } else {
      parentCheckbox.checked = false;
    }
  }

  // Attach change event listeners to child checkboxes
  document.querySelectorAll('.child-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', handleChildCheckboxChange);
  });

  // Attach click event listeners to "Select All" checkboxes
  document.querySelectorAll('[id^="select-all-"]').forEach(checkbox => {
    checkbox.addEventListener('click', (event) => {
      const parentColor = event.target.id.replace('select-all-', '');
      toggleAll(parentColor);
    });
  });
});
</script>




<style>
.active {
  background-color: var(--bs-primary);
  color: var(--bs-white) !important;
}

.active:hover {
  background-color: var(--bs-primary) !important;
  color: var(--bs-white) !important;
}

.d-flex-important {
  display: flex !important;
}

#sidebarfilter {
  max-width: 300px
}

@media only screen and (max-width: 767px) {
  .shop-filters {
    position: fixed;
    padding: 16px;
    width: 300px;
    left: -100%;
    z-index: 99;
    height: 100%;
    top: 0px;
    background-color: white;
    overflow-x: hidden;
    transition: left 0.5s;
  }




}
</style>

<script>
function openSidebarFilter() {
  document.getElementById("sidebarfilter").style.left = "0";
  document.getElementById("overlay").classList.remove("d-none");


}

function closeSidebarFilter() {
  document.getElementById("sidebarfilter").style.left = "-100%";
  document.getElementById("overlay").classList.add("d-none");

}

document.getElementById("overlay").addEventListener("click", function() {
  closeSidebarFilter();
  closeNav()
});
</script>


<script>
document.addEventListener('DOMContentLoaded', function() {

  //Active Class on Filtering
  function setActiveCategory() {
    const currentUrl = new URL(window.location.href);
    const currentPath = currentUrl.pathname;
    console.log(currentUrl);
    const categoryLinks = document.querySelectorAll('#categoryList .category-item a');


    categoryLinks.forEach(link => {
      const linkUrl = new URL(link.href);
      const linkPath = linkUrl.pathname;

      if (linkPath === currentPath) {
        link.classList.add('active');
      } else {
        link.classList.remove('active');
      }
    });

    moveActiveToTop('#categoryList');
  }

  function setActiveSort() {
    const currentUrl = new URL(window.location.href);
    const currentPath = currentUrl.pathname;
    const currentOrderby = currentUrl.searchParams.get('orderby');


    const sortList = document.getElementById('sortList');

    const sortLinks = sortList.querySelectorAll('li a');

    sortLinks.forEach(link => {
      const linkUrl = new URL(link.href);
      const linkPath = linkUrl.pathname;
      const linkOrderby = linkUrl.searchParams.get('orderby');


      if (linkPath === currentPath && linkOrderby === currentOrderby) {
        link.classList.add('active');
      } else {
        link.classList.remove('active');
      }
    });
    moveActiveToTop('#sortList');
  }

  function setActiveColorFilter() {
    const currentUrl = new URL(window.location.href);
    const currentColor = currentUrl.searchParams.get('filter_color');

    const colorFilterList = document.getElementById('sortColor');

    const colorFilterLinks = colorFilterList.querySelectorAll('li a');


    colorFilterLinks.forEach(link => {
      const linkUrl = new URL(link.href);
      const linkColor = linkUrl.searchParams.get('filter_color');

      if (linkColor === currentColor) {
        link.classList.add('active');
      } else {
        link.classList.remove('active');
      }
    });
    moveActiveToTop('#sortColor');
  }

  function moveActiveToTop(listId) {
    const list = document.querySelector(listId);
    if (!list) return;

    const header = list.querySelector('h6');
    if (!header) return;

    // Find all active items, including those in nested lists
    const activeItems = Array.from(list.querySelectorAll('li a.active'))
      .map(activeLink => activeLink.closest('li')); // Use closest to get the li element

    // Remove active items from their original positions
    activeItems.forEach(item => item.remove());

    // Insert active items after the header
    activeItems.forEach(item => {
      list.insertBefore(item, header.nextElementSibling);
      item.classList.remove('d-none'); // Ensure the item is visible
    });
  }


  setActiveSort();
  setActiveCategory();
  setActiveColorFilter();

  // const listItems = document.querySelectorAll('li');
  //     listItems.forEach(item => {
  //         const link = item.querySelector('a');
  //         if (link && link.classList.contains('active')) {
  //             item.classList.add('d-flex-important');
  //         }
  // });

});
</script>




<script>
// Show More Button
const batchSize = <?php echo $batch_size; ?>;
let currentBatch = 1;

document.getElementById('showMoreBtn').addEventListener('click', function() {
  const categories = document.querySelectorAll('.category-item.d-none');
  const end = currentBatch * batchSize + batchSize;

  for (let i = 0; i < end && i < categories.length; i++) {
    categories[i].classList.remove('d-none');
  }

  currentBatch++;

  if (currentBatch * batchSize >= categories.length) {
    this.style.display = 'none';
  }
});
</script>
