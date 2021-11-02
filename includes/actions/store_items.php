<?php
  session_start();
  $lang = '../../includes/langs/'; // Configration variable languages
  include '../../config/config_lang.php';  // Configration languages
  include '../../config/connectDB.php';  // connect db
  include '../../includes/functions/function.php';

  if(isset($_POST['total_cart_items']))
  {
      if (isset($_SESSION['cart']) && (isset($_SESSION['customer']) || isset($_SESSION['sellar']))) {
          $cou_cart = countItems("p_c_id", "store_cart_item");
          echo $cou_cart;
          exit();
      } else {
          echo '0';
      }
  }

  if(isset($_POST['item_img'])) {
     // store information
    $cart                   = $_POST['cart'];
    $img                    = $_POST['item_img'];
    $name_item              = $_POST['item_name'];
    $product_id             = $_POST['product_id'];
    $sellar_name            = $_POST['item_sellar'];
    $price                  = $_POST['item_price'];
    $discount               = $_POST['price_discount'];
    $quantity               = $_POST['item_quantity'];
    if(isset($_SESSION['cus_id'])){
      $cus_id = $_SESSION['cus_id'];
    } elseif(isset($_SESSION['sellar_id'])) {
      $cus_id = $_SESSION['sellar_id'];
    }
   // check if product is exist or not
   $sql = $con->prepare("SELECT p_id FROM store_cart_item WHERE p_id = ?");
   $sql->execute(array($product_id));
   $count = $sql->rowCount();

    if ($count !== 1) {
      $stmt = $con->prepare("INSERT INTO
                            store_cart_item(p_id, p_name, sellar_name, p_img, p_price, p_quantity, discount, customer_id, date_insert)
                            VALUES(:id, :pname, :sname, :pimg, :price, :quan, :discount, :cusid, now())");
      $stmt->execute(array (
        'id'       => $product_id,
        'pname'    => $name_item,
        'sname'    => $sellar_name,
        'pimg'     => $img,
        'price'    => $price,
        'quan'     => $quantity,
        'discount' => $discount,
        'cusid'    => $cus_id
      ));

      // for equal session with information
      $_SESSION['cart'][]     = $cart;
      $_SESSION['id'][]       = $product_id;
    }
    $cou_cart = countItems("p_c_id", "store_cart_item");
    echo $cou_cart;
    exit();
  }

if(isset($_POST['mycart'])) {
    $total    = 0;
  ?>
    <form class="product ft-product" action="order.php?do=check" method="POST">
      <?php
        if(isset($_SESSION['cus_id'])){
          $cus_id = $_SESSION['cus_id'];
        } elseif(isset($_SESSION['sellar_id'])) {
          $cus_id = $_SESSION['sellar_id'];
        }
        $getAll = $con->prepare("SELECT * FROM store_cart_item WHERE customer_id = ? ORDER BY p_c_id ASC");
        $getAll->execute(array($cus_id));
        $all = $getAll->fetchAll();

      foreach ($all as $value) { ?>

            <div class="ln">
                <div class="image ft-product-image ">
                    <a href="">
                        <img class="lazy image -loaded" width="60" height="60" src="<?php echo $value['p_img']; ?>" value="<?php echo $value['p_img']; ?>" alt="product img">
                    </a>
                    <input name="image" type="hidden" value="<?php echo $value['p_img']; ?>">
                </div>
                <div class="item">
                    <input name="product" type="hidden" value="<?php echo $value['p_name']; ?>">
                    <a href="#" class="name -mbs -inline-block ft-product-name "><?php echo $value['p_name']; ?></a>
                    <div class="acts">
                        <a class="osh-btn -link js-remove confirm" href="cart.php?action=delete&productid=<?php echo $value['p_id']; ?>">
                              <i class="fa fa-trash"></i>
                            <span class="label"><?php echo $lang['delete']; ?></span>
                        </a>
                    </div>
                </div>

                <!-- product id -->
                <input type="hidden" value="<?php echo $value['p_id']; ?>" name="product_id">

                <div class="quantity">
                  <?php echo '<span class="red">' . $value['p_quantity'] . '</span> ' . $lang['pieces']; ?>
                </div>

                <div class="unit-price ft-product-unit-price">
                    <span class="current">
                        <span><?php echo '&dollar;' . ($value['p_price'] - $value['discount']); ?></span>
                        <input name="price" type="hidden" value="<?php echo $value['p_price']; ?>">
                    </span>
                    <span class="old -mtm">
                        <span> <?php if (!empty($value['discount'])) { echo '&dollar;' . $value['p_price']; } ?></span>
                    </span>
                      <span class="save"><?php echo $lang['Provided:']; ?> <span> <?php echo '&dollar;' . $value['discount']; ?></span>
                    </span>
                </div>
                <?php

                    $final_price = ($value['p_price'] - $value['discount']) * $value['p_quantity'] ; ?>
                    <div class="subtotal ft-product-subtotal-price">
                        <span><?php echo '&dollar;' . number_format($final_price, 2); ?></span>
                    </div>
            </div>
            <input name="discount" type="hidden" value="<?php echo $value['discount']; ?>">
            <input name="final_price" type="hidden" value="<?php echo $final_price; ?>">

            <?php $total += $final_price; ?>
            <input name="total_price" type="hidden" value="<?php echo $total; ?>">

<?php  } ?>

        <div class="resume -mtxxl -mbxs">
            <div class="btn btn-light clean-cart"><a href="includes/actions/clean_cart.php"><?php echo $lang['clean cart']; ?></a></div>
            <div class="row total ft-total">
                <label><?php echo $lang['The total amount:']; ?></label>
                <div class="ft-total-panel">
                    <span dir="ltr"><?php echo '&dollar;' . number_format($total, 2); ?></span>
                </div>
            </div>
        </div>
        <div class="btn-sub">
          <button type="submit" class="btn btn-primary"><?php echo $lang['follow buying']; ?></button>
        </div>
</form>
<?php
   exit();
}
?>
