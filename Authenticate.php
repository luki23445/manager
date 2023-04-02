<?php
session_start();

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'baza';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {

    exit('Błąd połączenia z Bazą: ' . mysqli_connect_error());
}

if (!isset($_POST['username'], $_POST['password'])) {

    exit('Wypełnij pole');
}

if ($stmt = $con->prepare('SELECT id, password FROM konta WHERE username = ?')) {

    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();

    $stmt->store_result();


    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password);
        $stmt->fetch();

        if (password_verify($_POST['password'], $password)) {

            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['id'] = $id;
            header('Location: tabela.php');
        } else {
            echo '<script type="text/javascript">';
            echo ' alert("Nie poprawyne hasło Lub login")';
            echo '</script>';

            echo '<script type="text/javascript">';
            echo ' const myTimeout = setTimeout(funkc, 30); ';
            echo ' function funkc() { location.href = "index.html"; } ';
            echo '</script>';
        }
    } else {
        echo '<script type="text/javascript">';
        echo ' alert("Nie poprawyne hasło Lub login")';
        echo '</script>';

        echo "<body style='background-color:#23242a'>";
        echo '<script type="text/javascript">';

        echo ' const myTimeout = setTimeout(funkc, 30); ';
        echo ' function funkc() { location.href = "index.html"; } ';
        echo '</script>';
    }

    $stmt->close();
}
