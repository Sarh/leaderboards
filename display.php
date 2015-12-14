<?php

/*
 * Author: Sarah Hall
 * Date Created: 12/08/2015
 * Summary: Created for On The Bit Sim game members, in php and mysql for leaderboards
 */

include_once('Functions.php');
$name = trim(filter_input(INPUT_GET, "name", FILTER_SANITIZE_STRING));
$results = showPerHorse($name, $dbh);
function showName($arr){
	return $arr['showName'];
}
$shows = array_map('showName', $results);

$points = points($results);

echo '<h1>'.$name.'</h1>';

echo "<div id='stats'>
<b>Total Points: </b> $points<br/>
</div>
<div id='results'>";
	foreach($shows as $show){
		echo "<h3>$show</h3>
		<table>
		<thead>
		<tr>
		<th>Class Name</th>
		<th>Place</th>
		</tr>
		</thead>
		<tbody>";
			foreach($results as $result){
				if($result['showName'] == $show){
					echo "
						<tr>
							<td>$result[className]</td>
							<td>$result[place]</td>
						</tr>
						";
				}
			}
		echo "</tbody></table>";
	}
	
	
echo "

</div>";


?>