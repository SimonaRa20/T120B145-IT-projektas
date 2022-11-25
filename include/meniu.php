<html>
<style>
    a:visited {
        color: black;
  
}
a:hover {
    color: grey;
}

</style>

<?php
// meniu.php  rodomas meniu pagal vartotojo rolę

if (!isset($_SESSION)) { header("Location: logout.php");exit;}
include("include/nustatymai.php");
$user=$_SESSION['user'];
$userlevel=$_SESSION['ulevel'];
$role="";
{foreach($user_roles as $x=>$x_value)
			      {if ($x_value == $userlevel) $role=$x;}
} 

     echo "<table style=\"margin-left: auto; margin-right: auto;\">";
        echo "<tr><td>";
        echo "Prisijungęs vartotojas: <b>".$user."</b>     Rolė: <b>".$role."</b> <br>";
        echo "</td></tr><tr><td>";
        //Administratoriaus sąsaja rodoma tik administratoriui
        if ($userlevel == $user_roles[ADMIN_LEVEL] ) {
            echo "<a href=\"addnewbet.php\">Pridėti lažybas</a> &nbsp;&nbsp;";
            echo "<a href=\"closebet.php\">Uždaryti lažybas</a> &nbsp;&nbsp;";
            echo "<a href=\"admin.php\">Administratoriaus sąsaja</a> &nbsp;&nbsp;";
            
        }

        if ($_SESSION['user'] != "guest") echo "<a href=\"useredit.php\">Redaguoti paskyrą</a> &nbsp;&nbsp;";
        
        if (($userlevel == $user_roles["Registruotas vartotojas"]) || ($userlevel == $user_roles[DEFAULT_LEVEL] )) {
            echo "<a href=\"addstake.php\">Atlikti statymą</a> &nbsp;&nbsp;";
            echo "<a href=\"istorija.php\">Statymo istorija</a> &nbsp;&nbsp;";
            }    
        
        echo "<a href=\"logout.php\">Atsijungti</a>";
      echo "</td></tr></table>";
?>       
    
    </html>