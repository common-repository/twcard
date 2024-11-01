<?
/*
Plugin Name: Twitter TwCard
Plugin URI: http://photos.herobo.com
Description: TwCard allows blog owners to display a TwitterCard for any twitter user. It shows screen name, real name, location,bio,followers,following and user icon.
Version: 1.1.2
Author: Harris A.
Author URI: http://photos.herobo.com
License: GPL2
*/

/*
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.Go to the following link for more iformation: <http://www.gnu.org/licenses/>.


*/ ?>
<?
$twcard_curversion = "1.1.2";
// create twcard menu left
add_action('admin_menu', 'twcard_menu');

function twcard_menu() {
add_options_page('TwCard Settings', 'TwCard',administrator,_FILE_,twcard_page);
}
///activation hook
register_activation_hook( __FILE__, 'twcard_default' );
//add admin menu left
add_action('admin_init', 'twcard_default');
function twcard_default() {
	register_setting( 'twcard-setting', 'optionw' );
	register_setting( 'twcard-setting', 'optionz' );
	register_setting( 'twcard-setting', 'optionx' );
	register_setting( 'twcard-setting', 'optiony' );
	     add_option('optionw', '');
        add_option('optionz', '');
		add_option('optionx', '');
		add_option('optiony', '');
}

///activation hook
//admin menu page settings
///admin menu page settings
function twcard_page() {
echo '<div class="wrap">
<h2>TwCard Options</h2>
<form method="post" action="options.php">';
    settings_fields( 'twcard-setting' );
	?>
    <table class="form-table">
	<tr valign="top">
        <th scope="row">Twitter Username</th>
        <td><input type="text" name="optionx" value="<?php echo get_option('optionx'); ?>" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">Twitter Password</th>
        <td><input type="password" name="optiony" value="<? echo get_option('optiony'); ?>" />
        <p>Why Provide Twitter Username/Password? Its optional to give twitter username & pass but if you are having difficulty showing a TwCard, you should use a twitter account. This may be needed if your website is constantly using Twitter API.</p>
</td>
        </tr>
      <tr valign="top">
        <th scope="row">Default Display</th>
        <td>
         <label>
      <select name="optionw" id="optionw">';
       <?
	   $stcheckbw=get_option('optionw');
	   if($stcheckbw>"") { echo '<option value="'.$stcheckbw.'">'.$stcheckbw.'</option>'; }
       echo ' <option value="BASIC">BASIC</option>
        <option value="FULL">FULL</option> </select>
    </label>
        <p>Set Default display mode for the [twcard] shortcode.</p>
            Basic:  <img src="'.WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)).'/basicscreen.gif" />
                Full :<img src="'.WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)).'/fullscreen.gif"/>
</td> </tr> <tr valign="top">
        <th scope="row">Show Background Image:</th>
        <td><label>
      <select name="optionz" id="optionz">';
      $stcheckbx=get_option('optionz');  if($stcheckbx>"") { echo '<option value="'.$stcheckbx.'">'.$stcheckbx.'</option>'; }
       echo '<option value="YES">YES</option>
        <option value="NO">NO</option>
      </select>
    </label>
    Tip: If you would like to change the default background image, save your image as "<b>bkg_twcard.gif</b>" and palce it in the "'.WP_PLUGIN_DIR.'" folder';
echo '</td></tr>
    </table>
<div style="background-color:#CCC; margin: 5px;	padding: 5px;">
 <p>How to use this plugin: Whenever you want to display a TwitterCard, just use the following shortcode:</p>
<p>[twcard sn="world_surfer"] will show a card for the user World_surfer or [twcard sn="
BillGates"] shows a card for Bill Gates. sn means <i>Screen Name</i>, so make sure you use screen names.</p>
<p>You can use the code in pages and posts. You can use the code multiple times in the same page/posts.</p>
<p>If the Twitter service is down, twitter user no longer exists, or the script is unable to connect to the Twitter API service, it will a simple link to the twitter profile.</p>
<p>[twcard] will display in the default mode set above.</p>
<p>If you want to override the default mode. use these codes:</p>
<p> [twcardf sn="X"] for full display mode where X is the screen name.</p>
<p>Or alternatively, [twcardb] to always display in basic mode. for example: [twcardb sn="X"] where X is a screen name.</p>
<p>You can use the Widget from the Appearance > Widgets section.</p>';
 echo '<p class="submit">
 </div>
    <input type="submit" class="button-primary" value="'; ?>
	<?php _e('Save Changes') ?><? echo '" />
    </p>
</form>
</div>';
 }

////twitter option function
function twcard_display($twcardinputdata,$tdisplaymode,$twcardwyes) {
	$sttwcardz=get_option('optionz');
	$sttwcardw=get_option('optionw');
	$sttwcardx=get_option('optionx');
	$sttwcardy=get_option('optiony');
	$hideb=$tdisplaymode;
	try {
     	 $twcard_url_prep = "http://api.twitter.com/1/users/show.xml?screen_name=".$twcardinputdata;
		 $twcard_curl_url =curl_init("$twcard_url_prep");
         curl_setopt($twcard_curl_url, CURLOPT_HEADER, 1);
         curl_setopt($twcard_curl_url,CURLOPT_TIMEOUT, 30);
         curl_setopt($twcard_curl_url,CURLOPT_RETURNTRANSFER,1);
		 if ($sttwcardx > "") {
			 if ($sttwcardy > "") {
				 curl_setopt($twcard_curl_url, CURLOPT_USERPWD, $sttwcardx.':'.$sttwcardy);
			 }
		 }
         $twcard_response=curl_exec ($twcard_curl_url);
		  $twcard_output = strstr($twcard_response, '<?');
		 $twcard_xml = new SimpleXMLElement($twcard_output);
		$twcard_location = $twcard_xml->location;
		$twcard_name= $twcard_xml->name;
		$twcard_screen_name = $twcard_xml->screen_name;
		$twcard_description=$twcard_xml->description;
		$twcard_twprofimgurl=$twcard_xml->profile_image_url;
		$twcard_twweburl=$twcard_xml->url;
		$twcard_followers=$twcard_xml->followers_count;
		$twcard_following=$twcard_xml->friends_count;
		$twcard_tweets=$twcard_xml->statuses_count;
  }
 catch (exception $e) {
	echo'<a href="http://twitter.com/'.$twcardinputdata.'">'.$twcardinputdata.'</a><br />';

  }



// Continue execution

if ( $twcard_location=="" || $twcard_screen_name=="" || $twcard_twprofimgurl=="") {

    if ($twcardwyes=="widget") {
    echo '">';
	echo'<li><span style="font-weight:bold;"><a href="http://twitter.com/'.$twcardinputdata.'">@'.$twcardinputdata.'</a></span><br /></li>';
	echo"</ul>";

} else {
echo'<a href="http://twitter.com/'.$twcardinputdata.'">'.$twcardinputdata.'</a><br />';
}

} else {

if ($twcardwyes<>"widget") {
$twcard_output_option='<ul style="width:240px; list-style:none; margin:0px; padding:0px; list-style-image:none; overflow:hidden;';
}

if ($sttwcardz=="YES") {

$twcard_output_option.=' background-image: url('.WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)).'/bkg_twcard.gif);';

}

$twcard_output_option.='"><li><span style="font-weight:bold;"><a href="http://twitter.com/'.$twcard_screen_name.'">@'.$twcard_screen_name.'</a></span></li>';

$twcard_output_option.='<li style="padding-left:1px; list-style:none; list-style-image:none;"><img alt="'.$twcard_name.'" src="'.$twcard_twprofimgurl.'"  align="left" style="border:0px; padding-left:2px; padding-top: 5px; padding-bottom:5px; padding-right:5px;"  /><img src="'.WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)).'/twicon.gif" alt="Twitter '.$twcard_name.'" style="padding-left:2px; padding-top: 3px;" /><span style="padding-left:5px;">'.$twcard_name.'</span></li>';

