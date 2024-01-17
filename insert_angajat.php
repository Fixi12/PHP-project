<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_angajat = $_POST["id_angajat"];
    $id_facultate = $_POST["id_facultate"];
    $id_departament = $_POST["id_departament"];
    $id_job = $_POST["id_job"];
    $nume = $_POST["nume"];
    $prenume = $_POST["prenume"];
    $adresa = $_POST["adresa"];
    $cnp = $_POST["cnp"];
    $nume_materie = $_POST["nume_materie"];

   
    $link = mysqli_connect("localhost", "valudes", "dinozaurul1", "proiect");

    if (!$link) {
        die("Eroare la conectarea cu baza de date: " . mysqli_connect_error());
    }

   
    $query = "INSERT INTO angajat (id_angajat, id_facultate, id_departament, id_job, nume, prenume, adresa, cnp, nume_materie) VALUES (?,?,?,?,?,?,?,?)";

    
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "iiiisssss", $id_angajat, $id_facultate, $id_departament, $id_job, $nume, $prenume, $adresa, $cnp, $nume_materie);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        echo "Înregistrarea angajatului a fost inserată cu succes!";
    } else {
        echo "Eroare la inserarea înregistrării: " . mysqli_error($link);
    }


    mysqli_close($link);
}
?>
