import './bootstrap';

$(document).ready(function() {
    $('.js-select2').select2({
        closeOnSelect: false,
        placeholder: "Sélectionnez une ou plusieurs options",
        allowClear: true,
        width: '100%'
    });
});



document.querySelectorAll('.carousel-wrapper').forEach(wrapper => {
    const carousel = wrapper.querySelector('.carousel');
    const prevButton = wrapper.querySelector('.carousel-prev');
    const nextButton = wrapper.querySelector('.carousel-next');

    function updateButtons() {
        const isDesktop = window.innerWidth >= 1024;

        if (!isDesktop) {
            prevButton.style.display = 'none';
            nextButton.style.display = 'none';
            return;
        }

        prevButton.style.display = carousel.scrollLeft > 0 ? 'flex' : 'none';
        nextButton.style.display = carousel.scrollLeft < (carousel.scrollWidth - carousel.clientWidth) ? 'flex' : 'none';
    }

    // Event listeners
    nextButton.addEventListener('click', () => {
        carousel.scrollBy({ left: 250, behavior: 'smooth' });
        setTimeout(updateButtons, 300);
    });

    prevButton.addEventListener('click', () => {
        carousel.scrollBy({ left: -250, behavior: 'smooth' });
        setTimeout(updateButtons, 300);
    });

    carousel.addEventListener('scroll', updateButtons);
    window.addEventListener('resize', updateButtons);

    // Init
    updateButtons();
});
