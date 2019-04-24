<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Auti Kafé - Admin</title>
    <link rel="stylesheet" type="text/css" href="/style.css">
    <link rel="template" href="templates/styling.html">
    <link rel="template" href="templates/scripts.html">
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
	if(isset($_POST['sessionreset'])) {
		if($_POST['sessionreset'] == 'Reset Session') {
			unset($_POST['sessionreset']);
		}
	}
} else if (isset($_POST['logoff']) && $_POST['logoff'] == 'Logout') {
	unset($_SESSION['username']);
	echo "Logout successful";
	header("refresh:3;index.php");
} else {
	echo "<a href='login.php'>Login aub</a>";
}
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
		} else if($items['text']) {
			$textareatext = $items['text'];
		}
	} else {
		$textareatext = "";
	}
	?>
    <script>
    $(document).ready(function() {
		easyMDE.value('<?php if(strlen($textareatext) > 1) { echo $textareatext; } ?>');
	});
	</script>
  </body>
</html>
