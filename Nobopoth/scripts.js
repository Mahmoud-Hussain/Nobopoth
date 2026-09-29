document.addEventListener('DOMContentLoaded', function() {
    const elements = document.querySelectorAll('.fade-in, .slide-in, .bounce');

    function checkPosition() {
        elements.forEach(element => {
            const position = element.getBoundingClientRect();
            if (position.top < window.innerHeight && position.bottom >= 0) {
                element.classList.add('visible');
            }
        });
    }

    window.addEventListener('scroll', checkPosition);
    checkPosition();
    
    // Add background image to the section
    const section = document.querySelector('.perfect-service-section');
    if (section) {
        section.style.backgroundImage = 'url("path/to/image.jpg")';
        section.style.backgroundSize = 'cover';
        section.style.backgroundPosition = 'center';
    }
});
