<?php
class api{
	function api( ){
		
		require("classes/class_db.php");
		$this->con = new db();
		$this->con->conecta();

	}
	
	function Auth($login, $senha, $app){
		
	 	$this->con->executa("SELECT * FROM \"JOGADOR\" WHERE \"EMAIL\" = '$login' and \"SENHA\" = '$senha'");
 var_dump($this->con->res);
 	 	if ($this->con->res === true)
	 		echo "foi";
	 	else 
	 		echo "nao foi";  
	 
	  
	 	
		$data = array("data"=>array("login" => "$login", 
								    "senha" => "$senha")
				
		  			  );
		$app->render ('default.php',$data,200);
	}
}