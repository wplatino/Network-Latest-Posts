<?php
/*
Plugin Name: Network Latest Posts
Plugin URI: http://en.8elite.com/network-latest-posts
Description: Display posts from all blogs in a WordPress Network. It can be used as an embedded function, shortcodes or widgets.
Version: 4.0
Author: L'Elite
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
require_once( 'nlposts-config.php' );
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
}
?>