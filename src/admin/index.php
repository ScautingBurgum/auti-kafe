<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Auti Kafé - Admin</title>
    <link rel="stylesheet" type="text/css" href="/style.css">
    <link rel="template" href="templates/styling.html">
    <link rel="stylesheet" href="/vendor/easymde/dist/easymde.min.css">
	<script src="/vendor/easymde/dist/easymde.min.js"></script>
	<?php
	require_once('../scripts/dbcon.php');
	if(isset($_SESSION['artformid'])) {
	    $count = $_SESSION['artformid'];
	}if(isset($_POST['artformid'])) {
	  	$count = $_POST['artformid'];
	  	$_SESSION['artformid'] = $_POST['artformid'];
	} else if (isset($_POST['id'])) {
	  	$count = $_POST['id'];
	} else {
		$count = '';
	}
	?>
</head>
<body>
	<link rel="template" href="templates/header.html">
	<?php
	if(isset($_SESSION['username']) && !isset($_POST['logoff'])) {
	?>
	<div class='wrapper'>
		<table id="adminpanelinterface" class="tborder2 shopwidth" cellspacing="0" cellpadding="10" border="0">
			<thead>
				<tr>
					<td class="thead-alt" colspan="2">
						<div class='header'><h2><a href="#">Admin Panel</a></h2></div>
					</td>
				</tr>
			</thead>
			<tbody style="display: flex;" id="boardstats_e">
				<tr id="leftpanel">
					<td>
						<ul style="font-size: 20px; list-style-type: none">
							<li>
								<a id="artikelKnop" href="/admin/?action=post" style="cursor: pointer;color: #000;" name='postvlak'><i class="fa fa-group"></i>
								Post artikel
								</a>
							</li>
							<li>
								<a id="deletevlakknop" href="/admin/?action=current" style="cursor: pointer;color: #000;" name='deletevlak'><i class="fa fa-group"></i>
								Huidige artikels
								</a>
							</li>
							<li>
								<a id="imageuploadknop" href="/admin/?action=picupload" style="cursor: pointer;color: #000;" name='imagevlak'><i class="fa fa-group"></i>
								Foto upload
								</a>
							</li>
							<li>
								<a id="imagedeleteknop" href="/admin/?action=picdelete" style="cursor: pointer;color: #000;" name='imagedelvlak'><i class="fa fa-group"></i>
								Foto delete
								</a>
							</li>
						</ul>
						<div id ="personal" style="position: absolute; bottom: 0; margin-bottom: 10px">
							<?php
							echo "My username: " . $_SESSION['username'] . "<br />";
							?>
							<form action='' method='post'>
							<input type='submit' value='Logout' name='logoff' />
							<input type='submit' value='Reset Session' name='sessionreset' />
							</form>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div id='mainpage'>
							<?php
							$allowed = array('current', 'picupload', 'post', 'picdelete', 'submit');
							if (isset($_GET['action'])){
							    if (!in_array($_GET['action'], $allowed)) {
							        exit('Not permitted to view this page');
							    }
							    include('actions/action_'.$_GET['action'].'.php');
							}
							?>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
<?php
} else if (isset($_POST['logoff']) && $_POST['logoff'] == 'Logout') {
	unset($_SESSION['username']);
	echo "Logout successful";
	header("refresh:3;index.php");
} else {
	echo "<a href='login.php'>Login aub</a>";
}
<<<<<<< HEAD
//Begin Database troep
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

if(isset($_POST['submit'])) {
	if(isset($_POST['titel']) && isset($_POST['text']) && isset($_POST['date']) && strlen($count) < 1) {
		echo 'Test';
		$titel = mysqli_real_escape_string ($conn,$_POST['titel']);
		$text = mysqli_real_escape_string ($conn,$_POST['text']);
		$date = $_POST['date'];
		$query = "INSERT INTO evenement (`titel`, `datetime`, `text`)
		VALUES ('$titel', '$date', '$text')";
		if(mysqli_query($conn, $query)) {
			echo "<div id='continue'>Titel: " . $titel . "<br />Text:" . $text . "<br />Datum: " . $date . "<br /></div>";
			echo  $conn->insert_id;
			unset($_SESSION['artformid']);
			if(isset($_SESSION['artformid'])) {
				echo "<script>alert('SESSION NOT DESTROYED');";
			} else {
				echo "Session destroyed";
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
			echo $query1 .= "UPDATE evenement SET `picturecount` = $picamount WHERE `id` = $latestuniqueid;";
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
				echo "Session destroyed";
			}

		} else {
			echo("Error description: " . mysqli_error($conn));
		}
		$picamount = $_POST['amount'];
		$selectedpics = $_POST['pictureids'];
		$count2 = array();
		$query1 = "";
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
			$query1 .= "UPDATE images SET `artikel_id` = '$count3' WHERE `id` = $numres; ";
			unset($count2); // $foo is gone
			$count2 = array();
		}
		$query1 .= "UPDATE `evenement` SET `picturecount` = $picamount WHERE id = $count;";
		if(mysqli_multi_query($conn, $query1)) {
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
if(isset($_POST['sessionreset'])) {
	if($_POST['sessionreset'] == 'Reset Session') {
		unset($_POST['sessionreset']);
	}
}

// Einde Database Troep
=======
>>>>>>> 4e16727568141e7ddbdbce8cc5b81f007b982f4c
?>
<link rel="template" href="templates/footer.html">

    <!-- Bootstrap core JavaScript -->

    <link rel="template" href="templates/scripts.html">
    <script src="adminpanel.js"></script>
    <?php
	$query = "SELECT `text` FROM `evenement` WHERE `id` = " . $count;
	if($query = mysqli_query($conn, $query)) {
		$items = mysqli_fetch_array($query);
		$_SESSION['textareatext'] = $items['text'];
		if(isset($_SESSION['textareatext'])) {
			$textareatext = $_SESSION['textareatext'];
		} else {
			$textareatext = $items['text'];
		}
	}
	?>
    <script>
		easyMDE.value('<?php echo json_encode($textareatext); ?>');
		document.getElementById('continue').scrollIntoView();
	</script>
  </body>
</html>
