<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = validateInput($_POST["username"]);
    $rawPassword = validateInput($_POST["parola"]);
    $cnp = validateInput($_POST["cnp"]);

    // Hash parola
    $hashedPassword = password_hash($rawPassword, PASSWORD_DEFAULT);

    echo "Username: " . htmlspecialchars($username) . "<br>";
    echo "Password: " . htmlspecialchars($rawPassword) . "<br>";
    echo "CNP: " . htmlspecialchars($cnp) . "<br>";

    $link = mysqli_connect("localhost", "valudes", "dinozaurul1", "proiect");

    if (!$link) {
        echo "Error";
        exit;
    }

    
    $query = "INSERT INTO register(username, parola, cnp) VALUES (?, ?, ?)";
    $stmt = $link->prepare($query);
    $stmt->bind_param("sss", $username, $hashedPassword, $cnp);

    if ($stmt->execute()) {
        header("Location: register.html");
    } else {
        echo "Eroare la adăugarea datelor: " . $link->error;
    }

    mysqli_close($link);
}

function validateInput($input)
{
    
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}
?>
