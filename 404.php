<?php
get_header();

$url = $_SERVER["REQUEST_URI"];
$slugEN = strpos($url, 'en/');
?>

    <section class="h-100 w-100 position-relative overflow-x-hidden overflow-y-hidden bg-danger">
        <div class="container">
            <div class="row px-0 min-vh-100 justify-content-center align-items-center">
                <div class="col-lg-8 d-flex flex-column justify-content-center text-center text-white">
                    <h4>
                        <?php echo $slugEN ? '404 - You are Lost!' : 'متاسفانه صفحه‌ی مورد نظر شما یافت نشد !'; ?>
                    </h4>
                    <p>
                        <?php echo $slugEN ? 'Use the Search Below' : 'از طریق باکس زیر آن را جست‌وجو کنید : '; ?>

                    </p>
                    <hr>
                    <div class="text-center my-4">
                        <a class="MoreLink position-relative d-inline-block lazy fs-6 py-2"
                           data-aos="fade-down" data-aos-delay="300"
                           href="<?php echo esc_url(get_home_url()) ?>">
                            <?php echo $slugEN ? 'Go to Homepage' : ' بازگشت به صفحه اصلی'; ?>
                        </a>
                    </div>
                    <form class="searchform w-100" role="search" method="get" action="https://macan.agency/">
                        <label for="search" class="screen-reader-text">Search:</label>
                        <input type="text"
                               class="field searchform-s w-100 p-2"
                               name="s"
                               value=""
                               placeholder="<?php echo $slugEN ? 'Type in ...' : 'عبارت مورد نظرتان را تایپ و دکمه&zwnj;ی اینتر را فشار دهید ...'; ?>">
                        <input type="submit" class="assistive-text searchsubmit d-none" value="Go!">
                        <a href="#go" class="submit"></a>
                    </form>
                </div>
            </div>
        </div>
    </section>


<?php get_footer();

