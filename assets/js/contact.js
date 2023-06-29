const contactLink = document.querySelector('.contact-btn');
const overlay = document.querySelector('.popup');
const popup = document.querySelector('.popup-content');

contactLink.addEventListener('click', () => {
    overlay.classList.add('open');
});

overlay.addEventListener('click', () => {
    overlay.classList.remove('open');
});





