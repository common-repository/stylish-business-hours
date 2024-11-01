<?php
//include '/home2/equestr/public_html/wp-content/plugins/Stylish-Business-Hour/admin/functions/businesshour_option_data.php';
///home2/equestr/public_html/wp-content/plugins/Stylish-Business-Hour/admin/functions/businesshour_option_data.php

class DF_SBH_Bussines_Hour_Plug
{
	private $version = DF_SBH_BUSINESS_HOUR_VERSION;

	function __construct()
	{
		add_action('wp_enqueue_scripts', array($this, 'sbh_js_css_enqueue_scripts'));
		add_action('admin_enqueue_scripts', array($this, 'sbh_js_css_enqueue_scripts'));
		add_action('admin_menu', array($this, 'wpdocs_register_my_custom_menu_page_business_hour'));
	}

	function wpdocs_register_my_custom_menu_page_business_hour()
	{
		$icon_url = DF_SBH_URL . '/assets/images/admin_icon.png';
		add_menu_page(
			__('Stylish Business Hours', 'sbh'),
			__('Stylish Business Hours', 'sbh'),
			'manage_options',
			'business_hour_listing',
			array($this, 'business_hour_listing_page'),
			$icon_url,
			99
		);
		$lists_page_hook = add_submenu_page('business_hour_listing', __('All Lists', 'sbh'), __('All Lists', 'sbh'), 'manage_options', 'business_hour_listing', array($this, 'business_hour_listing_page'));
		add_action( $lists_page_hook, function () {
			wp_enqueue_style( 'sbh_bootstrap' );
			wp_enqueue_script( 'sbh_bootstrap' );
			wp_enqueue_style( 'businessHour_admin_style' );
		} );
		add_submenu_page('business_hour_listing', __('Add New List', 'sbh'), __('Add New List', 'sbh'), 'manage_options', 'business_hour_page_new', array($this, 'my_custom_menu_page_business_hour'));
		//add_submenu_page( 'business_hour_listing', __( 'Settings', 'stylishpl' ), __( 'Settings', 'stylishpl' ), 'manage_options', 'stylish_business_hour_settings', 'stylish_business_hour_settings' );
	}


	function my_custom_menu_page_business_hour()
	{
		require_once dirname(__FILE__, 1) . '/controllers/PageController/businessHourViewController.php';
	}
	function business_hour_listing_page()
	{
		require_once dirname(__FILE__, 1) . '/controllers/PageController/businessHourListController.php';
	}

	function stylish_business_hour_settings()
	{

		require_once dirname(__FILE__) . '/view/businessHourSetting.php';
	}
	function sbh_js_css_enqueue_scripts($hook)
	{
		wp_register_style('jstimepick_style', DF_SBH_URL . 'assets/lib/timepicker/jquery.timepicker.min.css');
		wp_register_script('jstimepick', DF_SBH_URL . 'assets/lib/timepicker/jquery.timepicker.min.js', array('jquery'), $this->version, true);
		wp_register_style('businessHour_admin_style', DF_SBH_URL . 'assets/css/admin_style.css');
		// wp_register_script('businessHour_js', DF_SBH_URL . 'assets/js/businesshour.js', array('jquery'), $this->version, true);

		// new
		wp_register_script('sbh_backend', DF_SBH_URL . 'assets/js/business_new.js', array('jquery'), $this->version, true);
		wp_register_style('sbh_bootstrap', DF_SBH_URL . 'assets/lib/bootstrap/bootstrap.min.css');
		wp_register_script('sbh_bootstrap', DF_SBH_URL . 'assets/lib/bootstrap/bootstrap.min.js', array('jquery'), true);

		wp_enqueue_style('sbh_fonts', 'https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;600&display=swap', false);
		wp_register_style('sbh-list-style', DF_SBH_URL . 'assets/css/style.css', array(), $this->version, 'all');
	}
}

$SBH_ = new DF_SBH_Bussines_Hour_Plug();
