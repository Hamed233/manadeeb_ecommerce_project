<?php
  session_start();
  include "../../config/connectDB.php"; // connect with DB.
  // second delete all records in DB.
  $stmt = $con->prepare("DELETE FROM store_cart_item");
  $stmt->execute();
  // direct to cart page.
  header('Location: ../../cart.php');
  exit();
?>
