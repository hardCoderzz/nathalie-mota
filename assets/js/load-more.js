const loadMore = document.getElementById('load-more');
const photosList = document.querySelector('.photos-wrapper');

let currentPage = 1;
const existingPostElements = document.querySelectorAll('.related-post');
const loadedCount = existingPostElements.length;

loadMore.addEventListener('click', async () => {
    currentPage++;
    fetch('http://localhost/Projet-11/wp-admin/admin-ajax.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            action: 'photos_load_more',
            paged: currentPage,
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
            photosList.insertAdjacentHTML('beforeend', res);

            const newPostElements = document.querySelectorAll('.related-post');
            const loadedCount = newPostElements.length;

            if (loadedCount >= 12) {
                loadMore.style.opacity = '0';
                loadMore.style.pointerEvents = 'none';
            }
        })
        .catch(error => {
            console.error(error);
        });
});
