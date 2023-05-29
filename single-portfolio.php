<?php

get_header(); ?>
    <article class="py-5 container min-vh-100 d-flex justify-content-center align-items-center">
        <div class="row justify-content-center align-items-center w-100 g-lg-5 g-2 py-5 py-lg-0">
            <?php
            $terms = get_the_terms( get_the_ID(), 'portfolio_categories' );
            foreach ( $terms as $term ) {
                if ($term->slug == 'campaign'){
                    get_template_part('template-parts/portfolio/campaign');
                }
                elseif ($term->slug == 'social'){
                    get_template_part('template-parts/portfolio/social');
                }
                elseif ($term->slug == 'website'){
                    get_template_part('template-parts/portfolio/website');
                }
            }

            get_template_part('template-parts/navigation-post');
            ?>
        </div>
    </article>

<?php
?>
<?php get_footer(); ?>