<?php
/**
 * Plugin Name: Talend GDPR Wordpress plugin
 * Plugin URI: https://www.talend.com
 * Github Plugin URI: https://github.com/talend-webdev/talend-gdpr
 * Description: GDPR Consent Tools for WP
 * Version: 0.1
 * Author: Matt Cascardi
 * Author URI: https://www.talend.com
 * @package Talend
 * @subpackage GDPR
 */

define('GDPR_VERSION', '0.1');

function gdpr() {
    wp_register_script(
        'gdpr-cc-js',
        '//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.js',
        [], '3.1.0', true
    );
    wp_register_style(
        'gdpr-cc-css',
        '//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.css',
        [], '3.1.0', 'all'
    );
    wp_register_script(
        'gdpr-cc-init',
        plugin_dir_url( __FILE__ ) . 'js/init.js',
        ['gdpr-cc-js'], GDPR_VERSION, true
    );
}
add_action('init', 'gdpr');

function gdpr_cc_js() {
    wp_enqueue_script('gdpr-cc-js');
    wp_enqueue_style('gdpr-cc-css');
}

function gdpr_cc_init() {
    wp_enqueue_script('gdpr-cc-init');
}


if(!is_admin()) {
    add_action('wp_footer', 'gdpr_cc_content');
    add_action('wp_footer', 'gdpr_cc_init');
    add_action('wp_footer', 'gdpr_cc_js');
}


/**
 * Cookie Consent Content
 *
 * Output the content for the cookie consent banner
 *
 */
function gdpr_cc_content() {
    // TODO:  Allow setting of the cookie policy href in wp options

    wp_localize_script(
        'gdpr-cc-init',
        'gdprCcContent',
        [
            'message' => __('This website uses cookies. By continuing to browse the site you agree to our use of cookies.', 'gdpr-cc'),
            'dismiss' => __('Ok, thanks', 'gdpr-cc'),
            'link' => __('Find out more.', 'gdpr-cc'),
            'href' => '/cookie-policy/'
        ]
    );
}

// EOF