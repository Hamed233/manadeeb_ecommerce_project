<?php
/*
================================
==   Configration languages   ==
================================
*/

   if (!isset($_SESSION['lang'])) {
       
      $_SESSION['lang'] = "en";
       
   } elseif (isset($_GET['lang']) && $_SESSION['lang'] != $_GET['lang'] && !empty($_GET['lang'])) {
       
       if ($_GET['lang'] == 'en') {
           
           $_SESSION['lang'] = "en";
           
       } elseif ($_GET['lang'] == 'ar') {
           
           $_SESSION['lang'] = "ar";
           
       } elseif ($_GET['lang'] == 'ardo') {
           
           $_SESSION['lang'] = "ardo";
      }
   }
    include  $lang . $_SESSION['lang'] . ".php";

?>