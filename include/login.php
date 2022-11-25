<?php
// login.php - tai prisijungimo forma, index.php puslapio dalis 
// formos reikšmes tikrins proclogin.php. Esant klaidų pakartotinai rodant formą rodomos klaidos
// formos laukų reikšmės ir klaidų pranešimai grįžta per sesijos kintamuosius
// taip pat iš čia išeina priminti slaptažodžio.
// perėjimas į registraciją rodomas jei nustatyta $uregister kad galima pačiam registruotis

if (!isset($_SESSION)) {
    header("Location: logout.php");
    exit;
}
$_SESSION['prev'] = "login";
include("include/nustatymai.php");
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

<body>
    <div class="container">
        <div class="row">
            <div>
                <div>
                    <div>
                        <h1>Prisijungti</h1>
                        <form action="proclogin.php" method="POST">
                            <div>
                                <label class="label" for="floatingInput">Vartotojo vardas</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="input2" id="floatingInput" name="user"
                                    value="<?php echo $_SESSION['name_login']; ?>">
                            </div>
                            <div>
                                <?php echo $_SESSION['name_error']; ?>
                            </div>
                            <div>
                                <label class="label" for="floatingPassword">Slaptažodis</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="input2" id="floatingPassword" name="pass"
                                    value="<?php echo $_SESSION['pass_login']; ?>">
                            </div>
                            <div>
                                <?php echo $_SESSION['pass_error']; ?>
                            </div>
                            <div class="d-grid">
                                <button class="input1" type="submit">Prisijungti</button>
                            </div>
                            <div>
                                <p>Neturi paskyros? <a href="register.php">Susikurk</a> </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>