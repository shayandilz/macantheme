import $ from 'jquery';
import 'regenerator-runtime/runtime'; // Import the regenerator runtime for async/await support

class Blog {
    constructor() {
        this.searchInput = $('#search-input');
        this.searchResults = $('#search-results');
        this.loadingSpinner = $('#loading-spinner');

        this.currentPage = 1;
        this.perPage = 9;
        this.totalPages = 1;
        this.posts = [];
        this.categories = [];
        this.currentCategory = null;
        this.isLoadMore = false;
        this.loadLatestPosts();
        this.bindEvents();


    }

    bindEvents() {
        let timeout = null;
        $(document).on('keyup', '#search-input', () => {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                const keyword = this.searchInput.val();
                this.searchPosts(keyword);
            }, 500);
        });
        $(document).on('click', '#load-more', () => {
            this.loadMorePosts();
        });

    }

    async loadLatestPosts() {
        this.searchResults.empty();
        this.loadingSpinner.toggleClass('d-flex', true);
        try {
            const response = await $.getJSON(jsData.root_url + '/wp-json/wp/v2/posts');
            this.posts = response.map(post => {
                return {
                    title: post.title.rendered,
                    content: post.content.rendered,
                    date: post.date,
                    link: post.link,
                    slug: post.slug,
                    categories: post.categories
                };
            });
            await this.getCategories();
            const categoryId = parseInt(localStorage.getItem('categoryID'));
            if (categoryId) {
                // Render the posts for the category with the matching ID
                await this.renderPosts(categoryId, 1);
                this.currentCategory = categoryId;
            } else {
                // Render all posts if no category ID is present
                await this.renderPosts();
            }
        } catch (error) {
            console.error('Error: Could not retrieve latest posts.', error);
        } finally {
            this.loadingSpinner.hide();
            this.loadingSpinner.toggleClass('d-flex', false);
            this.renderButtons();
        }
    }

    async renderPosts(categoryId = null, page = 1, keyword = null, isLoadMore = false) {
        this.loadingSpinner.toggleClass('d-flex', true);
        if (categoryId === null && this.currentCategory === null) {
            categoryId = null; // Set categoryId to null if both are null
        }
        if (this.currentPage === 1) {
            this.searchResults.empty();
        }
        let postsToRender = [];
        let apiUrl = jsData.root_url + '/wp-json/wp/v2/posts?page=' + page + '&per_page=' + this.perPage;
        if (categoryId || this.currentCategory) {
            const catId = categoryId || this.currentCategory;
            apiUrl += `&categories=${catId}`;
        }
        if (keyword) {
            apiUrl += `&search=${keyword}`;
        }
        // Fetch categories for the new posts
        const categoriesUrl = `${jsData.root_url}/wp-json/wp/v2/categories?include=${postsToRender.map(post => post.categories).flat().join(",")}`;
        try {
            const categoriesResponse = await fetch(categoriesUrl);
            const response = await categoriesResponse.json();
            const newCategories = response.map(category => {
                return {
                    id: category.id,
                    name: category.name
                };
            });

            // Update the categories array with new categories
            this.categories = newCategories;

            const dataResponse = await fetch(apiUrl);
            const data = await dataResponse.json();
            postsToRender = data.map(post => {
                return {
                    title: post.title.rendered,
                    content: post.excerpt.rendered.slice(0, 86) + '...',
                    date: post.date,
                    link: post.link,
                    image: post.fimg_url,
                    categories: post.categories
                };
            });
            const totalPages = dataResponse.headers.get('X-WP-TotalPages');
            this.totalPages = totalPages;
            if (keyword === '') {
                // Clear the search and display all posts
                await this.loadLatestPosts();
            }
            if (postsToRender.length === 0 && !window.location.href.includes('/en')) {
                const noPostsHtml = '<div class="d-flex justify-content-center align-items-center mt-5 text-dark"><h3>هیچ پستی یافت نشد.</h3></div>';
                this.searchResults.append(noPostsHtml);
            }else if (postsToRender.length === 0 && window.location.href.includes('/en')){
                const noPostsHtml = '<div class="d-flex justify-content-center align-items-center mt-5 text-dark"><h3>Nothing Found.</h3></div>';
                this.searchResults.append(noPostsHtml);
            }
            else {
                await this.displayPosts(postsToRender);
            }
            this.loadingSpinner.hide(); // Hide the spinner after the request is completed
            this.loadingSpinner.toggleClass('d-flex', false);
            if (isLoadMore) {
                setTimeout(function () {
                    window.scrollTo({
                        top: document.body.scrollHeight,
                        behavior: 'smooth'
                    });
                }, 0);
            }
        } catch (error) {
            console.error('Error: Could not retrieve categories for new posts.');
        }
    }

    loadMorePosts() {
        if (this.currentPage < this.totalPages) {
            this.currentPage++;
            this.renderPosts(null, this.currentPage, null, true);
        }

    }

    async displayPosts(posts) {
        let i = 0;
        posts.forEach(post => {
            i++;
            const title = post.title;
            const link = post.link;
            const image = post.image;
            const excerpt = post.content;
            const categories = post.categories;
            const categoriesHtml = categories.map(catId => {
                const category = this.categories.find(cat => cat.id === catId);
                if (category) {
                    return `<span data-category-id="${category.id}" class="category category-button">${category.name}</span>`;
                }
                return '';
            }).join('');

            const postHtml = `<div class="col-lg-4 col-md-6">
      <article data-aos-delay="${i}00" data-aos="zoom-in" class="position-relative overflow-hidden" title="${title}">
        <span class="d-inline-block position-absolute top-0 end-0 z-top p-2 small text-white " style="background-color: rgba(0, 0, 0, .5) !important">${categoriesHtml}</span>
        <a target="_blank" href="${link}">
          <div class="ratio ratio-16x9">
            <img src="${image}" class="object-fit" alt="${title}">
          </div>
          <div class="position-absolute bottom-0 start-0 h-100 w-100 d-flex justify-content-center align-items-end">
            <div class="textBlog h-100 w-100 text-center lazy">
              <p class="title text-center text-white position-absolute bottom-0 start-0 end-0 lazy">${title}</p>
              <div class="excerpt position-absolute bottom-0 start-0 end-0 mb-3 fs-6 text-white lazy px-3">${excerpt}</div>
            </div>
          </div>
        </a>
      </article>
    </div>`;

            this.searchResults.append(postHtml);
        });
        // Run the provided code after posts are rendered
        $(document).ready(function () {
            $('.category-button').click(function () {
                let categoryId = $(this).data('category-id');
                localStorage.setItem('categoryID', categoryId);

                // Check if the current URL contains "/blog"
                if (window.location.href.includes('/blog')) {
                    location.href = window.location.href; // Refresh the page
                } else {
                    window.location.href = 'blog/';
                }
            });
        });
        if (this.currentPage == this.totalPages) {
            $('#load-more').hide();
        }
    }

    searchPosts(keyword, categoryId = null) {
        this.searchResults.empty();
        this.renderPosts(categoryId, 1, keyword);
        const url = `${jsData.root_url}/wp-json/wp/v2/posts?search=${keyword}`;
        $.getJSON(url, (data) => {
            this.posts = data.map(post => {
                return {
                    categories: post.categories
                };
            });
            // Get categories for search results
            const categoriesUrl = `${jsData.root_url}/wp-json/wp/v2/categories?include=${this.posts.map(post => post.categories).flat().join(",")}`;
            $.getJSON(categoriesUrl, (response) => {
                this.categories = response.map(category => {
                    return {
                        id: category.id,
                        name: category.name
                    };
                });
                this.renderButtons();
                // this.renderPosts();
            })
                .fail(() => {
                    console.error('Error: Could not retrieve categories for search results.');
                });
        })
            .fail(() => {
                console.error('Error: Could not retrieve search results.');
            });
    }

    renderButtons() {
        const container = $('#category-filter');
        container.empty(); // Clear the container

        if (this.categories.length > 0) {
            const categoryId = parseInt(localStorage.getItem('categoryID'));
            console.log(categoryId)
            // Render all the category buttons except "Uncategorized"
            const excludedIds = [1, 23]; // Add more IDs to exclude if needed
            const categoryButtons = this.categories
                .filter(category => !excludedIds.includes(category.id))
                .map(category => {
                    const button = $('<button>').text(category.name).addClass('button-dark button p-1 px-lg-4');
                    button.click(() => {
                        container.find('button').removeClass('active');
                        button.addClass('active');
                        this.renderPosts(category.id, 1);
                        this.currentCategory = category.id;
                        $('#load-more').show();
                    });
                    return $('<li>').addClass('nav-item').append(button);
                });

            // Render the "Uncategorized" button
            const uncategorizedButton = this.categories.find(category => category.id === 1 || category.id === 23);
            if (uncategorizedButton) {
                const button = $('<button>').text(uncategorizedButton.name).addClass('button-dark button p-1 px-lg-4');
                button.click(() => {
                    container.find('button').removeClass('active');
                    button.addClass('active');
                    this.renderPosts(uncategorizedButton.id, 1);
                    this.currentCategory = uncategorizedButton.id;
                    $('#load-more').show();
                });
                const listItem = $('<li>').addClass('nav-item').append(button);
                categoryButtons.push(listItem);
            }

            // Render the "All" button

            const allButton = $('<button>').addClass('button-dark button active p-1 px-lg-4');
            if (window.location.href.includes('/en')) {
                allButton.text('All');
            } else {
                allButton.text('مشاهده همه');
            }
            allButton.click(() => {
                container.find('button').removeClass('active');
                allButton.addClass('active');
                this.loadLatestPosts();
                localStorage.setItem('categoryID', '');
                this.currentCategory = null;
                $('#load-more').show();
            });
            const listItem = $('<li>').addClass('nav-item').append(allButton);
            categoryButtons.unshift(listItem);

            container.append(categoryButtons);

            // Check if the current category matches the category ID in the URL's hashtag
            if (categoryId) {
                const activeButton = container.find(`button[data-id="${categoryId}"]`);
                if (activeButton) {
                    container.find('button').removeClass('active');
                    activeButton.addClass('active');
                    this.currentCategory = categoryId;
                }
            }
        }
    }

    async getCategories() {
        const categoriesUrl = jsData.root_url + '/wp-json/wp/v2/categories';
        try {
            const response = await fetch(categoriesUrl);
            const data = await response.json();
            this.categories = data.map(category => {
                return {
                    id: category.id,
                    name: category.name
                };
            });
            this.renderButtons();
        } catch (error) {
            console.error('Error: Could not retrieve categories.');
        }
    }


}
document.addEventListener('DOMContentLoaded', function () {
    const blog = new Blog();

    //     handle search animation for blog archive
    // Handle search input focus and blur events
    $("#search-input").focus(function () {
        $(".search-box").addClass("border-searching");
        $(".search-icon").addClass("si-rotate");
    });

    $("#search-input").blur(function () {
        $(".search-box").removeClass("border-searching");
        $(".search-icon").removeClass("si-rotate");
    });
})