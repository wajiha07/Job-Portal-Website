<?php
/**
 * Employer Meta
 *
 * @package    wp-job-board-pro
 * @author     Habq 
 * @license    GNU General Public License, version 3
 */

if ( ! defined( 'ABSPATH' ) ) {
  	exit;
}

class WP_Job_Board_Pro_Employer_Meta {

	private static $_instance = null;
	private $metas = null;
	private $post_id = null;

	public static function get_instance($post_id) {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self($post_id);
		} else {
			self::$_instance->post_id = $post_id;
		}
		return self::$_instance;
	}

	public function __construct($post_id) {
		$this->post_id = $post_id;
		$this->metas = $this->get_post_metas();
	}

	public function get_post_metas() {
		$return = array();
		$fields = WP_Job_Board_Pro_Custom_Fields::get_custom_fields(array(), false, 0, WP_JOB_BOARD_PRO_EMPLOYER_PREFIX);
		if ( !empty($fields) ) {
			foreach ($fields as $field) {
				if ( !empty($field['id']) ) {
					$return[$field['id']] = $field;
				}
			}
		}
		return apply_filters('wp-job-board-pro-get-employer-post-metas', $return);
	}

	public function check_post_meta_exist($key) {
		if ( isset($this->metas[WP_JOB_BOARD_PRO_EMPLOYER_PREFIX.$key]) ) {
			return true;
		}
		return false;
	}

	public function check_custom_post_meta_exist($key) {
		if ( isset($this->metas[$key]) ) {
			return true;
		}
		return false;
	}
	
	public function get_post_meta($key) {
		return get_post_meta($this->post_id, WP_JOB_BOARD_PRO_EMPLOYER_PREFIX.$key, true);
	}

	public function get_custom_post_meta($key) {
		return get_post_meta($this->post_id, $key, true);
	}
	
	public function get_post_meta_title($key) {
		if ( !empty($this->metas[WP_JOB_BOARD_PRO_EMPLOYER_PREFIX.$key]) && isset($this->metas[WP_JOB_BOARD_PRO_EMPLOYER_PREFIX.$key]['name'])) {
			return $this->metas[WP_JOB_BOARD_PRO_EMPLOYER_PREFIX.$key]['name'];
		}
		return '';
	}

	public function get_custom_post_meta_title($key) {
		if ( !empty($this->metas[$key]) && isset($this->metas[$key]['name'])) {
			return $this->metas[$key]['name'];
		}
		return '';
	}

	public function get_meta_field($key) {
		if ( !empty($this->metas[WP_JOB_BOARD_PRO_EMPLOYER_PREFIX.$key]) ) {
			return $this->metas[WP_JOB_BOARD_PRO_EMPLOYER_PREFIX.$key];
		}
		return '';
	}

	public function get_custom_meta_field($key) {
		if ( !empty($this->metas[$key]) ) {
			return $this->metas[$key];
		}
		return '';
	}
}
