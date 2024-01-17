<?php
session_start();

$link = mysqli_connect("localhost", "valudes", "dinozaurul1", "proiect");

if (!$link) {
    echo "Error la conectare cu baza de date";
    exit;
}

$username = $_SESSION['username'];
$cnp = $_SESSION['cnp'];

$queryStudentInfo = "SELECT nota.nume_materie, GROUP_CONCAT(nota.nota ORDER BY nota.nota DESC) AS note, student.cnp
                     FROM student
                     JOIN facultate_student ON student.id_student = facultate_student.id_student
                     JOIN facultate ON facultate_student.id_facultate = facultate.id_facultate
                     LEFT JOIN nota ON student.id_student = nota.id_student
                     WHERE student.cnp = '$cnp'
                     GROUP BY nota.nume_materie, student.cnp";
$resultStudentInfo = $link->query($queryStudentInfo);

if ($resultStudentInfo && $resultStudentInfo->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Materie</th>
                <th>Note</th>

            </tr>";
    while ($row = $resultStudentInfo->fetch_assoc()) {
        echo "<tr>
                <td>{$row['nume_materie']}</td>
                <td>{$row['note']}</td>

              </tr>";
    }
    echo "</table>";
} else {
    echo "Nu s-au găsit informații pentru utilizatorul $username.";
}

mysqli_close($link);
?>
