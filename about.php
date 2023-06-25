<?php /* Template Name: About */
get_header();
?>

    <section class="h-100 w-100 position-relative overflow-x-hidden overflow-y-hidden">
        <div class="d-none d-lg-block">
            <?php
            $slider = get_field('slider_field');
            echo do_shortcode('' . $slider); ?>
        </div>
        <div class="d-block d-lg-none">
            <?php if (have_rows('about_us_sections')):
                $total_rows = count(get_field('about_us_sections')); // Get the total number of rows in the repeater
                $current_row = 0; // Initialize the current row index
                ?>
                <div class="d-flex flex-column">
                    <?php while (have_rows('about_us_sections')): the_row();
                        $current_row++; // Increment the current row index
                        $image = get_sub_field('image');
                        $text = get_sub_field('text');
                        $color = get_sub_field('color');
                        ?>

                        <?php
                        if ($current_row !== $total_rows) { ?>
                            <div style="background-color: <?= $color ?>"
                                 class="pt-5 container-fluid d-flex justify-content-center flex-column">
                                <div class="text-start text-white pt-5 lh-lg">
                                    <?= $text ?>
                                </div>
                                <img class="img-fluid" src="<?= $image['url']; ?>" alt="<?= $image['alt']; ?>">
                            </div>
                        <?php } else { ?>
                            <div style="background-color: <?= $color ?>"
                                 class="pt-5 container-fluid d-flex justify-content-center flex-column">
                                <h6 class="text-start mb-4 text-white">ارزش‌ها به سبک ماکان</h6>
                                <img class="img-fluid" src="<?= $image['url']; ?>" alt="<?= $image['alt']; ?>">
                                <div class="text-start text-white pt-5 lh-lg">
                                    <?= $text ?>
                                </div>

                            </div>
                        <?php } ?>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>


<?php get_footer();

