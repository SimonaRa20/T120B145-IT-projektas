<?php
// admin.php
// vartotojų įgaliojimų keitimas ir naujo vartotojo registracija, jei leidžia nustatymai
// galima keisti vartotojų roles, tame tarpe uzblokuoti ir/arba juos pašalinti
// sužymėjus pakeitimus į procadmin.php, bus dar perklausta

session_start();
include("include/nustatymai.php");
include("include/functions.php");
date_default_timezone_set("Europe/Vilnius");
?>

<style>
    #zinutes {
        text-align: center;
        font-family: Arial;
        border-collapse: collapse;
        width: 100%;
    }

    #zinutes td {
        border: 5px solid #ddd;
        padding: 8px;
    }

    #zinutes th {
        background-color: #f2f2f3;
        padding: 8px;
        border: 1px solid #ddd;
        text-align: left
    }

    #zinutes tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    /* #zinutes tr:hover {background-color: #777777;} */

    .input1 {
        background-color: black;
        color: white;
        padding: 10px 25px;
        border: #FFFFFF;

    }

    .input1:hover {
        background-color: grey;
        color: white;
        padding: 10px 25px;
        border: #FFFFFF;
    }
</style>

<html>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8">
    <title>Totalizatorius</title>
    <link href="include/styles.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div class="container">
        <div class="row">
        <img src="include/new_top.png">
            <div>
                <div>
                    <div>
                        <?php

                        $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
                        $sql = 'SELECT b.title FROM bets b WHERE b.status = 0;';
                        $result = mysqli_query($db, $sql);
                        if (!$result || (mysqli_num_rows($result) < 1)) {
                            echo "Klaida skaitant lentelę bets";
                            exit;
                        }
                        ?>
                        <div style="width: 50%; margin-left: auto;
  margin-right: auto;">
                            <h3>Lažybų sąrašas</h3>
                            <table id="zinutes">
                                <tr>
                                    <td  style="background-color: #ddd;" ><b>Lažybos</b></td>
                                </tr>
                                <?php
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $title = $row['title'];
                                    echo "<tr><td>" . $title . "</td></tr>";
                                }
                                ?>
                            </table>
                        </div>

                        <input type="submit" class="input1" onClick="myFunction()" value="Prisijungti/Registruotis" />
                        <script>
                            function myFunction() {
                                window.location.href = "prisijungimas.php";
                            }
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>