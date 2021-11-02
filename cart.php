<?php
    ob_start();
    $pageTitle = 'Cart';
    $no_ads    = '';
    include "init.php";

    if (isset($_GET["action"]) == 'delete') {

        // Check If Get Request Itemid Is Numeric & Get The Integer Value It

       $productid = isset($_GET['productid']) && is_numeric($_GET['productid']) ? intval($_GET['productid']) : 0;

        // Select All Data Depend On This ID

        $check = checkItem('p_id', 'store_cart_item', $productid);

        // If There Is Such ID Show The Form

      if($check > 0) {

          $sql = $con->prepare('DELETE FROM store_cart_item WHERE p_id = :zid');
          $sql->bindparam(":zid", $productid);  
          $sql-> execute();
      }
    }
?>

<div class="my-container container_100 _mar_top cart">
    <h1 class=""><?php echo $lang['cart']; ?> (<?php
        if (isset($_SESSION['cart']) && isset($_SESSION['customer']) || isset($_SESSION['sellar'])){
          $cou_cart = countItems("p_c_id", "store_cart_item");
            echo "<span class='count-product'>" . $cou_cart . "</span>";
        } else {
            echo "<span class='count-product'>0</span>";
        } ?>
           <?php echo $lang['products']; ?>)</h1>

    <div class="free-shiping-eligible-cart-header"></div>

    <?php

     $cou_cart = countItems("p_c_id", "store_cart_item");
     if (!empty($cou_cart) && (isset($_SESSION['customer']) || isset($_SESSION['sellar']))) { ?>

    <div class="items ft-products-list">
        <div class="header">
            <div class="item"><?php echo $lang['product']; ?></div>
            <div class="quantity"><?php echo $lang['amount']; ?></div>
            <div class="unit-price"><?php echo $lang['The total amount']; ?></div>
            <div class="subtotal"><?php echo $lang['unit price']; ?></div>
        </div>

        <!-- Here All Cart Info -->
        <div id="mecart"></div>

    </div>


    <div class="button-info">
        <div class="btn-content">
         <div class="btn btn-success"><a href="index.php"><?php echo $lang['Back to the web site']; ?></a></div>
        </div>
    </div>
</div>
    <?php } else { ?>
        <div class="cart-empty">
            <img src="layout/images/cart.png" alt="Cart" />
            <h2><?php echo $lang['Your cart is empty']; ?></h2>
            <p><?php echo $lang['Browse our categories and discover our best offers']; ?></p>
            <div class="btn btn-danger"><a href="index.php"><?php echo $lang['Shopping']; ?></a></div>
        </div>
    <?php  } ?>
</div>


<?php
    include $temp . 'footer.php';
    ob_end_flush();
?>
