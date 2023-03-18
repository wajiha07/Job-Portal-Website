<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
wp_enqueue_script('wpjbp-select2');
wp_enqueue_style('wpjbp-select2');
?>
<div class="box-employer widget">
	<h3 class="widget-title"><?php echo esc_html__('Job Alerts','wp-job-board-pro') ?></h3>
	
	<div class="search-orderby-wrapper flex-middle-sm">
		<div class="search-jobs-alert-form widget-search">
			<form action="" method="get">
				<div class="input-group">
					<input type="text" placeholder="<?php echo esc_html__( 'Search ...', 'wp-job-board-pro' ); ?>" class="form-control" name="search" value="<?php echo esc_attr(isset($_GET['search']) ? $_GET['search'] : ''); ?>">
					<span class="input-group-btn">
						<button class="search-submit btn btn-sm btn-search" name="submit">
							<i class="flaticon-magnifying-glass"></i>
						</button>
					</span>
				</div>
				<input type="hidden" name="paged" value="1" />
			</form>
		</div>
		<div class="sort-jobs-alert-form sortby-form">
			<?php
				$orderby_options = apply_filters( 'wp_job_board_pro_my_jobs_orderby', array(
					'menu_order'	=> esc_html__( 'Default', 'wp-job-board-pro' ),
					'newest' 		=> esc_html__( 'Newest', 'wp-job-board-pro' ),
					'oldest'     	=> esc_html__( 'Oldest', 'wp-job-board-pro' ),
				) );

				$orderby = isset( $_GET['orderby'] ) ? wp_unslash( $_GET['orderby'] ) : 'newest'; 
			?>

			<div class="orderby-wrapper flex-middle">
				<span class="text-sort">
					<?php echo esc_html__('Sort by: ','wp-job-board-pro'); ?>
				</span>
				<form class="my-jobs-ordering" method="get">
					<select name="orderby" class="orderby">
						<?php foreach ( $orderby_options as $id => $name ) : ?>
							<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $name ); ?></option>
						<?php endforeach; ?>
					</select>
					<input type="hidden" name="paged" value="1" />
					<?php WP_Job_Board_Pro_Mixes::query_string_form_fields( null, array( 'orderby', 'submit', 'paged' ) ); ?>
				</form>
			</div>
		</div>
	</div>
	<?php if ( !empty($alerts) && !empty($alerts->posts) ) {
		$email_frequency_default = WP_Job_Board_Pro_Job_Alert::get_email_frequency(); ?>
		<div class="table-responsive">
			<table class="job-table">
				<thead>
					<tr>
						<th class="job-title"><?php esc_html_e('Title', 'wp-job-board-pro'); ?></th>
						<th class="alert-query"><?php esc_html_e('Alert Query', 'wp-job-board-pro'); ?></th>
						<th class="job-number"><?php esc_html_e('Number Jobs', 'wp-job-board-pro'); ?></th>
						<th class="job-times"><?php esc_html_e('Times', 'wp-job-board-pro'); ?></th>
						<th class="job-actions"><?php esc_html_e('Actions', 'wp-job-board-pro'); ?></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($alerts->posts as $alert_id) {
					
					$email_frequency = get_post_meta($alert_id, WP_JOB_BOARD_PRO_JOB_ALERT_PREFIX . 'email_frequency', true);
					if ( !empty($email_frequency_default[$email_frequency]['label']) ) {
						$email_frequency = $email_frequency_default[$email_frequency]['label'];
					}

					$alert_query = get_post_meta($alert_id, WP_JOB_BOARD_PRO_JOB_ALERT_PREFIX . 'alert_query', true);
					$params = null;
					if ( !empty($alert_query) ) {
						$params = json_decode($alert_query, true);
					}

					$query_args = array(
						'post_type' => 'job_listing',
					    'post_status' => 'publish',
					    'post_per_page' => 1,
					    'fields' => 'ids'
					);
					$jobs = WP_Job_Board_Pro_Query::get_posts($query_args, $params);
					$count_jobs = $jobs->found_posts;

					$jobs_alert_url = WP_Job_Board_Pro_Mixes::get_jobs_page_url();
					if ( !empty($params) ) {
						foreach ($params as $key => $value) {
							if ( is_array($value) ) {
								$jobs_alert_url = remove_query_arg( $key.'[]', $jobs_alert_url );
								foreach ($value as $val) {
									$jobs_alert_url = add_query_arg( $key.'[]', $val, $jobs_alert_url );
								}
							} else {
								$jobs_alert_url = add_query_arg( $key, $value, remove_query_arg( $key, $jobs_alert_url ) );
							}
						}
					}
					?>

					<?php do_action( 'wp_job_board_pro_before_job_alert_content', $alert_id ); ?>
					<tr <?php post_class('job-alert-wrapper'); ?>>
						<td>
							<div class="job-table-info-content-title">
					        	<a href="<?php echo esc_url($jobs_alert_url); ?>" rel="bookmark"><?php echo get_the_title($alert_id); ?></a>
					        </div>
						</td>
						<td>
							<div class="alert-query">
					        	<?php
					        	$params = WP_Job_Board_Pro_Abstract_Filter::get_filters($params);
					        	if ( $params ) {
					        		?>
					        		<ul class="list">
					        			<?php
						        			foreach ($params as $key => $value) {
						        				WP_Job_Board_Pro_Job_Filter::display_filter_value_simple($key, $value, $params);
						        			}
					        			?>
					        		</ul>
					        	<?php } ?>
					        </div>
						</td>
						<td>
							<div class="job-found">
					            <?php echo sprintf(esc_html__('Jobs found %d', 'wp-job-board-pro'), intval($count_jobs) ); ?>
					        </div>
						</td>
						<td>
							<div class="job-metas">
					            <?php echo wp_kses_post($email_frequency); ?>
					        </div>
						</td>
						<td>
							<a href="javascript:void(0)" class="btn-remove-job-alert btn-action-icon deleted btn-action-sm" data-alert_id="<?php echo esc_attr($alert_id); ?>" data-nonce="<?php echo esc_attr(wp_create_nonce( 'wp-job-board-pro-remove-job-alert-nonce' )); ?>"><i class="flaticon-rubbish-bin"></i></a>
						</td>
					</tr>
					
					<?php do_action( 'wp_job_board_pro_after_job_alert_content', $alert_id );
				}

				?>
				</tbody>
			</table>
		</div>
		<?php WP_Job_Board_Pro_Mixes::custom_pagination( array(
			'wp_query' => $alerts,
			'max_num_pages' => $alerts->max_num_pages,
			'prev_text'     => esc_html__( 'Previous page', 'wp-job-board-pro' ),
			'next_text'     => esc_html__( 'Next page', 'wp-job-board-pro' ),
		));
	?>

	<?php } else { ?>
		<div class="not-found"><?php esc_html_e('No job alert found.', 'wp-job-board-pro'); ?></div>
	<?php } ?>
</div>