<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;
if ( empty($post->post_type) || $post->post_type != 'employer' ) {
    return;
}
extract( $args );
extract( $instance );
$title = apply_filters('widget_title', $instance['title']);

if ( $title ) {
    echo trim($before_title)  . trim( $title ) . $after_title;
}

global $post;

$meta_obj = WP_Job_Board_Pro_Employer_Meta::get_instance($post->ID);

$website = $meta_obj->get_post_meta('website');

$styles = (!empty($styles)) ? $styles : '';
?>
<div class="job-detail-employer-info">
    <?php if ( $styles == 'style1' ) { ?>
        <div class="job-employer-header">
            <?php if ( has_post_thumbnail($post->ID) ) { ?>
                <div class="employer-thumbnail">
                    <?php echo get_the_post_thumbnail( $post->ID, 'thumbnail' ); ?>
                </div>
            <?php } ?>

            <div class="employer-links">
                <?php the_title( '<h1 class="employer-title">', '</h1>' ); ?>

                <?php superio_employer_display_nb_jobs($post); ?>
            </div>
        </div>
    <?php } ?>

    <?php superio_employer_display_category($post->ID, 'title'); ?>
    <?php superio_employer_display_meta($post, 'founded_date', '', true, '', true); ?>
    <?php superio_employer_display_meta($post, 'company_size', '', true, '', true); ?>
    <?php superio_employer_display_short_location($post, 'title', true); ?>
    <?php superio_employer_display_phone($post, '', true); ?>
    <?php superio_employer_display_email($post, 'title'); ?>

    <?php
    $socials = $meta_obj->get_post_meta('socials');
    if ( $socials ) {
        $all_socials = WP_Job_Board_Pro_Mixes::get_socials_network();
    ?>
        <div class="social-employer">
            <h3 class="title"><?php echo trim($meta_obj->get_post_meta_title('socials')); ?>:</h3>
            <div class="value">
                <div class="apus-social-share">
                    <?php foreach ($socials as $social) { ?>
                        <?php if ( !empty($social['url']) && !empty($social['network']) ) {
                            $icon_class = !empty( $all_socials[$social['network']]['icon'] ) ? $all_socials[$social['network']]['icon'] : '';
                        ?>
                            <a href="<?php echo esc_html($social['url']); ?>">
                                <i class="<?php echo esc_attr($icon_class); ?>"></i>
                            </a>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php } ?>

    <?php do_action('wp-job-board-pro-single-employer-details', $post); ?>

    <?php if ( $website ) { ?>
        <div class="employer-website">
            <a href="<?php echo esc_url($website); ?>" class="btn btn-theme-light btn-block"><?php echo trim($website); ?></a>
        </div>
    <?php } ?>
</div>