<?php

/*
===============================
   orders Page
===============================
*/

   ob_start(); // OutPut Buffering Start
   $pageTitle = 'Manage Orders';
   include 'init.php';
if (isset($_SESSION['adm_name'])) {

        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

        if ($do == 'Manage') {

                  // Select All orders
                  $sql = $con->prepare("SELECT * FROM orderdetails ORDER BY ord_detail_id DESC");
                  $sql->execute();
                  $orders = $sql->fetchAll(); ?>

                      <h1 class="text-center global-h1"><?php echo $lang['Manage orders']; ?></h1>
                        <div class="container-fluid orders">
                          <div class="stat st-items">
                            <i class="fab fa-first-order-alt dash_i"></i>
                              <div class="info">
                                 <?php echo $lang['Total orders']; ?>
                                  <span>
                                      <a href="orders.php"><?php echo countItems('ord_detail_id', 'orderdetails') ?></a>
                                  </span>
                               </div>
                           </div>
                     <?php  if (! empty($orders)) { ?>
                            <div class="table-responsive">
                                <table class="main-table text-center table table-bordered">
                                    <tr>
                                        <td><?php echo $lang['order number']; ?></td>
                                        <td><?php echo $lang['Product Name']; ?></td>
                                        <td><?php echo $lang['quantity']; ?></td>
                                        <td><?php echo $lang['Price']; ?></td>
                                        <td><?php echo $lang['Order Date']; ?></td>
                                        <td><?php echo $lang['Control']; ?></td>
                                    </tr>

                                    <?php

                                         foreach($orders as $order) {

                                             echo "<tr>";
                                                echo "<td>" . $order['ord_number']           . "</td>";
                                                echo "<td>" . $order['product_name']         . "</td>";
                                                echo "<td>" . $order['ord_quantity']         . "</td>";
                                                echo "<td>" . '$' . $order['product_price']  . "</td>";
                                                echo "<td>" . $order['timestamp']            . "</td>";
                                                echo "<td>
                                                    <a href='orders.php?do=Delete&orderid=" . $order['ord_detail_id'] . "'' class='btn btn-danger confirm'><i class='fas fa-times'></i>  " . $lang['Delete'] . "</a>";
                                               echo "</td>";
                                             echo "</tr>";

                                         }

                                        ?>

                                </table>
                                <hr />
                                 <div class="news">
                                     <div class="head-new">
                                       <i class="fas fa-tachometer-alt"></i>
                                       <h3>Quick report last 24 hours</h3>
                                     </div>
                                     <marquee behavior="scroll" scrollamount="1" direction="left" width="100%">
                                       <?php
                                                      
                                         $stmt= $con->prepare("SELECT * FROM orderdetails WHERE TIMESTAMPDIFF(HOUR, timestamp, NOW()) < 24; ORDER BY ord_detail_id ASC");
                                         $stmt->execute();
                                         $orders = $stmt->fetchAll(); 
                                         if (!empty($orders)) {
                                          foreach($orders as $order) {
                                            echo "A new order was added with the number: <b><span class='red'>" . $order['ord_number'] . "</span></b> - ";  
                                          } 
                                         } else {
                                           echo "No any new orders added in last 24 Hours! - ";
                                         } ?>
                                     </marquee>
                                   </div>
                            </div>
                          <?php } else { ?>
                                   <div class="container container-special">
                                      <div class='alert alert-danger' style='margin-top: 60px;'><b><i class='fas fa-exclamation-circle' style="padding: 10px;"></i> <?php echo $lang['Sorry Not Found Any orders.']; ?></b></div>
                                </div>
                        <?php } ?>
                    </div>

    <?php } elseif ($do == 'Delete') {

                echo "<h1 class='text-center global-h1'>" . $lang['Delete order'] . "</h1>";
                  echo "<div class='container'>";

                        // Check If Get Request Itemid Is Numeric & Get The Integer Value It
                       $orderid = isset($_GET['orderid']) && is_numeric($_GET['orderid']) ? intval($_GET['orderid']) : 0;

                        // Select All Data Depend On This ID
                        $check = checkItem('ord_detail_id', 'orderdetails', $orderid);

                        // If There Is Such ID Show The Form
                      if($check > 0) {

                          $sql = $con->prepare('DELETE FROM orderdetails WHERE ord_detail_id = :zid');
                          $sql->bindparam(":zid", $orderid);    // ربطهم ببعض
                          $sql-> execute();
                          $theMsg = "<div class='alert alert-success text-center'>" . $sql->rowCount() . 'Delete Record</div>';
                          redirectHome($theMsg, 'back');

                      } else {
                          $theMsg = '<div class="alert alert-danger text-center">' . $lang['This Id Not Exist'] . '</div>';
                          redirectHome($theMsg);
                      }

                  echo "</div>";


        } else {
          header('Location: dashboard.php');
          exit();
        }

        include $tpl . 'footer-copyright.php';
        include $tpl . 'footer.php';

    } else {
        header('Location: index.php');
        exit();
    }

   ob_end_flush();
?>