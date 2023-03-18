<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Superio
 * @since Superio 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="//gmpg.org/xfn/11">
	
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php if ( superio_get_config('preload', true) ) {
	$preload_icon = superio_get_config('media-preload-icon');
	$styles = array();
	if ( !empty($preload_icon['id']) ) {
		$img = wp_get_attachment_image_src($preload_icon['id'], 'full');
		if ( !empty($img[0]) ) {
			$styles[] = 'background-image: url(\''.$img[0].'\');';
		}
		if ( !empty($img[1]) ) {
			$styles[] = 'width: '.$img[1].'px;';
		}
		if ( !empty($img[1]) ) {
			$styles[] = 'height: '.$img[2].'px;';
		}
    }
    $style_attr = '';
    if ( !empty($styles) ) {
    	$style_attr = 'style="'.implode(' ', $styles).'"';
    }
?>
	<div class="apus-page-loading">
        <div class="apus-loader-inner" <?php echo trim($style_attr); ?>></div>
    </div>
<?php } ?>
<div id="wrapper-container" class="wrapper-container">
	<?php
    if ( function_exists( 'wp_body_open' ) ) {
        wp_body_open();
    }
    if ( superio_get_config('separate_header_mobile', true) ) {
	    get_template_part( 'headers/mobile/offcanvas-menu' );
		get_template_part( 'headers/mobile/header-mobile' );
	}
	?>

	<?php
		$header = apply_filters( 'superio_get_header_layout', superio_get_config('header_type') );
		if ( !empty($header) ) {
			superio_display_header_builder($header);
		} else {
			get_template_part( 'headers/default' );
		}
	?>
	<div id="apus-main-content">