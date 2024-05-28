<?php
include("../../../conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    extract($_POST);

    // Vérifiez si tous les champs nécessaires sont définis
    if (isset($courseSelected, $timeLimit, $examTitle, $examDesc, $reponse_attendue)) {
        // Vérifiez si un examen avec les mêmes données existe déjà
        $checkExam = $conn->prepare("SELECT * FROM exam_tbl WHERE cou_id = ? AND titre = ? AND ex_time_limit = ? AND contenu = ? AND reponse_attendue = ?");
        $checkExam->execute([$courseSelected, $examTitle, $timeLimit, $examDesc, $reponse_attendue]);

        if ($checkExam->rowCount() > 0) {
            // L'examen existe déjà, affichez un message d'erreur
            $res = array("res" => "duplicate");
        } else {
            // Encoder la réponse attendue en UTF-8
            $reponse_attendue_encoded = mb_convert_encoding($reponse_attendue, "UTF-8");

            // L'examen n'existe pas, insérez les données dans la base de données
            $insExam = $conn->prepare("INSERT INTO exam_tbl (cou_id, titre, ex_time_limit, contenu, reponse_attendue) VALUES (?, ?, ?, ?, ?)");
            if ($insExam->execute([$courseSelected, $examTitle, $timeLimit, $examDesc, $reponse_attendue_encoded])) {
                $res = array("res" => "success", "examTitle" => $examTitle);
            } else {
                $res = array("res" => "failed", "examTitle" => $examTitle);
            }
        }
    } else {
        $res = array("res" => "missingFields");
    }
} else {
    $res = array("res" => "invalidMethod");
}

echo json_encode($res);


?>
