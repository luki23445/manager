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

$stmt = $con->prepare('SELECT password, email, imie, nazwisko, tel, img, tlo FROM konta WHERE id = ?');

$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password, $email, $imie, $nazwisko, $tel, $img, $tlo);
$stmt->fetch();
$stmt->close();
?>

<?php
include_once("config.php");

$columns = array('id', 'ppl', 'kod', 'nazwa', 'cenak', 'cenas', 'ilosc', 'iloscwsumie', 'data');

$column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[0];


$sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'desc' ? 'DESC' : 'ASC';

if ($result = $mysqli->query('SELECT * FROM produkty ORDER BY ' .  $column . ' ' . $sort_order)) {
    $up_or_down = str_replace(array('ASC', 'DESC'), array('up', 'down'), $sort_order);
    $asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
    $add_class = ' class="highlight"';
?>

    <!DOCTYPE html>
    <html lang="pl">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <title>......</title>
        <link rel="icon" href="ico/logo.ico">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/przejście.css">
        <link rel="stylesheet" href="css/style_responsiv.css">
        <script src="https://kit.fontawesome.com/cbd8a1cfd7.js" crossorigin="anonymous"></script>

    </head>

    <body oncontextmenu="return false;" onload="terminowanie(), kolor(), czarny()">





        <div id="przejscie"></div>


        <div class="strona">
            <div class="nawigacja">

                <div class="pasek_pole">
                    <div class="pasek" id="pasek"></div>
                </div>
                <span>
                    <div id="kod_s">
                        <input type="text" id="kodzik_search" onkeyup="szukaj()" placeholder="00000000000000" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\.*)\./g, '$1');" maxlength="14">
                    </div>

                    <div id="text_s">
                        <input type="text" id="tekst_search" onkeyup="szukajtxt()" placeholder="abcdefghijklmn" maxlength="14">
                    </div>
                </span>


            </div>
            <div style="overflow-x:hidden;" id="tabela" class="tabela zaznaczanie animacja">
                <table id="tbl">
                    <tr class="tbody">
                        <th><a href="tabela.php?column=id&order=<?php echo $asc_or_desc; ?>">ID <i class="<?php echo $column == 'id' ? 'fas fa-sort-' . $up_or_down : ''; ?>"></i></a></th>
                        <!-- <td>ID</td> -->
                        <th><a href="tabela.php?column=ppl&order=<?php echo $asc_or_desc; ?>">PPL <i class="<?php echo $column == 'ppl' ? 'fas fa-sort-' . $up_or_down : ''; ?>"></i></a></th>
                        <!-- <td>PPL</td> -->
                        <th><a href="tabela.php?column=kod&order=<?php echo $asc_or_desc; ?>">KOD <i class="<?php echo $column == 'kod' ? 'fas fa-sort-' . $up_or_down : ''; ?>"></i></a></th>
                        <!-- <td>kod</a></td> -->
                        <th><a href="tabela.php?column=nazwa&order=<?php echo $asc_or_desc; ?>">NAZWA <i class="<?php echo $column == 'nazwa' ? 'fas fa-sort-' . $up_or_down : ''; ?>"></i></a></th>
                        <!-- <td>Nazwa</a></td> -->
                        <th><a href="tabela.php?column=cenak&order=<?php echo $asc_or_desc; ?>">Cena Kupna <i class="<?php echo $column == 'cenak' ? 'fas fa-sort-' . $up_or_down : ''; ?>"></i></a></th>
                        <!-- <td>Cena Kupna</td> -->
                        <th><a href="tabela.php?column=cenas&order=<?php echo $asc_or_desc; ?>">Cena Sprzedarzy <i class="<?php echo $column == 'cenas' ? 'fas fa-sort-' . $up_or_down : ''; ?>"></i></a></th>
                        <!-- <td>Cena Sprzedarzy</td> -->
                        <th><a href="tabela.php?column=ilosc&order=<?php echo $asc_or_desc; ?>">Dostępna Ilość <i class="<?php echo $column == 'ilosc' ? 'fas fa-sort-' . $up_or_down : ''; ?>"></i></a></th>
                        <!-- <td>Dostępna Ilość</td> -->
                        <th><a href="tabela.php?column=iloscwsumie&order=<?php echo $asc_or_desc; ?>">W Sumie Ilość <i class="<?php echo $column == 'iloscwsumie' ? 'fas fa-sort-' . $up_or_down : ''; ?>"></i></a></th>
                        <!-- <td>W Sumie Ilość</td> -->
                        <th><a href="tabela.php?column=data&order=<?php echo $asc_or_desc; ?>">Data Ważności <i class="<?php echo $column == 'data' ? 'fas fa-sort-' . $up_or_down : ''; ?>"></i></a></th>
                        <!-- <td>Data Ważności</td> -->

                    </tr>
                    <?php while ($user_data = mysqli_fetch_array($result)) : ?>
                        <tr>
                            <td <?php echo $column == 'id' ? $add_class : ''; ?>><?php echo $user_data['id']; ?></td>
                            <td <?php echo $column == 'ppl' ? $add_class : ''; ?>><?php echo $user_data['ppl']; ?></td>
                            <td <?php echo $column == 'kod' ? $add_class : ''; ?>><?php echo $user_data['kod']; ?></td>

                            <td <?php echo $column == 'nazwa' ? $add_class : ''; ?>><?php echo "<p class='has-details'>" . $user_data['nazwa'] . "<span class='details'>" . $user_data['opis'] . "</span>" . "</p>" ?></td>

                            <td <?php echo $column == 'cenak' ? $add_class : ''; ?>><?php echo $user_data['cenak']; ?></td>
                            <td <?php echo $column == 'cenas' ? $add_class : ''; ?>><?php echo $user_data['cenas']; ?></td>

                            <td <?php echo $column == 'ilosc' ? $add_class : ''; ?>><?php echo $user_data['ilosc']; ?></td>
                            <td <?php echo $column == 'iloscwsumie' ? $add_class : ''; ?>><?php echo $user_data['iloscwsumie']; ?></td>
                            <td <?php echo $column == 'data' ? $add_class : ''; ?>><?php echo $user_data['data']; ?></td>

                            <?php echo "<td class='rozwijany'>
                    <a><i class='fa-solid fa-arrow-left fa-2x arrow'></i></a>
                    <a href='odrzut.php?id=$user_data[id]'><button class='r_btn'><i class='fa-solid fa-circle-xmark'></i></button></a>
                    <a href='edit.php?id=$user_data[id]'><button class='y_btn'><i class='fa-solid fa-pen-to-square'></i></button></a>
                    <form method='POST' action='delete.php?id=$user_data[id]' onsubmit='return czy_delate()'>
                        <a><button class='r_btn' type='submit'><i class='fa-solid fa-trash'></i></button></a>
                    </form>
                    <a href='increment.php?id=$user_data[id]'><button class='b_btn'><i class='fa-solid fa-circle-plus'></i></button></a>
                    <a href='decrement.php?id=$user_data[id]'><button class='b_btn'><i class='fa-solid fa-circle-minus'></i></button></a>
                    </td></tr>"; ?>
                        <?php endwhile; ?>
                </table>
            </div>

            <div class="stopka">
                <a href="add.php"><button class="g_btn" class="fa fa-user"><i class="fa-solid fa-plus"></i> Dodaj
                        Produkt</button></a>

                <a href="tabela_odpady.php"><button class="g_btn" class="fa fa-user"><i class="fa-solid fa-trash"></i> Odpady</button></a>
                <button class="m_btn" style="display: none;"><i class="fa-solid fa-gear"></i> Ustawienia</button>
                <button class="t_btn" onclick=" printDivContent()"><i class="fa-solid fa-print"></i> Drukuj</button>


                <button class="o_btn" id="myBtn">Ustawienia</button>

                <div id="myModal" class="modal">

                    <div class="modal-content">
                        <div class="modal-header">
                            <span class="close">&times;</span>
                            <h2>TŁO</h2>
                        </div>
                        <div class="modal-body">
                            <form name="update_user" method="post" action="tabela.php">
                                <ul class="ul">
                                    <li>
                                        <input id="input" type="color" value=<?php echo $tlo; ?>>
                                    </li>
                                </ul>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <div class="zaznaczanie">Copyright 2023 - DON. All rights reserved. Design by DON</div>
                        </div>
                    </div>

                </div>

                <script>
                    var modal = document.getElementById("myModal");

                    var btn = document.getElementById("myBtn");

                    var span = document.getElementsByClassName("close")[0];

                    btn.onclick = function() {
                        modal.style.display = "block";
                    }

                    span.onclick = function() {
                        modal.style.display = "none";
                    }

                    window.onclick = function(event) {
                        if (event.target == modal) {
                            modal.style.display = "none";
                        }
                    }
                </script>



                <div class="napis"><button type="button" class="l_btn" disabled>Wersja</button>
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
            function terminowanie() {
                var table, tr, td, i, txtValue;

                const a = new Date();
                let year = a.getFullYear();
                const b = new Date();
                let month = b.getMonth() + 1;
                if (month < 10) {
                    month = "0" + month;
                }
                const c = new Date();
                let day = c.getDay() - 1;
                if (day < 10) {
                    day = "0" + day;
                }



                const filter = year + '-' + month + '-' + day;

                table = document.getElementById("tbl");
                tr = table.getElementsByTagName("tr");
                for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td")[8];
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.background = "red";
                        } else {
                            tr[i].style.background = "";
                        }
                    }
                }
            }
        </script>
        <script>
            function szukaj() {
                var input, filter, table, tr, td, i, txtValue;
                input = document.getElementById("kodzik_search");
                filter = input.value.toUpperCase();
                table = document.getElementById("tbl");
                tr = table.getElementsByTagName("tr");
                for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td")[2];
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
        </script>

        <script>
            function szukajtxt() {
                var input, filter, table, tr, td, i, txtValue;
                input = document.getElementById("tekst_search");
                filter = input.value.toUpperCase();
                table = document.getElementById("tbl");
                tr = table.getElementsByTagName("tr");
                for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td")[3];
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
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
        <script>
            document.getElementById('input').addEventListener('input', function() {
                document.body.style.backgroundColor = this.value;
            })
        </script>

        <script>
            function kolor() {
                var x = document.getElementById('input').value
                document.body.style.backgroundColor = x;

            }
        </script>

        <script>
            function czarny() {
                document.getElementById("przejscie").style.display = "none";
            }
        </script>

        <script src="js/blokada.js"></script>

    </body>

    </html>
<?php
    $result->free();
}
?>