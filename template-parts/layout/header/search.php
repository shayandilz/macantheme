<?php

$url = $_SERVER["REQUEST_URI"];
$slugEN = strpos($url, 'en');
?>

<div class="container position-relative">
    <form class="w-100 search-form"
          method="get"
          action="<?php echo esc_url(home_url('/')); ?>">
        <div>
            <input id="search-form" type="search"  name="s" class="s form-control pe-4 bg-light"
                   placeholder="<?php echo $slugEN ? 'Search' : 'جستجو'; ?>"
                   aria-label="Search">

            <button type="submit" class="search-submit position-absolute start-50 end-50 top-100 px-2 border-1 border-white text-white mt-3 px-4 py-2 translate-middle-x" style="background-color: rgba(255, 255, 255, 0.15);width: fit-content">

                <?php echo $slugEN ? 'More' : 'بیشتر'; ?>
            </button>
        </div>
    </form>
<!--    <button type="button"-->
<!--            class="btn-close text-reset mobile-overlay__close d-xl-none d-none mt-2">-->
<!--    </button>-->
    <div class="search-overlay__results search-box-overflow">

    </div>
</div>
