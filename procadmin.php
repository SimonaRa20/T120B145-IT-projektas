<?php
// procadmin.php  kai adminas keičia vartotojų įgaliojimus ir padaro atžymas lentelėje per admin.php
// ji suformuoja numatytų pakeitimų aiškią lentelę ir prašo patvirtinimo, toliau į procadmindb, kuri įrašys į DB

session_start();
// cia sesijos kontrole
if (!isset($_SESSION['prev']) || (($_SESSION['prev'] != "admin") && ($_SESSION['prev'] != "procadmin")))
{ header("Location: logout.php");exit;}

include("include/nustatymai.php");
include("include/functions.php");
$_SESSION['prev'] = "procadmin";

$db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
	$sql = "SELECT username,userlevel,email,timestamp "
            . "FROM " . TBL_USERS . " ORDER BY userlevel DESC,username";
	$result = mysqli_query($db, $sql);
	if (!$result || (mysqli_num_rows($result) < 1))  
			{echo "Klaida skaitant lentelę users"; exit;}
?>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8">
        <title>Administratoriaus sąsaja</title>
        <link href="include/styles.css" rel="stylesheet" type="text/css" >
    </head>
    <body>
        <table class="center" ><tr><td>
            <center><img src="include/top.png"></center>
			</td></tr><tr><td><center><font size="5">Vartotojų įgaliojimų pakeitimas</font></center></td></tr></table> <br>
		<form name="vartotojai" action="procadmindb.php" method="post">
		<table class="center" style="width:60%; border-width: 2px; border-style: dotted;"><tr><td width="50%" >
           [<a href="admin.php">Atgal</a>]</td>
			<td width="40%">Patikrinkite ar teisingi pakeitimai</td><td width="10%"> <input type="submit" value="Atlikti"></td></tr></table> <br> 
		
   
	  </table>
    </form>
  </body></html>
