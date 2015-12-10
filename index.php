<?php
// phpinfo();

// commit feito pelo mac
require_Once("classes/class_db.php");

$con = new db();
$con->conecta();

require 'vendor/autoload.php';
// tentando commitar pro github 
 
//instancie o objeto
$app = new \Slim\Slim( array(
    'debug' => true,
     'templates.path' => './templates'
) );
\Slim\Slim::registerAutoloader();
 
//defina a rota
$app->get('/bruno/:first/:last/', function ($first, $last) use ($app) { 
	$data = array("data"=>array("H $first $last aaaaaello World"));
	$app->render ('default.php',$data,200);
}); 

//defina a rota
$app->get('/teste/', function () use ($app) {
	$data = array("data"=>array("H     aaaaaello World- "));
	$app->render ('default.php',$data,200);
});



//rode a aplicação Slim 
$app->run();
