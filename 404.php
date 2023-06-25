<?php
get_header();
?>

    <section class="h-100 w-100 position-relative overflow-x-hidden overflow-y-hidden bg-danger">
        <div class="container">
            <div class="row px-0 min-vh-100 justify-content-center align-items-center">
                <div class="col-lg-8 d-flex flex-column justify-content-center text-center text-white">
                    <h4>
                        متاسفانه صفحه‌ی مورد نظر شما یافت نشد !
                    </h4>
                    <p>
                        از طریق باکس زیر آن را جست‌وجو کنید :
                    </p>
                    <form class="searchform w-100" role="search" method="get" action="https://macan.agency/">
                        <label for="search" class="screen-reader-text">Search:</label>
                        <input type="text" class="field searchform-s w-100" name="s" value="" placeholder="عبارت مورد نظرتان را تایپ و دکمه&zwnj;ی اینتر را فشار دهید ...">
                        <input type="submit" class="assistive-text searchsubmit d-none" value="Go!">
                        <a href="#go" class="submit"></a>
                    </form>
                </div>
            </div>
        </div>
    </section>


<?php get_footer();

