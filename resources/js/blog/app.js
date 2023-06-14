import $ from 'jquery';

class Blog {
    constructor() {
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
        $('#search-input').on('keyup', () => {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                const keyword = $('#search-input').val();
                this.searchPosts(keyword);
            }, 500);
        });
        $('#load-more').click(() => {
            this.loadMorePosts();
        });
    }

    loadLatestPosts() {
        const spinner = $('#loading-spinner');
        spinner.toggleClass('d-flex', true); // Show the spinner
        $.getJSON(jsData.root_url + '/wp-json/wp/v2/posts', (response) => {
            this.posts = response.map(post => {
                return {
                    title: post.title.rendered,
                    content: post.content.rendered,
                    date: post.date,
                    link: post.link,
                    slug : post.slug,
                    categories: post.categories
                };
            });
            this.getCategories();
            const categoryId = window.location.hash.substring(1);
            if (categoryId) {
                // Render the posts for the category with the matching ID
                this.renderPosts(categoryId, 1);
                this.currentCategory = categoryId;
            } else {
                // Render all posts if no category ID is present
                this.renderPosts();
            }
        })
            .fail(() => {
                console.error('Error: Could not retrieve latest posts.');
            })
            .always(() => {
                spinner.hide(); // Hide the spinner after the request is completed
                spinner.toggleClass('d-flex', false);
            })
            .done(() => {
                // Call renderButtons to show all categories at first
                this.renderButtons();
            });

    }

    renderPosts(categoryId = null, page = 1, keyword = null, isLoadMore = false) {
        const spinner = $('#loading-spinner');
        spinner.toggleClass('d-flex', true); // Show the spinner
        if (categoryId !== null) {
            this.currentPage = 1; // reset page to 1 when new category is selected
        }
        const container = $('#search-results');
        if (this.currentPage === 1) {
            container.empty();
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
        $.getJSON(categoriesUrl, (response) => {
            const newCategories = response.map(category => {
                return {
                    id: category.id,
                    name: category.name
                };
            });

            // Update the categories array with new categories
            this.categories = newCategories;

            // Rest of the code...
        })
            .fail(() => {
                console.error('Error: Could not retrieve categories for new posts.');
            });
        $.getJSON(apiUrl, (data, status, xhr) => {
            postsToRender = data.map(post => {
                return {
                    title: post.title.rendered,
                    content: post.excerpt.rendered.slice(0, 86) + '...',
                    date: post.date,
                    link: post.link,
                    image: post.fimg_url,
                    categories: post.categories
                };
            })
            this.totalPages = xhr.getResponseHeader('X-WP-TotalPages')
            if (keyword === '') {
                // Clear the search and display all posts
                this.loadLatestPosts();
            }
            if (postsToRender.length === 0) {
                const noPostsHtml = '<div class="d-flex justify-content-center align-items-center mt-5 text-white"><h3>هیچ پستی یافت نشد.</h3></div>';
                container.append(noPostsHtml);
            } else {
                this.displayPosts(postsToRender);
            }
            spinner.hide(); // Hide the spinner after the request is completed
            spinner.toggleClass('d-flex', false);
            if (isLoadMore) {
                setTimeout(function() {
                    window.scrollTo({
                        top: document.body.scrollHeight,
                        behavior: 'smooth'
                    });
                }, 0);
            }
        });
    }


    loadMorePosts() {
        if (this.currentPage < this.totalPages) {
            this.currentPage++;
            this.renderPosts(null, this.currentPage,null, true);
        }

    }

    displayPosts(posts) {
        const container = $('#search-results');
        if (this.currentPage === 1) {
            // container.empty();
        }
        let i = 0
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
                    return `<span class="category">${category.name}</span>`;
                }
                return '';
            }).join('');

            const postHtml = `<div class="col-lg-4 col-md-6">
        <article data-aos-delay="${i}00" data-aos="zoom-in" class="position-relative overflow-hidden" title="${title}">
          <span class="d-inline-block position-absolute top-0 end-0 z-top p-2 small text-white" style="background-color: rgba(0, 0, 0, .5) !important">${categoriesHtml}</span>
          <a href="${link}">
            <div class="ratio ratio-16x9">
              <img src="${image}" class="object-fit" alt="${title}">
            </div>
            <div class="position-absolute bottom-0 start-0 h-100 w-100 d-flex justify-content-center align-items-end">
              <div class="textBlog h-100 w-100 text-center lazy">
                <p class="title text-center text-white position-absolute bottom-0 start-0 end-0 lazy">${title}</p>
                <div class="excerpt position-absolute bottom-0 start-0 end-0 mb-3 fs-6 text-white lazy">${excerpt}</div>
              </div>
            </div>
          </a>
        </article>
      </div>`;

            container.append(postHtml);
        });
        if (this.currentPage == this.totalPages) {
            $('#load-more').hide();
        }
    }


    searchPosts(keyword, categoryId = null) {
        const container = $('#search-results');
        container.empty();
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
        const searchResult = $('#search-results');
        container.empty(); // Clear the container
        if (this.categories.length > 0) { // add this check
            const categoryId = Number(window.location.hash.substring(1));
            this.categories.forEach(category => {
                const button = $('<button>').text(category.name).addClass('button-dark button');
                button.click(() => {
                    container.find('button').removeClass('active');
                    button.addClass('active');
                    this.renderPosts(category.id, 1);
                    this.currentCategory = category.id;
                    window.location.hash = '';
                    // searchResult.empty(); // Clear the container
                    $('#load-more').show();
                });
                const listItem = $('<li>').addClass('nav-item').append(button);
                container.append(listItem);
                // Check if the current category matches the category ID in the URL's hashtag
                if (category.id === categoryId) {
                    // // Activate the button for the category with the matching ID
                    button.addClass('active');
                    this.currentCategory = category.id;
                }
            });

        }
    }

    getCategories() {
        const categoriesUrl = jsData.root_url + '/wp-json/wp/v2/categories?per_page=100';
        $.getJSON(categoriesUrl, (response) => {
            this.categories = response.map(category => {
                return {
                    id: category.id,
                    name: category.name
                };
            });
            this.renderButtons();
        })
            .fail(() => {
                console.error('Error: Could not retrieve categories.');
            });
    }

    getCategoriesForPosts(posts) {
        const categories = [];
        posts.forEach(post => {
            post.categories.forEach(category => {
                if (!categories.some(cat => cat.id === category)) {
                    const newCategory = this.categories.find(cat => cat.id === category);
                    categories.push(newCategory);
                }
            });
        });
        return categories;
    }

    updateCategories() {
        const newCategories = [];
        this.posts.forEach(post => {
            post.categories.forEach(category => {
                const index = newCategories.findIndex(c => c.id === category);
                if (index === -1) {
                    const cat = this.categories.find(c => c.id === category);
                    newCategories.push(cat);
                }
            });
        });
        this.categories = newCategories;
        this.renderButtons();
    }
}

export default Blog;
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


