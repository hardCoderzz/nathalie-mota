let currentPage = 1;
let selectedCategory;

jQuery('.category-list li').on('click', function () {
    currentPage = 1;
    selectedCategory = jQuery(this).data('category');
    loadMorePosts(true); // true indique qu'il s'agit d'un nouveau chargement de catégorie
});

jQuery('#load-more').on('click', function () {
    currentPage++;
    loadMorePosts();
});

function loadMorePosts(isNewCategory = false) {
    let sortOrder;
    if (document.querySelector('.sort-order h3').innerHTML != 'Trier') {
        sortOrder = document.querySelector('.sort-order h3').innerHTML.toUpperCase();
    }

    jQuery.ajax({
        type: 'POST',
        url: 'http://localhost/Projet-11/wp-admin/admin-ajax.php',
        dataType: 'json',
        data: {
            action: 'photos_load_more',
            paged: currentPage,
            category: selectedCategory,
            sortOrder: sortOrder ? sortOrder : 'DESC',
        },
        success: function (res) {
            if (isNewCategory || currentPage === 1) {
                jQuery('.photos-wrapper').html(res.html);
            } else {
                jQuery('.photos-wrapper').append(res.html);
            }

            const currentDisplayedPosts = jQuery('.photos-wrapper').children().length;
            console.log('post en cours', currentDisplayedPosts)
            console.log('total post reponse: ', res.total_posts)
            if (currentDisplayedPosts >= res.total_posts) {
                jQuery('#load-more').hide();
                jQuery('.btn__wrapper').css('margin-bottom', '0');
            } else {
                jQuery('#load-more').show();
            }
        }
    });
}
