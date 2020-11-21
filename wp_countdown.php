<?php
/**
 * Plugin Name: wp_countdown
 * Author     : Bill Rigas
 * Author URI : https://everfounders.com
 * Description: A custom Bootstrap countdown timer for Wordpress
 * Version    : 1.0.0
 * License    :  GPL2
 * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
*/

if (!defined('ABSPATH')) exit;

// Register style sheet and JS library
add_action('admin_enqueue_scripts', 'initScripts');
add_action('wp_enqueue_scripts', 'initScripts');

// Register ajax call function for refresh
add_action('wp_ajax_refreshContents', 'refreshContents');

function initScripts() {
	wp_enqueue_style('wp_cnt_style', plugins_url('/css/countdown.css', __FILE__));
	wp_register_script('wp_cnt_script', plugins_url('/js/jquery.countdown.min.js', __FILE__), array('jquery'));
	wp_localize_script('wp_cnt_script', 'ajax_object', array('ajaxurl' => admin_url('admin-ajax.php')));
	wp_enqueue_script('wp_cnt_script');
}

function refreshContents() {
	if (isset($_POST['atts'])) {
		echo makeContent($_POST['atts']);
	}
	
	wp_die();
}

// Add Shortcode
add_shortcode('wp_countdown', function ($atts) {
	// normalize attribute keys, lowercase
	$atts = array_change_key_case((array)$atts, CASE_LOWER);
	// Attributes
	$atts = shortcode_atts(
		array(
			'active' => 'false',
			'due_day' => '',
			'show_day' => '',
			'template' => '',
			'message' => '',
			'title' => '',
			'color' => '1'
		),
		$atts
	);
	
	return makeContent($atts);
});

function makeContent(array $atts) {
	date_default_timezone_set('Europe/Athens');
	
	$cdd_day = date('Y/m/d');
	$cds_day = date('Y/m/d');
	
	if (!empty($atts['due_day'])) {
		if (strpos($atts['due_day'], ':') > 0) {
			$cdd_day = date('Y/m/d H:i');
		}
	}
	
	if (!empty($atts['show_day'])) {
		if (strpos($atts['show_day'], ':') > 0) {
			$cds_day = date('Y/m/d H:i');
		}
	}
	
	$html = "<div class='container py-5' id='wp_cnt_scode'";
	
	if ($atts["active"] == "false" || ($shw_day != null && $cds_day >= $shw_day)) {
	    $html .= " style='display:none;'";
	}
	
	$html .= "><div class='row'><div class='col-lg-10 mx-auto'>";
	
	if (!empty($atts['due_day']) && $cdd_day < $atts['due_day']) {
		$data = json_encode($atts);
		$gr_color = 1;
		
		if (!empty($atts['color'])) {
			$gr_color = intval($atts['color']);
			
			if ($gr_color < 1 || $gr_color > 4) {
				$gr_color = 1;
			}
		}
			
		$html .= "<div class='rounded bg-gradient-{$gr_color} text-white shadow p-5 text-center mb-5'>";
		
		if (!empty($atts['title']))
			$html .= "<p class='mb-4 font-weight-bold shadowed_head'>{$atts['title']}</p>";
		
		$html .= "<div id='wp_countdown' class='countdown-circles d-flex flex-wrap justify-content-center pt-4'></div>";
		$html .= "<script type='text/javascript'>jQuery('#wp_countdown').countdown('{$atts['due_day']}').on('update.countdown', function (event) {
				var reply = '<div class=\"holder m-2\"><span class=\"h1 font-weight-bold\">%D</span> Day%!d</div>';
				reply += '<div class=\"holder m-2\"><span class=\"h1 font-weight-bold\">%H</span> Hr</div>';
				reply += '<div class=\"holder m-2\"><span class=\"h1 font-weight-bold\">%M</span> Min</div>';
				reply += '<div class=\"holder m-2\"><span class=\"h1 font-weight-bold\">%S</span> Sec</div>';
				jQuery(this).html(event.strftime(reply)) }).on('finish.countdown', function (event) { 
				jQuery.ajax({ type: 'POST', url: ajax_object.ajaxurl, data: { 'action': 'refreshContents', 'atts': {$data} }, success: function (output) { 
				jQuery('#wp_cnt_scode').replaceWith(output) } }) })</script></div>";
	}
	else if (!empty($atts['show_day']) && $cds_day < $atts['show_day']) {
		if (!empty($atts['message'])) {
			$msg = stripslashes($atts['message']);
			$html .= "<div class='rounded shadow p-5 text-center mb-5'>{$msg}</div>";
		}
		
		if (!empty($atts['template'])) {
			$templates = new WP_Query(array('post_type' => 'elementor_library', 'title' => $atts['template']));
			
			if ($templates->have_posts()) {
				$templates->the_post();
				$the_content = apply_filters('the_content', get_the_content());			
				if (!empty($the_content))
					$html .= "<div class='rounded shadow'>{$the_content}</div>";
			}
			
			wp_reset_postdata();
		}
	}
	
	return $html."</div></div></div>";
}
