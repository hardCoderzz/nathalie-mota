let currentPage = 1;
let selectedCategory;
let selectedSortOrder;
let selectedFormat;

jQuery('.category-list li').on('click', function () {
    currentPage = 1;
    selectedCategory = jQuery(this).data('category');
    loadMorePosts(true); // true indique qu'il s'agit d'un nouveau chargement de catégorie
});

jQuery('.format-list li').on('click', function () {
    currentPage = 1;
    selectedFormat = jQuery(this).data('format');
    loadMorePosts(true);
});

jQuery('.sort-order-list li').on('click', function () {
    currentPage = 1;
    selectedSortOrder = jQuery(this).data('sort-order');
    loadMorePosts(true);
});


jQuery('#load-more').on('click', function () {
    currentPage++;
    loadMorePosts();
});

function loadMorePosts(isNewCategoryOrSortOrFormat = false) {
    if (document.querySelector('.sort-order h3').innerHTML != 'Trier') {
        selectedSortOrder = document.querySelector('.sort-order h3').innerHTML.toUpperCase();
    }

    jQuery.ajax({
        type: 'POST',
        url: 'http://localhost/Projet-11/wp-admin/admin-ajax.php',
        dataType: 'json',
        data: {
            action: 'photos_load_more',
            paged: currentPage,
            category: selectedCategory,
            format: selectedFormat,
            sortOrder: selectedSortOrder ? selectedSortOrder : 'DESC',
        },
        success: function (data) {
            if (isNewCategoryOrSortOrFormat || currentPage === 1) {
                jQuery('.photos-wrapper').html(data.html);
            } else {
                jQuery('.photos-wrapper').append(data.html);
            }

            const currentDisplayedPosts = jQuery('.photos-wrapper').children().length;
            if (currentDisplayedPosts >= data.total_posts) {
                jQuery('#load-more').hide();
                jQuery('.btn__wrapper').css('margin-bottom', '0');
            } else {
                jQuery('#load-more').show();
                jQuery('.btn__wrapper').css('margin-bottom', '1.5em');
            }
        }
    });
}
