<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $post;

?>
<?php do_action( 'wp_job_board_pro_before_candidate_content', $post->ID ); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class('map-item candidate-card'); ?> <?php superio_candidate_item_map_meta($post); ?>>
    <div class="candidate-grid v1 candidate-archive-layout">
        <?php WP_Job_Board_Pro_Candidate::display_shortlist_btn($post->ID); ?>
        <?php superio_candidate_display_logo($post); ?>
        <?php the_title( sprintf( '<h2 class="candidate-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
        <?php superio_candidate_display_job_title($post); ?>
        <div class="candidate-info">
            <div class="job-metas">
                <?php superio_candidate_display_short_location($post, 'icon'); ?>
            </div>
        </div>
        <div class="candidate-link">
	        <a href="<?php the_permalink(); ?>" class="btn btn-block btn-theme-lighten"><?php esc_html_e('View Profile', 'superio'); ?></a>
    	</div>
    </div>
</article><!-- #post-## -->
<?php do_action( 'wp_job_board_pro_after_candidate_content', $post->ID ); ?>