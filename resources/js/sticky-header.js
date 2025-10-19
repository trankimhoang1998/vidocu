// Sticky Header Functionality
document.addEventListener('DOMContentLoaded', function() {
    const mainNav = document.querySelector('.main-nav');
    const header = document.querySelector('.user-header');

    if (!mainNav || !header) return;

    // Calculate the offset position
    const stickyOffset = mainNav.offsetTop;

    // Add scroll event listener
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > stickyOffset) {
            mainNav.classList.add('sticky');
            // Add padding to body to prevent content jump
            header.style.paddingBottom = mainNav.offsetHeight + 'px';
        } else {
            mainNav.classList.remove('sticky');
            header.style.paddingBottom = '0';
        }
    });
});
