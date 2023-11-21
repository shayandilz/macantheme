<?php
if (have_rows('section_5')):
    while (have_rows('section_5')): the_row();
        $tab_name = get_sub_field('tab_name');
        $section_title = get_sub_field('section_title');
        $image = get_sub_field('background_image');
        $color = get_sub_field('background_color');

        $url = $_SERVER["REQUEST_URI"];
        $slugEN = strpos($url, '/en/');
        ?>
        <section class="h-100 w-100 py-5 py-lg-0 overflow-hidden position-relative d-flex justify-content-center align-items-center mobile-section-bg aos-remover"
                 style="background-color: <?php echo esc_attr($color); ?>"
                 data-name="<?= $tab_name; ?>">
            <div class="container">
                <div class="row px-lg-0 mx-lg-0 justify-content-lg-between justify-content-center">
                    <div class="col-lg-5">
                        <img data-aos="fade-up" data-aos-duration="3000" data-aos-disable
                             class="position-absolute bottom-0 <?php echo $slugEN ? 'end-0' : 'start-0'; ?> w-75 section5"
                             alt="<?php echo $image['alt']; ?>"
                             title="<?php echo $image['alt']; ?>"
                             src="<?php echo esc_url($image['url']); ?>">
                    </div>
                    <div class="col-lg-6 g-2 row flex-row-reverse justify-content-center align-content-center mb-5 z-top">
                        <h2 class="text-center text-white" data-aos="fade-down" data-aos-delay="100">
                            <?= $section_title; ?>
                        </h2>
                        <div class="row g-4 justify-content-center px-0">
                            <?php
                            $d = 0;
                            // Get the post objects from the clients_list field
                            $selected_clients = get_sub_field('clients_list');
                            if ($selected_clients) {
                                foreach ($selected_clients as $client) {
                                    $d++; ?>

                                    <div class="col-lg-3 col-4" title="<?php echo get_the_title($client); ?>" data-aos="zoom-in"
                                         data-aos-delay="<?= $d; ?>00">
                                        <?php
                                        $client_image = get_field('img_class', $client);
                                        $client_attr = get_field('client_attr', $client);
                                        if (!empty($client_attr)): ?>
                                            <img class="<?= $client_image; ?>" width="100" height="100"
                                                 src="<?php echo $client_attr; ?>"
                                                 alt="<?php echo get_the_title($client); ?>"/>
                                        <?php endif; ?>
                                    </div>
                                <?php }
                            }
                            ?>
                        </div>

                    </div>
                </div>
            </div>

        </section>
    <?php
    endwhile;
endif; ?>
