<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;
if ( empty($post->post_type) || $post->post_type != 'candidate' ) {
    return;
}

$tags = superio_candidate_display_tags($post, 'no-title', false);

if ( empty($tags) ) {
	return;
}

extract( $args );
extract( $instance );
$title = apply_filters('widget_title', $instance['title']);

if ( $title ) {
    echo trim($before_title)  . trim( $title ) . $after_title;
}

?>
<div class="candidate-detail-tags">
    <?php echo trim($tags); ?>
</div>
