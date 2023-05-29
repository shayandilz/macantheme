import 'swiper/css';
import Swiper from 'swiper/bundle';
import 'swiper/css/bundle';
import $ from "jquery";

document.addEventListener('DOMContentLoaded', function () {
// gallery light box
    if (document.getElementById('portfolioModal')) {
        // let thumbnails = document.querySelectorAll('.swiper-thumbnail');
        let swiperModal;
        let swiperThumb;

        [].slice.call(document.querySelectorAll('.play-btn[data-bs-toggle="modal"]')).map(function (El) {
            let slideNumber = parseInt(El.dataset.slide);
            El.addEventListener('click', function () {
                swiperThumb = new Swiper(".swiperThumb", {
                    spaceBetween: 2,
                    slidesPerView: 5,
                    breakpoints: {
                        996: {
                            slidesPerView: 18,
                        }
                    }
                });
                swiperModal = new Swiper('.swiperModal', {
                    autoWidth: true,
                    speed: 700,
                    slidesPerView: 'auto',
                    direction: 'horizontal',
                    loop: false,
                    initialSlide: slideNumber - 1, // Update the initialSlide value
                    spaceBetween: 10,
                    on: {
                        slideChange: function () {
                            // Pause videos on slide change
                            document.querySelectorAll('video').forEach(function (video) {
                                video.pause();
                            });
                        }
                    },
                    pagination: {
                        el: ".pagination-button",
                        type: "fraction",
                    },
                    navigation: {
                        nextEl: '.next-button',
                        prevEl: '.prev-button',
                        disabledClass: "swiper-button-disabled"
                    },
                    thumbs: {
                        swiper: swiperThumb,
                    },
                });
            });
        });

        document.getElementById('portfolioModal').addEventListener('show.bs.modal', function () {
            const activeThumbnail = document.querySelector('.swiper-thumbnail.active');
            if (activeThumbnail) {
                activeThumbnail.classList.remove('active');
            }

        });

        document.getElementById('portfolioModal').addEventListener('hide.bs.modal', function () {
            document.querySelectorAll('video').forEach(function (video) {
                video.pause();
            });
        });
    }

    function resizeForm() {
        var width = (window.innerWidth > 0) ? window.innerWidth : document.documentElement.clientWidth;

        // Slice words and add ellipsis for .previous-post h6
        if (width <= 1024) {
            function sliceAndFadeInFromLeft(element, length) {
                var string = element.text();
                if (string.length > length) {
                    var slicedString = string.substring(0, length) + ' ... ';
                    element.text(slicedString);
                }
                fadeInFromLeft(element);
            }

            function sliceAndFadeInFromRight(element, length) {
                var string = element.text();
                if (string.length > length) {
                    var slicedString = string.substring(0, length) + ' ... ';
                    element.text(slicedString);
                }
                fadeInFromRight(element);
            }

            function fadeInFromLeft(element) {
                element.css({
                    animationName: 'fadeInFromLeft'
                });
            }

            function fadeInFromRight(element) {
                element.css({
                    animationName: 'fadeInFromRight'
                });
            }

            function fadeElementsIn() {
                var previousPostH6 = $('.previous-post h6');
                var nextPostH6 = $('.next-post h6');
                var length = 9;

                if (previousPostH6.length > 0) {
                    sliceAndFadeInFromLeft(previousPostH6, length);
                }

                if (nextPostH6.length > 0) {
                    sliceAndFadeInFromRight(nextPostH6, length);
                }
            }

            fadeElementsIn();

        }
    }

    window.onresize = resizeForm;
    resizeForm();
})