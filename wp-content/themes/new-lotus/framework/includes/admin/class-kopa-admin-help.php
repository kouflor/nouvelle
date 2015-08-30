<?php
/**
 * Add some content to the help tab.
 *
 * @author 		Kopatheme
 * @category 	Admin
 * @package 	KopaFramework/Admin
 * @since       1.0.0
 * @folked      WC_Admin_Help class from WooCommerce
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Kopa_Admin_Help' ) ) :

/**
 * Kopa_Admin_Help Class
 */
class Kopa_Admin_Help {

	/**
	 * Hook in tabs.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		add_action( "current_screen", array( $this, 'add_tabs' ), 50 );
	}

	/**
	 * Add help tabs
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function add_tabs() {
		$screen = get_current_screen();

		if ( ! in_array( $screen->id, kopa_get_screen_ids() ) )
			return;

		$screen->add_help_tab( array(
		    'id'	=> 'kopa_framework_docs_tab',
		    'title'	=> __( 'Documentation', 'new-lotus' ),
		    'content'	=>

		    	'<p>' . __( 'Thank you for using Kopa Framework. Should you need help using or extending Kopa Framework please read the documentation.', 'new-lotus' ) . '</p>' .

		    	'<p><a href="#docs" class="button button-primary">' . __( 'Kopa Framework Documentation', 'new-lotus' ) . '</a> <a href="#api" class="button">' . __( 'Developer API Docs', 'new-lotus' ) . '</a></p>'

		) );

		$screen->add_help_tab( array(
		    'id'	=> 'kopa_framework_support_tab',
		    'title'	=> __( 'Support', 'new-lotus' ),
		    'content'	=>

		    	'<p>' . sprintf(__( 'After <a href="%s">reading the documentation</a>, for further assistance you can use the <a href="%s">community forum</a>, or if you have access as a Kopatheme customer, <a href="%s">our support desk</a>.', 'new-lotus' ), '#doc', '#community', '#ticket' ) . '</p>' .

		    	'<p><a href="' . '#' . '" class="button">' . __( 'Community Support', 'new-lotus' ) . '</a> <a href="' . '#' . '" class="button">' . __( 'Customer Support', 'new-lotus' ) . '</a></p>'

		) );

		$screen->add_help_tab( array(
		    'id'	=> 'kopa_framework_bugs_tab',
		    'title'	=> __( 'Found a bug?', 'new-lotus' ),
		    'content'	=>

		    	'<p>' . sprintf(__( 'If you find a bug within Kopa Framework core you can create a ticket via <a href="%s">Kopatheme ticket</a>. Ensure you read the <a href="%s">contribution guide</a> prior to submitting your report. Be as descriptive as possible.', 'new-lotus' ), '#ticket', '#guide') . '</p>' .

		    	'<p><a href="#report" class="button button-primary">' . __( 'Report a bug', 'new-lotus' ) . '</a></p>'

		) );


		$screen->set_help_sidebar(
			'<p><strong>' . __( 'For more information:', 'new-lotus' ) . '</strong></p>' .
			'<p><a href="#" target="_blank">' . __( 'About Kopa Framework', 'new-lotus' ) . '</a></p>' .
			'<p><a href="#" target="_blank">' . __( 'Project on WordPress.org', 'new-lotus' ) . '</a></p>' .
			'<p><a href="#" target="_blank">' . __( 'Official Themes', 'new-lotus' ) . '</a></p>'
		);
	}

}

endif;

return new Kopa_Admin_Help();