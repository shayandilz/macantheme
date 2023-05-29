import gsap from "gsap";
import ScrollTrigger from 'gsap/ScrollTrigger';
import $ from "jquery";


// Register ScrollTrigger plugin
gsap.registerPlugin(ScrollTrigger);

$(document).ready(function () {
    // Configure gsap animations
    if (gsap.utils.toArray('progress, .sidebar-area').length) {
        gsap.to('progress', {
            value: 100,
            ease: 'none',
            scrollTrigger: {
                trigger: ".sidebar-container",
                scrub: 0.3,
                start: 'start 0px',
                end: 'bottom bottom',
                toggleClass: {targets: ".blog-progress", className: "show"}
            }
        });

        // Define scrollTrigger for sticky sidebar
        ScrollTrigger.matchMedia({
            "(min-width: 1080px)": function () {
                if ($('body').is('.single-post')) {
                    let stickySidebar = gsap.timeline({
                        scrollTrigger: {
                            trigger: ".sidebar-container",
                            start: "top 90px",
                            end: "bottom center",
                            pin: ".sidebar-area"
                        }
                    });
                }
            }
        });
    }


    // Highlight active section in the sidebar
    let sectionsP = $('.sidebar-container').find('h2, h3, h4, h5, h6');
    let navTable = $('.table-of-contents');

    $(window).on('scroll', function () {
        let curPos = $(this).scrollTop();

        sectionsP.each(function () {
            let top = $(this).offset().top - 50, // Adjust 50 to your needs
                bottom = top + $(this).outerHeight();

            if (curPos >= top && curPos <= bottom) {
                navTable.find('a').removeClass('active-item');
                navTable.find('a[href="#' + $(this).attr('id') + '"]').addClass('active-item');
            }
        });
    });
});


document.addEventListener('DOMContentLoaded', function () {
    // table active color
    var tocItems = document.querySelectorAll('.table-of-contents a');
    tocItems.forEach(function (item) {
        item.addEventListener('click', function (event) {
            // Remove active class from all items
            tocItems.forEach(function (item) {
                item.classList.remove('active-item');
            });

            // Add active class to the clicked item and its parents
            var currentItem = this;
            while (currentItem) {
                currentItem.classList.add('active-item');
                currentItem = currentItem.parentElement.closest('li');
            }

            // Stop the event from propagating to parent elements
            event.stopPropagation();
        });

        // Handle click events for nested UL elements
        var nestedULs = item.querySelectorAll('ul');
        nestedULs.forEach(function (ul) {
            ul.addEventListener('click', function (event) {
                // Stop the event from propagating to parent elements
                event.stopPropagation();
            });
        });
    });


})