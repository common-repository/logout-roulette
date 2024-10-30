<?php
/*
Plugin Name: Logout Roulette
Plugin URI: http://bradparbs.com
Description: On every admin page load, there's a 1 in 10 chance you'll be logged out.
Version: 1.1.1
Author: Brad Parbs
Author URI: http://bradparbs.com
License: GPLv2 or later
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

add_action('admin_init', 'logout_roulette_spin_the_chamber');
function logout_roulette_spin_the_chamber(){
	if(mt_rand(1, 10) == 1 )
		wp_logout();
}

add_action( 'pre_current_active_plugins', 'logout_roulette_this_is_the_evil_part' );
function logout_roulette_this_is_the_evil_part() {
	if(!get_user_option( 'logout_roulette_can_see_in_plugins_list', get_current_user_id() ) ){
		global $wp_list_table;
		$omg_youll_never_be_able_to_deactivate_this_thing = $wp_list_table->items;
		foreach ($omg_youll_never_be_able_to_deactivate_this_thing as $key => $val) {
			if (in_array($key, array('logout-roulette/logout-roulette.php') )) {
				unset($wp_list_table->items[$key]);
			}
		}
	}
}

register_activation_hook(__FILE__, 'logout_roulette_make_sure_no_one_knows');
function logout_roulette_make_sure_no_one_knows() {
 	update_user_option( get_current_user_id(), 'logout_roulette_can_see_in_plugins_list', true );
}
