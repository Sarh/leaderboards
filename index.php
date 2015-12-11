<?php

/*
 * Author: Sarah Hall
 * Date: 12/11/2015
 * Summary: Created for On The Bit Sim game members, in php and mysql for leaderboards
 */

include_once('functions.php');

$horses = allHorses($dbh);
echo '
<table>
	<tr>
		<th>Horse Name</th>
		<th>Points</th>
	</tr>';
foreach($horses as $horse){
	echo '<tr>
			<td>'.$horse['horseName'].'</td>
			<td>'.points(showPerHorse($horse['horseName'], $dbh)).'</td>
		</tr>';
}
echo '
</table>';
	

?>
