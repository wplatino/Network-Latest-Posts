<?php
/**
 * Network Latest Posts
 *
 * @package Network Latest Posts
 * @author José SAYAGO <jose.sayago@laelite.info>
 * @internal nlposts-config.php
 *
 * Configuration
 *      Default paths and pre-defined variables required by this software.
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
class NLP_Config {
    /**
     * Load Configuration
     */
    function NLP_Config() {
        /**
         * Absolute Paths
         */
        // Upload directory path
        $wp_upload_dir = wp_upload_dir();
        /**
         * Full Paths
         */
        if( !defined( 'NLP_DIR'            ) ) define( 'NLP_DIR',              '/'.basename( dirname( __FILE__ ) ).'/',                true );
        if( !defined( 'NLP_NAME'           ) ) define( 'NLP_NAME',             'Network Latest Posts',                                 true );
        if( !defined( 'NLP_VERSION'        ) ) define( 'NLP_VERSION',          '4.0',                                                  true );
        if( !defined( 'NLP_TEXTDOMAIN'     ) ) define( 'NLP_TEXTDOMAIN',       'trans-nlp',                                            true );
        if( !defined( 'NLP_TRANSIENT'      ) ) define( 'NLP_TRANSIENT',        'nlposts_data_',                                        true );
        if( !defined( 'NLP_ROOT'           ) ) define( 'NLP_ROOT',             dirname( __FILE__ ),                                    true );
        if( !defined( 'NLP_THEMES'         ) ) define( 'NLP_THEMES',           NLP_ROOT . '/themes/',                                  true );
        if( !defined( 'NLP_THEMES_FOLDER'  ) ) define( 'NLP_THEMES_FOLDER',    'nlposts_themes',                                       true );
        if( !defined( 'NLP_THEMES_PATH'    ) ) define( 'NLP_THEMES_PATH',      $wp_upload_dir['basedir'].'/'. NLP_THEMES_FOLDER .'/',  true );
        if( !defined( 'NLP_CORE'           ) ) define( 'NLP_CORE',             NLP_ROOT . '/core/',                                    true );
        if( !defined( 'NLP_INCLUDES'       ) ) define( 'NLP_INCLUDES',         NLP_CORE . 'includes/',                                 true );
        if( !defined( 'NLP_FUNCTIONS'      ) ) define( 'NLP_FUNCTIONS',        NLP_CORE . 'includes/functions/',                       true );
        if( !defined( 'NLP_STYLES'         ) ) define( 'NLP_STYLES',           NLP_CORE . 'includes/styles/',                          true );
        if( !defined( 'NLP_LIBRARIES'      ) ) define( 'NLP_LIBRARIES',        NLP_CORE . 'libraries/',                                true );
        if( !defined( 'NLP_JS'             ) ) define( 'NLP_JS',               NLP_CORE . 'libraries/js/',                             true );
        if( !defined( 'NLP_LANGUAGES'      ) ) define( 'NLP_LANGUAGES',        NLP_CORE . 'languages/',                                true );
        if( !defined( 'NLP_ACTIVE_THEME'   ) ) define( 'NLP_ACTIVE_THEME',     get_option( 'nlposts_theme', 'evolution', true ),       true );
        if( !defined( 'NLP_HOMEPAGE'       ) ) define( 'NLP_HOMEPAGE',         get_option( 'nlposts_homepage', 'yes', true ),          true );
        if( !defined( 'NLP_DEPRECATED'     ) ) define( 'NLP_DEPRECATED',       get_option( 'nlposts_deprecated', 'yes', true ),        true );
        if( !defined( 'NLP_ACF'            ) ) define( 'NLP_ACF',              get_option( 'nlposts_load_acf', 'yes', true ),          true );
        if( !defined( 'NLP_WOO'            ) ) define( 'NLP_WOO',              get_option( 'nlposts_load_woo', 'yes', true ),          true );
        /**
         * Relative Paths
         */
        if( !defined( 'NLP_CORE_REL'       ) ) define( 'NLP_CORE_REL',         'core/',                                                true );
        if( !defined( 'NLP_INCLUDES_REL'   ) ) define( 'NLP_INCLUDES_REL',     'includes/',                                            true );
        if( !defined( 'NLP_FUNCTIONS_REL'  ) ) define( 'NLP_FUNCTIONS_REL',    'includes/functions/',                                  true );
        if( !defined( 'NLP_STYLES_REL'     ) ) define( 'NLP_STYLES_REL',       'includes/styles/',                                     true );
        if( !defined( 'NLP_LIBRARIES_REL'  ) ) define( 'NLP_LIBRARIES_REL',    'libraries/',                                           true );
        if( !defined( 'NLP_JS_REL'         ) ) define( 'NLP_JS_REL',           'libraries/js/',                                        true );
        if( !defined( 'NLP_LANGUAGES_REL'  ) ) define( 'NLP_LANGUAGES_REL',    'languages/',                                           true );
        if( !defined( 'NLP_THEMES_REL'     ) ) define( 'NLP_THEMES_REL',       'themes/',                                              true );
        if( !defined( 'NLP_THEMES_PATH_REL') ) define( 'NLP_THEMES_PATH_REL',  $wp_upload_dir['baseurl'].'/'. NLP_THEMES_FOLDER .'/',  true );
        /**
         *  Third Party Plugins
         */
        if( !defined( 'NLP_WOOCOMMERCE_INSTALLED' ) ) define( 'NLP_WOOCOMMERCE_INSTALLED', $this->nlposts_file_exists( 'woocommerce/woocommerce.php' ), true );
        if( !defined( 'NLP_ACF_INSTALLED' ) ) define( 'NLP_ACF_INSTALLED', $this->nlposts_file_exists( 'advanced-custom-fields/acf.php' ), true );
        // Load HTML Library
        require_once NLP_LIBRARIES  . 'nlposts-html.php';
        // Load options
        require_once NLP_FUNCTIONS  . 'nlposts-options.php';
        // Load textdomain and strings
        require_once NLP_LIBRARIES  . 'nlposts-phrases.php';
        // Load +4.0 libraries
        if( NLP_DEPRECATED != 'yes' ) {
            /**
             * Plugin Libraries
             */
            require_once NLP_FUNCTIONS  . 'nlposts-core.php';
            require_once NLP_FUNCTIONS  . 'nlposts-widgets.php';
            require_once NLP_FUNCTIONS  . 'nlposts-updates.php';
            require_once NLP_LIBRARIES  . 'nlposts-placeholders.php';
            require_once NLP_LIBRARIES  . 'nlposts-themes.php';
            require_once NLP_THEMES     . 'nlposts-theme-loader.php';
            // Load Advanced Custom Fields (ACF)
            if( NLP_ACF == 'yes' ) {
                /**
                 * Check if Advanced Custom Fields plugin is installed
                 */
                if( NLP_ACF_INSTALLED ) {
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
            // Load WooCommerce
            if( NLP_WOO == 'yes' ) {
                /**
                 * Check if WooCommerce plugin is installed
                 */
                if( NLP_WOOCOMMERCE_INSTALLED ) {
                    require_once WP_PLUGIN_DIR . '/woocommerce/woocommerce.php';
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
            if( !is_dir( NLP_THEMES_PATH ) ) {
                // Check if folder exists
                if ( !is_dir( NLP_THEMES_PATH ) ) {
                    // Create folder
                    wp_mkdir_p( NLP_THEMES_PATH );
                }
            }
        // Deprecated mode
        } else {
            /**
             * Enter legacy mode
             */
            require_once( NLP_ROOT . '/deprecated/network-latest-posts.php' );
            require_once( NLP_ROOT . '/deprecated/network-latest-posts-widget.php' );
        }
    }
    /**
     * File Exists
     *
     * Verifies if a plugin file exists
     *
     * @param string $file_path Plugin file path
     * @return bool true/false File exists or not
     */
    private function nlposts_file_exists( $file_path ) {
        // Get file path
        $file_path = htmlspecialchars( $file_path );
        // Check if file exists in plugins directory
        if( file_exists( WP_PLUGIN_DIR . '/' . $file_path ) ) {
            // Include WordPress Plugin functions
            include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
            // Check if plugin is active
            if( is_plugin_active( $file_path ) )
                return true;
            else
                return false;
        } else {
            return false;
        }
    }
}
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