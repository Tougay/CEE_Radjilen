<div class="app-main__outer">
        <div class="app-main__inner">
             <?php 
    @$exam_id = $_GET['exam_id'];

    if($exam_id != "") {
        $selEx = $conn->query("SELECT * FROM exam_tbl WHERE ex_id='$exam_id' ")->fetch(PDO::FETCH_ASSOC);
        $exam_course = $selEx['cou_id'];

        // Récupérer les informations des candidats pour cet examen
        $selExmne = $conn->query("SELECT * FROM examinee_tbl WHERE exmne_course='$exam_course'");
        ?>

        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div><b class="text-primary">CLASSEMENT PAR EXAMEN</b><br>
                        Exam Name : <?php echo $selEx['titre']; ?><br><br>
                        <span class="border" style="padding:10px;color:black;background-color: yellow;">Excellence</span>
                        <span class="border" style="padding:10px;color:white;background-color: green;">Très bien</span>
                        <span class="border" style="padding:10px;color:white;background-color: blue;">Bien</span>
                        <span class="border" style="padding:10px;color:white;background-color: red;">Échoué</span>
                        <span class="border" style="padding:10px;color:black;background-color: #E9ECEE;">Ne pas répondre</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="tableList">
                <thead>
                    <tr>
                        <th width="25%">Nom complet du candidat</th>
                        <th>Pourcentage</th>
                        <th>Classement</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $rank = 1;
                    while ($selExmneRow = $selExmne->fetch(PDO::FETCH_ASSOC)) {
                        // Calculer le pourcentage pour chaque candidat (à adapter selon vos besoins)
                        $pourcentage = $selExmneRow['score'] * 100; // Supposons que le score soit déjà en pourcentage

                        // Déterminer le classement en fonction du pourcentage
                        $classement = "";
                        if ($pourcentage >= 90) {
                            $classement = "Excellence";
                        } elseif ($pourcentage >= 80) {
                            $classement = "Très bien";
                        } elseif ($pourcentage >= 70) {
                            $classement = "Bien";
                        } else {
                            $classement = "Échoué";
                        }
                        ?>
                        <tr>
                            <td><?php echo $selExmneRow['nom_complet']; ?></td>
                            <td><?php echo $pourcentage . "%"; ?></td>
                            <td><?php echo $classement; ?></td>
                        </tr>
                        <?php
                        $rank++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    <?php
    } else { 
    ?>
        <!-- Votre code HTML pour la liste des examens -->
    <?php } 
?>

                <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div><b>CLASSEMENT PAR EXAMEN</b></div>
                    </div>
                </div>
                </div> 

                 <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">Liste des examens
                    </div>
                    <div class="table-responsive">
                        <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="tableList">
                            <thead>
                            <tr>
                                <th class="text-left pl-4">Titre de l'examen</th>
                                <th class="text-left ">Cours</th>
                                <th class="text-left ">Description</th>
                                <th class="text-center" width="8%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                              <?php 
                                $selExam = $conn->query("SELECT * FROM exam_tbl ORDER BY ex_id DESC ");
                                if($selExam->rowCount() > 0)
                                {
                                    while ($selExamRow = $selExam->fetch(PDO::FETCH_ASSOC)) { ?>
                                        <tr>
                                            <td class="pl-4"><?php echo $selExamRow['titre']; ?></td>
                                            <td>
                                                <?php 
                                                    $courseId =  $selExamRow['cou_id']; 
                                                    $selCourse = $conn->query("SELECT * FROM course_tbl WHERE cou_id='$courseId' ");
                                                    while ($selCourseRow = $selCourse->fetch(PDO::FETCH_ASSOC)) {
                                                        echo $selCourseRow['cou_name'];
                                                    }
                                                ?>
                                            </td>
                                            <td><?php echo $selExamRow['contenu']; ?></td>
											
                                            <td class="text-center">
                                             <a href="?page=ranking-exam&exam_id=<?php echo $selExamRow['ex_id']; ?>"  class="btn btn-success btn-sm">View</a>
                                            </td>
                                        </tr>

                                    <?php }
                                }
                                else
                                { ?>
                                    <tr>
                                      <td colspan="5">
                                        <h3 class="p-3">Aucun examen trouvé</h3>
                                      </td>
                                    </tr>
                                <?php }
                               ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>   
                    
                <?php }

             ?>      
            
            
      
        
</div>
         


















