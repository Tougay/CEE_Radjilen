<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Traitement du Sujet de Dissertation</title>
    <style>
        /* Styles pour le corps de la page */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        /* Styles pour le conteneur du résultat */
        .result-container {
            background-color: #fff;
            padding: 20px;
            margin: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
        /* Styles pour le bouton de soumission */
        .submit-button {
            background-color: #337ab7;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        /* Styles pour le TinyMCE (éditeur de texte) */
        #reponse {
            width: 100%;
            min-height: 300px;
        }
    </style>
</head>
<body>
    <h1>Traitement du Sujet</h1>
   	
<?php
$pdo = new PDO("mysql:host=localhost;dbname=cee_db;charset=utf8", "root", "");

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Vérifier si l'examen a déjà été soumis par l'étudiant
$stmt = $pdo->prepare("SELECT submitted FROM exam_tbl WHERE ex_id = :examId");
$stmt->bindParam(":examId", $id_examen);
$stmt->execute();
$examenSoumis = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT evaluated FROM exam_tbl WHERE ex_id = :examId");
$stmt->bindParam(":examId", $id_examen);
$stmt->execute();
$examenEvalue = $stmt->fetchColumn();

if ($_SERVER["REQUEST_METHOD"] == "POST" && !$examenEvalue) {
    if (isset($_POST["ex_id"])) {
        $id_examen = $_POST["ex_id"];

        // Récupérer la réponse attendue de la base de données
        $stmt_reponse_attendue = $pdo->prepare("SELECT reponse_attendue FROM exam_tbl WHERE ex_id = ?");
        $stmt_reponse_attendue->execute([$id_examen]);
        $reponse_attendue = $stmt_reponse_attendue->fetchColumn();

        // Récupérer la réponse du candidat du formulaire
        $reponse_candidat = $_POST["reponse"];

        // Assurer que les chemins des fichiers sont corrects
        $chemin_script_python = "votre_script_python.py"; // Remplacer par le chemin correct vers votre script Python

        // Commande pour exécuter le script Python avec les réponses du candidat et de l'attendu
        $reponse_candidat_cleaned = escapeshellarg($reponse_candidat);
        $reponse_attendue_cleaned = escapeshellarg($reponse_attendue);
        $commande = "python $chemin_script_python $reponse_candidat_cleaned $reponse_attendue_cleaned";

        // Exécuter la commande et récupérer la sortie du script Python
        $resultat_similarite = shell_exec($commande);

        if ($resultat_similarite === null) {
            echo "<p>Erreur lors de l'exécution de la commande shell.</p>";
        } else {
            // Afficher le résultat
            echo "<div class='result-container'>";
//            echo "<h2>Résultat de la Dissertation</h2>";
//            echo "<p>Reponse du candidat :</p>";
//            echo "<p>" . $reponse_candidat . "</p>";
            echo "<p> " . $resultat_similarite . "</p>";

            // Nettoyer les balises HTML et décoder les entités HTML
            $reponse_candidat_nettoyee = html_entity_decode(strip_tags($reponse_candidat), ENT_QUOTES);

            // Insérer la réponse dans la table exam_tbl
            $stmt = $pdo->prepare("UPDATE exam_tbl SET submitted = 1, reponse_candidat = :reponseCandidat WHERE ex_id = :examId");
            $stmt->bindParam(":reponseCandidat", $reponse_candidat_nettoyee);
            $stmt->bindParam(":examId", $id_examen);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                echo "<p>Réponse du candidat enregistrée avec succès dans la base de données.</p>";
            } else {
                echo "<p>Erreur lors de l'enregistrement de la réponse du candidat dans la base de données.</p>";
            }
            echo "</div>"; // Fin du conteneur de résultat
        }
    }
}
?>

<!-- Autres éléments HTML -->

</body>
</html>

<!-- Inclure le script d'initialisation de TinyMCE ici -->
<!-- Votre code HTML -->

<script src="https://cdn.tiny.cloud/1/itz90trdx5moulfbq91uzbo5hkqith8sho2z6bo63rk1xwmh/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<script>
    // Initialisez TinyMCE ici pour le champ "reponse"
    tinymce.init({
        selector: "#reponse",
        // Autres options de configuration...
        forced_root_block: "", // Empêche l'ajout automatique de balises <p>
        force_br_newlines: true,
        force_p_newlines: false,
        valid_elements: "*[*]" // Autoriser tous les éléments
    });
</script>
