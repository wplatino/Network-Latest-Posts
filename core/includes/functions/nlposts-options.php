<?php
/**
 * Network Latest Posts
 *
 * @package Network Latest Posts
 * @author José SAYAGO <jose.sayago@laelite.info>
 * @file nlposts-options.php
 *
 * Options
 *      Dashboard options panel.
 */
/*  @section LICENSE

    Copyright (C) 2013  L'Elite de José SAYAGO

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
class NLPosts_Options {
    /**
     * Create Menu
     */
    public static function nlposts_dashboard_menu() {
        $phrases = new NLPosts_Phrases();
        /**
         * Top-level Menu
         */
        add_menu_page(  $phrases->nlposts_options_phrase()->dashboard_panel, 
                        $phrases->nlposts_options_phrase()->dashboard_menu, 
                        'administrator', 
                        $phrases->nlposts_options_phrase()->dashboard_slug, 
                        array( __CLASS__, 'nlposts_options_index' ),
                        plugins_url( 'styles/images/menu_icon.png', dirname( __FILE__ ) )
        );
        add_submenu_page(   $phrases->nlposts_options_phrase()->dashboard_slug, 
                            '', 
                            '', 
                            'administrator', 
                            $phrases->nlposts_options_phrase()->dashboard_slug, 
                            array( __CLASS__, 'nlposts_options_index' ) 
        );
        add_submenu_page(   $phrases->nlposts_options_phrase()->dashboard_slug, 
                            $phrases->nlposts_options_phrase()->dashboard_general_panel, 
                            $phrases->nlposts_options_phrase()->dashboard_general_menu, 
                            'administrator', 
                            $phrases->nlposts_options_phrase()->dashboard_general_slug, 
                            array( __CLASS__, 'nlposts_options_general' )
        );
        add_submenu_page(   $phrases->nlposts_options_phrase()->dashboard_slug, 
                            $phrases->nlposts_options_phrase()->dashboard_themes_panel, 
                            $phrases->nlposts_options_phrase()->dashboard_themes_menu, 
                            'administrator', 
                            $phrases->nlposts_options_phrase()->dashboard_themes_slug, 
                            array( __CLASS__, 'nlposts_options_themes' )
        );
        /**
         * Default Settings
         */
        add_action( 'admin_init', array( __CLASS__, 'nlposts_options_register' ) );
        /** 
         * Load stylesheet
         */
        add_action( 'admin_print_styles', array( __CLASS__, 'nlposts_options_style' ) );
        /** 
         * Activation Hook
         */
        register_activation_hook( __FILE__, array( __CLASS__, 'nlposts_options_default' ) );
    }
    /**
     * Load Options Stylesheet
     */
    public static function nlposts_options_style() {
        // Register style
        wp_register_style( 
            'nlposts-options-style', 
            plugins_url( NLP_STYLES_REL . '/nlposts-options.css', dirname( dirname( __FILE__ ) ) ), 
            '', 
            NLP_VERSION, 
            'all' 
        );
        // Load jQuery UI Dialog
        wp_enqueue_script( 'jquery-ui-dialog' );
        // Enqueue style
        wp_enqueue_style( 'nlposts-options-style' );
    }
    /**
     * Load Main Options Template
     */
    public static function nlposts_options_index() {
        // Load Template
        include_once( NLP_STYLES . 'templates/options-index.php' );
    }
    /**
     * Load General Settings Template
     */
    public static function nlposts_options_general() {
        // Load Template
        include_once( NLP_STYLES . 'templates/options-general.php' );
    }
    /**
     * Load Themes Settings Template
     */
    public static function nlposts_options_themes() {
        // Load Template
        include_once( NLP_STYLES . 'templates/options-themes.php' );
    }
    /**
     * Register Options
     */
    public static function nlposts_options_register() {
        //register our settings
        register_setting( 'nlposts_options_group', 'nlposts_deprecated' );
        register_setting( 'nlposts_options_group', 'nlposts_theme' );
        register_setting( 'nlposts_options_group', 'nlposts_homepage' );
    }
    /**
     * Default Options
     */
    public static function nlposts_options_default() {
        // Options
        $options = apply_filters( 'nlposts_custom_options_default', array(
            'nlposts_deprecated',
            'nlposts_theme',
            'nlposts_homepage',
        ) );
        // Register options
        foreach( $options as $option ) {
            if ( get_option( $option ) === false ) {
                add_option( $option, '' );
            }
        }
    }
    /**
     * Save Options
     *
     * @var   string option and option name
     */
    function nlposts_save_option( $option, $option_name ) {
        $option = htmlspecialchars( trim( $option ) );
        $option_name = htmlspecialchars( $option_name );
        if( get_option( $option_name ) === false ) {
            add_option( $option_name, $option );
        } elseif( get_option( $option_name ) != $option ) {
            update_option( $option_name, $option );
        }
    }
}
 ?>