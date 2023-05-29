// Initialize variables
import _ from "lodash";

var postsPerPage = 9;
var currentPage = 1;
var totalPages = 1;
var currentSearch = '';
var currentCategory = '';
var isLoadMore = false;


var $loadingSpinner = jQuery('#loading-spinner');
// Add a CSS class to display the loading spinner
function showLoadingSpinner() {
    $loadingSpinner.addClass('show-spinner');
    jQuery('#load-more').hide();
}

// Remove the CSS class to hide the loading spinner
function hideLoadingSpinner() {
    $loadingSpinner.removeClass('show-spinner');
}


function getCategoryName(categoryId) {
    var categoryName = "";
    jQuery.ajax({
        url: jsData.root_url + "/wp-json/wp/v2/categories/" + categoryId,
        type: 'GET',
        async: false,
        success: function(category, status, xhr) {
            categoryName = category.name;
        }
    });
    return categoryName;
}
// Function to get posts using AJAX

var isGetPostsRunning = false;

function getPosts(page, category, search, isAppend) {
// Check if the function is already running
    if (isGetPostsRunning) {
        return;
    }

    isGetPostsRunning = true;
    // Set the API endpoint URL
    var apiUrl = jsData.root_url + '/wp-json/wp/v2/posts?page=' + page + '&per_page=' + postsPerPage;
    showLoadingSpinner();
    // Add category parameter if provided
    if (category) {
        apiUrl += '&categories=' + encodeURIComponent(category);
    }

    // Add search parameter if provided
    if (search) {
        apiUrl += '&search=' + encodeURIComponent(search);
    }

    // Make AJAX request
    jQuery.ajax({
        url: apiUrl,
        type: 'GET',
        success: function(posts, status, xhr) {
            hideLoadingSpinner();
            // Create HTML for the search results
            var searchResultsHtml = '';
            // Add posts to the post grid
            for (var i = 0; i < posts.length; i++) {
                var post = posts[i];
                var title = post.title.rendered;
                var excerpt = post.excerpt.rendered.slice(0, 86) + '...';
                var link = post.link;
                var image = post.fimg_url;
                var categoriesHtml = '';
                post.categories.forEach(function(category) {
                    categoriesHtml += '<span class="category">' + getCategoryName(category) + '</span>';
                });
                searchResultsHtml +=
                    '<div class="col-lg-4 col-md-6">'+
                    '<article data-aos-delay="' + i + '00" data-aos="zoom-in" class="position-relative overflow-hidden" title="' + title + '">' +
                    '<span class="d-inline-block position-absolute top-0 end-0 z-top p-2 small text-white"\n' +
                    'style="background-color: rgba(0, 0, 0, .5) !important">' + categoriesHtml + '</span>' +
                    '<a href="' + link + '">' +
                    '<div class="ratio ratio-16x9">' +
                    '<img src="' + image + '" class="object-fit" alt="' + title + '">' +
                    '</div>' +
                    '<div class="position-absolute bottom-0 start-0 h-100 w-100 d-flex justify-content-center align-items-end">' +
                    '<div class="textBlog h-100 w-100 text-center lazy">' +
                    '<h6 class="text-center text-white position-absolute bottom-0 start-0 end-0 lazy">' + title + '</h6>' +
                    '<div class="position-absolute bottom-0 start-0 end-0 mb-3 fs-6 text-white lazy">' + excerpt + '</div>' +
                    '</div>' +
                    '</div>' +
                    '</a>' +
                    '</article>' +
                    '</div>';
            }

            // Update the search results and pagination
            if (isAppend) {
                jQuery('#search-results').append(searchResultsHtml);
            } else {
                jQuery('#search-results').html(searchResultsHtml);
            }
            currentPage = page;
            totalPages = xhr.getResponseHeader('X-WP-TotalPages');
            var hasAvailablePosts = (posts.length > 0) || (totalPages > 0 && currentPage <= totalPages);

            // Show or hide load more button based on number of search results and total pages
            if (isLoadMore) {
                if (hasAvailablePosts && currentPage < totalPages) {
                    jQuery('#load-more').show();
                } else {
                    jQuery('#load-more').hide();
                }
            } else {
                if ((category || search) && (totalPages === 1 || posts.length < postsPerPage)) {
                    jQuery('#load-more').hide();
                } else {
                    jQuery('#load-more').show();
                }
            }

            // Hide the "Load More" button if there are no more available posts
            if (currentPage >= totalPages) {
                jQuery('#load-more').hide();
            }
            // Hide category buttons if there are no search results
            if (posts.length === 0) {
                jQuery('#category-filter').fadeOut();
                jQuery('#search-results').append('<div class="d-flex justify-content-center align-items-center mt-5 text-white"><h3>هیچ پستی یافت نشد.</h3></div>');
            } else {
                jQuery('#category-filter').fadeIn();
            }
            isGetPostsRunning = false;
        },
        error: function(xhr, status, error) {
            console.log(xhr);
            console.log(status);
            console.log(error);
            hideLoadingSpinner();
            isGetPostsRunning = false;
        }
    });
}



