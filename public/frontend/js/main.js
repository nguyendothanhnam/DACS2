// Initialize Swiper
const swiper = new Swiper(".swiper", {
    loop: true, // Enable loop mode
    autoplay: {
        delay: 3000, // Slide delay (in ms)
        disableOnInteraction: false, // Continue autoplay after user interaction
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true, // Allow pagination to be clicked
    },
});
// Hàm khởi tạo carousel
function initCardCarousel(carouselId) {
    const multipleCardCarousel = document.querySelector(`#${carouselId}`);

    if (window.matchMedia("(min-width: 200px)").matches) {
        const carousel = new bootstrap.Carousel(multipleCardCarousel, {
            interval: false,
        });

        // Tạo scope riêng cho mỗi carousel
        const carouselInner =
            multipleCardCarousel.querySelector(".carousel-inner");
        const carouselWidth = carouselInner.scrollWidth;
        const cardWidth =
            multipleCardCarousel.querySelector(".carousel-item").offsetWidth;
        let scrollPosition = 0;

        // Next button
        multipleCardCarousel
            .querySelector(".carousel-control-next")
            .addEventListener("click", () => {
                if (scrollPosition < carouselWidth - cardWidth * 1) {
                    scrollPosition += cardWidth;
                    $(carouselInner).animate(
                        { scrollLeft: scrollPosition },
                        600
                    );
                }
            });

        // Prev button
        multipleCardCarousel
            .querySelector(".carousel-control-prev")
            .addEventListener("click", () => {
                if (scrollPosition > 0) {
                    scrollPosition -= cardWidth;
                    $(carouselInner).animate(
                        { scrollLeft: scrollPosition },
                        600
                    );
                }
            });
    } else {
        $(multipleCardCarousel).addClass("slide");
    }
}

// Khởi tạo từng carousel
initCardCarousel("carouselExampleControls1");
initCardCarousel("carouselExampleControls2");
initCardCarousel("carouselExampleControls3");

