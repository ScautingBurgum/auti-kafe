<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Auti Kafé</title>

    <link rel="template" href="templates/styling.html">
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
    <link rel="template" href="templates/footer.html">

    <link rel="template" href="templates/scripts.html">

  </body>

</html>
