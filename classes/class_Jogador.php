<?php
error_reporting(E_ALL ^ E_DEPRECATED ^E_NOTICE);

class Jogador{
	function Jogador( ){
		
		require("classes/class_db.php");
		$this->con = new db();
		$this->con->conecta();

	}

	function Recomendar($app , $id_recomendado, $jsonRAW){
		GLOBAL $IDPosicao;
		$json = json_decode( $jsonRAW, true );
		IF ($json == NULL) {
			$data = array("data"=>
	
					array(	"resultado" =>  "ERRO",
							"erro" => "JSON zuado - $jsonRAW" )
			);
	
	
			$app->render ('default.php',$data,500);
			return false;
		}
		//var_dump($json);
	
		//	curl -H 'Content-Type: application/json' -X PUT -d '{"notaCornerDoritos":"5.0","notaBackCenter":"5.0","notaVelocidade":"0.0","notaConhecimento":"0.0","notaDoritos":"0.0","notaCoach":"0.0","notaCornerSnake":"0.0","notaGunfight":"0.0","notaSnake":"5.0"}' http://localhost/api/Jogador/Recomendar/2/
		/*
	
	
	
		*/
		$erro = 0;
	
		//dados cadastrais
		if (  $this->con->executa( " INSERT INTO PUBLIC.\"RECOMENDACAO\" 
( \"ID_RECOMENDADO\", \"ID_RECOMENDANDO\",  DATA, 
   \"BACKCENTER\", \"SNAKE\", \"DORITOS\", 
   \"CORNERSNAKE\", \"CORNERDORITOS\", \"COACH\",
   \"GUNFIGHT\", \"CONHECIMENTO\", \"VELOCIDADE\"
				
)

VALUES (
	'".$id_recomendado."','".$json["ID_RECOMENDANDO"]."', NOW(), 
	'".$json["notaBackCenter"]."','".$json["notaSnake"]."','".$json["notaDoritos"]."',
	'".$json["notaCornerSnake"]."','".$json["notaCornerDoritos"]."','".$json["notaCoach"]."',
	'".$json["notaGunfight"]."','".$json["notaConhecimento"]."','".$json["notaVelocidade"]."'
				)

RETURNING \"ID_RECOMENDACAO\" ", 1 ) === false )
			$erro = 1;
			else{
				$lastInsertId =  $this->con->dados["ID_RECOMENDACAO"];
	
			}
	
	
			if ($erro == 0){
				//autenticado
					
				$data = array("data"=>
						array(	"resultado" =>  "SUCESSO",
								"ID_RECOMENDACAO" => $lastInsertId
						)
				);
			}
			else {
				// nao encontrado
				$data = array("data"=>
	
						array(	"resultado" =>  "ERRO #$erro",
								"erro" => "Nao encontrado" )
				);
			}
	
			$app->render ('default.php',$data,200);
	}
		
	
	
	function Pesquisar($app, $jsonRAW){
		GLOBAL $IDPosicao;
		$json = json_decode( $jsonRAW, true );
		IF ($json == NULL) {
			$data = array("data"=>
		
					array(	"resultado" =>  "ERRO",
							"erro" => "JSON zuado - $jsonRAW" )
			);
		
		
			$app->render ('default.php',$data,500);
			return false;
		}
		 
		//	curl -H 'Content-Type: application/json' -X PUT -d '{"ForcaDe":"","ForcaAte":"","CornerDoritos":"","Snake":"","Num":"","IdJogadorLogado":"2","Coach":"","CornerSnake":"","Peso":"","BackCenter":"","Altura":"","Time":"3","Doritos":"","Nome":""}' http://localhost/api/Jogadores/Pesquisar/
		
		
		
		$opt_where = null;
		if ($json["IdJogadorLogado"]) $opt_where[] = " J.\"ID_JOGADOR\" != '". $json["IdJogadorLogado"] ."' ";
		if ($json["Nome"]) $opt_where[] = " \"NOME\" LIKE '".str_replace(" ","%",$json["Nome"])."' ";
		if ($json["Time"]) $opt_where[] = " T.\"ID_TIME\" = '".$json["Time"]."' ";
		if ($json["Altura"]) $opt_where[] = " \"ALTURA\" = '".$json["Altura"]."' ";
		if ($json["Peso"]) $opt_where[] = " \"PESO\" = '".$json["Peso"]."' ";
		if ($json["ForcaDe"] && $json["ForcaAte"]) $opt_where[] = " \"FORCA\" between '".$json["ForcaDe"]."' and '".$json["ForcaAte"]."'  ";
		
		$where = " WHERE ".join($opt_where, " and ");
		
		//".$json["Email"]."
		$sql = " select  J.*, T.*
								from \"JOGADOR\" J
									LEFT JOIN \"TIME_JOGADORES\" TJ ON (TJ.\"ID_JOGADOR\" = J.\"ID_JOGADOR\")
									LEFT JOIN \"TIMES\" T ON (T.\"ID_TIME\" = TJ.\"ID_TIME\")
								 $where ";
		$this->con->executa( $sql);
//		echo "linhas encontradas ".$this->con->nrw;
		IF ($this->con->nrw >0){
			//$this->con->navega();
			
			
			$i=0;
			while ($this->con->navega()){
				$array["RESULTSET"][$i]["NOME"]  = $this->con->dados["NOME"];
				$array["RESULTSET"][$i]["TIME"]  = $this->con->dados["TIME"];
				$array["RESULTSET"][$i]["PWR"]  = $this->con->dados["FORCA"];
				$array["RESULTSET"][$i]["ID_JOGADOR"]  = $this->con->dados["ID_JOGADOR"];
				$array["RESULTSET"][$i]["FOTOJOGADOR"]  = $this->con->dados["FOTOJOGADOR"];
				$array["RESULTSET"][$i]["NEW"]  = $this->con->dados["NEW"];
				$i++;
			}
				
			
	
		
			$data =  	$array;
			$app->render ('default.php',$data,200);
				
		}
		else{
		
	
	 
			$data = array("data"=>
		
					array(	"resultado" =>  "NOTFOUND",
							"erro" => "Nenhum Registro encontrado - $where" )
			);
			$app->render ('default.php',$data,404);
		}	
		
	
	
	
	
	}
	
	
	
