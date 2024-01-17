<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $id_student = $_POST["id_student"];
    $nume = $_POST["nume"];
    $prenume = $_POST["prenume"];
    $grupa = $_POST["grupa"];
    $loc_camin = $_POST["loc_camin"];
    $cnp = $_POST["cnp"];

    
    $link = mysqli_connect("localhost", "valudes", "dinozaurul1", "proiect");

    if (!$link) {
        die("Eroare la conectarea cu baza de date: " . mysqli_connect_error());
    }

   
    $query = "UPDATE student SET nume=?, prenume=?, grupa=?, loc_camin=?, cnp=? WHERE id_student=?";

    
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "ssiisi", $nume, $prenume, $grupa, $loc_camin, $cnp, $id_student);
    $result = mysqli_stmt_execute($stmt);

    
    if ($result) {
        echo "Înregistrarea studentului a fost actualizată cu succes!";
    } else {
        echo "Eroare la actualizarea înregistrării: " . mysqli_error($link);
    }

    
    mysqli_close($link);
}
?>
