<?php
/*
Plugin Name: Adsense for Authors(AFA)
Plugin URI: http://techtuft.com/forum/adsense-for-authors/
Description: The plugin enables revenue sharing for authors on your wordpress site.
Version: 1.0
Author: Plato P.
Author URI: http://www.techtuft.com
License: GPL2
*/
?>
<?php
/*  Copyright 2015  Plato P.  (email : plato.puthur@gmail.com)
    This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License, version 2, as published by the Free Software Foundation.
    This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
    You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
?>
<?php require_once(plugin_dir_path( __FILE__ ) . 'widgetad.php'); ?>
<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );?>
<?php add_filter('the_content', 'adsense_ad');
add_action('admin_menu', 'adsense_for_authors_admin_page');
function adsense_for_authors_admin_page() {
  add_menu_page('Adsense for Authors Settings','AFA Settings','manage_options','afa_page','adsenseforshare_admin','dashicons-groups');
  //add_submenu_page('afa_page','AFA Admin','AFA Admin Settings','manage_options','afa_page2','adsenseforshare_admin2');
  //add_submenu_page('AFA Admin','AFA Admin Settings','manage_options','afa_page2','adsenseforshare_admin2');
}
function adsenseforshare_admin() { ?>
  <h2>Adsense for Authors Settings</h2>
  Set the adslot and the position of the ad here.
  <form name="pubIdForm" action="options.php" method="post">
    <?php settings_fields('afa_option_group');
    do_settings_sections('afa_page'); ?>
    <input class="afa_submit_buttom" name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
  </form>
<?php  /* $options = get_option('afa_option_name');
  echo '<br /><h3>Current Admin Settings</h3>';
  echo 'Adslot given by Lemonoid Staff:<b>';
  echo $options['adslotid'];
  echo '<br />';
  echo '</b>Adsense Ads will be displayed at the following spots in your post: <b> ';
  echo $options['adposition'];*/
}
add_action( 'admin_init', 'afa_settings' );
function afa_settings() {
  register_setting( 'afa_option_group', 'afa_option_name','afa_register_callback' );
  //register_setting( 'afa_option_group2', 'afa_option_name2','afa_register_callback2' );
  add_settings_section( 'afa_section1', '', 'afa_section_callback', 'afa_page' );
  //add_settings_section( 'afa_section2', '', 'afa_section_callback2', 'afa_page2' );
  //add_settings_field( 'adslotid', 'Ad Slot', 'afa_adslot', 'afa_page', 'afa_section1' );
  add_settings_field( 'adposition', 'Position of the adspot', 'afa_position', 'afa_page', 'afa_section1' );
  add_settings_field( 'adpubid', 'Adsense Pub ID', 'afa_adpub', 'afa_page', 'afa_section1' );
}
function afa_position() {
  $options = get_option('afa_option_name');
  //echo "<input id='afa_section1' name='afa_option_name[adposition]' size='25' type='text' value='{$options['adposition']}' /><br>"; ?>
  <select id='afa_section1' name="afa_option_name[ad_position]">
      <option value='Top' <?php selected( $options['ad_position'], 'Top' ); ?>>Top Spot</option>
      <option value='Bottom' <?php selected( $options['ad_position'], 'Bottom' ); ?>>Bottom Spot</option>
      <option value='Disabled' <?php selected( $options['ad_position'], 'Disabled' ); ?>>Disabled</option>
  </select>
<?php }
/*function afa_adslot() {
  $options = get_option('afa_option_name');
  //echo "<input id='plugin_text_string' name='plugin_options[text_string]' size='40' type='text' value='{$options['text_string']}' />";
  echo "<input id='adslotid' name='afa_option_name[adslot_id]' size='25' type='text' value='{$options['adslot_id']}' /><br>";
}*/
function afa_adpub() {
  $options = get_option('afa_option_name');
  //echo "<input id='plugin_text_string' name='plugin_options[text_string]' size='40' type='text' value='{$options['text_string']}' />";
  echo "<input id='adpubid' name='afa_option_name[adpub_id]' size='25' type='text' value='{$options['adpub_id']}' /><br>";
}
function afa_register_callback($input) {
  /*$newinput['adslot_id'] = trim($input['adslot_id']);
  if(!preg_match('/^[a-z0-9]{32}$/i', $newinput['adslot_id'])) {
    $newinput['adslot_id'] = '';
  }*/
  return $input;
}
function afa_register_callback2($input) {
  /*$newinput['adslot_id'] = trim($input['adslot_id']);
  if(!preg_match('/^[a-z0-9]{32}$/i', $newinput['adslot_id'])) {
    $newinput['adslot_id'] = '';
  }*/
  return $input;
}
function afa_section_callback( $arg ) {
  // echo section intro text here
  echo '';
}
function afa_section_callback2( $arg ) {
  // echo section intro text here
  echo '';
}
function add_adslot_text($user) { ?>
  <table class="form-table">
      <tr>
          <th><label for="afa_adslot_id">Adslot ID as given by the staff</label></th>
          <td>
            <input type="text" name="afa_adslot_id" id="afa_adslot_id" value="<?php echo esc_attr( get_the_author_meta( 'afa_adslot_id', $user->ID ) ); ?>" class="regular-text" /><br />
            <span class="description">Add your Adslot ID given by the staff.</span>
          </td>
      </tr>
  </table>
<?php }
function save_adslot_text($user_id) {
  update_usermeta( absint( $user_id ), 'afa_adslot_id', wp_kses_post( $_POST['afa_adslot_id'] ) );
}
function adsense_ad($content) {
  $options = get_option('afa_option_name');

  if (!get_option('afa_option_name')) {
      return $content;
  }
  $position = $options['ad_position'];
  global $post;
  $authorId = $post->post_author;
  $flag = get_the_author_meta( 'afa_adslot_id', $authorId );
  if($flag == "") {
    $flag == "test123";
  }
  $ad_content = '<div align=center><style type="text/css">
.adslot_1 { width: 320px; height: 100px; }
@media (min-width:500px) { .adslot_1 { width: 468px; height: 60px; } }
@media (min-width:800px) { .adslot_1 { width: 728px; height: 90px; } }
</style>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<ins class="adsbygoogle adslot_1"
style="display:inline-block;"
data-ad-client="ca-pub-'.$options['adpub_id'].'";
data-ad-slot="'.$flag.'"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script></div>';
if($position == 'Top') {
  return $ad_content.'<br />'.$content;
} else if($position == 'Bottom') {
  return $content.'<br />'.$ad_content;
} else if($position == 'Disabled') {
  return $content;
}
}
add_action('show_user_profile', 'add_adslot_text' );
add_action('edit_user_profile', 'add_adslot_text');
add_action( 'personal_options_update', 'save_adslot_text' );
add_action( 'edit_user_profile_update', 'save_adslot_text' );
register_activation_hook( __FILE__, 'afa_activate' );
function afa_activate() {
  add_user_meta( $user_id, $meta_key, $meta_value, $unique);
  add_user_meta( $user_id, $meta_key, $meta_value, $unique);
  update_option('afa_option_name[adposition]','Top');
  //update_option('afa_option_name[adslotid]','123');
  update_option('afa_option_name[adpub_id]','123');
}
register_deactivation_hook(__FILE__, 'afa_deactivate' );
function afa_deactivate() {
  delete_option( 'afa_option_name' );
  //delete_option( 'afa_option_name2' );
}?>
