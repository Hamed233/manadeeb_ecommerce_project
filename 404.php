<?php
/*
** =================================== **
**** 404 Not Found Page *****
** =================================== **
*/
  ob_start();
  $no_ads = ''; // for disable main navbar
  $pageTitle = '404 Not Found'; // Page Main Title
  include 'init.php'; // this file contain all info for config
 ?>

<div class="bg-purple">
        
        <div class="stars">
            <div class="central-body">
                <img class="image-404" src="http://salehriaz.com/404Page/img/404.svg" width="300px">
                <a href="index.php" class="btn-go-home" target="_blank">GO BACK HOME</a>
            </div>
            <div class="objects">
                <img class="object_rocket" src="http://salehriaz.com/404Page/img/rocket.svg" width="40px">
                <div class="earth-moon">
                    <img class="object_earth" src="http://salehriaz.com/404Page/img/earth.svg" width="100px">
                    <img class="object_moon" src="http://salehriaz.com/404Page/img/moon.svg" width="80px">
                </div>
                <div class="box_astronaut">
                    <img class="object_astronaut" src="http://salehriaz.com/404Page/img/astronaut.svg" width="140px">
                </div>
            </div>
            <div class="glowing_stars">
                <div class="star"></div>
                <div class="star"></div>
                <div class="star"></div>
                <div class="star"></div>
                <div class="star"></div>

            </div>

        </div>

    </div>

<?php
    include $temp . 'footer.php'; // Footer template
    ob_end_flush(); // Release The Output
 ?>