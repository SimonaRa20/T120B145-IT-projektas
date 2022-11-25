<?php
$server = "localhost";
$db = "vartvalds";
$user = "stud";
$password = "stud";
$lentele = "postings";
$dbc=mysqli_connect($server,$user,$password, $db);
mysqli_set_charset($dbc,"utf8");
if(!$dbc) { die ("Negaliu prisijungti prie MySQL:".mysqli_error($dbc));}
include("include/session.php");
if ($session->logged_in) {
	if (isset($_POST["submit"])) {
		$id = $_POST['id'];
		$name = $_POST['name'];
		$description = $_POST['description'];
		$location = $_POST['location'];
		$price = $_POST['price'];
		$sql = "UPDATE $lentele SET name = '$name', price = '$price', description = '$description', location = '$location' WHERE id = {$id}";
		if (!mysqli_query($dbc, $sql)) die ("Klaida įrašant:" .mysqli_error($dbc));
		
		$remove_old_images_sql = "DELETE FROM pictures WHERE posting_fk = {$id}";
		if (!mysqli_query($dbc, $remove_old_images_sql)) die ("Klaida įrašant:" .mysqli_error($dbc));
		
		$posting_fk = $id;
		
		$uploadDir = "./uploads/";
		$allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
		$maxSize = 2 * 1024 * 1024;
		if (!empty(array_filter($_FILES['files']['name']))) {
			foreach ($_FILES['files']['tmp_name'] as $key => $value) {
				$uploadStatus = false;
				$file_tmp_name = $_FILES['files']['tmp_name'][$key];
				$file_name = $_FILES['files']['name'][$key];
				$file_size = $_FILES['files']['size'][$key];
				$file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
				
				$filepath = $uploadDir.$file_name;
				
				if(in_array(strtolower($file_ext), $allowedTypes)) {
					if ($file_size > $maxSize) {
						echo "Per didelis failas.";
					}
					if (file_exists($filepath)) {
						$filepath = $uploadDir.time().$file_name;
						
						$flag = move_uploaded_file($file_tmp_name, $filepath);
						if (!$flag) {
							echo "Error uploading {$file_name}. <br />";
						}
						else
							$uploadStatus = true;
					}
					else {
						$flag = move_uploaded_file($file_tmp_name, $filepath);
							if (!$flag) {
							echo "Error uploading {$file_name}. <br />";
						}
						else
							$uploadStatus = true;
					}
				}
				else {
					echo "({$file_ext} file type is not allowed)<br / >";
				}
				if ($uploadStatus) {
					$sql = "INSERT INTO pictures (posting_fk, filepath) VALUES ('$posting_fk', '$filepath')";
					if (!mysqli_query($dbc, $sql)) die ("Klaida įrašant:" .mysqli_error($dbc));
				}
			}
			header("Location: my-postings.php");
		}
		else {
			header("Location: my-postings.php");
		}
	}
	else {
		header('Location: index.php');
	}
}
?>