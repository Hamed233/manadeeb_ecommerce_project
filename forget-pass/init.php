<?php
/*
============================================================
== Configration all files & information special MyDream   ==
============================================================
*/

    session_start(); // starting session

    include '../config/connectDB.php'; // connect To DB

    // === All short path  ===

     // => Special includes directory
    $temp = '../includes/templates/';
    $page = '../includes/pages/';
    $func = '../includes/functions/';
    $lang = '../includes/langs/';
     // => special layout directory
    $css  = '../layout/css/';
    $js   = '../layout/js/';
    $img  = '../layout/imges/';
    $libr = '../layout/libraries/';

    // Static files

    include $func . 'function.php';   // functions file
    include '../config/config_lang.php';  // Configration languages
    include $temp . 'header.php';      // header template
