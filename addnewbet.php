<?php

session_start();
// sesijos kontrole
if (!isset($_SESSION['prev']) || (($_SESSION['prev'] != "index") && ($_SESSION['prev'] != "procaddnewbet") && ($_SESSION['prev'] != "addnewbet"))) {
    header("Location: logout.php");
    exit;
}
$_SESSION['prev'] = "addnewbet";

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
</style>


<html>

<head>

    <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8">
    <link href="include/styles.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div>
        <img src="include/new_top.png">
    </div>
    <div>
        <h1>Pridėti naujas lažybas</h1>
        <form action="procaddnewbet.php" method="POST">
            <div>
                <label class="header" for="title">Lažybų pavadinimas</label>
            </div>
            <div>
                <input class="input2" type="text" name="title" id="title"
                    value="<?php echo $_SESSION['new_bet_title'] ?>">
            </div>
            <div>
                <?php echo $_SESSION['new_bet_title_error'] ?>
            </div>

            <div>
                <label class="header" for="stake">Statymas nr. 1</label>
            </div>
            <div>
                <input class="input2" type="text" name="stake_nr1" value="<?php echo $_SESSION['new_bet_stake_nr1'] ?>">
            </div>
            <div>
                <?php echo $_SESSION['new_bet_stake_nr1_error'] ?>
            </div>

            <div>
                <label class="header" for="stake">Statymas nr. 2</label>
            </div>
            <div>
                <input class="input2" type="text" name="stake_nr2" value="<?php echo $_SESSION['new_bet_stake_nr2'] ?>">
            </div>
            <div>
                <?php echo $_SESSION['new_bet_stake_nr2_error'] ?>
            </div>
            <div>
                <button class="input1" type="submit">Pridėti</button>
                <a href="prisijungimas.php" class="btn btn-secondary">Atgal</a>
            </div>
        </form>
    </div>
    <br>
</body>
</html>