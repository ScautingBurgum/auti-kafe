<!DOCTYPE html>
<html lang="en">

  <head>


    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
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
                <img class="product-item-img mx-auto d-flex rounded img-fluid mb-3 mb-lg-0" src="<?php echo '../admin/image.php?id=' . $picId; ?>" alt="">
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

    <link rel="template" href="templates/footer.html">

    <link rel="template" href="templates/scripts.html">

  </body>

</html>
