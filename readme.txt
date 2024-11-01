=== Plugin Name ===
Contributors: fluiditystudio
Donate link: 
Tags: catfish ad
Requires at least: 2.0.2
Tested up to: 3.3
Stable tag: 0.7

A Catfish style advertisement that comes up from the bottom of the screen.

== Description ==

This plugin provides a basic catfish style advertisement that comes up from the bottom of the screen.

The user can enter whatever text they like and change the color of the background and text styles. They can also choose a location to where the ad will click through to.

== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload the entire `catfishad_basic` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Configure the plugin, and edit text/settings via the "Catfish-Ad" menu on the main menu bar.

== Frequently Asked Questions ==

= Why do embeded videos go over the top of my catfish ad? =

This would be because the embedded video needs a "wmode="transparent" placed in the embed tag.

Example: <embed src="" type="application/x-shockwave-flash" width="560" height="410" allowscriptaccess="always" allowfullscreen="true" wmode="transparent"></embed>

= Why won't my ad show up? =

If you hit return when typing the text of your ad, then it will not show up. You need to run your scentences together (See video tutorial link on settings page).

== Changelog ==

= 0.1 =
* Initial Release

= 0.2 =
* Changed some folder structure and fixed some jquery conflicts.

= 0.4 =
* goofed in sending up 0.2 & 0.3

= 0.5 =
* Icon for main menu tab never got added.

= 0.6 =
* Corrected issues that developed from the WP version 3.3 update.

= 0.7 =
* additional corrections since WP version 3.3 update.