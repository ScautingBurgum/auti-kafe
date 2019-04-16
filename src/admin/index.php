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
				<form action='submit.php' method='post'>
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
	<form name="upload" action="submit.php" enctype="multipart/form-data" method="post">
	<?php
	$query = "SELECT * FROM `evenement` WHERE id = $count";
	if($query = mysqli_query($conn, $query)) {
		$items = mysqli_fetch_array($query);
	}
	?>
	<input type="hidden" value="<?php echo $count; ?>" name="id">
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
</div>
<div id="imagevlak" class="verbergItem pages" style='padding: 15px'>
	<form name="upload" action="submit.php" method="POST" enctype="multipart/form-data">
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
	if(isset($_GET["pagenr"]) && $_GET['pagenr'] != 0 && is_numeric($_GET['pagenr'])) {
		$limitget = htmlspecialchars($_GET["pagenr"]);
		$limitget = $limitget-1;
		if($limitget == 0) {
			$limit = 0;
		} else {
			$limit = $limitget*20;
		}
	} else {
		$limit = 0;
	}
	$artquery = "SELECT * FROM `evenement` LIMIT $limit,20";
	$artcounts = "SELECT count(id) FROM `evenement`";
	if($artquery = mysqli_query($conn, $artquery)) {
		echo '<div style="width:75%;height:350px;position:relative;overflow:hidden;">';
		$whilecounter = 0;
		$whilestyle = 0;
		while($result = mysqli_fetch_assoc($artquery)) {
			if($whilecounter < 10) {
				$styleside = "style='width:45%;position:absolute;left:10px;top:" . $whilestyle*35 . "px;'";
			} else {
				$whilestyle = 0;
				$styleside = "style='width:45%;position:absolute;left:50%;top:" . $whilestyle*35 . "px;'";
			}
			?>			
			<form method='post' action="" name='artsubmit' <?php echo $styleside; ?> >
				<input type='hidden' name='artformid' value='<?php echo $result['id']; ?>'></input>
				<input type='submit' value='<?php echo $result['titel']; ?>'></input>
			</form>
			<?php
			$whilestyle++;
			$whilecounter++;
		}
		if($artcounts = mysqli_query($conn, $artcounts)) {
			$artscounts = mysqli_fetch_array($artcounts);
			//var_dump($artscounts);
			$finalcount = $artscounts[0];
			$finalcount = ceil($finalcount/20);
		}
		echo '</div><div style="width:100%;"><span style="margin-left: 10px;">Page: ';
		for($i=1;$i<$finalcount+1;$i++) {
			echo '<a name="deletevlak" href="?pagenr=' . $i . '">'.$i.'</a>';
		}
		echo '</span></div>';
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
			echo '<hr>Titel: <br />' . $restitel . '<br /><hr>
			Datum: ' . $resdate . '<br />
			<form action="" method="post">
			<input type="hidden" name="id" value="'.$resid.'">
			<input id="showbutton" type="submit" '; ?> onclick="return confirm('Are you sure?')" 
			<?php echo 'value="Show" name="showbutton">
			<a name="postvlak"><input id="editbutton" type="submit" value="Edit" name="editbutton"></a>
			</form>';

			} else {
				echo("Error description: " . mysqli_error($conn));
			}
			echo '<form action="submit.php" method="post">
			<input type="hidden" name="id" value="'.$resid.'">
			<input id="deletebutton" type="submit" '; ?> onclick="return confirm('Are you sure?')" 
			<?php echo 'value="Delete" name="deletebutton">
			</form>';
		} else {
			//echo("Error description: " . mysqli_error($conn));
		}
} else if (isset($_POST['logoff']) && $_POST['logoff'] == 'Logout') {
	unset($_SESSION['username']);
	echo "Logout successful";
	header("refresh:3;index.php");
} else {
	echo "<a href='login.php'>Login aub</a>";
}
?>
</div>
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
