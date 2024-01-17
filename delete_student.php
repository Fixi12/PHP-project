<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $id_student = $_POST["id_student"];

    
    $link = mysqli_connect("localhost", "valudes", "dinozaurul1", "proiect");

    if (!$link) {
        die("Eroare la conectarea cu baza de date: " . mysqli_connect_error());
    }

    
    $query = "DELETE FROM student WHERE id_student=?";

    
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "i", $id_student);
    $result = mysqli_stmt_execute($stmt);

    
    if ($result) {
        echo "Înregistrarea studentului a fost ștearsă cu succes!";
    } else {
        echo "Eroare la ștergerea înregistrării: " . mysqli_error($link);
    }

    
    mysqli_close($link);
}
?>
