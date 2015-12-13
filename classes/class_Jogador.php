<?php
error_reporting(E_ALL ^ E_DEPRECATED ^E_NOTICE);

class Jogador{
	function Jogador( ){
		
		require("classes/class_db.php");
		$this->con = new db();
		$this->con->conecta();

	}
	
	function Alterar($app, $idJogador, $jsonRAW){
		GLOBAL $IDPosicao;
		$json = json_decode( $jsonRAW, true );
		IF ($json == NULL) {
			$data = array("data"=>
			
					array(	"resultado" =>  "ERRO",
							"erro" => "JSON zuado - $jsonRAW" )
			);
			
			
			$app->render ('default.php',$data,200);
			return false;	
		} 
		//var_dump($json);
		
	//	curl -H 'Content-Type: application/json' -X PUT -d '{"Coach":"0","CornerSnake":"0","Peso":"teste....","CornerDoritos":"0","BackCenter":"1","Altura":"teste....","Time":"1","Snake":"1","Num":"teste....","Doritos":"1","nomeJogador":"teste....","TIMECoach":"0","TIMECornerSnake":"0" "TIMECornerDoritos":"0","TIMEBackCenter":"1", "TIMESnake":"1", "TIMEDoritos":"1"}' http://localhost/api/Jogadores/2/
/*
 * \"POSICAO_SNAKE\"= '".$json["Snake"]."',
	 							\"POSICAO_SNAKECORNER\"= '".$json["CornerSnake"]."',
	 							\"POSICAO_BACKCENTER\"= '".$json["BackCenter"]."',
	 							\"POSICAO_DORITOSCORNER\"= '".$json["CornerDoritos"]."',
	 							\"POSICAO_DORITOS\"= '".$json["Doritos"]."',
	 							\"POSICAO_COACH\"= '".$json["Coach"]."'*/
		$erro = 0;

		//dados cadastrais
	 	if (  $this->con->executa( "UPDATE \"JOGADOR\" SET
	 							\"NOME\"= '".$json["nomeJogador"]   ."',
	 							\"PESO\"= '".$json["Peso"]   ."',
	 							\"ALTURA\"= '".$json["Altura"]   ."',
	 							\"NUM\"= '".$json["Num"]."'
	 						WHERE \"ID_JOGADOR\"  = '".$idJogador."' ") === false ) 
	 		$erro = 1;
	 						
	 		// relacionando jogador ao time
	 		$this->con->executa( "SELECT * FROM \"TIME_JOGADORES\" WHERE \"ID_JOGADOR\" = '".$idJogador."' and saida is null ");
 			if (!$this->con->dados["ID_TIME_JOGADOR"] && $json["Time"] > 0 ){
 				//INCLUIR NO TIME
 				if ($this->con->executa( "INSERT INTO \"TIME_JOGADORES\" (\"ID_JOGADOR\", \"ID_TIME\", \"entrada\") VALUES ('".$idJogador."', '".$json["Time"]."', NOW()); "  ) === FALSE)
 					$erro=4;
 			}
 			ELSE if ($this->con->dados["ID_TIME_JOGADOR"]>0 && $json["Time"] == 0){
 				//SAIU DO TIME
 				if ($this->con->executa( "UPDATE  \"TIME_JOGADORES\" SET \"saida\"= now() WHERE \"ID_TIME_JOGADOR\"='".$this->con->dados["ID_TIME_JOGADOR"]."'" ) === FALSE)
 					$erro=5;
 			}
 			
 			$this->con->executa( "SELECT * FROM \"TIME_JOGADORES\" WHERE \"ID_JOGADOR\" = '".$idJogador."' and saida is null ");
 			$idTimeJogador = $this->con->dados["ID_TIME_JOGADOR"];	
 			
			if ( $idTimeJogador > 0)
			{
				// ajustando posicoes do jogador NO TIME
				foreach ($IDPosicao  as $key => $value){
						echo " \n checkando... $key $value --- ".$json[$key];
				
					$this->con->executa( "SELECT * FROM \"TIME_JOGADOR_POSICOES\" WHERE \"ID_POSICAO\" = '".$value."' AND \"ID_TIME_JOGADOR\" = '".$idTimeJogador."' ");
					if (!$this->con->dados["ID_TIME_JOGADOR_POSICAO"] && $json["TIME".$key] == 1){
						if ($this->con->executa( "INSERT INTO \"TIME_JOGADOR_POSICOES\" (\"ID_TIME_JOGADOR\", \"ID_POSICAO\") VALUES ('".$idTimeJogador."', '".$value."'); "  ) === FALSE)
							$erro=6;
					}
					ELSE if ($this->con->dados["ID_TIME_JOGADOR_POSICAO"]>0 && $json["TIME".$key] == 0){
						if ($this->con->executa( "delete from \"TIME_JOGADOR_POSICOES\" where \"ID_TIME_JOGADOR_POSICAO\"='".$this->con->dados["ID_TIME_JOGADOR_POSICAO"]."'" ) === FALSE)
							$erro=7;
					}
				
				}
				
			}
 			
 			
 		// ajustando posicoes DO JOGADOR
 		foreach ($IDPosicao  as $key => $value){
 		//	echo " \n checkando... $key $value --- ".$json[$key];

 			$this->con->executa( "SELECT * FROM \"JOGADOR_POSICOES\" WHERE \"ID_POSICAO\" = '".$value."' AND \"ID_JOGADOR\" = '".$idJogador."' ");
 			if (!$this->con->dados["ID_POSICAO_JOGADOR"] && $json[$key] == 1){
 				if ($this->con->executa( "INSERT INTO \"JOGADOR_POSICOES\" (\"ID_JOGADOR\", \"ID_POSICAO\") VALUES ('".$idJogador."', '".$value."'); "  ) === FALSE)
 					$erro=2;
 			}
 			ELSE if ($this->con->dados["ID_POSICAO_JOGADOR"]>0 && $json[$key] == 0){
 				if ($this->con->executa( "delete from \"JOGADOR_POSICOES\" where \"ID_POSICAO_JOGADOR\"='".$this->con->dados["ID_POSICAO_JOGADOR"]."'" ) === FALSE)
 					$erro=3;
 			}
 			
 		}
 
 			
	 	if ($erro == 0){
 	 		//autenticado
 	 		
 	 		$data = array("data"=>
 	 				array(	"resultado" =>  "SUCESSO"
 	 						)
 	 		); 	 	
 	 	}
	 	else {
	 		// nao encontrado
	 		$data = array("data"=>
	 						
	 				array(	"resultado" =>  "ERRO $erro",
	 						"erro" => "Nao encontrado" )
	 		);	 		
	 	} 

		$app->render ('default.php',$data,200);
	}
}