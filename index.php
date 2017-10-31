<?php
session_start();

include 'php/lib.php';

if (isset($_POST['usersql'])) {	
	$usersql = $_POST['usersql'];
}
if (isset($_GET['deleteall'])) {	
	$deleteall = $_GET['deleteall'];
}
else {
	$deleteall = false;
}

/** Connexion **/
$conn = connexion();

/** Schema déjà existant dans la session on va le reprendre, sinon on en créé un nouveau **/
if (isset($_SESSION['schema'])) {
	$schema = $_SESSION['schema'];
}
else {
	$schema = generateRandomString(7);
	$_SESSION['schema'] = $schema;	
	$sql = 'CREATE SCHEMA ' . $schema;
	$res = $conn->exec($sql);
	if ($res===false) {
		$err = $conn->errorInfo();
		echo ('Database can not be created, contact the administrator\n');
		die('Technical message : *Schema not created* '  . 'Schema ' . $schema . $err[2]);
	}	
}

/** DB reinitialization  **/
if ($deleteall) {
	$sql = 'DROP SCHEMA ' . $schema . ' CASCADE';
	$res = $conn->exec($sql);
	if ($res===false) {
		$err = $conn->errorInfo();
		echo ('Database can not be reinitialized, contact the administrator\n');
		die('Technical message : *Schema not dropped* '  . 'Schema ' . $schema . $err[2]);
	}
	$sql = 'CREATE SCHEMA ' . $schema;
	$res = $conn->exec($sql);
	if ($res===false) {
		$err = $conn->errorInfo();
		echo ('Database can not be reinitialized, contact the administrator\n');
		die('Technical message : *Schema not dropped* '  . 'Schema ' . $schema . $err[2]);
	}
}

/** search path **/
$sql = 'SET search_path TO ' . $schema;
$res=$conn->exec($sql);
if ($res===false) {
	$err = $conn->errorInfo();
	session_unset(); // on vide la variable schema qui ne fonctionne pas
	echo('Inexpected error, the current database will be lost if exists, refresh the web page to initiate a new database<br>');
	die('Technical message : *Search_path not setted* : ' .  'Schema ' . $schema . $err[2] );
}



/** HTML **/
printHtmlBegin($schema);
if (isset($usersql)) {
	printHtmlForm($usersql);
}
else {
	printHtmlForm();
}

if (isset($usersql) && $usersql != '') {
	execUserSql($conn, $usersql);
}

printBdContent($conn, $schema);

printHtmlEnd();

?>
