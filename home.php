<?php
/** Template Name: Blog Page */

get_header(); ?>

    <section class="container py-5 min-vh-100 ">
        <div class="row  mt-5">
            <div class="col-lg-12 d-flex gap-4 flex-column align-items-center justify-content-stretch">
                <!-- Add a search input field -->
                <?php
                //    <!--Search -->
                get_template_part('template-parts/search-input-blog');
                ?>
                <ul class="nav-fill nav mt-5 mb-3" id="category-filter"></ul>
                <!-- Add a div to display search results -->
                <div class="position-relative w-100 min-vh-50">
                    <div id="search-results" class="row w-100 g-2 mx-0"></div>
                    <div id="loading-spinner" class="position-absolute w-100 h-100 top-0 end-0 justify-content-center align-items-center" style="background-color: #00000045">
                        <div  class="spinner-border text-light" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <!-- Add a load more button -->
                <div class="my-3">
                    <button class="button-dark button" id="load-more">بیشتر</button>
                </div>
            </div>
        </div>
    </section>
<?php get_footer(); ?>