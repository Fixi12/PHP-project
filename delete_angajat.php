<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $id_angajat = $_POST["id_angajat"];

    
    $link = mysqli_connect("localhost", "valudes", "dinozaurul1", "proiect");

    if (!$link) {
        die("Eroare la conectarea cu baza de date: " . mysqli_connect_error());
    }

    
    $query = "DELETE FROM angajat WHERE id_angajat=?";

   
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "i", $id_angajat);
    $result = mysqli_stmt_execute($stmt);

    
    if ($result) {
        echo "Înregistrarea angajatului a fost ștearsă cu succes!";
    } else {
        echo "Eroare la ștergerea înregistrării: " . mysqli_error($link);
    }

    
    mysqli_close($link);
}
?>
