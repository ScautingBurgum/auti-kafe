<?php
require_once('../scripts/dbcon.php');
if(isset($_SESSION['username']) || isset($_POST['registerform']) && $_POST['registerform'] == "register") {
	if(isset($_POST['id'])) {
		$count = $_POST['id'];
	} else {
		unset($count);
	}
	if(isset($_POST['registerform']) && $_POST['registerform'] == "register") {
		$username = mysqli_real_escape_string ($conn,$_POST['username']);
		$email = mysqli_real_escape_string ($conn,$_POST['email']);
		$password = mysqli_real_escape_string ($conn,$_POST['password']);
		$cPassword = mysqli_real_escape_string ($conn,$_POST['password_confirm']);
		$secretcode = mysqli_real_escape_string ($conn,$_POST['scode']);
		$error = "";
		$query = "SELECT username FROM kafelogin";
		if($query = mysqli_query($conn, $query)) {
			while($result = mysqli_fetch_assoc($query)) {
				if(strtolower($result['username']) == strtolower($username)) {
					$error .= "Username already exists! <br />";
				}
			}
			unset($query);
		}
		if(strlen($username) < 4 && strlen($password) < 4 && strlen($cPassword) < 4 && strlen($email) < 4) {
			$error .= "Username needs to be 3 characters or more! <br />";
		}
		if(strlen($password) < 4) {
			$error .= "Passwords need 4 characters or more! <br />";
		}
		if(strlen($email) < 4) {
			$error .= "Email need 4 characters or more! <br />";
		}
		if($password != $cPassword) {
			$error .= "Passwords don't match <br />";
		}
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$error .= "Not a valid email address <br /><br />";				
		}
		if($secretcode != "copyscauting") {
			$error .= "Wrong secret code <br /><br />";
		}
		if(strlen($error) < 1) {
			$safepassword = password_hash($password, PASSWORD_BCRYPT, array('cost'=>12));
			$query = "INSERT INTO kafelogin (`username`, `email`, `password`)
			VALUES ('$username', '$email', '$safepassword')";
			if(mysqli_query($conn, $query)) {
				echo "<div id='continue'>Username : $username registered! <br />
				<a href'/login/'>Go to login!</a>";
				unset($query);
			} else {
				echo("Error description: " . mysqli_error($conn));
			}

		} else {
			$error .= "<a href='?action=register'>Go back!</a><br />";
			echo $error;
		}
	}
	if(isset($_POST['upload'])) {

		set_time_limit(60);
		require_once "config.php";
		require_once "imgupload.class.php";
		$img = new ImageUpload;

		$result = $img->uploadImages($_FILES['image']);

		if(!empty($result->info)){
		    foreach($result->info as $infoMsg){
		        echo $infoMsg .'<br />';
		    }
		}

		echo "<div id='continue'>Your images can be viewed here:<br/><br/>";

		if(!empty($result->ids)){
		    foreach($result->ids as $id){
		        echo "http://localhost:8000/admin/image.php?id=". $id;
		    }
		}

		echo "<br /><a href='/admin/'>Go Back!</a></div>";
	}

	if(isset($_POST['picturedelids'])) {
		require_once "config.php";
		require_once "imgupload.class.php";

		$img = new ImageUpload;

		$picturedelete = $_POST['picturedelids'];

		foreach($picturedelete as $id) {
			$result = $img->deleteImage($id);
			if(!empty($result->info)){
			    foreach($result->info as $infoMsg){
			        echo $infoMsg .'<br />';
			    }
			}
			if(!empty($result->error)){
				foreach($result->error as $errMsg){
					echo $errMsg;
				}
			}
		}
		echo "<a href='/admin/'>Go back!</a>'";
	}
	if(isset($_POST['submit'])) {
		if(isset($_POST['titel']) && isset($_POST['text']) && isset($_POST['date']) && strlen($count) < 1) {
			$titel = mysqli_real_escape_string ($conn,$_POST['titel']);
			$text = mysqli_real_escape_string ($conn,$_POST['text']);
			$date = $_POST['date'];
			$query = "INSERT INTO evenement (`titel`, `datetime`, `text`)
			VALUES ('$titel', '$date', '$text')";
			if(mysqli_query($conn, $query)) {
				echo "<div id='continue'>Titel: " . $titel . "<br />Text:" . $text . "<br />Datum: " . $date . "<br /></div>";
				echo 'Art ID: ' . $count;
				unset($_SESSION['artformid']);
				if(isset($_SESSION['artformid'])) {
					echo "<script>alert('SESSION NOT DESTROYED');";
				} else {
					echo "<br />Session destroyed - Nieuw artikel posted";
				}
			} else {
				echo("Error description: " . mysqli_error($conn));
			}
			$latestuniqueid = $conn->insert_id;
			$picamount = $_POST['amount'];
			if(isset($_POST['pictureids'])) {
				$selectedpics = $_POST['pictureids'];
				$query1 = "";
				$count2 = array();
				foreach($selectedpics as $res) {
					$numres = ((int)$res);
					$currentartids = "SELECT `artikel_id` FROM images WHERE `id` = $res";
					
					if($currentartids = mysqli_query($conn,$currentartids)) {				
						$results = mysqli_fetch_assoc($currentartids);
						$results = explode(',',$results['artikel_id']);
						if(!in_array($count, $count2)) {
							$count2[] = $count;
						}
					}
					if(isset($results)) {
						$count2 = array_merge($results, $count2);		
					}
					$count3 = implode(',',$count2);	
					$query1 .= "UPDATE images SET `artikel_id` = '$count3' WHERE `id` = $latestuniqueid; ";	
					unset($count2); // $foo is gone
					$count2 = array();
					$query1 .= "UPDATE images SET `artikel_id` = $latestuniqueid WHERE `id` = $numres; ";
				}
				$query1 .= "UPDATE evenement SET `picturecount` = $picamount WHERE `id` = $latestuniqueid;";
				if(mysqli_multi_query($conn, $query1)) {
					echo "<div id='continue'>Max amount pictures: " . $picamount . "<br />Selected pics:" . $numres . "<br /> Inserted!</div>";
					unset($_SESSION['artformid']);
					if(isset($_SESSION['artformid'])) {
						echo "<script>alert('SESSION NOT DESTROYED');";
					} else {
						echo "Session destroyed";
					}
				} else {
					echo("Error description: " . mysqli_error($conn));
				}
			}
			if(isset($_POST['image'])) {
				set_time_limit(60);
				require_once "config.php";
				require_once "imgupload.class.php";
				$img = new ImageUpload;

				$result = $img->uploadImages($_FILES['image']);

				if(!empty($result->info)){
				    foreach($result->info as $infoMsg){
				        echo $infoMsg .'<br />';
				    }
				}

				echo "<div id='continue'>Your images can be viewed here:<br/><br/>";

				if(!empty($result->ids)){
				    foreach($result->ids as $id){
				        echo "http://localhost:8000/admin/image.php?id=". $id;
				    }
				}
			}

			echo "<br /><a href='/admin/'>Go Back!</a></div>";
		}else if(isset($_POST['titel']) && isset($_POST['text']) && isset($_POST['date']) && isset($count) && strlen($count) >= 1) {
			$titel = mysqli_real_escape_string ($conn,$_POST['titel']);
			$text = mysqli_real_escape_string ($conn,$_POST['text']);
			$oldarticleimg = mysqli_real_escape_string ($conn,$_POST['oldarticle']);
			$date = $_POST['date'];
			$query = "UPDATE evenement
			SET `titel` = '$titel', `text` = '$text', `datetime` = '$date'
			WHERE `id` = '$count'; ";
			if(mysqli_query($conn, $query)) {
				echo "<div id='continue'>Id: ".$count."<br />Titel: " . $titel . "<br />Text:" . $text . "<br />Datum: " . $date . "<br /></div>";
				unset($_SESSION['artformid']);
				if(isset($_SESSION['artformid'])) {
					echo "<script>alert('SESSION NOT DESTROYED');";
				} else {
					echo "Session destroyed - Artikel updated!";
				}

			} else {
				echo("Error description: " . mysqli_error($conn));
			}
			if(isset($_POST['amount'])) {
				$picamount = $_POST['amount'];
			}
			if(isset($_POST['pictureids'])) {
				$selectedpics = $_POST['pictureids'];
			}
			$count2 = array();		
			$query1 = "";
			if(isset($selectedpics) && $selectedpics != '') {
				foreach($selectedpics as $res) {					
					$oldartids = "SELECT `artikel_id`,`id` FROM images WHERE `id` = (SELECT `id` FROM images WHERE `artikel_id` LIKE '%$oldarticleimg%' OR `artikel_id` LIKE '$oldarticleimg%' OR `artikel_id` LIKE '%$oldarticleimg')"; 
					//GET ID OF IMG WITH THIS ARTICLE ADDED TO IT
					if($oldartid = mysqli_query($conn,$oldartids)) {
						$oldartikels = mysqli_fetch_assoc($oldartid);
						$oldartikelimageid = $oldartikels['id'];

						$commaleft = ",$oldarticleimg";
						$commaright = "$oldarticleimg,";

						if(strpos($oldartikels['artikel_id'],$commaleft) || $oldartikels['artikel_id'] == $commaleft) {
							$replacedstring = str_replace($commaleft, "", $oldartikels['artikel_id']);
							$somethingreplaced = true;
						} else if(strpos($oldartikels['artikel_id'],$commaright) || $oldartikels['artikel_id'] == $commaright) {
							$replacedstring = str_replace($commaright, "", $oldartikels['artikel_id']);
							$somethingreplaced = true;
						} else if($oldartikels['artikel_id'] === $oldarticleimg) {
							$replacedstring = str_replace($oldarticleimg, "", $oldartikels['artikel_id']);
							$somethingreplaced = true;
						}
						
						if(isset($somethingreplaced) && $somethingreplaced){

							$removequery = "UPDATE images SET `artikel_id` = '$replacedstring' WHERE `id` = $oldartikelimageid";

							if($removequery = mysqli_query($conn,$removequery)) {
								echo "<br />Removed artikel from old image id: $oldartikelimageid";
							} else {
								echo("Error description: " . mysqli_error($conn));
							}
						}
					}
					$numres = ((int)$res);
					$currentartids = "SELECT `artikel_id` FROM images WHERE `id` = $res"; 
					//GET EXISTING IDS OF SELECTED IMAGE
					
					if($currentartids = mysqli_query($conn,$currentartids)) {				
						$results = mysqli_fetch_assoc($currentartids);
						$results = explode(',',$results['artikel_id']);
						$count2 = $results;
						
						if(!in_array($count, $count2)) {
							$count2[] = $count;
						}
					}
					$count3 = implode(',',array_filter($count2));	
					$query1 .= "UPDATE images SET `artikel_id` = '$count3' WHERE `id` = $numres; ";
					unset($count2); // $foo is gone
					$count2 = array();
					
				}
			}
			$query1 .= "UPDATE `evenement` SET `picturecount` = $picamount WHERE id = $count;";
			if(mysqli_multi_query($conn, $query1)) {
				if(!isset($numres)) {
					$numres = 0;
				}
				echo "<div id='continue'>Max amount pictures: " . $picamount . "<br />Selected pics:" . $numres . "<br /> Updated!</div>";
				unset($_SESSION['artformid']);
				if(isset($_SESSION['artformid'])) {
					echo "<script>alert('SESSION NOT DESTROYED');";
				} else {
					echo "Session destroyed";
				}
			} else {
				echo("Error description: " . mysqli_error($conn));
			}
			if(isset($_POST['image'])) {
				set_time_limit(60);
				require_once "config.php";
				require_once "imgupload.class.php";
				$img = new ImageUpload;

				$result = $img->uploadImages($_FILES['image']);

				if(!empty($result->info)){
				    foreach($result->info as $infoMsg){
				        echo $infoMsg .'<br />';
				    }
				}

				echo "<div id='continue'>Your images can be viewed here:<br/><br/>";

				if(!empty($result->ids)){
				    foreach($result->ids as $id){
				        echo "http://localhost:8000/admin/image.php?id=". $id;
				    }
				}
			}

			echo "<br /><a href='/admin/'>Go Back!</a></div>";
		}
	}
	if(isset($_POST['deletebutton'])) {
		$id = $_POST['id'];
		$query = "DELETE FROM `evenement` WHERE id = $id;";
		if(mysqli_query($conn, $query)) {
			echo "<div id='continue'>Post with id: " . $id . "Deleted <br /><a href='/admin/'>Go Back!</a></div>";
		} else {
			echo("Error description: " . mysqli_error($conn));
		}
	}
}
?>