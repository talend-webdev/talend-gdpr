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

function cookie_consent_js() {
    wp_enqueue_script(
        'gdpr-cc',
        '//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.js',
        [], '3.1.0', true
    );
    wp_enqueue_style(
        'gdpr-cc-css',
        '//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.css',
        [], '3.1.0'
    );
    wp_enqueue_script(
        'gdpr-cc-init',
        plugin_dir_url( __FILE__ ) . 'js/init.js',
        ['gdpr-cc'], true
    );
    wp_localize_script(
        'gdpr-cc',
        'gdprSettings',
        [
            'content' => [
                'message' => cookie_consent_text(),
                'dismiss' => __('Ok, thanks', 'gdpr-cc'),
                'link' => __('Find out more.', 'gdpr-cc')
            ],
            'theme' => 'classic',
            'palette' =>
             [
                 'popup' => [
                     'background' => '#464646',
                     'text' => '#ddd'
                 ],
                 'button' => [
                     'background' => '#82bd41'

                 ]
             ]
        ]
    );
}

if(!is_admin()) {
    add_action('wp_enqueue_scripts', 'cookie_consent_js');
}

function cookie_consent_text() {
    return __('This website uses cookies. By continuing to browse the site you agree to our use of cookies. Find out more.', 'gdpr-cc');
}

// EOF