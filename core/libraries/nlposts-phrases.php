<?php
/**
 * Network Latest Posts
 *
 * @package Network Latest Posts
 * @author José SAYAGO <jose.sayago@laelite.info>
 * @file nlposts-phrases.php
 *
 * Phrases
 *      Class providing default strings for all core elements.
 */
/*  @section LICENSE
    
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
class NLPosts_Phrases {
    /**
     * Phrases Variables
     *
     * @var array $excerpts Phrases used in excerpts function
     */
    protected $excerpts;
    protected $options;
    protected $alerts;
    /**
     * Excerpt Phrases
     *
     * All phrases used in excerpt core functions.
     * @param array $excerpts Contains a list of phrases used in excerpts
     * @return object $excerpts Object containing all Phrases
     */
    public function nlposts_excerpt_phrase() {
        // Phrases
        $excerpts = apply_filters( 'nlposts_custom_excerpt_phrase', array(
            'ellipsis'      => __( '&hellip;',  NLP_TEXTDOMAIN ),
            'more_link'     => __( 'more',      NLP_TEXTDOMAIN ),
        ) );
        /**
         * WPML Support
         */
        if ( function_exists( 'icl_translate' ) ) {
            foreach( $excerpts as $field => $string ) {
                $excerpts[$field] = icl_translate( NLP_TEXTDOMAIN, $field, $string );
            }
        }
        // Array to Object
        $excerpts = json_decode( json_encode( $excerpts ) );
        // Return object
        return $excerpts;
    }
    /**
     * Phrases for Elements 
     * present in the Dashboard Panel
     */
    public function nlposts_options_phrase() {
        // Phrases
        $options = apply_filters( 'nlposts_custom_options_phrase', array(
            'dashboard_panel'           => __( 'Network Latest Posts | Dashboard',          NLP_TEXTDOMAIN ),
            'dashboard_main'            => __( 'Dashboard',                                 NLP_TEXTDOMAIN ),
            'dashboard_menu'            => __( 'Network Latest Posts',                      NLP_TEXTDOMAIN ),
            'dashboard_slug'            => __( 'nlposts-options',                           NLP_TEXTDOMAIN ),
            'dashboard_cache'           => __( 'Cached Results',                            NLP_TEXTDOMAIN ),
            'dashboard_general_panel'   => __( 'Network Latest Posts | General Settings',   NLP_TEXTDOMAIN ),
            'dashboard_general_menu'    => __( 'General Settings',                          NLP_TEXTDOMAIN ),
            'dashboard_general_slug'    => __( 'nlposts-general-settings',                  NLP_TEXTDOMAIN ),
            'dashboard_themes_panel'    => __( 'Network Latest Posts | Themes',             NLP_TEXTDOMAIN ),
            'dashboard_themes_menu'     => __( 'Theme Installer',                           NLP_TEXTDOMAIN ),
            'dashboard_themes_slug'     => __( 'nlposts-theme-installer',                   NLP_TEXTDOMAIN ),
            'dashboard_themes_field'    => __( 'Theme ZIP File',                            NLP_TEXTDOMAIN ),
            'dashboard_themes_help'     => __( 'Theme must be in .zip format.',             NLP_TEXTDOMAIN ),
            'dashboard_themes_install'  => __( 'Install Now',                               NLP_TEXTDOMAIN ),
            'dashboard_themes_success'  => __( 'Theme was succesfully installed.',          NLP_TEXTDOMAIN ),
            'dashboard_themes_error'    => __( 'Theme must be a .zip file. Try again.',     NLP_TEXTDOMAIN ),
            'dashboard_themes_errorm'   => __( '.zip file seems to be corrupted. Try again.',NLP_TEXTDOMAIN ),
            'dashboard_internal_links'  => __( 'Quick Access',                              NLP_TEXTDOMAIN ),
            'dashboard_external_links'  => __( 'Quick Links',                               NLP_TEXTDOMAIN ),
            'option_nlposts_deprecated' => __( 'Deprecated Mode',                           NLP_TEXTDOMAIN ),
            'option_nlposts_theme'      => __( 'Theme',                                     NLP_TEXTDOMAIN ),
            'option_nlposts_homepage'   => __( 'Set as Homepage',                           NLP_TEXTDOMAIN ),
            'option_nlposts_load_acf'   => __( 'Advanced Custom Fields Support',            NLP_TEXTDOMAIN ),
            'option_nlposts_load_woo'   => __( 'WooCommerce Support',                       NLP_TEXTDOMAIN ),
            'yes'                       => __( 'Yes',                                       NLP_TEXTDOMAIN ),
            'no'                        => __( 'No',                                        NLP_TEXTDOMAIN ),
            'delete'                    => __( 'Delete',                                    NLP_TEXTDOMAIN ),
            'confirm'                   => __( 'Do you want to proceed?',                   NLP_TEXTDOMAIN ),
            'close'                     => __( 'Close',                                     NLP_TEXTDOMAIN ),
            'btn_ok'                    => __( 'Yes',                                       NLP_TEXTDOMAIN ),
            'btn_cancel'                => __( 'Cancel',                                    NLP_TEXTDOMAIN ),
            'empty_records'             => __( 'No custom themes available yet.',           NLP_TEXTDOMAIN ),
            'theme_deleted'             => __( 'Theme successfuly deleted.',                NLP_TEXTDOMAIN ),
            'theme_not_deleted'         => __( 'Could not delete this theme. Try again.',   NLP_TEXTDOMAIN ),
            'cached_results'            => _n('%d element in cache.', '%d elements in cache.', $x, NLP_TEXDOMAIN),
        ) );
        /**
         * WPML Support
         */
        if ( function_exists( 'icl_translate' ) ) {
            foreach( $options as $field => $string ) {
                $options[$field] = icl_translate( NLP_TEXTDOMAIN, $field, $string );
            }
        }
        // Array to object
        $options = json_decode( json_encode( $options ) );
        // Return object
        return $options;
    }
    /**
     * Phrases for Alert 
     * Notifications
     */
    public function nlposts_alert_phrase() {
        $alerts = apply_filters( 'nlposts_custom_alerts_phrase', array(
            'alert_msg' => __( 'Sorry, there is no recent content to display.',             NLP_TEXTDOMAIN ),
            'alert_adm' => __( 'No posts found. Please check your settings and try again.', NLP_TEXTDOMAIN ),
        ) );
        /**
         * WPML Support
         */
        if ( function_exists( 'icl_translate' ) ) {
            foreach( $alerts as $field => $string ) {
                $alerts[$field] = icl_translate( NLP_TEXTDOMAIN, $field, $string );
            }
        }
        $alerts = json_decode( json_encode( $alerts ) );
        return $alerts;
    }
    /**
     * Phrases for External
     * Links
     */
    public function nlposts_external_links() {
        $links = array(
            'link_documentation'    => __( 'Documentation',                                 NLP_TEXTDOMAIN ),
            'link_store'            => __( "L'Elite Store",                                 NLP_TEXTDOMAIN )
        );
        /**
         * WPML Support
         */
        if ( function_exists( 'icl_translate' ) ) {
            foreach( $links as $field => $string ) {
                $links[$field] = icl_translate( NLP_TEXTDOMAIN, $field, $string );
            }
        }
        $links = json_decode( json_encode( $links ) );
        return $links;
    }
}
?>