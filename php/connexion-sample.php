<?php
function connexion() {
	try {
		return new PDO('pgsql:host=localhost;port=5432;dbname=dbdisco', 'dbdisco', 'passsword');	
	} catch (PDOException $e) {
		die('Connection failed: ' . $e->getMessage());	
	}
}
