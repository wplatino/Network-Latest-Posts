<?php
/**
 * Network Latest Posts
 *
 * @package Network Latest Posts
 * @author José SAYAGO <jose.sayago@laelite.info>
 * @file nlposts-placeholders.php
 *
 * Placeholders
 *      Class providing services for placeholder images.
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
class NLPosts_Placeholders {
    /**
     * Placeholder Variables
     *
     * @var string $base_url Placeholder service URL
     * @var array $parameters Placeholder parameters
     * @var string $url Placeholder URL with parameters
     * @var array $service_url List of services' URLs
     */
    protected $base_url;
    protected $parameters;
    protected $url;
    protected $service_url;
    /**
     * Placeholder
     *
     * Returns placeholder image along with parameters
     * @param string $service Placeholder service name
     * @param array $parameters Placeholder parameters
     * @return string $url URL requesting images by parameters to placeholder services
     */
    public function placeholder( $service, $parameters ) {
        // Service URL
        $base_url   = $this->placeholder_service( $service );
        // URL and parameters
        $url        = $base_url . $parameters;
        // HTML object
        $html_tag   = new NLPosts_HTML();
        // Image parameters
        $image_parameters   = array(
            'src'   => $url,
            'class' => 'attachment- wp-post-image',
        );
        // Image tag
        $thumbnail  = $html_tag->image_tag( $image_parameters );
        // Return thumbnail
        return $thumbnail;
    }
    /**
     * Placeholder Services
     *
     * List of services providing dummy images.
     *
     * This function provides a hookable action,
     * use nlposts_custom_placeholder_service in
     * functions.php file to override services.
     *
     * @param string $service Service name
     * @return string $base_url Service URL
     */
    protected function placeholder_service( $service ) {
        // Services
        $service_url        = apply_filters( 'nlposts_custom_placeholder_service', array(
            'hhhhold'       => 'http://hhhhold.com',
            'dummyimage'    => 'http://dummyimage.com',
            'lorempixel'    => 'http://lorempixel.com',
            'placehold'     => 'http://placehold.it',
            'placeimg'      => 'http://placeimg.com',
            'imageholdr'    => 'http://imageholdr.com',
            'placecreature' => 'http://placecreature.com',
            'pixelholdr'    => 'http://pixelholdr.com',
            'baconmockup'   => 'http://baconmockup.com',
            'placedog'      => 'http://placedog.com',
            'placekitten'   => 'http://placekitten.com',
        ) );
        // Check if service exists
        if( array_key_exists( $service, $service_url ) )
            $base_url = $service_url[$service];
        else
            // Default service
            $base_url = 'http://placehold.it';
        return $base_url;
    }
}
?>