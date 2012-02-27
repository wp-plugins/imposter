<?php
/**
 * Plugin Name:	Imposter
 * Plugin URI:	http://gostomski.co.uk/code/wordpress-imposter-plugin
 * Author:		Damian Gostomski
 * Author URI:	http://gostomski.co.uk
 * Description:	Allow administrators to take on the role of another user, for testing or trouble shooting purposes.
 * Version:		0.1
 * License:		GPLv2
 */

class DJG_Imposter {
	/**
	 * Register all the hooks and filters for the plugin
	 */
	public function __construct() {
		// Session handling
		if(!session_id()) session_start();
		add_action('wp_logout',						array($this, 'unimpersonate'), 1);
		
		// Only admins can use this plugin (for obvious reasons)
		if(!current_user_can('add_users')) return;
		
		// Add a column to the user list table which will allow you to impersonate that user
		add_filter('manage_users_columns',			array($this, 'user_table_columns'));
		add_action('manage_users_custom_column',	array($this, 'user_table_columns_value'), 10, 3);
		
		// Is this request attempting to impersonate someone?
		if(!empty($_GET['impersonate'])) {
			$this->impersonate($_GET['impersonate']);
		}
	}
	
	/**
	 * Add an additional column to the users table
	 * 
	 * @param $columns - An array of the current columns
	 */
	public function user_table_columns($columns) {
		$columns['djg_imposter']	= 'Impersonate';
		
		return $columns;
	}
	
	/**
	 * Return the value for custom columns
	 * 
	 * @param String $value		- Current value, not used
	 * @param String $column	- The name of the column to return the value for
	 * @param Integer $user_id	- The ID of the user to return the value for
	 * @return String
	 */
	function user_table_columns_value($value, $column, $user_id) {
		switch($column) {
			case 'djg_imposter':
				$impersonate_url	= admin_url("?impersonate=$user_id");
				return "<a href='$impersonate_url'>Impersonate</a>";
			default: return $value;
		}
	}
	
	/**
	 * 
	 */
	public function impersonate($user_id) {
		global $current_user;
		get_currentuserinfo();
		
		// We need to know what user we were before so we can go back
		$_SESSION['impersonated_by']	= $current_user->ID;
		
		// Login as the other user
		wp_set_auth_cookie($user_id, false);
		wp_redirect(admin_url());
		exit;
	}
	
	public function unimpersonate() {
		if(!empty($_SESSION['impersonated_by'])) {
			wp_set_auth_cookie($_SESSION['impersonated_by'], false);
			wp_redirect(admin_url());
			exit;
		}
	}
}

add_action('init', create_function('', 'new DJG_Imposter;'));
