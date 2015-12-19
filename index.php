<?php
error_reporting(E_ALL ^ E_DEPRECATED);
// phpinfo();


//adt for windows 64 http://dl.google.com/android/adt/adt-bundle-windows-x86_64-20140702.zip
// commit feito pelo mac
require_Once("classes/globais.php");
require_Once("classes/class_Auth.php");
require_Once("classes/class_Feed.php");
require_Once("classes/class_Jogador.php");


require 'vendor/autoload.php';
// tentando commitar pro github 
 
//instancie o objeto
$app = new \Slim\Slim( array(
    'debug' => true,
    'templates.path' => './templates'
) );
\Slim\Slim::registerAutoloader();
 
//defina a rota
$app->get('/Auth/:login/:senha/', function ($login, $senha) use ($app)  {
		$api = new Auth();
		$api->Autenticar($login,$senha,$app);
	}  ); 

$app->put('/Jogadores/:idJogador/', function ($idJogador ) use ($app)  {
	$Jog = new Jogador();
	$Jog->Alterar($app, $idJogador,$app->request->getBody() );
}  );
$app->put('/Jogador/New/', function (  ) use ($app)  {
	$Jog = new Jogador();
	$Jog->NovoJogador($app,  $app->request->getBody() );
}  );

$app->get('/Jogador/:idJogador/', function ($idJogador) use ($app)  {
	$Jog = new Jogador();
	$Jog->CarregarDados($app, $idJogador );
}  ); 

$app->get('/Feed/', function ( ) use ($app)  {
	$Feed = new Feed();
	$Feed->CarregarFeed($app );
}  );

$app->put('/RegistrarFeed/', function ( ) use ($app)  {
	$Feed = new Feed();
	$Feed->RegistrarFeed( $app, $app->request->getBody() );
}  );
	
/*
//defina a rota
$app->get('/teste/', function () use ($app) {
	$data = array("data"=>array("H     aaaaaello World- "));
	$app->render ('default.php',$data,200);
});
*/

//rode a aplicação Slim 
$app->run();
