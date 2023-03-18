<?php

class Superio_Widget_Job_Employer_Info extends Apus_Widget {
    public function __construct() {
        parent::__construct(
            'apus_job_employer_info',
            esc_html__('Job Detail:: Employer Information', 'superio'),
            array( 'description' => esc_html__( 'Show job employer information', 'superio' ), )
        );
        $this->widgetName = 'job_employer_info';
    }

    public function getTemplate() {
        $this->template = 'job-employer-info.php';
    }

    public function widget( $args, $instance ) {
        $this->display($args, $instance);
    }
    
    public function form( $instance ) {
        $defaults = array(
            'title' => '',
            'style' => 'style1',
        );
        $instance = wp_parse_args((array) $instance, $defaults);
        // Widget admin form
        $options = array(
            'style1' => esc_html__('Style 1', 'superio'),
            'style2' => esc_html__('Style 2', 'superio'),
        );
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'superio' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('style')); ?>">
                <?php echo esc_html__('Style:', 'superio' ); ?>
            </label>
            <br>
            <select id="<?php echo esc_attr($this->get_field_id('style')); ?>" name="<?php echo esc_attr($this->get_field_name('style')); ?>">
                <?php foreach ($options as $key => $value) { ?>
                    <option value="<?php echo esc_attr( $key ); ?>" <?php selected($instance['style'],$key); ?> ><?php echo esc_html( $value ); ?></option>
                <?php } ?>
            </select>
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['style'] = ( ! empty( $new_instance['style'] ) ) ? strip_tags( $new_instance['style'] ) : '';

        return $instance;
    }
}
register_widget('Superio_Widget_Job_Employer_Info');