$twcard_output_option.='<li style="padding-left:1px; padding-top:3px; padding-right:5px; list-style:none; list-style-image:none;">'.$twcard_location.'</li>';

///low to full

$sttwcardw=get_option('optionw');
		if ($hideb=="FULL") {
			$sttwcardw="FULL";
		} elseif ($hideb=="BASIC") {
			$sttwcardw="BASIC";
		}
if ($sttwcardw=="FULL") {

$twcard_output_option.='<li style=" padding-left:1px; padding-top: 15px; width:225px; float:left; ">'.$twcard_description.'</li>';
$twcard_output_option.='<li style=" float:left; text-align:center; padding-bottom: 15px; padding-top:10px; padding-left:25px; width:50px;">';


if ($twcardwyes=="widget") {

	$twcard_output_option.= number_format($twcard_following);

} else {

$twcard_output_option.= '<a href="http://twitter.com/'.$twcard_screen_name.'/following">'.number_format($twcard_following).'</a>';

}
$twcard_output_option.= '<br /> Following</li>';

$twcard_output_option.='<li style="float:left; text-align: center; padding-bottom: 15px; padding-top:10px; padding-left:50px; width:50px;">';

if ($twcardwyes=="widget") {
	$twcard_output_option.= number_format($twcard_followers);

} else {
$twcard_output_option.= '<a href="http://twitter.com/'.$twcard_screen_name.'/followers">'.number_format($twcard_followers).'</a>';
}
$twcard_output_option.=' <br />Followers</li>';

}

