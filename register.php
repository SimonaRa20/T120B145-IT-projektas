<?php
// register.php registracijos forma
// jei pats registruojasi rolė = DEFAULT_LEVEL, jei registruoja ADMIN_LEVEL vartotojas, rolę parenka
// Kaip atsiranda vartotojas: nustatymuose $uregister=
//                                         self - pats registruojasi, admin - tik ADMIN_LEVEL, both - abu atvejai galimi
// formos laukus tikrins procregister.php

session_start();
if (empty($_SESSION['prev'])) {
    header("Location: logout.php");
    exit;
}

// registracija galima kai nera userio arba adminas
// kitaip kai sesija expirinasi blogai, laikykim, kad prev vistik visada nustatoma
include("include/nustatymai.php");
include("include/functions.php");
if ($_SESSION['prev'] != "procregister")
    inisession("part"); // pradinis bandymas registruoti

$_SESSION['prev'] = "register";
?>
<style>
    a:visited {
        color: black;

    }

    .header {
        font-size: 15px;
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
                <div>
                    <div>
                        <h1>Registracija</h1>
                        <form action="procregister.php" method="POST">

                            <div>
                                <label class="label" for="floatingInput">Vartotojo vardas</label>
                            </div>
                            <div>
                                <input type="text"
                                    style="-webkit-box-shadow: 0 0 0 30px #D3D3D3 inset;text-align: center; padding: 15px 70px;  border: #FFFFFF;"
                                    id="floatingInput" name="user" value="<?php echo $_SESSION['name_login']; ?>">
                            </div>

                            <div>
                                <?php echo $_SESSION['name_error']; ?>
                            </div>
                            <div>
                                <label class="label" for="floatingPassword">Slaptažodis</label>
                            </div>
                            <div>
                                <input type="password"
                                    style="-webkit-box-shadow: 0 0 0 30px #D3D3D3 inset;text-align: center; padding: 15px 70px;  border: #FFFFFF;"
                                    id="floatingPassword" name="pass" value="<?php echo $_SESSION['pass_login']; ?>">
                            </div>
                            <div>
                                <?php echo $_SESSION['pass_error']; ?>
                            </div>

                            <div>
                                <label class="label" for="floatingEmail">El. Paštas</label>
                            </div>

                            <div>
                                <input type="email"
                                    style="-webkit-box-shadow: 0 0 0 30px #D3D3D3 inset;text-align: center; padding: 15px 70px;  border: #FFFFFF;"
                                    id="floatingEmail" name="email" value="<?php echo $_SESSION['pass_login']; ?>">
                            </div>
                            <div>
                                <?php echo $_SESSION['mail_error']; ?>
                            </div>
                            <div>
                                <button class="input1" type="submit">Registruotis</button>
                            </div>
                            <div>
                                <p>Jau turite paskyrą? <a href="prisijungimas.php">Prisijunkite</a> </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>