<?php 

define("DBUSER","root");
define("DBPWD","root");
define("DBHOST","database");
define("DBNAME","database");
define("DBPORT","3306");

define("DS", "/");

$scriptName = (dirname($_SERVER["SCRIPT_NAME"])) ? '' : dirname($_SERVEUR['SCRIPT_NAME']);

define("DIRNAME", $scriptName.DS);


