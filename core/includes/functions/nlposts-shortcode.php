<?php
/**
 * Network Latest Posts
 *
 * @package Network Latest Posts
 * @author José SAYAGO <jose.sayago@laelite.info>
 * @internal nlposts-shortcode.php
 *
 * Shortcode Form
 *      TinyMCE shortcode form helper.
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
class NLPosts_Shortcode {
    /**
     * Constructor
     */
    public function NLPosts_Shortcode() {
        $base_file      = dirname( __FILE__ );
        return $base_file;
    }
    /**
     * WordPress Configuration Path
     *
     * Finds the WordPress configuration file and return its path
     *
     * @param string $base file dirname
     * @return string $path file path
     */
    // Retrieve the WordPress root path
    public function nlposts_wp_config( $base ) {
        $path = false;
        if( !empty( $base ) ) {
            // Check multiple levels, until find the config file
            if ( file_exists( dirname( dirname( $base ) ).'/wp-config.php' ) ) {
                $path = dirname( dirname( $base ) );
            } elseif ( file_exists( dirname( dirname( dirname( $base ) ) ).'/wp-config.php' ) ) {
                $path = dirname( dirname( dirname( $base ) ) );
            } elseif ( file_exists( dirname( dirname( dirname( dirname( $base ) ) ) ).'/wp-config.php' ) ) {
                $path = dirname( dirname( dirname( dirname( $base ) ) ) );
            } elseif ( file_exists( dirname( dirname( dirname( dirname( dirname( $base ) ) ) ) ).'/wp-config.php' ) ) {
                $path = dirname( dirname( dirname( dirname( dirname( $base ) ) ) ) );
            } elseif ( file_exists( dirname( dirname( dirname( dirname( dirname( dirname( $base ) ) ) ) ) ).'/wp-config.php' ) ) {
                $path = dirname( dirname( dirname( dirname( dirname( dirname( $base ) ) ) ) ) );
            } else { $path = false; }
            // Get the path
            if ( $path != false ) { $path = str_replace( '\\', '/', $path ); }
            // Return the path
            return $path;
        } else { return false; }
    }
}
// Shortcode Object
$shortcode = new NLPosts_Shortcode();
// Requires WordPress Load file
require_once( $shortcode->nlposts_wp_config( $shortcode->NLPosts_Shortcode() ) . '/wp-load.php');
// Core Object
$nlposts = new NLPosts_Core();
// HTML Object
$html = new NLPosts_HTML();
// Phrases Object
$phrases = new NLPosts_Phrases();
// Set array
$settings = array();
// Parse & merge settings with default values
$settings = wp_parse_args( $settings, $nlposts->NLPosts_Core() );
// Extract elements as variables
extract( $settings );
// Blogs Info
$blogs = $nlposts->nlposts_get_blogs();
// HTML Form
$form_content = $html->header_tag( array(
    'data'          => $phrases->nlposts_options_phrase()->shortcode_panel,
    'structure'     => 'h2',
    'class'         => ''
) );
$form_content.= $html->selfclosing_tag( 'hr' );
$tab1 = $html->link_tag( array(
    'title'         => $phrases->nlposts_options_phrase()->shortcode_tab1,
    'href'          => '#tab1',
    'class'         => 'tab1',
    'text'          => $phrases->nlposts_options_phrase()->shortcode_tab1,
) );
$tab2 = $html->link_tag( array(
    'title'         => $phrases->nlposts_options_phrase()->shortcode_tab2,
    'href'          => '#tab2',
    'class'         => 'tab2',
    'text'          => $phrases->nlposts_options_phrase()->shortcode_tab2,
) );
$tab3 = $html->link_tag( array(
    'title'         => $phrases->nlposts_options_phrase()->shortcode_tab3,
    'href'          => '#tab3',
    'class'         => 'tab3',
    'text'          => $phrases->nlposts_options_phrase()->shortcode_tab3,
) );
$tab4 = $html->link_tag( array(
    'title'         => $phrases->nlposts_options_phrase()->shortcode_tab4,
    'href'          => '#tab4',
    'class'         => 'tab4',
    'text'          => $phrases->nlposts_options_phrase()->shortcode_tab4,
) );
$tab5 = $html->link_tag( array(
    'title'         => $phrases->nlposts_options_phrase()->shortcode_tab5,
    'href'          => '#tab5',
    'class'         => 'tab5',
    'text'          => $phrases->nlposts_options_phrase()->shortcode_tab5,
) );
$tabs = $html->html5_structure( array( 
    'data'      => $tab1,
    'structure' => 'li',
    'class'     => '',
    'id'        => ''
) );
$tabs.= $html->html5_structure( array( 
    'data'      => $tab2,
    'structure' => 'li',
    'class'     => '',
    'id'        => ''
) );
$tabs.= $html->html5_structure( array( 
    'data'      => $tab3,
    'structure' => 'li',
    'class'     => '',
    'id'        => ''
) );
$tabs.= $html->html5_structure( array( 
    'data'      => $tab4,
    'structure' => 'li',
    'class'     => '',
    'id'        => ''
) );
$tabs.= $html->html5_structure( array( 
    'data'      => $tab5,
    'structure' => 'li',
    'class'     => '',
    'id'        => ''
) );
$form_tabs = $html->html5_structure( array(
    'data'          => $tabs,
    'structure'     => 'ul',
    'class'         => '',
    'id'            => ''
) );
/**
 * Tab Content
 */
