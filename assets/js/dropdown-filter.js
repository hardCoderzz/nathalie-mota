const chevronCategories = document.querySelector('.chevron-categories');
const chevronFormat = document.querySelector('.chevron-format');
const chevronSort = document.querySelector('.chevron-sort');
const categories = document.querySelector('.category-list');
const formats = document.querySelector('.format-list');
const sort = document.querySelector('.sort-order-list');
const categoryLinks = document.querySelectorAll('.category-list li');
const formatLinks = document.querySelectorAll('.format-list li');
const sortOrderLinks = document.querySelectorAll('.sort-order-list li');

function toggleChevronAndList(chevron, list) {
    list.classList.toggle('open');
    chevron.style.transform = list.classList.contains('open') ? 'rotate(180deg)' : '';
}

function handleLinkClick(links, clickedLink, chevron, list) {
    links.forEach(link => link.classList.remove('active'));
    clickedLink.classList.add('active');
    list.classList.remove('open');
    chevron.style.transform = '';
    updatePhotos();
}

if (chevronCategories || chevronFormat || chevronSort != null) {
    chevronCategories.addEventListener('click', () => toggleChevronAndList(chevronCategories, categories));
    chevronFormat.addEventListener('click', () => toggleChevronAndList(chevronFormat, formats));
    chevronSort.addEventListener('click', () => toggleChevronAndList(chevronSort, sort));

    categoryLinks.forEach(link => {
        link.addEventListener('click', () => {
            handleLinkClick(categoryLinks, link, chevronCategories, categories);
        });
    });

}

formatLinks.forEach(link => {
    link.addEventListener('click', () => {
        handleLinkClick(formatLinks, link, chevronFormat, formats);
    });
});

sortOrderLinks.forEach(link => {
    link.addEventListener('click', () => {
        handleLinkClick(sortOrderLinks, link, chevronSort, sort);

    });
});

document.querySelectorAll('.category-list li').forEach(item => {
    item.addEventListener('click', () => {

        const prevActive = document.querySelector('.category-list li.active');
        if (prevActive) {
            prevActive.classList.remove('active');
        }
        item.classList.add('active');

        updatePhotos();
    });
});

function updatePhotos() {
    currentPage = 1;
    const category = document.querySelector('.category-list li.active');
    const format = document.querySelector('.format-list li.active');
    const sortOrder = document.querySelector('.sort-order-list li.active');

    let categorySlug = category ? category.getAttribute('data-category') : '';
    let formatSlug = format ? format.getAttribute('data-format') : '';
    let sortOrderValue = sortOrder ? sortOrder.getAttribute('data-sort-order') : '';

    document.querySelector('.category h3').innerHTML =
        categorySlug.length > 0 ? categorySlug : 'Catégorie'
    document.querySelector('.format h3').innerHTML =
        formatSlug.length > 0 ? formatSlug : 'Format'
    document.querySelector('.sort-order h3').innerHTML =
        sortOrderValue.length > 0 ? sortOrderValue : 'Trier'

    sendFetchRequest(categorySlug, formatSlug, sortOrderValue);
}

function sendFetchRequest(category, format, sortOrder) {
    fetch('http://localhost/Projet-11/wp-admin/admin-ajax.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            action: 'filter_posts',
            category: category,
            format: format,
            sortOrder: sortOrder,
        }),
    })
        .then(response => {
            if (response.ok) {
                return response.text();
            } else {
                throw new Error('La requête a échoué');
            }
        })
        .then(res => {
            const photosList = document.querySelector('.photos-wrapper');
            const data = JSON.parse(res);
            photosList.innerHTML = data.html;
        })
        .catch(error => {
            console.error(error);
        });
}
