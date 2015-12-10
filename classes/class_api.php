<?php
class api{
	function api( ){
		
		require("classes/class_db.php");
		$this->con = new db();
		$this->con->conecta();

	}
	
	function Auth($login, $senha, $app){
		
	 	$this->con->executa("SELECT * FROM \"JOGADOR\" WHERE \"EMAIL\" = '$login' and \"SENHA\" = '$senha'");
 
 	 	if ($this->con->res === true){
 	 		//autenticado
 	 		
 	 		$data = array("data"=>
 	 				array(	"email" => $this->con->dados["EMAIL"],
 	 						"nome" => $this->con->dados["NOME"])
 	 		); 	 	
 	 	}
	 	else {
	 		// nao encontrado
	 		$data = array("data"=>
	 				array(	"erro" => "Nao encontrado" )
	 		);	 		
	 	} 

		$app->render ('default.php',$data,200);
	}
}