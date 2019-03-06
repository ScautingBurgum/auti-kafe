<!DOCTYPE html>
<html lang="en">

  <head>

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


    <!-- Start php stukje -->
    <?php
    $query = "SELECT * FROM evenement";
    if($query = mysqli_query($conn, $query)) {
      $c = 0;
      while($result = mysqli_fetch_assoc($query)) {
        $resarray[] = $result;
        $c++;
      }
      if(isset($showone) && $showone == 0) {
        for($i=0;$i<$c;$i++) {
          echo "<a href='?artikel=" . $i . "'>Art. $i</a> ";
        }
        // Content met meerdere artikels
        echo '<hr>Titel: <br />' . $resarray[$count]['titel'] . '<br /><hr>';
        echo 'Text: <br />' . $resarray[$count]['text'] . '<br /><hr>';
        echo 'Datum: ' . $resarray[$count]['datetime'] . '<br />';
      } else if (isset($showone) && $showone == 1) {
        $query = "SELECT * FROM evenement WHERE actief = 1";
        if($query = mysqli_query($conn, $query)) {
        //Content met 1 artikel
          $row = mysqli_fetch_assoc($query);
          $titel = $row['titel'];
          $text = $row['text'];
          //$text = MarkdownExtended::parseString( $text , $options );
          $date = date_format(date_create($row['datetime']), 'd-m-Y');
          //echo $titel;
          //echo $text;
          //echo $date;  
          ?>
          <div class="product-item">
            <div class="product-item-title d-flex">
              <div class="bg-faded p-5 d-flex ml-auto rounded">
                <h2 class="section-heading mb-0">
                  <span class="section-heading-upper"><?php echo $date; ?></span>
                  <span class="section-heading-lower"><?php echo $titel; ?></span>
                </h2>
              </div>
            </div>
            <img class="product-item-img mx-auto d-flex rounded img-fluid mb-3 mb-lg-0" src="/img/DSC_2157.jpg" alt="">
            <div class="product-item-description d-flex mr-auto">
              <div class="bg-faded p-5 rounded">
                <p class="mb-0">
                  <table class="timetable" style="width:100%">
                    <tr>
                      <td valign="top">20:00-20.30</td>
                      <td>Welkom, de deur gaat open (idereen krijgt een naamsticker)</td>
                    </tr>

                    <tr>
                      <td valign="top"> 20:30</td>
                      <td>Activiteit(1 december 2018: Pubquiz?)</td>
                    </tr>

                    <tr>
                      <td valign="top">21:00</td>
                      <td>Disco in de bar (zaal 5
                      De 2 rustige ruimtes zijn open, spelletjes zijn aanwezig (zaal 6 & 7)
                      Zo mogelijk is op de begane grond de biljartruimte open</td>
                    </tr>

                    <tr>
                      <td valign="top">23:00</td>
                      <td>Muziek gaat uit</td>
                    </tr>


                    <tr>
                      <td valign="top">23:30</td>
                      <td>Einde van de avond</td>
                    </tr>
                  </table>
                </p>
              </div>
            </div>
        </div>
        
    <section class="page-section">
      <div class="container">
        <div class="product-item">
          <div class="product-item-title d-flex">
            <div class="bg-faded p-5 d-flex mr-auto rounded">
              <h2 class="section-heading mb-0">
                <span class="section-heading-upper">De dj</span>
                <span class="section-heading-lower">achter de bar</span>
              </h2>
            </div>
          </div>
          <img class="product-item-img mx-auto d-flex rounded img-fluid mb-3 mb-lg-0" src="/img/aandebar.jpg" alt="">
          <div class="product-item-description d-flex ml-auto">
            <div class="bg-faded p-5 rounded">
              <p id='markdown' class="mb-0"><?php echo $text; ?></p>
            </div>
          </div>
        </div>
      </div>
    </section>
        <?php

        }
      }
    } else {
      echo("Error description: " . mysqli_error($conn));
    }

    ?>

    </div>
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


    <script src="/vendor/jquery/jquery.min.js"></script>
<script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="marked.min.js"></script>
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
$("#signup").click(function() {
$("#first").fadeOut("fast", function() {
$("#second").fadeIn("fast");
});
});

$("#signin").click(function() {
$("#second").fadeOut("fast", function() {
$("#first").fadeIn("fast");
});
});



         $(function() {
           $("form[name='login']").validate({
             rules: {

               email: {
                 required: true,
                 email: true
               },
               password: {
                 required: true,

               }
             },
              messages: {
               email: "Please enter a valid email address",

               password: {
                 required: "Please enter password",

               }

             },
             submitHandler: function(form) {
               form.submit();
             }
           });
         });



$(function() {

  $("form[name='registration']").validate({
    rules: {
      firstname: "required",
      lastname: "required",
      email: {
        required: true,
        email: true
      },
      password: {
        required: true,
        minlength: 5
      }
    },

    messages: {
      firstname: "Please enter your firstname",
      lastname: "Please enter your lastname",
      password: {
        required: "Please provide a password",
        minlength: "Your password must be at least 5 characters long"
      },
      email: "Please enter a valid email address"
    },

    submitHandler: function(form) {
      form.submit();
    }
  });
});

</script>


  </body>

</html>
