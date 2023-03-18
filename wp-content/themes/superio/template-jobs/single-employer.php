<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$employer_layout = superio_get_employer_layout_type();
$employer_layout = !empty($employer_layout) ? $employer_layout : 'v1';

?>

<section id="primary" class="content-area inner">
	<div id="main" class="site-main content" role="main">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post();
				global $post;
				if ( !WP_Job_Board_Pro_Employer::check_view_employer_detail() ) {
					?>
					<div class="restrict-wrapper container">
						<?php
							$restrict_detail = wp_job_board_pro_get_option('employer_restrict_detail', 'all');
							switch ($restrict_detail) {
								case 'register_user':
									?>
									<h2 class="restrict-title"><?php esc_html_e( 'This page is restricted for registered users only.', 'superio' ); ?></h2>
									<div class="restrict-content"><?php esc_html_e( 'Please login to view this page', 'superio' ); ?></div>
									<?php
									break;
								case 'only_applicants':
									?>
									<h2 class="restrict-title"><?php esc_html_e( 'The page is restricted only for candidates view his applicants.', 'superio' ); ?></h2>
									<?php
									break;
								case 'register_candidate':
									?>
									<h2 class="restrict-title"><?php esc_html_e( 'Please login as candidate to view employer.', 'superio' ); ?></h2>
									<?php
									break;
								default:
									$content = apply_filters('wp-job-board-pro-restrict-employer-detail-information', '', $post);
									echo trim($content);
									break;
							}
						?>
					</div><!-- /.alert -->

					<?php
				} else {
				?>
					<div class="single-listing-wrapper employer" <?php superio_employer_item_map_meta($post); ?>>
						<?php
							if ( $employer_layout !== 'v1' ) {
								echo WP_Job_Board_Pro_Template_Loader::get_template_part( 'content-single-employer-'.$employer_layout );
							} else {
								echo WP_Job_Board_Pro_Template_Loader::get_template_part( 'content-single-employer' );
							}
						?>
					</div>
				<?php } ?>
			<?php endwhile; ?>

			<?php the_posts_pagination( array(
				'prev_text'          => esc_html__( 'Previous page', 'superio' ),
				'next_text'          => esc_html__( 'Next page', 'superio' ),
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'superio' ) . ' </span>',
			) ); ?>
		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>
	</div><!-- .site-main -->
</section><!-- .content-area -->

<?php get_footer();
