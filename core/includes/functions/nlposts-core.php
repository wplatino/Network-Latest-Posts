<?php
/**
 * Network Latest Posts
 *
 * @package Network Latest Posts
 * @author José SAYAGO <jose.sayago@laelite.info>
 * @internal nlposts-core.php
 *
 * Core
 *      Main application functionality.
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
class NLPosts_Core {
    /**
     * Constructor
     *
     * Default parameters can be overriden using
     * WordPress pre-filter functions.
     *
     * To override default options use the
     * nlposts_custom_default_parameters filter.
     *
     * Example:
     * 1.- Create a custom function:
     *      function my_custom_parameters() {
     *          $default = array(
     *              'cache_results' => 'yes',
     *              'cache_time'    => 12*12*60,
     *          );
     *          return $default;
     *      }
     * 2.- Pre-filter function:
     *      add_filter( 'nlposts_custom_default_parameters', 'my_custom_parameters' );
     *
     * @return array $default Default parameters
     */
    public function NLPosts_Core() {
        $strings = new NLPosts_Phrases();
        $default = apply_filters( 'nlposts_custom_default_parameters', array(
            /**
             * Global UI Settings
             */
            'instance_headline'     => '',
            'instance_id'           => 'nlp-'.rand(),
            'alert_msg'             => $strings->nlposts_alert_phrase()->alert_msg,
            'cache_results'         => 'no',
            'cache_time'            => 43200,
            'query_relationship'    => 'and',
            /**
             * Blog Settings
             */
            'blog_include'      => 'all',
            'blog_exclude'      => 'none',
            'blog_language'     => 'all',
            'blog_visibility'   => 'public',
            /**
             * Author Settings
             */
            'author_include'    => 'all',
            'author_exclude'    => 'none',
            /**
             * Display Settings
             */
            'display_title'     => 'yes',
            'display_excerpt'   => 'no',
            'display_date'      => 'no',
            'display_author'    => 'no',
            'display_blog'      => 'no',
            'display_category'  => 'no',
            'display_tag'       => 'no',
            'display_comment'   => 'no',
            'display_thumbnail' => 'no',
            'display_content'   => 'no',
            /**
             * Author Settings
             */
            'author_image'          => 'no',
            'author_image_size'     => '96',
            'author_image_default'  => '',
            /**
             * Link Settings
             */
            'link_title'        => 'yes',
            'link_excerpt'      => 'no',
            'link_date'         => 'no',
            'link_author'       => 'no',
            'link_blog'         => 'no',
            'link_category'     => 'no',
            'link_tag'          => 'no',
            'link_comment'      => 'no',
            'link_thumbnail'    => 'no',
            'link_target'       => '_self',
            /**
             * Posts' Settings
             */
            'post_language'                 => 'all',
            'post_qty'                      => 10,
            'post_time_frame'               => 0,
            'post_keep_sticky'              => 'yes',
            'post_status'                   => 'publish',
            'post_type'                     => 'post',
            'post_include'                  => 'all',
            'post_exclude'                  => 'none',
            'post_include_from'             => 'all',
            'post_exclude_from'             => 'all',
            'post_category_taxonomy'        => 'category',
            'post_tag_taxonomy'             => 'post_tag',
            'post_category_include'         => 'all',
            'post_category_exclude'         => 'none',
            'post_category_include_from'    => 'all',
            'post_category_exclude_from'    => 'all',
            'post_tag_include'              => 'all',
            'post_tag_include_from'         => 'all',
            'post_tag_exclude'              => 'none',
            'post_tag_exclude_from'         => 'all',
            'post_featured'                 => 'no',
            /**
             * Sorting Settings
             */
            'sort_random'       => 'no',
            'sort_posts_by'     => 'date',
            'sort_blogs_by'     => 'registered',
            'sort_order'        => 'desc',
            'sort_limit'        => 0,
            'sort_ignore_blog'  => 'no',
            /**
             * Thumbnails Settings
             */
            'thumbnail_type'        => 'wordpress',
            'thumbnail_size'        => '150x150',
            'thumbnail_css_class'   => '',
            'thumbnail_service'     => 'none',
            'thumbnail_parameters'  => '',
            'thumbnail_field'       => '',
            /**
             * Excerpt Settings
             */
            'excerpt_length'        => 55,
            'excerpt_from_content'  => 'no',
            'excerpt_link'          => '',
            'excerpt_shortcodes'    => 'yes',
            'excerpt_keep_tags'     => 'no',
            'excerpt_linebreaks'    => 'no',
            'excerpt_trunc_el'      => 'ellipsis',
            /**
             * Pagination Settings
             */
            'paginate_content'      => 'no',
            'paginate_mode'         => 'classic',
            'paginate_number'       => 4,
            'paginate_limit'        => '',
            /**
             * WooCommerce
             */
            'woo_products'          => 'no',
            'woo_meta_key'          => '',
        ) );
        $this->default =& $default;
        return $this->default;
    }
    /**
     * Network Latest Posts
     *
     * Gets posts from all blogs in a network, using
     * user parameters (available in constructor).
     *
     * @param array $parameters User parameters
     * @return array $posts Posts data
     */
    protected function nlposts( $parameters ) {
        /**
         * Settings
         */
        $settings               = json_decode( json_encode( $parameters ) );
        $post_language          = $settings->post_language;
        $post_qty               = $settings->post_qty;
        $post_type              = $settings->post_type;
        $post_exclude           = $settings->post_exclude;
        $post_exclude_from      = $settings->post_exclude_from;
        $post_include           = $settings->post_include;
        $post_include_from      = $settings->post_include_from;
        $category_taxonomy      = $settings->post_category_taxonomy;
        $category_exclude       = $settings->post_category_exclude;
        $category_exclude_from  = $settings->post_category_exclude_from;
        $category_include       = $settings->post_category_include;
        $category_include_from  = $settings->post_category_include_from;
        $tag_taxonomy           = $settings->post_tag_taxonomy;
        $tag_exclude            = $settings->post_tag_exclude;
        $tag_exclude_from       = $settings->post_tag_exclude_from;
        $tag_include            = $settings->post_tag_include;
        $tag_include_from       = $settings->post_tag_include_from;
        // Random sorting
        if( $settings->sort_random == 'yes' )
            $orderby            = 'rand';
        else
            $orderby            = $settings->sort_posts_by;
        // Keep results in Cache
        if( $settings->cache_results == 'yes' ) {
            // Get results using WordPress Transients
            if( !empty ( $posts_transient = get_transient( NLP_TRANSIENT.$settings->instance_id ) ) )
                return $posts_transient;
        }
        /**
         * Get Blogs
         */
        $blog_info = $this->nlposts_get_blogs( $parameters );
        /**
         * Strings to Array
         */
        // Posts to exclude
        if( !preg_match( "/,/", $post_exclude ) )
            if( $post_exclude != 'all' )
                $post_exclude = array( $post_exclude );
            else
                $post_exclude = array();
        else
            $post_exclude = explode( ",", $post_exclude );
        // Posts to include
        if( !preg_match( "/,/", $post_exclude_from ) )
            if( $post_exclude_from != 'all' )
                $post_exclude_from = array( $post_exclude_from );
            else
                $post_exclude_from = array();
        else
            $post_exclude_from = explode( ",", $post_exclude_from );
        // Posts to include
        if( !preg_match( "/,/", $post_include ) )
            if( $post_include != 'all' )
                $post_include = array( $post_include );
            else
                $post_include = array();
        else
            $post_include = explode( ",", $post_include );
        // Posts to include
        if( !preg_match( "/,/", $post_include_from ) )
            if( $post_include_from != 'all' )
                $post_include_from = array( $post_include_from );
            else
                $post_include_from = array();
        else
            $post_include_from = explode( ",", $post_include_from );
        /**
         * Posts' Options
         */
        $posts_options = array(
            'numberposts'   => $post_qty,
            'orderby'       => $orderby,
            'order'         => strtoupper( $settings->sort_order )
        );
        $posts_options_exclude = array(
            'exclude'       => $post_exclude,
        );
        $posts_options_include = array(
            'include'       => $post_include,
        );
        /**
         * Exclude Category From
         */
        // Categories to Array
        if( !preg_match( "/,/", $category_exclude_from ) )
            if( $category_exclude_from != 'all' )
                $category_exclude_from = array( $category_exclude_from );
            else
                $category_exclude_from = array();
        else
            $category_exclude_from = explode( ",", $category_exclude_from );
        /**
         * Include Category From
         */
        // Categories to array
        if( !preg_match( "/,/", $category_include_from ) )
            if( $category_include_from != 'all' )
                $category_include_from = array( $category_include_from );
            else
                $category_include_from = array();
        else
            $category_include_from = explode( ",", $category_include_from );
        /**
         * Exclude Tag From
         */
        // Tags to Array
        if( !preg_match( "/,/", $tag_exclude_from ) )
            if( $tag_exclude_from != 'all' )
                $tag_exclude_from = array( $tag_exclude_from );
            else
                $tag_exclude_from = array();
        else
            $tag_exclude_from = explode( ",", $tag_exclude_from );
        /**
         * Include Tag From
         */
        // Tags to array
        if( !preg_match( "/,/", $tag_include_from ) )
            if( $tag_include_from != 'all' )
                $tag_include_from = array( $tag_include_from );
            else
                $tag_include_from = array();
        else
            $tag_include_from = explode( ",", $tag_include_from );
        /**
         * Post Types
         */
        $types = array();
        if( !empty( $post_type ) ) {
            if( !preg_match( "/,/", $post_type ) ) {
                if( $post_type != 'post' )
                    $types[] = htmlspecialchars( $post_type );
            } else {
                $post_type = explode( ",", $post_type );
                foreach ( $post_type as $type ) {
                    $types[] = htmlspecialchars( $type );
                }
            }
        }
        $posts_options['post_type'] = $types;
        /**
         * Post Languages
         */
        if( !empty( $post_language ) ) {
            if( $post_language != 'all' ) {
                if( !preg_match( "/,/", $post_language ) )
                    $post_languages[] = htmlspecialchars( $post_language );
                else {
                    $post_language = explode( ",", $post_language );
                    foreach( $post_language as $post_lang ) {
                        $post_languages[] = htmlspecialchars( $post_lang );
                    }
                }
            } else
                // All languages
                $post_languages = $post_language;
        }
        $posts_options['post_language'] = $post_languages;
        /**
         * Categories to Include or Exclude
         */
        // Include
        if( preg_match( '/,/', $category_include ) )
            $category_include = explode( ',', $category_include );
        else {
            if( $category_include != 'all' )
                $category_include = array( $category_include );
            else
                $category_include = array();
        }
        // Exclude
        if( preg_match( '/,/', $category_exclude ) )
            $category_exclude = explode( ',', $category_exclude );
        else {
            if( $category_exclude != 'none' )
                $category_exclude = array( $category_exclude );
            else
                $category_exclude = array();
        }
        /**
         * Tags to Include or Exclude
         */
        // Include
        if( preg_match( '/,/', $tag_include ) )
            $tag_include = explode( ',', $tag_include );
        else {
            if( $tag_include != 'all' )
                $tag_include = array( $tag_include );
            else
                $tag_include = array();
        }
        // Exclude
        if( preg_match( '/,/', $tag_exclude ) )
            $tag_exclude = explode( ',', $tag_exclude );
        else {
            if( $tag_exclude != 'none' )
                $tag_exclude = array( $tag_exclude );
            else
                $tag_exclude = array();
        }
        /**
         * Taxonomy Query
         */
        // Categories
        $cat_tax = explode( ',', $category_taxonomy );
        if( !preg_match( '/,/', $category_taxonomy ) ) {
            $posts_options['tax_query'] = array(
                'relation'      => $settings->query_relationship,
            );
            if( !empty( $category_exclude ) ) {
                array_push( 
                    $posts_options['tax_query'],
                    array(
                        'taxonomy'  => $category_taxonomy,
                        'field'     => 'slug',
                        'terms'     => $category_exclude,
                        'operator'  => 'NOT IN'
                    )
                );
            }
            if( !empty( $category_include ) ) {
                array_push(
                    $posts_options['tax_query'],
                    array(
                        'taxonomy'  => $category_taxonomy,
                        'field'     => 'slug',
                        'terms'     => $category_include,
                        'operator'  => 'IN'
                    )
                );
            }
        } else {
            $posts_options['tax_query'] = array(
                'relation'      => $settings->query_relationship,
            );
            if( !empty( $category_exclude ) ) {
                foreach( $cat_tax as $taxonomy ) {
                    array_push(
                        $posts_options['tax_query'],
                        array(
                            'taxonomy'  => $taxonomy,
                            'field'     => 'slug',
                            'terms'     => $category_exclude,
                            'operator'  => 'NOT IN'
                        )
                    );
                }
            }
            if( !empty( $category_include ) ) {
                foreach( $cat_tax as $taxonomy ) {
                    array_push(
                        $posts_options['tax_query'],
                        array(
                            'taxonomy'  => $taxonomy,
                            'field'     => 'slug',
                            'terms'     => $category_include,
                            'operator'  => 'IN'
                        )
                    );
                }
            }
        }
        // Tags
        $tag_tax = explode( ',', $tag_taxonomy );
        if( !preg_match( '/,/', $tag_taxonomy ) ) {
            $posts_options['tax_query'] = array(
                'relation'      => $settings->query_relationship,
            );
            if( !empty( $tag_exclude ) ) {
                array_push( 
                    $posts_options['tax_query'],
                    array(
                        'taxonomy'  => $tag_taxonomy,
                        'field'     => 'slug',
                        'terms'     => $tag_exclude,
                        'operator'  => 'NOT IN'
                    )
                );
            }
            if( !empty( $tag_include ) ) {
                array_push(
                    $posts_options['tax_query'],
                    array(
                        'taxonomy'  => $tag_taxonomy,
                        'field'     => 'slug',
                        'terms'     => $tag_include,
                        'operator'  => 'IN'
                    )
                );
            }
        } else {
            $posts_options['tax_query'] = array(
                'relation'      => $settings->query_relationship,
            );
            if( !empty( $tag_exclude ) ) {
                foreach( $tag_tax as $taxonomy ) {
                    array_push(
                        $posts_options['tax_query'],
                        array(
                            'taxonomy'  => $taxonomy,
                            'field'     => 'slug',
                            'terms'     => $tag_exclude,
                            'operator'  => 'NOT IN'
                        )
                    );
                }
            }
            if( !empty( $tag_include ) ) {
                foreach( $tag_tax as $taxonomy ) {
                    array_push(
                        $posts_options['tax_query'],
                        array(
                            'taxonomy'  => $taxonomy,
                            'field'     => 'slug',
                            'terms'     => $tag_include,
                            'operator'  => 'IN'
                        )
                    );
                }
            }
        }
        /**
         * Get Posts
         */
        for( $counter = 0; $counter < count( $blog_info ); $counter++ ) {
            // Blog ID
            $blog_id = $blog_info[$counter]['id'];
            $blog_ids[] = $blog_id;
            // Blog Data
            $blog_data[$blog_id] = array(
                'blog_id'            => $blog_info[$counter]['id'],
                'blog_name'          => $blog_info[$counter]['name'],
                'blog_url'           => $blog_info[$counter]['url'],
                'blog_language'      => $blog_info[$counter]['language'],
                'blog_date_format'   => $blog_info[$counter]['date_format'],
                'blog_registered'    => $blog_info[$counter]['registered'],
                'blog_last_updated'  => $blog_info[$counter]['last_updated'],
            );
            // Array ID Sorting
            if( $settings->sort_blogs_by == 'registered' )
                $id = strtotime( $blog_data[$blog_id]['blog_registered'] ).$blog_id;
            else
                $id = strtotime( $blog_data[$blog_id]['blog_last_updated'] ).$blog_id;
            $id = str_pad($id, 15, '0', STR_PAD_LEFT);
            // Set Inclusion or Exclusion filters
            if( !in_array( 'none', $post_exclude )  ||
                !in_array( 'all', $post_include )   ||
                $category_include != 'all'          || 
                $category_exclude != 'none'         || 
                $tag_include != 'all'               || 
                $tag_exclude != 'none' 
            ) {

                if( in_array( $blog_id, $post_exclude_from )        ||
                    in_array( $blog_id, $post_include_from )        ||
                    in_array( $blog_id, $category_exclude_from )    ||
                    in_array( $blog_id, $category_include_from )    ||
                    in_array( $blog_id, $tag_exclude_from )         ||
                    in_array( $blog_id, $tag_include_from )
                ) {
                    // Posts to exclude
                    $posts_options = array_merge( $posts_options, $posts_options_exclude );
                    // Posts to include
                    if( in_array( $blog_id, $post_include_from ) )
                        $posts_options = array_merge( $posts_options, $posts_options_include );
                    // Switch to blog
                    switch_to_blog( $blog_id );
                        // Get posts
                        $posts[$id] = $this->nlposts_get_posts( 
                            $posts_options,
                            $parameters 
                        );
                    // Restore current blog
                    restore_current_blog();
                } else {
                    // Unset inclusion and exclusion filters
                    unset( 
                        $posts_options['exclude'],
                        $posts_options['include'],
                        $posts_options['tax_query']
                    );
                    // Switch to blog
                    switch_to_blog( $blog_id );
                        // Get posts
                        $posts[$id] = $this->nlposts_get_posts( 
                            $posts_options, 
                            $parameters 
                        );
                    // Restore current blog
                    restore_current_blog();
                }
            } else {
                // Unset inclusion and exclusion filters
                unset(
                    $posts_options['tax_query']
                );
                // Switch to blog
                switch_to_blog( $blog_id );
                    // Get posts
                    $posts[$id] = $this->nlposts_get_posts( 
                        $posts_options, 
                        $parameters 
                );
                // Restore current blog
                restore_current_blog();
            }
            // Merge blog data with posts
            $posts[$id] = array_merge( $blog_data[$blog_id], $posts[$id] );
        }
        // Loop through posts
        foreach( $posts as $post ) {
            // Ignore blog info
            for( $count = 0; $count < ( count( $post ) - 7 ); $count++ ) {
                // Get excerpt
                if( $settings->excerpt_from_content == 'no' )
                    // By excerpt
                    $excerpt_content = $post[$count]->post_excerpt;
                else
                    // By content
                    $excerpt_content = $post[$count]->post_content;
                // Excerpt parameters
                $excerpt_params = array(
                    'content'       => $excerpt_content,
                    'shortcodes'    => $settings->excerpt_shortcodes,
                    'keeptags'      => $settings->excerpt_keep_tags,
                    'linebreaks'    => $settings->excerpt_linebreaks,
                    'trunc_el'      => $settings->excerpt_trunc_el,
                    'limit'         => $settings->excerpt_length,
                    'link'          => $settings->excerpt_link
                );
                // Format excerpts
                $excerpt = $this->nlposts_excerpt( $excerpt_params );
                // Push excerpt data to each post object
                $post[$count]->excerpt          = $excerpt->content;
                $post[$count]->excerpt_trunc_el = $excerpt->trunc_el;
                $post[$count]->excerpt_link     = $excerpt->link;
                // Permalinks
                $post[$count]->permalink    = get_blog_permalink( $post['blog_id'], $post[$count]->ID );
                // Display Author
                if( $settings->display_author == 'yes' ) {
                    $author_settings = apply_filters( 'nlposts_custom_author_data', array(
                        'user_login'            => 'no',
                        'user_pass'             => 'no',
                        'user_nicename'         => 'yes',
                        'user_email'            => 'yes',
                        'user_url'              => 'no',
                        'user_registered'       => 'no',
                        'user_activation_key'   => 'no',
                        'user_status'           => 'no',
                        'display_name'          => 'yes',
                        'nickname'              => 'yes',
                        'first_name'            => 'no',
                        'last_name'             => 'no',
                        'description'           => 'no',
                        'jabber'                => 'no',
                        'aim'                   => 'no',
                        'yim'                   => 'no',
                        'user_level'            => 'no',
                        'user_firstname'        => 'no',
                        'user_lastname'         => 'no',
                        'rich_editing'          => 'no',
                        'comment_shortcuts'     => 'no',
                        'admin_color'           => 'no',
                        'plugins_per_page'      => 'no',
                        'plugins_last_view'     => 'no',
                        'ID'                    => $post[$count]->post_author,
                        'display_avatar'        => $settings->author_image,
                        'avatar_size'           => $settings->author_image_size,
                        'avatar_default'        => $settings->author_image_default,
                        'blog_id'               => $post['blog_id'],
                    ) );
                    // Author Data
                    $post[$count]->author = $this->nlposts_author_data( $author_settings );
                }
                // Switch to Blog
                switch_to_blog( $post['blog_id'] );
                    // Sticky?
                    if( $settings->post_keep_sticky == 'yes' ) {
                        if( is_sticky( $post[$count]->ID ) ) {
                            $post[$count]->sticky = 'yes';
                        } else {
                            $post[$count]->sticky = 'no';
                        }
                    }
                    // Post Language
                    // WPML Compatibility
                    if( function_exists( 'wpml_get_language_information' ) ) {
                        $post_lang = wpml_get_language_information( $post[$count]->ID );
                        $post[$count]->language = $post_lang['locale'];
                    }
                // Back to current blog
                restore_current_blog();
                // Default language
                if( empty( $post[$count]->language ) )
                    $post[$count]->language = 'en_US';
                // Sort posts by date
                if( $settings->sort_posts_by == 'date' )
                    $key = strtotime( $post[$count]->post_date );
                // Sort posts by last update
                if( $settings->sort_posts_by == 'modified' )
                    $key = strtotime( $post[$count]->post_modified );
                // List all posts regardless of blog
                $posts_without_blog[$key] = $post[$count];
                // Shuffle to randomize posts
                if( $settings->sort_random == 'yes' )
                    shuffle( $posts_without_blog );
                if( !empty( $post[$count]->ID ) ) {
                    // Store post IDs for thumbnails' usage
                    $post_ids[ $post['blog_id'] ][] = $post[$count]->ID;
                    // Store keys for thumbnails' usage
                    $keys_ids[ $post['blog_id'].'-'.$post[$count]->ID ] = $key;
                }
            }
            // List posts by blog
            $posts_by_blog[] = $post;
            // Shuffle to randomize posts
            if( $settings->sort_random == 'yes' )
                shuffle( $posts_by_blog );
        }
        // Display thumbnails
        if( $settings->display_thumbnail == 'yes' ) {
            // Thumbnail parameters
            $thumbnail_options = array(
                'blog_id'               => $blog_ids,
                'post_id'               => $post_ids,
                'thumbnail_type'        => $settings->thumbnail_type,
                'thumbnail_css_class'   => $settings->thumbnail_css_class,
                'thumbnail_size'        => $settings->thumbnail_size,
                'thumbnail_service'     => $settings->thumbnail_service,
                'thumbnail_parameters'  => $settings->thumbnail_parameters,
                'thumbnail_field'       => $settings->thumbnail_field,
            );
            // Get thumbnails
            $thumbnails = $this->nlposts_get_thumbnails( $thumbnail_options );
        }
        // List posts regardless of blog they were posted on
        if(  $settings->sort_ignore_blog == 'yes' ) {
            // Order blogs
            if( $settings->sort_order == 'desc' )
                krsort( $posts_without_blog );
            else
                ksort( $posts_without_blog );
            // Display thumbnails
            if( $settings->display_thumbnail == 'yes' ) {
                // Push thumbnails to posts
                foreach( $thumbnails as $key_blog => $key_post ) {
                    foreach( $key_post as $key_id => $key_image ) {
                        // Push each thumbnail to their corresponding post
                        $posts_without_blog[ $keys_ids[ $key_blog.'-'.$key_id ] ]->thumbnail = $key_image;
                    }
                }
            }
            // Keep results in Cache
            if( $settings->cache_results == 'yes' ) {
                // Cache results using WordPress Transients
                if( false === ( $posts_transient = get_transient( NLP_TRANSIENT.$settings->instance_id ) ) )
                    // Cache data
                    set_transient( NLP_TRANSIENT.$settings->instance_id, $posts_without_blog, $settings->cache_time );
                else
                    return $posts_transient;
            }
            // Return post data
            return $posts_without_blog;
        } else {
            // Order blogs
            if( $settings->sort_order == 'desc' )
                krsort( $posts_by_blog );
            else
                ksort( $posts_by_blog );
            // Display thumbnails
            if( $settings->display_thumbnail == 'yes' ) {
                // Push thumbnails to posts listed by blog
                foreach( $posts_by_blog as $posts_thumb ) {
                    for( $count = 0; $count < ( count( $posts_thumb ) - 7 ); $count++ ) {
                        // Push each thumbnail to their corresponding post
                        $posts_thumb[$count]->thumbnail = $thumbnails[$posts_thumb['blog_id']][$posts_thumb[$count]->ID];
                    }
                }
            }
            // Keep results in Cache
            if( $settings->cache_results == 'yes' ) {
                // Cache results using WordPress Transients
                if( false === ( $posts_transient = get_transient( NLP_TRANSIENT.$settings->instance_id ) ) )
                    // Cache data
                    set_transient( NLP_TRANSIENT.$settings->instance_id, $posts_by_blog, $settings->cache_time );
                else
                    return $posts_transient;
            }
            // Return post data
            return $posts_by_blog;
        }
    }
    /**
     * Excerpts
     *
     * Format data using passed arguments to build short extracts of content.
     * @param array $parameters Arguments to format excerpts
     * @return string $excerpt Excerpt formated using user arguments
     *
     * Example of Usage:
     *
     * $parameters = array(
     *      'content'       => 'Post content or excerpt',
     *      'shortcodes'    => 'yes',                   // Yes: Execute shortcodes. No: Strip them.
     *      'keeptags'      => 'no',                    // Yes: Keep HTML tags. No: Strip them.
     *      'linebreaks'    => 'no',                    // Yes: Convert new lines to line-breaks. No: Remove new lines.
     *      'trunc_el'      => 'ellipsis',              // Truncation element, ellipsis by default.
     *      'limit'         => 55,                      // Excerpt lenght in number of words.
     *      'link'          => 'Read more',             // Link title to read the full entry, set to none to omit links.
     * );
     * $excerpt = $obj->nlposts_excerpt( $parameters );
     */
    protected function nlposts_excerpt( $parameters ) {
        // Strings object
        $phrase = new NLPosts_Phrases();
        // Array to object
        $excerpt = json_decode( json_encode( $parameters ) );
        // Check if Shortcodes must be interpreted
        if( $excerpt->shortcodes === 'yes' )
            // Do shortcode
            $excerpt->content = do_shortcode( $excerpt->content );
        else
            // Strip shortcodes
            $excerpt->content = preg_replace( '/\[(.*?)\]/i', '', $excerpt->content );
        // Check if tags should be kept
        if( $excerpt->keeptags === 'no' )
            // Strip tags
            $excerpt->content = strip_tags( $excerpt->content );
        // Remove line-breaks
        if( $excerpt->linebreaks === 'no' )
            // Strip line-breaks
            $excerpt->content = str_replace( '<br />', ' ', nl2br( $excerpt->content ) );
        else
            // Convert new lines to line-breaks
            $excerpt->content = nl2br( $excerpt->content );
        // Truncation element
        if( empty( $excerpt->trunc_el ) || $excerpt->trunc_el == 'ellipsis' )
            // Default element
            $excerpt->trunc_el = $phrase->nlposts_excerpt_phrase()->ellipsis;
        // Get words
        $words = explode( ' ', $excerpt->content, $excerpt->limit + 1 );
        // Check if content exceeds the number of words specified
        if( count( $words ) > $excerpt->limit )
            // Pop off the rest
            array_pop( $words );
        // Add whitespaces
        $excerpt->content = implode( ' ', $words );
        // Remove whitespaces from the beginning and end
        $excerpt->content = trim( $excerpt->content );
        // Custom link text
        if( empty( $excerpt->link ) )
            // Default link text
            $excerpt->link = $phrase->nlposts_excerpt_phrase()->more_link;
        // No link
        elseif( $excerpt->link == 'none' )
            $excerpt->link = '';
        // Excerpt array
        $excerpt_obj = array(
            'content'   => $excerpt->content,
            'trunc_el'  => $excerpt->trunc_el,
            'link'      => $excerpt->link,
        );
        // Array to object
        $excerpt_obj = json_decode( json_encode( $excerpt_obj ) );
        // Return excerpt object
        return $excerpt_obj;
    }
    /**
     * Shortcodes
     *
     * Pull posts with shortcode parameters
     * @param array $parameters Custom parameters
     * @return string $shortcode HTML output
     */
    protected function nlposts_shortcode( $parameters ) {
        $posts = $this->nlposts( $parameters );
        $themes = new NLPosts_Themes( $posts, $parameters );
        return $themes->nlposts_theme_load();
    }
    /**
     * Get Network Blogs
     *
     * Pull network blogs information.
     * @param array $parameters Custom parameters
     * @return array $blog_list List of blogs with data
     */
    public function nlposts_get_blogs( $parameters = null ) {
        // WordPress Global Database Object
        global $wpdb;
        // Merge parameters ( custom, defaults )
        $query_args = wp_parse_args( $parameters, $this->default );
        /**
         * Include Blogs
         * To include multiple blogs, Blog IDs must be comma separated.
         *
         * <code>
         *    [nlposts blog_include=1]
         *    [nlposts blog_include=1,2,3]
         * </code>
         */
        if( !preg_match( "/,/", $query_args['blog_include'] ) ) {
            // Sanitize
            $blog_include = (int)htmlspecialchars( $query_args['blog_include'] );
            // Numbers only
            if( is_numeric( $blog_include ) )
                if( $blog_include > 0 )
                    // SQL
                    $blog_include_sql = " AND blog_id = $blog_include ";
        } else {
            // String to Array
            $blog_include = explode( ",", $query_args['blog_include'] );
            // SQL
            for( $counter = 0; $counter < count( $blog_include ); $counter++ ) {
                // SQL ( AND for the first one )
                if( $counter == 0 )
                    $blog_include_sql .= " AND blog_id = " . (int)$blog_include[ $counter ];
                // SQL ( OR for the rest )
                else
                    $blog_include_sql .= " OR blog_id = " . (int)$blog_include[ $counter ];
            }
        }
        /**
         * Exclude Blogs
         * To exlude multiple blogs, Blog IDs must be comma separated.
         *
         * <code>
         *    [nlposts blog_exclude=1]
         *    [nlposts blog_exclude=1,2,3]
         * </code>
         */
        if( !preg_match( "/,/", $query_args['blog_exclude'] ) ) {
            // Sanitize
            $blog_exclude = (int)htmlspecialchars( $query_args['blog_exclude'] );
            // Numbers only
            if( is_numeric( $blog_exclude ) )
                if( $blog_exclude > 0 )
                    // SQL
                    $blog_exclude_sql = " AND blog_id != $blog_exclude ";
        } else {
            // String to Array
            $blog_exclude = explode( ",", trim( $query_args['blog_exclude'] ) );
            // and repeat the sql for each ID found
            for( $counter = 0; $counter < count( $blog_exclude ); $counter++ ) {
                $blog_exclude_sql .= " AND blog_id != " . (int)$blog_exclude[ $counter ];
            }
        }
        /**
         * Blog Visibility
         *
         * WordPress Network handles different blog visibility options.
         * Multiple visibility options must be comma separated.
         *
         * There are five (5) attributes:
         *    - public
         *    - archived
         *    - mature
         *    - spam
         *    - deleted
         *
         * Invisible blogs are those not matching any of the five attributes listed above,
         * that's why there is a special SQL query for them.
         *
         * <code>
         *    [nlposts blog_visibility=public]
         *    [nlposts blog_visibility=public,invisible,mature]
         * </code>
         */
        $blog_include_sql = '';
        $blog_exclude_sql = '';
        if( !preg_match( "/,/", $query_args['blog_visibility'] ) ) {
            // Sanitize
            $blog_visibility = htmlspecialchars( $query_args['blog_visibility'] );
            // Invisible blogs are special
            if( $blog_visibility != 'invisible' )
                $blog_visibility_sql = " $blog_visibility = '1' ";
            else
                $blog_visibility_sql = " public = '0' AND archived = '0' AND mature = '0' AND spam = '0' AND deleted = '0' ";
        } else {
            // String to Array
            $blog_visibility = explode( ",", $query_args['blog_visibility'] );
            // Walk array
            for( $counter = 0; $counter < count( $blog_visibility ); $counter++ ) {
                // Build SQL
                if( $counter == 0 ) {
                    // Invisible blogs are special
                    if( trim( $blog_visibility[ $counter ] ) != 'invisible' )
                        $blog_visibility_sql .= trim( $blog_visibility[ $counter ] ) . " = '1' ";
                    else
                        $blog_visibility_sql .= " ( public = '0' AND archived = '0' AND mature = '0' AND spam = '0' AND deleted = '0' ) ";
                } else {
                    if( trim( $blog_visibility[ $counter ] ) != 'invisible' )
                        $blog_visibility_sql .= " OR " . trim( $blog_visibility[ $counter ] ) . " = '1' ";
                    else
                        $blog_visibility_sql .= " OR ( public = '0' AND archived = '0' AND mature = '0' AND spam = '0' AND deleted = '0'  ) ";
                }
            }
        }
        /**
         * Blog Languages
         * Languages must be passed as codes, f.e: 
         *   - English: en_US or en_GB
         *   - Spanish: es_ES or es_VE
         *   - French: fr_FR
         * multiple values must be comma separated.
         */
        if( $query_args['blog_language'] != 'all' ) {
            if( !preg_match( "/,/", $query_args['blog_language'] ) )
                $blog_language[] = htmlspecialchars( $query_args['blog_language'] );
            else {
                $blog_language = explode( ",", $query_args['blog_language'] );
                for( $counter = 0; $counter < count( $blog_language ); $counter++ ) {
                    $blog_language[$counter] = trim( $blog_language[$counter] );
                }
            }
        } else
            $blog_language = null;
        // SQL Query
        $query_data = "SELECT blog_id, registered, last_updated FROM $wpdb->blogs WHERE " . $blog_visibility_sql . $blog_include_sql . $blog_exclude_sql;
        // Get Blog Info
        $blog_info = $wpdb->get_results( $wpdb->prepare( $query_data, '%s' ) );
        // Put blog info into an array
        if( $blog_info ) {
            foreach( $blog_info as $blog_data ) {
                // Get Blog Info
                $blogs[] = array(
                    'id'            => $blog_data->blog_id,
                    'name'          => get_blog_option( $blog_data->blog_id, 'blogname' ),
                    'url'           => get_blog_option( $blog_data->blog_id, 'siteurl' ),
                    'language'      => get_blog_option( $blog_data->blog_id, 'WPLANG' ) ? get_blog_option( $blog_data->blog_id, 'WPLANG' ) : 'en_US',
                    'date_format'   => get_blog_option( $blog_data->blog_id, 'date_format' ),
                    'registered'    => $blog_data->registered,
                    'last_updated'  => $blog_data->last_updated,
                );
            }
            // Filter by language
            if( $blog_language != null ) {
                foreach( $blogs as $blog ) {
                    // Check for matching languages
                    if( in_array( $blog['language'], $blog_language) )
                        // Keep only those matching user settings
                        $blog_list[] = $blog;
                }
            } else
                // All blogs
                $blog_list = $blogs;
            // Return list of blogs
            return $blog_list;
        } else
            // Nothing found
            return false;
    }
    /**
     * Custom Get Posts
     *
     * Pull posts from blogs using user's arguments.
     * Default options can be modified using custom filter
     * nlposts_custom_get_posts
     *
     * @uses $wpdb
     * @uses WP_Query::query() See for more default arguments and information.
     * @link http://codex.wordpress.org/Template_Tags/get_posts
     *
     * @param array $options Optional. Overrides defaults.
     * @param array $parameters Specific options for query: time_frame, query_date
     * @return array $posts_filtered | $posts List of posts.
     */
    protected function nlposts_get_posts( $posts_options = null, $parameters ) {
        $default_options = apply_filters( 'nlposts_custom_get_posts', array(
            'numberposts'           => 10, 
            'offset'                => 0,
            'category'              => array(), 
            'orderby'               => 'date',
            'category__in'          => array(),
            'category__not_in'      => array(),
            'tag__in'               => array(),
            'tag__not_in'           => array(),
            'order'                 => 'DESC', 
            'include'               => array(),
            'exclude'               => array(), 
            'meta_key'              => '',
            'meta_value'            => '', 
            'post_type'             => 'post',
            'suppress_filters'      => true,
            'ignore_sticky_posts'   => false,
            'no_found_rows'         => true,
        ) );
        // Time frame
        $time_frame = (int)$parameters['post_time_frame'];
        // Post date to choose from
        $query_date = $parameters['sort_posts_by'];
        // Merge arguments with default options
        $posts_arguments = wp_parse_args( $posts_options, $default_options );
        // Post status
        if ( empty( $posts_arguments['post_status'] ) )
          $posts_arguments['post_status'] = ( 'attachment' == $posts_arguments['post_type'] ) ? 'inherit' : 'publish';
        // Posts per page
        if ( !empty( $posts_arguments['numberposts'] ) && empty( $posts_arguments['paginate_number'] ) )
          $posts_arguments['posts_per_page'] = $posts_arguments['numberposts'];
        // Category
        if ( !empty( $posts_arguments['category'] ) )
          $posts_arguments['cat'] = $posts_arguments['category'];
        // Included posts
        if ( !empty( $posts_arguments['include'] ) ) {
          $posts_included = wp_parse_id_list( $posts_arguments['include'] );
          // Only the number of posts included
          $posts_arguments['posts_per_page'] = count( $posts_included );
          $posts_arguments['post__in'] = $posts_included;
        // Excluded posts
        } elseif ( !empty( $posts_arguments['exclude'] ) )
          $posts_arguments['post__not_in'] = wp_parse_id_list( $posts_arguments['exclude'] );
        // Time frame
        if( $time_frame > 0 ) {
            // Nasty hack to access this variable from inside callback filters
            $GLOBALS['nlposts_time_frame'] = $time_frame;
            $GLOBALS['nlposts_query_date'] = $query_date;
            // Avoid function duplication
            if( !function_exists( 'filter_where' ) ) {
                // Override where filter
                function filter_where( $where ) {
                    $days = (int)$GLOBALS['nlposts_time_frame'];
                    $query_date = $GLOBALS['nlposts_query_date'];
                    // Time frame from post date
                    if( $query_date == 'date' )
                        $where .= " AND post_date >= '".date( 'Y-m-d', strtotime( "-$days days" ) )."'";
                    // Time frame from last modification date
                    if( $query_date == 'post_modified' )
                        $where .= " AND post_modified >= '".date( 'Y-m-d', strtotime( "-$days days" ) )."'";
                    return $where;
                }
            }
            // Filter posts
            add_filter( 'posts_where', 'filter_where' );
        }
        // Query posts
        $nlposts_get_posts = new WP_Query;
        // Get them all
        $posts = $nlposts_get_posts->query( $posts_arguments );
        // Time frame?
        if( $time_frame > 0 ) {
            remove_filter( 'posts_where', 'filter_where' );
            // Unset the nasty global
            unset( $GLOBALS['nlposts_time_frame'] );
            unset( $GLOBALS['nlposts_query_date'] );
        }
        // Reset post data
        wp_reset_postdata();
        // Reset query
        wp_reset_query();
        // Filter by language
        if( $posts_options['post_language'] != 'all' ) {
            $lang_list = $posts_options['post_language'];
            for( $i = 0; $i < count( $posts ); $i++ ) {
                // WPML compatibility
                if( function_exists( 'wpml_get_language_information' ) ) {
                    $post_lang = wpml_get_language_information( $posts[$i]->ID );
                    $post_lang = $post_lang['locale'];
                    // Keep only those matching language
                    if( in_array( $post_lang, $lang_list ) )
                        $posts_filtered[] = $posts[$i];
                } 
            }
            if( empty( $posts_filtered ) )
                $posts_filtered = array();
            // Return posts
            return $posts_filtered;
        } else
            // Return posts
            return $posts;
    }
    /**
     * Get Thumbnails
     *
     * Get thumbnails by type:
     *  - WordPress: default WordPress thumbnails
     *  - ACF: Advanced Custom Fields thumbnails
     *
     * @param array $parameters Thumbnail parameters
     * @return array $thumbnails List of thumbnails by blog and post IDs
     */
    private function nlposts_get_thumbnails( $parameters ) {
        // String to array
        if( preg_match( '/x/', $parameters['thumbnail_size'] ) )
            $parameters['thumbnail_size'] = explode( 'x', $parameters['thumbnail_size'] );
        // Thumbnail from WordPress
        if( $parameters['thumbnail_type'] == 'wordpress' ) {
            // Loop through blogs
            for( $counter = 0; $counter < count( $parameters['blog_id'] ); $counter++ ) {
                // Blog ID
                $blog_id = $parameters['blog_id'][$counter];
                // Switch to blog
                switch_to_blog( $parameters['blog_id'][$counter] );
                    // Loop through posts
                    for( $incounter = 0; $incounter < count( $parameters['post_id'][$blog_id] ); $incounter++ ) {
                        // Get thumbnail by Post ID
                        $thumbnails[$blog_id][$parameters['post_id'][$blog_id][$incounter]] = @get_the_post_thumbnail( 
                            $parameters['post_id'][$blog_id][$incounter],
                            $parameters['thumbnail_size'],
                            array(
                                'class'     => $parameters['thumbnail_css_class'],
                            ) 
                        );
                        // Placeholders
                        if( $parameters['thumbnail_service'] != 'none' ) {
                            // No thumbnail found
                            if( empty( $thumbnails[$blog_id][$parameters['post_id'][$blog_id][$incounter]] ) ) {
                                // Placeholder object
                                $placeholder = new NLPosts_Placeholders();
                                // Get a placeholder instead
                                $thumbnails[$blog_id][$parameters['post_id'][$blog_id][$incounter]] = 
                                    $placeholder->placeholder( 
                                        $parameters['thumbnail_service'], 
                                        $parameters['thumbnail_parameters']
                                    );
                            }
                        }
                    }
                // Restore current blog
                restore_current_blog();
            }
        }
        // Thumbnails from Advanced Custom Fields
        if( $parameters['thumbnail_type'] == 'acf' ) {
            // Check if ACF has been loaded
            if( NLP_ACF == 'yes' ) {
                if( function_exists( 'get_field' ) ) {
                    // Advanced Custom Field Object
                    $thumbnail_obj = new NLPosts_ACF();
                    // Set Parameters
                    $thumbnail_parameters = array(
                        'blog_ids'              => $parameters['blog_id'],
                        'post_ids'              => $parameters['post_id'],
                        'thumbnail_field'       => $parameters['thumbnail_field'],
                        'thumbnail_size'        => $parameters['thumbnail_size'],
                        'thumbnail_service'     => $parameters['thumbnail_service'],
                        'thumbnail_parameters'  => $parameters['thumbnail_parameters'],
                    );
                    // Get Thumbnails
                    $thumbnails = $thumbnail_obj->thumbnail( $thumbnail_parameters );
                }
            } else
                // ACF Library not loaded
                return false;
        }
        // Return thumbnails
        return $thumbnails;
    }
    /**
     * Author Data
     *
     * Pull post author information.
     * Default options can be modified using custom filter
     * nlposts_custom_author_data.
     *
     * Default options are:
     *      'user_login'            => 'no'
     *      'user_pass'             => 'no'
     *      'user_nicename'         => 'yes'
     *      'user_email'            => 'yes'
     *      'user_url'              => 'no'
     *      'user_registered'       => 'no'
     *      'user_activation_key'   => 'no'
     *      'user_status'           => 'no'
     *      'display_name'          => 'yes'
     *      'nickname'              => 'yes'
     *      'first_name'            => 'no'
     *      'last_name'             => 'no'
     *      'description'           => 'no'
     *      'jabber'                => 'no'
     *      'aim'                   => 'no'
     *      'yim'                   => 'no'
     *      'user_level'            => 'no'
     *      'user_firstname'        => 'no'
     *      'user_lastname'         => 'no'
     *      'rich_editing'          => 'no'
     *      'comment_shortcuts'     => 'no'
     *      'admin_color'           => 'no'
     *      'plugins_per_page'      => 'no'
     *      'plugins_last_view'     => 'no'
     *      'ID'                    => $post[$count]->post_author
     *      'display_avatar'        => $settings->author_image
     *      'avatar_size'           => $settings->author_image_size
     *      'avatar_default'        => $settings->author_image_default
     *      'blog_id'               => $post['blog_id']
     *
     * To override defaults use the nlposts_custom_author_data filter.
     *
     * Example:
     * 1.- Create a custom function:
     *      function my_custom_author() {
     *          $author_settings = array(
     *              'user_registered'   => 'yes',
     *              'description'       => 'yes',
     *          );
     *          return $author_settings;
     *      }
     * 2.- Pre-filter function:
     *      add_filter( 'nlposts_custom_author_data', 'my_custom_author' );
     *
     * @param array $parameters author profile settings
     * @return array $author_info containing author profile data.
     */
    protected function nlposts_author_data( $parameters ) {
        // Main parameters
        $blog_id = (int)$parameters['blog_id'];
        $author_id = (int)$parameters['ID'];
        $avatar_size = (int)$parameters['avatar_size'];
        $avatar_default = $parameters['avatar_default'];
        $display_avatar = $parameters['display_avatar'];
        // Switch to blog
        switch_to_blog( $blog_id );
            // Get user data
            $author_data = get_userdata( $author_id );
            // Display avatar?
            if( $display_avatar == 'yes' ) {
                // Get Gravatar
                $author_data->avatar = get_avatar( $author_id, $avatar_size, $avatar_default );
            }
        // Restore current blog
        restore_current_blog();
        // Loop through parameters
        foreach( $parameters as $field_name => $field_value ) {
            // If parameter is set
            if( $field_value != 'no' ) {
                // And is not one of our internal parameters
                if( !in_array( $field_name, array( 'display_avatar', 'avatar_size', 'blog_id' ) ) ) {
                    // Set data
                    $author_info[$field_name] = $author_data->$field_name;
                }
                // Set Avatar
                if( $field_name == 'display_avatar' ) {
                    $author_info[$field_name] = $author_data->avatar;
                }
            }
        }
        // Return Author profile data
        return $author_info;
    }
    /**
     * @section PUBLIC METHODS
     *
     * These methods are public shortcuts to protected functions within this class
     */
    /**
     * Do Shortcode
     *
     * Allows to publicly access shortcode function.
     *
     * @param array $parameters Custom Network Latest Posts settings
     * @return callable $this->nlposts_shortcode() Loads nlposts_shortcode protected function
     */
    public function nlposts_do_shortcode( $parameters = null ) {
        // Merge parameters with defaults
        $parameters = wp_parse_args( $parameters, $this->default );
        // Load protected function
        return $this->nlposts_shortcode( $parameters );
    }
}
?>