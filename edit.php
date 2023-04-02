<?php

session_start();

if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
?>
<?php
include_once("config.php");
if (isset($_POST['update'])) {
	$id = $_POST['id'];

	$ppl = $_POST['ppl'];
	$kod = $_POST['kod'];
	$nazwa = $_POST['nazwa'];
	$cenak = $_POST['cenak'];
	$cenas = $_POST['cenas'];
	$ilosc = $_POST['ilosc'];
	$iloscwsumie = $_POST['iloscwsumie'];
	$iloscodpadow = $_POST['iloscodpadow'];
	$data = $_POST['data'];
	$opis = $_POST['opis'];

	$result = mysqli_query($mysqli, "UPDATE produkty SET ppl='$ppl',kod='$kod',nazwa='$nazwa',cenak='$cenak',cenas='$cenas',ilosc='$ilosc',iloscwsumie='$iloscwsumie',iloscodpadow='$iloscodpadow',data='$data',opis='$opis' WHERE id=$id");

	header("Location: tabela.php");
}
?>
<?php
$id = $_GET['id'];

$result = mysqli_query($mysqli, "SELECT * FROM produkty WHERE id=$id");

while ($user_data = mysqli_fetch_array($result)) {
	$ppl = $user_data['ppl'];
	$kod = $user_data['kod'];
	$nazwa = $user_data['nazwa'];
	$cenak = $user_data['cenak'];
	$cenas = $user_data['cenas'];
	$ilosc = $user_data['ilosc'];
	$iloscwsumie = $user_data['iloscwsumie'];
	$iloscodpadow = $user_data['iloscodpadow'];
	$data = $user_data['data'];
	$opis = $user_data['opis'];
}
?>
<!DOCTYPE html>
<html lang="pl">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/edit.css">
	<link rel="icon" href="ico/logo.ico">
	<title>.......</title>
</head>

<body oncontextmenu="return false;">
	<div class="box wjazd">
		<form name="update_user" method="post" action="edit.php">
			<div class="form">
				<h2 class="zaznaczanie">Edytowanie</h2>
				<br><br>
				<div class="opisBox">
					<textarea class="opis" name="opis" required="required"><?php echo $opis; ?></textarea>
					<span class="zaznaczanie">Opis</span>
					<i></i>
				</div>
				<div class="pplBox">
					<input type="text" name="ppl" required="required" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\.*)\./g, '$1');" maxlength="6" autocomplete="off" value=<?php echo $ppl; ?>>
					<span class="zaznaczanie">PPL</span>
					<i></i>
				</div>

				<div class="kol1">
					<div class="inputBox">
						<input type="text" name="kod" required="required" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\.*)\./g, '$1');" maxlength="14" autocomplete="off" value=<?php echo $kod; ?>>

						<span class="zaznaczanie">Kod</span>
						<i></i>
					</div>
					<br>
					<div class="inputBox">

						<input type="text" name="nazwa" required="required" autocomplete="off" value=<?php echo $nazwa; ?>>
						<span class="zaznaczanie">Nazwa</span>
						<i></i>
					</div>
					<br>
					<div class="inputBox">
						<input type="number" name="cenak" required="required" value=<?php echo $cenak; ?> min="1" step="any" maxlength="14" autocomplete="off">

						<span class="zaznaczanie">Cena Kupna</span>
						<i></i>
					</div>
					<br>
					<div class="inputBox">
						<input type="number" name="cenas" required="required" value=<?php echo $cenas; ?> min="1" step="any" maxlength="14" autocomplete="off">

						<span class="zaznaczanie">Cena Sprzedarzy</span>
						<i></i>
					</div>
					<br>
					<div class="inputBox">
						<input type="text" name="ilosc" required="required" value=<?php echo $ilosc; ?> oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\.*)\./g, '$1');" maxlength="14" autocomplete="off">

						<span class="zaznaczanie">Ilość</span>
						<i></i>
					</div>
					<br>
					<div class="inputBox">
						<input type="date" name="data" required="required" autocomplete="off" value=<?php echo $data; ?>>

						<span class="zaznaczanie">Data Ważności</span>
						<i></i>
					</div>

					<br>

					<input type="hidden" name="id" value=<?php echo $_GET['id']; ?>>
					<input type="hidden" name="iloscodpadow" value="<?php echo $iloscwsumie; ?>">
					<input type="hidden" name="iloscwsumie" value="<?php echo $iloscodpadow; ?>">

					<span>
						<input class="btn1" type="submit" name="update" value="Edytuj">

						<a class="btn2 zaznaczanie" href="tabela.php">Cofnij</a>

					</span>
				</div>
			</div>
		</form>
	</div>
	<div class="copyright zaznaczanie">Copyright 2022 - DON. All rights reserved. Design by DON</div>

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