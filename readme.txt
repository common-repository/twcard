=== Twitter TwCard===
Contributors: Harris A
Donate link: http://photos.herobo.com
Tags: twitter,plugin,feed,automatic,twcard
Requires at least: 2.7
Tested up to: 3.0
Stable tag: 2.9.2


== Description == 

TwCard allows blog owners to display a TwitterCard for any twitter user. It’s useful if you want to mention a twitter user. It shows screen name, real name, location,followers,following, and biography.

use shortcode `[twcard sn="X"]`to display a card with default settings.

You can also use `[Twcardf sn="world_surfer"]` to display a detailed card and `[Twcardb sn="world_surfer"]` to display a basic card.

It is necessary to use your twitter username/password to access Twitter API, so make sure you update the settings in the twcard settings page.

Plugin by <a href="http://www.photos.herobo.com">Harris A.</a>


== Changelog ==

= 1.1.2 = 
* Compatible with Wordpress 3.0
* Added 'twitter' before name.
* fixed the header already sent issue.
* Added built in css to save loading time

= 1.1.1 = 
* Changed the HTML output to List Styles for better integartion
* Its optional to use twitter usr/pass, recommended for heavy users

= 1.1 = 
* Removed the authentication option. Now, there is no need to provide a twitter user/pass to use the plugin.  
* Added a Widget for the plugin
* Added option to catch unexpected errors.
* Shows hyperlinks instead of blank now when an error occurs
* improved the CSS

= 1.0.3 = 
* fixed Internet Explorer CSS Issue with a spacer.

= 1.0.2 = 
* detailed card option also available
* Passes XHTML validation
* added [twcardb] and [twcardf] shortcodes
* [twcardb] for basic info (overrides default)
* [twcardf] for full info (overrides default)


= 1.0.1 = 
* Fixed twitter timeout issue
* fixed admin form properties
* improve connection settings to twitter API


= 1.0 = 
* Fixed CSS style
* First version


== Installation ==

-Upload the plugin folder to your `/wp-content/plugins/` folder.
-Go to the Plugins page and activate the plugin.
-Go to `Twcard` options page and enter your twitter information.

== Screenshots ==

1. Short display Card
2. Detailed display Card
3. TwCard Widget


== Upgrade Notice ==

UL style for better integration

== License ==

This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.Go to the following link for more iformation: <http://www.gnu.org/licenses/>.

== Frequently Asked Questions ==

= What is a TwitterCard =

A TwitterCard includes some information about a twitter user from his/her twitter profile.

= How do I display a TwitterCard =

Use the following Code: `[Twcard sn="world_surfer"]` where world_surfer is the screen name.

= The plugin still shows blank =

Make sure you update the 'twcard options' page with your twitter profile information. Also, make sure that you have no spelling errors in the screen name when you use the shortcode. If Twitter is down or twitter user no longer exists, twcard would return blank to prevent showing error codes.

= How do I show a detailed card for one particular Twitter =

use [twcardf sn="X"] for full display mode where X is the screen name.f= Full. this overrides the default setting.

= How do I show a basic card for one particular Twitter =

use [twcardb] to always display in basic mode. for example: [twcardb sn="X"] where X is a screen name. b= Basic.  this overrides the default setting.

= My widget doesnt show the color I entered =

Make sure that when you are entering HTML color codes, you also include' #' sign. for example: #CCCC.

= My widget shows a background image =

you can set the background on/off globally in the TwCard settings.