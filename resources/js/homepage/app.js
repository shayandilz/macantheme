import $ from "jquery";
import 'swiper/css';
import Swiper from 'swiper/bundle';
import 'swiper/css/bundle';

$(document).ready(function () {
    // Handle category button click
    $('.category-button').click(function () {
        let categoryId = $(this).data('category-id');
        window.location.href = 'blog/#' + categoryId;
    });
})

function homeSwiper() {
    let names = [];
    $(".swiper1 .swiper-slide section").each(function (i) {
        names.push($(this).data("name"));
    });

// aos data attribute looping
    const swiper = new Swiper('.swiper1', {
        hashNavigation: true,
        allowTouchMove: false,
        effect: 'slide',
        speed: 900,
        slidesPerView: 1,
        mousewheel: {
            invert: false,
            sensitivity: 3
        },
        spaceBetween: 0,
        direction: 'vertical',
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
            renderBullet: function (index, className) {
                return '<div class="tooltip position-relative ' + className + '" ><span class="tooltiptext text-white text-start position-absolute z-top ">' + (names[index]) + '</span></div>';
            }
        },
        on: {

            init: function () {
                // button back to top
                let backToTop = document.querySelector('.backTo_Top');
                backToTop.addEventListener('click', function () {
                    swiper.slideTo(0);
                });
            },
            afterInit: function () {
                setTimeout(function () {
                    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
                    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
                }, 50)
            },
            realIndexChange: function () {
                let activeSlide = this.realIndex;
                let slides = this.slides;
                if (activeSlide === 0) {
                    $('.navbar-brand').addClass('aos-animate')
                    $('.backTo_Top').removeClass('aos-animate');
                } else {
                    $('.navbar-brand').removeClass('aos-animate');
                    $('.backTo_Top').addClass('aos-animate')
                }
                slides.forEach(function (slide, index) {
                    let elementsWithAos = slide.querySelectorAll('[data-aos]');
                    elementsWithAos.forEach(function (element) {
                        if (index === activeSlide) {
                            element.classList.add('aos-animate');
                        } else {
                            element.classList.remove('aos-animate');
                        }
                    });
                });
            }
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    function handleResponsive() {
        // Check the screen size or viewport dimensions
        if (window.innerWidth > 1024) {
            homeSwiper();
        } else {
            $('.home main > div').removeClass('swiper')
            $('.home main > div > div').removeClass('swiper-wrapper')
            $('.home main > div > div > div').removeClass('swiper-slide')
            let disableAnimationElements = document.querySelectorAll('[data-aos-disable]');
            disableAnimationElements.forEach(function (element) {
                element.removeAttribute('data-aos');
                element.removeAttribute('data-aos-duration');
            });
        }
    }

// Event listener for the resize event
    window.addEventListener('resize', handleResponsive);

// Initial call to handleResponsive to execute the code on page load
    handleResponsive();
})
