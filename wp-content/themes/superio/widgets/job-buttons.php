<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;
if ( empty($post->post_type) || $post->post_type != 'job_listing' ) {
    return;
}
extract( $args );
extract( $instance );
$title = apply_filters('widget_title', $instance['title']);

if ( $title ) {
    echo trim($before_title)  . trim( $title ) . $after_title;
}

?>
<div class="job-detail-buttons">
	<?php
        if ( $show_apply_button ) {
            WP_Job_Board_Pro_Job_Listing::display_apply_job_btn($post->ID);
        }
    ?>
    <?php if ( $show_shortlist_button ) { ?>
        <?php WP_Job_Board_Pro_Job_Listing::display_shortlist_btn($post->ID); ?>
    <?php } ?>
    <?php if ( WP_Job_Board_Pro_Job_Listing::check_can_apply_social($post->ID) && $show_apply_social ) { ?>
        <div class="socials-apply">
            <div class="title"><?php esc_html_e('OR apply with', 'superio'); ?></div>
            <div class="inner">
                <?php do_action('wp_job_board_pro_social_apply_btn', $post); ?>
            </div>
        </div>
    <?php } ?>
</div>