<?php
include("include/nustatymai.php");
include("include/functions.php");
session_start();

if(isset($_POST['bet'])){
    $_SESSION['id_bet'] = $_POST['bet'];
}
?>

<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8">
        <link href="include/styles.css" rel="stylesheet" type="text/css" >
    </head>
    <body>
    <table class="center" ><tr><td>
            <center><img src="include/new_top.png"></center>
            </td></tr><tr><td>

            <table><tr><td>
          <a href="prisijungimas.php">Atgal</a>
      </td></tr>
	</table>
		<center><font size="5">Atlikti statymą</font></center></td></tr></table> 
    <br>
			
		<div> 
        <form action="addstake.php" method="post">
            <p>
               <label for="title">Pasirinkite lažybas, kuriose norite atlikti statymą</label>
            </p>
            <p>
            <select name="bet"> 
            <?php
    
	            $db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
	            $sql = "SELECT b.id AS id, b.title AS title FROM `bets` b WHERE b.status = 0;";
	            $result = mysqli_query($db, $sql);
                if(isset($_SESSION['id_bet']))
                {
                    $chosen_bet = $_SESSION['id_bet'];
                    echo $chosen_bet;
                    echo "<p>laba3</p>";
                }
                while($row = mysqli_fetch_assoc($result)) 
	            {	 
                    $id =$row['id'];
	                $title=$row['title'];
                    if($chosen_bet == $id){
                        
                        echo "<option selected value=\"$id\">$id. $title</option>";
                    }
                    else{
                        echo "<option value=\"$id\">$id. $title</option>";
                    }
                    
                }
                mysqli_close($db);
            ?>
            </select>

<p>
            <input name="select" type="submit" value="Patvirtinti pasirinkimą">
            </p>

            <p>
                <?php
                if(isset($_POST['bet'])){
                    $_SESSION['id_bet'] = $_POST['bet'];
                    if(!empty($_POST['bet'])) {
                    $select = $_POST['bet'];
                    // $str = (int)preg_replace('/[^0-9]+/', '', $select);
                    $con=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
                
                    $result = mysqli_query($con, "SELECT b.id AS id, b.title AS title, b.stake_nr1 AS statymas1, b.stake_nr2 AS statymas2 FROM `bets` b WHERE b.status = 0 AND b.id = $select;");
                    $row = mysqli_fetch_array($result);
                    
                    $id = $row['id'];
                    $title = $row['title'];
                    $statymas1 = $row['statymas1'];
                    $statymas2 = $row['statymas2'];
                    echo "<p name=\"bets\">Buvo pasirinkta: $id. $title lažybos</p>";
                    echo "<label for=\"title\">Pasirinkite laimėjusį statymą</label>";

                    echo "<div>";
                    echo "<input type=\"radio\" id=\"statymas1\" name=\"status\" value=\"$statymas1\">";
                    echo "<label for=\"statymas1\">$statymas1</label>";
                    echo "</div>";
                    echo "<div>";
                    echo "<input type=\"radio\" id=\"statymas2\" name=\"status\" value=\"$statymas2\" >";
                    echo "<label for=\"statymas2\">$statymas2</label>";
                    echo "</div>";

                    echo "<div>";
                    echo "<p>Įveskite sumą, kurią norite pastatyti</p>";
                    echo "</div>";
                    echo "<div>";
                    echo "<input type=\"number \" step=0.01 name=\"suma\">";
                    echo "</div>";

                    echo "<div>";
                    echo "<input type=\"submit\" name=\"submit\" value=\"Atlikti statymą\">";
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
                        if(empty($_POST['suma']))
                        {
                            echo "<p style=\"color:red;\">*Neįvedėte sumos. Bandykite iš naujo</p>";
                        }
                        if(empty($_POST['status']))
                        {
                            echo "<p style=\"color:red;\">*Nepasirinkote už ką statote. Bandykite iš naujo</p>";
                        }
                        else
                        {
                            $user_id = $_SESSION['userid'];
                            // echo "<p>$user_id</p>";
                            $id_bet = (int)preg_replace('/[^0-9]+/', '', $_SESSION['id_bet']); // lažybų id
                            // echo "<p>$id_bet</p>";
                            $stake = $_POST['status'];
                            // echo "<p>$stake</p>";
                            $su = $_POST['suma'];
                            // echo "<p>$su</p>";

                            $con = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
                            if (!$con)
                            {
                                die("Connection failed!" . mysqli_connect_error());
                            }

                            $query = "INSERT INTO `stakes`(`stake_title`, `amount`, `id_user`, `id_bet`) VALUES ('$stake','$su','$user_id','$id_bet')";
                            $run = mysqli_query($con, $query);
                            mysqli_close($con);
                            echo "<p>Statymas buvo priimtas</p>";
                            // $win_stake = $_POST['status']; // laimėjusis statymas
                            // $con=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
                            // $result = mysqli_query($con, "UPDATE `bets` b SET `stake_win`='$win_stake',`status`='1' WHERE b.id = $id;");
                            // mysqli_close($con);
                        }
                    }
                    ?>
                </p>          
            
           
        </form>
        </div>
    <br>