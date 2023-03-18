<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$user_id = WP_Job_Board_Pro_User::get_user_id();
$employer_id = WP_Job_Board_Pro_User::get_employer_by_user_id($user_id);

if ( get_query_var( 'paged' ) ) {
    $paged = get_query_var( 'paged' );
} elseif ( get_query_var( 'page' ) ) {
    $paged = get_query_var( 'page' );
} else {
    $paged = 1;
}

$query_vars = array(
	'post_type'         => 'job_meeting',
	'posts_per_page'    => get_option('posts_per_page'),
	'paged'    			=> $paged,
	'post_status'       => 'publish',
	'author' 			=> $user_id
);

$loop = WP_Job_Board_Pro_Query::get_posts($query_vars);

$zoom_email = WP_Job_Board_Pro_Employer::get_post_meta($employer_id, 'zoom_email');
$zoom_client_id = WP_Job_Board_Pro_Employer::get_post_meta($employer_id, 'zoom_client_id');
$zoom_client_secret = WP_Job_Board_Pro_Employer::get_post_meta($employer_id, 'zoom_client_secret');
?>

<div class="box-dashboard-wrapper">

		<h3 class="widget-title flex-middle">
            <span class="left-inner">
                <?php esc_html_e('Meetings', 'superio'); ?>
            </span>
            <span class="ali-right">
                <a href="#employer-meeting-zoom-settings" class="employer-meeting-zoom-settings btn btn-theme"><?php esc_html_e('Zoom Settings', 'superio'); ?></a>
            </span>
        </h3>

		<div id="employer-meeting-zoom-settings" class="job-apply-email-form-wrapper mfp-hide">
			<div class="inner">
				<h2 class="widget-title"><span><?php esc_html_e('Zoom API Setting', 'superio'); ?></span></h2>

				<form id="employer-zoom-meeting-settings-form" class="zoom-meeting-settings-form" method="post">
					<div class="form-group">
						<label><?php esc_html_e('Zoom Email', 'superio'); ?></label>
						<input type="text" class="form-control style2" name="email" value="<?php echo esc_attr($zoom_email); ?>">
					</div>
					<div class="form-group">
						<label><?php esc_html_e('Zoom Client ID', 'superio'); ?></label>
						<input type="text" class="form-control style2" name="client_id" value="<?php echo esc_attr($zoom_client_id); ?>">
					</div>
					<div class="form-group">
						<label><?php esc_html_e('Client Secret', 'superio'); ?></label>
						<input type="text" class="form-control style2" name="client_secret" value="<?php echo esc_attr($zoom_client_secret); ?>">
					</div>

			        <!-- /.form-group -->

					<?php wp_nonce_field( 'wp-job-board-pro-zoom-meeting-nonce', 'nonce' ); ?>
			      	<input type="hidden" name="action" value="wp_job_board_pro_ajax_zoom_settings">
			        <button class="button btn btn-theme btn-block" name="zoom-settings"><?php esc_html_e( 'Get Authorize with zoom', 'superio' ); ?></button>
				</form>
			</div>
		</div>

	<div class="inner-list meetings-list-inner">
        <?php
    	if ( $loop->have_posts() ) {
    		$current_day = strtotime('now');
			while ( $loop->have_posts() ) : $loop->the_post();
				global $post;
				$date = WP_Job_Board_Pro_Meeting::get_post_meta($post->ID, 'date', true);
				$time = WP_Job_Board_Pro_Meeting::get_post_meta($post->ID, 'time', true);
				$time_duration = WP_Job_Board_Pro_Meeting::get_post_meta($post->ID, 'time_duration', true);
				$candidate_id = WP_Job_Board_Pro_Meeting::get_post_meta($post->ID, 'candidate_id', true);
				$application_id = WP_Job_Board_Pro_Meeting::get_post_meta($post->ID, 'application_id', true);
				$messages = WP_Job_Board_Pro_Meeting::get_post_meta($post->ID, 'messages', true);

				$job_id = WP_Job_Board_Pro_Applicant::get_post_meta($application_id, 'job_id', true);

				$datetotime = strtotime($date);
				$week_day = $datetotime > $current_day ? date_i18n('l', $datetotime) : esc_html__('Today', 'superio');
            	?>
            	<div class="meeting-wrapper flex-middle-sm">
            		<div class="date text-center">
            			<div class="day"><?php echo date_i18n('d', $datetotime); ?></div>
                        <div class="bottom-date">
                			<span class="week"><?php echo trim($week_day); ?></span> - 
                            <span class="month"><?php echo date_i18n('M', $datetotime); ?></span>
                        </div>
            		</div>
                    <div class="righ-inner flex-middle-sm">
                		<div class="information">
                			<div class="title-wrapper flex-middle">
	                			<h3 class="title">
	                				<a href="<?php echo esc_url(get_permalink($job_id)); ?>">
	                					<?php echo get_the_title($job_id); ?>
	                				</a>
	            				</h3>
            					<?php
	            					$status = WP_Job_Board_Pro_Meeting::get_post_meta($post->ID, 'status');
	            					if ( $status == 'cancel') {
	            						echo '<span class="label label-danger cancel">'.esc_html__('Canceled', 'superio').'</span>';
	            					}
	            				?>
	            			</div>
                            <div class="meta-bottom">
                                <?php esc_html_e('Meeting with: ', 'superio'); ?> 
                                <a href="<?php echo esc_url(get_permalink($candidate_id)); ?>"><strong><?php echo get_the_title($candidate_id); ?></strong></a>
                            </div>
                			<div class="job-metas">
                				<div class="time"><i class="flaticon-wall-clock"></i> <?php echo trim($time); ?></div>
                				<div class="time_duration"><i class="flaticon-waiting"></i> <?php echo trim($time_duration); ?> <?php esc_html_e('Minutes', 'superio'); ?></div>
                			</div>
                		</div>
                		<div class="action-button">
                			
                			<?php
                				$meeting_platform = WP_Job_Board_Pro_Meeting::get_post_meta($post->ID, 'meeting_platform');
                				if ( $meeting_platform == 'zoom' ) {
                					$zoom_meeting_id = WP_Job_Board_Pro_Meeting::get_post_meta($post->ID, 'zoom_meeting_id');
    	            				$zoom_meeting_url = WP_Job_Board_Pro_Meeting::get_post_meta($post->ID, 'zoom_meeting_url');
    	            				?>
    	            				<a href="<?php echo esc_url($zoom_meeting_url); ?>" class="zoom-meeting-btn"><?php esc_html_e('Zoom Meeting', 'superio'); ?></a>
    	            				<?php
                				}
                			?>
                			
                			<?php if ( !empty($messages) ) { ?>
                				<div id="meeting-messages-wrapper-<?php echo esc_attr($post->ID); ?>" class="job-apply-email-form-wrapper mfp-hide">
                					<div class="popup-title-wrapper flex-middle">
                						<h3 class="popup-title"><?php esc_html_e('Meeting History', 'superio'); ?></h3>
                                        <div class="ali-right">
                						  <span class="close-popup"><i class="ti-close"></i></span>
                                        </div>
                					</div>
                					<div class="meesage-meeting-wrapper">
	                					<?php foreach ( $messages as $message ) {
	                						$type = !empty($message['type']) ? $message['type'] : '';
	            						?>
	                						<div class="meesage-meeting">
	                							<div class="heading flex-middle">
	                								<?php if ( $type == 'create' ) { ?>
	                									<h5><?php echo sprintf(esc_html__('Created by: %s', 'superio'), get_the_title($employer_id)); ?></h5>
	                								<?php } elseif ( $type == 'reschedule' ) {
	                									$user_post_id = !empty($message['user_post_id']) ? $message['user_post_id'] : 0;
	            									?>
	            										<h5><?php echo sprintf(esc_html__('Re-schedule by: %s', 'superio'), get_the_title($user_post_id)); ?></h5>
	                								<?php } ?>
	                								<div class="date ali-right">
	                									<?php echo date_i18n(get_option('date_format'), $message['date']); ?>
	                								</div>
	                							</div>
	                							<div class="content">
	                								<?php echo wpautop($message['message']); ?>
	                							</div>
	                						</div>
	                					<?php } ?>
	                				</div>
                				</div>

                				<a data-toggle="tooltip" href="#meeting-messages-wrapper-<?php echo esc_attr($post->ID); ?>" class="btn-messages-job-meeting btn-action-icon messages" data-meeting_id="<?php echo esc_attr($post->ID); ?>" data-nonce="<?php echo esc_attr(wp_create_nonce( 'wp-job-board-pro-messages-meeting-nonce' )); ?>" title="<?php echo esc_attr_e('Messages', 'superio'); ?>"><i class="flaticon-envelope"></i> <sup><?php echo count($messages); ?></sup></a>

                			<?php } ?>
                			
                			<a data-toggle="tooltip" href="#job-apply-reschedule-meeting-form-wrapper-<?php echo esc_attr($post->ID); ?>" class="btn-reschedule-job-meeting btn-action-icon reschedule" data-meeting_id="<?php echo esc_attr($post->ID); ?>" data-nonce="<?php echo esc_attr(wp_create_nonce( 'wp-job-board-pro-reschedule-meeting-nonce' )); ?>" title="<?php echo esc_attr_e('Re-schedule Meeting', 'superio'); ?>"><i class="flaticon-refresh"></i></a>

                			<?php echo WP_Job_Board_Pro_Template_Loader::get_template_part('misc/meeting-reschedule-form'); ?>

                			<a data-toggle="tooltip" title="<?php esc_attr_e('Remove', 'superio'); ?>" href="javascript:void(0);" class="btn-action-icon btn-remove-job-meeting remove" data-meeting_id="<?php echo esc_attr($post->ID); ?>" data-nonce="<?php echo esc_attr(wp_create_nonce( 'wp-job-board-pro-remove-meeting-nonce' )); ?>"><i class="flaticon-trash"></i></a>
                		</div>
                    </div>
            	</div>
                
            	<?php
            endwhile;

			WP_Job_Board_Pro_Mixes::custom_pagination( array(
				'max_num_pages' => $loop->max_num_pages,
				'prev_text'     => esc_html__( 'Previous page', 'superio' ),
				'next_text'     => esc_html__( 'Next page', 'superio' ),
				'wp_query' => $loop
			));

			wp_reset_postdata();
        }  else { ?>
			<div class="not-found"><?php esc_html_e('No meetings found.', 'superio'); ?></div>
		<?php } ?>
    </div>
	    
</div>