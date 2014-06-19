<?php
/*
Plugin Name:  Tor Chart
Plugin URI: http://www.icetor.is
Description: This draws charts for tor exit bandwidth
Version: 0.1.0
Author: Jason Scott
Author URI: icetor.is
*/
//Please not that this script looks for pChart dir one level above in the wordpress plugins folder
function check_chart( $atts ){
	extract( shortcode_atts( array(
	'node' => 'loki1'
	), $atts ) );
//	$_SESSION['name'] = $node;
//	echo '<img src="wordpress/torchart/torchart.php?name='.$node.'">';
	echo '<img src="/wordpress/torchart/torchart.php?name='.$node.'">';
//	return  $node;
}
add_shortcode('torchart', 'check_chart');
?>
