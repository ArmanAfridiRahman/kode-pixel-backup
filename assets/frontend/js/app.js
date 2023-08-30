(function () {

    "use strict";
    const header = document.querySelector(".header");
    const backToTop = document.querySelector(".back-to-top");
    window.addEventListener("scroll", () => {
        if (header !== null && window.scrollY > 0) {
            header.classList.add("sticky");
        }
        else {
            header.classList.remove("sticky");
        }
    })

    // Back to Top 

    if (backToTop != null) {
        backToTop.addEventListener("click", () => {
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            })
        })
    }

    // header
    // mobile-menu

    $('.mobile-menu-btn').on("click", function () {
        $('.main-nav').toggleClass('show-menu');
    });

    $('.menu-close-btn').on("click", function () {
        $('.main-nav').removeClass('show-menu');
    });


    // mobile-drop-down
    $(".main-nav .bi").on('click', function (event) {
        var $fl = $(this);
        $(this).parent().siblings().find('.sub-menu').slideUp();
        $(this).parent().siblings().find('.bi').addClass('bi-chevron-down');
        if ($fl.hasClass('bi-chevron-down')) {
            $fl.removeClass('bi-chevron-down').addClass('bi-chevron-up');
        } else {
            $fl.removeClass('bi-chevron-up').addClass('bi-chevron-down');
        }
        $fl.next(".sub-menu").slideToggle();
    });

    // window.addEventListener('load', function () {
    //     $('.marquee').marquee({
    //         duration: 15000,
    //         gap: 50,

    //         delayBeforeStart: 0,
    //         direction: 'left',
    //         duplicated: true
    //     });
    // });


    // Author Slider

    const authorSlider = document.querySelector(".author-slider");
    if (authorSlider) {
        new Swiper(authorSlider, {
            slidesPerView: 3,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
            breakpoints: {
                320: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 3,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 40,
                },
                1200: {
                    slidesPerView: 3,
                    spaceBetween: 50,
                },
            }
        })
    }

    // Portfolio Slider
    const portfolioSlider = document.querySelector(".portfolio-slider");
    if (portfolioSlider) {
        new Swiper(portfolioSlider, {
            slidesPerView: 3,
            spaceBetween: 30,
            loop: true,
            navigation: {
                nextEl: ".port-button-next",
                prevEl: ".port-button-prev",
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 2,
                    spaceBetween: 30,
                },
                1200: {
                    slidesPerView: 4,
                    spaceBetween: 30,
                },
            }
        })
    }

    // Team Slider
    const teamSlider = document.querySelector(".teams-slider");
    if (teamSlider) {
        new Swiper(teamSlider, {
            slidesPerView: 3,
            spaceBetween: 30,
            loop: true,
            navigation: {
                nextEl: ".team-button-next",
                prevEl: ".team-button-prev",
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                },
                577: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 15,
                },
                1200: {
                    slidesPerView: 4,
                    spaceBetween: 20,
                },
            }
        })
    }

}())