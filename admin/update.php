<?php
/*
 * Author: Sarah Hall
 * Date: 12/17/2015
 * Summary: Created for On The Bit Sim game members, in php and mysql for leaderboards
 */

include_once('functions.php');


if(isset($_POST[Delete])){
	echo deleteR($dbh, $_POST['id']);
	unset($_POST);
}
if(isset($_POST[Changes])){
	echo update($dbh, $_POST['result']);
}

$results = allShows($dbh);



?>
<!DOCTYPE>
<html>
	<head>
		<link href='http://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
	   	<link href="../css/footable.core.min.css" rel="stylesheet" type="text/css" />
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
		<script src="../js/footable.js" type="text/javascript"></script>
		<script src="../js/footable.sort.js" type="text/javascript"></script>
		<script src="../js/footable.paginate.js" type="text/javascript"></script>
		<script src="../js/footable.filter.js" type="text/javascript"></script>
		<script type="text/javascript">
			$(function () {
				$('.footable').footable();
			});
		</script>
	</head>
	<body>
		<?php 
		
		if(!isset($_POST['id'])) {
		echo '
		<form action="update.php" method="POST">
		<input type="submit" value="Edit Selected Entries" name="Edit">
		<input type="submit" value="Delete Selected Entries" name="Delete" onclick="return confirm(\'Are you sure you want to delete these entries?\')" >
		<br/>
		<table class="footable" data-page-size="100" data-filter="#filter">
			<thead>
				<tr colspan="2">
				<input id="filter" type="text" placeholder="Search" style="margin-right:10px;"/>
				</tr>
				<tr>
					<th data-type="date" data-sort-initial="descending">Result Date</th>
					<th>Show Name</th>
					<th>Class Name</th>
					<th>Horse Name</th>
					<th>Place</th>
					<th data-sort-ignore="true"">Selected</th>
					
					
				</tr>
			</thead>
			<tbody>';
		foreach($results as $result){
			echo 	'<tr>
					<td>'.$result['showDate'].'</td>
					<td>'.$result['showName'].'</td>
					<td>'.$result['className'].'</td>
					<td>'.$result['horseName'].'</td>
					<td>'.$result['place'].'</td>
					<td><input type="checkbox" name="id[]" value="'.$result[id].'"></td>
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
		</table>
		</form>';
		}
			
		if(isset($_POST[Edit])){

			
			$arr = $_POST[id];
		
			echo '<form method="POST" action="update.php">';
			foreach($arr as $id){
				$result = resultByID($id, $dbh);
				
				echo "
				<input type='hidden' name='result[]' value='$id'>
				Show Date: <input type=\"text\"  name=\"result[]\" value='$result[showDate]'><br/>
				Show Name: <input type=\"text\" name=\"result[]\" value=\"$result[showName]\"><br/>
				Class Name: <input type=\"text\" name=\"result[]\" value=\"$result[className]\"><br/>
				Horse Name: <input type=\"text\" name=\"result[]\" value=\"$result[horseName]\"><br/>
				Place: <input type=\"text\" name=\"result[]\" value=\"$result[place]\"><br/><br/>";
			}
			echo "
			<input type=\"submit\" name=\"Changes\" value=\"Make Changes\">
			</form>";
			
			
			
			
		}?>
		
		
	</body>
</html>