// Tab 1
$tab1_content = "";
$tab1_content.= $html->input_tag( array(
    'id'            => 'title',
    'name'          => 'title',
    'class'         => '',
    'type'          => 'text',
    'label'         => true,
    'break'         => true,
    'title'         => $phrases->nlposts_options_phrase()->shortcode_f1_va,
    'value'         => '',
    'placeholder'   => $phrases->nlposts_options_phrase()->shortcode_f1_ph,
) );
$tab1_content.= $html->selfclosing_tag( 'br' );
$tab1_content.= $html->input_tag( array(
    'id'            => 'instance',
    'name'          => 'instance',
    'class'         => '',
    'type'          => 'text',
    'label'         => true,
    'break'         => true,
    'title'         => $phrases->nlposts_options_phrase()->shortcode_f2_va,
    'value'         => '',
    'placeholder'   => $phrases->nlposts_options_phrase()->shortcode_f2_ph,
) );
$tab2_content = "";
$tab3_content = "";
$tab4_content = "";
$tab5_content = "";
/**
 * Tabs
 */
$form_tabs.= $html->html5_structure( array(
    'data'      => $tab1_content,
    'structure' => 'div',
    'class'     => '',
    'id'        => 'tab1'
) );
$form_tabs.= $html->html5_structure( array(
    'data'      => $tab2_content,
    'structure' => 'div',
    'class'     => '',
    'id'        => 'tab2'
) );
$form_tabs.= $html->html5_structure( array(
    'data'      => $tab3_content,
    'structure' => 'div',
    'class'     => '',
    'id'        => 'tab3'
) );
$form_tabs.= $html->html5_structure( array(
    'data'      => $tab4_content,
    'structure' => 'div',
    'class'     => '',
    'id'        => 'tab4'
) );
$form_tabs.= $html->html5_structure( array(
    'data'      => $tab5_content,
    'structure' => 'div',
    'class'     => '',
    'id'        => 'tab5'
) );
$form_content.= $html->html5_structure( array(
    'data'          => $form_tabs,
    'structure'     => 'div',
    'class'         => 'tabs',
    'id'            => 'nlptabs'
) );
$form_content.= $html->selfclosing_tag( 'hr' );

echo $html->html5_structure( array( 
    'data'          => $form_content,
    'structure'     => 'div',
    'class'         => 'wrap nlposts',
    'id'            => ''
) );
?>
<script type="text/javascript" charset="utf-8">
    //<![CDATA[
    jQuery('.wrap').ready(function(){
        jQuery('#nlptabs').tabs();

    });
    jQuery('#nlposts_shortcode_submit').click(function(){
        // Count words
        function nlp_countWords(s) {
            return s.split(/[ \t\r\n]/).length;
        }
        // Get the form fields
        var values = {};
        jQuery('#TB_ajaxContent form :input').each(function(index,field) {
            name = '#TB_ajaxContent form #'+field.id;
            values[jQuery(name).attr('id')] = jQuery(name).val();
        });
        // Default values
        var defaults = new Array();
        defaults['title'] = null;
        defaults['number_posts'] = '10';
        defaults['time_frame'] = '0';
        defaults['title_only'] = 'true';
        defaults['display_type'] = 'ulist';
        defaults['blog_id'] = null;
        defaults['ignore_blog'] = null;
        defaults['thumbnail'] = 'false';
        defaults['thumbnail_wh'] = '80x80';
        defaults['thumbnail_class'] = null;
        defaults['thumbnail_filler'] = 'placeholder';
        defaults['thumbnail_custom'] = 'false';
        defaults['thumbnail_field'] = null;
        defaults['custom_post_type'] = 'post';
        defaults['category'] = null;
        defaults['tag'] = null;
        defaults['paginate'] = 'false';
        defaults['posts_per_page'] = null;
        defaults['display_content'] = 'false';
        defaults['excerpt_length'] = null;
        defaults['auto_excerpt'] = 'false';
        defaults['full_meta'] = 'false';
        defaults['sort_by_date'] = 'false';
        defaults['sort_by_blog'] = 'false';
        defaults['sorting_order'] = 'desc';
        defaults['sorting_limit'] = null;
        defaults['post_status'] = 'publish';
        defaults['excerpt_trail'] = 'text';
        defaults['css_style'] = null;
        defaults['wrapper_list_css'] = 'nav nav-tabs nav-stacked';
        defaults['wrapper_block_css'] = 'content';
        defaults['instance'] = null;
        defaults['random'] = 'false';
        defaults['post_ignore'] = null;
        // Set the thumbnail size
        if( values.thumbnail_w && values.thumbnail_h ) {
            var thumbnail_wh = values.thumbnail_w+'x'+values.thumbnail_h;
            values['thumbnail_wh'] = thumbnail_wh;
            values['thumbnail_w'] = 'null';
            values['thumbnail_h'] = 'null';
        }
        // Clear the submit button so the shortcode doesn't take its value
        values['nlposts_shortcode_submit'] = null;
        // Build the shortcode
        var nlp_shortcode = '[nlposts';
        // Get the settings and values
        for( settings in values ) {
            // If they're not empty or null
            if( values[settings] && values[settings] != 'null' ) {
                // And they're not the default values
                if( values[settings] != defaults[settings] ) {
                    // Count words
                    if( nlp_countWords(String(values[settings])) > 1 ) {
                        // If more than 1 or a big single string, add quotes to the key=value
                        nlp_shortcode += ' '+settings +'="'+ values[settings]+'"';
                    } else {
                        // Otherwise, add the key=value
                        nlp_shortcode += ' '+settings +'='+ values[settings];
                    }
                }
            }
        }
        // Close the shortcode
        nlp_shortcode += ']';
        // insert the shortcode into the active editor
        tinyMCE.activeEditor.execCommand('mceInsertContent', 0, nlp_shortcode);
        // close Thickbox
        tb_remove();
    });
    //]]>
</script>