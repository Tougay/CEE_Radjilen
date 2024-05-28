<?php
// Connexion à la base de données
$pdo = new PDO("mysql:host=localhost;dbname=cee_db", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_GET['exam_id'])) {
    $examId = $_GET['exam_id'];

    // Requête pour récupérer la durée de l'examen depuis la base de données
    $stmt = $pdo->prepare("SELECT ex_time_limit FROM exam_tbl WHERE ex_id = :examId");
    $stmt->bindParam(":examId", $examId);
    $stmt->execute();

    $examDuration = $stmt->fetchColumn();

    // Renvoyer la durée de l'examen en secondes
    echo $examDuration;
} else {
    echo "ID de l'examen non spécifié";
}
?>
