<?php
/**
 * Network Latest Posts
 *
 * @package Network Latest Posts
 * @author José SAYAGO <jose.sayago@laelite.info>
 * @file nlposts-config.php
 *
 * Configuration
 *      Default paths and pre-defined variables required by this software.
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
/**
 * Absolute Paths
 */
$wp_upload_dir = wp_upload_dir();
define( 'NLP_DIR',          '/'.basename( dirname( __FILE__ ) ).'/',                true );
define( 'NLP_NAME',         'Network Latest Posts',                                 true );
define( 'NLP_VERSION',      '4.0',                                                  true );
define( 'NLP_TEXTDOMAIN',   'trans-nlp',                                            true );
define( 'NLP_TRANSIENT',    'nlposts_data_',                                        true );
define( 'NLP_ROOT',         dirname( __FILE__ ),                                    true );
define( 'NLP_THEMES',       NLP_ROOT . '/themes/',                                  true );
define( 'NLP_THEME_USERN', 'nlposts_themes',                                        true );
define( 'NLP_THEMES_USER',  $wp_upload_dir['basedir'].'/'. NLP_THEME_USERN .'/',    true );
define( 'NLP_CORE',         NLP_ROOT . '/core/',                                    true );
define( 'NLP_INCLUDES',     NLP_CORE . 'includes/',                                 true );
define( 'NLP_FUNCTIONS',    NLP_CORE . 'includes/functions/',                       true );
define( 'NLP_STYLES',       NLP_CORE . 'includes/styles/',                          true );
define( 'NLP_LIBRARIES',    NLP_CORE . 'libraries/',                                true );
define( 'NLP_JS',           NLP_CORE . 'libraries/js/',                             true );
define( 'NLP_LANGUAGES',    NLP_CORE . 'languages/',                                true );
define( 'NLP_ACTIVE_THEME', get_option( 'nlposts_theme', 'evolution', true ),       true );
define( 'NLP_HOMEPAGE',     get_option( 'nlposts_homepage', 'yes', true ),          true );
define( 'NLP_DEPRECATED',   get_option( 'nlposts_deprecated', 'yes', true ),        true );
define( 'NLP_ACF',          get_option( 'nlposts_load_acf', 'yes', true ),          true );
define( 'NLP_WOO',          get_option( 'nlposts_load_woo', 'yes', true ),          true );
/**
 * Relative Paths
 */
define( 'NLP_CORE_REL',         'core/',                                            true );
define( 'NLP_INCLUDES_REL',     'includes/',                                        true );
define( 'NLP_FUNCTIONS_REL',    'includes/functions/',                              true );
define( 'NLP_STYLES_REL',       'includes/styles/',                                 true );
define( 'NLP_LIBRARIES_REL',    'libraries/',                                       true );
define( 'NLP_JS_REL',           'libraries/js/',                                    true );
define( 'NLP_LANGUAGES_REL',    'languages/',                                       true );
define( 'NLP_THEMES_REL',       'themes/',                                          true );
define( 'NLP_THEMES_USER_REL',  $wp_upload_dir['baseurl'].'/'. NLP_THEME_USERN .'/',true );
/**
 * Network Latest Posts v4.0
 *
 * Includes lots of new elements, it's been rewritten to
 * improve quality and flexibility. That's why there is now
 * a deprecated mode which allow users to keep using features
 * present till version 3.5.6.
 *
 * This is a solution to avoid breaking websites, only those who
 * are well aware of new features present in version 4.0 are
 * encouraged to disable deprecated mode through the options panel.
 */
require_once NLP_LIBRARIES  . 'nlposts-html.php';
if( NLP_DEPRECATED != 'yes' ) {
    /**
     * System Assets
     */
    require_once NLP_FUNCTIONS  . 'nlposts-core.php';
    require_once NLP_FUNCTIONS  . 'nlposts-widgets.php';
    require_once NLP_FUNCTIONS  . 'nlposts-updates.php';
    require_once NLP_LIBRARIES  . 'nlposts-placeholders.php';
    require_once NLP_LIBRARIES  . 'nlposts-themes.php';
    require_once NLP_THEMES     . 'nlposts-theme-loader.php';
    if( NLP_ACF == 'yes' ) {
        /**
         * Check if Advanced Custom Fields plugin is installed
         */
        if( file_exists( WP_CONTENT_DIR . '/plugins/advanced-custom-fields/acf.php' ) ) {
            require_once NLP_LIBRARIES . 'nlposts-acf.php';
        } else {
            /**
             * Otherwise, do not load support for ACF
             */
            if( get_option( 'nlposts_load_acf' ) === false ) {
                add_option( 'nlposts_load_acf', 'no' );
            } elseif( get_option( 'nlposts_load_acf' ) != 'no' ) {
                update_option( 'nlposts_load_acf', 'no' );
            }
        }
    }
    if( NLP_WOO == 'yes' ) {
        /**
         * Check if WooCommerce plugin is installed
         */
        if( file_exists( WP_CONTENT_DIR . '/plugins/woocommerce/woocommerce.php' ) ) {
            require_once WP_CONTENT_DIR . '/plugins/woocommerce/woocommerce.php';
            require_once NLP_LIBRARIES . 'nlposts-woo.php';
        } else {
            /**
             * Otherwise, do not load support for WooCommerce
             */
            if( get_option( 'nlposts_load_woo' ) === false ) {
                add_option( 'nlposts_load_woo', 'no' );
            } elseif( get_option( 'nlposts_load_woo' ) != 'no' ) {
                update_option( 'nlposts_load_woo', 'no' );
            }
        }
    }
    /**
     * Set Upload Folder
     */
    if( !is_dir( NLP_THEMES_USER ) ) {
        // Check if folder exists
        if ( !is_dir( NLP_THEMES_USER ) ) {
            // Create folder
            wp_mkdir_p( NLP_THEMES_USER );
        }
    }
} else {
    /**
     * Enter legacy mode
     */
    require_once( NLP_ROOT . '/deprecated/network-latest-posts.php' );
    require_once( NLP_ROOT . '/deprecated/network-latest-posts-widget.php' );
}
require_once NLP_FUNCTIONS  . 'nlposts-options.php';
require_once NLP_LIBRARIES  . 'nlposts-phrases.php';
/**
 * Made in Venezuela by 
 *
 * José Luis SAYAGO ROJAS
 *      Web Consultant & e-Marketing Specialist
 *      @link http://josesayago.com/blog/
 *
 * José de Jesús SAYAGO ROJAS
 *      Graphic Designer
 *      @link http://josedejesus.me
 *
 * L'Elite
 *      @link http://laelite.info
 */
?>