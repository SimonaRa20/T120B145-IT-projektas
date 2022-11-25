<?php
// useredit.php 
// vartotojas gali pasikeisti slaptažodį ar email
// formos reikšmes tikrins procuseredit.php. Esant klaidų pakartotinai rodant formą rodomos ir klaidos

session_start();
// sesijos kontrole
if (!isset($_SESSION['prev']) || (($_SESSION['prev'] != "index") && ($_SESSION['prev'] != "procuseredit") && ($_SESSION['prev'] != "useredit"))) {
    header("Location: logout.php");
    exit;
}
if ($_SESSION['prev'] == "index") {
    $_SESSION['mail_login'] = $_SESSION['umail'];
    $_SESSION['passn_error'] = ""; // papildomi kintamieji naujam password įsiminti
    $_SESSION['passn_login'] = "";
} //visos kitos turetų būti tuščios
$_SESSION['prev'] = "useredit";
?>

<style>
    a:visited {
        color: black;

    }

    .header {
        font-size: 15px;
    }

    .input2 {
        -webkit-box-shadow: 0 0 0 30px #D3D3D3 inset;
        text-align: center; 
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

    .label {
        font-size: 18px;
    }

    .container {
        text-align: center;
    }
</style>

<html>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8">
    <title>Registracija</title>
    <link href="include/styles.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div class="container">
        <div class="row">
            <img src="include/new_top.png">
            <div>
                <h1>Paskyros redagavimas</h1>
                <h5>Vartotojas:
                    <?php echo $_SESSION['user']; ?>
                </h5>
                <div>
                    <div>

                        <form action="procuseredit.php" method="POST">
                            <div>
                                <label class="label" for="floatingPassword">Dabartinis slaptažodis</label>
                            </div>
                            <div>
                                <input type="password"
                                class="input2"
                                    id="floatingPassword" name="pass" value="<?php echo $_SESSION['pass_login']; ?>">
                            </div>
                            <div>
                                <?php echo $_SESSION['pass_error']; ?>
                            </div>

                            <div>
                                <label class="label" for="floatingNewPassword">Naujas slaptažodis</label>
                            </div>

                            <div>
                                <input type="password"
                                    class="input2"
                                    id="floatingNewPassword" name="passn"
                                    value="<?php echo $_SESSION['passn_login']; ?>">
                            </div>
                            <div>
                                <?php echo $_SESSION['passn_error']; ?>
                            </div>

                            <div>
                                <label class="label" for="floatingEmail">E-paštas</label>
                            </div>

                            <div>
                                <input type="email"
                                class="input2"
                                    id="floatingEmail" name="email" value="<?php echo $_SESSION['mail_login']; ?>">
                            </div>
                            <div>
                                <?php echo $_SESSION['mail_error']; ?>
                            </div>
                            <div>
                                <button class="input1" type="submit">Atnaujinti</button>
                                <a href="prisijungimas.php" class="btn btn-secondary">Atgal</a>
                            </div>
                            <?php
                            echo "<div align=\"center\">";
                            echo "<font size=\"4\" color=\"#ff0000\">" . $_SESSION['message'] . "<br></font>";
                            echo "</div>";
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>