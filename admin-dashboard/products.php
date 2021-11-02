<?php

/*
===============================
   products Page
===============================
*/

   ob_start(); // OutPut Buffering Start
   $pageTitle = 'products';
   include 'init.php';
if (isset($_SESSION['adm_name'])) {

        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

        if ($do == 'Manage') {

                  // Select All Users Expect Admin
                   $sql = $con->prepare("SELECT
                                              products. *,
                                              categories.c_name,
                                              sellars.sellar_name,
                                              countries.coun_name
                                        FROM
                                              products
                                        INNER JOIN
                                              categories
                                        ON    categories.c_id = products.categoryID
                                        INNER JOIN
                                              sellars
                                        ON
                                              sellars.sellar_id  = products.sellar_id
                                        INNER JOIN
                                              countries
                                        ON
                                              countries.coun_id  = products.p_country_id
                                        ORDER BY p_id DESC");
                   $sql->execute();
                   $products = $sql->fetchAll();
       ?>

                      <h1 class="text-center global-h1"><?php echo $lang['Manage products']; ?></h1>
                        <div class="container-fluid products">
                          <div class="row">
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
                             <div class="stat st-items">
                                 <i class="fa fa-tag dash_i"></i>
                                 <div class="info">
                                    <?php echo $lang['Products Activated']; ?>
                                     <span>
                                       <?php
                                         $sql = $con->prepare("SELECT COUNT('p_id') From products WHERE Approve = 1");
                                         $sql->execute();
                                         $count = $sql->fetchColumn();
                                       ?>
                                         <a href="products.php"><?php echo $count; ?></a>
                                     </span>
                                  </div>
                              </div>
                            </div>

                            <div class="col-sm-12 col-md-3 col-lg-3">
                              <div class="stat st-items">
                                  <i class="fa fa-tag dash_i"></i>
                                  <div class="info">
                                     <?php echo $lang['Pending Products']; ?>
                                      <span>
                                        <?php
                                          $sql = $con->prepare("SELECT COUNT('p_id') From products WHERE Approve = 0");
                                          $sql->execute();
                                          $count = $sql->fetchColumn();
                                        ?>
                                          <a href="products.php"><?php echo $count; ?></a>
                                      </span>
                                   </div>
                               </div>
                             </div>

                            <div class="col-sm-12 col-md-3 col-lg-3">
                              <div class="stat st-items">
                                  <i class="fa fa-tag dash_i"></i>
                                  <div class="info">
                                     OSP <!-- out of stock products -->
                                      <span>
                                        <?php
                                          $sql = $con->prepare("SELECT COUNT('p_id') From products WHERE available_product_num = 0");
                                          $sql->execute();
                                          $count = $sql->fetchColumn();
                                        ?>
                                          <a href="products.php"><?php echo $count; ?></a>
                                      </span>
                                   </div>
                               </div>
                             </div>

                         </div>
                  <?php if (! empty($products)) { ?>
                            <div class="table-responsive">
                                <table class="main-table text-center table table-bordered">
                                    <tr>
                                        <td>#ID</td>
                                        <td><?php echo $lang['Product Image']; ?></td>
                                        <td><?php echo $lang['Product Name']; ?></td>
                                        <td><?php echo $lang['available_product_num']; ?></td>
                                        <td><?php echo $lang['Country made']; ?></td>
                                        <td><?php echo $lang['Price']; ?></td>
                                        <td><?php echo $lang['Adding Data']; ?></td>
                                        <td><?php echo $lang['Category']; ?></td>
                                        <td><?php echo $lang['Sellar name']; ?></td>
                                        <td><?php echo $lang['Control']; ?></td>
                                    </tr>

                                    <?php

                                         foreach($products as $product) {

                                             echo "<tr>";
                                                echo "<td>" . $product['p_id']    . "</td>";
                                                echo "<td>";
                                                if (empty($product['p_picture'])) {
                                                    echo "Sorry, Not Found Image";
                                                } else {
                                                    echo "<img style='width: 100px; height: 100px' src='upload/products/" . $product['p_picture'] . "' alt='' />";
                                                }

                                                echo "</td>";
                                                echo "<td>" . $product['p_name']          . "</td>";
                                                echo "<td>" . $product['available_product_num'] . "</td>";
                                                echo "<td>" . $product['coun_name']   . "</td>";
                                                echo "<td>" . $product['price']   . "</td>";
                                                echo "<td>" . $product['date_insert']      . "</td>";
                                                echo "<td>" . $product['c_name']      . "</td>";
                                                echo "<td>" . $product['sellar_name']      . "</td>";
                                                echo "<td>
                                                    <a href='products.php?do=Edit&productid= " . $product['p_id'] . "' class='btn btn-success'><i class='fa fa-edit'></i> " . $lang['Edit'] . "</a>
                                                    <a href='products.php?do=Delete&productid= " . $product['p_id'] . "'' class='btn btn-danger confirm'><i class='fas fa-times'></i>  " . $lang['Delete'] . "</a>";
                                                    if ($product['Approve'] == 0) {
                                                        echo "<a href='products.php?do=Approve&productid= " . $product['p_id'] . "'' class='btn btn-info activate'><i class='fa fa-check'></i>  " . $lang['Approve'] . "</a>";
                                                    }
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
                                         // first statment to get any products added in last 24 hours
                                         $stmt= $con->prepare("SELECT products. *, sellars.sellar_name FROM products INNER JOIN sellars ON sellars.sellar_id  = products.sellar_id WHERE TIMESTAMPDIFF(HOUR, date_insert, NOW()) < 24; ORDER BY p_id ASC");
                                         $stmt->execute();
                                         $products = $stmt->fetchAll(); 
                                         if (!empty($products)) {
                                          foreach($products as $product) {
                                            echo "A new product was added with the name: <b><span class='red'>" . $product['p_name'] . "</span></b> by sellar: <span class='red'><b>" . $product['sellar_name'] . '</span></b> - ';  
                                          } 
                                         } else {
                                           echo "No Any Actions in last 24 Hours - ";
                                         } 
                                                 
                                         // second statment to get any products approved in last 24 hours
                                         $sql = $con->prepare("SELECT * FROM products WHERE Approve = 1 AND TIMESTAMPDIFF(HOUR, approve_date, NOW()) < 24; ORDER BY p_id ASC");
                                         $sql->execute();
                                         $productsApp = $sql->fetchAll();
                                         
                                        if (!empty($productsApp)) {
                                          foreach($productsApp as $product_a) {
                                            echo "New product is approved with the name: <b><span class='red'>" . $product_a['p_name'] . "</span></b> at:" . $product_a['approve_date'] . " today - ";  
                                          }
                                        } else {
                                            echo "Not found any approved products last 24 hours! - ";
                                        }
                                                 
                                         // Thirs statment to get any products edit in last 24 hours
                                         $sql = $con->prepare("SELECT * FROM products WHERE TIMESTAMPDIFF(HOUR, edit_date, NOW()) < 24; ORDER BY p_id ASC");
                                         $sql->execute();
                                         $productsEdit = $sql->fetchAll();
                                         
                                        if (!empty($productsEdit)) {
                                          foreach($productsEdit as $product_e) {
                                            echo "New product is edit with the name: <b><span class='red'>" . $product_e['p_name'] . "</span></b> at:" . $product_e['edit_date'] . " - ";  
                                          }
                                        } else {
                                            echo "Not found any edits products last 24 hours! - ";
                                        }
                                         ?>
                                     </marquee>
                                 </div>
                              <?php } else { ?>
                                       <div class="container container-special">
                                          <div class='alert alert-danger' style='margin-top: 60px;'><b><i class='fas fa-exclamation-circle' style="padding: 10px;"></i> <?php echo $lang['Sorry Not Found Any Record To Show, but you can add now.']; ?></b></div>

                                        <div class='btn btn-danger'>
                                          <a href='products.php?do=Add'>
                                            <i class='fa fa-plus'></i> <?php echo $lang['Add New product']; ?>
                                          </a>
                                      </div>
                                    </div>
                            <?php } ?>
                            </div>

                           <div class='btn btn-danger'><a href='products.php?do=Add'><i class="fa fa-plus"></i> <?php echo $lang["Add New product"]; ?></a></div>
                      </div>


    <?php    } elseif ($do == 'Add') { ?>

                       <h1 class="text-center global-h1"><?php echo $lang['Add New Products']; ?></h1>
                        <div class="container container-special form-content">
                            <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
                                <!-- Start  Name Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['Name Of The product']; ?></h5>
                                          <input
                                                 type="text"
                                                 name="name"
                                                 class="form-control"
                                                 autocomplete= "off"
                                                 value="<?php echo isset($_POST["name"]) ? $_POST["name"] : ''; ?>"
                                                 required='required'
                                                 placeholder="<?php echo $lang['Name Of The product']; ?>" />
                                        </div>
                                      </div>
                                <!-- End  Name Field -->

                                <!-- Start  Description Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['Description Of The product']; ?></h5>
                                          <input
                                                 type="text"
                                                 name="description"
                                                 class="form-control"
                                                 autocomplete= "off"
                                                 value="<?php echo isset($_POST["description"]) ? $_POST["description"] : ''; ?>"
                                                 placeholder="<?php echo $lang['Description Of The product']; ?>" />
                                        </div>
                                     </div>
                                <!-- End  Description Field -->

                                <!-- Start  Price Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['Price Of The product']; ?></h5>
                                          <input
                                                 type="text"
                                                 name="price"
                                                 class="form-control"
                                                 autocomplete= "off"
                                                 value="<?php echo isset($_POST["price"]) ? $_POST["price"] : ''; ?>"
                                                 required='required'
                                                 placeholder="<?php echo $lang['Price Of The product']; ?>" />
                                        </div>
                                   </div>
                                <!-- End  Price Field -->

                                <!-- Start  discount Field -->
                                <div class="form-group form-group-lg">
                                    <div class="col-12">
                                      <h5><?php echo $lang['product discount']; ?></h5>
                                        <input
                                          type="number"
                                          name="discount"
                                          class="form-control"
                                          autocomplete= "off"
                                          value="<?php echo isset($_POST["discount"]) ? $_POST["discount"] : ''; ?>"
                                          required='required'
                                          placeholder="<?php echo $lang['Discount']; ?>" />
                                    </div>
                                </div>
                                <!-- End  discount Field -->

                                <!-- Start  available_product_num Field -->
                                <div class="form-group form-group-lg">
                                    <div class="col-12">
                                      <h5><?php echo $lang['available_product_num']; ?></h5>
                                        <input
                                          type="number"
                                          name="available_product_num"
                                          class="form-control"
                                          autocomplete= "off"
                                          value="<?php echo isset($_POST["available_product_num"]) ? $_POST["available_product_num"] : ''; ?>"
                                          required='required'
                                          placeholder="<?php echo $lang['available_product_num']; ?>" />
                                    </div>
                                </div>
                                <!-- End  available_product_num Field -->

                                <!-- Start Product Image -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['Product Image']; ?></h5>
                                          <input
                                                 type="file"
                                                 name="product_img"
                                                 class="form-control"
                                                 autocomplete= "off"
                                                 required='required'
                                                 placeholder="<?php echo $lang['Product Image']; ?>" />
                                        </div>
                                   </div>
                                <!-- End Product Image -->

                                <!-- Start country made filed -->
                                <div class="form-group form-group-lg">
                                    <div class="col-12">
                                      <h5><?php echo $lang['Country made']; ?></h5>
                                        <select class="form-control" name="country" required>
                                          <option value="0"><?php echo $lang['Country made']; ?></option>
                                            <?php
                                            $allCountries = getAllFrom("*", "countries", "", "", "coun_id");

                                                 foreach ($allCountries as $country) {
                                                     echo "<option value='" . $country['coun_id'] . "'>" . $country['coun_name'] . "</option>";
                                                 }

                                              ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- End country made filed -->

                                <!-- Start product city Field -->
                                <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['product city']; ?></h5>
                                            <select class="form-control" name="city">
                                                <option value="Jahra">Jahra</option>
                                                <option value="Fahaheel">Fahaheel</option>
                                                <option value="Hawly">Hawly</option>
                                                <option value="Salmiya">Salmiya</option>
                                                <option value="Sabah-Al-Salem">Sabah Al-Salem</option>
                                                <option value="Almankf">Almankf</option>
                                                <option value="Ahmadi">Ahmadi</option>
                                                <option value="Mahboula">Mahboula</option>
                                                <option value="Al-Farwaniyah">Al Farwaniyah</option>
                                                <option value="Alkhiran">Alkhiran</option>
                                                <option value="Muraqab">Muraqab</option>
                                                <option value="Alsalibia">Alsalibia</option>
                                                <option value="Khaitan">Khaitan</option>
                                                <option value="Alearidia">Alearidia</option>
                                                <option value="Abha">Abha</option>
                                                <option value="Ad-Dilam">Ad-Dilam</option>
                                                <option value="Al-Abwa">Al-Abwa</option>
                                                <option value="Al-Artaweeiyah">Al Artaweeiyah</option>
                                                <option value="Al-Bukayriyah">Al Bukayriyah</option>
                                                <option value="Badr">Badr</option>
                                                <option value="Baljurashi">Baljurashi</option>
                                                <option value="Bisha">Bisha</option>
                                                <option value="Bareg">Bareg</option>
                                                <option value="Buraydah">Buraydah</option>
                                                <option value="Dammam">Dammam</option>
                                                <option value="Dhahran">Dhahran</option>
                                                <option value="Gurayat">Gurayat</option>
                                                <option value="Hotat Bani Tamim">Dahaban</option>
                                                <option value="Al-Hareeq">Al-Hareeq</option>
                                                <option value="Hotat-Bani-Tamim">Hotat Bani Tamim</option>
                                                <option value="Hofuf">Hofuf</option>
                                                <option value="Hafr-Al-Batin">Hafr Al-Batin</option>
                                                <option value="Al Riyadh">Riyadh</option>
                                                <option value="Makkah">Makkah</option>
                                                <option value="jadah">jadah</option>
                                                <option value="almadinat-almunawara">Almadinat almunawara</option>
                                                <option value="Tabuk">Tabuk</option>
                                                <option value="alttayif">Alttayif</option>
                                                <option value="alkhabar">Alkhabar</option>
                                                <option value="Jubail">Jubail</option>
                                                <option value="hayil">Hayil</option>
                                                <option value="albaha">Albaha</option>
                                                <option value="Cairo">Cairo</option>
                                                <option value="Alexandria">Alexandria</option>
                                                <option value="Suez">Suez</option>
                                                <option value="Mansoura">Mansoura</option>
                                                <option value="almahalah-alkubraa">Almahalah alkubraa</option>
                                                <option value="Hurghada">Hurghada</option>
                                            </select>
                                        </div>
                                   </div>
                                <!-- End product city Field -->

                                <!-- Start  Status Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['product status']; ?></h5>
                                            <select class="form-control" name="status">
                                                <option value="not"><?php echo $lang['Status']; ?></option>
                                                <option value="New"><?php echo $lang['New']; ?></option>
                                                <option value="Like-New"><?php echo $lang['Like New']; ?></option>
                                                <option value="Used"><?php echo $lang['Used']; ?></option>
                                                <option value="Old"><?php echo $lang['Old']; ?></option>
                                            </select>
                                        </div>
                                   </div>
                                <!-- End  Status Field -->

                                <!-- Start  sellar Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['Sellar']; ?></h5>
                                            <select class="form-control" name="sellar">
                                                <option value="not"><?php echo $lang['Sellar']; ?>r</option>
                                                  <?php
                                                  $allSellars = getAllFrom("*", "sellars", "", "", "sellar_id");

                                                       foreach ($allSellars as $sellar) {
                                                           echo "<option value='" . $sellar['sellar_id'] . "'>" . $sellar['sellar_name'] . "</option>";
                                                       }

                                                    ?>
                                            </select>
                                        </div>
                                   </div>
                                <!-- End  sellar Field -->

                                <!-- Start  Category Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['product category']; ?></h5>
                                            <select class="form-control" name="category">
                                                <option value="not"><?php echo $lang['Category']; ?></option>
                                                  <?php
                                                  $allCats = getAllFrom("*", "categories", "", "", "c_id");
                                                       foreach ($allCats as $cat) {
                                                           echo "<option value='" . $cat['c_id'] . "'>" . $cat['c_name'] . "</option>";
                                                       }
                                                    ?>
                                            </select>
                                        </div>
                                   </div>
                                <!-- End  Category Field -->

                                <!-- Start brand Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['product brand']; ?></h5>
                                            <select class="form-control" name="brand" required>
                                                <option value="0"><?php echo $lang['brand']; ?></option>
                                                  <?php
                                                  $allCats = getAllFrom("*", "brands", "", "", "brand_id");
                                                       foreach ($allCats as $cat) {
                                                           echo "<option value='" . $cat['brand_id'] . "'>" . $cat['brand_name'] . "</option>";
                                                       }
                                                    ?>
                                            </select>
                                        </div>
                                   </div>
                                <!-- End brand Field -->

                                 <!-- Start Places of distribution Field -->
                            <div class="form-group form-group-lg distribution">
                              <div class="col-12">
                                <h5><?php echo $lang['Places of distribution']; ?></h5>
                                  <p>
                                    <input class="checkbox-distribution" id="Jahra" type="checkbox" name="distribution[]" value="Jahra">
                                    <label for="Jahra"> Jahra </label>
                                  </p>
                                  <p>
                                    <input class="checkbox-distribution" id="Fahaheel" type="checkbox" name="distribution[]" value="Fahaheel">
                                    <label for="Fahaheel">Fahaheel</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Hawly" type="checkbox" name="distribution[]" value="Hawly">
                                   <label for="Hawly">Hawly</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Salmiya" type="checkbox" name="distribution[]" value="Salmiya">
                                   <label for="Salmiya">Salmiya</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Sabah" type="checkbox" name="distribution[]" value="Sabah-Al-Salem">
                                   <label for="Sabah">Sabah Al Salem</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Almankf" type="checkbox" name="distribution[]" value="Almankf">
                                   <label for="Almankf">Almankf</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="" type="checkbox" name="distribution[]" value="Ahmadi">
                                   <label for="Ahmadi">Ahmadi</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="" type="checkbox" name="distribution[]" value="Mahboula">
                                   <label for="Mahboula">Mahboula</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Farwaniyah" type="checkbox" name="distribution[]" value="Al-Farwaniyah">
                                   <label for="Farwaniyah">Al-Farwaniyah</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Alkhiran" type="checkbox" name="distribution[]" value="Alkhiran">
                                   <label for="Alkhiran">Alkhiran</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Muraqab" type="checkbox" name="distribution[]" value="Muraqab">
                                   <label for="Muraqab">Muraqab</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Alsalibia" type="checkbox" name="distribution[]" value="Alsalibia">
                                   <label for="Alsalibia">Alsalibia</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Khaitan" type="checkbox" name="distribution[]" value="Khaitan">
                                   <label for="Khaitan">Khaitan</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Alearidia" type="checkbox" name="distribution[]" value="Alearidia">
                                   <label for="Alearidia">Alearidia</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Abha" type="checkbox" name="distribution[]" value="Abha">
                                   <label for="Abha">Abha</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Dilam" type="checkbox" name="distribution[]" value="Ad-Dilam">
                                   <label for="Dilam">Ad Dilam</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Abwa" type="checkbox" name="distribution[]" value="Al-Abwa">
                                   <label for="Abwa">Al Abwa</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Artaweeiyah" type="checkbox" name="distribution[]" value="Al-Artaweeiyah">
                                   <label for="Artaweeiyah">Al-Artaweeiyah</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Bukayriyah" type="checkbox" name="distribution[]" value="Al-Bukayriyah">
                                   <label for="Bukayriyah">Al-Bukayriyah</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Badr" type="checkbox" name="distribution[]" value="Badr">
                                   <label for="Badr">Badr</label>
                                  </p>    
                                  <p>                 
                                   <input class="checkbox-distribution" id="Baljurashi" type="checkbox" name="distribution[]" value="Baljurashi">
                                   <label for="Baljurashi">Baljurashi</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Bisha" type="checkbox" name="distribution[]" value="Bisha">
                                   <label for="Bisha">Bisha</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Bareg" type="checkbox" name="distribution[]" value="Bareg">
                                   <label for="Bareg">Bareg</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Buraydah" type="checkbox" name="distribution[]" value="Buraydah">
                                   <label for="Buraydah">Buraydah</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Dammam" type="checkbox" name="distribution[]" value="Dammam">
                                   <label for="Dammam">Dammam</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Dhahran" type="checkbox" name="distribution[]" value="Dhahran">
                                   <label for="Dhahran">Dhahran</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Gurayat" type="checkbox" name="distribution[]" value="Gurayat">
                                   <label for="Gurayat">Gurayat</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Dahaban" type="checkbox" name="distribution[]" value="Dahaban">
                                   <label for="Dahaban">Dahaban</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Hareeq" type="checkbox" name="distribution[]" value="Al-Hareeq">
                                   <label for="Hareeq">Al-Hareeq</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Hotat" type="checkbox" name="distribution[]" value="Hotat-Bani-Tamim">
                                   <label for="Hotat">Hotat-Tamim</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Hofuf" type="checkbox" name="distribution[]" value="Hofuf">
                                   <label for="Hofuf">Hofuf</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Hafr" type="checkbox" name="distribution[]" value="Hafr-Al-Batin">
                                   <label for="Hafr">Hafr-Al-Batin</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Riyadh" type="checkbox" name="distribution[]" value="Al Riyadh">
                                   <label for="Riyadh">Al-Riyadh</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Makkah" type="checkbox" name="distribution[]" value="Makkah">
                                   <label for="Makkah">Makkah</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Almadinat" type="checkbox" name="distribution[]" value="almadinat-almunawara">
                                   <label for="Almadinat">Almadinat</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="jadah" type="checkbox" name="distribution[]" value="jadah">
                                   <label for="jadah">jadah</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Tabuk" type="checkbox" name="distribution[]" value="Tabuk">
                                   <label for="Tabuk">Tabuk</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Alttayif" type="checkbox" name="distribution[]" value="alttayif">
                                   <label for="Alttayif">Alttayif</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Alkhabar" type="checkbox" name="distribution[]" value="alkhabar">
                                   <label for="Alkhabar">Alkhabar</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Jubail" type="checkbox" name="distribution[]" value="Jubail">
                                   <label for="Jubail">Jubail</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Hayil" type="checkbox" name="distribution[]" value="hayil">
                                   <label for="Hayil">Hayil</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Albaha" type="checkbox" name="distribution[]" value="albaha">
                                   <label for="Albaha">Albaha</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Cairo" type="checkbox" name="distribution[]" value="Cairo">
                                   <label for="Cairo">Cairo</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Alexandria" type="checkbox" name="distribution[]" value="Alexandria">
                                   <label for="Alexandria">Alexandria</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Suez" type="checkbox" name="distribution[]" value="Suez">
                                   <label for="Suez">Suez</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Mansoura" type="checkbox" name="distribution[]" value="Mansoura">
                                   <label for="Mansoura">Mansoura</label>
                                  </p>
                                  <p> 
                                   <input class="checkbox-distribution" id="almahalah" type="checkbox" name="distribution[]" value="almahalah-alkubraa">
                                   <label for="almahalah">Almahalah</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Hurghada" type="checkbox" name="distribution[]" value="Hurghada">
                                   <label for="Hurghada">Hurghada</label>
                                  </p>
                              </div>
                            </div>
                            <!-- End Places of distribution Field -->

                                <!-- Start  submit Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <input
                                                 type="submit"
                                                 value="<?php echo $lang['Add New product']; ?>"
                                                 class="btn btn-success btn-block" />
                                        </div>
                                    </div>
                                <!-- End  submit Field -->
                            </form>
                        </div>


    <?php


        } elseif ($do == 'Insert') {

            if($_SERVER['REQUEST_METHOD'] == 'POST') {

               echo "<h1 class='text-center global-h1'>" . $lang['Insert Product'] . "</h1>";
               echo "<div class='container'>";

                // Get Variable From The Form
                $name                  = test_input($_POST['name']);
                $desc                  = test_input($_POST['description']);
                $price                 = test_input($_POST['price']);
                $discount              = test_input($_POST['discount']);
                $country               = test_input($_POST['country']);
                $city                  = test_input($_POST['city']);
                $status                = test_input($_POST['status']);
                $sellar                = test_input($_POST['sellar']);
                $category              = test_input($_POST['category']);
                $brand                 = test_input($_POST['brand']);
                $available_product_num = test_input($_POST['available_product_num']);

                $Places_distribution   = $_POST['distribution'];

                $place="";  
                foreach($Places_distribution as $distribution){  
                      $place .= $distribution . ",";
                }


                $productImg     = $_FILES['product_img'];
                $productImgName = $_FILES['product_img']['name'];
                $productImgSize = $_FILES['product_img']['size'];
                $productImgTmp  = $_FILES['product_img']['tmp_name'];
                $productImgType = $_FILES['product_img']['type'];

                // List Of Allowed File Typed To Upload
                $productImgAllowedExtention = array("jpeg", "jpg", "png", "gif");

                // Get productImg Extention
                $productImgEtention = strtolower(end(explode('.', $productImgName)));

                // Validate The Form
                $formErrors = array();
                if (empty($name)) { $formErrors[] = 'Name Can\'t Be <strong> Empty</strong>';  }
                if (empty($city)) { $formErrors[] = 'City Can\'t Be <strong> Empty</strong>';  }
                if (! empty($productImgName) && ! in_array($productImgEtention, $productImgAllowedExtention)) { $formErrors[] = 'This Extention Is Not <strong> Allowed </strong>'; }
                if (empty($productImgName)) { $formErrors[] = 'Image Product is <strong> Required </strong>'; }
                if ($productImgSize > 4194304) { $formErrors[] = 'This Image Can\'t Larger Than <strong> 4MB </strong>'; }
                if(empty($available_product_num)) { $formErrors[] = 'Available product number Product is <strong> Required </strong>';  }
                if (empty($desc)) { $formErrors[] = 'Description Can\'t Be <strong> Empty</strong>'; }
                if (empty($price)) { $formErrors[] = 'Price Can\'t Be <strong> Empty</strong>'; }
                if (empty($country)) { $formErrors[] = 'Country Can\'t Be <strong> Empty</strong>'; }
                if (empty($Places_distribution)) { $formErrors[] = 'Places distribution Can\'t Be <strong> Empty</strong>'; }
                if ($status == 'not') { $formErrors[] = 'You Must Choose <strong>Status</strong>'; }
                if ($sellar == 'not') { $formErrors[] = 'You Must Choose <strong>sellars</strong>'; }
                if ($category == 'not') { $formErrors[] = 'You Must Choose <strong>Category</strong>'; }
                if ($brand == 0) { $formErrors[] = 'You Must Choose <strong>brand</strong>'; }
                
                // Check If There's No Proceed The Update Operation
                if (empty($formErrors)) {
                  $productImg = rand(0, 1000000) . '_' . $productImgName;
                  move_uploaded_file($productImgTmp, "upload\products\\" . $productImg);
                    
                  // Check If User Exist In Database
                  $check = checkItem("p_name", "products", $name);

                    if ($check == 1) {
                        $theMsg =  "<div class='alert alert-danger'><i class='fas fa-exclamation-circle' style='padding: 10px;'></i> Sorry This Name Is Exist</div>";
                        redirectHome($theMsg, 'back');
                    } else {
                         // Insert UserInfo In DB
                        $sql = $con->prepare("INSERT INTO
                                            products(p_name, p_description, price, discount, available_product_num, p_country_id, city_product, p_picture, status, date_insert, brand_ID, categoryID, sellar_id, Places_distribution)
                                            VALUES(:zname, :zdesc, :zprice, :zprice_discount, :ava_pro_num, :zcountry, :city, :zproductImg, :zstatus, now(), :brand, :zcategory, :zsellar, :zdistribution)");
                        $sql->execute(array (

                            'zname'            => $name,
                            'zdesc'            => $desc,
                            'zprice'           => $price,
                            'zprice_discount'  => $discount,
                            'ava_pro_num'      => $available_product_num,
                            'zcountry'         => $country,
                            'city'             => $city,
                            'zproductImg'      => $productImg,
                            'zstatus'          => $status,
                            'zcategory'        => $category,
                            'brand'            => $brand,
                            'zsellar'          => $sellar,
                            'zdistribution'    => $place
                        ));

                              echo "<div class='container'>";
                                 // Echo Success Message
                               $theMsg = "<div class='alert alert-success text-center'>" . $sql->rowCount() . ' Record Inserted</div>';
                               redirectHome($theMsg, 'back');
                              echo '</div>';
                          exit();
                       }

                } else {
                   // Loop Into Errors Array And Echo It
                    foreach($formErrors as $error) { echo '<div class="alert alert-danger text-left container_special"><i class="fas fa-exclamation-circle" style="padding: 10px;"></i>' . $error . '</div>'; }

                    $theMsg = '';
                    redirectHome($theMsg, 'back');
                }


            } else {
                $theMsg =  '<div class="alert alert-danger">Sorry you Can\'t Enter To This Page</div>';
                redirectHome($theMsg);
            }


     echo "</div>";


        } elseif ($do == 'Edit') {


                    // Check If Get Request itemid Is Numeric & Get The Integer Value It
                   $productid = isset($_GET['productid']) && is_numeric($_GET['productid']) ? intval($_GET['productid']) : 0;

                    // Select All Data Depend On This ID
                    $sql = $con->prepare("SELECT * FROM products WHERE p_id = ?");

                    // Execute Query
                    $sql->execute(array($productid));

                    // Fetch The Data
                    $product = $sql->fetch();

                    // The Row Count
                    $count = $sql->rowCount();

                    $Places_distributions = explode(",", $product['Places_distribution']);

                    // If There Is Such ID Show The Form
                    if($count > 0) { ?>

                        <h1 class="text-center global-h1"><?php echo $lang['Edit products']; ?></h1>
                        <div class="container container-special form-content">
                            <form class="form-horizontal" action="?do=Update" method="POST">
                            <input type="hidden" name="productid" value="<?php echo $productid ?>" />

                                <!-- Start  Name Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['Product Name']; ?></h5>
                                          <input
                                             type="text"
                                             name="name"
                                             class="form-control"
                                             autocomplete= "off"
                                             required='required'
                                             placeholder="<?php echo $lang['Name Of The product']; ?>"
                                             value="<?php echo $product['p_name'] ?>"/>
                                        </div>
                                      </div>
                                <!-- End  Name Field -->

                                <!-- Start  Description Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['Description Of The product']; ?></h5>
                                          <input
                                             type="text"
                                             name="description"
                                             class="form-control"
                                             autocomplete= "off"
                                             placeholder="<?php echo $lang['Description Of The product']; ?>"
                                             value="<?php echo $product['p_description'] ?>"/>
                                        </div>
                                     </div>
                                <!-- End  Description Field -->

                                <!-- Start  Price Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['Price Of The product']; ?></h5>
                                          <input
                                           type="text"
                                           name="price"
                                           class="form-control"
                                           autocomplete= "off"
                                           required='required'
                                           placeholder="<?php echo $lang['Price Of The product']; ?>"
                                           value="<?php echo $product['price'] ?>" />
                                        </div>
                                   </div>
                                <!-- End  Price Field -->
                                <!-- Start  discount Field -->
                                <div class="form-group form-group-lg">
                                    <div class="col-12">
                                      <h5><?php echo $lang['Discount']; ?></h5>
                                        <input
                                                type="number"
                                                name="discount"
                                                class="form-control"
                                                autocomplete= "off"
                                                value="<?php echo $product['discount'] ?>"
                                                required='required'
                                                placeholder="<?php echo $lang['Discount']; ?>" />
                                    </div>
                                </div>
                                <!-- End  discount Field -->

                                <!-- Start  available_product_num Field -->
                                <div class="form-group form-group-lg">
                                    <div class="col-12">
                                      <h5><?php echo $lang['Discount']; ?></h5>
                                        <input
                                                type="number"
                                                name="available_product_num"
                                                class="form-control"
                                                autocomplete= "off"
                                                value="<?php echo $product['available_product_num'] ?>"
                                                required='required'
                                                placeholder="<?php echo $lang['available_product_num']; ?>" />
                                    </div>
                                </div>
                                <!-- End  available_product_num Field -->

                                <!-- Start Product Image -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['Product Image']; ?></h5>
                                          <input
                                                 type="file"
                                                 name="product_img"
                                                 class="form-control"
                                                 autocomplete= "off"
                                                 required='required'
                                                 value="<?php echo $product['Image'] ?>"
                                                 placeholder="<?php echo $lang['Product Image']; ?>" />
                                        </div>
                                   </div>
                                <!-- End Product Image -->

                                <!-- Start country made filed -->
                                <div class="form-group form-group-lg">
                                    <div class="col-12">
                                      <h5><?php echo $lang['Country made']; ?></h5>
                                        <select class="form-control" name="country" required>
                                          <?php
                                          $allCountries = getAllFrom("*", "countries", "", "", "coun_id");
                                               foreach ($allCountries as $country) {
                                                 echo "<option value='" . $country['coun_id'] . "'";
                                                   if ($country['coun_name'] == $country['coun_name'] ) { echo "selected"; }
                                                  echo ">" . $country['coun_name'] . "</option>";
                                               }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- End country made -->

                                <!-- Start product city Field -->
                                <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['product city']; ?></h5>
                                            <select class="form-control" name="city">
                                                <option value="Jahra" <?php $product['city_product'] == 'Jahra' ? 'selected' : '' ?>>Jahra</option>
                                                <option value="Fahaheel" <?php $product['city_product'] == 'Fahaheel' ? 'selected' : '' ?>>Fahaheel</option>
                                                <option value="Hawly" <?php $product['city_product'] == 'Hawly' ? 'selected' : '' ?>>Hawly</option>
                                                <option value="Salmiya" <?php $product['city_product'] == 'Salmiya' ? 'selected' : '' ?>>Salmiya</option>
                                                <option value="Sabah-Al-Salem" <?php $product['city_product'] == 'Sabah-Al-Salem' ? 'selected' : '' ?>>Sabah Al-Salem</option>
                                                <option value="Almankf" <?php $product['city_product'] == 'Almankf' ? 'selected' : '' ?>>Almankf</option>
                                                <option value="Ahmadi" <?php $product['city_product'] == 'Ahmadi' ? 'selected' : '' ?>>Ahmadi</option>
                                                <option value="Mahboula" <?php $product['city_product'] == 'Mahboula' ? 'selected' : '' ?>>Mahboula</option>
                                                <option value="Al-Farwaniyah" <?php $product['city_product'] == 'Al-Farwaniyah' ? 'selected' : '' ?>>Al Farwaniyah</option>
                                                <option value="Alkhiran" <?php $product['city_product'] == 'Alkhiran' ? 'selected' : '' ?>>Alkhiran</option>
                                                <option value="Muraqab" <?php $product['city_product'] == 'Muraqab' ? 'selected' : '' ?>>Muraqab</option>
                                                <option value="Alsalibia" <?php $product['city_product'] == 'Alsalibia' ? 'selected' : '' ?>>Alsalibia</option>
                                                <option value="Khaitan" <?php $product['city_product'] == 'Khaitan' ? 'selected' : '' ?>>Khaitan</option>
                                                <option value="Alearidia" <?php $product['city_product'] == 'Alearidia' ? 'selected' : '' ?>>Alearidia</option>
                                                <option value="Abha" <?php $product['city_product'] == 'Abha' ? 'selected' : '' ?>>Abha</option>
                                                <option value="Ad-Dilam" <?php $product['city_product'] == 'Ad-Dilam' ? 'selected' : '' ?>>Ad-Dilam</option>
                                                <option value="Al-Abwa" <?php $product['city_product'] == 'Al-Abwa' ? 'selected' : '' ?>>Al-Abwa</option>
                                                <option value="Al-Artaweeiyah" <?php $product['city_product'] == 'Al-Artaweeiyah' ? 'selected' : '' ?>>Al Artaweeiyah</option>
                                                <option value="Al-Bukayriyah" <?php $product['city_product'] == 'Al-Bukayriyah' ? 'selected' : '' ?>>Al Bukayriyah</option>
                                                <option value="Badr" <?php $product['city_product'] == 'Badr' ? 'selected' : '' ?>>Badr</option>
                                                <option value="Baljurashi <?php $product['city_product'] == 'Baljurashi' ? 'selected' : '' ?>">Baljurashi</option>
                                                <option value="Bisha" <?php $product['city_product'] == 'Bisha' ? 'selected' : '' ?>>Bisha</option>
                                                <option value="Bareg" <?php $product['city_product'] == 'Bareg' ? 'selected' : '' ?>>Bareg</option>
                                                <option value="Buraydah" <?php $product['city_product'] == 'Buraydah' ? 'selected' : '' ?>>Buraydah</option>
                                                <option value="Dammam" <?php $product['city_product'] == 'Dammam' ? 'selected' : '' ?>>Dammam</option>
                                                <option value="Dhahran" <?php $product['city_product'] == 'Dhahran' ? 'selected' : '' ?>>Dhahran</option>
                                                <option value="Gurayat" <?php $product['city_product'] == 'Gurayat' ? 'selected' : '' ?>>Gurayat</option>
                                                <option value="Hotat-Bani-Tamim" <?php $product['city_product'] == 'Hotat-Bani-Tamim' ? 'selected' : '' ?>>Dahaban</option>
                                                <option value="Al-Hareeq" <?php $product['city_product'] == 'Al-Hareeq' ? 'selected' : '' ?>>Al-Hareeq</option>
                                                <option value="Hotat-Bani-Tamim" <?php $product['city_product'] == 'Hotat-Bani-Tamim' ? 'selected' : '' ?>>Hotat Bani Tamim</option>
                                                <option value="Hofuf" <?php $product['city_product'] == 'Hofuf' ? 'selected' : '' ?>>Hofuf</option>
                                                <option value="Hafr-Al-Batin" <?php $product['city_product'] == 'Hafr-Al-Batin' ? 'selected' : '' ?>>Hafr Al-Batin</option>
                                                <option value="Riyadh" <?php $product['city_product'] == 'Riyadh' ? 'selected' : '' ?>>Riyadh</option>
                                                <option value="Makkah" <?php $product['city_product'] == 'Makkah' ? 'selected' : '' ?>>Makkah</option>
                                                <option value="jadah" <?php $product['city_product'] == 'jadah' ? 'selected' : '' ?>>jadah</option>
                                                <option value="almadinat-almunawara" <?php $product['city_product'] == 'almadinat-almunawara' ? 'selected' : '' ?>>Almadinat almunawara</option>
                                                <option value="Tabuk" <?php $product['city_product'] == 'Tabuk' ? 'selected' : '' ?>>Tabuk</option>
                                                <option value="alttayif" <?php $product['city_product'] == 'alttayif' ? 'selected' : '' ?>>Alttayif</option>
                                                <option value="alkhabar" <?php $product['city_product'] == 'alkhabar' ? 'selected' : '' ?>>Alkhabar</option>
                                                <option value="Jubail" <?php $product['city_product'] == 'Jubail' ? 'selected' : '' ?>>Jubail</option>
                                                <option value="hayil" <?php $product['city_product'] == 'hayil' ? 'selected' : '' ?>>Hayil</option>
                                                <option value="albaha" <?php $product['city_product'] == 'albaha' ? 'selected' : '' ?>>Albaha</option>
                                                <option value="Cairo" <?php $product['city_product'] == 'Cairo' ? 'selected' : '' ?>>Cairo</option>
                                                <option value="Alexandria" <?php $product['city_product'] == 'Alexandria' ? 'selected' : '' ?>>Alexandria</option>
                                                <option value="Suez" <?php $product['city_product'] == 'Suez' ? 'selected' : '' ?>>Suez</option>
                                                <option value="Mansoura" <?php $product['city_product'] == 'Mansoura' ? 'selected' : '' ?>>Mansoura</option>
                                                <option value="almahalah-alkubraa" <?php $product['city_product'] == 'almahalah-alkubraa' ? 'selected' : '' ?>>Almahalah alkubraa</option>
                                                <option value="Hurghada" <?php $product['city_product'] == 'Hurghada' ? 'selected' : '' ?>>Hurghada</option>
                                            </select>
                                        </div>
                                   </div>
                                <!-- End product city Field -->


                                <!-- Start brand Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['product brand']; ?></h5>
                                            <select class="form-control" name="brand">
                                                <option value="0"><?php echo $lang['brand']; ?></option>
                                                  <?php
                                                  $allBrands = getAllFrom("*", "brands", "", "", "brand_id");
                                                       foreach ($allBrands as $brand) {
                                                         echo "<option value='" . $brand['brand_name'] . "'";
                                                           if ($brand['brand_name'] == $brand['brand_name'] ) { echo "selected"; }
                                                          echo ">" . $brand['brand_name'] . "</option>";
                                                       }
                                                    ?>
                                            </select>
                                        </div>
                                   </div>
                                <!-- End brand Field -->

                                <!-- Start  Status Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['product status']; ?></h5>
                                            <select class="form-control" name="status">
                                                <option value="new" <?php if ($product['status']== 'new') { echo "selected"; } ?> ><?php echo $lang['New']; ?></option>
                                                <option value="like-new" <?php if ($product['status']== 'like-new') { echo "selected"; } ?> ><?php echo $lang['Like New']; ?></option>
                                                <option value="used" <?php if ($product['status']== 'used') { echo "selected"; } ?> ><?php echo $lang['Used']; ?></option>
                                                <option value="old" <?php if ($product['status']== 'old') { echo "selected"; } ?> ><?php echo $lang['Old']; ?></option>
                                            </select>
                                        </div>
                                   </div>
                                <!-- End  Status Field -->

                                <!-- Start  sellar Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['Sellar']; ?></h5>
                                            <select class="form-control" name="sellar">
                                                  <?php
                                                     $sql = $con->prepare("SELECT * FROM sellars");
                                                     $sql->execute();
                                                     $sellars = $sql->fetchAll();
                                                       foreach ($sellars as $sellar) {
                                                           echo "<option value='" . $sellar['sellar_id'] . "'";
                                                             if ($sellar['sellar_name'] == $sellar['sellar_name'] ) { echo "selected"; }
                                                            echo ">" . $sellar['sellar_name'] . "</option>";
                                                       }

                                                    ?>
                                            </select>
                                        </div>
                                   </div>
                                <!-- End  sellar Field -->

                                <!-- Start  Category Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['product category']; ?></h5>
                                            <select class="form-control" name="category">
                                                  <?php
                                                     $sql2 = $con->prepare("SELECT * FROM categories");
                                                     $sql2->execute();
                                                     $cats = $sql2->fetchAll();
                                                       foreach ($cats as $cat) {
                                                           echo "<option value='" . $cat['c_id'] . "'";
                                                           if ($product['categoryID'] == $cat['c_id']) { echo "selected"; }
                                                           echo ">" . $cat['c_name'] . "</option>";
                                                       }

                                                    ?>
                                            </select>
                                        </div>
                                   </div>
                                <!-- End  Category Field -->

                                  <!-- Start Places of distribution Field -->
                            <div class="form-group form-group-lg distribution">
                              <div class="col-12">
                                <h5><?php echo $lang['Places of distribution']; ?></h5>
                                  <p>
                                    <input class="checkbox-distribution" id="Jahra" type="checkbox" name="distribution[]" value="Jahra" <?php echo in_array('Jahra', $Places_distributions, true) ? "checked" : ''; ?>>
                                    <label for="Jahra"> Jahra </label>
                                  </p>
                                  <p>
                                    <input class="checkbox-distribution" id="Fahaheel" type="checkbox" name="distribution[]" value="Fahaheel" <?php echo in_array('Fahaheel', $Places_distributions, true) ? "checked" : ''; ?>>
                                    <label for="Fahaheel">Fahaheel</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Hawly" type="checkbox" name="distribution[]" value="Hawly" <?php echo in_array('Hawly', $Places_distributions, true) ? "checked" : ''; ?>>
                                   <label for="Hawly">Hawly</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Salmiya" type="checkbox" name="distribution[]" value="Salmiya" <?php echo in_array('Salmiya', $Places_distributions, true) ? "checked" : ''; ?>>
                                   <label for="Salmiya">Salmiya</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Sabah" type="checkbox" name="distribution[]" value="Sabah-Al-Salem" <?php echo in_array('Sabah-Al-Salem', $Places_distributions, true) ? "checked" : ''; ?>>
                                   <label for="Sabah">Sabah Al Salem</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Almankf" type="checkbox" name="distribution[]" value="Almankf" <?php echo in_array('Almankf', $Places_distributions, true) ? "checked" : ''; ?>>
                                   <label for="Almankf">Almankf</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="" type="checkbox" name="distribution[]" value="Ahmadi" <?php echo in_array('Ahmadi', $Places_distributions, true) ? "checked" : ''; ?>>
                                   <label for="Ahmadi">Ahmadi</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="" type="checkbox" name="distribution[]" value="Mahboula" <?php echo in_array('Mahboula', $Places_distributions, true) ? "checked" : ''; ?>>
                                   <label for="Mahboula">Mahboula</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Farwaniyah" type="checkbox" name="distribution[]" value="Al-Farwaniyah" <?php echo in_array('Al-Farwaniyah', $Places_distributions, true) ? "checked" : ''; ?>>
                                   <label for="Farwaniyah">Al-Farwaniyah</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Alkhiran" type="checkbox" name="distribution[]" value="Alkhiran" <?php echo in_array('Alkhiran', $Places_distributions, true) ? "checked" : ''; ?>>
                                   <label for="Alkhiran">Alkhiran</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Muraqab" type="checkbox" name="distribution[]" value="Muraqab" <?php echo in_array('Muraqab', $Places_distributions, true) ? "checked" : ''; ?>>
                                   <label for="Muraqab">Muraqab</label>
                                  </p>
                                  <p> 
                                   <input class="checkbox-distribution" id="Alsalibia" type="checkbox" name="distribution[]" value="Alsalibia" <?php echo in_array('Alsalibia', $Places_distributions, true) ? "checked" : ''; ?>>
                                   <label for="Alsalibia">Alsalibia</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Khaitan" type="checkbox" name="distribution[]" value="Khaitan" <?php echo in_array('Khaitan', $Places_distributions, true) ? "checked" : ''; ?>>
                                   <label for="Khaitan">Khaitan</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Alearidia" type="checkbox" name="distribution[]" value="Alearidia" <?php echo in_array('Alearidia', $Places_distributions, true) ? "checked" : ''; ?>>
                                   <label for="Alearidia">Alearidia</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Abha" type="checkbox" name="distribution[]" value="Abha" <?php echo in_array('Abha', $Places_distributions, true) ? "checked" : ''; ?>>
                                   <label for="Abha">Abha</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Dilam" type="checkbox" name="distribution[]" value="Ad-Dilam" <?php echo in_array('Ad-Dilam', $Places_distributions, true) ? "checked" : ''; ?>>
                                   <label for="Dilam">Ad Dilam</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Abwa" type="checkbox" name="distribution[]" value="Al-Abwa" <?php echo in_array('Al-Abwa', $Places_distributions, true) ? "checked" : ''; ?>>
                                   <label for="Abwa">Al Abwa</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Artaweeiyah" type="checkbox" name="distribution[]" value="Al-Artaweeiyah" <?php echo in_array('Al-Artaweeiyah', $Places_distributions, true) ? "checked" : ''; ?>>
                                   <label for="Artaweeiyah">Al-Artaweeiyah</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Bukayriyah" type="checkbox" name="distribution[]" value="Al-Bukayriyah" <?php echo in_array('Al-Bukayriyah', $Places_distributions, true) ? "checked" : ''; ?>>
                                   <label for="Bukayriyah">Al-Bukayriyah</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Badr" type="checkbox" name="distribution[]" value="Badr" <?php echo in_array('Badr', $Places_distributions, true) ? "checked" : ''; ?>>
                                   <label for="Badr">Badr</label>
                                  </p>    
                                  <p>                 
                                   <input class="checkbox-distribution" id="Baljurashi" type="checkbox" name="distribution[]" value="Baljurashi" <?php echo in_array('Baljurashi', $Places_distributions, true) ? "checked" : ''; ?>>
                                   <label for="Baljurashi">Baljurashi</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Bisha" type="checkbox" name="distribution[]" value="Bisha" <?php echo in_array('Bisha', $Places_distributions, true) ? "checked" : ''; ?>>
                                   <label for="Bisha">Bisha</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Bareg" type="checkbox" name="distribution[]" value="Bareg" <?php echo in_array('Bareg', $Places_distributions, true) ? "checked" : ''; ?>>
                                   <label for="Bareg">Bareg</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Buraydah" type="checkbox" name="distribution[]" value="Buraydah" <?php echo in_array('Buraydah', $Places_distributions, true) ? "checked" : ''; ?>>
                                   <label for="Buraydah">Buraydah</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Dammam" type="checkbox" name="distribution[]" value="Dammam" <?php echo in_array('Dammam', $Places_distributions, true) ? "checked" : ''; ?>>
                                   <label for="Dammam">Dammam</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Dhahran" type="checkbox" name="distribution[]" value="Dhahran" <?php echo in_array('Dhahran', $Places_distributions, true) ? "checked" : ''; ?>>
                                   <label for="Dhahran">Dhahran</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Gurayat" type="checkbox" name="distribution[]" value="Gurayat" <?php echo in_array('Gurayat', $Places_distributions, true) ? "checked" : ''; ?>>
                                   <label for="Gurayat">Gurayat</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Dahaban" type="checkbox" name="distribution[]" value="Dahaban" <?php echo in_array('Dahaban', $Places_distributions, true) ? "checked" : ''; ?>>
                                   <label for="Dahaban">Dahaban</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Hareeq" type="checkbox" name="distribution[]" value="Al-Hareeq" <?php echo in_array('Al-Hareeq', $Places_distributions, true) ? "checked" : ''; ?>>
                                   <label for="Hareeq">Al-Hareeq</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Hotat" type="checkbox" name="distribution[]" value="Hotat-Bani-Tamim" <?php echo in_array('Hotat-Bani-Tamim', $Places_distributions, true) ? "checked" : ''; ?>>
                                   <label for="Hotat">Hotat-Tamim</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Hofuf" type="checkbox" name="distribution[]" value="Hofuf" <?php echo in_array('Hofuf', $Places_distributions, true) ? "checked" : ''; ?>>
                                   <label for="Hofuf">Hofuf</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Hafr" type="checkbox" name="distribution[]" value="Hafr-Al-Batin" <?php echo in_array('Hafr-Al-Batin', $Places_distributions, true) ? "checked" : ''; ?>>
                                   <label for="Hafr">Hafr-Al-Batin</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Riyadh" type="checkbox" name="distribution[]" value="Al Riyadh" <?php echo in_array('Al Riyadh', $Places_distributions, true) ? "checked" : ''; ?>>
                                   <label for="Riyadh">Al-Riyadh</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Makkah" type="checkbox" name="distribution[]" value="Makkah" <?php echo in_array('Makkah', $Places_distributions, true) ? "checked" : ''; ?>>
                                   <label for="Makkah">Makkah</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Almadinat" type="checkbox" name="distribution[]" value="almadinat-almunawara" <?php echo in_array('almadinat-almunawara', $Places_distributions, true) ? "checked" : ''; ?>>
                                   <label for="Almadinat">Almadinat</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="jadah" type="checkbox" name="distribution[]" value="jadah" <?php echo in_array('jadah', $Places_distributions, true) ? "checked" : ''; ?>>
                                   <label for="jadah">jadah</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Tabuk" type="checkbox" name="distribution[]" value="Tabuk" <?php echo in_array('Tabuk', $Places_distributions, true) ? "checked" : ''; ?>>
                                   <label for="Tabuk">Tabuk</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Alttayif" type="checkbox" name="distribution[]" value="alttayif" <?php echo in_array('alttayif', $Places_distributions, true) ? "checked" : ''; ?>>
                                   <label for="Alttayif">Alttayif</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Alkhabar" type="checkbox" name="distribution[]" value="alkhabar" <?php echo in_array('alkhabar', $Places_distributions, true) ? "checked" : ''; ?>>
                                   <label for="Alkhabar">Alkhabar</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Jubail" type="checkbox" name="distribution[]" value="Jubail" <?php echo in_array('Jubail', $Places_distributions, true) ? "checked" : ''; ?>>
                                   <label for="Jubail">Jubail</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Hayil" type="checkbox" name="distribution[]" value="hayil" <?php echo in_array('hayil', $Places_distributions, true) ? "checked" : ''; ?>>
                                   <label for="Hayil">Hayil</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Albaha" type="checkbox" name="distribution[]" value="albaha" <?php echo in_array('albaha', $Places_distributions, true) ? "checked" : ''; ?>>
                                   <label for="Albaha">Albaha</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Cairo" type="checkbox" name="distribution[]" value="Cairo" <?php echo in_array('Cairo', $Places_distributions, true) ? "checked" : ''; ?>>
                                   <label for="Cairo">Cairo</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Alexandria" type="checkbox" name="distribution[]" value="Alexandria" <?php echo in_array('Alexandria', $Places_distributions, true) ? "checked" : ''; ?>>
                                   <label for="Alexandria">Alexandria</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Suez" type="checkbox" name="distribution[]" value="Suez" <?php echo in_array('Suez', $Places_distributions, true) ? "checked" : ''; ?>>
                                   <label for="Suez">Suez</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Mansoura" type="checkbox" name="distribution[]" value="Mansoura" <?php echo in_array('Mansoura', $Places_distributions, true) ? "checked" : ''; ?>>
                                   <label for="Mansoura">Mansoura</label>
                                  </p>
                                  <p> 
                                   <input class="checkbox-distribution" id="almahalah" type="checkbox" name="distribution[]" value="almahalah-alkubraa" <?php echo in_array('almahalah-alkubraa', $Places_distributions, true) ? "checked" : ''; ?>>
                                   <label for="almahalah">Almahalah</label>
                                  </p>
                                  <p>
                                   <input class="checkbox-distribution" id="Hurghada" type="checkbox" name="distribution[]" value="Hurghada" <?php echo in_array('Hurghada', $Places_distributions, true) ? "checked" : ''; ?>>
                                   <label for="Hurghada">Hurghada</label>
                                  </p>
                              </div>
                            </div>
                            <!-- End Places of distribution Field -->

                                <!-- Start  submit Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <input
                                                 type="submit"
                                                 value="<?php echo $lang['Save Item']; ?>"
                                                 class="btn btn-danger btn-block" />
                                        </div>
                                    </div>
                                <!-- End  submit Field -->
                            </form>
                        </div>


          <?php

                // If There Is No Such ID Show Error Message
              } else {

                      echo "<div class='container'>";
                        $theMsg ="<div class='alert alert-danger text-center'>There is No Such Id</div>";
                        redirectHome($theMsg);
                      echo "</div>";
                }


        }  elseif ($do == 'Update') {

            echo "<h1 class='text-center global-h1'>" . $lang['Update Product'] . "</h1>";
            echo "<div class='container'>";

            if($_SERVER['REQUEST_METHOD'] == 'POST') {

                // Get Variable From The Form
                $id                    = test_input($_POST['productid']);
                $name                  = test_input($_POST['name']);
                $desc                  = test_input($_POST['description']);
                $price                 = test_input($_POST['price']);
                $discount              = test_input($_POST['discount']);
                $available_product_num = test_input($_POST['available_product_num']);
                $country               = test_input($_POST['country']);
                $city                  = test_input($_POST['city']);
                $status                = test_input($_POST['status']);
                $cat                   = test_input($_POST['category']);
                $sellar                = test_input($_POST['sellar']);

                $Places_distribution   = $_POST['distribution'];

                $place="";  
                foreach($Places_distribution as $distribution){  
                      $place .= $distribution . ",";
                }

                // Validate The Form
                $formErrors = array();
                if (empty($name)) { $formErrors[] = 'Name Can\'t Be <strong> Empty</strong>';  }
                if (empty($desc)) { $formErrors[] = 'Description Can\'t Be <strong> Empty</strong>'; }
                if (empty($price)) { $formErrors[] = 'Price Can\'t Be <strong> Empty</strong>'; }
                if (empty($country)) { $formErrors[] = 'Country Can\'t Be <strong> Empty</strong>'; }
                if (empty($Places_distribution)) { $formErrors[] = 'Places distribution Can\'t Be <strong> Empty</strong>'; }
                if ($status == 'not') { $formErrors[] = 'You Must Choose <strong>Status</strong>'; }
                if ($sellar == 'not') { $formErrors[] = 'You Must Choose <strong>sellars</strong>';   }
                if ($cat == 'not') { $formErrors[] = 'You Must Choose <strong>Category</strong>'; }

                // Check If There's No Proceed The Update Operation
                if (empty($formError)) {

                  // Update The Database With This Information
                  $sql = $con->prepare("UPDATE
                                              products
                                        SET
                                               p_name = ?,
                                               p_description = ?,
                                               price = ?,
                                               discount = ?,
                                               available_product_num = ?,
                                               p_country_id = ?,
                                               city_product = ?,
                                               status = ?,
                                               categoryID = ?,
                                               sellar_id = ?,
                                               Places_distribution = ?,
                                               edit_date = NOW()

                                        WHERE
                                               p_id = ? LIMIT 1");
                  $sql->execute(array($name, $desc, $price, $discount, $available_product_num, $country, $city, $status, $cat, $sellar, $place, $id));

                     // Echo Success Message
                    $theMsg ="<div class='alert alert-success text-center'>" . $sql->rowCount() . ' ' . $lang['Record Update'] . "</div>";
                    redirectHome($theMsg, 'back');
                } else {
                  // Loop Into Errors Array And Echo It
                  foreach($formErrors as $error) { echo '<div class="alert alert-danger">' . $error . '</div>'; }
                  $theMsg = '';
                  redirectHome($theMsg, 'back');
                }

            } else {
                $theMsg = '<div class="alert alert-danger">' . $lang['Sorry you Can\'t Browse This Page Directory'] . '</div>';
                redirectHome($theMsg);
            }

         echo "</div>";

        } elseif ($do == 'Delete') {

                echo "<h1 class='text-center global-h1'>" . $lang['Delete Product'] . "</h1>";
                  echo "<div class='container'>";

                        // Check If Get Request Itemid Is Numeric & Get The Integer Value It
                        $productid = isset($_GET['productid']) && is_numeric($_GET['productid']) ? intval($_GET['productid']) : 0;

                        // Select All Data Depend On This ID
                        $check = checkItem('p_id', 'products', $productid);

                        // If There Is Such ID Show The Form
                        if($check > 0) {
                          $sql = $con->prepare('DELETE FROM products WHERE p_id = :zname');
                          $sql->bindparam(":zname", $productid);
                          $sql-> execute();
                          $theMsg = "<div class='alert alert-success'>" . $sql->rowCount() . 'Delete Record</div>';
                           redirectHome($theMsg);

                      } else {

                          $theMsg = '<div class="alert alert-danger">' . $lang['This Id Not Exist'] . '</div>';
                          redirectHome($theMsg);
                      }

                  echo "</div>";


        } elseif ($do == 'Approve') {

                  echo "<h1 class='text-center global-h1'>" . $lang['Approve Product'] . "</h1>";
                  echo "<div class='container'>";

                        // Check If Get Request Userid Is Numeric & Get The Integer Value It
                       $productid = isset($_GET['productid']) && is_numeric($_GET['productid']) ? intval($_GET['productid']) : 0;

                        // Select All Data Depend On This ID
                        $check = checkItem('p_id', 'products', $productid);

                        // If There Is Such ID Show The Form
                      if($check > 0) {

                          $sql = $con->prepare("UPDATE products SET Approve = 1, approve_date = now() WHERE p_id = ?");
                          $sql-> execute(array($productid));
                          $theMsg = "<div class='alert alert-success text-center'>" . $sql->rowCount() . ' ' . $lang['Record Approved'] .  '</div>';
                           redirectHome($theMsg, 'back');

                      } else {

                          $theMsg = '<div class="alert alert-danger text-center">' . $lang['This Id Not Exist'] . '</div>';
                          redirectHome($theMsg, 'back');
                      }

                  echo "</div>";
           }

        include $tpl . 'footer-copyright.php';
        include $tpl . 'footer.php';

    } else {
        header('Location: index.php');
        exit();
    }

    ob_end_flush();
?>
