<?php


// Écrivez votre logique pour obtenir l'ID de l'examen actuel pour le candidat ici
// Par exemple, vous pouvez utiliser les données de session ou d'autres informations pour obtenir l'ID de l'examen
$pdo = new PDO("mysql:host=localhost;dbname=cee_db", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// Exemple: récupération de l'ID de l'examen pour le candidat à partir de la session
// ...

// Exemple de récupération de l'ID de l'examen pour le candidat à partir de la session
session_start();
if (isset($_SESSION['examineeSession']['exmne_id'])) {
    $exmneId = $_SESSION['examineeSession']['exmne_id'];

    // Écrivez votre requête SQL pour obtenir l'ID de l'examen actuel en fonction de l'ID du candidat
    $sql = "SELECT cou_id FROM exam_tbl WHERE exmne_id = $exmneId";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Récupérer la première ligne de résultat (vous pouvez adapter cela à votre logique)
        $row = $result->fetch_assoc();
        $currentExamId = $row["exam_id"];

        // Envoyer l'ID de l'examen actuel en réponse à la requête AJAX
        echo $currentExamId;
    } else {
        echo "Aucun examen en cours pour ce candidat";
    }
} else {
    echo "Session non trouvée";
}

// ...

// Fermer la connexion à la base de données
$conn->close();
?>
