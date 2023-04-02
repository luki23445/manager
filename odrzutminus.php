<?php
include_once("config.php");

$id = $_GET['id'];

$result = mysqli_query($mysqli, "UPDATE `produkty` SET `iloscwsumie`= `iloscwsumie` - 1 WHERE id=$id");

$result = mysqli_query($mysqli, "UPDATE `produkty` SET `iloscodpadow`= `iloscodpadow` - 1 WHERE id=$id");
header("Location:tabela_odpady.php");
?>