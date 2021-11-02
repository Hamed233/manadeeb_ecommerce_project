<!DOCTYPE html>
 <html>
     <head>
        <title><?php getTitle(); ?></title> <!-- Main Title -->
               <!-- All Meta -->
            <meta charset="UTF-8" />
            <meta http-equiv ="X-UA-Compatible" content="IE=edge" />
            <meta name ="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
            <meta name ="author" content="" />
            <meta name ="description" content="" />

           <!-- All file must be included -->
               <!--  All plugins -->
            <link rel="stylesheet" href="<?php echo $libr; ?>bootstrap/bootstrap.min.css" /> <!-- v4.0 -->
            <link rel="stylesheet" href="<?php echo $libr; ?>fontawesome/css/all.min.css" /><!-- Font-awesome library -->
            <link rel="stylesheet" href="<?php echo $libr; ?>normalize/normalize.css" /> <!-- Normailze library -->
               <!-- css file -->
             <link rel="stylesheet" href="<?php echo $css; ?>main_style.css" />
             <link rel="stylesheet" href="<?php echo $css; ?>responsive-query.css" />
              <?php
                 if ($_SESSION['lang'] == "ar") { ?>
                    <link rel="stylesheet" href="<?php echo $css; ?>rtl.css" />
              <?php } ?>

               <!-- Favicon -->
            <link rel="shortcut icon" href="<?php echo $img; ?>favicon.ico" type="image/x-icon">
     </head>
     <body>
      <!-- Preloader -->
      <!-- <div class="preloader d-flex align-items-center justify-content-center">
         <p class="round">
         <span class="ouro ouro3">
            <span class="left"><span class="anim"></span></span>
            <span class="right"><span class="anim"></span></span>
         </span>
         </p>
      </div> -->
