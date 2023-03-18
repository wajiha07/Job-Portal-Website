<?php

class Superio_Widget_Job_Buttons extends Apus_Widget {
    public function __construct() {
        parent::__construct(
            'apus_job_buttons',
            esc_html__('Job Detail:: Apply/Shortlist Buttons', 'superio'),
            array( 'description' => esc_html__( 'Show job buttons', 'superio' ), )
        );
        $this->widgetName = 'job_buttons';
    }

    public function getTemplate() {
        $this->template = 'job-buttons.php';
    }

    public function widget( $args, $instance ) {
        $this->display($args, $instance);
    }
    
    public function form( $instance ) {
        $defaults = array(
            'title' => '',
            'show_apply_button' => 1,
            'show_apply_social' => 1,
            'show_shortlist_button' => 1,
        );
        $instance = wp_parse_args((array) $instance, $defaults);
        // Widget admin form
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'superio' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
        </p>

        <p>
            <input class="checkbox" type="checkbox" <?php checked( $instance['show_apply_button'], 1 ); ?> id="<?php echo esc_attr( 'show_apply_button' ); ?>" name="<?php echo esc_attr($this->get_field_name('show_apply_button')); ?>" value="1"/>
            <label for="<?php echo esc_attr($this->get_field_name('show_apply_button') ); ?>">
                <?php esc_html_e('Show Apply Button', 'superio'); ?>
            </label>
        </p>

        <p>
            <input class="checkbox" type="checkbox" <?php checked( $instance['show_apply_social'], 1 ); ?> id="<?php echo esc_attr( 'show_apply_social' ); ?>" name="<?php echo esc_attr($this->get_field_name('show_apply_social')); ?>" value="1"/>
            <label for="<?php echo esc_attr($this->get_field_name('show_apply_social') ); ?>">
                <?php esc_html_e('Show Social Apply', 'superio'); ?>
            </label>
        </p>

        <p>
            <input class="checkbox" type="checkbox" <?php checked( $instance['show_shortlist_button'], 1 ); ?> id="<?php echo esc_attr( 'show_shortlist_button' ); ?>" name="<?php echo esc_attr($this->get_field_name('show_shortlist_button')); ?>" value="1"/>
            <label for="<?php echo esc_attr($this->get_field_name('show_shortlist_button') ); ?>">
                <?php esc_html_e('Show Shortlist Button', 'superio'); ?>
            </label>
        </p>
<?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['show_apply_button'] = (isset( $new_instance['show_apply_button'] ) ) ? strip_tags( $new_instance['show_apply_button'] ) : '';
        $instance['show_apply_social'] = (isset( $new_instance['show_apply_social'] ) ) ? strip_tags( $new_instance['show_apply_social'] ) : '';
        $instance['show_shortlist_button'] = (isset( $new_instance['show_shortlist_button'] ) ) ? strip_tags( $new_instance['show_shortlist_button'] ) : '';
        return $instance;

    }
}
register_widget('Superio_Widget_Job_Buttons');
