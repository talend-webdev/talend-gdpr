<?php
/**
 * Plugin Name: Talend GDPR Cookie Consent
 * Plugin URI: https://www.talend.com
 * Github Plugin URI: https://github.com/talend-webdev/talend-gdpr
 * Description: GDPR Consent Tools for WP
 * Version: 0.4
 * Author: Matt Cascardi
 * Author: Niklas Dahlqvist
 * Author URI: https://www.talend.com
 * Text Domain: talend-gdpr
 * Domain Path: /languages/
 * @package Talend
 * @subpackage GDPR
 */

if (!defined('ABSPATH')) {
    die('No direct access allowed');
}

define('GDPR_VERSION', '0.4');

if (!class_exists('TalendGDPR')) {
    class TalendGDPR
    {
        public function __construct()
        {
            // Actions
            add_action('plugins_loaded', [$this, 'gdpr_textdomain']);
            add_action('init', [$this, 'register_scripts']);
            add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
            add_action('wp_enqueue_scripts', [$this, 'localize_sript'], 100);
            // Filters
        }

        public function gdpr_textdomain()
        {
            load_plugin_textdomain('talend-gdpr', false, plugin_basename(dirname(__FILE__)) . '/languages');
        }

        public function register_scripts()
        {
            wp_register_script(
                'gdpr-cc-js',
                '//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.js',
                [],
                '3.1.0',
                true
            );
            wp_register_script(
                'gdpr-cc-cookie',
                '//cdnjs.cloudflare.com/ajax/libs/js-cookie/2.2.0/js.cookie.min.js',
                [],
                '2.2.0',
                true
            );

            wp_register_style(
                'gdpr-cc-css',
                '//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.css',
                [],
                '3.1.0',
                'all'
            );
        }

        public function enqueue_scripts()
        {
            wp_enqueue_script('gdpr-cc-js');
            wp_enqueue_script('gdpr-cc-cookie');
            wp_enqueue_style('gdpr-cc-css');
        }

        public function localize_sript()
        {
            wp_register_script(
                'gdpr-cc-init',
                plugin_dir_url(__FILE__) . 'js/init.js',
                ['gdpr-cc-js'],
                GDPR_VERSION,
                true
            );

            wp_localize_script(
                'gdpr-cc-init',
                'gdpr',
                [
                    'message' => __(
                        'This website uses cookies. By continuing to browse the site you agree to our use of cookies.',
                        'talend-gdpr'
                    ),
                    'dismiss' => __('Ok, thanks', 'talend-gdpr'),
                    'deny' => __('Decline', 'talend-gdpr'),
                    'link' => __('Find out more.', 'talend-gdpr'),
                    'href' => '/cookie-policy/'
                ]
            );
            wp_enqueue_script('gdpr-cc-init');
        }
    }
}

// Boot Plugin
new TalendGDPR();
// EOF
