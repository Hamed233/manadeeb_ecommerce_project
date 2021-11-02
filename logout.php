<?php

     session_start();    // Start This Session

     session_unset();    // Unset Data

     session_destroy();  // Destroy The Session

     header('Location: index.php');

     exit();