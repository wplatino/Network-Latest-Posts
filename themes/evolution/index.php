<?php
/**
 * Network Latest Posts
 *
 * @package Network Latest Posts
 * @author José SAYAGO <jose.sayago@laelite.info>
 * @internal index.php
 *
 * Index
 *      Main template file.
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
include_once( 'header.php' );
/*
Default Parameters Filter

function custom_parameters() {
    $params = array(
        'param1' => 'black',
        'param2' => 'white',
        'param3' => 'green',
    );
    return $params;
}
add_filter( 'nlposts_custom_default_parameters', 'custom_parameters' );
*/
$nlposts = new NLPosts_Core();
/*
Phrases Filter

function custom_frases() {
    $frases = array(
        'ellipsis'  => '&raquo;',
        'more_link' => 'Leer mas',
    );
    return $frases;
}
add_filter( 'nlposts_custom_excerpt_phrase', 'custom_frases' );
*/

/*
//Placeholder Filter

function custom_service() {
    $service_url = array(
        'hhhhold' => 'http://google.com',
    );
    return $service_url;
}
add_filter( 'nlposts_custom_placeholder_service', 'custom_service' );

$placeholder_url = $nlposts->nlposts_placeholder();

echo $placeholder_url;
*/

//echo do_shortcode( '[nlposts_evo]' );
//var_dump( $shortcode );

/*
            'display_title'     => 'yes',
            'display_excerpt'   => 'no',
            'display_date'      => 'no',
            'display_author'    => 'no',
            'display_author_img'=> 'no',
            'display_blog'      => 'no',
            'display_category'  => 'no',
            'display_tag'       => 'no',
            'display_comment'   => 'no',
            'display_thumbnail' => 'no',
            'display_content'   => 'no',
            

            'link_title'        => 'yes',
            'link_excerpt'      => 'no',
            'link_date'         => 'no',
            'link_author'       => 'no',
            'link_blog'         => 'no',
            'link_category'     => 'no',
            'link_tag'          => 'no',
            'link_comment'      => 'no',
            'link_thumbnail'    => 'no',
*/
$html5 = new NLPosts_HTML();
?>
<div class="content">
    <?php
        
        foreach( $posts as $post ) {
            if( is_array( $post ) ) {
                if( !empty( $post[0]->post_title ) ) {
                    if( $parameters->display_blog == 'yes' ) {
                        // Link to blog?
                        if( $parameters->link_blog == 'yes' )
                            $blog_name = $html5->link_tag( array(
                                'title'     => $post['blog_name'],
                                'href'      => $post['blog_url'],
                                'hreflang'  => $post['blog_language'],
                                'text'      => $post['blog_name'],
                                'target'    => $parameters->link_target,
                            ) );
                        else
                            $blog_name = $post['blog_name'];
                        // Display Blog name
                        echo $html5->header_tag( array( 
                            'data'      => $blog_name,
                            'structure' => 'h3',
                            'class'     => 'blog_name',
                        ) );
                    }
                }
                for( $count = 0; $count < ( count( $post ) - 7 ); $count++ ) {
                    if( $parameters->display_title == 'yes' ) {
                        if( $parameters->link_title == 'yes' )
                            $post_title = $html5->link_tag( array(
                                'title'     => $post[$count]->post_title,
                                'href'      => $post[$count]->permalink,
                                'hreflang'  => $post[$count]->language,
                                'text'      => $post[$count]->post_title,
                                'target'    => $parameters->link_target,
                            ) );
                        else
                            $post_title = $post[$count]->post_title;
                        // Wrap data
                        echo $html5->header_tag( array( 
                            'data'      => $post_title,
                            'structure' => 'h3',
                            'class'     => 'post_title',
                        ) );
                    }
                    if( $parameters->display_excerpt == 'yes' ) {
                        $excerpt = $post[$count]->excerpt;
                        $excerpt.= $post[$count]->excerpt_trunc_el;
                        $excerpt.= $html5->link_tag( array(
                            'title'     => $parameters->excerpt_link.' &gt; '.$post[$count]->post_title,
                            'href'      => $post[$count]->permalink,
                            'hreflang'  => $post[$count]->language,
                            'text'      => $parameters->excerpt_link,
                            'target'    => $parameters->link_target,
                        ) );
                        echo $html5->html5_structure( array( 
                            'data'      => $excerpt,
                            'structure' => array( 'div', 'p' ),
                            'class'     => 'post_excerpt',
                        ) );
                    }
                    // Thumbnails
                    if( $parameters->link_thumbnail == 'yes' ) {
                        $thumbnail = $html5->link_tag( array(
                                    'title'     => $post[$count]->post_title,
                                    'href'      => $post[$count]->permalink,
                                    'hreflang'  => $post[$count]->language,
                                    'text'      => $post[$count]->thumbnail,
                                    'target'    => $parameters->link_target,
                                ) );
                        echo $html5->html5_structure( array( 
                            'data'      => $thumbnail,
                            'structure' => 'div',
                            'class'     => 'post_thumbnail',
                        ) );
                    } else
                        echo $html5->html5_structure( array( 
                            'data'      => $post[$count]->thumbnail,
                            'structure' => 'div',
                            'class'     => 'post_thumbnail',
                        ) );
                }
            }
            if( is_object( $post ) ) {
                if( $parameters->display_title == 'yes' ) {
                    if( $parameters->link_title == 'yes' )
                        $post_title = $html5->link_tag( array(
                            'title'     => $post->post_title,
                            'href'      => $post->permalink,
                            'hreflang'  => $post->language,
                            'text'      => $post->post_title,
                            'target'    => $parameters->link_target,
                        ) );
                    else
                        $post_title = $post->post_title;
                    // Wrap data
                    echo $html5->header_tag( array( 
                        'data'      => $post_title,
                        'structure' => 'h3',
                        'class'     => 'post_title',
                    ) );
                }
                if( $parameters->display_excerpt == 'yes' ) {
                    echo $html5->html5_structure( array( 
                        'data'      => $post->excerpt.$post->excerpt_trunc_el,
                        'structure' => array( 'div', 'p' ),
                        'class'     => 'post_excerpt',
                    ) );
                }
            }
        }
    ?>
</div>
<?php
include_once( 'footer.php' );
?>