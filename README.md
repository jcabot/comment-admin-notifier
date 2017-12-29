# comment-admin-notifier
WordPress plugin to enable admins get notifications for new published comments 

=== Plugin Name ===
Contributors: softmodeling
Tags: comments, email, admin, alert, mail, comment
Requires at least: 4.3
Tested up to: 4.9.1
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Admin users get an email alert every time a new comment is posted on ANY post in the site

== Description ==

In the *Discussion* page, authors of a post can use the checkbox *Email me whenever - Anyone posts a comment*.

But this does not send an email as well to the site admins. In blogs where you have a number of guest authors, you may want to be informed about all the new comments so you can respond (if the author is missing) or just participate in the discussion. 

As a site admin myself, I was missing many comments. This means plenty of missing opportunities to engage with your audience.

To solve this situation, the plugin adds a new checkbox in the *Discussion* page. If checked, admins will get an alert email for new comments. 

== Installation ==

1. Upload `plugin-name.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place `<?php do_action('plugin_name_hook'); ?>` in your templates

OR you can just install it with WordPress by going to Plugins &rarr; Add New &rarr; and type this plugin's name

== Changelog ==

= 1.0 =
* Initial release

