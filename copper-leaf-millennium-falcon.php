<?php

/*
Plugin Name: Copper Leaf Creative: Millenium Falcon
Description: For smuggling.  "Uh, everything is fine here. Situation Normal.  How are you?"
Version: 1.2.5
Author: Copper Leaf Creative, Gordon Seirup
Author URI: https://www.copperleafcreative.com
License: GPLv2
*/

/*
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; version 2 of the License.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Make sure we don't expose any info if called directly
if ( ! function_exists( 'add_action' ) ) {
    _e( "Hi there! I'm just a plugin, not much I can do when called directly." );
    exit; 
}



require 'plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/CopperLeafCreative/copper-leaf-millennium-falcon',
	__FILE__,
	'copper-leaf-millennium-falcon'
);

//Set the branch that contains the stable release.
// $myUpdateChecker->setBranch('stable-branch-name');

$myUpdateChecker->getVcsApi()->enableReleaseAssets();

// get Personal Access Token from Copper Leaf Settings
$github_personal_access_token = get_field( 'clcs_github_personal_access_token' , 'option' );

//Optional: If you're using a private repository, specify the access token like this:
$myUpdateChecker->setAuthentication( $github_personal_access_token );




// Add custom stylesheet
add_action( 'wp_enqueue_scripts', 'clc_wasabi_enqueue_stylesheet', 50 );
function clc_wasabi_enqueue_stylesheet() {
  wp_enqueue_style( 'clc_wasabi_css', plugins_url('css/copper.css', __FILE__));
}


// Add custom Admin stylesheet
add_action('admin_enqueue_scripts', 'clc_wasabi_admin_style');
function clc_wasabi_admin_style() {
  wp_enqueue_style( 'clc_wasabi_admin_css', plugins_url('css/copper-admin.css', __FILE__));
}


add_shortcode ( 'otc_client_name' , 'make_otc_client_name' );
function make_otc_client_name() {

	if ( $_GET['cn']!='' && $_GET['cfn']!='' ) {

		return '<p style="font-weight: bold; padding-top: 8px;">Company: '.$_GET['cn'].'</p>
					<p>Thanks '.$_GET['cfn'].'!</p>';

	}

}


// Render shortcodes in Gravity Forms
// https://wpstreak.com/shortcodes-gravity-forms-fields/
add_filter( 'gform_get_form_filter', 'shortcode_unautop', 11 );
add_filter( 'gform_get_form_filter', 'do_shortcode', 11 );