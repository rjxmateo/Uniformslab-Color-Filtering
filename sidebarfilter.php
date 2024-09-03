<div id="sidebarfilter" class="shop-filters flex-shrink-0 border-end d-block py-4">
<?php echo do_shortcode('[facetwp facet="colors"]'); ?>

    <?php 
        $shop_url = esc_url( wc_get_page_permalink( 'shop' ) );
        $current_url = home_url( add_query_arg( array(), $_SERVER['REQUEST_URI'] ) );
        $is_active = strpos($current_url, $shop_url) === 0;
    ?>

    <li class="list-group-item border-0 p-0 mx-4 mb-2">
        <a href="<?php echo $shop_url; ?>" class="d-flex align-items-center gap-6 list-group-item-action text-dark px-3 py-6 rounded-1 <?php echo $is_active ? 'active' : ''; ?>"><i class="ti ti-circles fs-5"></i>All Products</a>
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

    function get_parent_category_slug_from_url() {
        $current_url = $_SERVER['REQUEST_URI'];
        $parts = explode('/', trim($current_url, '/'));
        // Adjust index based on your URL structure
        return isset($parts[1]) ? $parts[1] : '';
    }

    $parent_category_slug = get_parent_category_slug_from_url();

    function render_category_list($categories, $categories_by_parent, $batch_size, &$index, $parent_category_slug) {
        foreach ($categories as $category) {
            $category_link = get_term_link($category);
            if (is_wp_error($category_link)) {
                continue;
            }
    
            $category_slug = $category->slug;
            $category_icons = array(
                'uncategorized'           => 'ti ti-question-mark fs-5',
                'accessories'             => 'ti ti-hanger fs-5',
                'clothing'                => 'ti ti-hanger-2 fs-5',
                'decor'                   => 'ti ti-question-mark fs-5',
                'hoodies'                 => 'ti ti-clothes-rack fs-5',
                'music'                   => 'ti ti-music fs-5',
                'tshirts'                 => 'ti ti-shirt fs-5',
                't-shirt'                 => 'ti ti-shirt fs-5', // Same icon as 'tshirts'
                '1-2-1-4-zip'             => 'ti ti-zip fs-5',
                '3-in-1'                  => 'ti ti-refresh fs-5',
                'activewear'              => 'ti ti-run fs-5',
                'aprons'                  => 'ti ti-chef-hat fs-5',
                'athletic-warm-ups'       => 'ti ti-run fs-5',
                'backpacks'               => 'ti ti-backpack fs-5',
                'briefcases-messengers'   => 'ti ti-briefcase fs-5',
                'camp-shirts'             => 'ti ti-shirt fs-5',
            );
    
            $icon_class = isset($category_icons[$category_slug]) ? $category_icons[$category_slug] : 'ti ti-point fs-5';
            $hidden_class = $index >= $batch_size ? 'd-none' : '';
    
            ?>
            <li class="list-group-item border-0 p-0 mx-4 mb-2 category-item <?php echo $hidden_class; ?>">
          
                <a href="<?php echo esc_url($category_link); ?>" class="d-flex align-items-center gap-6 list-group-item-action text-dark px-3 py-6 rounded-1">
                    <i class="<?php echo esc_attr($icon_class); ?>"></i>
                    <?php echo esc_html($category->name); ?>
                </a>
                
                <?php if (isset($categories_by_parent[$category->term_id])): ?>
                    <ul class="list-group">
                        <?php
                        render_category_list($categories_by_parent[$category->term_id], $categories_by_parent, $batch_size, $index, $parent_category_slug);
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
    render_category_list($categories_by_parent[0], $categories_by_parent, $batch_size, $index, $parent_category_slug);
    ?>

    <?php if (count($product_categories) > $batch_size) : ?>
        <a id="showMoreBtn" class="underline mx-4 my-2 text-center cursor-pointer" role="button">Show More</a>
    <?php endif; ?>
</ul>




    <!-- Sort By -->
    <ul class="list-group pt-2 border-bottom rounded-0" id="sortList">
    <h6 class="my-3 mx-4 fw-semibold" id="filterTitle">Sort By</h6>
    <?php
    $current_url = home_url( add_query_arg( null, null ) );
    ?>
        <li class="list-group-item border-0 p-0 mx-4 mb-2">
            <a href="<?php echo esc_url( add_query_arg( 'orderby', 'date', $current_url ) ); ?>" class="d-flex align-items-center gap-6 list-group-item-action text-dark px-3 py-6 rounded-1"><i class="ti ti-timeline fs-5"></i>Newest</a>
        </li>
        <li class="list-group-item border-0 p-0 mx-4 mb-2">
            <a href="<?php echo esc_url( add_query_arg( 'orderby', 'price', $current_url ) ); ?>" class="d-flex align-items-center gap-6 list-group-item-action text-dark px-3 py-6 rounded-1"><i class="ti ti-tag fs-5"></i>Price: Low-High</a>
        </li>
        <li class="list-group-item border-0 p-0 mx-4 mb-2">
            <a href="<?php echo esc_url( add_query_arg( 'orderby', 'price-desc', $current_url ) ); ?>" class="d-flex align-items-center gap-6 list-group-item-action text-dark px-3 py-6 rounded-1"><i class="ti ti-tag-off fs-5"></i>Price: High-Low</a>
        </li>
        <li class="list-group-item border-0 p-0 mx-4 mb-2">
            <a href="<?php echo esc_url( add_query_arg( 'orderby', 'rating', $current_url ) ); ?>" class="d-flex align-items-center gap-6 list-group-item-action text-dark px-3 py-6 rounded-1"><i class="ti ti-graph fs-5"></i>Rating</a>
        </li>
        <li class="list-group-item border-0 p-0 mx-4 mb-2">
            <a href="<?php echo esc_url( add_query_arg( 'orderby', 'popularity', $current_url ) ); ?>" class="d-flex align-items-center gap-6 list-group-item-action text-dark px-3 py-6 rounded-1"><i class="ti ti-chart-area-line fs-5"></i>Popularity</a>
        </li>
    </ul>

    <!-- By Gender -->
    <!-- <div class="by-gender border-bottom rounded-0">
        <h6 class="mt-4 mb-3 mx-4 fw-semibold" id="filterTitle">By Gender</h6>
        <div class="pb-4 px-4">
            <div class="form-check py-2 mb-0">
                <input class="form-check-input" type="radio" name="gender" id="genderAll" value="all" <?php checked( 'all', get_query_var('gender') ); ?>>
                <label class="form-check-label" for="genderAll">All</label>
            </div>
        </div>
    </div> -->

    <!-- By Pricing -->
    <div class="by-price border-bottom rounded-0">
        <h6 class="mt-4 mb-3 mx-4 fw-semibold" id="filterTitle">Filter by Price</h6>
        <div style="max-width:200px;margin:auto;margin-top:30px">
            <?php echo do_shortcode('[facetwp facet="price_range"]'); ?>
        </div>
        
    </div>

<!-- By Colors -->
    <ul class="list-group pt-2 border-bottom rounded-0" id="sortColor">
        <h6 class="my-3 mx-4 fw-semibold" id="filterTitle">Filter by Color</h6>
  	<?php echo do_shortcode('[facetwp facet="colors"]'); ?>
      </ul>
 
  

    <div class="p-4">
        <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn btn-primary w-100 text-white">Reset Filters</a>
    </div>

	<!-- By Colors -->
<?php
// Get the category ID from the URL
$category_slug = get_query_var('product_cat');
$category = get_term_by('slug', $category_slug, 'product_cat');
$category_id = $category ? $category->term_id : 0;

// Get all products if no category is selected, otherwise get products from the selected category
$args = array(
    'post_type' => 'product',
    'posts_per_page' => -1,
);

if ($category_id) {
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'product_cat',
            'field' => 'term_id',
            'terms' => $category_id,
        ),
    );
}

