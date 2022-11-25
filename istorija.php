<?php
// operacija2.php
// tiesiog rodomas  tekstas ir nuoroda atgal

include("include/nustatymai.php");
include("include/functions.php");
session_start();

?>

<style>
    a:visited {
        color: black;
    }

    a:hover {
        color: grey;
    }
</style>


<html>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8">
    <title>Operacija 2</title>
    <link href="include/styles.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div>
        <img src="include/new_top.png">

    </div>



    <html>

    <body>
        <?php

        $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
        $user_id = $_SESSION['userid'];
        $sql = "SELECT b.title AS title, SUM(CASE WHEN s.stake_title = b.stake_win AND s.id_user = $user_id THEN s.amount ELSE 0 END) as stake, 
                                     SUM(CASE WHEN s.stake_title = b.stake_win THEN s.amount ELSE 0 END) AS sumawin, 
                                     SUM(CASE WHEN s.stake_title != b.stake_win THEN s.amount ELSE 0 END) AS nosumawin
            FROM stakes s
            LEFT JOIN bets b ON b.id = s.id_bet
            WHERE b.status = 1
            GROUP BY b.id HAVING SUM(CASE WHEN s.stake_title = b.stake_win AND s.id_user = $user_id THEN s.amount ELSE 0 END)>0 ";


        $result = mysqli_query($db, $sql);
        if (mysqli_num_rows($result) == 0) {
            echo "Laimėtų lažybų neturite.";
            echo "<div style=\"margin-left: auto;\">
            <a href=\"prisijungimas.php\">Atgal</a>
        </div>";
            exit;
        }
        if (!$result || (mysqli_num_rows($result) < 0)) {
            echo "Klaida skaitant lentelę bets";
            exit;
        }
        ?>
        <center>
            <h3>Lažybų sąrašas</h3>
        </center>
        <table class="main" style="text-align: center;" border="1" cellspacing="0" cellpadding="3">

            <?php
            if ((mysqli_num_rows($result) == 0)) {
                echo "<p>Dar nieko nelaimėjote</p>";
            } else {
                echo " <tr><td><b>Lažybos</b></td><td><b>Pastatyta suma</b></td><td><b>Išlošta suma</b></td></tr>";
                while ($row = mysqli_fetch_assoc($result)) {

                    $title = $row['title'];
                    $amount = $row['stake'];
                    $sumwinamount = $row['sumawin'];
                    $sumnowinamount = $row['nosumawin'];
                    $win = number_format($amount + ($amount / $sumwinamount * $sumnowinamount), 2, '.', '');
                    echo "<tr><td>" . $title . "</td><td>" . $amount . "</td><td>" . $win . "</td></tr>";
                }
            }

            ?>
        </table>
        <div style="margin-left: auto;">
            <a href="prisijungimas.php">Atgal</a>
        </div>

    </body>

    </html>