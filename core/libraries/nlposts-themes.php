<?php
/**
 * Network Latest Posts
 *
 * @package Network Latest Posts
 * @author José SAYAGO <jose.sayago@laelite.info>
 * @file nlposts-themes.php
 *
 * Themes
 *      Class providing theme callable functions.
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
class NLPosts_Themes {
    /**
     * Constructor
     */
    public function NLPosts_Themes( $data = null, $parameters = null ) {
        // Make data available
        $this->data = &$data;
        $this->parameters = &$parameters;
    }
    /**
     * Load Theme
     */
    public function nlposts_theme_load() {
        // Local theme
        if( file_exists( NLP_THEMES . NLP_ACTIVE_THEME . '/index.php' ) )
            // Load index template
            include_once( NLP_THEMES . NLP_ACTIVE_THEME . '/index.php' );
        // User theme
        else
            // Load index template
            include_once( NLP_THEMES_USER . NLP_ACTIVE_THEME . '/index.php' );
    }
    /**
     * Load Theme as Homepage
     */
    public function nlposts_theme_home() {
        // Is homepage?
        if( is_home() ) {
            // Local theme
            if( file_exists( NLP_THEMES . NLP_ACTIVE_THEME . '/home.php' ) )
                // Load index template
                include_once( NLP_THEMES . NLP_ACTIVE_THEME . '/home.php' );
            // User theme
            else
                // Load index template
                include_once( NLP_THEMES_USER . NLP_ACTIVE_THEME . '/home.php' );
            // Close the door
            exit();
        }
    }
    /**
     * Load Theme Stylesheet
     */
    public function nlposts_theme_style() {
        // Local styles
        if( file_exists( NLP_THEMES . NLP_ACTIVE_THEME . '/style.css' ) ) {
            // Register style
            wp_register_style( 
                NLP_ACTIVE_THEME . '-style', 
                plugins_url( NLP_THEMES_REL . NLP_ACTIVE_THEME . '/style.css', dirname( dirname( __FILE__ ) ) ), 
                '', 
                NLP_VERSION, 
                'all'
            );
        // User styles
        } else {
            // Register style
            wp_register_style( 
                NLP_ACTIVE_THEME . '-style', 
                NLP_THEMES_USER_REL . NLP_ACTIVE_THEME . '/style.css',
                '', 
                NLP_VERSION, 
                'all' 
            );
        }
        // Enqueue style
        wp_enqueue_style( NLP_ACTIVE_THEME . '-style' );
    }
}
?>