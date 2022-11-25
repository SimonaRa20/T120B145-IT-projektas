<?php
// index.php
// jei vartotojas prisijungęs rodomas demonstracinis meniu pagal jo rolę
// jei neprisijungęs - prisijungimo forma per include("login.php");
// toje formoje daugiau galimybių...

session_start();
include("include/functions.php");
?>

<html>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8">
    <title>Totalizatorius</title>
    <link href="include/styles.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div>
        <img src="include/new_top.png">
    </div>
    <table>
        <!-- <tr>
                        <td>
                            <a href="index.php">Atgal</a>
                        </td>
                    </tr> -->
        <?php

        if (!empty($_SESSION['user'])) //Jei vartotojas prisijungęs, valom logino kintamuosius ir rodom meniu
        { // Sesijoje nustatyti kintamieji su reiksmemis is DB
            // $_SESSION['user'],$_SESSION['ulevel'],$_SESSION['userid'],$_SESSION['umail']
        
            inisession("part"); //   pavalom prisijungimo etapo kintamuosius
            $_SESSION['prev'] = "index";

            include("include/meniu.php"); //įterpiamas meniu pagal vartotojo rolę
        
        } else {

            if (!isset($_SESSION['prev']))
                inisession("full"); // nustatom sesijos kintamuju pradines reiksmes 
            else {
                if ($_SESSION['prev'] != "proclogin")
                    inisession("part"); // nustatom pradines reiksmes formoms
            }
            // jei ankstesnis puslapis perdavė $_SESSION['message']
            echo "<div align=\"center\">";
            echo "<font size=\"4\" color=\"#ff0000\">" . $_SESSION['message'] . "<br></font>";

            echo "<table style=\" margin-left: auto; margin-right: auto;\"><tr><td>";
            include("include/login.php"); // prisijungimo forma
            echo "</td></tr></table></div><br>";

        }
        ?>
</body>

</html>

<html>
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
        background-color: #f2f2f2;
        padding: 8px;
        text-align: left
    }

    #zinutes tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    /* #zinutes tr:hover {background-color: #777777;} */
</style>

<body>
    <div class="container">
        <div class="row">
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
                                    <td style="background-color: #ddd;"><b>Lažybos</b></td>
                                </tr>
                                <?php
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $title = $row['title'];
                                    echo "<tr><td>" . $title . "</td></tr>";
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>