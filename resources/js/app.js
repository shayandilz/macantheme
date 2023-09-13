require('./bootstrap');
import Search from './global/search';
import $ from "jquery";
import AOS from 'aos';
import 'aos/dist/aos.css';
import Masonry from 'masonry-layout';
import imagesLoaded from 'imagesloaded';


$(document).ready(function () {
    // Hide preloader when entering the page
    setTimeout(function () {
        $('#preloader-fa').fadeOut('slow');
    }, 2400);
    // active tabs from card category inside
    $('.categoryClick').click(function(e) {
        e.preventDefault();
        var selectedCategory = $(this).data('category-id');
        localStorage.setItem('selectedCategory', selectedCategory);
        location.reload();
    });
    var storedCategory = localStorage.getItem('selectedCategory');
    if (storedCategory) {
        $('.nav-link').removeClass('active');
        $('.tab-pane').removeClass('show active');
        $('#cat-'+storedCategory+'-tab').addClass('active');
        $('#cat-' + storedCategory).addClass('show active');
    }
    // Handle category button click
    jQuery('.category-button').click(function () {
        let categoryId = jQuery(this).data('category-id');
        localStorage.setItem('categoryID', categoryId);

        // Check if the current URL contains "/blog"
        if (window.location.href.includes('/blog')) {
            location.href = window.location.href; // Refresh the page
        } else {
            window.location.href = 'blog/';
        }
    });
    setTimeout(function () {
        localStorage.setItem('categoryID', '');
        localStorage.setItem('selectedCategory', '');
    }, 8000);
//when browser closed - clear all local storage
    jQuery('#portfolioModal .modal-dialog').click(function (e) {
        if (jQuery(e.target).hasClass('modal-dialog')) {
            jQuery(this).closest('.modal').modal('hide');
        }
    });

    jQuery(function ($) {
        const macanisms = [
            {element: '.M-Macanism', shape: '.M-shape', flower: '.M-Flower', description: '.M-Description'},
            {element: '.A-Macanism', shape: '.A-shape', flower: '.A-Flower', description: '.A-Description'},
            {element: '.K-Macanism', shape: '.K-shape', flower: '.K-Flower', description: '.K-Description'},
            {element: '.AA-Macanism', shape: '.AA-shape', flower: '.AA-Flower', description: '.AA-Description'},
            {element: '.N-Macanism', shape: '.N-shape', flower: '.N-Flower', description: '.N-Description'},
            {element: '.I-Macanism', shape: '.I-shape', flower: '.I-Flower', description: '.I-Description'},
            {element: '.S-Macanism', shape: '.S-shape', flower: '.S-Flower', description: '.S-Description'},
            {element: '.MM-Macanism', shape: '.MM-shape', flower: '.MM-Flower', description: '.MM-Description'}
        ];

        macanisms.forEach(function (macanism) {
            const {element, shape, flower, description} = macanism;

            $(shape).add(flower).css('display', 'none');

            $(element).mouseenter(function () {
                $(shape).css('display', 'block').addClass(`${element.slice(1)}-flower-Animation`);
                $(flower).css('display', 'block');
                $(description).addClass('Macanism-Description-animate');
            });

            $(element).mouseleave(function () {
                $(shape).css('display', 'none').removeClass(`${element.slice(1)}-flower-Animation`);
                $(flower).css('display', 'none');
                $(description).removeClass('Macanism-Description-animate');
            });
        });
    });
})
class AOSDisabler {
    constructor(className) {
        this.elements = document.querySelectorAll('.' + className);
        this.initialize();
    }

    initialize() {
        if (this.isMobileScreenSize()) {
            this.disableAOSOnMobile();
        }
    }

    isMobileScreenSize() {
        return window.matchMedia('(max-width: 767px)').matches;
    }

    disableAOSOnMobile() {
        this.elements.forEach((element) => {
            const elementsWithAOS = element.querySelectorAll('[data-aos]');

            elementsWithAOS.forEach((aosElement) => {
                aosElement.setAttribute('data-aos', 'none');
            });
        });
    }
}


