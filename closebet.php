<?php
session_start();
include("include/nustatymai.php");
include("include/functions.php");
// $chosen_bet = "";
// cia sesijos kontrole
if (!isset($_SESSION['prev']) || ($_SESSION['ulevel'] != $user_roles[ADMIN_LEVEL]))   { header("Location: logout.php");exit;}
$_SESSION['prev']="admin";
date_default_timezone_set("Europe/Vilnius");


?>

<style>

a:visited {
    color: black;
  
}
.header{
    font-size: 15px;
}
.input2 {
    background-color: grey;  color: white; padding: 15px 65px; border: #FFFFFF;
}
a:hover {
    color: grey;
}
.input1 {
    background-color: black;  color: white; padding: 10px 25px; border: #FFFFFF;
  
}
.input1:hover {
    background-color: grey;  color: white; padding: 10px 25px; border: #FFFFFF;
}
.special {
    padding: 10px 25px;
    font-weight: grey;
    color:white;
    background: grey;
    text-transform: uppercase;
}

option {
  font-size: 15px;
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
    <table style=" margin-left: auto; margin-right: auto;" ><tr><td>
            <center><img src="include/new_top.png"></center>
            </td></tr><tr><td>

            <table><tr><td>
          <a href="prisijungimas.php">Atgal</a>
      </td></tr>
	</table>
		<center><font size="5">Uždaryti lažybas</font></center></td></tr></table> 
        <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8">
        <link href="include/styles.css" rel="stylesheet" type="text/css" >
    </head>
    <body>
    <br>
			
		<div> 
        <form action="closebet.php" method="post">
            <p>
               <label for="title">Pasirinkti lažybas</label>
            </p>
            <p>
            <select class="special" name="bet"> 
            <?php
    
	            $db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
	            $sql = "SELECT b.id AS id, b.title AS title FROM `bets` b WHERE b.status = 0;";
	            $result = mysqli_query($db, $sql);
                if(isset($_SESSION['id_bet']))
                {
                    $chosen_bet = $_SESSION['id_bet'];
                }
                echo "<p>var_dump($_SESSION\['id_bet'])</p>";
                while($row = mysqli_fetch_assoc($result)) 
	            {	 
                    $id =$row['id'];
	                $title=$row['title']; 
                    // echo "<option name=\"id\">$id. $title</option>";
                    if($chosen_bet == $id){
                        
                        echo "<option selected='selected' name=\"id\">$id. $title</option>";
                    }
                    else{
                        echo "<option name=\"id\">$id. $title</option>";
                    }
                    
                }
                mysqli_close($db);
            ?>
            </select>

<p>
            <input class="input1" name="select" type="submit" value="Patvirtinti pasirinkimą">
            </p>
            </form>
            <form>
            <p>
                <?php
                if(isset($_POST['select'])){
                    $_SESSION['id_bet'] = $_POST['bet'];
                    // $_GET['id_bet'] = $_POST['bet'];
                    // echo var_dump($_SESSION['id_bet']);
                    if(!empty($_POST['bet'])) {
                    $select = $_POST['bet'];
                    $str = (int)preg_replace('/[^0-9]+/', '', $select);
                    $con=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
                
                    $result = mysqli_query($con, "SELECT b.id AS id, b.title AS title, b.stake_nr1 AS statymas1, b.stake_nr2 AS statymas2 FROM `bets` b WHERE b.status = 0 AND b.id = $str;");
                    $row = mysqli_fetch_array($result);
                    
                    $id = $row['id'];
                    $title = $row['title'];
                    $statymas1 = $row['statymas1'];
                    $statymas2 = $row['statymas2'];
                    echo "<p name=\"bets\">Buvo pasirinkta: $id. $title lažybos</p>";
                    echo "<label class=\"header\" for=\"title\">Pasirinkite laimėjusį statymą</label>";

                    echo "<div>";
                    echo "<input type=\"radio\" style=\"accent-color: black;\" id=\"statymas1\" name=\"status\" value=\"$statymas1\">";
                    echo "<label for=\"statymas1\">$statymas1</label>";
                    echo "<input type=\"radio\" style=\"accent-color: black;\" id=\"statymas2\" name=\"status\" value=\"$statymas2\">";
                    echo "<label for=\"statymas2\">$statymas2</label>";
                    echo "</div>";
                    echo "<div>";
                    echo "<input class=\"input1\" type=\"submit\" name=\"submit\" value=\"Uždaryti lažybas\">";
                    echo "</div>";

                    mysqli_close($con);
                    
                    }
                    else { echo "<p style=\"color:red;\">*Pasirinkite ir patvirtinkite lažybas, kurias norite uždaryti</p>";}
                    }
                    
                ?>
                </p>
                <p>
                    
                </p>
                <p>
                    <?php 
                    
                    if(isset($_POST['submit']))
                    {
                        if(empty($_POST['status']))
                        {
                            echo "<p style=\"color:red;\">*Nepasirinkote laimėjusio statymo. Bandykite iš naujo</p>";
                        }
                        else
                        {
                            $id = (int)preg_replace('/[^0-9]+/', '', $_SESSION['id_bet']); // lažybų id
                            $win_stake = $_POST['status']; // laimėjusis statymas
                            $con=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
                            $result = mysqli_query($con, "UPDATE `bets` b SET `stake_win`='$win_stake',`status`='1' WHERE b.id = $id;");
                            mysqli_close($con);
                        }
                    }
                    ?>
                </p>          
            
           
        </form>
        </div>
    <br>