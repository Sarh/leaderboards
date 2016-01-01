<?php
/*
 * Author: Sarah Hall
 * Date Created: 01/01/2016
 * Summary: Created for On The Bit Sim game members, in php and mysql for leaderboards
 */

require('functions.php');


if($_POST['results']){

	// set the show info, i.e. Show Date and Show Name into an array $show
	$show = array(filter_input(INPUT_POST, 'showName', FILTER_SANITIZE_STRING), filter_input(INPUT_POST, 'showDate', FILTER_SANITIZE_STRING));

	// create a new array consisting of all results, exploded by the new line & return (separates the classes)
	$array = explode("\n\r", filter_input(INPUT_POST, 'results', FILTER_SANITIZE_STRING));
	
	// for each array, treat it as a class. 
	foreach($array as $class){
		if(empty($class)){ // the empty array element (the empty line separating the classes), skip it. 
			continue;
		}
		
		$class = array_values(array_filter(explode("\n", $class))); // 1st explodes each result set of a class into an array at the new line, then uses array_filter to do a quick check and exclude all empty array elements. Finally resets the numeric keys of the array returned. 	
		
		// take the first element of the array, remove it and save it as the class name, reset the numeric index of the array. 
		$className = array_shift($class);
		
		foreach($class as $key => $value){
			if(empty($value)){
				continue;
			}
			// step thru array, split +  processes and execute db stmt
			if(stripos($value, "-") !== false){
				$temp = explode("-", $value);
				$temp = array_filter($temp);
				$place = $temp[0];
				$percentage = $temp[2];
				unset($temp[2]);
				unset($temp[0]);			
				$temp = array_values($temp);
				$temp = implode(" ", $temp);
			} else if (stripos($value, ".") !== false){
				$temp = explode(".", $value);
				$temp = array_filter($temp);
				$place = $temp[0];
				$percentage = $temp[2];
				unset($temp[2]);
				unset($temp[0]);			
				$temp = array_values($temp);
				$temp = implode(" ", $temp);
			} else {
				$temp = explode(" ", $value);
				$temp = array_filter($temp);
				$place = $temp[0];
				$percentage = $temp[2];
				unset($temp[2]);
				unset($temp[0]);			
				$temp = array_values($temp);
				$temp = implode(" ", $temp);
			}


			// Check if ridden by is in here.....
			if(stripos($temp, "ridden by")){

				// check which comes first, owned by or ridden by

				if(stripos($temp, "ridden by") < stripos($temp, "owned by")){
					//if ridden by comes before owned by
					$temp1 = explode("ridden by", $temp);
					$horseName = trim($temp1[0]);
					//Now split the owned by off
					$temp1 = explode("owned by", $temp1[1]);
					$owner = trim($temp1[1]);	
					$rider = trim($temp1[0]);
				}
				else if(stripos($temp, "ridden by") > stripos($temp, "owned by")) {
					//if owned by comes before ridden by
					$temp1 = explode("owned by", $temp);
					$horseName = trim($temp1[0]);
					//Now split the owned by off
					$temp1 = explode("ridden by", $temp1[1]);

					$owner = trim($temp1[0]);
					$rider = trim($temp1[1]);
				}	
			} else { // it is just "owned by" that is here so do the usual..., split the string by where owned by starts. IF there is no owned by, just make it the horses name and set the owner as blank. 
				if(stripos($temp, "owned by")){
					$temp1 = explode("owned by", $temp);
					$horseName = trim($temp1[0]);
					$owner = trim($temp1[1]);
				} else {$horseName = $temp; $owner=" ";}

			}


			$arr[] = array($show[1], $show[0], $className, $place, $horseName); // push the info into an array that will be passed to import (so we don't repeat our code, well will format everything to look like what a .csv file would import as. )
		
		
		}
		
	}
	import($dbh, $arr, 0, 0);
}
?>
<html>
	<body>
		<form method="post" action="create.php">
			<label>Show Name: <input type="text" name="showName"></label><br />
			<label>Show Date: <input type="date" name="showDate"></label><br />
			<textarea name="results"></textarea><br />
			<input type="submit">
		</form>
		
		
	</body>
	
</html>