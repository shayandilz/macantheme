<div class="row px-5 align-items-center g-4 g-sm-2 justify-content-between mt-0 mt-lg-5">
    <?php
    $i = 0;
    if (have_rows('services_icon_lists')):
        while (have_rows('services_icon_lists')) : the_row();
            $i++;
            $icon = get_sub_field('icon');
            $title = get_sub_field('title'); ?>

                <div class="col-sm col-12 text-center d-flex align-items-center justify-content-center gap-3 flex-column"
                     data-aos="zoom-in"
                     data-aos-delay="<?= $i; ?>00">
                    <div class="rounded-circle bg-opacity-50 bg-white mx-auto text-dark" title=" <?= $title; ?>">
                        <span class="<?= $icon; ?> d-flex justify-content-center align-items-center font-size-icon"></span>
                    </div>
                    <h5 class="fs-6 text-white fw-semibold text-center">
                        <?= $title; ?>
                    </h5>
                </div>
        <?php endwhile;
    endif;
    ?>
</div>