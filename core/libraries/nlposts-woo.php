<?php
/**
 * Network Latest Posts
 *
 * @package Network Latest Posts
 * @author José SAYAGO <jose.sayago@laelite.info>
 * @file nlposts-woo.php
 *
 * WooCommerce
 *      Class providing support for third party plugin WooCommerce
 *      @link http://www.woothemes.com/woocommerce/
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
class NLPosts_WooCommerce {
    /**
     * Get Products
     *
     * Pulls product information from WooCommerce
     * for each one of network sites.
     * @param array $parameters List of parameters
     * @return array $products List of products
     */
    public function nlposts_get_products( $parameters ) {
        $blog_ids = $parameters['blog_ids'];
        $post_ids = $parameters['post_ids'];
        foreach( $blog_ids as $blog_id ) {
            switch_to_blog( $blog_id );
                for( $count = 0; $count < count( $post_ids ); $count++ ) {
                    $products[$blog_id][] = get_product( $post_ids[$count] );
                }
            restore_current_blog();
        }
        if( !empty( $products ) )
            return $products;
        else
            return false;
    }
    /**
     * Get WooCommerce Post Meta
     *
     * Pulls meta information from posts' meta table.
     * @param array $parameters List of parameters
     * @return array $data Meta information
     */
    public function nlposts_woo_meta( $parameters ) {
        $blog_ids = $parameters['blog_ids'];
        $post_ids = $parameters['post_ids'];
        $meta_key = htmlspecialchars( $parameters['meta_key'] );
        foreach( $blog_ids as $blog_id ) {
            switch_to_blog( $blog_id );
                for( $count = 0; $count < count( $post_ids ); $count++ ) {
                    if( $meta_key == '_price' ) {
                        if( function_exists( 'woocommerce_price' ) ) {
                            $data[$blog_id][$post_ids[$count]] = woocommerce_price( get_post_meta( $post_ids[$count], $meta_key, true ) );
                        }
                    } else
                        $data[$blog_id][$post_ids[$count]] = get_post_meta( $post_ids[$count], $meta_key, true );
                }
            restore_current_blog();
        }
        if( !empty( $data ) )
            return $data;
        else
            return false;
    }
}
?>