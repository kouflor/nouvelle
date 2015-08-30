<?php

define('KOPA_THEME_TYPE', 'free');
define('KOPA_THEME_URL', 'http://kopatheme.com');
define('KOPA_THEME_NAME', 'new-lotus');
define('KOPA_DOMAIN', 'new-lotus');

/**
 * Kopa Framework by Kopatheme
 * this include calls a file that automatically includes all
 * the files within the folder framework and therefore makes
 * all functions and classes available for later use
 */
require_once( get_template_directory() . '/framework/kopa-framework.php' );

require_once( get_template_directory() . '/library/theme-option.php' );

require_once( get_template_directory() . '/library/sidebar-custom-layout.php' );

add_action('widgets_init', 'kopa_register_widgets');

function kopa_register_widgets() {
    include( 'widgets/widget.php' );
}

require trailingslashit(get_template_directory()) . '/library/includes/bfithumb.php';
require trailingslashit(get_template_directory()) . '/library/front.php';
require trailingslashit(get_template_directory()) . '/library/backend.php';

/* set default socials */
if (!function_exists('kopa_get_socials')) {

    function kopa_get_socials() {
        $kopa_socials = array(
            array(
                'title' => 'Facebook',
                'id' => 'facebook',
                'display'=>'false'
            ),
            array(
                'title' => 'Twitter',
                'id' => 'twitter',
                'display'=>'false'
            ),
            array(
                'title' => 'Instagram',
                'id' => 'instagram',
                'display'=>'false'
            ),
            array(
                'title' => 'Youtube',
                'id' => 'youtube',
                'display'=>'false'
            ),
            array(
                'title' => 'Rss',
                'id' => 'rss',
                'display'=>'false'
            ),
            array(
                'title' => 'Google plus',
                'id' => 'google-plus',
                'display'=>'false'
            )
        );

        return $kopa_socials;
    }
}
