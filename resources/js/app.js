import './bootstrap';

const carousel = document.getElementById('carousel');
const prevButton = document.getElementById('prev');
const nextButton = document.getElementById('next');

function updateButtons() {
    if (window.innerWidth >= 1024) { // Vérifie si on est sur PC (lg:)
        prevButton.style.display = carousel.scrollLeft > 0 ? 'flex' : 'none';
        nextButton.style.display = carousel.scrollLeft < (carousel.scrollWidth - carousel.clientWidth) ? 'flex' : 'none';
    } else {
        prevButton.style.display = 'none';
        nextButton.style.display = 'none';
    }
}

// Défilement fluide au clic
nextButton.addEventListener('click', () => {
    carousel.scrollBy({ left: 250, behavior: 'smooth' });
    setTimeout(updateButtons, 300);
});

prevButton.addEventListener('click', () => {
    carousel.scrollBy({ left: -250, behavior: 'smooth' });
    setTimeout(updateButtons, 300);
});

// Mettre à jour les boutons au chargement et lors du redimensionnement
updateButtons();
window.addEventListener('resize', updateButtons);

// Mettre à jour les boutons lors du scroll manuel
carousel.addEventListener('scroll', updateButtons);

window.addEventListener("scroll", function() {
    let statsTitle = document.getElementById("statsTitle");
    if (window.scrollY > 50) {
        statsTitle.classList.add("opacity-0");
    } else {
        statsTitle.classList.remove("opacity-0");
    }
});
