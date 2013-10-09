<?php
/**
 * Network Latest Posts
 *
 * @package Network Latest Posts
 * @author José SAYAGO <jose.sayago@laelite.info>
 * @file options-general.php
 *
 * Options : General Settings
 *      General settings options.
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
include_once( 'options-header.php' );
@$option_obj = new NLPosts_Options();
// Get Params
@$options = array(
    'nlposts_deprecated'    => @htmlspecialchars( $_POST['nlposts_deprecated'] ),
    'nlposts_theme'         => @htmlspecialchars( $_POST['nlposts_theme'] ),
    'nlposts_homepage'      => @htmlspecialchars( $_POST['nlposts_homepage'] ),
);
// Save params
foreach( $options as $option_name => $option ) {
    if( !empty( $option ) )
        $option_obj->nlposts_save_option( $option, $option_name );
}
?>

<div class="nlposts-options-header">
    <div id="nlposts-options-icon" class="icon32"><br></div>
    <h2><?php echo $phrases->nlposts_options_phrase()->dashboard_general_panel;  ?></h2>
</div>

<div class="nlposts-options">
    <form method="post" action="#">
        <?php
            settings_fields( 'nlposts_options_group' );
            do_settings_fields( __FILE__ , 'nlposts_options_group' );
        ?>
        <p>
            <label for="nlposts_deprecated"><?php echo $phrases->nlposts_options_phrase()->option_nlposts_deprecated; ?></label>
        </p>
        <p>
            <select class="nlposts_selector <?php if( get_option( 'nlposts_deprecated' ) === 'yes' ) echo 'warning'; ?>" name="nlposts_deprecated">
                <?php if( get_option( 'nlposts_deprecated' ) === false || get_option( 'nlposts_deprecated' ) === 'yes' ) { ?>
                    <option value="yes" selected="selected"><?php echo $phrases->nlposts_options_phrase()->yes; ?></option>
                    <option value="no"><?php echo $phrases->nlposts_options_phrase()->no; ?></option>
                <?php } elseif( get_option( 'nlposts_deprecated' ) === 'no' ) { ?>
                    <option value="yes"><?php echo $phrases->nlposts_options_phrase()->yes; ?></option>
                    <option value="no" selected="selected"><?php echo $phrases->nlposts_options_phrase()->no; ?></option>
                <?php } ?>
            </select>
        </p>
        <p>
            <label for="nlposts_theme"><?php echo $phrases->nlposts_options_phrase()->option_nlposts_theme; ?></label>
        </p>
        <p>
            <select class="nlposts_selector" name="nlposts_theme">
                <?php
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
        <p>
            <label for="nlposts_load_acf"><?php echo $phrases->nlposts_options_phrase()->option_nlposts_load_acf; ?></label>
        </p>
        <p>
            <select class="nlposts_selector" name="nlposts_load_acf">
                <?php if( get_option( 'nlposts_load_acf' ) === false || get_option( 'nlposts_load_acf' ) === 'yes' ) { ?>
                    <option value="yes" selected="selected"><?php echo $phrases->nlposts_options_phrase()->yes; ?></option>
                    <option value="no"><?php echo $phrases->nlposts_options_phrase()->no; ?></option>
                <?php } elseif( get_option( 'nlposts_load_acf' ) === 'no' ) { ?>
                    <option value="yes"><?php echo $phrases->nlposts_options_phrase()->yes; ?></option>
                    <option value="no" selected="selected"><?php echo $phrases->nlposts_options_phrase()->no; ?></option>
                <?php } ?>
            </select>
        </p>
        <p>
            <label for="nlposts_load_woo"><?php echo $phrases->nlposts_options_phrase()->option_nlposts_load_woo; ?></label>
        </p>
        <p>
            <select class="nlposts_selector" name="nlposts_load_woo">
                <?php if( get_option( 'nlposts_load_woo' ) === false || get_option( 'nlposts_load_woo' ) === 'yes' ) { ?>
                    <option value="yes" selected="selected"><?php echo $phrases->nlposts_options_phrase()->yes; ?></option>
                    <option value="no"><?php echo $phrases->nlposts_options_phrase()->no; ?></option>
                <?php } elseif( get_option( 'nlposts_load_woo' ) === 'no' ) { ?>
                    <option value="yes"><?php echo $phrases->nlposts_options_phrase()->yes; ?></option>
                    <option value="no" selected="selected"><?php echo $phrases->nlposts_options_phrase()->no; ?></option>
                <?php } ?>
            </select>
        </p>

        <?php echo get_submit_button(); ?>
    </form>
</div>
<?php
include_once( 'options-footer.php' );
?>