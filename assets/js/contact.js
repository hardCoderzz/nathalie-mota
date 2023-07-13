const contactLinks = document.querySelectorAll('.contact-btn, .contact-single-btn');
const overlay = document.querySelector('.popup');
const popup = document.querySelector('.popup-content');
const form = document.querySelector('.wpcf7');

contactLinks.forEach((contactLink) => {
    contactLink.addEventListener('click', () => {
        overlay.classList.add('open');
    });
});

form.addEventListener('click', (event) => {
    event.stopPropagation();
});

overlay.addEventListener('click', () => {
    overlay.classList.remove('open');
});





