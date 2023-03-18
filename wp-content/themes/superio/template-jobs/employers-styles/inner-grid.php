<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post;

?>

<?php do_action( 'wp_job_board_pro_before_employer_content', $post->ID ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class('map-item employer-card'); ?> <?php superio_employer_item_map_meta($post); ?>>
    <div class="employer-grid layout-employer">
        <?php superio_employer_display_follow_btn($post->ID); ?>
        <?php superio_employer_display_featured_icon($post, 'text'); ?>
        <?php superio_employer_display_logo($post); ?>
        <?php the_title( sprintf( '<h2 class="employer-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
        <div class="employer-information">
            <?php superio_employer_display_short_location($post, 'icon'); ?>

            <?php superio_employer_display_category($post, 'icon'); ?>

            <?php superio_employer_display_open_position($post); ?>
        </div>
    </div>
</article><!-- #post-## -->

<?php do_action( 'wp_job_board_pro_after_employer_content', $post->ID ); ?>