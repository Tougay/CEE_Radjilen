  <!-- Styles CSS personnalisés -->
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
            background-color: #fff;
            display: block;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            color: #007bff;
            transition: background-color 0.3s, color 0.3s;
        }

        a:hover {
            background-color: #007bff;
            color: #fff;
        }
    </style>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Examens</title>
</head>
<body>
    <h1>Liste des Examens Disponibles</h1>

    <ul>
    <?php
// Connexion à la base de données
$conn = new PDO("mysql:host=localhost;dbname=cee_db", "root", "");

// Sélectionnez tous les examens disponibles depuis la base de données
$query = $conn->query("SELECT * FROM exam_tbl");

while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    echo "<li><a href='compose_exam.php?id={$row['ex_id']}'>{$row['titre']}</a></li>";
}
// Fermer la connexion à la base de données
$conn = null;
?>

    </ul>
</body>
</html>


