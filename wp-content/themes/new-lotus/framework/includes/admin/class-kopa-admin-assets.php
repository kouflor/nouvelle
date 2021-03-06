<?php
/**
 * Load assets.
 *
 * @author 		Kopatheme
 * @category 	Admin
 * @package 	KopaFramework/Admin
 * @since       1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Kopa_Admin_Assets' ) ) {

/**
 * Kopa_Admin_Assets Class
 */
class Kopa_Admin_Assets {

	/**
	 * Hook in tabs.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
	}

	/**
	 * Enqueue styles
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_styles() {
		global $wp_scripts;

		$screen = get_current_screen();

		// Admin styles for admins pages only
		wp_register_style( 'kopa_admin', KF()->framework_url() . '/assets/css/admin.css', array(), KOPA_FRAMEWORK_VERSION );

		// font awesome
		wp_register_style( 'kopa_font_awesome', KF()->framework_url() . '/assets/css/font-awesome.css', array(), '4.0.3' );

		// style for custom layout feature
		wp_register_style( 'kopa_custom_layout', KF()->framework_url() . '/assets/css/custom-layout.css', array(), KOPA_FRAMEWORK_VERSION );

		// check admin pages to enqueue styles
		if ( in_array( $screen->id, kopa_get_screen_ids() ) ) {
			wp_enqueue_style( 'kopa_font_awesome' );
			wp_enqueue_style( 'kopa_admin' );
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_style( 'thickbox' );
		}

		do_action( 'kopa_admin_css' );
	}


	/**
	 * Enqueue scripts
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_scripts() {
		global $wp_query, $post;

		$screen       = get_current_screen();
		$suffix       = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		// $suffix       = false ? '' : '.min';

		// Register scripts
		wp_register_script( 'kopa_admin', KF()->framework_url() . '/assets/js/admin'.$suffix.'.js', array( 'jquery', 'wp-color-picker', 'jquery-ui-sortable', 'kopa_media_uploader' ), KOPA_FRAMEWORK_VERSION );

		wp_register_script( 'kopa_dynamic_sidebar', KF()->framework_url() .'/assets/js/admin-sidebar'.$suffix.'.js', array( 'jquery', 'jquery-ui-sortable', 'thickbox' ), KOPA_FRAMEWORK_VERSION );

		wp_register_script( 'kopa_dynamic_layout', KF()->framework_url() .'/assets/js/admin-layout'.$suffix.'.js', array( 'jquery' ), KOPA_FRAMEWORK_VERSION );

		// script for custom layout feature
		wp_register_script( 'kopa_custom_layout', KF()->framework_url() . '/assets/js/custom-layout'.$suffix.'.js', array( 'jquery' ), KOPA_FRAMEWORK_VERSION );

		wp_register_script( 'kopa_media_uploader', KF()->framework_url() . '/assets/js/media-uploader'.$suffix.'.js', array( 'jquery' ), KOPA_FRAMEWORK_VERSION );

		// KopaFramework admin pages
	    if ( in_array( $screen->id, kopa_get_screen_ids() ) ) {
			wp_enqueue_script( 'kopa_admin' );
			wp_localize_script( 'kopa_admin', 'kopa_google_fonts', kopa_google_font_property_list_array() );
			wp_localize_script( 'kopa_admin', 'kopa_google_font_families', kopa_google_font_list() );
			wp_localize_script( 'kopa_admin', 'kopa_system_fonts', kopa_system_font_list() );
			wp_localize_script( 'kopa_admin', 'kopa_font_styles', kopa_font_style_options() );
			wp_localize_script( 'kopa_admin', 'kopa_custom_font_attributes', array(
				'name' => array(
					'type'        => 'text',
					'placeholder' => __( 'Enter font name', 'new-lotus' ),
					'required'    => false,
					'value'       => __( 'Custom font', 'new-lotus' ),
				),
				'woff' => array(
					'type'        => 'upload',
					'placeholder' => __( 'Upload .woff font file', 'new-lotus' ),
					'mimes'       => 'font/woff',
				),
				'ttf' => array(
					'type'        => 'upload',
					'placeholder' => __( 'Upload .ttf font file', 'new-lotus' ),
					'mimes'       => 'font/truetype',
				),
				'eot' => array(
					'type'        => 'upload',
					'placeholder' => __( 'Upload .eot font file', 'new-lotus' ),
					'mimes'       => 'font/eot',
				),
				'svg' => array(
					'type'        => 'upload',
					'placeholder' => __( 'Upload .svg font file', 'new-lotus' ),
					'mimes'       => 'font/svg',
				),
			) );
			wp_localize_script( 'kopa_admin', 'kopa_admin_l10n', array(
				'upload' => __( 'Upload', 'new-lotus' ),
				'remove' => __( 'Remove', 'new-lotus' ),
				'confirm_reset'   => __( 'Click OK to reset. Any selected settings will be lost!', 'new-lotus' ),
				'confirm_import'  => __( 'Click OK to import. Any selected settings will be lost!', 'new-lotus' ),
				'confirm_delete'  => __( 'Are you sure you want to delete?', 'new-lotus' ),
			) );

			if ( function_exists( 'wp_enqueue_media' ) ) {
				wp_enqueue_media();
			}

			wp_enqueue_script( 'kopa_dynamic_sidebar' );
			wp_localize_script( 'kopa_dynamic_sidebar', 'kopa_sidebar_attributes_l10n', array(
				'ajax_url'          => admin_url('admin-ajax.php'),
				'warning'           => __( 'Warning', 'new-lotus' ),
				'error'             => __( 'Error', 'new-lotus' ),
				'info'              => __( 'Info', 'new-lotus' ),
				'confirm_message'   => __( 'Are you sure you want to delete?', 'new-lotus' ),
				'close'             => __( 'Close', 'new-lotus' ),
				'remove'            => __( 'Delete', 'new-lotus' ),
				'advanced_settings' => __( 'Advanced Settings', 'new-lotus' ),
				'attributes'        => array(
					'name'          => __( 'Name', 'new-lotus' ),
					'description'   => __( 'Description', 'new-lotus' ),
					'before_widget' => __( 'Before Widget', 'new-lotus' ),
					'after_widget'  => __( 'After Widget', 'new-lotus' ),
					'before_title'  => __( 'Before Title', 'new-lotus' ),
					'after_title'   => __( 'After Title', 'new-lotus' ),
				),
			) );

			wp_enqueue_script( 'kopa_dynamic_layout' );
		}

		// script for widget upload fields
		if ( 'widgets' === $screen->id ) {
			wp_enqueue_script( 'kopa_media_uploader' );
			wp_localize_script( 'kopa_media_uploader', 'kopa_upload_l10n', array(
				'upload' => '+',
				'remove' => '&ndash;',
			) );
			if ( function_exists( 'wp_enqueue_media' ) ) {
				wp_enqueue_media();
			}
		} else {
			wp_localize_script( 'kopa_media_uploader', 'kopa_upload_l10n', array(
				'upload' => __( 'Upload', 'new-lotus' ),
				'remove' => __( 'Remove', 'new-lotus' ),
			) );
		}

	}
   
}

}

return new Kopa_Admin_Assets();
