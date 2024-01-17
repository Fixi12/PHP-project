<?php
session_start();

$link = mysqli_connect("localhost", "valudes", "dinozaurul1", "proiect");

if (!$link) {
    echo "Error la conectare cu baza de date";
    exit;
}

$username = $_SESSION['username'];
$cnp = $_SESSION['cnp'];

// Obține numele materiei pentru angajatul curent
$queryNumeMaterie = "SELECT nume_materie FROM angajat WHERE angajat.cnp = '$cnp'";
$resultNumeMaterie = $link->query($queryNumeMaterie);

if ($resultNumeMaterie && $resultNumeMaterie->num_rows > 0) {
    $rowNumeMaterie = $resultNumeMaterie->fetch_assoc();
    $numeMaterie = $rowNumeMaterie['nume_materie'];

    $queryAngajatInfo = "SELECT id_facultate
                         FROM angajat
                         WHERE angajat.cnp = '$cnp'";
    $resultAngajatInfo = $link->query($queryAngajatInfo);

    if ($resultAngajatInfo && $resultAngajatInfo->num_rows > 0) {
        $rowAngajatInfo = $resultAngajatInfo->fetch_assoc();
        $idFacultateAngajat = $rowAngajatInfo['id_facultate'];

        $queryEleviFacultate = "SELECT student.id_student, student.nume, student.prenume, student.cnp
                                FROM student
                                JOIN facultate_student ON student.id_student = facultate_student.id_student
                                WHERE facultate_student.id_facultate = '$idFacultateAngajat'";
        $resultEleviFacultate = $link->query($queryEleviFacultate);

        if ($resultEleviFacultate && $resultEleviFacultate->num_rows > 0) {
            echo "<form action='main1.php' method='POST'>";
            while ($rowElevFacultate = $resultEleviFacultate->fetch_assoc()) {
                echo "<label>{$rowElevFacultate['nume']} {$rowElevFacultate['prenume']} </label>";
                echo "<select name='note[{$rowElevFacultate['id_student']}]'>";
                for ($nota = 1; $nota <= 10; $nota++) {
                    echo "<option value='$nota'>$nota</option>";
                }
                echo "</select><br>";
            }
            echo "<input type='submit' name='submitNote' value='Trimite Note'>";
            echo "</form>";
        } else {
            echo "Nu s-au găsit elevi în aceeași facultate cu angajatul $username.";
        }
    } else {
        echo "Nu s-au găsit informații pentru angajatul $username.";
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitNote'])) {
        $note = $_POST['note'];

        foreach ($note as $idStudent => $nota) {
            $nota = mysqli_real_escape_string($link, $nota);  // Pentru a preveni SQL injection
            $queryAdaugaNota = "INSERT INTO nota (id_student, nota, nume_materie) VALUES ('$idStudent', '$nota', '$numeMaterie')";

            if ($link->query($queryAdaugaNota)) {
                echo "Notă adăugată cu succes!";
            } else {
                echo "Eroare la adăugarea notei: " . $link->error;
            }
        }
    }
} else {
    echo "Nu s-au găsit informații pentru numele materiei angajatului $username.";
}

mysqli_close($link);
?>