$twcard_output_option.='</ul>';

}
echo "$twcard_output_option";
 }
?>
<?php
///widget controls
function twcard_widget($args) {
  extract($args);
  $savedsettings = get_option("twcard_widget");
  echo $before_widget;
  echo $before_title;?><? echo $savedsettings['_twcardwtitle']; ?><?php echo $after_title;
  twcard_widgetcont();
  echo $after_widget;
}
function twcard_widget_control() {
 if ($_POST['twcardupdateopt'])
  {
	  $twcard_widget_options['_twcardwtitle'] = htmlspecialchars($_POST['_twcardwtitle']);
	  $twcard_widget_options['_twcardsn'] = htmlspecialchars($_POST['_twcardsn']);
	  $twcard_widget_options['_twcarddisp'] = htmlspecialchars($_POST['_twcarddisp']);
	  $twcard_widget_options['_twcardwbkgcol'] = htmlspecialchars($_POST['_twcardwbkgcol']);
	 update_option("twcard_widget", $twcard_widget_options);
  }
$savedsettings = get_option("twcard_widget"); ?>
    <table>
     <tr >
        <th>Title:</th>
<td><input type="text" name="_twcardwtitle" value="<? echo $savedsettings['_twcardwtitle']; ?>" />
    </td></tr>
          <tr >
        <th>Background-color:</th>
<td><input type="text" name="_twcardwbkgcol" value="<? echo $savedsettings['_twcardwbkgcol']; ?>" />
    </td></tr>
        <tr >
        <th>Screen Name:</th>
<td><input type="text" name="_twcardsn" value="<? echo $savedsettings['_twcardsn']; ?>" />
    </td></tr>
         <tr>
    <th>Display:</th>
   <td>
   <label>
 <select name="_twcarddisp" id="_twcarddisp">
 <?
$stcheckbxdisp=$savedsettings['_twcarddisp'];  if($stcheckbxdisp>"") { echo '<option value="'.$stcheckbxdisp.'">'.$stcheckbxdisp.'</option>'; } ?>
      <option value="BASIC">BASIC</option>
        <option value="FULL">FULL</option>
      </select>
    </label>
    <input type="hidden" id="twcardupdateopt" name="twcardupdateopt" value="1" />

    </td>
    </tr>
 </table>

<?php }
///widget display function
function twcard_widgetcont()
{
	$savedsettings = get_option("twcard_widget");
	echo '<ul style="width:240px; list-style:none; margin:0px; padding:0px; list-style-image:none; overflow:hidden;';
	$bgkcolor=$savedsettings['_twcardwbkgcol'];

if ($bkgcolor>"") {
	echo 'background-color:'.$bkgcolor;
}
twcard_display($savedsettings['_twcardsn'],$savedsettings['_twcarddisp'],'widget');
}
function load_twcardw()
{
	        if (function_exists('register_sidebar_widget'))
        {
              register_sidebar_widget(__('TwCard'), 'twcard_widget');
        }
		  if (function_exists('register_widget_control'))
        {
            register_widget_control( 'TwCard', 'twcard_widget_control', 250, 200 );
        }
}
 //main function
function twcardf_func($twcard_data) {
	extract(shortcode_atts(array(
		'sn' => '',
	), $twcard_data));
	if (empty($twcard_data)) {
    echo "";
} else {
	$twcard_sn=$twcard_data[sn];
	ob_start();
	twcard_display($twcard_sn,'FULL','0');
	$twcard_output_record=ob_get_contents();;
	ob_end_clean();
	return $twcard_output_record;
}
}

function twcardb_func($twcard_data) {
	extract(shortcode_atts(array(
		'sn' => '',
	), $twcard_data));
	if (empty($twcard_data)) {
    echo "";
} else {
	$twcard_sn=$twcard_data[sn];
	ob_start();
	twcard_display($twcard_sn,'BASIC','0');
	$twcard_output_record=ob_get_contents();;
	ob_end_clean();
	return $twcard_output_record;
}
}
function twcard_func($twcard_data) {
	extract(shortcode_atts(array(
		'sn' => '',
	), $twcard_data));
if (empty($twcard_data)) {
    echo "";
} else {
	$twcard_sn=$twcard_data[sn];
	//////////////// prevent infinite loops
	$twcarddefmode=get_option('optionw');
	ob_start();
	twcard_display($twcard_sn,$twcarddefmode,'0');
	$twcard_output_record=ob_get_contents();;
	ob_end_clean();
	return $twcard_output_record;
}
}
add_action("plugins_loaded", "load_twcardw");
add_shortcode('twcard', 'twcard_func');
add_shortcode('twcardb', 'twcardb_func');
add_shortcode('twcardf', 'twcardf_func');
?>