<?php
session_start();

if ($_SERVER['REQUEST_METHOD']=='GET') {
  header("Location: ../cadastrar.php");
  exit();
}

include_once('conexao.php');



$cadastro = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$json = file_get_contents("../login.json");
$jsonRegistrado = json_decode($json, true);


foreach ($jsonRegistrado['login'] as $numlogin => $loginRegistrado) {
  if ($cadastro['email'] === $loginRegistrado["email"]) {
    $_SESSION["registroExiste"]= true;
    header("Location: ../cadastrar.php"); 
    exit(); 
  }else{
    $_SESSION["registroExiste"] = false;
  }
}

if (!$_SESSION["registroExiste"]) {
  $jsonRegistrado["login"][] = ["email" => $cadastro["email"], "senha" => $cadastro["password"]];
  $newJsonCad = json_encode($jsonRegistrado);
  var_dump($jsonRegistrado);
  file_put_contents("../login.json",$newJsonCad);
  header("Location: ../cadastrar.php"); 
}

?>

