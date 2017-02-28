<?php
function connexion() {
	try {
		return new PDO('pgsql:host=91.121.160.11;port=5432;dbname=dbdisco', 'dbdisco', 'passsword');	
	} catch (PDOException $e) {
		die('Connection failed: ' . $e->getMessage());	
	}
}
