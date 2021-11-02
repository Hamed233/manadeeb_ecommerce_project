<?php

/*
===============================
   order Page
===============================
*/

  ob_start(); // OutPut Buffering Start
  $head_dis = ''; // for disable main navbar
  $lang = 'includes/langs/'; // for languages
  include 'config/config_lang.php'; // configration languages
  if ($_GET['do'] == 'done') {
    $pageTitle = $lang['Done, your order is send!']; // main page title
  } elseif($_GET['do'] == 'my_orders') {
    $pageTitle = $lang['My orders'];
  } elseif ($_GET['do'] == 'check') {
    $pageTitle = $lang['Follow buying'];
  } elseif ($_GET['do'] == 'ordernum'){
    $pageTitle = $lang['order number'] . ' ' . $_GET['order_number']; // main page title
  }
  include 'init.php'; // initialize files


  // make inside pages
  $do = isset($_GET['do']) ? ($_GET['do']) : 'not-allow';

  if ($do == 'not-allowd') {
      header('Location: index.php');
      exit();
  } elseif ($do == 'check') {

    // form information

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (isset($_POST['submit_info_order'])) {

        // personal information for order
        $username       = test_input($_POST['username']);
        $phone          = test_input($_POST['phone']);
        $customer_id    = $_SESSION['cus_id'];
        $adress_1       = test_input($_POST['adress_1']);
        $adress_2       = test_input($_POST['adress_2']);
        $city           = test_input($_POST['city']);
        $country        = test_input($_POST['country']);

        // place recieve
        $delivery       = test_input($_POST['delivery']);
        $place_center   = test_input($_POST['place-center']);

        // payment method
        $way_pay        = test_input($_POST['way_pay']);

        // credit card information
        $cart_number       = test_input($_POST['cart_num']);
        // $cart_num_validate = validatecard($cart_number);
        $exp_date_m        = test_input($_POST['exp_date_m']);
        $exp_date_y        = test_input($_POST['exp_date_y']);
        $secutiry_code     = test_input($_POST['secutiry_code']);

        // product info
        $total_price    = $_POST['total_price'];
        $orderNum       = rand(0, 10239048);
        $payment_id     = rand(998, 120934750);
        $ord_id         = rand(200, 8844820);

        // validate form
        $formErr = array();

        if (isset($username)) {
          $filter_username = filter_var($username, FILTER_SANITIZE_STRING);
          if ($filter_username != true) {
            $formErr [] = "<div class='alert alert-danger'>This name [" . $username . "] Invalid. </div>";
          }

          if (empty($username)) {
            $formErr [] = "<div class='alert alert-danger'>Full name is required.</div>";
          }

          if (!preg_match("/^[a-zA-Z ]*$/", $username)) {
            $formErr[] = "<div class='alert alert-danger'>Only letters and white space allowed in <b>Full name</b> input</div>";
          }
        }

        if (isset($phone)) {
          if (validate_phone_number($phone) !== true) {
            $formErr [] = "<div class='alert alert-danger'>" . $phone . 'Invalid phone number.' . "</div>";
          }

          if (empty($phone)) {
            $formErr [] = "<div class='alert alert-danger'>Phone is required.</div>";
          }
        }

        if (isset($adress_1) || isset($adress_2)) {
          if (empty($adress_1 || $adress_2)) {
            $formErr [] = "<div class='alert alert-danger'>Address_1 & Address_2 is required.</div>";
          }

          if (strlen($adress_1 || $adress_2) > 5) {
            $formErr [] = "<div class='alert alert-danger'>Address_1 or Address_2 is very short.</div>";
          }

          if (strlen($adress_1 || $adress_2) > 35) {
            $formErr [] = "<div class='alert alert-danger'>Address_1 or Address_2 is very long.</div>";
          }
        }

        if (isset($city)) {

            $filter_city = filter_var($city, FILTER_SANITIZE_STRING);

            if (strlen($city) < 4) {
                $formErr [] = "<div class='alert alert-danger'>City is very short</div>";
            }

            if ($filter_city != true) {
                $formErr [] = "<div class='alert alert-danger'>City Invalid</div>";
            }
        }

        if ($country == 0) {
          $formErr [] = "<div class='alert alert-danger'>You must choose <b>country</b>.</div>";
        }

        if ($way_pay == "by_card") {

            if (empty($cart_number || $exp_date_m || $exp_date_y || $secutiry_code)) {
                $formErr[] = "<div class='alert alert-danger'> Inputs Credit Card is <b>Empty. </b>. </div>";
            }

        } elseif ($delivery == "station") {

            if (empty($place_center)) {
                $formErr[] = "<div class='alert alert-danger'> Input is <b>Empty. </b>. </div>";
            }

        }

      // validate credit card
      if ($way_pay == "by_card") {

        if (empty($cart_number)) {
          $formErr [] = "<div class='alert alert-danger'>Cart number is required.</div>";
        }

        if (strlen($exp_date_m) > 2 || strlen($exp_date_m) < 2 || strlen($exp_date_y) > 2 || strlen($exp_date_y) < 2 || !is_numeric($exp_date_m)) {
          $formErr [] = "<div class='alert alert-danger'>Expiry date not valid.</div>";
        }

        if (empty($exp_date_m || $exp_date_y)) {
          $formErr [] = "<div class='alert alert-danger'>Expiry date is required.</div>";
        }

        $validate_secutiry_code = filter_var($secutiry_code, FILTER_SANITIZE_NUMBER_INT);

        if (strlen($secutiry_code) > 3 || strlen($secutiry_code) < 3 || $validate_secutiry_code != true) {
          $formErr [] = $formErr [] = "<div class='alert alert-danger'>Secutiry code not valid.</div>";
        }

        if (empty($secutiry_code)) {
          $formErr [] = "<div class='alert alert-danger'>Security code is required.</div>";
        }
      }

        if (empty($formErr)) {

         if ($way_pay == "by_card") {

           $stmt = $con->prepare("INSERT INTO payment(payment_method, ord_num, credit_cart_num, exp_m, exp_y, security_code, customer_id, payment_id, date_record)
                                   VALUES(:paymeth, :ord_num, :num, :expm, :expy, :code, :cus_id, :payid, now())");
           $stmt->execute(array(
             'paymeth' => $way_pay,
             'ord_num' => $orderNum,
             'num'     => $cart_number,
             'expm'    => $exp_date_m,
             'expy'    => $exp_date_y,
             'code'    => $secutiry_code,
             'cus_id'  => $customer_id,
             'payid'   => $payment_id
           ));
         } else {
           $stmt = $con->prepare("INSERT INTO payment(payment_method, ord_num, customer_id, date_record)
                                   VALUES(:paymeth, :ord_num, :cus_id, now())");
           $stmt->execute(array(
             'paymeth' => $way_pay,
             'ord_num' => $orderNum,
             'cus_id'  => $customer_id
           ));
         }


         $stmt2 = $con->prepare("INSERT INTO orders(customerID, order_id, ord_number, payment_method, address_1, address_2, city, country_id, customer_name, place_center, customer_phone, order_total_price, delivery_type, ord_date)
                                 VALUES(:cusid, :ordid, :ordnum, :paymethod, :caddress_1, :caddress_2, :ccity, :coun, :cname, :cpcenter, :cphone, :ordtprice, :cdelevery, now())");
         $stmt2->execute(array(
           'cusid'        => $customer_id,
           'ordid'        => $ord_id,
           'ordnum'       => $orderNum,
           'paymethod'    => $way_pay,
           'caddress_1'   => $adress_1,
           'caddress_2'   => $adress_2,
           'ccity'        => $city,
           'coun'         => $country,
           'cname'        => $username,
           'cpcenter'     => $place_center,
           'cphone'       => $phone,
           'ordtprice'    => $total_price,
           'cdelevery'    => $delivery
         ));


         $count = COUNT($_POST['product_id']);
         for ($i = 0; $i < $count; $i++) {

           // product info
           $product_id     = $_POST['product_id'][$i];
           $product_name   = $_POST['product_name'][$i];
           $p_f_price      = $_POST['p_f_price'][$i];
           $quantity       = $_POST['quantity'][$i];

         $stmt3 = $con->prepare("INSERT INTO orderdetails(productID, ord_number, ord_quantity, product_name, size, color, product_price, order_id, cus_id)
                                 VALUES(:productid, :ordnum, :ordquan, :product_name, 0, 'no_colors', :productprice, :ordid, :c_id)");
         $stmt3->execute(array(
           'productid'    => $product_id,
           'ordnum'       => $orderNum,
           'ordquan'      => $quantity,
           'product_name' => $product_name,
           'productprice' => $p_f_price,
           'ordid'        => $ord_id,
           'c_id'         => $customer_id
         ));

         // update product [orders_numbers]

         $stmt4 = $con->prepare("UPDATE products SET orders_number = orders_number + 1 WHERE p_id = ?");
         $stmt4->execute(array($product_id));
      }



      // clean cart
      $stmt5 = $con->prepare("DELETE FROM store_cart_item");
      $stmt5->execute();

         header('Location: ?do=done');
         exit();
      }
    } //

    } else {
        header('Location: index.php');
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){  ?>

       <div class="order-navbar">
         <div class="nav-b"><a class="navbar-brand" href="index.php"><span>M</span></a></div>
         <div class="section-header">
           <div class="safe-pay"><i class="fab fa-slack"></i><span><?php echo $lang['safe payment']; ?></span></div>
           <div class="return-easy"><i class="fa fa-recycle"></i><span><?php echo $lang['Easy return of products']; ?></span></div>
         </div>
      </div>
      <div class="container order-content">
        <h3 class="following-buy-head order-h-g"><?php echo $lang['Follow buying']; ?></h3>
       <div class="row">
        <div class="col-sm-8 col-md-8 col-lg-8 f_sec_ord">
            <form action="?do=check" method="post">
                <?php
                  $cus_id = isset($_SESSION['customer']) ? $_SESSION['customer'] : $_SESSION['sellar_id'];
                  $getAll = $con->prepare("SELECT * FROM store_cart_item WHERE customer_id = ? ORDER BY p_c_id ASC");
                  $getAll->execute(array($cus_id));
                  $all = $getAll->fetchAll();

                  // order details
                  foreach($all as $value) {
                    echo '<input type="hidden" name="image" value="' . $value['p_img'] . '">';
                    echo '<input type="hidden" name="product_name[]" value="' . $value['p_name'] . '">';
                    echo '<input type="hidden" name="quantity[]" value="' . $value['p_quantity'] . '">';
                    echo '<input type="hidden" name="p_f_price[]" value="' . ($value['p_price'] - $value['discount']). '">';
                    echo '<input type="hidden" name="discount[]" value="' . $value['discount'] . '">';
                    echo '<input type="hidden" name="product_id[]" value="' . $value['p_id'] . '">';
                  } ?>

                  <input type="hidden" name="total_price" value="<?php echo $_POST['total_price']; ?>">

                  <!-- start customer details  -->
                  <div class="section-first section-g">
                     <h4 class="section-title"><i class="fa fa-check-circle circle_1"></i><?php echo $lang['Address details']; ?></h4>
                      <div class="data-client">
                        <div class="form-row">
                          <div class="form-group col-md-6">
                              <label for="name"><?php echo $lang['Full name']; ?></label>
                              <input type="text" class="form-control pay_s_1_input" name="username" id="name" placeholder="<?php echo $lang['Full name']; ?>" minlength="10" maxlength="30" value="<?php echo isset($_POST["username"]) ? $_POST["username"] : ''; ?>" required>
                          </div>
                          <div class="form-group col-md-6">
                              <label for="phone"><?php echo $lang['Phone number']; ?></label>
                              <input type="tel" class="form-control pay_s_1_input" name="phone" id="phone" placeholder="<?php echo $lang['Phone number']; ?>" maxlength="13" value="<?php echo isset($_POST["phone"]) ? $_POST["phone"] : ''; ?>" required>
                          </div>
                          <div class="form-group col-md-6">
                              <label for="inputAddress"><?php echo $lang['First address']; ?></label>
                              <input type="text" class="form-control pay_s_1_input" name="adress_1" id="inputAddress" placeholder="<?php echo $lang['1234 Main St']; ?>" value="<?php echo isset($_POST["adress_1"]) ? $_POST["adress_1"] : ''; ?>" required>
                          </div>
                          <div class="form-group col-md-6">
                              <label for="inputAddress2"><?php echo $lang['Second address']; ?></label>
                              <input type="text" class="form-control pay_s_1_input" name="adress_2" id="inputAddress2" placeholder="<?php echo $lang['Apartment, studio, or floor']; ?>" value="<?php echo isset($_POST["adress_2"]) ? $_POST["adress_2"] : ''; ?>">
                          </div>
                          <div class="form-group col-md-6">
                              <label for="inputCity"><?php echo $lang['City']; ?></label>
                              <input type="text" class="form-control pay_s_1_input" name="city" id="inputCity" placeholder="<?php echo $lang['City']; ?>" value="<?php echo isset($_POST["city"]) ? $_POST["city"] : ''; ?>" required>
                          </div>
                          <!-- Start country filed -->
                           <div class="form-group col-md-6">
                            <label for="country"><?php echo $lang['country']; ?></label>
                              <select class="form-control pay_s_1_input" id="country" name="country">
                                <option value="0"><?php echo $lang['country']; ?></option>
                                  <?php
                                  $allCountries = getAllFrom("*", "countries", "", "", "coun_id");

                                       foreach ($allCountries as $country) {
                                           echo "<option value='" . $country['coun_id'] . "'>" . $country['coun_name'] . "</option>";
                                       }

                                    ?>
                              </select>
                          </div>
                        </div>
                     <!-- End country filed -->
                  </div><!-- .section-one -->
                </div>

                <div class="section-second  section-g">
                    <h4 class="section-title"><i class="fa fa-check-circle circle_2"></i><?php echo $lang['2. Delivery method']; ?></h4>
                    <div class="sec-content">
                        <div class="sec-one">
                            <h5><?php echo $lang['How do you want your order to be delivered?']; ?></h5>
                            <div class="sec-con-1">
                             <input class="form-check-input" type="radio" value="at_home" name="delivery" class="deliver" id="way-send" checked>
                             <p class="para-g"><?php echo $lang['Delivery to your door.']; ?></p>
                             <div class="alert alert-secondary alert-g">
                               <i class="fa fa-exclamation-circle"></i>
                               <span class="span_alert"><?php echo $lang['We will do our best to deliver all of your products in one shipment']; ?></span>
                             </div>
                            </div>
                            <hr />
                            <div class="sec-con-2">
                                <input class="form-check-input" value="station" type="radio" name="delivery" class="deliver" id="way-send-s">
                                <p class="para-g"><?php echo $lang['The receiving station']; ?></p>
                                <div class="alert alert-secondary alert-g">
                                  <i class="fa fa-exclamation-circle"></i>
                                  <span class="span_alert"><?php echo $lang['Choose the nearest reception center and enjoy free shipping']; ?></span>
                                </div>
                                <div class="center-inp d-none" style="margin: 31px;">
                                  <h5 class="h-center"><?php echo $lang['Select a specific delivery center']; ?></h5>
                                  <textarea class="choose-place" name="place-center" value="<?php echo isset($_POST["place-center"]) ? $_POST["place-center"] : ''; ?>"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- .section-second -->

                <div class="section-third section-g">
                    <h4 class="section-title"><i class="fa fa-check-circle circle_3"></i><?php echo $lang['3. Payment method']; ?></h4>
                    <div class="sec-con-3">
                      <h5><?php echo $lang['How would you like to pay for your order?']; ?></h5>
                       <div class="way-1 way-g">
                           <input id="card_pay" class="form-check-input pay_t" value="by_card" type="radio" name="way_pay" >
                           <img src="layout/images/visa.png" alt="visa">
                           <span class="way-name"><?php echo $lang['Pay by bank card']; ?></span>
                       </div>

                        <div class="form-payment d-none">
                            <h1 class="text-center"><?php echo $lang['Card Information']; ?></h1>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="cardnumber"><?php echo $lang['Card Number']; ?></label>
                                    <input class="form-control" name="cart_num" id="cardnumber" type="text" placeholder="<?php echo $lang['Card Number']; ?>" value="<?php echo isset($_POST["cart_num"]) ? $_POST["cart_num"] : ''; ?>">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="field-container col-3">
                                    <label for="expirationdate"><?php echo $lang['Expiration (mm)']; ?></label>
                                    <input class="form-control" id="expirationdate" name="exp_date_m" type="text" size="2" pattern="[0-9]*" minlength="2" maxlength="2" inputmode="numeric" placeholder="mm" value="<?php echo isset($_POST["exp_date_m"]) ? $_POST["exp_date_m"] : ''; ?>">
                                </div>
                                <div class="field-container col-3">
                                    <label for="expirationdate"><?php echo $lang['Expiration (yy)']; ?></label>
                                    <input class="form-control" id="expirationdate" name="exp_date_y" type="text" size="2" pattern="[0-9]*" minlength="2" maxlength="2" inputmode="numeric" placeholder="yy" value="<?php echo isset($_POST["exp_date_y"]) ? $_POST["exp_date_y"] : ''; ?>">
                                </div>
                                <div class="field-container col-6">
                                    <label for="securitycode"><?php echo $lang['Security Code']; ?></label>
                                    <input class="form-control" name="secutiry_code" id="securitycode" type="text" pattern="[0-9]*" inputmode="numeric" minlength="3" maxlength="3" placeholder="<?php echo $lang['Security Code']; ?>" value="<?php echo isset($_POST["secutiry_code"]) ? $_POST["secutiry_code"] : ''; ?>">
                                </div>
                            </div>
                        </div>
                        <hr />
                        <div class="way-3 way-g">
                            <input id="by_hand" class="form-check-input pay_t" value="money_on_recieve" type="radio" name="way_pay" checked>
                            <img src="layout/images/buy-hand.png" alt="buy">
                            <span class="way-name"><?php echo $lang['Cash on delivery']; ?></span>
                        </div>
                    </div>
                </div><!-- .section-third -->
                <button type="submit" class="btn btn-danger btn-block send-g" name="submit_info_order"><?php echo $lang['Confirm order']; ?></button>
            </form>

            <div class="formErr text-center" style="margin: 20px 0;">
            <?php
              if (isset($formErr)) {
                foreach($formErr as $err) {
                  echo "<b>" . $err . '</b>';
                }
              }
            ?>
          </div>
        </div>

        <div class="col-sm-4 col-md-4 col-lg-4">
          <h3 class="order-h-g"><?php echo $lang['Summary your request']; ?></h3>
            <div class="order-summery section-g">
                <h3 class="section-title">
                  <?php
                    $cou_cart = countItems("p_c_id", "store_cart_item");
                    echo $lang['Your order'] . ' (<span class="red"> ' . $cou_cart . ' </span>' . $lang['Products'] . ' )';
                  ?>
                </h3>

                <?php
                  $cus_id = isset($_SESSION['customer']) ? $_SESSION['cus_id'] : $_SESSION['sellar_id'];
                  $getAll = $con->prepare("SELECT * FROM store_cart_item WHERE customer_id = ? ORDER BY p_c_id ASC");
                  $getAll->execute(array($cus_id));
                  $all = $getAll->fetchAll();
                ?>


                <div class="product-or-content">
                  <div class="row">
                    <?php
                      foreach($all as $product) { ?>
                        <div class="col-3">
                          <img src="<?php echo $product['p_img']; ?>" alt="<?php echo $product['p_name']; ?>" />
                        </div>

                        <div class="col-9">
                           <div class="product-or-name"><?php echo $product['p_name']; ?></div>
                           <div class="product-or-price"><?php echo '&dollar;' . ($product['p_price'] - $product['discount']); ?></div>
                        </div>
                    <?php } ?>
                </div>
              </div>

                <div class="mon-info">
                    <?php $total = $_POST['total_price']; ?>
                    <p><?php echo '* ' . $lang['Total price']; ?><?php echo '<span>:' . number_format($total, 2) . '&dollar;</span> + ' . $lang['Shipping expenses']; ?></span></p>
                </div>
            </div><!-- .summery-order -->
        </div>
    </div><!-- .row -->
</div><!-- .container -->

<?php
} else {
        header('Location: index.php');
        exit();
    } ?>


<?php  } elseif ($do == 'done') {

// if($_SERVER['REQUEST_METHOD'] == 'POST') {
       // get info order
       $stmt_1 = $con->prepare("SELECT * FROM orders WHERE customerID = ?");
       $stmt_1->execute(array($_SESSION['cus_id']));
       $order = $stmt_1->fetch();
       // get info order_details
       $stmt_2 = $con->prepare("SELECT * FROM orderdetails WHERE ord_number = ?");
       $stmt_2->execute(array($order['ord_number']));
       $order_details = $stmt_2->fetch();
       // get product information.
       $stmt_3 = $con->prepare("SELECT * FROM products WHERE p_id = ?");
       $stmt_3->execute(array($order_details['productID']));
       $product_details = $stmt_3->fetchAll();
       // get customer info.
       $stmt_4 = $con->prepare("SELECT * FROM customers WHERE cus_id = ?");
       $stmt_4->execute(array($_SESSION['cus_id']));
       $customer = $stmt_4->fetch();

       // send alert for mail
       $to       = "info@manadeeb.com";
       $from     = $customer['cus_mail'];
       $name     = $customer['cus_f_name'] . ' ' . $customer['cus_l_name'];
       $subject  = 'your order has been sent!';

       $headers = "From: $from";
       $headers = "From: " . $from . "\r\n";
       $headers .= "Reply-To: ". $from . "\r\n";
       $headers .= "MIME-Version: 1.0\r\n";
       $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

       $logo = 'M';
       $link = 'https://manadeeb.com/';

       $body = "<!DOCTYPE html><html lang='en'><head><meta charset='UTF-8'><title>Your order has been send!</title></head><body>";
       $body .= '<div class="table-responsive"><table class="main-table text-center table table-bordered">';
       $body .= "<tr><td>" . $lang['product'] . "</td>";
       $body .= "<td>" . $lang['Product information'] . "</td>";
       $body .= "<td>" . $lang['Price'] . "</td></tr>";
       foreach ($product_details as $detail) {
         $body .= "<tr><td><img src='../admin-dashboard/upload/products/'" . $detail['p_picture'] . "' alt='product img' style='height: 60px; width: 60px;'></td>";
         $body .= "<td>" . $detail['p_name'] . "<br>" . $detail['p_description'] . "</td>";
         $body .= "<td>$" . $detail['price'] . "</td></tr>";
       }
       $body .= "</table></div>";
       $body .= "</body></html>";

       // $send = mail($to, $subject, $body, $headers);

       ?>

        <!-- card done page -->
       <div class="order-navbar">
         <div class="nav-b"><a class="navbar-brand" href="index.php"><span>M</span></a></div>
         <div class="section-header">
           <div class="safe-pay"><i class="fas fa-check-circle"></i><span><?php echo $lang['Done, your order is send!']; ?></span></div>
           <div class="return-easy"><i class="fa fa-recycle"></i><span><?php echo $lang['You can only return the product after two weeks']; ?></span></div>
         </div>
       </div>

      <div class="container">
       <div class="card-done">
        <h2 class="done-head text-center"><?php echo $lang['Done, your order is send!']; ?></h2>
        <div class="row">
          <div class="col-12">
           <div class="text-center"><i class="fas fa-check-circle"></i></div>
           <div class="alert_cus">
             <div><?php echo $lang['Hi'] . '<b> ' . $_SESSION['customer'] . ' </b>' . $lang['Done, your order is send & you number order'] . ':<span class="red"><a href="order.php?do=ordernum&order_number=' . $order['ord_number'] . '">' . $order['ord_number'] . '</a>.</span>'; ?></div>
           </div>
          </div>
        </div>

        <div class="more-info-for-customer">
          <?php echo $lang['You can know all orders & follow your orders']; ?>
          <a href="order.php?do=my_orders&customerid=<?php echo $_SESSION['cus_id']; ?>"><span class="red"><b><?php echo $lang['My orders']; ?></b></span></a>
        </div>

        <div class="btn btn-danger"><a href="index.php"><?php echo $lang['Back to the web site']; ?></a></div>
       </div>
     </div>

<?php 
// } else {
//         header('Location: 404.php');
//         exit();
//       }
   } elseif ($do == 'my_orders') {

        if (isset($_GET['customerid'])) {
          // get info order
          $stmt_1 = $con->prepare("SELECT * FROM orders WHERE customerID = ?");
          $stmt_1->execute(array($_SESSION['cus_id']));
          $order = $stmt_1->fetch();
          // get info order_details
          $stmt_2 = $con->prepare("SELECT * FROM orderdetails WHERE cus_id = ?");
          $stmt_2->execute(array($order['customerID']));
          $order_details = $stmt_2->fetchAll();


          ?>

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
             <div class="container header-con">
              <a class="navbar-brand" href="index.php"><span>M</span></a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
            </div>
           </nav>

          <h2 class="text-center myorders_head"><?php echo $lang['My orders']; ?></h2>
          <div class="container-fluid">
            <div class="my_orders_container">
              <?php if (!empty($order_details)) { ?>
              <div class="table-responsive">
                  <table class="main-table text-center table table-bordered">
                      <tr>
                          <td><?php echo $lang['product']; ?></td>
                          <td><?php echo $lang['quantity']; ?></td>
                          <td><?php echo $lang['Price']; ?></td>
                          <td><?php echo $lang['Order_number']; ?></td>
                          <td><?php echo $lang['date_order']; ?></td>
                      </tr>

                      <?php

                           foreach($order_details as $detail) {

                               echo "<tr>";
                                  echo "<td><a href='product.php?productid=" . $detail['productID'] . '&productname=' . preg_replace('/\s+|&/', '%', $detail['product_name']) ."' . target='_blank'>" . $detail['product_name'] . "</td></a>";
                                  echo "<td>" . $detail['ord_quantity'] . "</td>";
                                  echo "<td>" . $detail['product_price']    . "</td>";
                                  echo "<td><a href='order.php?do=ordernum&order_number=" . $detail['ord_number'] . "'>" . $detail['ord_number']   . "</a></td>";
                                  echo "<td>" . $detail['timestamp']    . "</td>";
                               echo "</tr>";
                           }
                          ?>

                  </table>

                  <div class="back-dashboard">
                    <a class="btn btn-danger" href="index.php"><?php echo $lang['Back Home']; ?></a>
                  </div>
              </div>
          <?php } else { ?>
            <div class="container">
              <div class="my_orders_empty text-center">
                <i class="fas fa-cart-arrow-down"></i>
                <div class="message_empty alert alert-danger"><i class='fas fa-exclamation-circle' style='padding: 10px;'></i><?php echo $lang['Not found any orders for you, but you can shopping now and make many orders']; ?></div>
                <div class="btn btn-danger"><a href="index.php"><?php echo $lang['Shopping']; ?></a></div>
              </div>
           </div>
        <?php  } ?>
          </div>
          </div>

  <?php } else {
              header('Location: index.php');
              exit();
            }

   } elseif ($do == 'ordernum') {
    if (isset($_GET['order_number']) && is_numeric($_GET['order_number'])) {
      // get order number Information
      $stmt = $con->prepare("SELECT * FROM orders WHERE ord_number = {$_GET['order_number']}");
      $stmt->execute();
      $order_info = $stmt->fetch(); ?>

      <nav class="navbar navbar-expand-lg navbar-light bg-light">
       <div class="container header-con">
        <a class="navbar-brand" href="index.php"><span>M</span></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      </div>
      </nav>

      <div class="container-fluid">
         <h2 class="order_num_head text-center"><?php echo $lang['all infrmation about'] . '<span class="red"> ' . $_GET['order_number'] . ' </span>' . $lang['order number']; ?></h2>
         <div class="table-responsive">
             <table class="main-table text-center table table-bordered">
                 <tr>
                     <td><?php echo $lang['product']; ?></td>
                     <td><?php echo $lang['quantity']; ?></td>
                     <td><?php echo $lang['Product Price']; ?></td>
                     <td><?php echo $lang['Total price']; ?></td>
                     <td><?php echo $lang['Shipping to']; ?></td>
                     <td><?php echo $lang['payment method']; ?></td>
                     <td><?php echo $lang['date_order']; ?></td>
                 </tr>

                 <?php

                 // get info order_details
                 $stmt_2 = $con->prepare("SELECT * FROM orderdetails WHERE ord_number = ?");
                 $stmt_2->execute(array($_GET['order_number']));
                 $order_details = $stmt_2->fetch(); ?>

                 <tr>
                  <td><a href='product.php?productid=<?php echo $order_details['productID'] . '&productname=' . preg_replace('/\s+|&/', '%', $order_details['product_name']); ?>' target='_blank'><?php echo $order_details['product_name']; ?></a></td>
                  <td><?php echo $order_details['ord_quantity']; ?></td>
                  <td><?php echo $order_details['product_price']; ?></td>
                  <td><?php echo $order_info['order_total_price']; ?></td>
                  <td><?php echo $order_info['address_1'] . '<br>' . $order_info['address_2'] . '<br>' . $order_info['city']; ?></td>
                  <td><?php echo $order_info['payment_method']; ?></td>
                  <td><?php echo $order_details['timestamp']; ?></td>
                 </tr>
             </table>
         </div>

         <div class="back-dashboard">
          <a class="btn btn-danger" href="index.php"><?php echo $lang['Back Home']; ?></a>
         </div>
      </div><!-- .container -->


<?php

  } else {
    header('Location: index.php');
    exit();
  } 
  
} else {
    header('Location: index.php');
    exit();
} 

    include $temp . 'footer.php';
    ob_end_flush();
?>
