<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Convertir somme</title>
</head>
<body>
<form method="POST">

    <input type="number" id="somme" placeholder="Somme à convertir" name="cfa">
    <br>

    <button type="submit">Convertir</button>
    <br>
</form>

<?php

$valeur = isset($_POST["cfa"]) ? $_POST["cfa"] : "";
$jour_saisi = date('Y-m-d');

if (is_numeric($valeur) && $valeur >= 0) {
    $convert = number_format($valeur * 655, 2); 
    echo '<input type="text" name=""  value="' . $convert .  '">';
    
    if (!isset($_SESSION['historique'])) {
        $_SESSION['historique'] = array();
    }

    $nouvelleSaisie = "$valeur => $convert => $jour_saisi";
    $_SESSION['historique'][] = $nouvelleSaisie;
    header("Location: {$_SERVER['PHP_SELF']}");
        exit;
}
else {
    print '<pre>Le nombre est négatif, entrez du positif'.'<pre>';
}

if (isset($_SESSION['historique'])) {
    $currentDate = null;

    foreach ($_SESSION['historique'] as $saisie) {
        list($valeurSaisie, $valeurConvertie, $dateSaisie) = explode(" => ", $saisie);
        
       if ($dateSaisie !== $currentDate) {
            if ($currentDate !== null) {
                // Suppression des boutons de suppression ici
                echo "</table>";
            }
            echo "<h2>Date: $dateSaisie</h2>";
            echo "<table border='1'>";
            echo "<tr><th>Valeur saisie</th><th>Valeur convertie</th></tr>";
            $currentDate = $dateSaisie;
        }
        
        echo "<tr><td>$valeurSaisie</td><td>$valeurConvertie</td></tr>";
    }
    
    if ($currentDate !== null) {
        // Suppression des boutons de suppression ici
        echo "</table>";
    }
}

?>
    
</body>
</html>
