<?php

/*
 * To change this template use Tools | Templates.
 */
date_default_timezone_set('UTC');
require_once('../functions.php');

function import($dbh, $csv, $number, $truncate){

	if($truncate == NULL) {$truncate = false;}
	if($number == NULL){$number = false;} 

	if($truncate && $number){
			
			
				$query = "TRUNCATE results";
				$sth = $dbh->prepare($query);
				$sth->execute();
			$query = "
						INSERT INTO results VALUES (DEFAULT, :showDate, :showName, :className, :place, :horseName)";
		$sth = $dbh->prepare($query);
		
		$count = 1;
			foreach($csv as $input){
				if($count == 1) { $count++; continue; }
				try {
					$showDate = date('Y-m-d', strtotime($input[0]));
					
					 $sth->bindValue(':showDate', $showDate);
					 $sth->bindParam(':showName', $input[1]);
					 $sth->bindParam(':className', $input[2]);
					 $sth->bindParam(':place', $input[3]);
					 $sth->bindParam(':horseName', $input[4]);
					
					$sth->execute(); }
					catch (PDOException $e){
						echo $e->getMessage();
						
					}
			}
		
	
			
	} elseif($truncate && !$number){
			$query = "TRUNCATE results";
				$sth = $dbh->prepare($query);
				$sth->execute();
			$query = "
						INSERT INTO results VALUES ( DEFAULT, :showDate, :showName, :className, :place, :horseName)";
		$sth = $dbh->prepare($query);
		
			foreach($csv as $input){
				
				try {
					$showDate = date('Y-m-d', strtotime($input[0]));
					
					 $sth->bindParam(':showDate', $showDate);
					 $sth->bindParam(':showName', $input[1]);
					 $sth->bindParam(':className', $input[2]);
					 $sth->bindParam(':place', $input[3]);
					 $sth->bindParam(':horseName', $input[4]);
					
					$sth->execute(); }
					catch (PDOException $e){
						echo $e->getMessage();
						var_dump($e);
					}
			}
		
		} elseif(!$truncate && $number){
				
			$query = "
						INSERT INTO results VALUES (DEFAULT, :showDate, :showName, :className, :place, :horseName)";
		$sth = $dbh->prepare($query);
		$count = 1;
			foreach($csv as $input){
				if($count == 1) { $count++; continue; }
				try {
					$showDate = date('Y-m-d', strtotime($input[0]));
					
					 $sth->bindParam(':showDate', $showDate);
					 $sth->bindParam(':showName', $input[1]);
					 $sth->bindParam(':className', $input[2]);
					 $sth->bindParam(':place', $input[3]);
					 $sth->bindParam(':horseName', $input[4]);
					
					$sth->execute(); }
					catch (PDOException $e){
						echo $e->getMessage();
						var_dump($e);
					}
			}
	} elseif(!$truncate && !$number){
		$query = "
						INSERT INTO results VALUES (DEFAULT, :showDate, :showName, :className, :place, :horseName)";
		$sth = $dbh->prepare($query);
	
			foreach($csv as $input){
				
				try {
					$showDate = date('Y-m-d', strtotime($input[0]));
					
					 $sth->bindParam(':showDate', $showDate);
					 $sth->bindParam(':showName', $input[1]);
					 $sth->bindParam(':className', $input[2]);
					 $sth->bindParam(':place', $input[3]);
					 $sth->bindParam(':horseName', $input[4]);
					
					$sth->execute(); }
					catch (PDOException $e){
						echo $e->getMessage();
						var_dump($e);
					}
			}
		
	}
	


	
}

function create($dbh){
	
}

function update($dbh, $arr){
	$query = "UPDATE results SET showDate=:showDate, showName=:showName, className=:className, place=:place, horseName=:horseName WHERE id=:id";
	$sth= $dbh->prepare($query);
	$i = 0;

	foreach($arr as $key => $value){
		
		switch ($number = $key % 6){
			case 0: $sth->bindValue(':id', $value); break;
			case 1: $sth->bindValue(':showDate', date('Y-m-d', strtotime($value))); break;
			case 2: $sth->bindValue(':showName', $value); break;
			case 3: $sth->bindValue(':className', $value); break;
			case 4: $sth->bindValue(':horseName', $value); break;
			case 5: $sth->bindValue(':place', trim($value));  $sth->execute(); break;
			default: break;
		}
		$i++; 
	}
	
	return ($i / 6 )  . " result(s) updated!";
	
}

function deleteR($dbh, $arr){
	$query = "DELETE FROM results WHERE id=:id";
	$sth = $dbh->prepare($query);
	$i = 0;	
	
	foreach($arr as $id){
		try{
			$sth->bindParam(':id', $id);
			$sth->execute();
		} catch (PDOException $e){
			echo $e->getMessage();
		}
		$i++;
		
	}
	return "$i results deleted!";
}

function read(){
	
}
?>