document.addEventListener('DOMContentLoaded', function () {


    const aosDisabler = new AOSDisabler('aos-remover');
    /*---------------------     SEARCH in HEADER     ---------------------------*/
    const search = new Search();

    /*---------------------     MENU & HEADER     ---------------------------*/
//toggle header on time
    const toggleScrollClass = function () {
        if (window.scrollY > 24) {
            document.body.classList.add('scrolled');
        } else {
            document.body.classList.remove('scrolled');
        }
    }

    toggleScrollClass();
    //check scroll to take actions on it
    window.addEventListener('scroll', function () {
        toggleScrollClass();
    });
    // menu modal
    let backBtn = $('<i>').addClass('bi bi-arrow-right-short back-button');
    let liElement = $('<li>').append(backBtn);
    $('#navbarTogglerMenu .sub-menu').append(liElement);

    const myModalEl = document.getElementById('headerModal');
    const menu_items = document.querySelectorAll('#navbarTogglerMenu > li');
    let submenuItems = $('#navbarTogglerMenu .sub-menu li');
    const socialIcons = document.querySelectorAll('.social_icons > div')

    let i = 0;
    let menu_items_num = menu_items.length
    socialIcons.forEach((social) => {
        menu_items_num++;
        social.setAttribute('data-aos', 'fade-up');
        social.setAttribute('data-aos-delay', menu_items_num + '00');
        setTimeout(function () {
            social.classList.remove('aos-animate');
        }, 20);
    })
    menu_items.forEach((item) => {
        i++;
        item.setAttribute('data-aos', 'fade-up');
        item.setAttribute('data-aos-delay', i + '00');
        setTimeout(function () {
            item.classList.remove('aos-animate');
        }, 20)
    });
    $('.menu li:has(ul)').addClass('has-submenu z-top');
    let subMenuTitle = $('.menu li.has-submenu > a');
    if (myModalEl) {
        myModalEl.addEventListener('shown.bs.modal', function (event) {

            if (window.location.href.includes('/services')) {
                let menuItems = $('.menu > ul > li').not($('.menu-item-has-children').closest('li')).not($('.menu-item-has-children').closest('.submenu').siblings());
                $('.menu-item-has-children').addClass('aos-animate');
                $('.menu li.has-submenu > a').fadeOut();
                menuItems.each(function (item) {
                    $(this).removeClass('aos-animate')
                });
                let subMenuUL = $('#navbarTogglerMenu .sub-menu');
                subMenuUL.addClass('submenu-open').fadeIn();
                submenuItems.each(function () {
                    $(this).addClass('aos-animate')
                })
            } else {
                $('.sub-menu').addClass('submenu-open').fadeOut();
                submenuItems.each(function () {
                    $(this).removeClass('aos-animate');
                })
                setTimeout(function () {
                    menu_items.forEach((item) => {
                        item.classList.add('aos-animate');
                    });
                    socialIcons.forEach((social) => {
                        social.classList.add('aos-animate');
                    });
                }, 20); // Delay added before adding the 'aos-animate' class
            }


        })
        myModalEl.addEventListener('hidden.bs.modal', function (event) {

            if (!subMenuTitle.hasClass('aos-animate')) {
                subMenuTitle.addClass('aos-animate')
            }
            submenuItems.each(function () {
                $(this).removeClass('aos-animate')
            })
            menu_items.forEach((item) => {
                item.classList.remove('aos-animate');
            });
            socialIcons.forEach((social) => {
                social.classList.remove('aos-animate');
            })
        })
    }
    // menu animations


    let index = 0;

    submenuItems.each(function () {
        index++;
        $(this).attr('data-aos', 'fade-up')
        $(this).attr('data-aos-delay', index + '00')
        subMenuTitle.attr('data-aos', 'fade-out')
        subMenuTitle.attr('data-aos-delay', index + '00')
        $(this).removeClass('aos-animate')


    })
    if (window.location.href.includes('/services')) {
        setTimeout(function () {
            submenuItems.each(function () {
                $(this).removeClass('aos-animate');
            })
        }, 10)
    }

    function subMenu() {

        $(this).removeClass('aos-animate')
        let submenu = $(this).next('ul');
        let menuItems = $('.menu > ul > li').not($(this).closest('li')).not($(this).closest('.submenu').siblings());
        menuItems.each(function (index) {
            $(this).removeClass('aos-animate')
        });

        submenu.addClass('submenu-open').fadeIn();
        submenuItems.each(function () {
            $(this).addClass('aos-animate')
        })
    }

    subMenuTitle.click(subMenu);

    function closeButton() {
        subMenuTitle.addClass('aos-animate')
        submenuItems.each(function () {
            $(this).removeClass('aos-animate')
        })
        var submenu = $('.submenu-open');
        submenu.fadeOut(function () {
            $(this).removeClass('submenu-open').closest('.has-submenu').children('a').fadeIn();
            var menuItems = $('.menu > ul > li').not($(this).closest('li')).not($(this).closest('.submenu').siblings());
            menuItems.each(function (index) {
                $(this).addClass('aos-animate')
            });
            // $(this).find('.back-button').remove();

        });

    }

    $('.menu').on('click', '.back-button', function (e) {
        e.preventDefault();
        closeButton();
    });
// Define the class to be removed
    const classToRemove = 'aos-animate';

// Function to check if an element is visible in the viewport
    function isElementVisible(element) {
        const rect = element.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }

// Function to remove the class when an element is visible
    function removeClassOnScroll() {
        menu_items.forEach((element) => {
            if (isElementVisible(element) && element.classList.contains(classToRemove)) {
                setTimeout(function () {
                    element.classList.remove(classToRemove);
                }, 200)
            }
        });
        socialIcons.forEach((element) => {
            if (isElementVisible(element) && element.classList.contains(classToRemove)) {
                setTimeout(function () {
                    element.classList.remove(classToRemove);
                }, 200)
            }
        });
    }

// Attach the scroll event listener
    window.addEventListener('scroll', removeClassOnScroll);

    /*---------------------     TABS for aos animation     ---------------------------*/
    // Select the tabs and tab content elements
    const tabs = document.querySelectorAll('.nav-tabs .nav-link');
    const tabContent = document.querySelectorAll('.tab-content .tab-pane');

    let counter = 0;
// Attach an event listener to each tab
    tabs.forEach((tab, index) => {
        tab.addEventListener('shown.bs.tab', () => {
            // Remove the "aos-animate" class from all elements
            const aosEls = document.querySelectorAll('.aos');
            aosEls.forEach(el => el.classList.remove('aos-animate'));
            // Add the "aos-animate" class to the current tab elements
            const currentTabEls = tabContent[index].querySelectorAll('.aos');
            currentTabEls.forEach(el => el.classList.add('aos-animate'));
            currentTabEls.forEach(
                el => {
                    el.setAttribute('data-aos-delay', counter + '00')
                    counter++;
                }
            );
            counter = 0;
        });
    });


    AOS.init();

    function initializeMasonry() {
        var masonryGrids = document.querySelectorAll(".grid");

        // Loop through all masonry grids and initialize Masonry
        masonryGrids.forEach(function (masonryGrid) {
            var masonryItems = masonryGrid.querySelectorAll(".grid-item");

            var masonry = new Masonry(masonryGrid, {
                itemSelector: ".grid-item",
                columnWidth: ".grid-item",
                percentPosition: true
            });

            // Initialize Masonry after images have loaded
            imagesLoaded(masonryGrid).on("progress", function () {
                masonry.layout();
            });
        });
    }
    initializeMasonry();
    // Event listener for Bootstrap tab shown event
    document.addEventListener("shown.bs.tab", function (event) {
        // Reinitialize Masonry when the tab is shown
        initializeMasonry();
    });

});