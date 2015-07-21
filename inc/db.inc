<?php
include 'Skola.inc';

class DAO
{
	protected $database = 'dbname';
	
	// Gets a complete array of all data
	public function getSkolor() 
	{
		$Skolor = array();
		
		// Create connection
		$db_handle = mysql_connect('dburl', 'username', 'password');
		if (!$db_handle) {
			die('Could not connect: ' . mysql_error());
		}
		
		$db_found = mysql_select_db('sverigestrafiks', $db_handle);
		if ($db_found)
		{
			$SQL = "SELECT * FROM customer";
			$result = mysql_query($SQL);
			while ( $db_field = mysql_fetch_assoc($result) )
			{
				$skola = new Skola();
				$skola->id = $db_field['id'];
				$skola->name = utf8_encode($db_field['name']);
				$skola->location = utf8_encode($db_field['location']);
				$skola->address = utf8_encode($db_field['address']);
				$skola->postort = utf8_encode($db_field['city']);
				$skola->postNumber = utf8_encode($db_field['postNumber']);
				$skola->homepage = utf8_encode($db_field['homePage']);
				$skola->tel = utf8_encode($db_field['tel']);
				$Skolor[] = $skola;
			}
			
			foreach($Skolor as $skola)
			{
				$SQL = "SELECT * FROM product where customerID =".$skola->id;
				$result = mysql_query($SQL);
				
				while ($db_field = mysql_fetch_assoc($result))
				{
					$name = utf8_encode($db_field['name']);
					
					if($name == "Körlektion")
					{
						$skola->priceLesson = utf8_encode($db_field['price']);
					}
					else if($name == "Riskutbildning 1")
					{
						$skola->priceRisketta = utf8_encode($db_field['price']);
					}
					else if($name == "Riskutbildning 2")
					{
						$skola->priceGuide = utf8_encode($db_field['price']);
					}
				}
			}
		}
		else
		{
			die('Could not open database: ' . mysql_error());
		}
		
		mysql_close($db_handle);
		return $Skolor;
	}
	
	
	// Gets a specific school
	public function getSkola($SkolNamn) 
	{
		$SkolNamn = urldecode($SkolNamn);
		$skola = new Skola();
		
		// Create connection
		$db_handle = mysql_connect('sverigestrafikskolor.se.mysql', 'sverigestrafiks', 's7VmHQtn');
		if (!$db_handle) {
			die('Could not connect: ' . mysql_error());
		}
		
		$db_found = mysql_select_db('sverigestrafiks', $db_handle);
		if ($db_found)
		{
			$SQL = "SELECT * FROM customer where name='". utf8_decode($SkolNamn) ."'";
			$result = mysql_query($SQL);
			while ( $db_field = mysql_fetch_assoc($result) )
			{
				$skola->id = $db_field['id'];
				$skola->name = utf8_encode($db_field['name']);
				$skola->location = utf8_encode($db_field['location']);
				$skola->address = utf8_encode($db_field['address']);
				$skola->postort = utf8_encode($db_field['city']);
				$skola->postNumber = utf8_encode($db_field['postNumber']);
				$skola->homepage = utf8_encode($db_field['homepage']);
				$skola->tel = utf8_encode($db_field['tel']);
			}

			$SQL = "SELECT * FROM product where customerID =".$skola->id;
			$result = mysql_query($SQL);
			
			while ($db_field = mysql_fetch_assoc($result))
			{
				$name = utf8_encode($db_field['name']);
				
				if($name == "Körlektion")
				{
					$skola->priceLesson = utf8_encode($db_field['price']);
				}
				else if($name == "Riskutbildning 1")
				{
					$skola->priceRisketta = utf8_encode($db_field['price']);
				}
				else if($name == "Riskutbildning 2")
				{
					$skola->priceGuide = utf8_encode($db_field['price']);
				}
			}	
		}
		else
		{
			die('Could not open database: ' . mysql_error());
		}
		
		mysql_close($db_handle);
		return $skola;
	}
	
	// Gets the Distinct locations
	public function getLocations() 
	{
		$locations = array();
		
		// Create connection
		$db_handle = mysql_connect('sverigestrafikskolor.se.mysql', 'sverigestrafiks', 's7VmHQtn');
		if (!$db_handle) {
			die('Could not connect: ' . mysql_error());
		}
		
		$db_found = mysql_select_db('sverigestrafiks', $db_handle);
		if ($db_found)
		{
			$SQL = "SELECT DISTINCT location FROM customer ORDER BY location ASC";
			$result = mysql_query($SQL);
			while ($db_field = mysql_fetch_assoc($result))
			{
				$locations[] = utf8_encode($db_field['location']);
			}
		}
		else
		{
			die('Could not open database: ' . mysql_error());
		}
		mysql_close($db_handle);
		return $locations;
	}
	
		// Gets the Distinct postorts
	public function getPostort($location) 
	{
		$location = urldecode($location);
		$postorts = array();
		// Create connection
		$db_handle = mysql_connect('sverigestrafikskolor.se.mysql', 'sverigestrafiks', 's7VmHQtn');
		if (!$db_handle) {
			die('Could not connect: ' . mysql_error());
		}
		$db_found = mysql_select_db('sverigestrafiks', $db_handle);
		if ($db_found)
		{
			$SQL = "SELECT DISTINCT city FROM customer WHERE location='".utf8_decode($location)."' ORDER BY city ASC";
			$result = mysql_query($SQL);
			while ($db_field = mysql_fetch_assoc($result))
			{
				$postorts[] = utf8_encode($db_field['city']);
			}
		}
		else
		{
			die('Could not open database: ' . mysql_error());
		}
		mysql_close($db_handle);
		return $postorts;
	}
	
}
	
?>