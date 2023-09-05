<?php /* Template Name: landing */

get_header();
?>
    <section class="h-100 w-100 position-relative overflow-x-hidden overflow-y-hidden landing" style="background-image: url('https://summer.xvision.ir/wp-content/uploads/2023/07/1111.jpg'); background-size: cover; background-position: center center">
        <div class="container">
            <div class="row px-0 min-vh-100 justify-content-start align-items-center">
                <div class="col-lg-6 d-flex flex-column align-items-center justify-content-center gap-5 py-3 px-3 z-top" style="background-image: url('https://summer.xvision.ir/wp-content/uploads/2023/07/stars.png'); background-size: cover;background-position: center center; background-repeat: no-repeat">
                    <h1 class="text-white mb-4">
                        قرعه‌کشی ایکس.ویژن
                    </h1>
<!--                    <div id="notice-contest"-->
<!--                         class="btn btn-warning fs-5 lh-base border-warning border pt-2 pb-1 rounded-0"></div>-->

                    <form class="text-center">
                        <fieldset name='number-code' data-number-code-form>
                            <legend>Number Code</legend>
                            <input type="number" min='0' max='9' name='number-code-0' class="pt-3"
                                   data-number-code-input='0'
                                   required/>
                            <input type="number" min='0' max='9' name='number-code-1' class="pt-3"
                                   data-number-code-input='1'
                                   required/>
                            <input type="number" min='0' max='9' name='number-code-2' class="pt-3"
                                   data-number-code-input='2'
                                   required/>
                            <input type="number" min='0' max='9' name='number-code-3' class="pt-3"
                                   data-number-code-input='3'
                                   required/>
                        </fieldset>
                    </form>

                    <button type="button" class="swipe-overlay-out border-0 fs-4 px-4 py-2 mt-2 fw-bold "
                            data-fetch-button>
                        انتخاب برنده
                    </button>

                    <div class="d-flex justify-content-center align-items-center counterUp element">
                        <div class="jumbo d-flex justify-content-end display-4 mb-0" id="myTargetElement"></div>
<!--                        <span>*</span>-->
<!--                        <span>*</span>-->
<!--                        <span>*</span>-->
<!--                        <div class="odometer last-four-digits"></div>-->

                    </div>

                </div>
            </div>
        </div>
    </section>


<?php get_footer();

