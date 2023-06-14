import $ from 'jquery';

class Search {
    // 1. describe and create/initiate our object
    constructor() {
        // this.addSearchHTML();

        this.openButton = $(".js-search-trigger");
        this.closeButton = $(".search-close, .mobile-overlay__close");
        this.searchOverlay = $(".search-overlay");
        this.searchField = $("#search-form");
        this.resultsDiv = $(".search-overlay__results");
        this.searchSubmit = $(".search-submit");

        this.searchSubmit.fadeOut()
        
        this.events();

        this.isOverlayOpen = false;
        this.isSpinnerVisible = false;

        this.previousValue;
        this.typingTimer;
    }

    // 2.events
    events() {
        this.openButton.on("click", this.openOverlay.bind(this));
        this.closeButton.on("click", this.closeOverlay.bind(this));

        $(document).on("keydown", this.keyPressDispatcher.bind(this));

        this.searchField.on("keyup", this.typingLogic.bind(this));
    }


    // 3. methods (function, action...)

    typingLogic() {
        if (this.searchField.val()) {
            $(".mobile-overlay__close").removeClass('d-none');
        }
        if (this.searchField.val() != this.previousValue) {
            clearTimeout(this.typingTimer);
            if (this.searchField.val()) {
                if (!this.isSpinnerVisible) {
                    this.resultsDiv.html(`<div class="text-center mt-4"><div class="spinner-border align-baseline text-white" role="status"></div></div>`);
                    this.isSpinnerVisible = true;

                }
                this.typingTimer = setTimeout(this.getResults.bind(this), 750);

            } else {
                this.resultsDiv.html('');
                this.isSpinnerVisible = false;
                this.searchSubmit.fadeOut()
            }
        }
        this.previousValue = this.searchField.val();
    }

    getResults() {
        $.getJSON(jsData.root_url + '/wp-json/search/v1/search?term=' + this.searchField.val(), (results) => {
            this.resultsDiv.html(`
                <div class="pt-3">
                        <h5  class="my-3 text-white text-center ">مقالات</h5>
                        ${results.post.length ? '<div class="row g-2">' : '<p class="p-2 m-0 border-top">هیچ مقاله ای یافت نشد</p>'}
                        ${results.post.map((item, index) =>
                `<div class="col-lg-4 col-md-6">
                                <article class="position-relative overflow-hidden" title="${item.title}">
                                    <span class="d-inline-block position-absolute top-0 end-0 z-top p-2 small text-white" style="background-color: rgba(0, 0, 0, .5) !important">
                                        ${item.category}
                                    </span>
                                    <a href="${item.url}">
                                        <div class="ratio ratio-16x9">
                                            <img class="object-fit" src="${item.img}" alt="${item.title}">
                                        </div>
                                        <div class="position-absolute bottom-0 start-0 h-100 w-100 d-flex justify-content-center align-items-end">
                                            <div class="textBlog h-100 w-100 text-center">
                                            <p class="title text-center text-white position-absolute bottom-0 start-0 end-0 ">${item.title}</p>
                                            <div class="excerpt position-absolute bottom-0 start-0 end-0 mb-3 fs-6"><p class="text-white px-2">${item.content}</p></div>
                                            </div>
                                        </div>
                                    </a>
                                </article>
                            </div>`
            ).join(' ')}
                        ${results.post.length ? '</div>' : ''}
                </div>
            `)
            this.isSpinnerVisible = false;
            this.searchSubmit.fadeIn()
        });
    }

    keyPressDispatcher(e) {
        if (e.keyCode == 83 && !this.isOverlayOpen && !$("input, textarea").is(':focus')) {
            this.openOverlay();
        }
        if (e.keyCode == 27 && this.isOverlayOpen) {
            this.closeOverlay();
        }
    }

    openOverlay() {
        this.searchOverlay.addClass("search-overlay--active");
        $("body").addClass("body-no-scroll");

        this.searchField.val('');

        setTimeout(() => this.searchField.focus(), 301);

        this.isOverlayOpen = true;
        return false;

    }

    closeOverlay() {
        this.searchOverlay.removeClass("search-overlay--active");
        $("body").removeClass("body-no-scroll");
        this.resultsDiv.html('');
        $(".mobile-overlay__close").addClass('d-none');
        this.searchField.val('');
        this.isOverlayOpen = false;
    }


}

export default Search;