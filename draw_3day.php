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
	echo '<a href="https://atlas.torproject.org/#details/'.$node.'" title="link to '.$node.' on atlas.torproject.org" target="_blank"><img src="/wordpress/torchart/torchart.php?name='.$node.'"></a>';
}
add_shortcode('torchart', 'check_chart');
?>
