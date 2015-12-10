<?php
class db
{

	function conecta()
	{
		$localhost = "localhost";
		$db ="pb";
		$username = "postgres";
		$password = "rodr1gues";
		
		try { 
			$pdo = new PDO("pgsql:host=$localhost;dbname=$db", $username, $password); 
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			 
		} 
		catch(PDOException $e) { 
			echo 'Error: ' . $e->getMessage();
		}
		

		
	}
	
}
?>
