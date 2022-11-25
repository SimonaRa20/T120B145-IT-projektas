<?php
session_start();
// sesijos kontrole
if (!isset($_SESSION['prev']) || (($_SESSION['prev'] != "addnewbet") && ($_SESSION['prev'] != "procaddnewbet") && ($_SESSION['prev'] != "addnewbet"))) {
    header("Location: logout.php");
    exit;
}
$_SESSION['prev'] = "procaddnewbet";

include("include/nustatymai.php");

$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
if (!$con) {
    die("Nepavyko prisijungti prie duomenų bazės" . mysqli_connect_error());
}

$title = $_POST['title'];
$stake1 = $_POST['stake_nr1'];
$stake2 = $_POST['stake_nr2'];

$closeCon = false;
if (empty($title)) {
    $_SESSION['new_bet_title_error'] = "*privalomas laukas";
    $closeCon = true;
}
if (empty($stake1)) {
    $_SESSION['new_bet_stake_nr1_error'] = "*privalomas laukas";
    $closeCon = true;
}
if (empty($stake2)) {
    $_SESSION['new_bet_stake_nr2_error'] = "*privalomas laukas";
    $closeCon = true;
}


if ($closeCon) {
    mysqli_close($con);
    header("Location:addnewbet.php");
    exit;
} else {
    $table = TBL_BETS;
    $query = "INSERT INTO " . $table. " (title, stake_nr1, stake_nr2, stake_win, status) VALUES ('$title', '$stake_nr1','$stake_nr2', '', 0)";
    $run = mysqli_query($con, $query);
    mysqli_close($con);
    header("Location:prisijungimas.php");
    exit;
}
