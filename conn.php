<?php 

$host = "localhost";
$user = "root";
$pass = "";
$db   = "cee_db";
$conn = null;

try {
  // Spécifiez le jeu de caractères utf8 lors de la connexion
  $conn = new PDO("mysql:host={$host};dbname={$db};charset=utf8",$user,$pass);
  // Définissez le mode d'erreur PDO sur exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
  // Gérez les exceptions de connexion
  echo "Erreur de connexion : " . $e->getMessage();
}
?>
