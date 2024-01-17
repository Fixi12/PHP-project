<?php
session_start();


$link = mysqli_connect("localhost", "valudes", "dinozaurul1", "proiect");

if (!$link) {
    echo "Error la conectare cu baza de date";
    exit;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["login"])) {
        $username = validateInput($_POST["username"]);
        $parola = validateInput($_POST["parola"]);



        $queryRegister = "SELECT cnp, parola FROM register WHERE username=?";
        $stmtRegister = $link->prepare($queryRegister);
        $stmtRegister->bind_param("s", $username);
        $stmtRegister->execute();
        $resultRegister = $stmtRegister->get_result();

        if ($resultRegister && $resultRegister->num_rows > 0) {
            $row = $resultRegister->fetch_assoc();
            $storedHashedPassword = $row['parola'];

            if (password_verify($parola, $storedHashedPassword)) {
                $cnp = $row['cnp'];

                $queryStudent = "SELECT * FROM student WHERE cnp=?";
                $stmtStudent = $link->prepare($queryStudent);
                $stmtStudent->bind_param("s", $cnp);
                $stmtStudent->execute();
                $resultStudent = $stmtStudent->get_result();

                $queryAngajat = "SELECT * FROM angajat WHERE cnp=?";
                $stmtAngajat = $link->prepare($queryAngajat);
                $stmtAngajat->bind_param("s", $cnp);
                $stmtAngajat->execute();
                $resultAngajat = $stmtAngajat->get_result();

                if ($resultStudent->num_rows > 0) {
                    $_SESSION['username'] = htmlspecialchars($username);
                    $_SESSION['cnp'] = htmlspecialchars($cnp);
                    header("Location: main.html");
                    exit;
                } elseif ($resultAngajat->num_rows > 0) {
    $rowAngajat = $resultAngajat->fetch_assoc();
    $idJobAngajat = $rowAngajat['id_job']; 
    $_SESSION['username'] = htmlspecialchars($username);
    $_SESSION['cnp'] = htmlspecialchars($cnp);


    if ($idJobAngajat == 3) {
        header("Location: main2.html");
        exit;
    } else {
        header("Location: main1.html");
        exit;
    }


                } else {
                    echo "Utilizatorul " . htmlspecialchars($username) . " nu este nici student, nici angajat!";
                }
            } else {
                echo "Parola incorectă!";


            }
        } else {
            echo "Utilizatorul " . htmlspecialchars($username) . " nu există!";
        }
    }
}

mysqli_close($link);

function validateInput($input)
{
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}



?>
