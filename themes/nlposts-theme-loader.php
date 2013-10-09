<?php
/**
 * Network Latest Posts
 *
 * @package Network Latest Posts
 * @author José SAYAGO <jose.sayago@laelite.info>
 * @file nlposts-theme-loader.php
 *
 * Theme Loader
 *      Access themes' class using callback functions.
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
/**
 * Set as Homepage
 */
if( NLP_HOMEPAGE === 'yes' ) {
	// Load template
	add_action( 'template_redirect', create_function( '', '
	    // Create a class object
	    $themes = new NLPosts_Themes();
	    // Load theme
	    return $themes->nlposts_theme_home();'
	) );
}
/** 
 * Load stylesheet
 */
add_action( 'wp_print_styles', create_function( '', '
    // Create a class object
    $themes = new NLPosts_Themes();
    // Load theme
    return $themes->nlposts_theme_style();'
) );
?>