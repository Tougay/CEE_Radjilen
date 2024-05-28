<link rel="stylesheet" type="text/css" href="css/mycss.css">
<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div>RÉSULTAT DE L'EXAMINÉ</div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-header">candidat Résultat</div>
                <div class="table-responsive">
                    <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="tableList">
                        <thead>
                            <tr>
                                <th>Nom et prénom</th>
                                <th>Nom de l'examen</th>
                                <th>Résultat du candidat (%)</th> <!-- Nouvelle colonne pour le résultat du candidat -->
                            </tr>
                        </thead>
                        <tbody>
<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=cee_db", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "
    SELECT 
        et.exmne_fullname AS Nom_du_candidat,
        c.cou_name AS Nom_de_l_examen,
        e.similarite AS Résultat_de_la_similarité
    FROM 
        examinee_tbl et
    JOIN 
        exam_tbl e ON et.exmne_course = e.cou_id
    JOIN 
        course_tbl c ON e.cou_id = c.cou_id";

    $result = $pdo->query($query);

     if ($result->rowCount() > 0) {
                                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<tr>";
                                        echo "<td>" . $row['Nom_du_candidat'] . "</td>";
                                        echo "<td>" . $row['Nom_de_l_examen'] . "</td>";
                                        echo "<td>" . $row['Résultat_de_la_similarité'] . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='3'>Aucun résultat trouvé.</td></tr>";
                                }
                            } catch (PDOException $e) {
                                echo "Erreur: " . $e->getMessage();
                            }


?>




                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
