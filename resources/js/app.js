require('./bootstrap');
import Search from './global/search';
import $ from "jquery";
import AOS from 'aos';
import 'aos/dist/aos.css';



document.addEventListener('DOMContentLoaded', function () {

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
    const myModalEl = document.getElementById('headerModal');
    const menu_items = document.querySelectorAll('#navbarTogglerMenu > li');
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

    if (myModalEl) {
        myModalEl.addEventListener('shown.bs.modal', function (event) {
            setTimeout(function () {
                menu_items.forEach((item) => {
                        item.classList.add('aos-animate');
                });
                socialIcons.forEach((social) => {
                    social.classList.add('aos-animate');
                });
            }, 20); // Delay added before adding the 'aos-animate' class
        })
        myModalEl.addEventListener('hidden.bs.modal', function (event) {
            submenuItems.each(function () {
                $(this).removeClass('aos-animate')
            })
            $('.back-button').remove();
            menu_items.forEach((item) => {
                item.classList.remove('aos-animate');
            });
            socialIcons.forEach((social) => {
                social.classList.remove('aos-animate');
            })

        })

    }
    // menu animations
    $('.menu li:has(ul)').addClass('has-submenu z-top');
    let submenuItems = $('#navbarTogglerMenu .sub-menu li');
    let index = 0;

    submenuItems.each(function () {
        index++;
        $(this).attr('data-aos', 'fade-up')
        $(this).attr('data-aos-delay', index + '00')
        $(this).removeClass('aos-animate')
    })
    $('.menu li.has-submenu > a').click(function (e) {
        e.preventDefault();
        let submenu = $(this).next('ul');
        let menuItems = $('.menu > ul > li').not($(this).closest('li')).not($(this).closest('.submenu').siblings());
        if ($(this).parents('.submenu-open').length === 0 && submenu.find('.back-button').length === 0) {
            // Add a back button only if the clicked item is not a child of an open submenu and if the submenu doesn't already have a back button
            let backBtn = $('<i>').addClass('bi bi-arrow-right-short back-button');
            submenu.append(backBtn);
        }
        menuItems.each(function (index) {
            $(this).removeClass('aos-animate')
        });

        submenu.addClass('submenu-open').fadeIn();
        submenuItems.each(function () {
            $(this).addClass('aos-animate')
        })
    });

    function closeButton() {
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
            $(this).find('.back-button').remove();
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
});


