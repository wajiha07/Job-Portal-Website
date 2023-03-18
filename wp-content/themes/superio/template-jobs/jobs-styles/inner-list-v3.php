<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $post;

?>
<?php do_action( 'wp_job_board_pro_before_job_content', $post->ID ); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class('map-item layout-job job-list v3'); ?> <?php superio_job_item_map_meta($post); ?>>
    <div class="flex-middle-sm">
        <div class="inner-left">
            <?php superio_job_display_employer_logo($post); ?>
            <div class="job-list-content">
                <div class="title-wrapper flex-middle-sm">
                    <?php the_title( sprintf( '<h2 class="job-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
                    <?php superio_job_display_featured_icon($post,'text'); ?>
                </div>
                <div class="job-metas">
                    <?php superio_job_display_job_category($post, 'icon'); ?>
                    <?php superio_job_display_postdate($post, 'icon'); ?>
                    <?php superio_job_display_salary($post, 'icon'); ?>
                    <?php superio_job_display_job_type($post); ?>
                    <?php superio_job_display_urgent_icon($post); ?>
                </div>
            </div>
        </div>
        <div class="ali-right">
            <?php WP_Job_Board_Pro_Job_Listing::display_apply_job_btn($post->ID); ?>
        </div>
    </div>
</article><!-- #post-## -->
<?php do_action( 'wp_job_board_pro_after_job_content', $post->ID ); ?>