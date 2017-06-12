<?php

//Create database if not exists
try {
    
    $pdo = new PDO('mysql:host=localhost', 'root', '', 
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
    );
	$request = "CREATE DATABASE IF NOT EXISTS live_react DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci";
    $pdo->prepare($request)->execute();
    

} catch (PDOException $e) {
	print("Erreur lors de la création de la base de données : " . $e->getMessage());
	die();
}

//Connect to database
//Create table if not exists
try {

	$db = new PDO('mysql:host=localhost;dbname=live_react', 'root', '');
    
    $sql = "CREATE TABLE IF NOT EXISTS buttons  (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
        image_src VARCHAR(255) NULL,
        audio_src VARCHAR(255) NULL
        )";
    $db->exec($sql);
    

} catch (PDOException $e) {
	print("Erreur lors de la connexion à la base de données : " . $e->getMessage());
	die();
}
