const leftArrow = document.querySelector('.arrow-left');
const rightArrow = document.querySelector('.arrow-right');
const prevPost = document.querySelector('.previous-thumbnail');
const nextPost = document.querySelector('.next-thumbnail');

leftArrow.addEventListener('mouseover', () => {
    prevPost.style.opacity = '1';
});
leftArrow.addEventListener('mouseout', () => {
    prevPost.style.opacity = '';
});

rightArrow.addEventListener('mouseover', () => {
    nextPost.style.opacity = '1';
});
rightArrow.addEventListener('mouseout', () => {
    nextPost.style.opacity = '';
});