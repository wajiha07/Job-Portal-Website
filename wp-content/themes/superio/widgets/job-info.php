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


$meta_obj = WP_Job_Board_Pro_Job_Listing_Meta::get_instance($post->ID);

$salary = WP_Job_Board_Pro_Job_Listing::get_salary_html($post->ID);
$location = superio_job_display_short_location($post, 'no-icon', false);

$expires = $meta_obj->get_post_meta( 'expiry_date' );

?>
<div class="job-detail-detail">
    <ul class="list">
        <li>
            <div class="icon">
                <i class="flaticon-calendar"></i>
            </div>
            <div class="details">
                <div class="text"><?php esc_html_e('Date Posted', 'superio'); ?></div>
                <div class="value"><?php the_time(get_option('date_format')); ?></div>
            </div>
        </li>

        <?php if ( $location ) { ?>
            <li>
                <div class="icon">
                    <i class="flaticon-location"></i>
                </div>
                <div class="details">
                    <div class="text"><?php echo trim($meta_obj->get_post_meta_title('location')); ?></div>
                    <div class="value"><?php echo trim($location); ?></div>
                </div>
            </li>
        <?php } ?>

        <?php if ( $salary ) { ?>
            <li>
                <div class="icon">
                    <i class="flaticon-money-1"></i>
                </div>
                <div class="details">
                    <div class="text"><?php esc_html_e('Offered Salary:', 'superio'); ?></div>
                    <div class="value"><?php echo trim($salary); ?></div>
                </div>
            </li>
        <?php } ?>

        <li>
            <div class="icon">
                <i class="flaticon-waiting"></i>
            </div>
            <div class="details">
                <div class="text"><?php esc_html_e('Expiration date', 'superio'); ?></div>
                <div class="value">
                    <?php
                    if ( $expires ) {
                        echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $expires ) ) );
                    } else {
                        echo '--';
                    }
                    ?>
                </div>
            </div>
        </li>

        <?php if ( $meta_obj->check_post_meta_exist('experience') && ($experience = $meta_obj->get_post_meta('experience')) ) { ?>
            <li>
                <div class="icon">
                    <i class="flaticon-businessman"></i>
                </div>
                <div class="details">
                    <div class="text"><?php echo trim($meta_obj->get_post_meta_title('experience')); ?></div>
                    <div class="value">
                        <?php
                            if ( is_array($experience) ) {
                                echo implode(', ', $experience);
                            } else {
                                echo esc_html($experience);
                            }
                        ?>
                    </div>
                </div>
            </li>
        <?php } ?>

        <?php if ( $meta_obj->check_post_meta_exist('gender') && ($gender = $meta_obj->get_post_meta('gender')) ) { ?>
            <li>
                <div class="icon">
                    <i class="flaticon-user"></i>
                </div>
                <div class="details">
                    <div class="text"><?php echo trim($meta_obj->get_post_meta_title('gender')); ?></div>
                    <div class="value">
                        <?php
                            if ( is_array($gender) ) {
                                echo implode(', ', $gender);
                            } else {
                                echo esc_html($gender);
                            }
                        ?>        
                    </div>
                </div>
            </li>
        <?php } ?>

        <?php if ( $meta_obj->check_post_meta_exist('industry') && ($industry = $meta_obj->get_post_meta('industry')) ) { ?>
            <li>
                <div class="icon">
                    <i class="flaticon-briefcase"></i>
                </div>
                <div class="details">
                    <div class="text"><?php echo trim($meta_obj->get_post_meta_title('industry')); ?></div>
                    <div class="value">
                        <?php
                            if ( is_array($industry) ) {
                                echo implode(', ', $industry);
                            } else {
                                echo esc_html($industry);
                            }
                        ?> 
                    </div>
                </div>
            </li>
        <?php } ?>

        <?php if ( $meta_obj->check_post_meta_exist('qualification') && ($qualification = $meta_obj->get_post_meta('qualification')) ) { ?>
            <li>
                <div class="icon">
                    <i class="flaticon-vector"></i>
                </div>
                <div class="details">
                    <div class="text"><?php echo trim($meta_obj->get_post_meta_title('qualification')); ?></div>
                    <div class="value">
                        <?php
                            if ( is_array($qualification) ) {
                                echo implode(', ', $qualification);
                            } else {
                                echo esc_html($qualification);
                            }
                        ?> 
                    </div>
                </div>
            </li>
        <?php } ?>

        <?php if ( $meta_obj->check_post_meta_exist('career_level') && ($career_level = $meta_obj->get_post_meta('career_level')) ) { ?>
            <li>
                <div class="icon">
                    <i class="flaticon-money"></i>
                </div>
                <div class="details">
                    <div class="text"><?php echo trim($meta_obj->get_post_meta_title('career_level')); ?></div>
                    <div class="value">
                        <?php
                            if ( is_array($career_level) ) {
                                echo implode(', ', $career_level);
                            } else {
                                echo esc_html($career_level);
                            }
                        ?> 
                    </div>
                </div>
            </li>
        <?php } ?>
        
        <?php do_action('wp-job-board-pro-single-job-details', $post); ?>
    </ul>
</div>