/// Function to handle load more button click
function handleLoadMoreClick() {
    isLoadMore = true;
    // Get new posts for the current search query and next page
    getPosts(currentPage + 1, currentCategory, currentSearch, true);
    setTimeout(function (){
        window.scrollTo({
            top: document.body.scrollHeight,
            behavior: 'smooth'
        });
    },700)
}


var searchTimeout;

function handleSearchInputChange() {
    // Get search query from input field
    var search = jQuery('#search-input').val();

    // If search query has changed, update current search and get new posts
    if (search !== currentSearch) {
        currentSearch = search;
        // Reset current page to 1
        currentPage = 1;

        // If search query has 3 or more characters, update the category list
        if (currentSearch.length >= 1) {
            // Clear the previous search timeout
            clearTimeout(searchTimeout);

            // Wait for 500ms before making the request to server
            searchTimeout = setTimeout(function() {
                // Call the getPosts function with the search query
                getPosts(currentPage, currentCategory, currentSearch);
            }, 500);

            getCategoryList(currentSearch);
        }
    }
    // If search input is empty, show all posts and categories
    if (search === '') {
        getPosts(currentPage, currentCategory, '');
        getCategoryList('');
    }
}


// Event listener for category buttons
jQuery(document).on('click', '.category-button', function() {
    // Remove active class from currently active category button (if any)
    jQuery('.category-button[data-active="true"]').removeClass('active').attr('data-active', 'false');

    // Get the selected category ID
    var categoryId = jQuery(this).data('category');
    // Reset current page to 1
    currentPage = 1;
    // Update current category
    currentCategory = categoryId;

    // Add active class to clicked category button
    jQuery(this).addClass('active').attr('data-active', 'true');

    // Replace search results HTML instead of appending to it
    jQuery('#search-results').html('');

    // Call the getPosts function with the category filter and search query
    getPosts(currentPage, currentCategory, currentSearch);

    // Replace category filter HTML instead of appending to it
    getCategoryList(currentSearch);
});


var categoryListGenerated = false;

function getCategoryList(search) {
    var apiUrl = jsData.root_url + '/wp-json/wp/v2/posts?per_page=50';
    if (search) {
        apiUrl += '&search=' + encodeURIComponent(search);
    }
    jQuery.ajax({
        url: apiUrl,
        type: 'GET',
        success: function(posts) {

            // Get all categories from posts (excluding Uncategorized category)
            var allCategories = [];
            posts.forEach(function(post) {
                post.categories.forEach(function(category) {
                    if (category !== 1 && !allCategories.includes(category)) {
                        allCategories.push(category);
                    }
                });
            });

            // Retrieve category names from API in bulk
            jQuery.ajax({
                url: jsData.root_url + '/wp-json/wp/v2/categories?per_page=100',
                type: 'GET',
                success: function(categories) {
                    // Map category ID to category name
                    var categoryNameById = {};
                    categories.forEach(function(category) {
                        categoryNameById[category.id] = category.name;
                    });

                    var html = '';
                    html += '<li class="nav-item"><button class="category-button active filterPortfolio lazy text-danger text-center position-relative d-inline-block px-4 py-2 nav-link" data-active="true" data-category="">مشاهده همه</button></li>';
                    allCategories.forEach(function(category, index) {
                        var isActive = (category == currentCategory) ? ' active' : '';
                        html += '<li class="nav-item"><button class="category-button filterPortfolio lazy text-danger text-center position-relative d-inline-block px-4 py-2 nav-link' + isActive + '" data-category="' + category + '">' + categoryNameById[category] + '</button></li>';
                    });

                    jQuery('#category-filter').html(html);

                    categoryListGenerated = true;
                    jQuery('.category-button').removeClass('active');
                    jQuery('.category-button[data-category="' + currentCategory + '"]').addClass('active');
                }
            });
        }
    });
}








// Attach event listeners to load more button and search input field
jQuery('#load-more').on('click', handleLoadMoreClick);
jQuery('#search-input').on('keyup', _.debounce(handleSearchInputChange, 100));


// Get initial posts and category list
getPosts(currentPage, currentCategory, currentSearch);
getCategoryList(currentSearch);
