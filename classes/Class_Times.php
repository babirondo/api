<?php
error_reporting(E_ALL ^ E_DEPRECATED ^E_NOTICE);

class Times{
	function Times( ){
		
		require("classes/class_db.php");
		$this->con = new db();
		$this->con->conecta();

	}

 
	
	function CarregarTimebyIdJogador($app,  $idJogador){
		 
		
		$this->con->executa( " select  T.\"ID_TIME\" ,T.\"TIME\" , T.\"FOTO\" , AVG(J.\"FORCA\") FORCA
								from \"JOGADOR\" J
									LEFT JOIN \"TIME_JOGADORES\" TJ ON (TJ.\"ID_JOGADOR\" = J.\"ID_JOGADOR\")
									LEFT JOIN \"TIMES\" T ON (T.\"ID_TIME\" = TJ.\"ID_TIME\")		
								WHERE J.\"ID_JOGADOR\"= '".$idJogador."' and TJ.\"saida\" is null
								GROUP BY T.\"ID_TIME\" ,T.\"TIME\", T.\"FOTO\"
						");
		$this->con->navega();
		
		$array["resultado"] = "SUCESSO";
		$array["Time"] =  $this->con->dados["TIME"];
		$array["PWR"] = $this->con->dados["forca"] ;
		$array["fotoTime"] =  $this->con->dados["FOTO"];
		$array["ID_Time"] =  $this->con->dados["ID_TIME"];
		
		 
		// carregadndo dados dos jogadores
		$this->con->executa( " select  J.*
								from \"JOGADOR\" J
									LEFT JOIN \"TIME_JOGADORES\" TJ ON (TJ.\"ID_JOGADOR\" = J.\"ID_JOGADOR\")
									LEFT JOIN \"TIMES\" T ON (T.\"ID_TIME\" = TJ.\"ID_TIME\")		
								WHERE T.\"ID_TIME\"= '".$array["ID_Time"]."' and TJ.\"saida\" is null
								 
						");
 
		$i=0;
		while ($this->con->navega(0)){
				$array["JOGADORES"][$i]["nomeJogador"]  = $this->con->dados["NOME"];
				$array["JOGADORES"][$i]["forcaJogador"]  = $this->con->dados["FORCA"];
			//	$array["JOGADORES"][$i]["fotoJogador"]  = $this->con->dados["FOTOJOGADOR"];
				$i++;
		}
		 
		$data =  	$array;
		
		
		
		$app->render ('default.php',$data,200);
				
		
	}
	 
}