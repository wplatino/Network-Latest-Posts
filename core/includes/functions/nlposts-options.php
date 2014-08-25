<?php
/**
 * Network Latest Posts
 *
 * @package Network Latest Posts
 * @author José SAYAGO <jose.sayago@laelite.info>
 * @internal nlposts-options.php
 *
 * Options
 *      Dashboard options panel.
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
        wp_register_style(
            'nlposts-switchery-style',
            plugins_url( NLP_STYLES_REL . '/switchery.min.css', dirname( dirname( __FILE__ ) ) ),
            '',
            NLP_VERSION,
            'all'
        );
        wp_enqueue_script(
            'nlposts-switchery-script',
            plugins_url( NLP_JS_REL . '/switchery.min.js', dirname( dirname( __FILE__ ) ) ),
            false,
            NLP_VERSION,
            false
        );
        wp_enqueue_script(
            'nlposts-switches-script',
            plugins_url( NLP_JS_REL . '/switches.min.js', dirname( dirname( __FILE__ ) ) ),
            false,
            NLP_VERSION,
            true
        );
        // Load jQuery UI Dialog
        wp_enqueue_script( 'jquery-ui-dialog' );
        // Load Switchery
        wp_enqueue_script( 'nlposts-switchery-script' );
        wp_enqueue_script( 'nlposts-switches-script' );
        // Enqueue style
        wp_enqueue_style( 'nlposts-options-style' );
        wp_enqueue_style( 'nlposts-switchery-style' );
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
     * @param string $option Option value
     * @param string $option_name Option name
     */
    function nlposts_save_option( $option, $option_name ) {
        // Clean variables
        $option = htmlspecialchars( trim( $option ) );
        $option_name = htmlspecialchars( $option_name );
        // Verify if option exists
        if( get_option( $option_name ) === false ) {
            // Create option
            add_option( $option_name, $option );
        } elseif( get_option( $option_name ) != $option ) {
            // Update option
            update_option( $option_name, $option );
        }
    }
    /**
     * Get Transients
     *
     * @return array $nlp_transients Data
     */
    public function nlposts_transient_data() {
        // WordPress Global Database Object
        global $wpdb;
        // Get Transients
        $nlp_transients = $wpdb->get_results("SELECT DISTINCT option_name FROM $wpdb->options WHERE option_name LIKE '_transient_".NLP_TRANSIENT."%' ");
        // If data exists
        if( !empty( $nlp_transients ) )
            // Return data
            return $nlp_transients;
        else
            // Nothing
            return false;
    }
    /**
     * Remove Transients
     *
     * @return bool true/false
     */
    public function nlposts_transient_remove() {
        // WordPress Global Database Object
        global $wpdb;
        // Get Transients
        $nlp_transients = $wpdb->get_results( "SELECT DISTINCT option_name FROM $wpdb->options WHERE option_name LIKE '_transient_".NLP_TRANSIENT."%' " );
        // If data exists
        if( !empty( $nlp_transients ) )
            // Return data
            if( $wpdb->query( "DELETE FROM $wpdb->options WHERE option_name LIKE '_transient_".NLP_TRANSIENT."%' " ) )
                return true;
            else
                return false;
        else
            // Nothing
            return false;
    }
}
 ?>