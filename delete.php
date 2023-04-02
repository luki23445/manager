<?php
include_once("config.php");

$id = $_GET['id'];

$result = mysqli_query($mysqli, "DELETE FROM produkty WHERE id=$id");

header("Location:tabela.php");