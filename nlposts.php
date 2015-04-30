<?php
/*
Plugin Name: Network Latest Posts
Plugin URI: http://en.8elite.com/network-latest-posts
Description: Display posts from all blogs in a WordPress Network. It can be used as an embedded function, shortcodes or widgets.
Version: 4.0
Author: Jose Luis SAYAGO
Author URI: http://laelite.info/
 */
/**
 * Network Latest Posts
 *
 * @package Network Latest Posts
 * @author José SAYAGO <jose.sayago@laelite.info>
 * @version 4.0
 * @internal nlposts.php
 *
 * Root
 *      Per aspera ad astra.
 */
/*  LICENSE

    Copyright (C) 2007 - 2014  L'Elite de José SAYAGO

    'NLPosts', 'Network Latest Posts', 'Network Latest Posts Evolution',
    'NLPosts Evolution' are unregistered trademarks of L'Elite, and cannot 
    be re-used in conjunction with the GPL v2 usage of this software 
    under the license terms of the GPL v2 without permission.

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */
// Load Configuration File
require_once( '_config.php' );
$exec_config = new NLP_Config();
$exec_config->NLP_Config();
// Load Shortcodes for Version +4.0
if( NLP_DEPRECATED != 'yes' ) {
    /**
     * Create a hook for Network Latest 
     * Posts Shortcode
     */
    add_shortcode( 'nlposts', create_function( '$parameters', '
        // Create a class object
        $nlposts = new NLPosts_Core();
        // Load shortcode function
        return $nlposts->nlposts_do_shortcode( $parameters );'
    ) );
}
/**
 * Add menu if admin
 */
if ( is_admin() ) {
    add_action( 'admin_menu', array( 'NLPosts_Options', 'nlposts_dashboard_menu'  ) );
    /*
     * TinyMCE Shortcode Plugin
     * Add a NLPosts button to the TinyMCE editor
     * this will simplify the way it is used
     */
    if( !function_exists( 'nlp_shortcode_button' ) ) {
        // TinyMCE button settings
        function nlp_shortcode_button() {
            if ( current_user_can('edit_posts') && current_user_can('edit_pages') ) {
                add_filter('mce_external_plugins', 'nlp_shortcode_plugin');
                add_filter('mce_buttons', 'nlp_register_button');
            }
        }
    }
    if( !function_exists( 'nlp_register_button' ) ) {
        // Hook the button into the TinyMCE editor
        function nlp_register_button($buttons) {
            array_push($buttons, "|" , "nlposts");
            return $buttons;
        }
    }
    if( !function_exists( 'nlp_shortcode_plugin' ) ) {
        // Load the TinyMCE NLposts shortcode plugin
        function nlp_shortcode_plugin($plugin_array) {
           $plugin_array['nlposts'] = plugin_dir_url(__FILE__) . NLP_CORE_REL . NLP_JS_REL .'tinymce-shortcode.js';
           return $plugin_array;
        }
    }
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-ui-accordion');
    wp_enqueue_script('jquery-ui-tabs');
    wp_register_style('nlposts-jui', plugins_url('/core/includes/styles/jquery-ui.theme.min.css', __FILE__));
    wp_enqueue_style('nlposts-jui');
    // Hook the shortcode button into TinyMCE
    add_action('init', 'nlp_shortcode_button');
}
?>