	function NovoJogador($app , $jsonRAW){
		GLOBAL $IDPosicao;
		$json = json_decode( $jsonRAW, true );
		IF ($json == NULL) {
			$data = array("data"=>
						
					array(	"resultado" =>  "ERRO",
							"erro" => "JSON zuado - $jsonRAW" )
			);
				
				
			$app->render ('default.php',$data,500);
			return false;
		}
		//var_dump($json);
	
		//	curl -H 'Content-Type: application/json' -X PUT -d '{"Senha":"Bruno Siqueira","Email":"Bruno Siqueira","Nome":"Bruno Siqueira"}' http://localhost/api/Jogador/New/
		/*
	
	
	
		*/
		$erro = 0;
	
		//dados cadastrais
		if (  $this->con->executa( "INSERT INTO \"JOGADOR\" ( \"NOME\", \"EMAIL\", \"SENHA\" )  
									VALUES ('".$json["Nome"]."','".$json["Email"]."','".$json["Senha"]."')
									RETURNING \"ID_JOGADOR\" ", 1 ) === false )
			$erro = 1;
		else{
			$lastInsertId =  $this->con->dados["ID_JOGADOR"];
				
		}
			     
	
			if ($erro == 0){
				//autenticado
				 
				$data = array("data"=>
						array(	"resultado" =>  "SUCESSO",
								"idJogador" => $lastInsertId
						)
				);
			}
			else {
				// nao encontrado
				$data = array("data"=>
	
						array(	"resultado" =>  "ERRO #$erro",
								"erro" => "Nao encontrado" )
				);
			}
	
			$app->render ('default.php',$data,200);
	}
	
	
	
	
	function CarregarDados($app, $idJogador){
	 
		$this->con->executa( " select  J.*, T.*
								from \"JOGADOR\" J
									LEFT JOIN \"TIME_JOGADORES\" TJ ON (TJ.\"ID_JOGADOR\" = J.\"ID_JOGADOR\")
									LEFT JOIN \"TIMES\" T ON (T.\"ID_TIME\" = TJ.\"ID_TIME\")		
								WHERE J.\"ID_JOGADOR\"= '".$idJogador."' and TJ.\"saida\" is null");
		$this->con->navega();
		
		$array["resultado"] = "SUCESSO";
		$array["Nome"] =  $this->con->dados["NOME"];
		$array["Num"] =   $this->con->dados["NUM"];
		$array["IDTime"] = $this->con->dados["ID_TIME"] ;
		$array["PWR"] = $this->con->dados["FORCA"] ;
		$array["Time"] = $this->con->dados["TIME"] ;
		$array["Peso"] =  $this->con->dados["PESO"];
		$array["Altura"] =  $this->con->dados["ALTURA"];
		$array["fotoJogador"] =  $this->con->dados["FOTOJOGADOR"];
		
		$this->con->executa( " select  COUNT(*) total_recomendacoes, 
									AVG(\"SNAKE\") notaSnake , AVG(\"BACKCENTER\") notaBackCenter, AVG(\"DORITOS\") notaDoritos, 
									AVG(\"COACH\") notaCoach, AVG(\"CORNERSNAKE\") notaCornerSnake, AVG(\"CORNERDORITOS\") notaCornerDoritos,
									AVG(\"GUNFIGHT\") notaGunfight, AVG(\"CONHECIMENTO\") notaConhecimento, AVG(\"VELOCIDADE\") notaVelocidade	
				
			 
								from \"RECOMENDACAO\" J 
								WHERE J.\"ID_RECOMENDADO\"= '".$idJogador."'  ");
		$this->con->navega();
		  
		$array["Avaliacoes"] = (($this->con->dados["total_recomendacoes"])?$this->con->dados["total_recomendacoes"] : 0) ;
		$array["notaVelocidade"] = (($this->con->dados["notavelocidade"])?$this->con->dados["notavelocidade"] : 0) ;
		$array["notaConhecimento"] = (($this->con->dados["notaconhecimento"])?$this->con->dados["notaconhecimento"] : 0) ;
		$array["notaGunfight"] = (($this->con->dados["notagunfight"])?$this->con->dados["notagunfight"] : 0) ;
		$array["notaSnake"] = (($this->con->dados["notasnake"])?$this->con->dados["notasnake"] : 0) ;
		$array["notaDoritos"] = (($this->con->dados["notadoritos"])?$this->con->dados["notadoritos"] : 0) ;
		$array["notaBackCenter"] = (($this->con->dados["notabackcenter"])?$this->con->dados["notabackcenter"] : 0) ;
		$array["notaCornerSnake"] = (($this->con->dados["notacornersnake"])?$this->con->dados["notacornersnake"] : 0) ;
		$array["notaCornerDoritos"] = (($this->con->dados["notacornerdoritos"])?$this->con->dados["notacornerdoritos"] : 0) ;
		$array["notaCoach"] = (($this->con->dados["notacoach"])?$this->con->dados["notacoach"] : 0) ;
		
		$array["notaVelocidade"] = (($this->con->dados["notavelocidade"])?$this->con->dados["notavelocidade"] : 0) ;
		$array["notaGunfight"] = (($this->con->dados["notagunfight"])?$this->con->dados["notagunfight"] : 0) ;
		$array["notaConhecimento"] = (($this->con->dados["notaconhecimento"])?$this->con->dados["notaconhecimento"] : 0) ;
		
		
		// carregando posicoes do jogador
		$this->con->executa( " select  *
								from \"JOGADOR_POSICOES\" 
								WHERE \"ID_JOGADOR\"= '".$idJogador."'");
	//	$this->con->navega();
		$i=0;
		while ($this->con->navega(0)){
				$array["POSICOES_JOGADOR"][$i]["ID_POSICAO"]  = $this->con->dados["ID_POSICAO"];
			$i++;
		}
		//$array[] = $array2;		
		//$data =  	$array;
		

		// carregando posicoes do jogador NO TIME
		$this->con->executa( "select * 
from \"TIME_JOGADOR_POSICOES\" tjp
	left join \"TIME_JOGADORES\" tj ON (tj.\"ID_TIME_JOGADOR\"  = tjp.\"ID_TIME_JOGADOR\")
WHERE tj.\"ID_JOGADOR\" =   '".$idJogador."'");
		//	$this->con->navega();
		$i=0;
		while ($this->con->navega(0)){
			$array["POSICOES_JOGADOR_NO_TIME"][$i]["ID_POSICAO"]  = $this->con->dados["ID_POSICAO"];
			$i++;
		}
		//$array[] = $array2;
		$data =  	$array;
		
		
		
		$app->render ('default.php',$data,200);
				
		
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
		
	//	curl -H 'Content-Type: application/json' -X PUT -d '{"TIMECornerSnake":"1","CornerDoritos":"0","Snake":"0","Num":"13","TIMEDoritos":"0","TIMECornerDoritos":"1","nomeJogador":"Bruno Siqueira","TIMESnake":"1","Coach":"0","CornerSnake":"0","Peso":"100","TIMECoach":"0","TIMEBackCenter":"0","BackCenter":"0","Altura":"1,78","Time":"3","Doritos":"0"}' http://localhost/api/Jogadores/2/
/*
 

  
	 							*/
		$erro = 0;

		//dados cadastrais
	 	if (  $this->con->executa( "UPDATE \"JOGADOR\" SET
	 							\"NOME\"= '".$json["nomeJogador"]   ."',
	 							\"PESO\"= '".$json["Peso"]   ."',
	 							\"ALTURA\"= '".$json["Altura"]   ."',
	 							\"NUM\"= '".$json["Num"]."',
	 							\"FOTOJOGADOR\"= '".$json["fotoJogador"]."'
	 						WHERE \"ID_JOGADOR\"  = '".$idJogador."' ") === false ) 
	 		$erro = 1;
	 						
	 		// relacionando jogador ao time
	 		$this->con->executa( "SELECT * FROM \"TIME_JOGADORES\" WHERE \"ID_JOGADOR\" = '".$idJogador."' and saida is null ");
	 		$this->con->navega();
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
			$this->con->navega();
			$idTimeJogador = $this->con->dados["ID_TIME_JOGADOR"];	
 			
			if ( $idTimeJogador > 0)
			{
				// ajustando posicoes do jogador NO TIME
				foreach ($IDPosicao  as $key => $value){
						echo " \n checkando... $key $value --- ".$json[$key];
				
					$this->con->executa( "SELECT * FROM \"TIME_JOGADOR_POSICOES\" WHERE \"ID_POSICAO\" = '".$value."' AND \"ID_TIME_JOGADOR\" = '".$idTimeJogador."' ");
					$this->con->navega();
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
 			$this->con->navega();
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
	 						
	 				array(	"resultado" =>  "ERRO #$erro",
	 						"erro" => "Nao encontrado" )
	 		);	 		
	 	} 

		$app->render ('default.php',$data,200);
	}
}