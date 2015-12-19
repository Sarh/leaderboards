<?php

/*
 * Author: Sarah Hall
 * Date Created: 12/08/2015
 * Summary: Created for On The Bit Sim game members, in php and mysql for leaderboards
 */

// some database variables
$host = "localhost"; // database host ASO uses localhost
$dbname = ""; // your database name
$user = ""; // your database user that has access to database
$pass = ""; // password for database user


// establish the PDO database handle
try {
	$dbh = new PDO("mysql:host=$host;port=3306;dbname=$dbname", $user, $pass);
} catch (PDOException $e) {
	echo $e->getMessage(); // for debugging
	echo "There was an error, you see."; // custom error message, albeit not very helpful one. 
	$dbh = NULL; // handle the error
	
}

// Query all horses. Returns NULL or an associative array. 
function allHorses($dbh){
	$results = NULL;
	if(!$dbh) throw new Exception("Database Handle error"); 
	try{
		$query = "SELECT DISTINCT horseName from results ORDER BY horseName";
		$sth = $dbh->prepare($query);
		$sth->execute();
		$results = $sth->fetchAll(PDO::FETCH_ASSOC); 
		
	} catch (Exception $e){
		echo $e->getMessage();
	}
	
	return $results;
	
}
// Query all results. Returns Null or associative array
function allShows($dbh){
	$results = NULL;
	if(!$dbh) throw new Exception("Database Handle error");
	try{
		$query = "SELECT * from results";
		$sth = $dbh->prepare($query);
		$sth->execute();
		$results = $sth->fetchAll(PDO::FETCH_ASSOC);
		
		
	} catch (Exception $e) {
		echo $e->getMessage();}
	catch (PDOException $d){
		echo $d->getMessage();
	}
	
	return $results;
}
// Select shows per horse, accepts horse name and database handler as arguments, returns associative array or NULL
function showPerHorse($name, $dbh){
	$results = NULL;
	if(!$dbh) throw new Exception("Database Handle error");
	try{
		$query = "SELECT * from results WHERE horseName=:name";
		$sth = $dbh->prepare($query);
		$sth->bindParam(':name', $name);
		$sth->execute();
		$results  = $sth->fetchAll(PDO::FETCH_ASSOC);
		
	} catch (Exception $e) {
		echo $e->getMessage();}
	catch (PDOException $d){
		echo $d->getMessage();
	}
	return $results;
	
}
// Determine points based off of Associative Array
function points($resultsArr){
	$points = 0;
	foreach($resultsArr as $result){
		switch($result['place']){
			case 1: $points += 10; 
				break;
			case 2: $points += 5;
				break;
			case 3: $points += 2;
				break;
			default: break;
		}
	}
	return $points;
}
function uniqueShows($name, $dbh){
	$results = NULL;
	if(!$dbh) throw new Exception("Database Handle error");
	try{
		$query = "SELECT DISTINCT showName, showDate from results WHERE horseName=:name";
		$sth = $dbh->prepare($query);
		$sth->bindParam(':name', $name);
		$sth->execute();
		$results  = $sth->fetchAll(PDO::FETCH_ASSOC);
		
	} catch (Exception $e) {
		echo $e->getMessage();}
	catch (PDOException $d){
		echo $d->getMessage();
	}
	return $results;
	
}

function resultByID($id, $dbh){
	
	if(!$dbh) throw new Exception("Database Handle error");
	try{
		$query = "SELECT * FROM results WHERE id=:id";
		$sth = $dbh->prepare($query);
		$sth->bindParam(':id', $id);
		$sth->execute();
		$results  = $sth->fetch(PDO::FETCH_ASSOC);
		
	} catch (Exception $e) {
		echo $e->getMessage();}
	catch (PDOException $d){
		echo $d->getMessage();
	}
	return $results;
	
}





?>
