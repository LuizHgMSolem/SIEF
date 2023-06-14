<?php
$servidor = "localhost";
$host = 'root';
$password = "";
$dbname = "sief";
$port = "3308";

$conn = new PDO("mysql:host=$servidor;port=$port;dbname=$dbname",$host,$password );



?>