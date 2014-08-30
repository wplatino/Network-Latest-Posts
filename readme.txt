=== Network Latest Posts ===
Contributors: iluminatus
Donate link: http://laelite.info
Tags: recent posts, shortcode, widget, network, latest posts
Requires at least: 3.0
Tested up to: 3.6.1
Stable tag: 4.0

This plugin allows you to pull all the recent posts from the blogs in your WordPress network and display them in your main site (or internal sites)

== Description ==



== Installation ==

1. Upload `network-latest-posts folder` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. If you want to use the Widget, you can add the Network Latest Posts widget under 'Appearance->Widgets'
4. If you want to use the Shortcode, go to a page or post then click the NLPosts icon (green button in the TinyMCE editor) or use [nlposts] (that's it, seriously!)

== Options ==


== Changelog ==

= 3.5.4 =
* Support for date localization (specially in german) using i18n, thanks to Claas Augner for the patch.

= 3.5.3 =
* Fixing line returns when using display_content parameter. Mixing nl2br and do_shortcode to do the job.

= 3.5.2 =
* Replacing nl2br by do_shortcode to fix an incompatibility issue with Vipers shortcodes.

= 3.5.1 =
* Added catch to avoid warnings when NLPosts can't find posts matching your parameters. Now it will display a message letting you know, no posts matching your criteria were found.

= 3.5 =
* Added parameter display_content which allows you to display posts content instead of excerpts, minor bug fixes

= 3.4.6 =
* Added parameter thumbnail_url which you can use to specify a custom thumbnail filler, this parameter must be a URL address

= 3.4.5 =
* Adding missing strings to Norwegian translation, thanks to kkalvaa

= 3.4.4 =
* Replacing language loadtext order to avoid some strings being ignored by translation files, thanks to kkalvaa for spotting this and contributing with the Norwegian Bokmål translation!

= 3.4.3 =
* Fixed bug while using sort_by_date and sort_by_blog, sorting capabilities were not working properly. Thanks to Julien Dizdar for reporting this bug.

= 3.4.2 =
* Fixing typo in $thumbnail_custom variable
* Added German language provided by Claas Augner

= 3.4.1 =
* Added CSS class 'nlposts-siteid-x' to each element so they can be styled depending on which blog they were pulled from

= 3.4 =
* NEW Feature: Ignore posts by ID. Now you can ignore certain posts by their IDs ex: post_ignore=1 ignores all "Hello World" posts

= 3.3.2 =
* Added post title to alt and title tags for thumbnails

= 3.3.1 =
* Fixing Display Blogs and Ignore Blogs lists in the Shortcode form

= 3.3 =
* NEW Feature: order by blog ID. Now you can sort by blog ID using sort_by_blog=true and sorting_order=asc or sorting_order=desc

= 3.2.1 =
* Bug fixed. Excerpts were being taken from content only and not from excerpts fields

= 3.2 =
* NEW Feature added Custom Thumbnail `thumbnail_custom`, `thumbnail_field` which allows you to specify custom fields for thumbnails

= 3.1.7 =
* Fixing a bug when placed before comments forms.

= 3.1.6 =
* Due to an incompatibility issue between the Visual Composer plugin and the WordPress hook strip_shortcodes, NLposts is using regex now.

= 3.1.5 =
* Replacing `wp_enqueue_scripts` by `admin_enqueue_scripts` to solve styling issues in the TinyMCE button

= 3.1.4 =
* Fixed notice for `wp_register_style` when debug has been turned on

= 3.1.3 =
* NEW Feature added `random` allows you to pull random posts from database

= 3.1.2 =
* Register ids changed to better identify NLPosts

= 3.1.1 =
* Patch for fixing `wp_register_sidebar_widget` and `wp_register_widget_control` thanks to cyberdemon8

= 3.1 =
* It's now possible to specify multiple custom types (comma separated)
* Two deprecated functions `register_sidebar_widget` and `register_widget_control` were updated to add the new prefix `wp_` used since WordPress version 2.8

= 3.0.9 =
* Custom post type variable fixed, it was using post_type instead of custom_post_type thanks to ricardoweb for spotting this

= 3.0.8 =
* Adding translation domain to the full meta strings.

= 3.0.7 =
* Fixed excerpt functions, the excerpt_length parameter wasn't pulling the right number of words, if not specified 55 words will be used by default (WordPress defaults)

= 3.0.6 =
* Fixed Shortcode's JavaScript function when used through the TinyMCE editor, there was a problem when using multiple categories or tags. It also inserted the thumbnail_w & thumbnail_h which aren't needed.

= 3.0.5 =
* Added wrapper_list_css & wrapper_block_css, these parameters permit to customize the CSS classes for the wrapper tag
* Fixed minor bug in the Shortcode TinyMCE form which inserted the Submit button to the list of parameters

= 3.0.4 =
* Adding Blog name to the meta info when using Widgets
* Added shortcode form CSS styles

= 3.0.3 =
* Adding Blog name to the meta info

= 3.0.2 =
* Fixing call to the widget class from the shortcode form, the TinyMCE shortcode button should be working now

= 3.0.1 =
* Bug "Problem with 3.0, unexpected T_FUNCTION" Fixed, add_action on line 1092 modified to provide compatibility with PHP versions &lt; 5.3

= 3.0 =
* Network Latest Posts was totally rewritten, it no longer uses Angelo's code. WordPress hooks took its place. All the nasty hackery and workarounds
  are gone.
* Support for RTL installations added.
* Sorting capabilities added, it's now possible to display the latest posts first regardless the blogs they were found.
* Name changed for some parameters to match their functionality.
* Some parameters no longer exist (display_root, wrapo, wrapc) they are no longer useful
* Thumbnail size, class and replacement added
* Display type added, 3 styles by default, it makes it easier for people with limited CSS knowledge to tweak the visual appearance.
* Fixed some bugs in the auto_excerpt function
* CSS style allows you to use your own css file to adapt the output to your active theme (when used it will unload the default styles)
* Instance is used to include multiple instances in the same page as a widget or as a shortcode, fixing the pagination bug which didn't work when used multiple times.
* Widget now includes multi-instance support extending the WP_Widget class, you can added as many times as you want to all your widgetized zones.
* Shortcode button added to the TinyMCE editor, now you just need to fill the form and it will insert the shortcode with the parameters into the post/page content.
* Renamed some functions to avoid incompatibility with other plugins using default function names.
* Main folders and sub-folder installations supported.

= 2.0.4 =
* NEW feature added `auto_excerpt` will generate an excerpt from the post's content
* NEW feature added `full_meta` will display the author's display name, the date and the time when the post was published

= 2.0.3 =
* Excerpt Length proposed by Tim (trailsherpa.com)
* It's possible now to display the posts published in the main blog (network root) using the display_root parameter

= 2.0.2 =
* Bug fix: When using only one category only one article from each blog was displayed. Now it displays the number specified with the `number`
parameter as expected - Thanks to Marcalbertson for spotting this

= 2.0.1 =
* Added missing spaces before "published in" string: Lines 347, 358 & 399 - Spotted by Josh Maxwell

= 2.0 =
* NEW feature added `cat` which allows you to filter by one or more categories - Proposed by Jenny Beaumont
* NEW feature added `tag` which allows you to filter by one or more tags - Proposed by Jenny Beaumont
* NEW feature added `paginate` which allows you to paginate the results using the number parameter as the number of results to display by page
* NEW CSS file added
* NEW img folder added

= 1.2 =
* Fixed the repeated `<ul></ul>` tags for the widget list
* NEW feature added `cpt` which allows you to display a specific post's type (post, page, etc) - Proposed by John Hawkins (9seeds.com)
* NEW feature added `ignore_blog` which allows you to ignore one or various blogs' ids - Proposed by John Hawkins (9seeds.com)
* Added the Domain name with the IDs to the list of blog ids in the Widget
* Some other minor bugs fixed

= 1.1 =
* Fixed the missing `<ul></ul>` tags for the widget list
* NEW feature added `blogid` which allows you to display the latest posts for a specific blog
* NEW feature added `thumbnail` to display the thumbnail of each post
* The widget includes now a list where you can select the blog's id for which you want to display the latest posts

= 1.0 =
* Added Widget option to display excerpt
* Markup improved to make CSS Styling easier
* Added Uninstall hook
* Added Shortcode functionality
* Plugin based in Multisite Recent Posts Widget

== Screenshots ==
1. NLPosts Shortcode in Edit Page
2. NLPosts Insert Shortcode Form
3. NLPosts Shortcode Output
4. Results by Page
5. NLPosts Multi-instance Widget
6. NLPosts Widget: Some Options
7. NLPosts Sidebar Widget Area
8. NLPosts Footer Widget Area
9. NLPosts in RTL Installation
10. NLPosts Shortcode & Widget in RTL

== Frequently Asked Questions ==

