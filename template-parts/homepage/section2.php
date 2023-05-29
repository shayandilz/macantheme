<?php
$section_2 = get_field('section_2');
if (have_rows('section_2')):
    while (have_rows('section_2')): the_row();
        $tab_name = get_sub_field('tab_name');
        $section_title = get_sub_field('section_title');
        $image = get_sub_field('background_image');
        $color = get_sub_field('background_color');
        $list_services = get_sub_field('select_services');
        ?>
        <section class="h-100 w-100 position-relative row px-0 mx-0 justify-content-between section2"
                 style="background-color: <?php echo $color ? esc_attr($color) : '#000' ?>"
                 data-name="<?= $tab_name; ?>">

            <div class="col-lg-7 g-5 gy-lg-5 row flex-row-reverse justify-content-center align-content-start align-content-lg-center mb-lg-5 m-0 custom-bg-opacity px-3 pb-5 pb-lg-0 px-lg-2 z-top">
                <h2 class="text-center text-white" data-aos="fade-down" data-aos-delay="100">
                   <?php if ($section_title){
                       echo $section_title;
                   }else{
                       echo 'No Data Selected';
                   } ?>
                </h2>
                <?php
                if ($list_services) {
                    $i = 0;
                    foreach ($list_services as $post):
                        $i++;
                        setup_postdata($post); ?>
                        <a href="<?php the_permalink(); ?>"
                           class="d-flex flex-column col-lg-3 col-6 justify-content-center align-items-center" aos-offset="50" data-aos="zoom-in"
                           data-aos-delay="<?= $i; ?>00">
                            <?php
                            $svg_icon = get_field('svg_icon');
                            if ($svg_icon) :
                                ?>
                                <div class="w-100 d-flex justify-content-center mb-4" title="<?php the_title(); ?>">
                                    <?php echo $svg_icon; ?>
                                </div>
                            <?php endif; ?>
                            <h2 class="text-center text-white small">
                                <?php the_title(); ?>
                            </h2>
                        </a>
                    <?php endforeach;
                }else{
                    echo 'No Data Selected';
                };
                wp_reset_postdata();
                ?>
            </div>
            <div class="col-lg-5 position-absolute bottom-0 end-0 custom-opacity-50" data-aos="fade-up" data-aos-duration="3000" data-aos-disable>
                <?php if ($image){ ?>
                    <img class="img-fluid"
                         src="<?php echo esc_url($image['url']); ?>"
                         alt="<?php echo esc_url($image['alt']); ?>"
                         title="<?php echo esc_url($image['alt']); ?>"
                    >
                <?php }else{
                    echo 'No Data Selected';
                } ?>
            </div>
        </section>
    <?php
    endwhile;
endif; ?>