$products = get_posts($args);

// Collect color terms associated with these products
$colors_in_category = array();
foreach ($products as $product) {
    $product_colors = get_the_terms($product->ID, 'pa_brand-color');
    if (!empty($product_colors) && !is_wp_error($product_colors)) {
        foreach ($product_colors as $color) {
            $colors_in_category[$color->term_id] = $color;
        }
    }
}

// Check if there are any color terms
if (!empty($colors_in_category)) {
    $batch_size = 5;
    $total_terms = count($colors_in_category);
    $index = 0;
    ?>

<ul class="list-group pt-2 border-bottom rounded-0" id="sortColor">
    <h6 class="my-3 mx-4 fw-semibold" id="filterTitle">Filter by Color</h6>
    <?php
    // Define parent colors and their corresponding child colors
    $parent_colors = [
        'Black' => ['Black'],
        'Blue' => ['Blue', 'Light Blue', 'Navy'],
        'Brown' => ['Brown'],
        'Green' => ['Green'],
        'Grey' => ['Grey'],
        'Maroon' => ['Maroon'],
        'Natural' => ['Natural'],
        'Orange' => ['Orange'],
        'Pink' => ['Pink'],
        'Purple' => ['Purple'],
        'Red' => ['Red'],
        'Teal' => ['Teal'],
        'Turquoise' => ['Turquoise'],
        'White' => ['White'],
        'Yellow' => ['Yellow']
    ];

    // Initialize an array to store colors grouped by parent color
    $colors_grouped_by_parent = [];

    // Group the colors by parent
    foreach ($colors_in_category as $term) {
        $found_parent = false;
        foreach ($parent_colors as $parent_color => $children) {
            if (in_array($term->name, $children)) {
                $colors_grouped_by_parent[$parent_color][] = $term;
                $found_parent = true;
                break;
            }
        }

        // If the color is not explicitly mapped, categorize it under "Others"
        if (!$found_parent) {
            $colors_grouped_by_parent['Others'][] = $term;
        }
    }

    // Display only the parent colors initially
    foreach ($colors_grouped_by_parent as $parent_color => $child_colors) {
        ?>
        <li class="list-group-item border-0 p-0 mx-4 mb-2 color-item">
            <!-- Trigger modal to show child colors -->
            <a href="#" class="d-flex align-items-center gap-6 list-group-item-action text-dark px-3 py-6 rounded-1"
               onclick="showModal('<?php echo esc_attr(strtolower($parent_color)); ?>')">
                <span class="color-name"><?php echo esc_html($parent_color); ?></span>
            </a>
        </li>

        <!-- Modal for child colors under the parent color -->
        <div class="custom-modal" id="modal-<?php echo esc_attr(strtolower($parent_color)); ?>">
            <div class="custom-modal-content">
                <span class="close" onclick="hideModal('<?php echo esc_attr(strtolower($parent_color)); ?>')">&times;</span>
                <h5>Choose a Shade of <?php echo esc_html($parent_color); ?></h5>
                <ul class="list-group">
                    <?php foreach ($child_colors as $child_color) {
                        // Generate the filtered URL and swatch HTML for each child color
                        $current_url = home_url(add_query_arg(array()));
                        $filtered_url = add_query_arg('filter_color', $child_color->slug, $current_url);
                        $swatch_html = apply_filters('woocommerce_color_swatch_html', '', $child_color);
                        ?>
                        <li class="list-group-item">
                            <a href="<?php echo esc_url($filtered_url); ?>" class="d-flex align-items-center gap-6 list-group-item-action text-dark px-3 py-6 rounded-1">
                                <?php echo $swatch_html; ?>
                                <span class="color-name"><?php echo esc_html($child_color->name); ?></span>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    <?php } ?>

    <?php if ($total_terms > $batch_size) : ?>
        <a id="showMoreColorBtn" class="underline mx-4 my-2 text-center cursor-pointer fs" role="button">Show More</a>
    <?php endif; ?>
</ul>

  
<?php
}
?>

    <script>
        // Show More Button for Colors
        const colorBatchSize = <?php echo $batch_size; ?>;
        let currentColorBatch = 1;

        document.getElementById('showMoreColorBtn').addEventListener('click', function () {
            const colors = document.querySelectorAll('.color-item.d-none');
            const end = currentColorBatch * colorBatchSize + colorBatchSize;

            for (let i = 0; i < end && i < colors.length; i++) {
                colors[i].classList.remove('d-none');
            }
 
            currentColorBatch++;

            if (currentColorBatch * colorBatchSize >= colors.length) {
                this.style.display = 'none';
            }
        });
    </script>
  


    <div class="p-4">
        <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn btn-primary w-100 text-white">Reset Filters</a>
    </div>


</div>



#Modal for the color swatch
<style>

.custom-modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Black background with opacity */
    z-index: 1000; /* Sit on top */
}

.custom-modal-content {
    background-color: #fff;
    margin: 15% auto; /* 15% from the top and centered */
    padding: 20px;
    border: 1px solid #888;
    width: 80%; /* Could be more or less, depending on screen size */
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}



</style>

#Js for color swatch

<script>
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
</script>




<style>
    .active {
    background-color: var(--bs-primary); 
    color:var(--bs-white) !important;
    }

    .active:hover {
        background-color: var(--bs-primary) !important;  
    color:var(--bs-white) !important;
    }

    .d-flex-important {
        display: flex !important;
    }

#sortColor{
margin-left:24px;
margin-right:24px
}
	
#sidebarfilter{
max-width:300px
}
   
@media only screen and (max-width: 767px){
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




<script>

   
    // Function to apply the filter and update the URL
    function applyFilter() {
        const min = rangeMin.value;
        const max = rangeMax.value;
        const url = new URL(window.location.href);

        url.searchParams.set('min_price', min);
        url.searchParams.set('max_price', max);

        window.location.href = url.toString();
    }

  
</script>
