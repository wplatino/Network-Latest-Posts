<?php
/**
 * Network Latest Posts
 *
 * @package Network Latest Posts
 * @author José SAYAGO <jose.sayago@laelite.info>
 * @file nlposts-html.php
 *
 * HTML
 *      Class providing HTML tags to be embedded in other classes.
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
class NLPosts_HTML {
    /**
     * HTML5 Structural Elements
     *
     * Wrap data inside HTML5 elements.
     * @param array $data_structure Data and structure
     * @return string $wrap_structure Wrapped data
     * 
     * Parameters:
     *  - data: Information to be wrapped
     *  - structrue: HTML5 structure element
     *  - class: CSS class for HTML5 element
     */
    public function html5_structure( $data_structure ) {
        // Parameters
        $data       = $data_structure['data'];
        $structure  = $data_structure['structure'];
        $class      = $data_structure['class'];
        if( is_array( $class ) )
            $class = implode( ' ', $class );
        // Tags
        $html_open  = apply_filters( 'nlposts_custom_html5_open', array(
            'div'       => "<div class='".$class."'>",
            'header'    => "<header class='".$class."'>",
            'footer'    => "<footer class='".$class."'>",
            'nav'       => "<nav class='".$class."'>",
            'article'   => "<article class='".$class."'>",
            'section'   => "<section class='".$class."'>",
            'aside'     => "<aside class='".$class."'>",
            'p'         => "<p class='".$class."'>",
            'small'     => "<small class='".$class."'>",
            'ul'        => "<ul class='".$class."'>",
            'li'        => "<li class='".$class."'>",
        ) );
        $html_close = apply_filters( 'nlposts_custom_html5_close', array(
            'div'       => '</div>',
            'header'    => '</header>',
            'footer'    => '</footer>',
            'nav'       => '</nav>',
            'article'   => '</article>',
            'section'   => '</section>',
            'aside'     => '</aside>',
            'p'         => '</p>',
            'small'     => '</small>',
            'ul'        => '</ul>',
            'li'        => '</li>',
        ) );
        if( empty( $data ) )
            return false;
        if( !is_array( $structure ) )
            // Wrap content
            $wrap_structure = $html_open[$structure].$data.$html_close[$structure];
        else {
            // Reverse structure for closing tags
            $reverse_structure = array_reverse( $structure );
            for( $x = 0; $x < count( $structure ); $x++ ) {
                @$wrap_structure .= $html_open[ $structure[$x] ];
            }
            @$wrap_structure .= $data;
            for( $y = 0; $y < count( $reverse_structure ); $y++ ) {
                @$wrap_structure .= $html_close[ $reverse_structure[$y] ];
            }
        }
        // Return wrapped content
        return $wrap_structure;
    }
    /**
     * Header Tag
     *
     * Creates header tags for headlines.
     * @param array $data_structure Data, structure and CSS class
     * @return string $wrap_structure Data embedded in HTML tags
     */
    public function header_tag( $data_structure ) {
        // Parameters
        $data       = $data_structure['data'];
        $structure  = $data_structure['structure'];
        $class      = $data_structure['class'];
        // Tags
        $html_open  = apply_filters( 'nlposts_custom_headertag_open', array(
            'h1'    => "<h1 class='".$class."'>",
            'h2'    => "<h2 class='".$class."'>",
            'h3'    => "<h3 class='".$class."'>",
            'h4'    => "<h4 class='".$class."'>",
            'h5'    => "<h5 class='".$class."'>",
            'h6'    => "<h6 class='".$class."'>",
        ) );
        $html_close = apply_filters( 'nlposts_custom_headertag_close', array(
            'h1'    => '</h1>',
            'h2'    => '</h2>',
            'h3'    => '</h3>',
            'h4'    => '</h4>',
            'h5'    => '</h5>',
            'h6'    => '</h6>',
        ) );
        // Wrap content
        $wrap_structure = $html_open[$structure].$data.$html_close[$structure];
        // Return wrapped content
        return $wrap_structure;
    }
    /**
     * Image Tag
     *
     * Creates an image tag using parameters
     * provided.
     *
     * Parameters:
     *  - alt
     *  - title
     *  - src
     *  - width
     *  - height
     *  - class
     *  - id
     *
     * This function provides a hookable action,
     * use nlposts_custom_image_tag in functions.php
     * to override default image tag parameters.
     *
     * @param array $parameters Tag parameters
     * @return string HTML image tag
     *
     */
    public function image_tag( $parameters ) {
        // Default parameters
        $defaults   = apply_filters( 'nlposts_custom_image_tag', array(
            'alt'       => '',
            'title'     => '',
            'src'       => '',
            'width'     => '',
            'height'    => '',
            'class'     => '',
            'id'        => '',
        ) );
        // Merge user's and default parameters
        $parameters = array_merge( $defaults, $parameters );
        $alt        = $parameters['alt'];
        $title      = $parameters['title'];
        $src        = $parameters['src'];
        $width      = $parameters['width'];
        $height     = $parameters['height'];
        $css_class  = $parameters['class'];
        $id         = $parameters['id'];
        // Create image
        $image_tag  = '<img';
        foreach( $parameters as $attribute => $value ) {
            if( !empty( $value ) )
                $image_tag.= ' '.$attribute.'="'.$value.'" ';
        }
        $image_tag  = rtrim( $image_tag );
        $image_tag .= ' />';
        // Return image
        if( !empty( $image_tag ) )
            return $image_tag;
        else
            return false;
    }
    /**
     * Link Tag
     *
     * Creates HTML links using user's parameters.
     * @param array $link_structure Data, link tag elements
     * @return string $link Linked data
     */
    public function link_tag( $link_structure ) {
        // Defaults
        $defaults   = apply_filters( 'nlposts_custom_link_tag', array(
            'title'     => '',
            'href'      => '',
            'hreflang'  => 'en_US',
            'media'     => '',
            'rel'       => '',
            'target'    => '',
            'type'      => '',
            'class'     => '',
            'id'        => '',
            'text'      => '',
        ) );
        // Merge user parameters with defaults
        $link_structure = array_merge( $defaults, $link_structure );
        /**
         * Language to ISO reference
         * @link http://www.w3schools.com/tags/ref_language_codes.asp
         */
        $link_structure['hreflang'] = $this->lang_iso( $link_structure['hreflang'] );
        // Create link
        $link = '<a';
        foreach( $link_structure as $attribute => $value ) {
            if( !empty( $value ) && $attribute != 'text' )
                $link.= ' '.$attribute.'="'.$value.'" ';
        }
        // Strip whitespace from the end of string
        $link = rtrim( $link );
        $link.= '>'.$link_structure['text'].'</a>';
        // Return link
        if( !empty( $link ) )
            return $link;
        else
            return false;
    }
    /**
     * Language Code to ISO
     *
     * Converts from WordPress language
     * code ISO-639_ISO-3166 to ISO-639
     */
    private function lang_iso( $code ) {
        // Return ISO-639 
        return substr($code, 0, strpos($code, '_'));
    }
}
?>