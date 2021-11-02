<?php
/*
============================================================
== Configration all files & information special MyDream   ==
============================================================
*/

    session_start(); // starting session

    include 'config/connectDB.php'; // connect To DB

        
    // Handle errors 
    ini_set('log_errors','On');
    ini_set('display_errors','Off');
    ini_set('error_reporting', E_ALL );
    define('WP_DEBUG', false);
    define('WP_DEBUG_LOG', true);
    define('WP_DEBUG_DISPLAY', false);

        /* at the top of 'check.php' */
        if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
          /* 
             Up to you which header to send, some prefer 404 even if 
             the files does exist for security
          */
          header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
  
          /* choose the appropriate page to redirect users */
          die( header( 'location: 404.php' ) );
  
      }

    // === All short path  ===

     // => Special includes directory
    $temp = 'includes/templates/';
    $page = 'includes/pages/';
    $func = 'includes/functions/';
    $lang = 'includes/langs/';
     // => special layout directory
    $css  = 'layout/css/';
    $js   = 'layout/js/';
    $img  = 'layout/images/';
    $libr = 'layout/libraries/';

    // Static files

    include $func . 'function.php';   // functions file
    include 'config/config_lang.php';  // Configration languages
    include $temp . 'header.php';      // header template

    if (!isset($head_dis)) {
      include $temp . 'main-nav.php';
    }

?>
