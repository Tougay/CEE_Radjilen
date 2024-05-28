<?php 
session_start();

if (!isset($_SESSION['examineeSession']['examineenakalogin'])) {
    header("location:index.php");
    exit; // Arrêter l'exécution du script après la redirection
}
?>
<?php include("conn.php"); ?>
<!-- MAO NI ANG HEADER -->
<?php include("includes/header.php"); ?>      

<!-- UI THEME DIRI -->
<?php include("includes/ui-theme.php"); ?>

<div class="app-main">
    <!-- sidebar diri  -->


     <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            background-color: #007bff;
            color: #fff;
            padding: 20px;
            margin: 0;
        }

        ul {
            list-style-type: none;
            padding: 0;
            margin: 20px;
        }

        li {
            margin-bottom: 10px;
        }

        a {
            text-decoration: none;
            background-color: #007bff;
            display: block;
            padding: 10px;
            border: 1px solid #007bff;
            border-radius: 5px;
            color: #fff;
            transition: background-color 0.3s, border-color 0.3s;
        }

        a:hover {
            background-color: #fff;
            border-color: #007bff;
            color: #007bff;
        }
    </style>


    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Liste de Vos Examens</title>
    </head>
    <body>
        <h1>Liste de Vos Examens</h1>

        <ul>
            <?php
            try {
                // Connexion à la base de données
                $conn = new PDO("mysql:host=localhost;dbname=cee_db", "root", "");
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $exmneId = $_SESSION['examineeSession']['exmne_id'];

                // Sélectionner les données de l'examiné
                $selExmneeData = $conn->query("SELECT * FROM examinee_tbl WHERE exmne_id='$exmneId' ")->fetch(PDO::FETCH_ASSOC);
                $exmneCourse =  $selExmneeData['exmne_course'];

                // Sélectionner les examens en fonction du cours de l'examiné
                $selExam = $conn->query("SELECT * FROM exam_tbl WHERE cou_id='$exmneCourse' ORDER BY ex_id DESC ");

                if ($selExam->rowCount() > 0) {
                    while ($row = $selExam->fetch(PDO::FETCH_ASSOC)) {
                        echo "<li><a href='includes/compose_exam.php?id={$row['ex_id']}'>{$row['titre']}</a></li>";
                    }
                } else {
                    echo "<li>Aucun examen trouvé pour cet étudiant</li>";
                }
            } catch (PDOException $e) {
                echo "Erreur: " . $e->getMessage();
            } finally {
                // Fermer la connexion à la base de données
                $conn = null;
            }
            ?>
        </ul>
    </body>
    </html>

    <!-- MAO NI IYA FOOTER -->
    <?php include("includes/footer.php"); ?>
    <?php include("includes/modals.php"); ?>
</div>
