<?php

/*
Plugin Name: Memepress ( Yahoo! Meme )
Version: 0.2
Plugin URI: http://gofedora.com/memepress/
Description: Provides one or more wordpress widgets for displaying public posts from Yahoo! Meme acounts. Inspired by <a href="http://wordpress.org/extend/plugins/twitter-for-wordpress/">Twitter for Wordpress</a>. Memepress is SEO ready and provides options to noindex and/or nofollow your Yahoo! Meme posts in your widget.
Author: Kulbir Saini 
Author URI: http://gofedora.com/
 */

/*
  Copyright 2009 Kulbir Saini <saini@saini.co.in>

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

// Magpie Options.
define('MAGPIE_CACHE_ON', 1);
define('MAGPIE_CACHE_AGE', 180);
define('MAGPIE_INPUT_ENCODING', 'UTF-8');
define('MAGPIE_OUTPUT_ENCODING', 'UTF-8');

// Memepress Plugin Options.
$memepress_options['widget_fields']['title'] = array('label'=>__('Title:'), 'type'=>'text', 'default'=>__('Memepress'));
$memepress_options['widget_fields']['username'] = array('label'=>__('Username:'), 'type'=>'text', 'default'=>'');
$memepress_options['widget_fields']['count'] = array('label'=>__('Number of links:'), 'type'=>'text', 'default'=>'5');
$memepress_options['widget_fields']['timestamps'] = array('label'=>__('Show timestamps:'), 'type'=>'checkbox', 'default'=>true);
$memepress_options['widget_fields']['link'] = array('label'=>__('Link Posts:'), 'type'=>'checkbox', 'default'=>true);
$memepress_options['widget_fields']['list'] = array('label'=>__('Display Posts as a list:'), 'type'=>'checkbox', 'default'=>true);
$memepress_options['widget_fields']['width'] = array('label'=>'<abbr style="border-bottom: 1px dotted grey;" title="'.__('Leave blank for auto adjustment. Examples: 200px or 50%').'">Width</abbr>:', 'type'=>'text', 'default'=>'');
$memepress_options['widget_fields']['noindex'] = array('label'=>__('Noindex Posts:'), 'type'=>'checkbox', 'default'=>true);
$memepress_options['widget_fields']['nofollow'] = array('label'=>__('Nofollow Posts:'), 'type'=>'checkbox', 'default'=>true);
$memepress_options['widget_fields']['encode_utf8'] = array('label'=>__('UTF8 Encode:'), 'type'=>'checkbox', 'default'=>false);

$memepress_options['prefix'] = 'memepress';


// Render all the Yahoo! Meme Public Posts for a specifif user.
function memepress_render_posts($username = '', $count = 1, $list = false, $timestamps = true, $link  = true, $link_rel = '', $width = '', $encode_utf8 = false) {

  global $memepress_options;
  include_once(ABSPATH . WPINC . '/rss.php');
  $memes = fetch_rss('http://meme.yahoo.com/'.$username.'/feed/en');

  $width = ($width == '') ? '100%' : $width;

  echo '<style id="memepress_Widget_styles" type="text/css">
    .memepress embed {width: '.$width.';height: 100%;}
    .memepress img {width: '.$width.';height: 100%;}
    .memepress-timestamp {font-size: 10px;}'."\n";
  if ($list) {
    echo 'li.memepress-item {background: none; font-size: 12px; font-weight: normal; padding: 4px 0 4px 4px; border-bottom: 1px dotted grey; list-style-type: none;}'."\n";
  }
  else {
    echo 'p.memepress-item {background: none; font-size: 12px; font-weight: normal; padding: 4px 0 4px 4px; border-bottom: 1px dotted grey; list-style-type: none;}'."\n";
  }
  echo '</style>';


  // Start list if 
  if ($list) {
      echo '<ul class="memepress">';
  }
  else {
      echo '<div class="memepress">';
  }

  if ($username == '') {
    if ($list) echo '<li>';
    echo _e('Please provide your Yahoo! Meme username in widget settings.');
    if ($list) echo '</li>';
  } 
  else {
    if ( empty($memes->items) ) {
      if ($list) echo '<li>';
      echo _e('Time to post something on your meme :)');
      if ($list) echo '</li>';
    } 
    else {
      $i = 0;
      foreach ( $memes->items as $meme ) {
        $message = $meme['content']['encoded'];
        if($encode_utf8) $message = utf8_encode($message);
        $memelink = $meme['link'];

        // meme may be text/photo/video/music.
        $list_class = $meme['category'];

        if ($list) echo '<li class="memepress-item memepress-'. $list_class .'">'; elseif ($num != 1) echo '<p class="memepress-item memepress-'. $list_class .'">';

        if($link)  { 
          $message = '<a href="'.$memelink.'" class="memepress-link" '. $link_rel .' >'.$message.'</a>';
        }

        echo $message;

        if($timestamps) {				
          $time = strtotime($meme['pubdate']);
          if ( ( abs( time() - $time) ) < 86400 )
            $human_time = sprintf( __('%s ago'), human_time_diff( $time ) );
          else
            $human_time = date(__('Y/m/d'), $time);

          echo sprintf( __('%s', 'memepress'),' <span class="memepress-timestamp"><abbr title="' . date(__('Y/m/d H:i:s'), $time) . '">' . $human_time . '</abbr></span>' );
        }          

        if ($list) echo '</li>'; elseif ($count != 1) echo '</p>';
        $i++;
        if ( $i >= $count ) break;
      }
    }
  }
  if ($list) {
?>
  <li style="font-size: 9px; list-style-type: none !important; background: none !important; list-style-image: none;"><?php _e('Powered by'); ?> <a style="text-decoration: none;" href="http://gofedora.com/memepress/">Memepress</a></li>
<?php
  }
  else {
?>
  <p style="font-size: 9px; background: none !important;"><?php _e('Powered by'); ?> <a style="text-decoration: none;" href="http://gofedora.com/memepress/">Memepress</a></p>
<?php
  }
  // Close list
  if ($list) {
      echo '</ul>';
  }
  else {
      echo '</div>';
  }
}


// Memepress widget
function widget_memepress_init() {
  // No sidebar :((
  if ( !function_exists('register_sidebar_widget') )
    return;

  $check_options = get_option('widget_memepress');
  if ($check_options['number']=='') {
    $check_options['number'] = 1;
    update_option('widget_memepress', $check_options);
  }

  function widget_memepress($args, $number = 1) {
    global $memepress_options;
    extract($args);
    include_once(ABSPATH . WPINC . '/rss.php');
    $options = get_option('widget_memepress');
    $item = $options[$number];
    foreach($memepress_options['widget_fields'] as $key => $field) {
      if (! isset($item[$key])) {
        $item[$key] = $field['default'];
      }
    }

    //$memes = fetch_rss('http://meme.yahoo.com/'.$item['username'].'/feed/en');

    // Formulate rel attribute for links.
    $link_rel = '';
    if ($item['noindex'] && $item['nofollow'])
      $link_rel = ' rel="noindex,nofollow" ';
    else if ($item['noindex'])
      $link_rel = ' rel="noindex" ';
    else if ($item['nofollow'])
      $link_rel = ' rel="nofollow" ';

    // Render everything.
    echo $before_widget . $before_title . '<a href="http://meme.yahoo.com/' .$item['username']. '" ' . $link_rel . ' class="memepress-title">'. $item['title'] . '</a>' . $after_title;
    memepress_render_posts($item['username'], $item['count'], $item['list'], $item['timestamps'], $item['link'], $link_rel, $item['width'], $item['encode_utf8']);
    echo $after_widget;
  }

  function widget_memepress_control($number = 1) {
    global $memepress_options;
    $options = get_option('widget_memepress');
    if ( isset($_POST['memepress-submit']) ) {
      foreach($memepress_options['widget_fields'] as $key => $field) {
        $options[$number][$key] = $field['default'];
        $field_name = sprintf('%s_%s_%s', $memepress_options['prefix'], $key, $number);
        if ($field['type'] == 'text') {
          $options[$number][$key] = strip_tags(stripslashes($_POST[$field_name]));
        } elseif ($field['type'] == 'checkbox') {
          $options[$number][$key] = isset($_POST[$field_name]);
        }
      }
      update_option('widget_memepress', $options);
    }

    foreach($memepress_options['widget_fields'] as $key => $field) {
      $field_name = sprintf('%s_%s_%s', $memepress_options['prefix'], $key, $number);
      $field_checked = '';
      if ($field['type'] == 'text') {
        $field_value = htmlspecialchars($options[$number][$key], ENT_QUOTES);
      } 
      if ($field['type'] == 'checkbox') {
        $field_value = 1;
        if ($options[$number][$key] == true) {
          $field_checked = 'checked="checked"';
        }
      }
      printf('<p style="text-align:left;" class="memepress_field"><label for="%s">%s <input id="%s" name="%s" type="%s" value="%s" class="%s" %s /></label></p>', $field_name, __($field['label']), $field_name, $field_name, $field['type'], $field_value, $field['type'], $field_checked);
    }
    echo '<input type="hidden" id="memepress-submit" name="memepress-submit" value="1" />';
  }

  function widget_memepress_setup() {
    $options = $newoptions = get_option('widget_memepress');
    if ( isset($_POST['memepress-number-submit']) ) {
      $number = (int) $_POST['memepress-number'];
      $newoptions['number'] = $number;
    }
    if ( $options != $newoptions ) {
      update_option('widget_memepress', $newoptions);
      widget_memepress_register();
    }
  }

  function widget_memepress_page() {
    $options = $newoptions = get_option('widget_memepress');
?>
    <div class="wrap">
      <form method="post">
        <h2><?php _e('Memepress Widgets for Yahoo! Meme Public Posts'); ?></h2>
        <p><?php _e('Select the number of Memepress Widgets?'); ?>
        <select id="memepress-number" name="memepress-number" value="<?php echo $options['number']; ?>">
  <?php for ( $i = 1; $i < 5; ++$i ) echo "<option value='$i' ".($options['number']==$i ? "selected='selected'" : '').">$i</option>"; ?>
        </select>
        <span class="submit"><input type="submit" name="memepress-number-submit" id="memepress-number-submit" value="<?php echo attribute_escape(__('Save')); ?>" /></span></p>
      </form>
    </div>
<?php
  }

  function widget_memepress_register() {
    $options = get_option('widget_memepress');
    $dims = array('width' => 300, 'height' => 300);
    $class = array('classname' => 'widget_memepress');
    for ($i = 1; $i <= 4; $i++) {
      $name = sprintf(__('Memepress Widget %d'), $i);
      $id = "memepress-".$i;
      wp_register_sidebar_widget($id, $name, $i <= $options['number'] ? 'widget_memepress' :  /* unregister */ '', $class, $i);
      wp_register_widget_control($id, $name, $i <= $options['number'] ? 'widget_memepress_control' :  /* unregister */ '', $dims, $i);
    }
    add_action('sidebar_admin_setup', 'widget_memepress_setup');
    add_action('sidebar_admin_page', 'widget_memepress_page');
  }
  widget_memepress_register();
}

add_action('widgets_init', 'widget_memepress_init');

?>
