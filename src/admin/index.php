<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Auti Kafé - Admin</title>
    <link rel="stylesheet" type="text/css" href="/style.css">
    <link rel="template" href="templates/styling.html">
    <link rel="stylesheet" href="/vendor/easymde.dist/easymde.min.css">
	  <script src="/vendor/easymde/dist/easymde.min.js"></script>
    <?php
	require_once('../scripts/dbcon.php');
  if(isset($_SESSION['artformid'])) {
    $count = $_SESSION['artformid'];
  }if(isset($_POST['artformid'])) {
  $count = $_POST['artformid'];
  $_SESSION['artformid'] = $_POST['artformid'];
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
						<a id="artikelKnop" style="cursor: pointer" name='postvlak'><i class="fa fa-group"></i>
						Post artikel
						</a>
					</li>
					<li>
						<a id="deletevlakknop" style="cursor: pointer" name='deletevlak'><i class="fa fa-group"></i>
						Huidige artikels
						</a>
					</li>
					<li>
						<a id="imageuploadknop" style="cursor: pointer" name='imagevlak'><i class="fa fa-group"></i>
						Foto upload
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

				</div>
			</td>
		</tr>
	</tbody>
</table>
<div id="postvlak" class="verbergItem pages" style='padding: 15px'>
	<form name="upload" enctype="multipart/form-data" method="post">
	<?php
	//<?php if(isset($count)) { echo $resarray[$count]['text']; }
	$query = "SELECT * FROM `evenement` WHERE id = $count";
	if($query = mysqli_query($conn, $query)) {
		$items = mysqli_fetch_array($query);
	}
	?>
	<label for="titel">Titel:</label><br /><input type="text" id="titel" name="titel" value="<?php if(isset($count) && $count !== '') { echo $items['titel']; } ?>"><br />
	<hr><label for="text">Text:</label><br /><textarea id="text" cols="60" rows="10" name="text"></textarea><br />
	<hr><label for="date">Datum:</label><input id="date" type="date" name="date" value="<?php if(isset($count) && $count !== '') { echo $items['datetime']; } ?>"><br />
		<?php
		$query = "SELECT picturecount FROM evenement WHERE id = $count";
		if($query = mysqli_query($conn, $query)) {
			$numpicsarr = mysqli_fetch_row($query);
		}
		if(isset($numpicsarr)) {
			$numpics = $numpicsarr[0];
		} else {
			$numpics = 0;
		}
			echo "<label for='amount'>Selecteer hoeveel foto's</label><input type='number' name='amount' value='" . $numpics . "'><br /><hr><br />";
			?>
			<label for='image[]'>Select image to upload: </label><br /><input type="file" name="image[]" multiple><br /><hr><br />
			<?php
			if(!empty($result->error)){
				foreach($result->error as $errMsg){
					echo $errMsg;
				}
			}
			if(!empty($result->info)){
				foreach($result->info as $infoMsg){
					echo $infoMsg;
				}
			}
			echo"<div style='display: table-cell;width: 100%;'>";
			$query = "SELECT id,artikel_id FROM images";
			if($query = mysqli_query($conn, $query)) {
				$numrows = mysqli_num_rows($query);
				while($result = mysqli_fetch_assoc($query)) {
					$picId = $result['id'];
					$artikel_id = $result['artikel_id'];
					if($artikel_id == $count && strlen($count) >= 1) {
						$checked = 'checked';
					} else {
						$checked = '';
					}
					echo "<div style='float:left; margin: 5px;' class='imagediv'><img style='max-width: 200px; max-height: 200px' src='image.php?id=$picId' name='image' /><br />
					<input style='margin-left: calc(50% - 7px);margin-top: 5px;' type='checkbox' value='$picId' name='pictureids[]' $checked></div>";
				}
			}
			echo "</div><hr><br/>";

		?>
	<input id="submit" type="submit" name="submit" value="Submit"></form>
	<?php

	?>
</div>
<div id="imagevlak" class="verbergItem pages" style='padding: 15px'>
	<form name="upload" method="POST" enctype="multipart/form-data">
		<label for='image[]'>Select image to upload: </label><br /><input type="file" name="image[]" multiple><br /><hr><br />
		<input type="submit" name="upload" value="upload">
	</form>
	<?php
	if(!empty($result->error)){
		foreach($result->error as $errMsg){
			echo $errMsg;
		}
	}
	if(!empty($result->info)){
		foreach($result->info as $infoMsg){
			echo $infoMsg;
		}
	}
	?>
</div>
<div id="deletevlak" class="verbergItem pages" style='padding: 15px'>
	<?php
	$artquery = "SELECT * FROM `evenement`";
	if($artquery = mysqli_query($conn, $artquery)) {
		while($result = mysqli_fetch_assoc($artquery)) {
			?>
			<form method='post' name='artsubmit'>
				<input type='hidden' name='artformid' value='<?php echo $result['id']; ?>'></input>
				<input type='submit' value='<?php echo $result['titel']; ?>'></input>
			</form>
			<?php
		}
	}
	if(strlen($count) >= 1) {
		$query = "SELECT * FROM evenement WHERE id = $count";
		if($query = mysqli_query($conn, $query)) {
			$items = mysqli_fetch_array($query,MYSQLI_ASSOC);
			if(isset($count) && $count !== '') {
				$restitel = $items['titel'];
				$resdate = $items['datetime'];
				$resid = $items['id'];
			} else {
				$restitel = '';
				$resdate = '';
				$resid = '';
			}
			//var_Dump($resarray);
			echo '<hr>Titel: <br />' . $restitel . '<br /><hr>';
			//echo 'Text: <br />' . $resarray[$count]['text'] . '<br /><hr>';
			echo 'Datum: ' . $resdate . '<br />';
			echo '<form action="" method="post">
			<input type="hidden" name="id" value="'.$resid.'">
			<input id="showbutton" type="submit" '; ?> onclick="return confirm('Are you sure?')" <?php echo 'value="Show" name="showbutton">
			<a name="postvlak"><input id="editbutton" type="submit" value="Edit" name="editbutton"></a>
			</form>';

			} else {
				echo("Error description: " . mysqli_error($conn));
			}
			echo '<form action="" method="post">
			<input type="hidden" name="id" value="'.$resid.'">
			<input id="deletebutton" type="submit" '; ?> onclick="return confirm('Are you sure?')" <?php echo 'value="Delete" name="deletebutton">
			</form>';
		} else {
			echo("Error description: " . mysqli_error($conn));
		}
} else if (isset($_POST['logoff']) && $_POST['logoff'] == 'Logout') {
	unset($_SESSION['username']);
		echo "Logout successful";
		header("refresh:3;index.php");

} else {
	echo "<a href='login.php'>Login aub</a>";
}
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
<<<<<<< HEAD
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
=======
				$query1 .= "UPDATE images SET `artikel_id` = $latestuniqueid WHERE `id` = $numres; ";
