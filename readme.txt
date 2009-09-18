=== Memepress - Wordpress Widgets for Yahoo! Meme Public Posts ===
Contributors: kulbirsaini
Tags: widget, yahoo, meme, yahoo meme, sidebar meme, yahoomeme, plugin
Requires at least: 2.1
Tested up to: 3.0
Stable tag: trunk
Donate link: http://gofedora.com/donate/

Provides wordpress widgets for displaying public posts from Yahoo! Meme. Memepress is SEO ready and has options to noindex/nofollow your Meme posts.

== Description ==

Provides wordpress widgets for displaying public posts from [Yahoo! Meme](http://meme.yahoo.com/). Memepress is SEO ready and provides options to noindex/nofollow your Meme posts. Memepress supports internationalization.

**Note:** Yahoo! Meme is still invite only.

**Demo:** Live demo of this plugin can be seen [here](http://gofedora.com/).

**Languages Supported**

1. English (en_US)
2. Turkish (tr_TR) - [Yalcin Erdemir](http://y4lcin.com/)

**Features**

    *  Easy to setup. Copy, Activate, Setup and Go :)
    *  Widget support
    *  No dependencies
    *  Supports all kinda of posts from Yahoo! Meme.
    *  Option to control width of sidebar.
    *  Option to link posts (you may not want to link back to Yahoo! Meme).
    *  Options to noindex/nofollow permalinks to Yahoo! Meme posts.
    *  Display posts as list or using <p> html attribute.
    *  Uniquely identifiable class for text/photo/video/music to control layout via css classes.
    *  Supports internationalization (i18n).

**Translation**
If you are interested in translating Memepress in your language, you have to translate just a few strings :) Download the [memepress.pot (POT) file](http://plugins.svn.wordpress.org/memepress-yahoo-meme/trunk/i18n/memepress.pot) and translate the strings in your language. Email the resulting .pot file to kulbirsaini25 [AT] gmail.com . 

**Example**

*Untranslated*

`#: memepress.php:37`
`msgid "Title"`
`msgstr ""`

*Translated*

`#: memepress.php:37`
`msgid "Title"`
`msgstr "_WHATEVER_TITLE_IS_WRITTEN_AS_IN_YOUR_LANGUAGE_"`

**Usage**

If you use WordPress widgets, just drag the widget into your sidebar and configure. If widgets are not your thing, use the following code to display your public Yahoo! Meme posts:

`<?php memepress__render_posts("username"); ?>`

For more info (options, customization, etc.) visit [the plugin homepage](http://gofedora.com/memepress/ "Memepress ( Yahoo! Meme )").

**Customization**

The plug in provides the following CSS classes:

    * ul.memepress: the main ul (if list is activated)
    * li.memepress-item: the ul items (if list is activated)
    * li.memepress-text: the ul item (if meme post is text)
    * li.memepress-photo: the ul item (if meme post is photo)
    * li.memepress-video: the ul item (if meme post is video)
    * li.memepress-music: the ul item (if meme post is music)
    * .memepress-timestamp: the timestamp span class
    * a.memepress-link: the link class

== Installation ==

1. Unzip memepress-yahoo-meme.zip.
2. Copy memepress folder to wp-content/plugins/ folder.
3. Activate the plugin by visiting wp-admin/plugins.php.
4. Go to wp-admin/widgets.php to add Memepress widget.

== Screenshots ==

1. Memepress (Yahoo Meme) Wordpress Plugin

== Credits ==

[Kulbir Saini](http://gofedora.com/) - This plugin is completely inspired from Twitter for WordPress. Basically the code was just copied and modified to support Yahoo! Meme and then a few more features were added. A lot of credits goes to [Ricardo Gonz�lez](http://rick.jinlabs.com/code/twitter).

[Ronald Heft](http://cavemonkey50.com/) - The plugin is highly based in his Pownce for Wordpress, so the major part of the credits goes to him.

[Michael Feichtinger](http://bohuco.net/blog) - For the multi-widget feature.

[Yalcin Erdemir](http://y4lcin.com/) - For Turkish Translation.

== Contact ==

Suggestion, fixes, rants, congratulations, gifts et al to kulbirsaini25 [at] gmail [dot] com
