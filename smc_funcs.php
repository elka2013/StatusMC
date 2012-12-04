<?php
/*
Plugin Name: StatusMC
Plugin URI: http://sync667.com/
Description: Wyświetla informacje odnośnie serwera bukkit poprzez JSONAPI.//Its shows server status via JsonAPI Plugin.
Version: 1.1
Author: sync667 - sync667@gmail.com
Author URI: http://sync667.com/
License: GPL3
*/

/*
 * StatusMC Widget
 * Copyright (C) 2012 sync667 - sync667@gmail.com
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

defined('ABSPATH') or die("Cannot access pages directly.");

add_action( 'widgets_init', create_function( '', 'register_widget("StatusMC");' ) );

class StatusMC extends WP_Widget
{
	function StatusMC() {
		$widget_ops = array( 
			'classname' => 'StatusMC', 
			'description' => 'Wyświetla informacje odnośnie serwera bukkit poprzez JSONAPI.//Its shows server status via JsonAPI Plugin.' 
		);
		$this->WP_Widget( 'StatusMC', 'StatusMC', $widget_ops );
	}
	
	function widget($args, $instance) {
		extract( $args );

		$title = apply_filters('widget_title', $instance['title'] );
		$smc_ip = $instance['smc_ip'];
		$smc_port = $instance['smc_port'];
                $smc_login = $instance['smc_login'];
                $smc_pass = $instance['smc_pass'];
                $smc_salt = $instance['smc_salt'];

		echo $before_widget;
		
	    if ( $title ) echo $before_title.$title.$after_title;
	
                require('JSONAPI.php');
            
		$api = new JSONAPI($smc_ip, $smc_port, $smc_login, $smc_pass, $smc_salt);
		
                // Pobieranie wartosci przez API
                /*var_dump(*/$data_server1 = $api->call(getPlayerLimit)/*)*/; // Pobieranie danych o serwerze 
                /*var_dump(*/$data_server2 = $api->call(getPlayerCount)/*)*/; // Pobieranie ilosci graczy aktualnie
                
                $sloty = $data_server1["success"];
                $players = $data_server2["success"];
                
                if ($api == NULL) {
			echo "<div><b><center>Serwer <font color='red'>offline</font>...</center></b></ br></div>";
                        echo "<div><center>IP: $smc_ip</center></div>";
		} else {
			echo "<div><b><center>Serwer <font color='green'>online</font> :)</center></b>";
                        echo "<center><b>IP: <font color='blue'>$smc_ip</font></b></center><br /></div>";
			echo "<center><div><b>Graczy: </b>$players / $sloty</div></center>";
				
                        //TODO Lista graczy online
                        /*$players=//lista graczy//;
			echo("<div>");
			foreach ($gracze as $gracz) {
				echo ("$gracz ");
			}
				echo("</div>");*/
		}
		echo $after_widget;
	}

	function form( $instance ) {
		$defaults = array('title'=>'Status Serwera','smc_ip'=>'localhost','smc_port'=>'20059','smc_login'=>'...','smc_pass'=>'...','smc_salt'=>'...');
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Tytuł</label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
	
		<p>
			<label for="<?php echo $this->get_field_id( 'smc_ip' ); ?>">JsonAPI IP</label>
			<input id="<?php echo $this->get_field_id( 'smc_ip' ); ?>" name="<?php echo $this->get_field_name( 'smc_ip' ); ?>" value="<?php echo $instance['smc_ip']; ?>" style="width:100%;" />
		</p>
	
		<p>
			<label for="<?php echo $this->get_field_id( 'smc_port' ); ?>">API Port</label>
			<input id="<?php echo $this->get_field_id( 'smc_port' ); ?>" name="<?php echo $this->get_field_name( 'smc_port' ); ?>" value="<?php echo $instance['smc_port']; ?>" style="width:100%;" />
		</p>
                
                <p>
			<label for="<?php echo $this->get_field_id( 'smc_login' ); ?>">API Login</label>
			<input id="<?php echo $this->get_field_id( 'smc_login' ); ?>" name="<?php echo $this->get_field_name( 'smc_login' ); ?>" value="<?php echo $instance['smc_login']; ?>" style="width:100%;" />
		</p>
                
                <p>
			<label for="<?php echo $this->get_field_id( 'smc_pass' ); ?>">API Pass</label>
			<input type="password" id="<?php echo $this->get_field_id( 'smc_pass' ); ?>" name="<?php echo $this->get_field_name( 'smc_pass' ); ?>" value="<?php echo $instance['smc_pass']; ?>" style="width:100%;" />
		</p>
                
                <p>
			<label for="<?php echo $this->get_field_id( 'smc_salt' ); ?>">API Salt</label>
			<input type="password" id="<?php echo $this->get_field_id( 'smc_salt' ); ?>" name="<?php echo $this->get_field_name( 'smc_salt' ); ?>" value="<?php echo $instance['smc_salt']; ?>" style="width:100%;" />
		</p>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['smc_ip'] = strip_tags( $new_instance['smc_ip'] );
		$instance['smc_port'] = strip_tags( $new_instance['smc_port'] );
                $instance['smc_login'] = strip_tags( $new_instance['smc_login'] );
                $instance['smc_pass'] = strip_tags( $new_instance['smc_pass'] );
                $instance['smc_salt'] = strip_tags( $new_instance['smc_salt'] );
		return $instance;
	}
}