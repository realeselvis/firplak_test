const header = document.querySelector ("header");
const footer = document.querySelector ("footer");
console.log(nombreUsuario); 

header.innerHTML = `
    <nav class="navbar navbar-expand-lg navbar-light bg-light p-2">

        <a class="navbar-brand" href="https://www.firplak.com/" target="_blank">
            <img src="img/logo_firplak.webp" alt="Logo" height="40">
        </a>
        <div class="d-flex align-items-center ms-auto border border-primary rounded me-2">
            <p class="text-end py-1 px-1 mb-0">👋 ¡Hola <strong>${nombreUsuario}</strong>!</p>
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/firplak">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://realeelvis.online/" target="_blank">Contacto</a>
                </li>
            </ul>
            <div class="d-flex">
                <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>
            </div>
        </div>
        <!-- Mensaje de bienvenida fuera del div colapsable pero dentro del contenedor nav -->

    </nav>
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
