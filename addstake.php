<?php
include("include/nustatymai.php");
include("include/functions.php");
session_start();

if (isset($_POST['bet'])) {
    $_SESSION['id_bet'] = $_POST['bet'];
}
?>

<style>
    a:visited {
        color: black;

    }

    .header {
        font-size: 18px;
    }

    .input2 {
        background-color: grey;
        color: white;
        padding: 15px 65px;
        border: #FFFFFF;
    }

    a:hover {
        color: grey;
    }

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

    .special {
        padding: 10px 25px;
        font-weight: grey;
        color: white;
        background: grey;
        text-transform: uppercase;
    }

    option {
        font-size: 20px;
        background-color: black;
    }

    option:before {
        content: ">";
        font-size: 20px;
        padding: 10px 25px;
        background-color: #ffffff;
    }

    option:hover:before {
        display: inline;
        background-color: black;
    }
</style>


<html>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8">
    <link href="include/styles.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div>
        <img src="include/new_top.png">
        <div>
           
            <div>
                <h1>Atlikti statymą</h1>
                <div>
                    <form action="addstake.php" method="post">

                        <h3>Pasirinkite lažybas, kuriose norite atlikti statymą</h3>

                        <div>
                            <select class="special" name="bet">
                                <?php

                                $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
                                $sql = "SELECT b.id AS id, b.title AS title FROM `bets` b WHERE b.status = 0;";
                                $result = mysqli_query($db, $sql);
                                if (isset($_SESSION['id_bet'])) {
                                    $chosen_bet = $_SESSION['id_bet'];
                                    echo $chosen_bet;
                                }
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $id = $row['id'];
                                    $title = $row['title'];
                                    if ($chosen_bet == $id) {

                                        echo "<option selected value=\"$id\">$id. $title</option>";
                                    } else {
                                        echo "<option value=\"$id\">$id. $title</option>";
                                    }

                                }
                                mysqli_close($db);
                                ?>
                            </select>
                            
            
                            <input class="input1" name="select" type="submit" value="Patvirtinti pasirinkimą">
                        </div>
                        <p></p>
                        <div>
                            <?php
                            if (isset($_POST['bet'])) {
                                $_SESSION['id_bet'] = $_POST['bet'];
                                if (!empty($_POST['bet'])) {
                                    $select = $_POST['bet'];
                                    // $str = (int)preg_replace('/[^0-9]+/', '', $select);
                                    $con = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

                                    $result = mysqli_query($con, "SELECT b.id AS id, b.title AS title, b.stake_nr1 AS statymas1, b.stake_nr2 AS statymas2 FROM `bets` b WHERE b.status = 0 AND b.id = $select;");
                                    $row = mysqli_fetch_array($result);

                                    $id = $row['id'];
                                    $title = $row['title'];
                                    $statymas1 = $row['statymas1'];
                                    $statymas2 = $row['statymas2'];

                                    echo "<div>";
                                    echo "<h3>Pasirinkite už ką norite statyti</h3>";

                                    
                                    echo "<input type=\"radio\" style=\"accent-color: black;\" id=\"statymas1\" name=\"status\" value=\"$statymas1\">";
                                    echo "<label style=\"font-size: 18px;\" for=\"statymas1\">$statymas1</label>";
                            
                                    echo "<input type=\"radio\" style=\"accent-color: black;\" id=\"statymas2\" name=\"status\" value=\"$statymas2\" >";
                                    echo "<label style=\"font-size: 18px;\" for=\"statymas2\">$statymas2</label>";
                                    echo "</div>";

                                    echo "<div>";
                                    echo "<p>Įveskite sumą, kurią norite pastatyti</p>";
                                    echo "</div>";
                                    echo "<div>";
                                    echo "<input class=\"input2\" type=\"number \" name=\"suma\">";
                                    echo "</div>";
                                    echo "<p>";
                                    echo "</p>";
                                    echo "<div>";
                                    echo "<input class=\"input1\" type=\"submit\" name=\"submit\" value=\"Atlikti statymą\">";
                                    echo "</div>";
                                    mysqli_close($con);

                                } else {
                                    echo "<p style=\"color:red;\">*Pasirinkite ir patvirtinkite lažybas, kurias norite uždaryti</p>";
                                }
                            }

                            ?>
                        </div>

                        <div>
                            <?php
                            $con = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
                            if (!$con) {
                                die("Connection failed!" . mysqli_connect_error());
                            }
                            if (isset($_POST['submit'])) {
                                $closeCon = false;
                                if (empty($_POST['status'])) {
                                    echo "<p style=\"color:red;\">*Nepasirinkote už ką statote. Bandykite iš naujo</p>";
                                    $closeCon = true;
                                }
                                if (empty($_POST['suma'])) {
                                    echo "<p style=\"color:red;\">*Neįvedėte sumos. Bandykite iš naujo</p>";
                                    $closeCon = true;
                                }
                                if (is_numeric($_POST['suma']) != 1) {
                                    echo "<p style=\"color:red;\">*Rašykite skaičius.</p>";
                                    $closeCon = true;
                                }
                                if (!$closeCon) {

                                    $user_id = $_SESSION['userid'];
                                    // echo "<p>$user_id</p>";
                                    $id_bet = (int) preg_replace('/[^0-9]+/', '', $_SESSION['id_bet']); // lažybų id
                                    // echo "<p>$id_bet</p>";
                                    $stake = $_POST['status'];
                                    // echo "<p>$stake</p>";
                                    $su = $_POST['suma'];
                                    // echo "<p>$su</p>";
                            


                                    $query = "INSERT INTO `stakes`(`stake_title`, `amount`, `id_user`, `id_bet`) VALUES ('$stake','$su','$user_id','$id_bet')";
                                    $run = mysqli_query($con, $query);
                                    mysqli_close($con);
                                    header("Location:prisijungimas.php");
                                    // $win_stake = $_POST['status']; // laimėjusis statymas
                                    // $con=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
                                    // $result = mysqli_query($con, "UPDATE `bets` b SET `stake_win`='$win_stake',`status`='1' WHERE b.id = $id;");
                                    // mysqli_close($con);
                                }
                            }
                            ?>
                        </div>



                    </form>
                    <a href="prisijungimas.php">Atgal</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>