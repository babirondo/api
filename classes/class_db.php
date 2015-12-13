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
			$this->pdo = new PDO("pgsql:host=$localhost;dbname=$db", $username, $password); 
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			 
		} 
		catch(PDOException $e) { 
			echo 'Error: ' . $e->getMessage();
		}		
	}
	
	
	function executa($sql)
	{
		 echo "\n".$sql;
		
		 
		 if (substr($sql,0,strpos($sql, " " )  ) == "SELECT")
		 {
		 	
		 	//select
		 	$select = 1;
		 	$this->res = $this->pdo->query($sql);
		 	
		 }
		 else{
		 
		 	//others
		 	$this->res = $this->pdo->exec($sql);
		 	
		 }
		 	 
   		
	//	var_dump($this->res);
   		
   		
		
   		
   		if ( $this->res > 0 ){

   			if ($select == 1)
   				$this->navega(0);
   			else
   				return true;
   		}	
   		else{
   			
   			return false;
   			
   		}
	}
	
	function navega($i){
		
			$this->dados = $this->res->fetch(PDO::FETCH_ASSOC);	
			 
			if ($this->dados === false ){
				return $this->res = false;
			}	
			else{
				return $this->res = true;
			} 
				
	}
	
}
?>
