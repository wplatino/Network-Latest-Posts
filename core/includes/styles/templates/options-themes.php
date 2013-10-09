<?php
/**
 * Network Latest Posts
 *
 * @package Network Latest Posts
 * @author José SAYAGO <jose.sayago@laelite.info>
 * @file options-general.php
 *
 * Options : Theme Uploader
 *      Upload themes to be used by the plugin.
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
/**
 * File Handler
 */
if ( ! function_exists( 'wp_handle_upload' ) ) 
	require_once( ABSPATH . 'wp-admin/includes/file.php' );
/**
 * Rewrite Upload Folder
 */
function nlposts_upload_dir( $upload ) {
	$upload['subdir']	= '/' . NLP_THEME_USERN;
	$upload['path']		= $upload['basedir'] . $upload['subdir'];
	$upload['url']		= $upload['baseurl'] . $upload['subdir'];
	return $upload;
}
/**
 * Remove directory recursively
 */
//Delete folder function 
function deleteDirectory( $dir ) { 
    if ( !file_exists( $dir ) ) return true; 
    if ( !is_dir( $dir ) || is_link( $dir ) ) return unlink( $dir ); 
    foreach ( scandir( $dir ) as $item ) { 
        if ( $item == '.' || $item == '..' ) continue; 
        if ( !deleteDirectory( $dir . "/" . $item ) ) { 
            chmod( $dir . "/" . $item, 0777 ); 
            if ( !deleteDirectory($dir . "/" . $item ) ) return false; 
        };
    } 
    return rmdir($dir); 
} 
/**
 * File Upload
 */
if( !empty( $_FILES['nlptheme'] ) ) {
	$filename = $_FILES['nlptheme'];
	$upload_overrides = array( 
		'test_form' => false, 
		'mimes' => array(
			'zip' => 'application/zip, application/octet-stream',
		) 
	);
	if( $filename['type'] == 'application/zip' ) {
		// Filter Uploads
		add_filter('upload_dir', 'nlposts_upload_dir');
		// Upload file
		$movefile = wp_handle_upload( $filename, $upload_overrides, null );
		if ( $movefile ) {
			$error = 0;
			$message = $phrases->nlposts_options_phrase()->dashboard_themes_success;
			// Load Filesystem Class
			WP_Filesystem();
		    // Full ZIP Path
		    $zipfile = $movefile['file'];
		    // Unzip file
		    unzip_file( $zipfile, NLP_THEMES_USER );
		    // Delete ZIP file
		    unlink( $zipfile );
		} else {
			$error = 1;
			$message = $phrases->nlposts_options_phrase()->dashboard_themes_errorm;
		}
		// Remove Filters
		remove_filter('upload_dir', 'nlposts_upload_dir');
	} else {
		$error = 1;
		$message = $phrases->nlposts_options_phrase()->dashboard_themes_error;
	}
}
$header_text = $html5->header_tag( array( 
    'data'      => $phrases->nlposts_options_phrase()->dashboard_themes_panel,
    'structure' => 'h2',
    'class'     => '',
) );
$icon32 = '<div id="nlposts-options-icon" class="icon32"><br></div>';
echo $html5->html5_structure( array( 
    'data'      => $icon32 . $header_text,
    'structure' => array( 'div' ),
    'class'     => 'nlposts-options-header',
) );
/**
 * Delete Theme
 */
if( isset( $_GET['delete'] ) ) {
	$del_path = htmlspecialchars( $_GET['delete'] );
	if( preg_match( '/nlposts_themes/', $del_path ) ) {
		if( deleteDirectory( $del_path ) )
			echo $html5->html5_structure( array( 
			    'data'      => $phrases->nlposts_options_phrase()->theme_deleted,
			    'structure' => array( 'div', 'p' ),
			    'class'     => 'updated',
			) );
		else
			echo $html5->html5_structure( array( 
			    'data'      => $phrases->nlposts_options_phrase()->theme_not_deleted,
			    'structure' => array( 'div', 'p' ),
			    'class'     => 'error',
			) );
	}
}
?>

<div class="nlposts-options">
	<?php
        $themes = array_filter( glob( NLP_THEMES_USER . '*' ), 'is_dir' );
        if( !empty( $themes ) ) {
	        echo '<ul class="nlp-theme-list">';
	        foreach( $themes as $theme ) {
	            if( NLP_ACTIVE_THEME == basename( $theme ) )
	            	echo $html5->html5_structure( array( 
                        'data'      => ucwords( str_replace( '-', ' ', basename( $theme ) ) ),
                        'structure' => array( 'li' ),
                        'class'     => 'active',
                    ) );
	            else {
	            	$delete_link = $html5->link_tag( array(
                        'title'     => $phrases->nlposts_options_phrase()->delete,
                        'href'      => 'admin.php?page=nlposts-theme-installer&amp;delete='.$theme,
                        'text'      => $phrases->nlposts_options_phrase()->delete,
                        'target'    => '_self',
                        'class'		=> 'nlp-theme-del',
                    ) );
	            	echo $html5->html5_structure( array( 
                        'data'      => ucwords( str_replace( '-', ' ', basename( $theme ) ) ) . $delete_link,
                        'structure' => array( 'li' ),
                        'class'     => 'theme',
                    ) );
	            }
	        }
	        echo '</ul>';
	    } else {
	    	echo '<ul class="nlp-theme-list">';
	    	echo $html5->html5_structure( array( 
                        'data'      => $phrases->nlposts_options_phrase()->empty_records,
                        'structure' => array( 'li' ),
                        'class'     => 'theme'
            ) );
	    	echo '</ul>';
	    }
		if( !empty( @$message ) ) {
			if( @$error > 0 )
				$message_class = 'error';
			else
				$message_class = 'updated';
			echo $html5->html5_structure( array( 
			    'data'      => $message,
			    'structure' => array( 'div', 'p' ),
			    'class'     => $message_class,
			) );
		}
	?>
    <form method="post" enctype="multipart/form-data" class="wp-upload-form" action="#">
		<p class="install-help">
			<?php echo $phrases->nlposts_options_phrase()->dashboard_themes_help; ?>
		</p>
		<?php wp_nonce_field( 'nlptheme-upload' ); ?>
		<label class="screen-reader-text" for="nlptheme"><?php echo $phrases->nlposts_options_phrase()->dashboard_themes_field; ?></label>
		<input type="file" id="nlptheme" name="nlptheme" />
		<?php submit_button( $phrases->nlposts_options_phrase()->dashboard_themes_install, 'button', 'install-theme-submit', false ); ?>
    </form>
</div>
<?php
if( get_current_screen()->base == 'network-latest-posts_page_nlposts-theme-installer' ) {
	wp_enqueue_script( 'nlposts-admin-ui', plugins_url().NLP_DIR.NLP_CORE_REL.NLP_JS_REL.'theme-install-ui.js' );
	$translations = array(
		'confirm' 		=> $phrases->nlposts_options_phrase()->confirm, 
		'close' 		=> $phrases->nlposts_options_phrase()->close,
		'btn_ok'		=> $phrases->nlposts_options_phrase()->btn_ok,
		'btn_cancel'	=> $phrases->nlposts_options_phrase()->btn_cancel,
	);
	wp_localize_script( 'nlposts-admin-ui', 'object', $translations );
}
include_once( 'options-footer.php' );
?>