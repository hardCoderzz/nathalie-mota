const contactLinks = document.querySelectorAll('.contact-btn, .contact-single-btn');
const overlay = document.querySelector('.popup');
const popup = document.querySelector('.popup-content');
const photoReferenceInput = document.querySelector('#photo-reference .wpcf7-form-control');
const postRef = document.querySelector('.post-ref');

contactLinks.forEach((contactLink) => {
    contactLink.addEventListener('click', () => {
        if (postRef) {
            const photoRef = postRef.textContent.replace('Référence : ', '');

            if (photoRef) {
                photoReferenceInput.value = photoRef;
            }
        }

        overlay.classList.add('open');
    });
});

popup.addEventListener('click', (event) => {
    event.stopPropagation();
});

overlay.addEventListener('click', () => {
    overlay.classList.remove('open');
});





