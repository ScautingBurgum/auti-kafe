<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Auti Kafé - Admin</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="template" href="templates/styling.html">
    <link rel="stylesheet" href="https://unpkg.com/easymde/dist/easymde.min.css">
	<script src="https://unpkg.com/easymde/dist/easymde.min.js"></script>
    <?php
	require_once('../scripts/dbcon.php');
	if(isset($_GET['artikel'])) {
		$count = $_GET['artikel'];
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
					<li>
						<a id="imageselectknop" style="cursor: pointer" name='imageselectvlak'><i class="fa fa-group"></i>
						Foto select
						</a>
					</li>
					<li>
						<a id="showvlakknop" style="cursor: pointer" name='showvlak'><i class="fa fa-group"></i>
						Opties
						</a>
					</li>					
				</ul>	
				<div id ="personal" style="position: absolute; bottom: 0; margin-bottom: 10px">
				<?php
				echo "My username: " . $_SESSION['username'] . "<br />";
				?>
				<form action='' method='post'>
				<input type='submit' value='Logout' name='logoff' />
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
	$query = "SELECT * FROM evenement";
	if($query = mysqli_query($conn, $query)) {
		$c = 0;
		while($result = mysqli_fetch_assoc($query)) {
			$resarray[] = $result;
			$c++;
		}
		$numrows = mysqli_num_rows($query);
	?>
	<label for="titel">Titel:</label><br /><input type="text" id="titel" name="titel" value="<?php if(isset($count) && $count !== '') { echo $resarray[$count]['titel']; } ?>"><br />
	<hr><label for="text">Text:</label><br /><textarea id="text" cols="60" rows="10" name="text"></textarea><br />
	<hr><label for="date">Datum:</label><input id="date" type="date" name="date" value="<?php if(isset($count) && $count !== '') { echo $resarray[$count]['datetime']; } ?>"><br />
	<input id="submit" type="submit" name="submit" value="Submit"></form>
	<?php
	}
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
<div id="imageselectvlak" class="verbergItem pages" style='padding: 15px'>
	<form name="imageselect" method="post">
		<?php
		$query = "SELECT picturecount FROM kafelogin";
		if($query = mysqli_query($conn, $query)) {
			$numpicsarr = mysqli_fetch_row($query);
		}
		if(isset($numpicsarr)) {
			$numpics = $numpicsarr[0];
		} else {
			$numpics = 0;
		}
		?>
		<label for="amount">Selecteer hoeveel foto's</label><input type='number' name='amount' value='<?php echo $numpics; ?>'><br /><hr><br />
		<?php
		$query = "SELECT id, active FROM images";
		if($query = mysqli_query($conn, $query)) {
			$numrows = mysqli_num_rows($query);
			while($result = mysqli_fetch_assoc($query)) {
				$picId = $result['id'];
				$activeImg = $result['active'];
				if($activeImg == 1) {
					$checked = 'checked';
				} else {
					$checked = '';
				}
				echo "<div style='float:left; margin: 5px;' class='imagediv'><img style='max-width: 200px; max-height: 200px' src='image.php?id=$picId' name='image' /><br />
				<input style='margin-left: calc(50% - 7px);margin-top: 5px;' type='checkbox' value='$picId' name='pictureids[]' $checked></div>";
			}
		}
		?>
		<br />
		<hr style='width: 100%;overflow: auto;'>
		<br />
		<input type='submit' name='imageselect' value='Select'>
	</form>
</div>
<div id="deletevlak" class="verbergItem pages" style='padding: 15px'>
	<?php
	$query = "SELECT * FROM evenement";
	if($query = mysqli_query($conn, $query)) {
		$c = 0;
		while($result = mysqli_fetch_assoc($query)) {
			$resarray[] = $result;
			$c++;
		}
		$numrows = mysqli_num_rows($query);
		for($i=0;$i<$c;$i++) {
			echo "<a name='deletevlak' href='?artikel=" . $i . "'>Art. $i</a> ";
		}	
		if(isset($count) && $count !== '') {
			$restitel = $resarray[$count]['titel'];
			$resdate = $resarray[$count]['datetime'];
			$resid = $resarray[$count]['id'];
		} else {
			$restitel = '';
			$resdate = '';
			$resid = '';
		}
		//var_Dump($resarray);
		echo '<hr>Titel: <br />' . $restitel . '<br /><hr>';
		//echo 'Text: <br />' . $resarray[$count]['text'] . '<br /><hr>';
		echo 'Datum: ' . $resdate . '<br />';
		$query = "SELECT showone FROM kafelogin";
		if($query = mysqli_query($conn, $query)) {
			$res = mysqli_fetch_assoc($query);
			if($res['showone'] == 1) {
			echo '<form action="" method="post">
			<input type="hidden" name="id" value="'.$resid.'">
			<input id="showbutton" type="submit" '; ?> onclick="return confirm('Are you sure?')" <?php echo 'value="Show" name="showbutton">
			<a name="postvlak" href="?artikel="' .$resid. '"><input id="editbutton" type="submit" value="Edit" name="editbutton"></a>
			</form>';
			}
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
	echo'</div><div id="showvlak" class="verbergItem pages"><form method="post">
		<button name="showonebutton" value="showone">Laat 1 zien</button>
		<button name="showonebutton" value="showmore">Laat alles zien</button>
	</form></div>';
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
	if(isset($_POST['titel']) && isset($_POST['text']) && isset($_POST['date']) && !isset($count)) {
		$titel = mysqli_real_escape_string ($conn,$_POST['titel']);
		$text = mysqli_real_escape_string ($conn,$_POST['text']);
		$date = $_POST['date'];
		$query = "INSERT INTO evenement (`titel`, `datetime`, `text`)
		VALUES ('$titel', '$date', '$text')";
		if(mysqli_query($conn, $query)) {
			echo "<div id='continue'>Titel: " . $titel . "<br />Text:" . $text . "<br />Datum: " . $date . "<br /> Updated!<a href='/admin/'>Go Back!</a></div>";
		} else {
			echo("Error description: " . mysqli_error($conn));
		}
	}
	if(isset($_POST['titel']) && isset($_POST['text']) && isset($_POST['date']) && isset($count)) {
		$titel = mysqli_real_escape_string ($conn,$_POST['titel']);
		$text = mysqli_real_escape_string ($conn,$_POST['text']);
		$date = $_POST['date'];
		$query = "UPDATE evenement
		SET `titel` = '$titel', `text` = '$text', `datetime` = '$date'
		WHERE `id` = '$count'; ";
		if(mysqli_query($conn, $query)) {
			echo "<div id='continue'>Titel: " . $titel . "<br />Text:" . $text . "<br />Datum: " . $date . "<br /> Updated!<a href='/admin/'>Go Back!</a></div>";
		} else {
			echo("Error description: " . mysqli_error($conn));
		}
	}
}
if(isset($_POST['imageselect'])) {
	$picamount = $_POST['amount'];
	$selectedpics = $_POST['pictureids'];
	//count($selectedpics);
	$query1 = "";
	foreach($selectedpics as $res) {
		$numres = ((int)$res);
		$query1 .= "UPDATE images SET `active` = 1 WHERE `id` = $numres; ";
	}
	$query1 .= "UPDATE 'kafelogin' SET `picturecount` = $picamount WHERE 1=1;";
	if(mysqli_multi_query($conn, $query1)) {
		echo "<div id='continue'>Max amount pictures: " . $picamount . "<br />Selected pics:" . $numres . "<br /> Updated!<a href='/admin/'>Go Back!</a></div>";
	} else {
		echo("Error description: " . mysqli_error($conn));
	}
}
if(isset($_POST['deletebutton'])) {
	$id = $_POST['id'];
	$query = "DELETE FROM 'evenement' WHERE id = $id;";
	if(mysqli_query($conn, $query)) {
		echo "<div id='continue'>Post with id: " . $id . "Deleted <br /><a href='/admin/'>Go Back!</a></div>";
	} else {
		echo("Error description: " . mysqli_error($conn));
	}
}
if(isset($_POST['showbutton'])) {
	$id = $_POST['id'];
	$query = "UPDATE evenement SET actief = 0 WHERE actief = 1; ";
	if(mysqli_query($conn, $query)) {
		$query = "UPDATE evenement SET actief = 1 WHERE id = $id; ";
		if(mysqli_query($conn, $query)) {
			echo "<div id='continue'>Gelukt! <br /><a href='/admin/'>Go Back!</a></div>";
			header("refresh:3;admin-panel.php");
		} else {
			echo("Error description: " . mysqli_error($conn));
		}
	} else {
		echo("Error description: " . mysqli_error($conn));
	}
}
if(isset($_POST['showbutton'])) {
	$id = $_POST['id'];
}
if(isset($_POST['showonebutton'])) {
	if($_POST['showonebutton'] == 'showone') {
		$query = "UPDATE kafelogin SET showone = 1;";
		if(mysqli_query($conn, $query)) {
			echo "Success!";
			header("refresh:3;admin-panel.php");
		} else {
			echo("Error description: " . mysqli_error($conn));
		}
	} else if($_POST['showonebutton'] == 'showmore') {
		$query = "UPDATE kafelogin SET showone = 0;";
		if(mysqli_query($conn, $query)) {
			echo "Success!";
			//header("refresh:3;admin-panel.php");
		} else {
			echo("Error description: " . mysqli_error($conn));
		}
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
	//<?php if(isset($count)) { echo $resarray[$count]['text']; } 
	$query = "SELECT * FROM evenement";
	if($query = mysqli_query($conn, $query)) {
		$c = 0;
		while($result = mysqli_fetch_assoc($query)) {
			$resarray[] = $result;
			$c++;
		}
		$numrows = mysqli_num_rows($query);
		if(isset($count) && $count !== '') { echo $textareatext = $resarray[$count]['text']; } else { $textareatext = '';}
	?>
    <script>
		easyMDE.value('<?php echo json_encode($textareatext); ?>');
		document.getElementById('continue').scrollIntoView();
	</script>
	<?php
	}
	?>
  </body>

</html>