<?php
//image size
if (get_field('image_size') == 'ratio1x1') {
    $ratioClass = 'ratio-1x1';
} elseif (get_field('image_size') == 'ratio16x9') {
    $ratioClass = 'ratio-16x9';
}
//column numbers
if (get_field('image_columns') == 'col-12') {
    $col_class = 'col-12';
} elseif (get_field('image_columns') == 'col-md-6') {
    $col_class = 'col-6';
} elseif(get_field('image_columns') == 'col-md-4') {
    $col_class = 'col-md-4 col-12';
}
if (have_rows('gallery')): ?>
    <ul class="slides row justify-content-center list-unstyled g-1">
        <?php $i = 0;
        while (have_rows('gallery')): the_row();
            $i++;
            $media_type = get_sub_field('media_type');
            $image = get_sub_field('image');
            $thumb = wp_get_attachment_image_src( $image['ID'], '300-thumbnail' ); // 'thumbnail' can be replaced with any available image size in your theme
            $video = get_sub_field('video');
            $cover = get_sub_field('cover');
            $thumb_cover = wp_get_attachment_image_src( $cover['ID'], '300-thumbnail' ); // 'thumbnail' can be replaced with any available image size in your theme
            if ($media_type == 'Image') { ?>
                <li class="<?= $col_class; ?>">
                    <a href="#portfolioModal" data-slide="<?= $i ?>" class="play-btn"
                       data-bs-toggle="modal">
                        <div class="<?= $ratioClass; ?> ratio">
                            <img class="object-fit" src="<?= esc_url( $thumb[0] ); ?>"
                                 alt="<?= $image['alt'] ?>">
                            <div class="position-absolute w-100 h-100 start-0 top-0 d-flex justify-content-center align-items-center lazy card-overlay fs-5">
                                <i class="bi bi-eye-fill"></i>
                            </div>
                        </div>

                    </a>
                </li>
            <?php } elseif ($media_type == 'Video') { ?>
                <li class="<?= $col_class; ?>">
                    <div class="position-relative">
                        <a href="#portfolioModal" data-slide="<?= $i ?>"
                           data-url="<?= $video['url']; ?>"
                           data-title="<?php the_title(); ?>"
                           data-bs-toggle="modal"
                           class="play-btn">
                            <div class="<?= $ratioClass; ?> ratio">
                                <img class="object-fit" src="<?= esc_url( $thumb_cover[0] ); ?>"
                                     alt="<?= $cover['alt'] ?>">
                                <div class="position-absolute w-100 h-100 start-0 top-0 d-flex justify-content-center align-items-center lazy card-overlay fs-5">
                                    <i class="bi bi-play-fill"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </li>
            <?php }; endwhile;
        wp_reset_postdata(); ?>
    </ul>
<?php endif; ?>