<?php get_header();

$column_style = get_field_object('column_style');
$column_value = $column_style['value'];
?>

    <article class="h-100 w-100 position-relative">
        <div class="container-fluid py-5 py-lg-0">
            <div class="row px-0 min-vh-100 justify-content-center">
                <?php if ($column_value['value'] == 'right') {
                    get_template_part('template-parts/services/right');

                } elseif ($column_value['value'] == 'left') {
                    get_template_part('template-parts/services/left');
                } ?>

            </div>
        </div>
        <?php get_template_part('template-parts/navigation-post'); ?>
    </article>

<?php get_footer();