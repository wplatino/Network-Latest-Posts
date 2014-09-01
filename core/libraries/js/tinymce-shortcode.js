/**
 * Network Latest Posts
 *
 * @package Network Latest Posts
 * @author José SAYAGO <jose.sayago@laelite.info>
 * @internal nlp_tinymce_button.php
 *
 * TinyMCE Button
 *      This file contains adds a TinyMCE button for 
 *      Network Latest Posts.
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
(function() {
    // Set the plugin
    tinymce.create('tinymce.plugins.nlposts', {
        init : function(ed, url) {
            var getUrl = url.split('/');
            var nlpIcon = getUrl[0]+'//'+getUrl[2]+'/'+getUrl[3]+'/'+getUrl[4]+'/'+getUrl[5]+'/'+getUrl[6]+'/includes/styles/images/menu_icon.png';
            var nlpShortcode = getUrl[0]+'//'+getUrl[2]+'/'+getUrl[3]+'/'+getUrl[4]+'/'+getUrl[5]+'/'+getUrl[6]+'/libraries/nlposts-shortcode.php';
            // Add this button to the TinyMCE editor
            ed.addButton('nlposts', {
                // Button title
                title : 'Network Latest Posts Shortcode',
                // Button image
                image : nlpIcon,
                onclick : function() {
                    // Window size
                    var width = jQuery(window).width(), height = jQuery(window).height(), W = ( 720 < width ) ? 720 : width, H = ( height > 600 ) ? 600 : height;
                    W = W - 80;
                    H = H - 80;
                    tb_show( 'Network Latest Posts Shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=nlposts-form' );
                    // Load form
                    jQuery(function(){
                        // Dynamic load
                        jQuery('#TB_ajaxContent').load( nlpShortcode );
                    });
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        }
    });
    // Run this stuff
    tinymce.PluginManager.add('nlposts', tinymce.plugins.nlposts);
})();