<?php

    /*
    ======================================================
    == Manage customers Page
    ======================================================
    */

    ob_start();
    $pageTitle = 'Customers Manage';
    include 'init.php';

          if (isset($_SESSION['adm_name'])) {

             $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

              // Start Manage Page

              if ($do == 'Manage') { // Manage Page

                  // Select All customers
                   $sql = $con->prepare("SELECT * FROM customers ORDER BY cus_id DESC");
                   $sql->execute();
                   $rows = $sql->fetchAll(); ?>

                      <h2 class="text-center global-h1"><?php echo $lang['customers']; ?></h2>
                        <div class="container-fluid customers ">
                          <div class="stat st-items">
                              <i class="fas fa-users dash_i"></i>
                              <div class="info">
                                 <?php echo $lang['Total customers']; ?>
                                  <span>
                                      <a href="customers.php"><?php echo countItems('cus_id', 'customers') ?></a>
                                  </span>
                               </div>
                           </div>
                           <?php if (! empty($rows)) { ?>
                            <div class="table-responsive">
                                <table class="main-table text-center manage_member table table-bordered">
                                    <tr>
                                        <td>#ID</td>
                                        <td><?php echo $lang['customer_name']; ?></td>
                                        <td><?php echo $lang['Email']; ?></td>
                                        <td><?php echo $lang['customer_phone']; ?></td>
                                        <td><?php echo $lang['customer_adress']; ?></td>
                                        <td><?php echo $lang['city']; ?></td>
                                        <td><?php echo $lang['Register Date']; ?></td>
                                        <td><?php echo $lang['Control']; ?></td>
                                    </tr>

                                    <?php

                                         foreach($rows as $row) {

                                             echo "<tr>";
                                                echo "<td>" . $row['cus_id'] . "</td>";
                                                echo "<td>" . $row['cus_f_name']   . ' ' . $row['cus_l_name'] .  "</td>";
                                                echo "<td>" . $row['cus_mail']   . "</td>";
                                                echo "<td>" . $row['cus_phone']  . "</td>";
                                                echo "<td>" . $row['cus_address_1']  . "</td>";
                                                echo "<td>" . $row['cus_city']          . "</td>";
                                                echo "<td>" . $row['cus_enter_date'] . "</td>";
                                                echo "<td>
                                                    <a href='customers.php?do=Edit&customerid= "  . $row['cus_id'] . "' class='btn btn-success'><i class='fa fa-edit'></i>  " . $lang['Edit'] . "</a>
                                                    <a href='customers.php?do=Delete&customerid= " . $row['cus_id'] . "' class='btn btn-danger confirm'><i class='fas fa-times'></i>  " . $lang['Delete'] . "</a>";
                                               echo "</td>";
                                             echo "</tr>";
                                         } ?>
                                </table>
                                 <hr />
                                 <div class="news">
                                     <div class="head-new">
                                       <i class="fas fa-tachometer-alt"></i>
                                       <h3>Quick report last 24 hours</h3>
                                     </div>
                                     <marquee behavior="scroll" scrollamount="1" direction="left" width="100%">
                                       <?php
                                                      
                                         $stmt= $con->prepare("SELECT * FROM customers WHERE TIMESTAMPDIFF(HOUR, cus_enter_date, NOW()) < 24; ORDER BY cus_id ASC");
                                         $stmt->execute();
                                         $customers = $stmt->fetchAll(); 
                                         if (!empty($customers)) {
                                          foreach($customers as $customer) {
                                            echo "A new customer was added with the name: <b><span class='red'>" . $customer['cus_f_name'] . "</span></b> - ";  
                                          } 
                                         } else {
                                           echo "No any new customers added in last 24 Hours! - ";
                                         } 
                                         
                                         // second statment to get any customer edit in last 24 hours
                                         $sql = $con->prepare("SELECT * FROM customers WHERE TIMESTAMPDIFF(HOUR, update_date, NOW()) < 24; ORDER BY cus_id ASC");
                                         $sql->execute();
                                         $customersEdit = $sql->fetchAll();
                                         
                                        if (!empty($customersEdit)) {
                                          foreach($customersEdit as $customerE) {
                                            echo "New customer is edit with the name: <b><span class='red'>" . $customerE['cus_f_name'] . "</span></b> at:" . $customerE['update_date'] . " - ";  
                                          }
                                        } else {
                                            echo "Not found any edits customers last 24 hours! - ";
                                        } ?>
                                     </marquee>
                                   </div>
                    <?php } else {

                                echo '<div class="container container-special">';
                                echo "<div class='alert alert-danger'><b><i class='fas fa-exclamation-circle' style='padding: 10px;''></i> " . $lang['Sorry Not Found Any Record To Show'] . "</b></div>";
                            } ?>
                        </div>


  <?php } elseif ($do == 'Edit') {  // Edit Page


                    // Check If Get Request customerid Is Numeric & Get The Integer Value It
                   $customerid = isset($_GET['customerid']) && is_numeric($_GET['customerid']) ? intval($_GET['customerid']) : 0;

                    // Select All Data Depend On This ID
                    $sql = $con->prepare("SELECT * FROM customers WHERE cus_id = ? LIMIT 1");

                    // Execute Query
                    $sql->execute(array($customerid));

                    // Fetch The Data
                    $row = $sql->fetch();

                    // The Row Count
                    $count = $sql->rowCount();

                    // If There Is Such ID Show The Form
                  if($count > 0) { ?>

                        <h1 class="text-center global-h1"><?php echo $lang['Edit customer']; ?></h1>

                        <div class="container container-special form-content">
                            <form class="form-horizontal" action="?do=Update" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="customerid" value="<?php echo $customerid ?>" />
                                <!-- Start customer f name Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['customer_f_name']; ?><h5>
                                          <input type="text" name="cus_f_name" class="form-control" value="<?php echo isset($_POST["customer_f_name"]) ? $_POST["customer_f_name"] : ''; ?>" autocomplete= "off" required='required' placeholder="<?php echo $lang['customer_f_name']; ?>" value="<?php echo $row['cus_f_name']; ?>" />
                                        </div>
                                    </div>
                                <!-- End customer name f Field -->

                                <!-- Start customer l name Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['customer_l_name']; ?><h5>
                                          <input type="text" name="cus_l_name" class="form-control" value="<?php echo isset($_POST["cus_l_name"]) ? $_POST["cus_l_name"] : ''; ?>" autocomplete= "off" required='required' placeholder="<?php echo $lang['customer_l_name']; ?>" value="<?php echo $row['cus_l_name']; ?>" />
                                        </div>
                                    </div>
                                <!-- End customer l name Field -->

                                <!-- Start customer mail Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['Email']; ?><h5>
                                          <input type="email" name="customer_mail" class="form-control" value="<?php echo isset($_POST["customer_mail"]) ? $_POST["customer_mail"] : ''; ?>" autocomplete= "off" required='required' placeholder="<?php echo $lang['Email']; ?>" value="<?php echo $row['cus_mail']; ?>" />
                                        </div>
                                    </div>
                                <!-- End customer mail Field -->

                                <!-- Start  Password Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['password']; ?><h5>
                                          <input type="hidden" name="oldPassword" value="<?php echo $row['cus_password']; ?>">
                                          <input type="Password" name="newPassword" class="password form-control" value="<?php echo isset($_POST["newPassword"]) ? $_POST["ordering"] : ''; ?>" autocomplete="new-password" required='required' placeholder="<?php echo $lang['password']; ?>" value="<?php echo $row['cus_password']; ?>" />
                                          <i class="show-pass fa fa-eye fa-2x"></i>
                                        </div>
                                    </div>
                                <!-- End  Password Field -->

                                <!-- Start phone Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['customer_phone']; ?><h5>
                                          <input type="text" name="phone" class="phone form-control" value="<?php echo isset($_POST["phone"]) ? $_POST["phone"] : ''; ?>" autocomplete="off" required='required' placeholder="<?php echo $lang['customer_phone']; ?>" value="<?php echo $row['cus_phone']; ?>" />
                                        </div>
                                    </div>
                                <!-- End phone Field -->

                                <!-- Start customer adress 1 Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['cus_address_1']; ?><h5>
                                          <input type="text" name="adress_1" class="adress form-control" value="<?php echo isset($_POST["adress_1"]) ? $_POST["adress_1"] : ''; ?>" autocomplete="off" required='required' placeholder="<?php echo $lang['cus_address_1']; ?>" value="<?php echo $row['cus_address_1']; ?>" />
                                        </div>
                                    </div>
                                <!-- End customer adress 1 Field -->

                                <!-- Start customer adress 2 Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['cus_address_2']; ?><h5>
                                          <input type="text" name="adress_2" class="adress form-control" value="<?php echo isset($_POST["adress_2"]) ? $_POST["adress_2"] : ''; ?>" autocomplete="off" required='required' placeholder="<?php echo $lang['cus_address_2']; ?>" value="<?php echo $row['cus_address_2']; ?>" />
                                        </div>
                                    </div>
                                <!-- End customer adress 2 Field -->

                                <!-- Start city Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['city']; ?><h5>
                                          <input type="text" name="city" class="city form-control" value="<?php echo isset($_POST["city"]) ? $_POST["city"] : ''; ?>" autocomplete="off" required='required' placeholder="<?php echo $lang['city']; ?>"  value="<?php echo $row['cus_city']; ?>" />
                                        </div>
                                    </div>
                                <!-- End city Field -->

                                <!-- Start cus_country Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['cus_country']; ?><h5>
                                            <select class="form-control" name="cus_country" required>
                                              <option value="0"><?php echo $lang['cus_country']; ?></option>
                                                <?php

                                                 $allCountries = getAllFrom("*", "countries", "", "", "coun_id");
                                                     foreach ($allCountries as $country) {
                                                       echo "<option value='" . $country['coun_id'] . "'";
                                                         if ($row['cus_country_id'] == $country['coun_id'] ) { echo "selected"; }
                                                        echo ">" . $country['coun_name'] . "</option>";
                                                     }
                                                  ?>
                                            </select>
                                        </div>
                                    </div>
                                <!-- End cus_country Field -->

                                <!-- Start cus_stat Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['cus_stat']; ?><h5>
                                          <input type="text" name="cus_stat" class="cus_stat form-control" value="<?php echo isset($_POST["cus_stat"]) ? $_POST["cus_stat"] : ''; ?>" autocomplete="off" required='required' placeholder="<?php echo $lang['cus_stat']; ?>" value="<?php echo $row['cus_state']; ?>" />
                                        </div>
                                    </div>
                                <!-- End cus_stat Field -->

                                <!-- Start cus_postal code Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['cus_postal_code']; ?><h5>
                                          <input type="text" name="cus_postal_code" class="cus_postal_code form-control" value="<?php echo isset($_POST["cus_postal_code"]) ? $_POST["cus_postal_code"] : ''; ?>" autocomplete="off" required='required' placeholder="<?php echo $lang['cus_postal_code']; ?>" value="<?php echo $row['cus_postalCode']; ?>" />
                                        </div>
                                    </div>
                                <!-- End cus_postal code Field -->

                                <!-- Start  submit Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <input type="submit" value="<?php echo $lang['Add New customer']; ?>" class="btn btn-danger btn-block" />
                                        </div>
                                    </div>
                                <!-- End  submit Field -->

                            </form>
                        </div>


          <?php

                // If There Is No Such ID Show Error Message

                } else {

                      echo "<div class='container container-special'>";
                        $theMsg  =  "<div class='alert alert-danger'>There is No Such Id</div>";
                        redirectHome($theMsg);
                      echo "</div>";
                }

        } elseif ($do == 'Update') {

            echo "<h1 class='text-center global-h1'>" . $lang['Update customer'] . "</h1>";
            echo "<div class='container container-special'>";

            if($_SERVER['REQUEST_METHOD'] == 'POST') {

                // Get Variable From The Form
                $id              = $_POST['customerid'];
                $customer_f_name = $_POST['cus_f_name'];
                $customer_L_name = $_POST['cus_l_name'];
                $customer_mail   = $_POST['customer_mail'];
                $adress_1        = $_POST['adress_1'];
                $adress_2        = $_POST['adress_2'];
                $country         = $_POST['cus_country'];
                $phone           = $_POST['phone'];
                $city            = $_POST['city'];
                $stat            = $_POST['cus_stat'];
                $postalC         = $_POST['cus_postal_code'];

                // Password Trick
                $pass = '';

                if (empty($_POST['newPassword'])) {
                    $pass = $_POST['oldPassword'];
                } else {
                    $pass = sha1($_POST['newPassword']);
                }

                // Validate The Form
                $formErrors = array();
                if (empty($customer_f_name || $customer_L_name || $customer_mail || $adress_1 || $adress_2 || $country || $phone || $city || $stat || $postalC || $c_credit || $c_credit_type || $exp_date)) { $formErrors [] = 'Sorry, this input is empty.'; }
                if (strlen($customer_f_name || $customer_L_name) < 4) { $formErrors[] = 'customer name Can\'t Be Less Than<strong> 4 </strong> Characters'; }
                if (strlen($customer_f_name || $customer_L_name) > 20) { $formErrors[] = 'customer name Can\'t Be More Than <strong> 20 </strong>Characters'; }
                if (!is_numeric($phone || $postalC) || strlen($phone) < 11) { $formErrors[] = 'This Input Not Valid'; }

                // Check If There's No Proceed The Update Operation
                if (empty($formErrors)) {

                    $stmt = $con->prepare("SELECT
                                                  *
                                            FROM
                                                  customers
                                            WHERE
                                                	cus_mail = ?
                                            AND
                                                  cus_id != ?");
                        $stmt->execute(array($customer_mail, $id));
                        $count = $stmt->rowCount();


                    if ($count == 1) {
                        echo "<div class='alert alert-danger'>" . $lang['Sorry This Mail IS Exit'] . "</div>";
                        redirectHome($theMsg, 'back');

                    } else {
                     // Update The Database With This Information
                      $sql = $con->prepare("UPDATE customers SET cus_f_name = ?, cus_l_name = ?, cus_address_1 = ?, cus_address_2 = ?, cus_city = ?, cus_state = ?, cus_postalCode = ?, cus_country = ?, cus_phone = ?, cus_mail = ?, cus_password = ?, update_date = now() WHERE cus_id = ? LIMIT 1");
                      $sql->execute(array($customer_f_name, $customer_L_name, $adress_1, $adress_2, $city, $stat, $postalC, $country, $phone, $customer_mail, $pass, $id ));

                         // Echo Success Message

                        $theMsg ="<div class='alert alert-success text-center'>" . $sql->rowCount() . $lang['Record Update'] . "</div>";
                        redirectHome($theMsg, 'back');
                    }

                  } else {
                    // Loop Into Errors Array And Echo It
                    foreach($formErrors as $error) { echo '<div class="alert alert-danger">' . $error . '</div>'; }
                    $theMsg = '';
                    redirectHome($theMsg, 'back');
                  }

            } else {
                 // Echo Danger Message

                $theMsg ="<div class='alert alert-danger'>" . $lang['Sorry You Can\'t Browse This Page'] . "</div>";
                redirectHome($theMsg, 'back');
            }

       echo "</div>";

        } elseif ($do == 'Delete') { // Delet Member Page

                  echo "<h1 class='text-center global-h1'>" . $lang['Delete customer'] . "</h1>";

                  echo "<div class='container container-special'>";

                        // Check If Get Request Userid Is Numeric & Get The Integer Value It
                       $customerid = isset($_GET['customerid']) && is_numeric($_GET['customerid']) ? intval($_GET['customerid']) : 0;

                        // Select All Data Depend On This ID
                        $check = checkItem('cus_id', 'customers', $customerid);

                        // If There Is Such ID Show The Form
                      if($check > 0) {

                          $sql = $con->prepare('DELETE FROM customers WHERE cus_id = :zcustomer');
                          $sql->bindparam(":zcustomer", $customerid);    // ربطهم ببعض
                          $sql-> execute();
                          $theMsg = "<div class='alert alert-success text-center'>" . $sql->rowCount() . $lang['Delete Record'] . '</div>';
                           redirectHome($theMsg, 'back');

                      } else {
                          $theMsg = '<div class="alert alert-danger">' . $lang['This Id Not Exist'] . '</div>';
                          redirectHome($theMsg, 'back');
                      }

                  echo "</div>";

             }

      echo "</div>";


        include $tpl . 'footer-copyright.php';
        include $tpl . 'footer.php';
    } else {
        header('Location: index.php');
        exit();
    }

    ob_end_flush();
    ?>