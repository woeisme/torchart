<?php
$node = $_GET['name'];
/* Include all the classes */
include("/usr/share/wordpress/wp-content/plugins/pChart2.1.3/class/pDraw.class.php");
include("/usr/share/wordpress/wp-content/plugins/pChart2.1.3/class/pImage.class.php");
include("/usr/share/wordpress/wp-content/plugins/pChart2.1.3/class/pData.class.php");
date_default_timezone_set("UTC");
//fetching relay nickname via fingerprint lookup method
$json = file_get_contents("https://onionoo.torproject.org/summary?lookup=${node}");
$decodedData = json_decode($json, true);
$relays = $decodedData['relays'];
$firstrelay = reset($relays);
$nickname = $firstrelay['n'];
//nickname fetched, now queriying for bandwidth data
$json = file_get_contents("https://onionoo.torproject.org/bandwidth?search=${nickname}");
$response = json_decode($json, true);
//print_r($response);
$relays = $response['relays'];
$firstRelay = reset($relays);
/* Get fields */
$finger_print = $firstRelay['fingerprint'];
$three_day_write_history_first = $firstRelay['write_history']['3_days']['first'];
$first_udate = strtotime($three_day_write_history_first);
$three_day_write_history_last = $firstRelay['write_history']['3_days']['last'];
$last_udate = strtotime($three_day_write_history_last);
$three_day_write_history_interval = $firstRelay['write_history']['3_days']['interval'];
$interval = $three_day_write_history_interval;
$date_array = array();
/*Calculate date points */
while ($first_udate < $last_udate)
	{
		$date_array[] = gmdate("  m-d H:i:s",$first_udate);
//		$date_array[] = $first_udate;
		$first_udate = $first_udate + $interval;
	}
/* Get values */
$three_day_write_history_values = $firstRelay['write_history']['3_days']['values'];
$three_day_read_history_values = $firstRelay['read_history']['3_days']['values'];
$one_week_write_history_values = $firstRelay['write_history']['1_week']['values'];
$one_week_read_history_values = $firstRelay['read_history']['1_week']['values'];
/* Create your dataset object */
$myData = new pData();
/* Add data in your dataset */
$myData->addPoints($three_day_write_history_values, "write");
$myData->addPoints($three_day_read_history_values, "read");
$myData->setAxisName(0,"bytes per sec");
$myData->setAxisDisplay(0,AXIS_FORMAT_METRIC);
/* experiment with adding dates to X axis */
$myData->setXAxisDisplay(AXIS_FORMAT_DEFAULT);
$myData->addPoints($date_array, "Timestamp");
$myData->setSerieDescription("Timestamp","Dates");
$myData->setAbscissa("Timestamp");
/* Create a pChart object and associate your dataset */
$myPicture = new pImage(700,270,$myData);
/* Define the boundaries of the graph area */
$myPicture->setGraphArea(60,40,670,190);
/* Choose a nice font */
$myPicture->setFontProperties(array("FontName"=>"/usr/share/wordpress/pChart2.1.3/fonts/Forgotte.ttf","FontSize"=>14));
/* Draw the scale, keep everything automatic */
$myPicture->drawScale(array("DrawSubTicks"=>TRUE,"LabelSkip"=>10,"LabelRotation"=>-45));
//$myPicture->drawScale(array("RemoveXAxis"=>TRUE));
//$myPicture->drawScale(array("LabelRotation"=>90));
//$myPicture->drawScale();
$myPicture->drawText(60,35,"{$nickname} - {$finger_print}",array("FontSize"=>12,"Align"=>TEXT_ALIGN_BOTTOMLEFT));
/* Draw the scale, keep everything automatic */
//$myPicture->drawSplineChart(array("DisplayValues"=>False,"DisplayColor"=>DISPLAY_AUTO));
$myPicture->drawSplineChart();
//$myPicture->drawCubicCurve();
/* Build the PNG file and send it to the web browser */
$myPicture->Stroke();
//header('Content-Length: '.filesize($yourimage));
//header('Content-Type: image/png');
//$myPicture->Render("three_day.png");
//echo $node;
//echo '<img src="/wordpress/torchart/three_day.png">';
//echo '<img src=`/wordpress/torchart/torchart.php`>';
//echo <img src="three_day.png";
//echo '<img src="/wordpress/torchart/torchart.php">';
//add_shortcode('torchart', 'check_chart');
?>
