<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Composition de l'Examen</title>
    <!-- Inclure le lien vers TinyMCE dans le head si ce n'est pas déjà fait -->
   
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- UI THEME DIRI -->

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        h1 {
            background-color: #007bff;
            color: #fff;
            padding: 20px;
            margin: 0;
        }

        h2 {
            font-size: 24px;
            margin: 20px 0;
        }

        p {
            font-size: 18px;
        }

        form {
            margin-top: 20px;
        }

        textarea {
            width: 100%;
            height: 200px;
            padding: 10px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 18px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
        }
    </style>

</head>
<body>

<?php 
// Votre code PHP pour récupérer les données de l'examen...
$examId = $_GET["id"];
$pdo = new PDO("mysql:host=localhost;dbname=cee_db", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $pdo->prepare("SELECT * FROM exam_tbl WHERE ex_id = :examId");
$stmt->bindParam(":examId", $examId);
$stmt->execute();
$examen = $stmt->fetch(PDO::FETCH_ASSOC);

$selExamTimeLimit = $examen['ex_time_limit'];
?>

<h1>Composition de l'Examen</h1>

<div class="page-title-actions mr-5" style="font-size: 20px;">
    <form name="cd">
        <input type="hidden" name="" id="timeExamLimit" value="<?php echo $selExamTimeLimit ?>">
        <label>Temps restant : </label>
        <!-- Affichage du temps restant directement depuis la base de données -->
        <input style="border:none;background-color: transparent;color:blue;font-size: 25px;" name="disp" type="text" class="clock" id="txt" value="<?php echo $selExamTimeLimit; ?>" size="5" readonly="true" />
    </form>
</div>

<?php
if (isset($_GET["id"])) {
    $examId = $_GET["id"];
    $pdo = new PDO("mysql:host=localhost;dbname=cee_db", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vérifier s'il y a un examen correspondant à l'ID
    $stmt = $pdo->prepare("SELECT * FROM exam_tbl WHERE ex_id = :examId");
    $stmt->bindParam(":examId", $examId);
    $stmt->execute();
    $examen = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($examen) {
        echo "<h2>{$examen['titre']}</h2>";
        echo "<p>{$examen['contenu']}</p>";

        // Vérifier la méthode de requête HTTP
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $reponse_candidat = $_POST["reponse"];
            $stmt = $pdo->prepare("UPDATE exam_tbl SET reponse_candidat = :reponse WHERE ex_id = :examId");
            $stmt->bindParam(":reponse", $reponse_candidat);
            $stmt->bindParam(":examId", $examId);
            $stmt->execute();
        } else {
            // Vérifier si l'examen a déjà été soumis par l'étudiant
            $examenSoumis = false; // Remplacer par votre logique de vérification dans la base de données

            if ($examenSoumis) {
                echo "<p>Vous avez déjà soumis cet examen. Vous ne pouvez pas le soumettre à nouveau.</p>";
            } else {
                // Formulaire pour composer l'examen
                echo "<form action='traitement.php' method='POST' accept-charset='\UTF-8'>";
                echo "<input type='hidden' name='ex_id' value='{$examId}'>";
                echo "<textarea id='reponse' name='reponse' rows='10' cols='80'></textarea><br>";
                echo "<input type='submit' value='Soumettre la Réponse'>";
                echo "</form>";
            }
        }
    }
}
        
?>
 

    <!-- Inclure le script d'initialisation de TinyMCE ici -->
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
<script type="text/javascript">
    $(document).ready(function() {
        "use strict";

        function startCountdown(endtime) {
            var deadline = Date.now() + (endtime * 60 * 1000);

            var clock = $('#txt');

            function updateClock() {
                var t = getTimeRemaining(deadline);

                var minutes = ('0' + t.minutes).slice(-2);
                var seconds = ('0' + t.seconds).slice(-2);

                clock.val(minutes + ":" + seconds);

                if (t.total <= 0) {
                    clearInterval(timeinterval);
                    // Affichage d'une boîte de dialogue lorsque le temps est écoulé
                    alert("Le temps est écoulé !");
                    // Désactiver le formulaire pour empêcher l'utilisateur de soumettre la réponse
                    $('form').find('input, textarea, button, select').prop('disabled', true);
                }
            }

            updateClock();
            var timeinterval = setInterval(updateClock, 1000);
        }

        function getTimeRemaining(endtime) {
            var total = endtime - Date.now();
            var minutes = Math.floor((total / 1000 / 60) % 60);
            var seconds = Math.floor((total / 1000) % 60);

            return {
                'total': total,
                'minutes': minutes,
                'seconds': seconds
            };
        }

        // Démarrer le compte à rebours avec le temps restant de la base de données
        startCountdown(<?php echo $selExamTimeLimit; ?>);
    });
</script>

<script src="../login-ui/vendor/countdowntime/countdowntime.js"></script>
<script src="countdown.js"></script>

</body>
  
</html>