>>>>>>> b80567754c9713c4e611847f087fcf7ea86c9a27
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
<<<<<<< HEAD
		$query1 .= "UPDATE `evenement` SET `picturecount` = $picamount WHERE id = $count;";
=======
		echo $query1 .= "UPDATE evenement SET `picturecount` = $picamount WHERE id = $count;";
>>>>>>> b80567754c9713c4e611847f087fcf7ea86c9a27
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
?>
</div>
<link rel="template" href="templates/footer.html">

    <!-- Bootstrap core JavaScript -->

    <link rel="template" href="templates/scripts.html">
    <script src="adminpanel.js"></script>
    <?php
    if(isset($_SESSION['artformid'])) {
    	$count = $_SESSION['artformid'];
    }if(isset($_POST['artformid'])) {
		$count = $_POST['artformid'];
		$_SESSION['artformid'] = $_POST['artformid'];
	} else {
		$count = '';
	}
	//<?php if(isset($count)) { echo $resarray[$count]['text']; }
	$query = "SELECT `text` FROM `evenement` WHERE `id` = " . $_SESSION['artformid'];
	if($query = mysqli_query($conn, $query)) {
		$items = mysqli_fetch_array($query);
		$_SESSION['textareatext'] = $items['text'];

		if(isset($_SESSION['textareatext'])) {
			echo $textareatext = $_SESSION['textareatext'];
		} else {
			$textareatext = $items['text'];
		}
	?>
    <script>
		easyMDE.value('<?php echo json_encode($textareatext); ?>');
		document.getElementById('continue').scrollIntoView();
	</script>
	<?php
	if(isset($_POST['artformid'])) {
		$count = $_POST['artformid'];
		$_SESSION['artformid'] = $_POST['artformid'];
	} else if (isset($_SESSION['artformid'])){
		$count = $_SESSION['artformid'];
	}else {
		$count = '';
	}
	}
	?>
  </body>

</html>
