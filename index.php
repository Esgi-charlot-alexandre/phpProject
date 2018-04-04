<?php 
	session_start();
	require("conf/config.php");

	function myAutoloader ($class) {
		$class = $class .".class.php";
		if ( file_exists("core/".$class) ){
			include "core/".$class;
		} else if ( file_exists("models/".$class) ){
			include "models/".$class;
		}
	}

	spl_autoload_register("myAutoloader");

	$uri = substr(urldecode($_SERVER["REQUEST_URI"]), strlen(dirname($_SERVER["SCRIPT_NAME"])));
	$uri = ltrim($uri, "/");
	$uri = explode("?", $uri);
	$uriExploded = explode("/", $uri[0]);

	//Utiliser des conditions ternaires pour mettre la chaine
	//"index" si la clé n'existe pas :
	$c = (empty($uriExploded[0]))?"index":$uriExploded[0];
	$a = (empty($uriExploded[1]))?"index":$uriExploded[1];

	//Controller : NomController
	$c = ucfirst(strtolower($c))."Controller";
	//Action : nomAction
	$a = strtolower($a)."Action";

	unset($uriExploded[0]);
	unset($uriExploded[1]);

	$uriExploded = array_values($uriExploded);

	$params = [
		"POST"=>$_POST,
		"GET"=>$_GET,
		"URL"=>$uriExploded
	];

	if(file_exists("controllers/".$c.".class.php")){

		include "controllers/".$c.".class.php";

		if (class_exists($c)) {
			$objC = new $c();

			if (method_exists($objC, $a)) {
				$objC->$a($params);
			} else {
				die("L'action ".$a." n'existe pas");
			}
		} else {
			die("Le controller ".$c." n'existe pas");
		}
	} else {
		die("Le fichier ".$c." n'existe pas");
	}






