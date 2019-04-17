<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Auti Kafé - Admin</title>
    <link rel="stylesheet" type="text/css" href="/style.css">
    <!-- Bootstrap core CSS -->
<link href="/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<!-- Custom fonts for this template -->
<link href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i" rel="stylesheet">

<!-- Custom styles for this template -->
<link href="/css/business-casual.min.css" rel="stylesheet">

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
					<h5>Snelle links</h5>
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
<script src="/vendor/marked/marked.min.js"></script>
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
