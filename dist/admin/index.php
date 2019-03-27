<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Auti Kafé - Admin</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
    <!-- Bootstrap core CSS -->
<link href="/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<!-- Custom fonts for this template -->
<link href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i" rel="stylesheet">

<!-- Custom styles for this template -->
<link href="/css/business-casual.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://unpkg.com/easymde/dist/easymde.min.css">
	<script src="https://unpkg.com/easymde/dist/easymde.min.js"></script>
    <?php
	require_once('../scripts/dbcon.php');	
	if(isset($_POST['artformid'])) {
		$count = $_POST['artformid'];
	} else if(isset($_SESSION['artformid'])) {
		$count = $_SESSION['artformid'];
	} else {
		$count = null;
	}
	?>
</head>
<body>
	

<h1 class="site-heading text-center text-white d-none d-lg-block">
  <span class="site-heading-upper text-primary mb-3"><img src = "/img/Auti logo.png" width="400px" alt = "Auti logo.png"></span>
</h1>
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark py-lg-4" id="mainNav">
  <div class="container">
    <a class="navbar-brand text-uppercase text-expanded font-weight-bold d-lg-none" href="#"><img src = "/img/Auti logo.png" style="max-width: 60vw; background-color: white;border-radius: 10px; " height="auto" alt = "Auto logo.png"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item px-lg-4">
          <a class="nav-link text-uppercase text-expanded" href="/">Home
            <!-- <span class="sr-only">(current)</span> -->
          </a>
        </li>
        <li class="nav-item px-lg-4">
          <a class="nav-link text-uppercase text-expanded" href="/about/">Over ons</a>
        </li>
        <li class="nav-item px-lg-4">
          <a class="nav-link text-uppercase text-expanded" href="/events/">Events</a>
        </li>
        <li class="nav-item px-lg-4">
          <a class="nav-link text-uppercase text-expanded" href="/location/">Locatie</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

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
			$query = "SELECT id, active, artikel_id FROM images";
			if($query = mysqli_query($conn, $query)) {
				$numrows = mysqli_num_rows($query);
				while($result = mysqli_fetch_assoc($query)) {
					$picId = $result['id'];
					$activeImg = $result['active'];
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
	if(isset($_POST['titel']) && isset($_POST['text']) && isset($_POST['date']) && strlen($count) < 1) {
		echo 'Test';
		$titel = mysqli_real_escape_string ($conn,$_POST['titel']);
		$text = mysqli_real_escape_string ($conn,$_POST['text']);
		$date = $_POST['date'];
		$query = "INSERT INTO evenement (`titel`, `datetime`, `text`)
		VALUES ('$titel', '$date', '$text')";
		if(mysqli_query($conn, $query)) {
			echo "<div id='continue'>Titel: " . $titel . "<br />Text:" . $text . "<br />Datum: " . $date . "<br /> Inserted!<a href='/admin/'>Go Back!</a></div>";
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

			//count($selectedpics);
			$query1 = "";
			foreach($selectedpics as $res) {
				$numres = ((int)$res);
				$query1 .= "UPDATE images SET `artikel_id` = $count WHERE `id` = $latestuniqueid; ";
			}
			echo $query1 .= "UPDATE `evenement` SET `picturecount` = $picamount WHERE id = $count;";
			if(mysqli_multi_query($conn, $query1)) {
				echo "<div id='continue'>Max amount pictures: " . $picamount . "<br />Selected pics:" . $numres . "<br /> Updated!<a href='/admin/'>Go Back!</a></div>";
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
	}else if(isset($_POST['titel']) && isset($_POST['text']) && isset($_POST['date']) && isset($count) && strlen($count) >= 1) {
		$titel = mysqli_real_escape_string ($conn,$_POST['titel']);
		$text = mysqli_real_escape_string ($conn,$_POST['text']);
		$date = $_POST['date'];
		$query = "UPDATE evenement
		SET `titel` = '$titel', `text` = '$text', `datetime` = '$date'
		WHERE `id` = '$count'; ";
		if(mysqli_query($conn, $query)) {
			echo "<div id='continue'>Id: ".$count."<br />Titel: " . $titel . "<br />Text:" . $text . "<br />Datum: " . $date . "<br /> Updated!<a href='/admin/'>Go Back!</a></div>";
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
		//count($selectedpics);
		$query1 = "";
		foreach($selectedpics as $res) {
			$numres = ((int)$res);
			$query1 .= "UPDATE images SET `artikel_id` = $count WHERE `id` = $numres; ";
		}
		echo $query1 .= "UPDATE `evenement` SET `picturecount` = $picamount WHERE id = $count;";
		if(mysqli_multi_query($conn, $query1)) {
			echo "<div id='continue'>Max amount pictures: " . $picamount . "<br />Selected pics:" . $numres . "<br /> Updated!<a href='/admin/'>Go Back!</a></div>";
			unset($_SESSION['artformid']);
			if(isset($_SESSION['artformid'])) {
				echo "<script>alert('SESSION NOT DESTROYED');";
			} else {
				echo "Session destroyed";
			}		
		} else {
			echo("Error description: " . mysqli_error($conn));
		}
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
if(isset($_POST['showbutton'])) {
	$id = $_POST['id'];
	$query = "UPDATE `evenement` SET actief = 0 WHERE actief = 1; ";
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
if(isset($_POST['sessionreset'])) {
	if($_POST['sessionreset'] == 'Reset Session') {
		unset($_POST['sessionreset']);
	}
}

// Einde Database Troep 
?>
</div>
<!-- <footer class="footer text-faded text-center py-5">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <p class="m-0 small">Copyright &copy; Sierd de Boer 2019</p>
      </div>

      <div class="col-sm-12">
        <img src="/img/scauting-logo.gif" alt="Scauting" height="75px" style="top: -48.5px; position:relative; float:right;">
      </div>
    </div>



  </div>
</footer> -->

<!------ Include the above in your HEAD tag ---------->

<!-- Footer -->
	<section id="footer">
		<div class="container">
			<div class="row text-center text-xs-center text-sm-left text-md-left">
				<div class="col-xs-12 col-sm-4 col-md-4">
					<h5>Quick links</h5>
					<ul class="list-unstyled quick-links">
						<li><a href="/"><i class="fa fa-angle-double-right"></i>Hoofdpagina</a></li>
						<li><a href="/about"><i class="fa fa-angle-double-right"></i>Over ons</a></li>
						<li><a href="/events/"><i class="fa fa-angle-double-right"></i>Events</a></li>
						<li><a href="/location/"><i class="fa fa-angle-double-right"></i>Locatie</a></li>
					</ul>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-4">
          <h5>Mede mogelijk gemaakt door:</h5>
          <a target = "_blank" href="https:scauting.nl"><img src="/img/scauting-logo.jpg" width="90%" alt=""></a>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-4">
					<h5>Contact</h5>
					<ul class="list-unstyled quick-links">
						<li><a href="javascript:void();"><i class="fa fa-user"></i>Kirsten Adema</a></li>
						<li><a href="tel:+31620005031"><i class="fa fa-phone"></i>06-20005031</li>
						<li><a href="mailto:autikafe@akt-diel.nl"><i class="fa fa-envelope"></i>autikafe@akt-diel.nl</li>
					</ul>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 mt-2 mt-sm-5">
					<ul class="list-unstyled list-inline social text-center">
						<li class="list-inline-item"><a href="https://nl-nl.facebook.com/aktdiel/" target = "_blank"><i class="fa fa-facebook"></i></a></li>
						<li class="list-inline-item"><a href="javascript:void();"><i class="fa fa-twitter"></i></a></li>
						<li class="list-inline-item"><a href="javascript:void();"><i class="fa fa-instagram"></i></a></li>
						<li class="list-inline-item"><a href="javascript:void();"><i class="fa fa-google-plus"></i></a></li>
						<li class="list-inline-item"><a href="javascript:void();" target="_blank"><i class="fa fa-envelope"></i></a></li>
					</ul>
				</div>
				</hr>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 mt-2 mt-sm-2 text-center text-white">

					<p class="h6">&copy Alle rechten gaan naar.<a class="text-green ml-2" href="https://scauting.nl/" target="_blank">Scauting : Sierd de Boer</a></p>
				</div>
				</hr>
			</div>
		</div>
	</section>


    <!-- Bootstrap core JavaScript -->

    <script src="/vendor/jquery/jquery.min.js"></script>
<script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/marked.min.js"></script>
<script type="text/javascript">
  $(function () {
    console.log("Hello")
    var url = window.location.pathname; //sets the variable "url" to the pathname of the current window

        $('nav li a').each(function () { //looks in each link item within the primary-nav list
            var linkPage = this.getAttribute("href"); //sets the variable "linkPage" as the substring of the url path in each &lt;a&gt;

            if (url == linkPage) { //compares the path of the current window to the path of the linked page in the nav item
                $(this).parent().addClass('active'); //if the above is true, add the "active" class to the parent of the &lt;a&gt; which is the &lt;li&gt; in the nav list
            }
        });
})


</script>

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