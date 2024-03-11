const header = document.querySelector ("header");
const footer = document.querySelector ("footer");
console.log(nombreUsuario); 

header.innerHTML = `
    <nav class="navbar navbar-expand-lg navbar-light bg-light p-2">
        <a class="navbar-brand" href="https://www.firplak.com/" target="_blank">
            <img src="img/logo_firplak.webp" alt="Logo" height="40"> <!-- Ajusta la altura según tus necesidades -->
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/firplak">Inicio</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" href="#">Transportadores</a>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link" href="https://realeelvis.online/" target="_blank">Contacto</a>
                </li>       
            </ul>
        </div>
    </nav>
    <p class="text-end pt-1 px-1">👋 ¡Hola ${nombreUsuario}!</p>

`;

footer.innerHTML = `
    <p>&copy; 2024 Firplak. Todos los derechos reservados.</p>
`
footer.classList.add('text-center', 'mt-auto', 'mt-4', 'bg-light', 'p-2');

document.addEventListener('DOMContentLoaded', function () {
    const swiper = new Swiper('.swiper', {
        // Optional parameters
        direction: 'horizontal',
        loop: false,
        slidesPerView: 1,
        spaceBetween: 2,

        // If we need pagination
        pagination: {
            el: '.swiper-pagination',
        },

        // Navigation arrows
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },

        // And if we need scrollbar
        scrollbar: {
            el: '.swiper-scrollbar',
        },
        breakpoints: {
            '768': {
                slidesPerView: 3,
            },
            pagination: {
                el: null,
            },

        },
    });
});
