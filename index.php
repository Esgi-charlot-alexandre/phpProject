<?php
// namespace Tester;
require("conf/config.php");

function myAutoLoad ($class) {
	$class = $class.'.class.php';
	if(file_exists('core/'.$class)) {
		include 'core/'.$class;
	}
}

spl_autoload_register('myAutoLoad');

// Yaml::parse(file_get_contents('/conf/ressources/routing.yml'));
// var_dump(yaml_parse());

$URI = explode("?", $_SERVER["REQUEST_URI"]);


$URI = str_ireplace(DIRNAME, "", urldecode($URI[0]));

$URIExploded = explode(DS, $URI);


$c = (empty($URIExploded[0]) ? "IndexController" : ucfirst(strtolower($URIExploded[0]))."Controller");
$a = (empty($URIExploded[1]) ? "indexAction" : strtolower($URIExploded[1])."Action");
unset($URIExploded[0]);
unset($URIExploded[1]);

$params = ["POST" => $_POST, "GET"=> $_GET, "URL" => array_values($URIExploded)];

if (file_exists("controllers/".$c.".php")) {
	include("controllers/".$c.".php");
	if(class_exists($c))
	{
		$oCtrl = new $c();
		if(method_exists($oCtrl, $a))
		{
			$oCtrl->$a($params);
		}
	}
}
