<?php
  session_start();
  $header = '';
  include "../../config/connectDB.php";
  $lang = "../../includes/langs/";
  include "../../config/config_lang.php";

?>

<?php
  if ((isset($_SESSION['customer']) || isset($_SESSION['sellar']))) {
      function userRating($userId, $productId) {

            global $con;
            $average = 0;
            $total_row = 0;

            $query = $con->prepare("SELECT rating FROM product_rating WHERE user_id = ? and product_id = ? limit 1");
            $query->execute(array($userId, $productId));
            $rows = $query->rowCount();
            $avgQuery = $query->fetchAll();

            if ($rows > 0) {
                foreach ($avgQuery as $query) {
                    $average = round($query["rating"]);
                } // endForeach
            } // endIf
            return $average;
        }
         // endFunction

        function totalRating($productId){
          global $con;
          $query = $con->prepare("SELECT * FROM product_rating WHERE product_id = ?");
          $query->execute(array($productId));
          $result = $query->rowCount();
          $totalVotesQuery = $query->fetchAll();

            return $result;
        } //endFunction

        if(isset($_SESSION['cus_id'])){
          $userId = $_SESSION['cus_id'];
        } elseif(isset($_SESSION['sellar_id'])) {
          $userId = $_SESSION['sellar_id'];
        }
            

            $query = $con->prepare("SELECT * FROM products ORDER BY p_id DESC");
            $query->execute();
            $row = $query->fetch();

            $outputString = '';

            $userRating = userRating($userId, $row['p_id']);
            $totalRating = totalRating($row['p_id']);
            $outputString .= '
            <div class="row-item">
              <ul class="list-inline" onMouseLeave="mouseOutRating(' . $row['p_id'] . ',' . $userRating . ');"> ';

                for ($count = 1; $count <= 5; $count++) {
                    $starRatingId = $row['p_id'] . '_' . $count;

                    if ($count <= $userRating) {

                        $outputString .= '<li value="' . $count . '" id="' . $starRatingId . '" class="star selected">&#9733;</li>';
                    } else {
                        $outputString .= '<li value="' . $count . '"  id="' . $starRatingId . '" class="star" onclick="addRating(' . $row['p_id'] . ',' . $count . ');" onMouseOver="mouseOverRating(' . $row['p_id'] . ',' . $count . ');">&#9733;</li>';
                    }
                } // endFor


              $outputString .= '
            </ul>
           <p class="review-note">' . $lang["Total Reviews"] . ': <span class="red">' . $totalRating . '</span></p></div>';

        echo $outputString;

        } else {
            echo "<div class='alert alert-success text-center' style='margin-bottom: 27px;'><i class='fas fa-exclamation-circle'></i>" . $lang['Log in to learn more about the product'] . "</div>";
        }
?>
<script src="../../layout/js/main.js"></script>
