<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: index.html');
    exit;
}
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'baza';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$stmt = $con->prepare('SELECT password, email, imie, nazwisko, tel, img FROM konta WHERE id = ?');

$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password, $email, $imie, $nazwisko, $tel, $img);
$stmt->fetch();
$stmt->close();
?>
<?php
include_once("config.php");

$result = mysqli_query($mysqli, "SELECT * FROM produkty ORDER BY id DESC");


?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>......</title>
    <link rel="icon" href="ico/logo.ico">
    <link rel="stylesheet" href="css/style12.css">
    <link rel="stylesheet" href="css/style_responsiv.css">
    <script src="https://kit.fontawesome.com/cbd8a1cfd7.js" crossorigin="anonymous"></script>
</head>

<body oncontextmenu="return false;" onload="zerowanie()">
    <div class="strona">
        <div class="nawigacja">

            <div class="pasek_pole">
                <div class="pasek" id="pasek"></div>
            </div>



        </div>
        <div style="overflow-x:hidden;" id="tabela" class="tabela zaznaczanie animacja">
            <table id="tbl">
                <tr class="tbody">
                    <th>ID</th>
                    <th>kod</a></th>
                    <th>Nazwa</a></th>
                    <th>Dostępna Ilość</th>
                    <th>Razem Ilość</th>
                    <th>Ilość Odpadów</th>
                    <th>Data Ważności</th>
                </tr>


                <?php


                while ($user_data = mysqli_fetch_array($result)) {
                    echo "<tr class='rekord' '>";
                    echo "<td>" . $user_data['id'] . "</td>";
                    echo "<td>" . $user_data['kod'] . "</td>";
                    echo "<td>" . $user_data['nazwa'] . "</td>";
                    echo "<td>" . $user_data['ilosc'] . " szt" . "</td>";
                    echo "<td>" . $user_data['iloscwsumie'] . " szt" . "</td>";
                    echo "<td>" . $user_data['iloscodpadow'] . " szt" . "</td>";
                    echo "<td>" . $user_data['data'] . "</td>";
                    echo "<td class='rozwijany'>
                    <a><i class='fa-solid fa-arrow-left fa-2x arrow'></i></a>
                    <a href='odrzutplus.php?id=$user_data[id]'><button class='r_btn'><i class='fa-solid fa-circle-plus'></i></button></a>
                    <a href='odrzutminus.php?id=$user_data[id]'><button class='r_btn'><i class='fa-solid fa-circle-minus'></i></button></a>
                    </td></tr>";
                }

                ?>
            </table>
        </div>

        <div class="stopka">


            <a href="tabela.php"><button class="g_btn" class="fa fa-user"><i class="fa-solid fa-plus"></i> Główna</button></a>
            <button class="m_btn" style="display: none;"><i class="fa-solid fa-gear"></i> Ustawienia</button>
            <button class="t_btn" onclick=" printDivContent()"><i class="fa-solid fa-print"></i> Drukuj</button>
            <div class="napis"><button class="l_btn" disabled>Wersja</button>
                <span class="napis_info">1.5</span>
            </div>

            <div class="napis"><a href="logout.php"><button onsubmit="return czy_wylogowac()" class="o_btn"><i class="fa-solid fa-sign-out"></i>Wyloguj</button></a>
                <span class="napis_info1">
                    <ul class="ul">
                        <li>Inforamcje o koncie:
                            <?= $_SESSION['name'] ?>
                        </li>
                        <li> <img width="50px" src='<?= $img ?>' /></li>

                        <li>
                            <?= $email ?>
                        </li>
                        <li>
                            <?= $imie ?>
                        </li>
                        <li>
                            <?= $nazwisko ?>
                        </li>
                        <li>
                            <?= $tel ?>
                        </li>
                    </ul>
                </span>

            </div>

            <div class="copyright zaznaczanie">Copyright 2023 - DON. All rights reserved. Design by DON</div>


        </div>
    </div>
    <script>
        function zerowanie() {
            var table, tr, td, i, txtValue;
            const filter = "0 SZT";

            table = document.getElementById("tbl");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[5];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) == 0) {
                        tr[i].style.display = "none";
                    } else {
                        tr[i].style.display = "";
                    }
                }
            }
        }
    </script>

    <script>
        function czy_delate() {
            if (confirm("Czy napewno chcesz usunąć produkt?"))
                return true;

            return false;
        }
    </script>

    <script>
        function pasek() {
            const scroll = document.getElementById("tabela").scrollTop;
            const wysokosc = document.getElementById("tabela").scrollHeight - document.documentElement.clientHeight;
            const wynik = (scroll / wysokosc) * 98;
            document.getElementById("pasek").style.width = wynik + "%";
        }

        document.getElementById("tabela").onscroll = function() {
            pasek()
        };
    </script>

    <script>
        function czy_wylogowac() {
            if (confirm("Czy napewno chcesz wylogować?"))
                return true;

            return false;
        }
    </script>

    <script>
        function printDivContent() {
            setTimeout(() => {

                var mywindow = window.open('', 'PRINT', ' width: 21cm; height: 29.7cm');

                mywindow.document.write('<html><head>');
                mywindow.document.write('<link rel="stylesheet" href="css/print.css">')
                mywindow.document.write('</head><body onload="window.print()">');
                mywindow.document.write(document.getElementById('tabela').innerHTML);
                mywindow.document.write('</body></html>');

                mywindow.document.close();
                mywindow.focus();


                setTimeout(function() {

                }, 2000)
                return true;
            }, 500);
        }
    </script>

    <script>
        function openTab(tabName) {
            var i, x;
            x = document.getElementsByClassName("containerTab");
            for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";
            }
            document.getElementById(tabName).style.display = "block";
        }
    </script>

    <script src="js/blokada.js"></script>

</body>

</html>