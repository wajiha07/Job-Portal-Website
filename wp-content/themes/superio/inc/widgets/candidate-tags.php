<?php

class Superio_Widget_Candidate_Tags extends Apus_Widget {
    public function __construct() {
        parent::__construct(
            'apus_candidate_tags',
            esc_html__('Candidate Detail:: Candidate Tags', 'superio'),
            array( 'description' => esc_html__( 'Show candidate Tags', 'superio' ), )
        );
        $this->widgetName = 'candidate_tags';
    }

    public function getTemplate() {
        $this->template = 'candidate-tags.php';
    }

    public function widget( $args, $instance ) {
        $this->display($args, $instance);
    }
    
    public function form( $instance ) {
        $defaults = array(
            'title' => '',
        );
        $instance = wp_parse_args((array) $instance, $defaults);
        // Widget admin form
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'superio' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
        </p>
    <?php
    }

    public function update( $new_instance, $old_instance ) {
        return $new_instance;
    }
}
register_widget('Superio_Widget_Candidate_Tags');
