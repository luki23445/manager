<?php

$Host = 'localhost';
$Nazwa = 'baza';
$Login = 'root';
$Haslo = '';

$mysqli = mysqli_connect($Host, $Login, $Haslo, $Nazwa);
$mysqli->set_charset("utf8");