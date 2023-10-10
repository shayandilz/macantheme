<?php
$theme_uri = get_stylesheet_directory_uri();
$macbook = $theme_uri . '/public/images/macbook.png';
$iphone = $theme_uri . '/public/images/iphone.png';
$ipad = $theme_uri . '/public/images/ipad.png';


//get mockup value images
$mockups = get_field('mockup_image');
$website_url = get_field('website_url');
?>
<section class="container">
    <div class="position-relative d-none d-lg-block my-0"
         style="height: 75vh">
        <div class="mac position-absolute">
            <img class="w-100" src="<?php echo $macbook; ?>" alt="macbook-mockup">
            <div class="imgBX position-absolute"
                 style="background: url('<?php echo esc_url($mockups['desktop']['url']); ?>')"></div>
        </div>
        <div class="iphone position-absolute">
            <img class="w-100" src="<?php echo $iphone; ?>" alt="iphone-mockup">
            <div class="imgBX position-absolute"
                 style="background: url('<?php echo esc_url($mockups['phone']['url']); ?>')"></div>
        </div>
        <div class="ipad position-absolute">
            <img class="w-100" src="<?php echo $ipad; ?>" alt="ipad-mockup">
            <div class="imgBX position-absolute"
                 style="background: url('<?php echo esc_url($mockups['tablet']['url']); ?>')"></div>
        </div>

    </div>
    <div class="d-lg-none min-vh-75">
        <ul class="nav nav-tabs border-0 justify-content-center nav-fill" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="button button-white active p-3" id="home-tab" data-bs-toggle="tab"
                        data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane"
                        aria-selected="true">
                    <i class="bi bi-laptop fs-1 d-flex"></i>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="button button-white p-3" id="contact-tab" data-bs-toggle="tab"
                        data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane"
                        aria-selected="false">
                    <i class="bi bi-tablet fs-1 d-flex"></i>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="button button-white p-3" id="profile-tab" data-bs-toggle="tab"
                        data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane"
                        aria-selected="false">
                    <i class="bi bi-phone fs-1 d-flex"></i>
                </button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab"
                 tabindex="0">
                <div class="mac position-absolute">
                    <img src="<?php echo $macbook; ?>" alt="macbook-mockup">
                    <div class="imgBX position-absolute"
                         style="background: url('<?php echo esc_url($mockups['desktop']['url']); ?>')"></div>
                    <div class="d-inline-flex justify-content-center align-items-center mt-5 text-center text-white position-absolute top-100 start-0 end-0 gap-3">
                        <span class="small">بر روی صفحه کلیک کنید</span><i class="bi bi-mouse fs-1"></i>
                    </div>
                </div>

            </div>
            <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
                <div>
                    <div class="ipad position-absolute">
                        <img src="<?php echo $ipad; ?>" alt="ipad-mockup">
                        <div class="imgBX position-absolute"
                             style="background: url('<?php echo esc_url($mockups['tablet']['url']); ?>')"></div>
                        <div class="d-inline-flex justify-content-center align-items-center mt-5 text-center text-white position-absolute top-100 start-0 end-0 gap-3">
                            <span class="small">بر روی صفحه کلیک کنید</span><i class="bi bi-mouse fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                <div>
                    <div class="iphone position-absolute">
                        <img src="<?php echo $iphone; ?>" alt="iphone-mockup">
                        <div class="imgBX position-absolute"
                             style="background: url('<?php echo esc_url($mockups['phone']['url']); ?>')"></div>
                        <div class="d-inline-flex justify-content-center align-items-center mt-5 text-center text-white position-absolute top-100 start-0 end-0 gap-3">
                            <span class="small">بر روی صفحه کلیک کنید</span><i class="bi bi-mouse fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <div class="text-center d-flex justify-content-center">
        <a class="MoreLink position-relative d-inline-flex justify-content-center align-items-center lazy fs-6 gap-2 "
           href="<?php echo esc_url($website_url['url']) ?>">
            <?= $website_url['title']; ?>
            <h1 class="fs-6 text-white mb-0">
                <?php the_title(); ?>
            </h1>
        </a>
    </div>
</section>