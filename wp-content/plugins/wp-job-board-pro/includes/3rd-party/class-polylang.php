<?php
/**
 * Polylang
 *
 * @package    wp-job-board
 * @author     Habq 
 * @license    GNU General Public License, version 3
 */

if ( ! defined( 'ABSPATH' ) ) {
  	exit;
}

class WP_Job_Board_Pro_Polylang {
	
	public static function init() {
		if ( did_action( 'pll_init' ) ) {

			add_filter( 'wp-job-board-pro-current-lang', array(__CLASS__, 'get_job_listings_lang') );
			
			add_filter( 'wp-job-board-pro-get-custom-fields-key', array(__CLASS__, 'custom_fields_key'), 100, 2 );
			add_filter( 'wp-job-board-pro-get-custom-fields-data', array(__CLASS__, 'get_custom_fields_data'), 100, 2 );

			add_filter( 'wp-job-board-pro-post-id', array(__CLASS__, 'get_post_id'), 10, 2 );
			add_filter( 'wp-job-board-translations-post-ids', array(__CLASS__, 'get_all_translations_object_id'), 10 );
			
			add_filter( 'wp_job_board_pro_settings_job_submission', array(__CLASS__, 'hide_page_selection'), 100 );
			add_filter( 'wp_job_board_pro_settings_pages', array(__CLASS__, 'hide_page_selection'), 100 );
			add_filter( 'wp_job_board_pro_settings_employer_settings', array(__CLASS__, 'hide_page_selection'), 100 );
			add_filter( 'wp_job_board_pro_settings_candidate_settings', array(__CLASS__, 'hide_page_selection'), 100 );
		}
	}

	public static function get_job_listings_lang( $lang ) {
		if (
			function_exists( 'pll_current_language' )
			&& function_exists( 'pll_is_translated_post_type' )
			&& pll_is_translated_post_type( 'job_listing' )
		) {
			return pll_current_language();
		}
		return $lang;
	}

	public static function get_icl_object_id($post_id, $post_type) {

        $current_lang = pll_current_language();
        $translations = pll_get_post_translations($post_id);
        $icl_post_id = !empty($translations[$current_lang]) ? $translations[$current_lang] : 0;
        if ($icl_post_id > 0) {
            $post_id = $icl_post_id;
        }

        return $post_id;
	}

	public static function get_all_translations_object_id($post_id) {
		if ( function_exists('pll_get_post_translations') ) {
			$post_ids = pll_get_post_translations($post_id);
			if ( empty($post_ids) ) {
				$post_ids = array($post_id);
			}
		} else {
			$post_ids = array($post_id);
		}
		
        return $post_ids;
	}
	
	public static function custom_fields_key($key, $prefix) {
		if ( function_exists( 'pll_current_language' ) && function_exists( 'pll_default_language' ) ) {
			$default_lang = pll_default_language();
			$current_lang = pll_current_language();
			if ( $default_lang != $current_lang ) {
				$key = $key.'_'.$current_lang;
			}
		}
		return $key;
	}

	public static function get_custom_fields_data($value, $prefix) {
		if ( empty($value) ) {
			$value = get_option('wp_job_board_pro_'.$prefix.'_fields_data', array());
		}
		return $value;
	}

	public static function get_post_id($post_id, $post_type = 'page') {
		if ( function_exists( 'pll_get_post' ) ) {
			$post_id = pll_get_post( $post_id );
		}
		return absint( $post_id );
	}

	public static function hide_page_selection($fields) {
		$current_lang = pll_current_language();
		$default_lang = pll_default_language();
		if ( $current_lang == $default_lang ) {
			return $fields;
		}
		$tab = '';
		if ( !empty($_GET['tab']) ) {
			$tab = '&tab='.$_GET['tab'];
		}
		
		$url_to_edit_page = admin_url( 'edit.php?post_type=job_listing&page=job_listing-settings'.$tab.'&lang=' . $default_lang );

		foreach ($fields as $key => $field) {
			if ( !empty($field['page-type']) && $field['page-type'] == 'page' ) {
				$fields[$key]['type'] = 'wp_job_board_pro_hidden';
				$fields[$key]['human_value'] = __( 'Page Not Set', 'wp-job-board-pro' );

				$current_value = get_option( $field['id'] );
				if ( $current_value ) {
					$page = pll_get_post( $current_value, $current_lang );

					if ( $page ) {
						$fields[$key]['human_value'] = $page->post_title;
					}
				}
				
				// translators: Placeholder (%s) is the URL to edit the primary language in WPML.
				$fields[$key]['desc'] = sprintf( __( '<a href="%s">Switch to primary language</a> to edit this setting.', 'wp-job-board-pro' ), $url_to_edit_page );
			}
		}
		return $fields;
	}

}

WP_Job_Board_Pro_Polylang::init();