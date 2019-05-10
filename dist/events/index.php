<!DOCTYPE html>
<html lang="en">

  <head>


    <script src="/vendor/marked/marked.min.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Auti Kafé</title>

    <!-- Bootstrap core CSS -->
<link href="/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<!-- Custom fonts for this template -->
<link href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i" rel="stylesheet">

<!-- Custom styles for this template -->
<link href="/css/business-casual.min.css" rel="stylesheet">

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

    

<h1 class="site-heading text-center text-white d-none d-lg-block">
  <span class="site-heading-upper text-primary mb-3"><img src = "/img/auti%20logo.png" width="400px" alt = "Auti logo.png"></span>
</h1>


<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark py-lg-4" id="mainNav">
  <div class="container">
    <a class="navbar-brand text-uppercase text-expanded font-weight-bold d-lg-none" href="#"><img src = "/img/auti%20logo.png" style="max-width: 60vw; background-color: white;border-radius: 10px; " height="auto" alt = "Auto logo.png"></a>
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
          <a class="nav-link text-uppercase text-expanded" href="/evening/">De avond</a>
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

    <section class="page-section">

    <!-- Start php stukje -->
    <?php
        $query = "SELECT * FROM evenement WHERE datetime >= CURDATE() ORDER BY `datetime` ASC ";
        if($query = mysqli_query($conn, $query)) {
        //Content met 1 artikel
        $i = 0;
          while($row = mysqli_fetch_assoc($query)) {
            $evenementid = $row['id'];
            $titel = $row['titel'];
            $text = $row['text'];
            //$text = MarkdownExtended::parseString( $text , $options );
            $date = date_format(date_create($row['datetime']), 'd-m-Y');
            $imgquery = "SELECT `id` FROM `images` WHERE `artikel_id` LIKE '%$evenementid%'";
            if($imgquery = mysqli_query($conn, $imgquery)) {
                $result = mysqli_fetch_assoc($imgquery);
                if(isset($result['id'])) {
                  $picId = $result['id'];
                }else {
                  $picId = 3; //VOEG DEFAULT IMAGE IN
                }
              }
            //echo $titel;
            //echo $text;
            //echo $date;
            ?>


            <div class="container">
              <div class="product-item">
                <div class="product-item-title d-flex">
                  <div class="bg-faded p-5 d-flex <?php echo ($i%2 == 0 ?'ml':'mr');?>-auto rounded">
                    <h2 class="section-heading mb-0">
                      <span class="section-heading-upper"><?php echo $date;  ?></span>
                      <span class="section-heading-lower"><?php echo $titel; ?></span>
                    </h2>
                  </div>
                </div>
                <img class="product-item-img mx-auto d-flex rounded img-fluid mb-3 mb-lg-0" src="<?php echo '/admin/image.php?id=' . $picId; ?>" alt="">
                <!--<img class="product-item-img mx-auto d-flex rounded img-fluid mb-3 mb-lg-0" src="/img/aandebar.jpg" alt="">-->
                <div class="product-item-description d-flex <?php echo ($i%2 == 0 ?'mr':'ml');?>-auto">
                  <div class="bg-faded p-5 rounded" id="content">
                    <p id='markdown<?php echo $i;?>' class="mb-0"></p>
                    <script type="text/javascript">
                      console.log(marked);
                      document.getElementById('markdown<?php echo $i;?>').innerHTML = marked(`<?php echo $text;?>`);
                    </script>
                  </div>
                </div>
              </div>
            </div>
            <br/>
        <?php
        $i++;
      }
    } else {
      echo("Error description: " . mysqli_error($conn));
    }

    ?>
  </section>

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
					<a target = "_blank" href="https:scauting.nl"><img src="/img/aktdiel-logo.png"  height="100px" alt=""></a>
					<a target = "_blank" href="https:scauting.nl"><img src="/img/NVA.png"  height="100px" alt=""></a>
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


    <script src="/vendor/jquery/jquery.min.js"></script>
<script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/vendor/marked/marked.min.js"></script>
<script type="text/javascript">
  $(function () {
    var url = window.location.pathname; //sets the variable "url" to the pathname of the current window

        $('nav li a').each(function () { //looks in each link item within the primary-nav list
            var linkPage = this.getAttribute("href"); //sets the variable "linkPage" as the substring of the url path in each &lt;a&gt;

            if (url == linkPage) { //compares the path of the current window to the path of the linked page in the nav item
                $(this).parent().addClass('active'); //if the above is true, add the "active" class to the parent of the &lt;a&gt; which is the &lt;li&gt; in the nav list
            }
        });
})


</script>


  </body>

</html>
