<?php
/*
  Plugin Name: Live Chat
  Plugin URI: https://www.bigsociety.com/LiveChatWidget
  Description: Live Chat Widget
  Version: 1.0
  Author: bigsociety
  Author URI: https://www.bigsociety.com
  License: GPLv2
 */

class Live_Chat extends WP_Widget {

    //process the new widget
    public function __construct() {
        $option = array(
            'classname' => 'live_chat',
            'description' => 'Live Chat Widget'
        );
        $this->WP_Widget('Live_Chat', 'Live Chat', $option);
    }

//build the widget settings form
    function form($instance) {
        echo 'Live Chat';
    }

//save the widget settings
    function update($new_instance, $old_instance) {

        return $old_instance;
    }

//display the widget
    function widget($args, $instance) {
		
		

        echo $before_widget;
		 $current_user = wp_get_current_user();
		 $nameUser=$current_user->user_login;
		  if ($nameUser=="") {
				 $nameUser="user unknown";
			 }
		 echo '<script type="text/javascript">var nameUserWP="'.$nameUser.'";</script>';
		 if (get_option('refresh_time')) {
			echo '<script type="text/javascript">var refreshTimeBG='.get_option('refresh_time').'</script>';
		 } else {
			echo '<script type="text/javascript">var refreshTimeBG=5000'.'</script>';
		 }
        echo '<style>#chatcontent { visibility:hidden ; position:fixed; top: 50%; left: 50%; width:50%; height:20%; margin-top: -19em; margin-left: -15em; border: 1px solid #ccc; background-color: grey; }</style>';
		echo '<div id="chatcontent">Live  Audio Video Text ChatRoom (Beta)<img onClick="closeChat()" style="width:20px;float:right" src="'.plugins_url( 'img/close.png', __FILE__ ).'"/></div>';
		echo '<script type="text/javascript" src="https://www.bigsociety.com/chat6/js/all.js" ></script>';
		echo '<script type="text/javascript">function displayChat() { document.getElementById("chatcontent").style.visibility="visible" ;launchChat();}</script>';
		echo '<script type="text/javascript">function closeChat() { document.getElementById("chatcontent").style.visibility="hidden" ;stopChat();}</script>';		
		echo '<button onClick="displayChat()">Enter in the Live Chat</button>';
        echo $after_widget;
    }

}




add_action('widgets_init', 'live_chat_register');

/**
 * Register the widget
 * 
 * @since 1.0
 */
function live_chat_register() {

    register_widget('Live_Chat');
}




add_action('admin_menu', 'live_chat_setup_menu');
 
function live_chat_setup_menu(){
        add_menu_page( 'Live Chat Page', 'BigSociety LiveChat', 'manage_options', 'live-chat', 'bgchat_init' );
}
 
function bgchat_init(){
	
        echo "<h1>Bigsociety Live Chat Settings</h1>";
		echo '<br/>';
		echo 'Any questions? Customization needs?  go to <a href="https://www.bigsociety.com/contact/">Bigsociety contact page<a>';
		?>
			<div class="wrap">
			<h1>Options</h1>
			<form method="post" action="options.php">
				<?php
					settings_fields("section");
					do_settings_sections("bigsociety-options");      
					submit_button(); 
				?>          
			</form>
			</div>
		<?php
		
}


function display_video_enabled()
{
	?>
    	<input type="checkbox" name="video_enabled" id="video_enabled" value="1"  <?php checked(1, get_option('video_enabled'), true); ?> />
    <?php
}

function display_audio_enabled()
{
	?>
    	<input type="checkbox" name="audio_enabled" id="audio_enabled" value="1" <?php checked(1, get_option('video_enabled'), true); ?> />
    <?php
}

function display_refresh_time()
{
	?>
    	<select name="refresh_time">
		  <option value="300" <?php selected(get_option('refresh_time'), "1000"); ?>>Every 300 ms</option>
          <option value="1000" <?php selected(get_option('refresh_time'), "1000"); ?>>Every second</option>
          <option value="5000" <?php selected(get_option('refresh_time'), "5000"); ?>>Every 5 seconds</option>
          
        </select>
    <?php
}

function display_chat_title()
{
	?>
    	<input type="text" name="chat_title" id="chat_title" value="<?php echo get_option('chat_title'); ?>" />
    <?php
}

function display_bigsocietylivechat_fields()
{
	add_settings_section("section", "All Settings", null, "bigsociety-options");
	
	
	//add_settings_field("video_enabled", "Video enabled", "display_video_enabled", "bigsociety-options", "section");
   // add_settings_field("audio_enabled", "Audio enabled", "display_audio_enabled", "bigsociety-options", "section");
	add_settings_field("refresh_time", "Video Refresh Time", "display_refresh_time", "bigsociety-options", "section");
	add_settings_field("chat_title", "Chat title", "display_chat_title", "bigsociety-options", "section");

    //register_setting("section", "video_enabled");
    //register_setting("section", "audio_enabled");
	register_setting("section", "refresh_time");
}

add_action("admin_init", "display_bigsocietylivechat_fields");










?>