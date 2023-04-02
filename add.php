<?php

session_start();

if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
?>
<!DOCTYPE html>
<html lang="pl">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Dodaj nowy produk</title>
	<link rel="icon" href="ico/logo.ico">
	<link rel="stylesheet" href="css/add.css">
</head>

<body oncontextmenu="return false;">
	<div class="box wjazd">
		<form action="add.php" method="post" name="form1">
			<div class="form">
				<h2 class="zaznaczanie">Dodawanie</h2>
				<br><br>

				<div class="inputBox">
					<input type="text" name="kod" required="required" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\.*)\./g, '$1');" maxlength="14" autocomplete="off">
					<span class="zaznaczanie">Kod</span>
					<i></i>
				</div>
				<br>
				<div class="inputBox">
					<input type="text" name="ppl" required="required" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\.*)\./g, '$1');" maxlength="6" autocomplete="off">
					<span class="zaznaczanie">PPL</span>
					<i></i>
				</div>
				<br>
				<div class="inputBox">
					<input type="text" name="nazwa" required="required" autocomplete="off">
					<span class="zaznaczanie">Nazwa</span>
					<i></i>
				</div>
				<br>
				<div class="inputBox">
					<input type="text" name="cenak" required="required" maxlength="14" autocomplete="off">
					<span class="zaznaczanie">Cena Kupna</span>
					<i></i>
				</div>
				<br>
				<div class="inputBox">
					<input type="text" name="cenas" required="required" maxlength="14" autocomplete="off">
					<span class="zaznaczanie">Cena Sprzedarzy</span>
					<i></i>
				</div>
				<br>
				<div class="inputBox">
					<input id="ilosc" type="text" name="ilosc" required="required" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\.*)\./g, '$1');" maxlength="14" autocomplete="off">
					<span class="zaznaczanie">Ilość</span>
					<i></i>
				</div>

				<br>
				<div class="inputHiden">
					<input id="iloscwsumieid" type="text" name="iloscwsumie" required="required" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\.*)\./g, '$1');" maxlength="14" autocomplete="off">
					<span class="zaznaczanie">Ilość ws</span>
					<i></i>
				</div>

				<br>
				<div class="inputHiden">
					<input id="iloscodpadow" type="text" name="iloscodpadow" value="0" required="required" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\.*)\./g, '$1');" maxlength="14" autocomplete="off">
					<span class="zaznaczanie">Ilość odp</span>
					<i></i>
				</div>

				<br>
				<div class="inputBox">
					<input type="text" name="opis" required="required" autocomplete="off">
					<span class="zaznaczanie">OPIS</span>
					<i></i>
				</div>
				<br>
				<div class="inputBox">
					<input type="date" name="data" required="required" autocomplete="off">
					<span class="zaznaczanie data">Data</span>
					<i></i>
				</div>

				<span>
					<input class="btn1" type="submit" name="Submit" value="Dodaj">
					<a class="btn2 zaznaczanie" href="tabela.php">Idź do strony główniej</a>
				</span>
			</div>
		</form>

	</div>
	<div class="copyright zaznaczanie">Copyright 2023 - DON. All rights reserved. Design by DON</div>
	<?php
	if (isset($_POST['Submit'])) {
		$kod = $_POST['kod'];
		$ppl = $_POST['ppl'];
		$nazwa = $_POST['nazwa'];
		$cenak = $_POST['cenak'];
		$cenas = $_POST['cenas'];
		$ilosc = $_POST['ilosc'];
		$iloscwsumie = $_POST['iloscwsumie'];
		$iloscodpadow = $_POST['iloscodpadow'];
		$opis = $_POST['opis'];
		$data = $_POST['data'];
		include_once("config.php");
		$result = mysqli_query($mysqli, "INSERT INTO produkty(kod,ppl,nazwa,cenak,cenas,ilosc,iloscwsumie,iloscodpadow,opis,data) VALUES('$kod','$ppl','$nazwa','$cenak','$cenas','$ilosc','$iloscwsumie','$iloscodpadow','$opis','$data')");
		echo '<script type ="text/JavaScript">';
		echo 'alert("Dodano Pomyślnie")';
		echo '</script>';
	}
	?>

	<script>
		window.addEventListener("change", function() {
			var ilosc = document.getElementById('ilosc').value;
			document.getElementById('iloscwsumieid').value = ilosc;
		});
	</script>

	<script>
		document.addEventListener('keydown', event => {
			if (event.key === 'Escape' || event.keyCode === 27) {
				window.close();
				let text;
				if (confirm("Czy napewno chcesz wyjść?") == true) {
					location.href = "tabela.php";
				} else {}
			}
		});
	</script>

	<script src="js/blokada.js"></script>
</body>
</html>