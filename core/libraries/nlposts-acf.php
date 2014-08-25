<?php
/**
 * Network Latest Posts
 *
 * @package Network Latest Posts
 * @author José SAYAGO <jose.sayago@laelite.info>
 * @internal nlposts-acf.php
 *
 * Advanced Custom Fields
 *      Class providing support for third party plugin Advanced Custom Fields
 *      @link http://advancedcustomfields.com
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
class NLPosts_ACF {
    /**
     * Thumbnail
     *
     * Pull and format thumbnails from ACF data.
     * @param array $parameters Function parameters
     * @return array $thumbnails list of Thumbnails embedded in HTML tags or false
     */
    public function thumbnail( $parameters ) {
        // Get blogs & posts IDs
        $blog_ids   = $parameters['blog_ids'];
        $post_ids   = $parameters['post_ids'];
        // Field name
        $field      = $parameters['thumbnail_field'];
        /**
         * ACF Sizes
         *  - thumbnail
         *  - medium
         *  - large
         *  - post-thumbnail
         *  - large-feature
         *  - small-feature
         */
        $size       = $parameters['thumbnail_size'];
        // Placeholder service
        $service    = $parameters['thumbnail_service'];
        // Placeholder parameters
        $placeholder_parameters   = $parameters['thumbnail_parameters'];
        if( function_exists( 'get_field' ) ) {
            // Loop through blogs
            for( $counter = 0; $counter < count( $blog_ids ); $counter++ ) {
                // Blog ID
                $blog_id = $blog_ids[$counter];
                // Switch to blog
                switch_to_blog( $blog_ids[$counter] );
                    // Loop through posts
                    for( $incounter = 0; $incounter < count( @$post_ids[$blog_id] ); $incounter++ ) {
                        // Get thumbnail by Post ID
                        $thumbnails[$blog_id][$post_ids[$blog_id][$incounter]] = @get_field( 
                            $field,
                            $post_ids[$blog_id][$incounter]
                        );
                        // Image found
                        if( $thumbnails[$blog_id][$post_ids[$blog_id][$incounter]] ) {
                            // Set parameters
                            $image_parameters = array(
                                'alt'   => @$thumbnails[$blog_id][$post_ids[$blog_id][$incounter]]['alt'],
                                'title' => @$thumbnails[$blog_id][$post_ids[$blog_id][$incounter]]['title'],
                                'src'   => @$thumbnails[$blog_id][$post_ids[$blog_id][$incounter]]['sizes'][$size],
                                'id'    => @$thumbnails[$blog_id][$post_ids[$blog_id][$incounter]]['id'],
                            );
                            // HTML object
                            $html_tag = new NLPosts_HTML();
                            // Get image tag
                            $thumbnails[$blog_id][$post_ids[$blog_id][$incounter]] = $html_tag->image_tag( $image_parameters );
                        }
                        // Placeholders
                        if( $service != 'none' ) {
                            // No thumbnail found
                            if( empty( $thumbnails[$blog_id][$post_ids[$blog_id][$incounter]] ) ) {
                                // Placeholder object
                                $placeholder = new NLPosts_Placeholders();
                                // Get a placeholder instead
                                $thumbnails[$blog_id][$post_ids[$blog_id][$incounter]] = 
                                    $placeholder->placeholder( 
                                        $service,
                                        $placeholder_parameters
                                    );
                            }
                        }
                    }
                 // Restore current blog
                restore_current_blog();
            }
            // Return thumbnails
            return $thumbnails;
        } else
            return false;
    }
    /**
     * Get Fields
     *
     * Pull custom fields added using ACF from database.
     * @param array $parameters ACF get_field parameters, plus NLP parameters
     * @return array $data ACF field data
     *
     * get_field
     * @link http://www.advancedcustomfields.com/resources/functions/get_field/
     * Parameters:
     *
     *  - field_name: the name of the field to be retrieved. eg “page_content” (required)
     *  - post_id: Specific post ID where your value was entered. Defaults to current post ID (not required). 
     *              This can also be options / taxonomies / users / etc
     *  - format_value: whether or not to format the value loaded from the db. Defaults to false (not required)
     *
     * Network Latest Posts parameters, as these is a plugin intended to pull data from multiple blogs
     * then Blog IDs and Post IDs are required in order to pull data from correct sources.
     *  - blog_ids: array containing blog IDs to pull data from
     *  - post_ids: array containing post IDs to pull data from
     */
    public function get_field( $parameters ) {
        // Get parameters
        $blog_ids       = $parameters['blog_ids'];
        $post_ids       = $parameters['post_ids'];
        $field_name     = $parameters['field_name'];
        $format_value   = $parameters['format_value'];
        if( function_exists( 'get_field' ) ) {
            // Loop through blogs
            for( $counter = 0; $counter < count( $blog_ids ); $counter++ ) {
                // Blog ID
                $blog_id = $blog_ids[$counter];
                // Switch to blog
                switch_to_blog( $blog_ids[$counter] );
                    // Loop through posts
                    for( $incounter = 0; $incounter < count( $post_ids[$blog_id] ); $incounter++ ) {
                        // Get data
                        $data[$blog_id][$post_ids[$blog_id][$incounter]] = @get_field(
                            $field_name,
                            $post_ids[$blog_id][$incounter],
                            $format_value
                        );
                    }
                // Restore current blog
                restore_current_blog();
            }
            if( !empty( $data ) )
                // Return data
                return $data;
            else
                // No data
                return false;
        } else
            // ACF is not active
            return false;
    }
}
?>