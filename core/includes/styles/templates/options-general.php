<?php
/**
 * Network Latest Posts
 *
 * @package Network Latest Posts
 * @author José SAYAGO <jose.sayago@laelite.info>
 * @internal options-general.php
 *
 * @uses NLP_Config::NLP_Config() found in nlposts-config.php
 * @uses NLPosts_Options::nlposts_save_option() found in functions/nlposts-options.php
 *
 * Options : General Settings
 *      General settings options.
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
if( isset( $_POST['save_options'] ) ) {
    // Get Params
    $options = array(
        'nlposts_deprecated'    => htmlspecialchars( $_POST['nlposts_deprecated'] ),
        'nlposts_theme'         => htmlspecialchars( $_POST['nlposts_theme'] ),
        'nlposts_homepage'      => htmlspecialchars( $_POST['nlposts_homepage'] ),
        'nlposts_load_acf'      => htmlspecialchars( $_POST['nlposts_load_acf'] ),
        'nlposts_load_woo'      => htmlspecialchars( $_POST['nlposts_load_woo'] )
    );
    // Save params
    foreach( $options as $option_name => $option ) {
        if( $_POST['save_options'] == true ) {
            if( !empty( $option ) )
                /**
                 * Register option
                 */
                $option_obj->nlposts_save_option( $option, $option_name );
            else {
                if( $option_name == 'nlposts_deprecated'    )   $option_obj->nlposts_save_option( 'no', $option_name );
                if( $option_name == 'nlposts_load_acf'      )   $option_obj->nlposts_save_option( 'no', $option_name );
                if( $option_name == 'nlposts_load_woo'      )   $option_obj->nlposts_save_option( 'no', $option_name );
            }
            /**
             * Reload configuration
             */
            $exec_config = new NLP_Config();
            // Reload config
            $exec_config->NLP_Config();
        }
    }
}
?>
<div class="nlposts-options-header">
    <div id="nlposts-options-icon"></div>
    <?php 
        echo $html5->header_tag( array(
            'data'      => $phrases->nlposts_options_phrase()->dashboard_general_panel,
            'structure' => 'h2',
            'class'     => ''
        ) );
    ?>
</div>

<hr />

<div class="nlposts-options">
    <form method="post" action="#">
        <input type="hidden" name="save_options" value="true" />
        <?php
            settings_fields( 'nlposts_options_group' );
            do_settings_fields( __FILE__ , 'nlposts_options_group' );
        ?>
        <p>
            <label for="nlposts_deprecated"><?php echo $phrases->nlposts_options_phrase()->option_nlposts_deprecated; ?></label>
        </p>
        <p>
            <input type="checkbox" class="js-switch" name="nlposts_deprecated" value="yes" 
            <?php if( get_option( 'nlposts_deprecated' ) === false || get_option( 'nlposts_deprecated' ) === 'yes' ) { ?> 
            checked 
            <?php } ?> />
        </p>
        <?php
            /**
             * Display options only if 
             * deprecated mode is not active.
             */
            if( NLP_DEPRECATED != 'yes' ) {
        ?>
        <p>
            <label for="nlposts_load_acf"><?php echo $phrases->nlposts_options_phrase()->option_nlposts_load_acf; ?></label>
        </p>
        <p>
            <input type="checkbox" class="js-switch" name="nlposts_load_acf" value="yes" 
            <?php if( get_option( 'nlposts_load_acf' ) === false || get_option( 'nlposts_load_acf' ) === 'yes' ) { ?> 
            checked 
            <?php } ?> <?php if( !NLP_ACF_INSTALLED ) { ?> disabled <?php } ?> />
        </p>
        <p>
            <label for="nlposts_load_woo"><?php echo $phrases->nlposts_options_phrase()->option_nlposts_load_woo; ?></label>
        </p>
        <p>
            <input type="checkbox" class="js-switch" name="nlposts_load_woo" value="yes" 
            <?php if( get_option( 'nlposts_load_woo' ) === false || get_option( 'nlposts_load_woo' ) === 'yes' ) { ?> 
            checked 
            <?php } ?> <?php if( !NLP_WOOCOMMERCE_INSTALLED ) { ?> disabled <?php } ?> />
        </p>

        <p>
            <label for="nlposts_theme"><?php echo $phrases->nlposts_options_phrase()->option_nlposts_theme; ?></label>
        </p>
        <p>
            <select class="nlposts_selector" name="nlposts_theme">
                <?php
                    /**
                     * Theme List
                     * Makes a list of installed themes.
                     */
                    $themes_local   = array_filter( glob( NLP_THEMES . '*' ), 'is_dir' );
                    $themes_user    = array_filter( glob( NLP_THEMES_USER . '*' ), 'is_dir' );
                    $themes = array_merge( $themes_local, $themes_user );
                    foreach( $themes as $theme ) {
                        if( NLP_ACTIVE_THEME == basename( $theme ) )
                            echo '<option value="'. basename( $theme ) .'" selected="selected">'. ucwords( str_replace( '-', ' ', basename( $theme ) ) ) .'</option>';
                        else
                            echo '<option value="'. basename( $theme ) .'">'. ucwords( str_replace( '-', ' ', basename( $theme ) ) ) .'</option>';
                    }
                ?>
            </select>
        </p>

        <?php } ?>

        <hr />

        <?php 
            echo get_submit_button('','nlposts_submit','submit','',''); 
            echo $html5->link_tag( array(
                'title'     => $phrases->nlposts_options_phrase()->dashboard_main,
                'href'      => 'admin.php?page=nlposts-options',
                'text'      => $phrases->nlposts_options_phrase()->dashboard_main,
                'target'    => '_self',
                'class'     => 'nlp-back-link',
            ) );
            echo $html5->link_tag( array(
                'title'     => $phrases->nlposts_options_phrase()->dashboard_themes_menu,
                'href'      => 'admin.php?page=nlposts-theme-installer',
                'text'      => $phrases->nlposts_options_phrase()->dashboard_themes_menu,
                'target'    => '_self',
                'class'     => 'nlp-back-link',
            ) );
        ?>
    </form>
</div>
<?php
include_once( 'options-footer.php' );
?>