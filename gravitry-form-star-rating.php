<?php

/**
 * Plugin Name: Star Rating Gravity Form
 * Description: This plugin allows create Rangeslider for gravityfrom.
 * Version: 1.0
 * Author: Ocean Infotech
 * Author URI:
 * Copyright:2019 
 */

if (!defined('ABSPATH')) {
	die('-1');
}
if (!defined('SRGF_rating_GF_PLUGIN_NAME')) {
	define('SRGF_rating_GF_PLUGIN_NAME', 'Star Rating Gravity Form');
}
if (!defined('SRGF_rating_GF_PLUGIN_VERSION')) {
	define('SRGF_rating_GF_PLUGIN_VERSION', '1.0.0');
}
if (!defined('SRGF_rating_GF_PLUGIN_FILE')) {
	define('SRGF_rating_GF_PLUGIN_FILE', __FILE__);
}
if (!defined('SRGF_rating_GF_PLUGIN_DIR')) {
	define('SRGF_rating_GF_PLUGIN_DIR',plugins_url('', __FILE__));
}
if (!defined('SRGF_rating_GF_DOMAIN')) {
	define('SRGF_rating_GF_DOMAIN', 'SRGF_rating_GF');
}

if (!class_exists('SRGF_rating_GF')) {

	class SRGF_rating_GF {
	  	protected static $rating;
  
	  	function includes() {
			include_once('admin/gravity_rating.php');
	  	} 


	  	function init() { 
			add_action('admin_enqueue_scripts', array($this, 'rating_load_admin_script_style'));
			add_action('wp_enqueue_scripts', array($this, 'rating_load_admin_script_style'),999);		
	  	}


	  	function rating_load_admin_script_style() {
		  	wp_enqueue_script( 'scrsssipt', SRGF_rating_GF_PLUGIN_DIR . '/js/jquery.rateit.js', false, '1.0.0' );
		  	wp_enqueue_script( 'scrsipt', SRGF_rating_GF_PLUGIN_DIR . '/js/rating.js', false, '1.0.0' );
		  	wp_enqueue_style( 'stylssse', SRGF_rating_GF_PLUGIN_DIR . '/js/rateit.css', false, '1.0.0' );
	  	}


	  	public static function rating() {
			if (!isset(self::$rating)) {
		  		self::$rating = new self();
		  		self::$rating->init();
		  		self::$rating->includes();
		  	}
			return self::$rating;
		}
	}
	add_action('plugins_loaded', array('SRGF_rating_GF', 'rating'));
}

?>