<?php
    ob_start(); // Output Buffering start
    $pageTitle =  'Dashboard admin';  // for main title page
    include 'init.php';
    $pageTitle = isset($_GET['lang']) ? $lang['Dashboard admin'] : '';

     if (isset($_SESSION['adm_name'])) {
        /* Start Dashboard Page */
        $numCustomers = 5;  // Number Of The Latest Customers
        $latestCustomers  = getLatest("*", "customers", "cus_id", $numCustomers); // Latest Members Array

        $numAdmins = 5;  // Number Of The Latest Admins
        $latestAdmins  = getLatest("*", "admins", "adm_id", $numAdmins); // Latest Admins Array

        $numSellars = 5;  // Number Of The Latest sellars
        $latestSellars  = getLatest("*", "sellars", "sellar_id", $numSellars); // Latest Admins Array

        $numProducts = 5;  // Number Of The Latest Items
        $latestProducts = getLatest("*", "products", "p_id", $numProducts);  // Latest Items Array

        $numCountries = 5;  // Number Of The Latest countries
        $latestCountries = getLatest("*", "countries", "coun_id", $numCountries);  // Latest Countries Array

        ?>

      <div class="dashboard-page">
        <div class="home-stats">
          <div class="container text-center">
             <h2 class="page-heading"><?php echo $lang['Dashboard']; ?></h2>
              <div class="row">
                  <div class="col-sm-12 col-md-3 col-lg-3">
                     <div class="stat st-members">
                        <i class="fa fa-users dash_i"></i>
                         <div class="info">
                           <?php echo $lang['Total Customers']; ?>
                             <span>
                                 <a href="customers.php"><?php echo countItems('cus_id', 'customers') ?></a>
                             </span>
                         </div>
                      </div>
                   </div>

                  <div class="col-sm-12 col-md-3 col-lg-3">
                     <div class="stat st-pending">
                         <i class="fa fa-user-plus dash_i"></i>
                         <div class="info">
                            <?php echo $lang['Pending Sellars']; ?>
                             <span>
                                 <a href='sellars.php?do=Manage&page=Pending'><?php echo checkItem('Reg_status', 'sellars', 0 ) ?></a>
                             </span>
                         </div>
                      </div>
                   </div>

                  <div class="col-sm-12 col-md-3 col-lg-3">
                     <div class="stat st-items">
                         <i class="fa fa-tag dash_i"></i>
                         <div class="info">
                            <?php echo $lang['Total Products']; ?>
                             <span>
                                 <a href="products.php"><?php echo countItems('p_id', 'products') ?></a>
                             </span>
                          </div>
                      </div>
                   </div>

                  <div class="col-sm-12 col-md-3 col-lg-3">
                     <div class="stat categories-count">
                         <div class="info">
                          <?php echo $lang['Total Categories']; ?>
                             <span>
                                <a href="categories.php"><?php echo countItems('c_id', 'categories') ?></a>
                             </span>
                         </div>
                      </div>
                   </div>

                   <div class="col-sm-12 col-md-6 col-lg-6">
                      <div class="stat st-order_d">
                        <i class="fab fa-first-order-alt dash_i"></i>
                          <div class="info">
                            <?php echo $lang['Total orders']; ?>
                              <span>
                                  <a href="orders.php"><?php echo countItems('ord_detail_id', 'orderdetails') ?></a>
                              </span>
                          </div>
                       </div>
                    </div>

                    <div class="col-sm-12 col-md-6 col-lg-6">
                       <div class="stat st-orders">
                         <i class="fas fa-question dash_i"></i>
                           <div class="info">
                             <?php echo $lang['Total orders in baskets']; ?>
                               <span>
                                   <a href="orders.php"><?php echo countItems('p_c_id', 'store_cart_item') ?></a>
                               </span>
                           </div>
                        </div>
                     </div>
                 </div>
             </div>
           </div>

           <div class="container">
             <h2 class="page-heading"><?php echo $lang['At a glance']; ?></h2>
             <div class="first-block">
               <div class="row">
                 <div class="col-sm-6 text-center">
                   <div class="panel panel-card">
                    <div class="panel-heading">
                     <i class="fa fa-tag"></i> <?php echo $lang['Latest'] .' ' . $numSellars . ' ' . $lang['Sellars']; ?>
                      <span class="toggle-info pull-right">
                          <i class="fa fa-plus fa-lg"></i>
                       </span>
                    </div>
                    <div class="panel-body">
                      <div class="table-responsive">
                           <?php if (! empty($latestSellars)) { ?>
                            <table class="table latest-product">
                              <thead class="bg-light">
                                <tr class="border-1">
                                  <th class="border-0"><?php echo $lang['Sellar Name']; ?></th>
                                  <th class="border-0"><?php echo $lang['Status']; ?></th>
                                  <th class="border-0"><?php echo $lang['date register']; ?></th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php foreach ($latestSellars as $sellar) {
                                       echo '<tr>';
                                        echo '<td>' . $sellar['sellar_name'] . '</td>';
                                        echo '<td>';
                                         if ($sellar['Reg_status'] == 0) {
                                            echo "Pending";
                                         } else {
                                           echo 'Accept';
                                         }
                                        echo '</td>';
                                        echo '<td>' . $sellar['date_register'] . '</td>';
                                       echo '</tr>';
                                     }
                                   ?>
                                 </tbody>
                                </table>
                              <?php } else { ?>
                                      <div class='alert alert-danger'><i class='fas fa-exclamation-circle' style='padding: 10px;'></i><?php echo $lang['Sorry Not Found Any Sellars']; ?></div>
                              <?php } ?>
                               </div>
                            </div>
                       </div>
                  </div>

                 <div class="col-sm-6 text-center">
                    <div class="panel panel-card">
                         <div class="panel-heading">
                           <i class="fa fa-tag"></i> <?php echo $lang['Latest'] . ' ' . $numProducts . ' ' . $lang['products']; ?>
                            <span class="toggle-info pull-right">
                                <i class="fa fa-plus fa-lg"></i>
                             </span>
                         </div>
                         <div class="panel-body">
                           <div class="table-responsive">
                             <?php if (! empty($latestProducts)) { ?>
                              <table class="table latest-product">
                                <thead class="bg-light">
                                  <tr class="border-1">
                                    <th class="border-0"><?php echo $lang['Product Name']; ?></th>
                                    <th class="border-0"><?php echo $lang['Price']; ?></th>
                                    <th class="border-0"><?php echo $lang['Discount']; ?></th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php foreach ($latestProducts as $product) {
                                         echo '<tr>';
                                          echo '<td>' . $product['p_name'] . '</td>';
                                          echo '<td>' . '$' . $product['price'] . '</td>';
                                          echo '<td>' . '$' . $product['discount'] . '</td>';
                                         echo '</tr>';
                                       } ?>
                                </tbody>
                              </table>
                    <?php } else { ?>
                             <div class='alert alert-danger'><i class='fas fa-exclamation-circle' style='padding: 10px;'></i><?php echo $lang['Sorry Not Found Any Products']; ?> </div>
                    <?php } ?>
                           </div>
                        </div>
                    </div>
               </div>
             </div><!-- #first-block -->

               <div class="second-block">
                 <div class="row">
                   <div class="col-sm-6 text-center">
                      <div class="panel panel-card">
                           <div class="panel-heading">
                             <i class="fa fa-users"></i> <?php echo $lang['Latest'] . ' ' . $numCustomers . ' ' . $lang['Registerd Customers']; ?>
                              <span class="toggle-info pull-right">
                                  <i class="fa fa-plus fa-lg"></i>
                               </span>
                           </div>
                           <div class="panel-body">
                             <div class="table-responsive">
                                <?php if (! empty($latestCustomers)) { ?>
                                <table class="table latest-product">
                                  <thead class="bg-light">
                                    <tr class="border-1">
                                      <th class="border-0"><?php echo $lang['Username']; ?></th>
                                        <th class="border-0"><?php echo $lang['Email']; ?></th>
                                      <th class="border-0"><?php echo $lang['Date']; ?></th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php foreach ($latestCustomers as $customer) {
                                           echo '<tr>';
                                            echo '<td>' . $customer['cus_f_name'] . ' ' . $customer['cus_l_name'] . '</td>';
                                            echo '<td>' . $customer['cus_mail'] . '</td>';
                                            echo '<td>' . $customer['cus_enter_date'] . '</td>';
                                           echo '</tr>';
                                         }
                                       ?>
                                  </tbody>
                                </table>
                              <?php } else { ?>
                                    <div class='alert alert-danger'><i class='fas fa-exclamation-circle' style='padding: 10px;'></i><?php echo $lang['Sorry Not Found Any Customers']; ?></div>
                              <?php } ?>
                             </div>
                          </div>
                      </div>
                  </div>
                     
                 <div class="col-sm-6 text-center">
                    <div class="panel panel-card">
                         <div class="panel-heading">
                           <i class="fa fa-users"></i> <?php echo $lang['Latest'] . ' ' . $numCountries . ' ' . $lang['countries']; ?>
                            <span class="toggle-info pull-right">
                                <i class="fa fa-plus fa-lg"></i>
                             </span>
                         </div>
                         <div class="panel-body">
                           <div class="table-responsive">
                              <?php if (! empty($latestCountries)) { ?>
                              <table class="table latest-product">
                                <thead class="bg-light">
                                  <tr class="border-1">
                                    <th class="border-0"><?php echo $lang['coun_id']; ?></th>
                                    <th class="border-0"><?php echo $lang['coun_name']; ?></th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php foreach ($latestCountries as $country) {
                                         echo '<tr>';
                                          echo '<td>' . $country['coun_id'] . '</td>';
                                          echo '<td>' . $country['coun_name'] . '</td>';
                                         echo '</tr>';
                                       }
                                     ?>
                                </tbody>
                              </table>
                            <?php } else { ?>
                                  <div class='alert alert-danger'><i class='fas fa-exclamation-circle' style='padding: 10px;'></i><?php echo $lang['Sorry Not Found Any Customers']; ?></div>
                            <?php } ?>
                           </div>
                        </div>
                    </div>
                 </div>

                 <div class="col-sm-6 text-center">
                    <div class="panel panel-card">
                         <div class="panel-heading">
                           <i class="fa fa-tag"></i> 
                             <?php echo $lang['Products need approval']; ?>
                            <span class="toggle-info pull-right">
                                <i class="fa fa-plus fa-lg"></i>
                             </span>
                         </div>
                         <div class="panel-body">
                             <?php 
                                $stmt = $con->prepare("SELECT * FROM products WHERE Approve = 0");
                                $stmt->execute();
                                $proApp = $stmt->fetchAll();
                             ?>
                           <div class="table-responsive">
                              <?php if (! empty($proApp)) { ?>
                              <table class="table latest-product">
                                <thead class="bg-light">
                                  <tr class="border-1">
                                    <th class="border-0"><?php echo $lang['product']; ?></th>
                                    <th class="border-0"><?php echo $lang['Approve Now']; ?></th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php foreach ($proApp as $product) {
                                         echo '<tr>';
                                          echo '<td>' . $product['p_name'] . '</td>';
                                          echo "<td><a href='products.php?do=Approve&productid= " . $product['p_id'] . "'' class='btn btn-info activate'><i class='fa fa-check'></i>  " . $lang['Approve'] . "</a></td>";
                                         echo '</tr>';
                                       } ?>
                                </tbody>
                              </table>
                            <?php } else { ?>
                                  <div class='alert alert-danger'><i class='fas fa-exclamation-circle' style='padding: 10px;'></i><?php echo $lang['All Products is approved!']; ?></div>
                            <?php } ?>
                           </div>
                        </div>
                    </div>
               </div>

                  <div class="col-sm-6 text-center">
                    <div class="panel panel-card">
                         <div class="panel-heading">
                           <i class="fa fa-users"></i> <?php echo $lang['Admins Need Active']; ?>
                            <span class="toggle-info pull-right">
                                <i class="fa fa-plus fa-lg"></i>
                             </span>
                         </div>
                             <?php 
                                $stmt = $con->prepare("SELECT * FROM admins WHERE adm_status = 0");
                                $stmt->execute();
                                $admApp = $stmt->fetchAll();
                             ?>
                         <div class="panel-body">
                           <div class="table-responsive">
                              <?php if (! empty($admApp)) { ?>
                              <table class="table latest-product">
                                <thead class="bg-light">
                                  <tr class="border-1">
                                    <th class="border-0"><?php echo $lang['admin_name']; ?></th>
                                    <th class="border-0"><?php echo $lang['Active now']; ?></th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php foreach ($admApp as $admin) {
                                         echo '<tr>';
                                          echo '<td>' . $admin['adm_full_name'] . '</td>';
                                          echo "<td><a href='admins.php?do=Activate&admid= " . $admin['adm_id'] . "'' class='btn btn-info activate'><i class='fa fa-check'></i> Activate  </a></td>";
                                         echo '</tr>';
                                       } ?>
                                </tbody>
                              </table>
                            <?php } else { ?>
                                  <div class='alert alert-danger'><i class='fas fa-exclamation-circle' style='padding: 10px;'></i><?php echo $lang['All Admins Activated!']; ?></div>
                            <?php } ?>
                           </div>
                        </div>
                    </div>
               </div>

                <div class="col-sm-6 text-center">
                    <div class="panel panel-card">
                         <div class="panel-heading">
                           <i class="fa fa-users"></i> <?php echo $lang['seller need active']; ?>
                            <span class="toggle-info pull-right">
                                <i class="fa fa-plus fa-lg"></i>
                             </span>
                         </div>
                         <?php 
                            $stmt = $con->prepare("SELECT * FROM sellars WHERE Reg_status = 0");
                            $stmt->execute();
                            $sellApp = $stmt->fetchAll();
                         ?>
                         <div class="panel-body">
                           <div class="table-responsive">
                              <?php if (! empty($sellApp)) { ?>
                              <table class="table latest-product">
                                <thead class="bg-light">
                                  <tr class="border-1">
                                    <th class="border-0"><?php echo $lang['sellar_name']; ?></th>
                                    <th class="border-0"><?php echo $lang['Active now']; ?></th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php foreach ($sellApp as $sellar) {
                                         echo '<tr>';
                                          echo '<td>' . $sellar['sellar_name'] . '</td>';
                                          echo "<td><a href='sellars.php?do=Activate&sellarid= " . $sellar['sellar_id'] . "'' class='btn btn-info activate'><i class='fa fa-check'></i> " . $lang['Activate'] . '</a></td>';
                                         echo '</tr>';
                                       } ?>
                                </tbody>
                              </table>
                            <?php } else { ?>
                                  <div class='alert alert-danger'><i class='fas fa-exclamation-circle' style='padding: 10px;'></i><?php echo $lang['All Sellars Activated!']; ?></div>
                            <?php } ?>
                           </div>
                        </div>
                    </div>
               </div>

                  <div class="col-sm-6 text-center">
                    <div class="panel panel-card">
                         <div class="panel-heading">
                           <i class="fas fa-question"></i> <?php echo $lang['order need to transfer to seller']; ?>
                            <span class="toggle-info pull-right">
                                <i class="fa fa-plus fa-lg"></i>
                             </span>
                         </div>
                         <?php 
                            $stmt = $con->prepare("SELECT * FROM orderdetails WHERE transfar_to_sellar = 0");
                            $stmt->execute();
                            $sellTranApp = $stmt->fetchAll();
                         ?>
                         <div class="panel-body">
                           <div class="table-responsive">
                              <?php if (! empty($sellTranApp)) { ?>
                              <table class="table latest-product">
                                <thead class="bg-light">
                                  <tr class="border-1">
                                    <th class="border-0"><?php echo $lang['Order number']; ?></th>
                                    <th class="border-0"><?php echo $lang['product']; ?></th>
                                    <th class="border-0"><?php echo $lang['Order date']; ?></th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php foreach ($sellTranApp as $order) {
                                         echo '<tr>';
                                          echo '<td>' . $order['ord_number'] . '</td>';
                                          echo '<td>' . $order['product_name'] . '</td>';
                                           echo '<td>'. $order['timestamp'] . '</td>';
                                         echo '</tr>';
                                       } ?>
                                </tbody>
                              </table>
                            <?php } else { ?>
                                  <div class='alert alert-danger'><i class='fas fa-exclamation-circle' style='padding: 10px;'></i><?php echo $lang['Sorry Not Found Any Customers']; ?></div>
                            <?php } ?>
                           </div>
                        </div>
                    </div>
                  </div>
                 </div>
               </div>
          </div><!-- #container -->
       </div>
    </div>
<?php
    /* End Dashboard Page */
    include $tpl . 'footer-copyright.php';
    include $tpl . 'footer.php';
 } else {
     header('Location: index.php');
     exit();
 }

 ob_end_flush();
?>
