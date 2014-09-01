<?php
/**
 * Network Latest Posts
 *
 * @package Network Latest Posts
 * @author José SAYAGO <jose.sayago@laelite.info>
 * @internal options-index.php
 *
 * Options : Index
 *      Main options page.
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
include_once( 'options-header.php' );
$option_obj = new NLPosts_Options();
?>
<div class="nlposts-options-header">
    <div id="nlposts-options-icon"></div>
    <h2>
        <?php echo $phrases->nlposts_options_phrase()->dashboard_panel;  ?>
    </h2>
</div>

<hr />

<div class="nlposts-options">
    <div class='quick-menu'>
        <?php
            echo $html5->header_tag( array(
                'data'      => $phrases->nlposts_options_phrase()->dashboard_internal_links,
                'structure' => 'h2',
                'class'     => 'quick-menu-title'
            ) );
            $general_settings = $html5->link_tag( array(
                'title'     => $phrases->nlposts_options_phrase()->dashboard_general_menu,
                'href'      => 'admin.php?page=nlposts-general-settings',
                'text'      => $phrases->nlposts_options_phrase()->dashboard_general_menu,
                'target'    => '_self',
                'class'     => 'nlp-option-link',
            ) );
            echo $html5->html5_structure( array( 
                'data'      => $general_settings,
                'structure' => array( 'p' ),
                'class'     => 'links',
            ) );
            $installer_settings = $html5->link_tag( array(
                'title'     => $phrases->nlposts_options_phrase()->dashboard_themes_menu,
                'href'      => 'admin.php?page=nlposts-theme-installer',
                'text'      => $phrases->nlposts_options_phrase()->dashboard_themes_menu,
                'target'    => '_self',
                'class'     => 'nlp-option-link',
            ) );
            echo $html5->html5_structure( array( 
                'data'      => $installer_settings,
                'structure' => array( 'p' ),
                'class'     => 'links',
            ) );
        ?>
    </div>
    <div class='quick-menu external-resources'>
        <?php
            echo $html5->header_tag( array(
                'data'      => $phrases->nlposts_options_phrase()->dashboard_external_links,
                'structure' => 'h2',
                'class'     => 'quick-menu-title'
            ) );
            $link_doc = $html5->link_tag( array(
                'title'     => NLP_NAME .' '. $phrases->nlposts_external_links()->link_documentation,
                'href'      => 'http://laelitestore.com/network-latest-posts/documentation?utm_source=wpnetworkadmin&utm_medium=link&utm_campaign=nlpostsfree',
                'text'      => $phrases->nlposts_external_links()->link_documentation,
                'target'    => '_blank',
                'class'     => 'nlp-option-link',
            ) );
            echo $html5->html5_structure( array( 
                'data'      => $link_doc,
                'structure' => array( 'p' ),
                'class'     => 'links',
            ) );
            $link_store = $html5->link_tag( array(
                'title'     => $phrases->nlposts_external_links()->link_store,
                'href'      => 'http://laelitestore.com/?utm_source=wpnetworkadmin&utm_medium=link&utm_campaign=nlpostsfree',
                'text'      => $phrases->nlposts_external_links()->link_store,
                'target'    => '_blank',
                'class'     => 'nlp-option-link',
            ) );
            echo $html5->html5_structure( array( 
                'data'      => $link_store,
                'structure' => array( 'p' ),
                'class'     => 'links',
            ) );
        ?>
    </div>
    <div class='nlposts-stats cache'>
        <?php
            $transients = $option_obj->nlposts_transient_data();
            echo $html5->header_tag( array(
                'data'      => $phrases->nlposts_options_phrase()->dashboard_cache,
                'structure' => 'h2',
                'class'     => 'quick-menu-title'
            ) );
            if( empty( $transients ) )
                $x = 0;
            else {
                $x = count( $transients );
                foreach( $transients as $transient ) {
                    echo $html5->html5_structure( array(
                        'data'      => substr( $transient->option_name, 24 ),
                        'structure' => array( 'div', 'p' ),
                        'class'     => ''
                    ) );
                }
            }
            printf( $html5->html5_structure( array(
                'data'      => $phrases->nlposts_options_phrase()->cached_results,
                'structure' => 'p',
                'class'     => 'alert'
            ) ), $x );
        ?>
    </div>
</div>

<hr />

<?php
include_once( 'options-footer.php' );
?>