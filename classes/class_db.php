<?php
class db
{
	function db ()
	{
		
	}
	
	function conecta()
	{

		try { 
			$pdo = new PDO('mysql:host=localhost;dbname=meuBancoDeDados', $username, $password); 
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			$stmt = $pdo->prepare('INSERT INTO minhaTabela VALUES(:nome)'); 
			$stmt->execute(array( ':nome' => 'Ricardo Arrigoni' )); 
			echo $stmt->rowCount(); 
		} 
		catch(PDOException $e) { 
			echo 'Error: ' . $e->getMessage();
		}
		

		
	}
	
}
?>
