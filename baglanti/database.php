<?php
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'db';

try{
	$conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
} catch(PDOException $e){
	die( "Bağlantı sağlanamadı: " . $e->getMessage());
}