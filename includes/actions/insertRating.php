<?php
  session_start();
  $header = '';
  include "../../config/connectDB.php";

    
      if(isset($_SESSION['cus_id'])){
        $userId = $_SESSION['cus_id'];
      } else {
        $userId = $_SESSION['sellar_id'];
      }
      
      if (isset($_POST["index"], $_POST["productid"])) {

        $product_id  = $_POST["productid"];
        $rating      = $_POST["index"];

        $stmt = $con->prepare("SELECT * from product_rating where user_id = ? and product_id = ?");
        $stmt->execute(array($userId, $product_id));
        $result = $stmt->fetchAll();
        $rows = $stmt->rowCount();

        if ($rows == 0) {

          $sql = $con->prepare("INSERT INTO product_rating(user_id, product_id, rating)
                                VALUES (:zuserid, :zproductId, :zrate)");
          $sql->execute(array(
            'zuserid'       => $userId,
            'zproductId'    => $product_id,
            'zrate'         => $rating
          ));

          $sql = $con->prepare("UPDATE products SET Rating = {$rating} WHERE p_id = {$product_id}");
          $sql->execute();

            echo "success";
        } else {
            echo "Already Voted!";
        }
      }
?>
