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
		$count = 0;
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
						Verwijder artikel
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
<div id="postvlak" class="verbergItem pages"><form method="post">
	<label for="titel">Titel:</label><br /><input type="text" id="titel" name="titel"><br />
	<hr><label for="text">Text:</label><br /><textarea id="text" cols="60" rows="10" name="text"></textarea><br />
	<hr><label for="date">Datum:</label><input id="date" type="date" name="date"><br />
	<input id="submit" type="submit" name="submit" value="Submit"></form>
</div>
<div id="deletevlak" class="verbergItem pages">
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
		//var_Dump($resarray);
		echo '<hr>Titel: <br />' . $resarray[$count]['titel'] . '<br /><hr>';
		echo 'Text: <br />' . $resarray[$count]['text'] . '<br /><hr>';
		echo 'Datum: ' . $resarray[$count]['datetime'] . '<br />';
		$query = "SELECT showone FROM kafelogin";
		if($query = mysqli_query($conn, $query)) {
			$res = mysqli_fetch_assoc($query);
			if($res['showone'] == 1) {
			echo '<form action="" method="post">
			<input type="hidden" name="id" value="'.$resarray[$count]['id'].'">
			<input id="showbutton" type="submit" '; ?> onclick="return confirm('Are you sure?')" <?php echo 'value="Show" name="showbutton">
			</form>';
			}
		} else {
			echo("Error description: " . mysqli_error($conn));
		}
		echo '<form action="" method="post">
		<input type="hidden" name="id" value="'.$resarray[$count]['id'].'">
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

if(isset($_POST['submit'])) {
	if(isset($_POST['titel']) && isset($_POST['text']) && isset($_POST['date'])) {
		$titel = mysqli_real_escape_string ($conn,$_POST['titel']);
		$text = mysqli_real_escape_string ($conn,$_POST['text']);
		$date = $_POST['date'];
		$query = "INSERT INTO evenement (`titel`, `datetime`, `text`)
		VALUES ('$titel', '$date', '$text')";
		if(mysqli_query($conn, $query)) {
			echo "Titel: " . $titel . "<br />Text:" . $text . "<br />Datum: " . $date . "<br /> Submitted!";			
			header("refresh:3;admin-panel.php");
		} else {
			echo("Error description: " . mysqli_error($conn));
		}
	}
}
if(isset($_POST['deletebutton'])) {
	$id = $_POST['id'];
	$query = "DELETE FROM 'evenement' WHERE id = $id;";
	if(mysqli_query($conn, $query)) {
		echo "Success!";
		header("refresh:3;admin-panel.php");
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
			echo "Success!";
			header("refresh:3;admin-panel.php");
		} else {
			echo("Error description: " . mysqli_error($conn));
		}
	} else {
		echo("Error description: " . mysqli_error($conn));
	}
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
  </body>

</html>