<?php
error_reporting(E_ALL ^ E_DEPRECATED);
// phpinfo();

// commit feito pelo mac
require_Once("classes/class_api.php");

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
	$api = new api();
	$api->Auth($login,$senha,$app);
	
	
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
