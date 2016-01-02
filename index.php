<?php

/*
 * Author: Sarah Hall
 * Date: 12/11/2015
 * Summary: Created for On The Bit Sim game members, in php and mysql for leaderboards
 */

include_once('functions.php');

$horses = allHorses($dbh);?>
<!DOCTYPE>
<html>
	<head>
		<link href='http://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
	   	<link href="css/footable.core.css" rel="stylesheet" type="text/css" />
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
		<script src="js/footable.js" type="text/javascript"></script>
		<script src="js/footable.sort.js" type="text/javascript"></script>
		<script src="js/footable.paginate.js" type="text/javascript"></script>
		<script src="js/footable.filter.js" type="text/javascript"></script>
		<script type="text/javascript">
			$(function () {
				$('.footable').footable();
			});
		</script>
	</head>
	<body>
		<?php 
		echo '
		<table class="footable" data-page-size="25" data-filter="#filter">
			<thead>
				<tr colspan="2">
				<input id="filter" type="text" placeholder="Search" style="margin-right:10px;"/>
				</tr>
				<tr>
					<th>Horse Name</th>
					<th data-type="numeric" data-sort-initial="descending">Points</th>
				</tr>
			</thead>
			<tbody>';
		foreach($horses as $horse){
			echo 	'<tr>
					<td><a href="display.php?name='.$horse[horseName].' " >'.$horse[horseName].'</a></td>
					<td>'.points(showPerHorse($horse['horseName'], $dbh)).'</td>
				</tr>';
		}
		echo '
		</tbody>
		<tfoot class="hide-if-no-paging">
			<tr>
				<td colspan="5">
					<div class="pagination pagination-centered"></div>
				</td>
			</tr>
		</tfoot>
		</table>';
			
		
		?>
	</body>
</html>
