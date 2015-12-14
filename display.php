<?php

/*
 * Author: Sarah Hall
 * Date Created: 12/08/2015
 * Summary: Created for On The Bit Sim game members, in php and mysql for leaderboards
 */

include_once('functions.php');
$name = trim(filter_input(INPUT_GET, "name", FILTER_SANITIZE_STRING));
$results = showPerHorse($name, $dbh);
$shows = array_unique($results['showName']);
var_dump($shows);
$points = points($results);

echo '<h1>'.$name.'</h1>';

echo "<div id='stats'>
<b>Total Points: </b> $points<br/>
</div>
<div id='results'>

</div>


?>