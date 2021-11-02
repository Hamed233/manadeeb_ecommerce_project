<?php
  ob_start();
  $pageTitle = 'Sell On Manadeeb & Earn Money'; // Page Main Title
  $no_ads    = '';
  include 'init.php'; // this file contain all info for config

 if (isset($_POST['login'])) {

   if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      $formErrors_sign = array();

      $mail       = $_POST['mail'];
      $pass       = $_POST['pass'];
      $hashedpass = sha1($pass);

      // validate form

      if (isset($mail)) {

        $filterEmail = filter_var($mail, FILTER_SANITIZE_EMAIL);

        if (filter_var($mail, FILTER_VALIDATE_EMAIL) != true) {
            $formErrors_sign[] = 'This <b>Email</b> not valid';
        }
      }

      if (empty($pass)) { $formErrors_sign [] = 'Field <b>Password</b>is empty'; }

    if(empty($formErrors_sign)) {
      $stmt = $con->prepare("SELECT
                                *
                            FROM
                                  sellars
                            WHERE
                                  sellar_mail = ?
                            AND
                                  sellar_pass = ?");

      $stmt->execute(array($mail, $hashedpass));
      $get   = $stmt->fetch();
      $count = $stmt->rowCount();
      if ($count > 0) {
          $_SESSION['sellar']      = $get['sellar_mail']; // Register Session Sellar mail
          $_SESSION['sellar_id']   = $get['sellar_id'];   // Register sellar ID In Session
          $_SESSION['sellar_name'] = $get['sellar_name']; // Register Session Sellar name
          $_SESSION['country_id']  = $get['country_id'];  // Register Session Sellar Country
          $_SESSION['sellar_city'] = $get['city'];       // Register Session Sellar city
          $_SESSIOM['cart']        = '0';
          header('Location: index.php');         // Redirect To Home Page
          exit();
      } else {
        $formErrors_sign [] = 'Sorry this sellar not found OR Password incorrect';
      }

      } else {
        header('Location: index.php');
        exit();
      }

  } else {
    header('Location: index.php');
    exit();
  }
} // end login

   $do = isset($_GET['do']) ? $_GET['do'] : 'login';

   if ($do == 'login') {

     if (isset($_SESSION['sellar'])) {
       header('Location: index.php');
       exit();
     } ?>
            <div class="page-wrapper">
                <div class="container">
                    <div class="form-container">
                        <h2 class="main-section-header text-center"><span>M</span></h2>
                        <p class="text-center">Signin for <span>sellar</span></p>
                        <?php
                          if (isset($_SESSION["success"])){
                              vprintf("<div class='alert alert-success text-center success %s'> <i class=\"fa fa-check-circle\"></i> %s</div>", $_SESSION["success"]);
                              unset($_SESSION["success"]);
                          } elseif(isset($_SESSION["customer"])) {
                            echo "<div class='alert alert-danger text-center'>" . $lang['You Must Logout From Ordinary Email'] . "</div>";
                            header('Location: index.php');
                            exit();
                          }
                        ?>
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                          <div class="form-group">
                            <label for="mail"><?php echo $lang['Email']; ?></label>
                            <input type="email" name="mail" class="form-control" id="mail" aria-describedby="emailHelp" placeholder="<?php echo $lang['Email']; ?>" value="<?php echo isset($_POST["mail"]) ? $_POST["mail"] : ''; ?>" required>
                          </div>
                          <div class="form-group">
                            <label for="pass"><?php echo $lang['Password']; ?></label>
                            <input type="password" name="pass" class="form-control password" id="pass" placeholder="<?php echo $lang['Password']; ?>" value="<?php echo isset($_POST["pass"]) ? $_POST["pass"] : ''; ?>" required>
                            <i class="show-pass fa fa-eye fa-2x"></i>
                          </div>
                          <button type="submit" name="login" class="btn btn-danger"><?php echo $lang['Signin']; ?></button>
                        </form>
                       <hr>
                      <div class="more-info-login">
                        <a href="forget-pass/index.php">Forget Password?</a>
                        <a href="sellar.php?do=signup" target="_self"><?php echo $lang['SignUp']; ?></a>
                      </div>
                    </div><!-- .form-container -->
                    <div class="errors text-center">
                        <?php
                            if (isset($formErrors_sign)) {
                                foreach ($formErrors_sign as $error) {
                                    echo "<div class='alert alert-danger'>" . $error . "</div>";
                                }
                            }

                            if (isset($successMsg)) {
                                echo '<div class="msg success">' . $successMsg . '</div>';
                            }
                          ?>
                      </div>
                </div>
            </div>

 <?php  } elseif ($do == 'signup') {
           if (!(isset($_SESSION['sellar']) || isset($_SESSION['customer']))) {
             header('Location: index.php');
             exit();
           } 
           
           if (isset($_POST['signup'])) {

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          
                 $formErrors_up = array();
          
                 $sellar_name    = $_POST['sellar_name'];
                 $email          = $_POST['mail'];
                 $password1      = $_POST['pass'];
                 $passwoed2      = $_POST['pass_2'];
                 $phone          = $_POST['phone'];
                 $country        = $_POST['country'];
                 $city           = $_POST['city'];
          
                 $sellarImg     = $_FILES['img'];
                 $sellarImgName = $_FILES['img']['name'];
                 $sellarImgSize = $_FILES['img']['size'];
                 $sellarImgTmp  = $_FILES['img']['tmp_name'];
                 $sellarImgType = $_FILES['img']['type'];
          
                 // List Odf Allowed File Typed To Upload
                 $sellarImgAllowedExtention = array("jpeg", "jpg", "png", "gif");
          
                 // Get productImg Extention
                 $sellarImgEtention = strtolower(end(explode('.', $sellarImgName)));
          
          
                  // validate Customer name
                  if (isset($_POST['sellar_name'])) {
      
                      $filtername = filter_var($sellar_name, FILTER_SANITIZE_STRING);
      
                      if (strlen($sellar_name) < 4) {
                          $formErrors_up[] = 'Field sellar Name is very <b>short</b>';
                      }
      
                      if (empty($sellar_name)) {
                        $formErrors_up [] = 'This field is <b>Required</b>';
                      }
                  }
      
                  // validate password
                  if (isset($password1) && isset($passwoed2)) {
      
                      if (empty($password1)) {
                          $formErrors_up[] = 'Password Must Be Writing';
                      }
      
                      if (sha1($password1) !== sha1($passwoed2)) {
                          $formErrors_up[] = 'Password Must Be Equal';
                      }
      
                  }
      
                  // validate mail
      
                  if (isset($email)) {
      
                      $filterEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
      
                      if (filter_var($filterEmail, FILTER_VALIDATE_EMAIL) != true) {
      
                          $formErrors_up[] = 'This Email Not Valid';
                      }
                  }
      
                  // validate phone
      
                  if (isset($phone)) {
                    if (strlen($phone) < 11 || strlen($phone) > 13 || ! is_numeric($phone)) {
                      $formErrors_up[] = 'This Phone Not Valid';
                    }
      
                    if (empty($phone)) {
                      $formErrors_up[] = 'This Field is <b>Empty</b>';
                    }
                  }
      
                  // validate country
      
                  if (empty($country)) {
                    $formErrors_up [] = 'Field <b>country</b> Not Valid';
                  }

                  if($country == 0){
                    $formErrors_sign [] = 'Field <b>Country</b> Not Found!';
                  }

                  if($city == 'city'){
                    $formErrors_sign [] = 'Field <b>City</b> Not Found!';
                  }
      
                  if (! empty($sellarImgName) && ! in_array($sellarImgEtention, $sellarImgAllowedExtention)) { $formErrors_up[] = 'This Extention Is Not <strong> Allowed </strong>'; }
                  if (empty($sellarImgName)) { $formErrors_up[] = 'Image Product is <strong> Required </strong>'; }
                  if ($sellarImgSize > 4194304) { $formErrors_up[] = 'This Image Can\'t Larger Than <strong> 4MB </strong>'; }
      
                  // Check If There's No ERRORS Proceed The User Add
                   if (empty($formErrors_up)) {
          
                       // Check If User Exist In Database
                       $check = checkItem("sellar_name", "sellars", $sellar_name); // check if name is exist or not
          
                         if ($check == 1) {
                             $formErrors_sign[] = 'Sorry This <b>Name</b> Is Exist';
                         } else {
          
                           $sellarImg = rand(0, 1000000) . '_' . $sellarImgName;
          
                           move_uploaded_file($sellarImgTmp, "upload\sellars\\" . $sellarImg);
          
                           $tmp = 'upload/sellars/'. $sellarImg;
                           $new = 'admin-dashboard/upload/sellars/'. $sellarImg;
                           $cpy = copy($tmp, $new);
                           move_uploaded_file($sellarImgTmp, $cpy); // move image to front-area
          
                             // Insert UserInfo In DB
                             $sql = $con->prepare("INSERT INTO
                                                 sellars(sellar_name, sellar_pass, sellar_img, sellar_mail, sellar_phone, country_id, city, date_register, Reg_status)
                                                 VALUES(:fuser, :zpass, :zimg, :zmail, :phone, :country, :zcity, now(), 0)");
                             $sql->execute(array (
          
                                 'fuser'     => $sellar_name,
                                 'zpass'     => sha1($password1),
                                 'zimg'       => $sellarImg,
                                 'zmail'     => $email,
                                 'phone'     => $phone,
                                 'country'   => $country,
                                 'zcity'     => $city
                             ));

                              // echo success Msg
                              $_SESSION["success"] = ["type" => "success", "message" => $lang["Congratz!! Signin Now"]];
          
                              header('Location: sellar.php');
                              exit();
                           } // end check exist
                     } // end check formErr
          
              } else {
                header('Location: index.php');
                exit();
              }
            } // end signUp  ?>

            <div class="page-wrapper">
                <div class="container">
                    <div class="form-container">
                        <h2 class="main-section-header text-center"><span>M</span></h2>
                        <p class="text-center">SignUp for <span>sellar</span></p>
                        <form action="sellar.php?do=signup" method="post" enctype="multipart/form-data">
                          <div class="form-group">
                            <label for="name"><?php echo $lang['Full Name']; ?></label>
                            <input type="text" name="sellar_name" class="form-control" value="<?php echo isset($_POST["sellar_name"]) ? $_POST["sellar_name"] : ''; ?>" id="name" aria-describedby="emailHelp" placeholder="Full Name">
                          </div>
                          <div class="form-group">
                            <label for="mail"><?php echo $lang['Email']; ?></label>
                            <input type="email" name="mail" class="form-control" id="mail" value="<?php echo isset($_POST["mail"]) ? $_POST["mail"] : ''; ?>" aria-describedby="emailHelp" placeholder="<?php echo $lang['Email']; ?>">
                          </div>
                          <div class="form-group">
                            <label for="pass"><?php echo $lang['Password']; ?></label>
                            <input type="password" name="pass" class="form-control" id="pass" value="<?php echo isset($_POST["pass"]) ? $_POST["pass"] : ''; ?>" placeholder="<?php echo $lang['Password']; ?>">
                            <i class="show-pass fa fa-eye fa-2x"></i>
                          </div>
                          
                          <div id="message">
                            <h5>Password must contain the following:</h5>
                            <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
                            <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
                            <p id="number" class="invalid">A <b>number</b></p>
                            <p id="length" class="invalid">Minimum <b>8 characters</b></p>
                          </div>
                         <div class="form-group">
                            <label for="pass_2"><?php echo $lang['Confirm Password']; ?></label>
                            <input type="password" name="pass_2" class="form-control" id="pass_2" value="<?php echo isset($_POST["pass_2"]) ? $_POST["pass_2"] : ''; ?>" placeholder="<?php echo $lang['Confirm password']; ?>">
                          </div>
                         <div class="form-group">
                            <label for="phone"><?php echo $lang['Phone']; ?></label>
                            <input type="tel" name="phone" class="form-control" id="phone" value="<?php echo isset($_POST["phone"]) ? $_POST["phone"] : ''; ?>" placeholder="<?php echo $lang['Phone']; ?>">
                          </div>
                          <!-- Start country filed -->
                          <div class="form-group">
                            <label for="country"><?php echo $lang['country']; ?></label>
                              <select class="form-control" id="country" name="country" required>
                                <option value="0"><?php echo $lang['country']; ?></option>
                                  <?php
                                  $allCountries = getAllFrom("*", "countries", "", "", "coun_id");

                                       foreach ($allCountries as $country) {
                                           echo "<option value='" . $country['coun_id'] . "'>" . $country['coun_name'] . "</option>";
                                       }

                                    ?>
                              </select>
                          </div>
                            <!-- End country filed -->

                            <!-- Start city Field -->
                          <div class="form-group form-group-lg">
                              <h5><?php echo $lang['City']; ?></h5>
                                <select class="form-control" name="city" id="city" value="<?php echo isset($_POST["city"]) ? $_POST["city"] : ''; ?>" aria-describedby="emailHelp" placeholder="<?php echo $lang['City']; ?>" required>
                                    <option value="city"><?php echo $lang['City']; ?></option>
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
                                    <option value="Dahaban">Dahaban</option>
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
                          <!-- End city Field -->


                            <!-- start photo filed -->
                          <div class="form-group">
                             <label for="img"><?php echo $lang['Your Photo']; ?></label>
                             <input type="file" name="img" class="form-control" id="img" placeholder="<?php echo $lang['Your Photo']; ?>">
                           </div>
                           <!-- End photo filed -->

                          <button type="submit" name="signup" class="btn btn-danger"><?php echo $lang['SignUp']; ?></button>
                        </form>
                       <hr>
                      <div class="more-info-login">
                        <a href="sellar.php?do=login" target="_self"><?php echo $lang['Signin']; ?></a>
                      </div>

                    </div><!-- .form-container -->
                    <div class="errors text-center container">
                        <?php
                            if (!empty($formErrors_up)) {
                                foreach ($formErrors_up as $error) {
                                    echo "<div class='alert alert-danger'>" . $error . "</div>";
                                }
                            }

                            if (isset($successMsg)) {
                                echo '<div class="msg success">' . $successMsg . '</div>';
                            }
                          ?>
                      </div>
                </div>
            </div>

          <?php } elseif ($do == 'myDashboard') {

            if(!isset($_SESSIOM['sellar'])) {
              header('Location: index.php');
              exit();
            }
            
            $numProducts = 10;  // Number Of The Latest Items
            $latestProducts = getLatest("*", "products", "p_id", $numProducts);  // Latest Items Array ?>

            <div class="dashboard-page">
              <div class="home-stats">
                <div class="container text-center">
                   <h2 class="page-heading mar_top"><?php echo $lang['Dashboard']; ?></h2>
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-6">
                           <div class="stat st-pending">
                               <i class="fab fa-product-hunt"></i>
                               <div class="info">
                                  <?php echo $lang['Pending Product']; ?>
                                   <span>
                                     <?php
                                        $sqlTwo = $con->prepare("SELECT * FROM products WHERE Approve = ? AND sellar_id = ?");
                                        $sqlTwo->execute(array(0, $_SESSION['sellar_id']));
                                        $count = $sqlTwo->rowCount();
                                      ?>
                                       <a href='sellar.php?do=Manage&page=Pending'><?php echo $count; ?></a>
                                   </span>
                               </div>
                            </div>
                         </div>

                        <div class="col-sm-12 col-md-6 col-lg-6">
                           <div class="stat st-items">
                               <i class="fa fa-tag dash_i"></i>
                               <div class="info">
                                  <?php echo $lang['Total Products']; ?>
                                   <span>
                                     <?php
                                        $sqlTwo = $con->prepare("SELECT * FROM products WHERE sellar_id = ?");
                                        $sqlTwo->execute(array($_SESSION['sellar_id']));
                                        $count_product = $sqlTwo->rowCount();
                                      ?>
                                       <a href="products.php"><?php echo $count_product; ?></a>
                                   </span>
                                </div>
                            </div>
                         </div>
                    </div>
                    <hr />
                 </div>
               </div>
              </div>



              <?php
              $sql = $con->prepare("SELECT
                                         *
                                   FROM
                                         products
                                   WHERE
                                         sellar_id = {$_SESSION['sellar_id']}");
              $sql->execute();
              $products = $sql->fetchAll(); ?>

              <h1 class="text-center global-h1"><?php echo $lang['My products']; ?></h1>
          <?php if (!empty($products)) { ?>
                <div class="container-fluid" style="margin-bottom: 19px;">
                    <div class="table-responsive">
                        <table class="main-table text-center table table-bordered">
                            <tr>
                                <td><?php echo $lang['Product Image']; ?>          </td>
                                <td><?php echo $lang['Product Name']; ?>           </td>
                                <td><?php echo $lang['available_product_num']; ?>  </td>
                                <td><?php echo $lang['Price']; ?>                  </td>
                                <td><?php echo $lang['Adding Data']; ?>            </td>
                                <td><?php echo $lang['product status']; ?>         </td>
                                <td><?php echo $lang['Control']; ?>                </td>
                            </tr>

                            <?php foreach($products as $product) {

                                     echo "<tr>";
                                        echo "<td>";
                                        if (empty($product['p_picture'])) {
                                            echo "Sorry, Not Found Image";
                                        } else { ?>
                                            <div class="box" style="background:url('<?php echo 'upload/products/' . $product['p_picture'] . ''; ?>')">
                                              <!-- Star Cover Right -->
                                              <div class="cover right">
                                                <button type="button" name="update_img" class="btn btn-warning bt-xs update_img" id="<?php echo $product['p_id'] ?>">Edit Img</button>
                                              </div>
                                            </div>
                                      <?php  }

                                        echo "</td>";
                                        echo "<td>" . $product['p_name'] . "</td>";
                                        echo "<td>" . $product['available_product_num'] . "</td>";
                                        echo "<td>$" . $product['price']   . "</td>";
                                        echo "<td>" . $product['date_insert']  . "</td>";
                                        if ($product['Approve'] == 0) {
                                          echo "<td>" . $lang['Pending'] . "</td>";
                                        } else {
                                          echo "<td>" . $lang['Published'] . "</td>";
                                        }
                                        echo "<td>
                                            <a href='sellar.php?do=Edit&productid=" . $product['p_id'] . "' class='btn btn-success edit-product'><i class='fa fa-edit'></i> Edit  </a>
                                            <a href='sellar.php?do=Delete&productid=" . $product['p_id'] . "'' class='btn btn-danger confirm del-product'><i class='fas fa-times'></i> Delete  </a>";
                                       echo "</td>";
                                     echo "</tr>";

                                 } ?>
                        </table>
                    </div>

                   <a href = 'sellar.php?do=Add' class="btn btn-danger"><i class="fa fa-plus"></i> <?php echo $lang["Add New product"]; ?></a>

                    <!-- for edit image -->
                    <div id="image_data"></div>
                    <!-- model for update image -->
                    <div id="imageModal" class="modal fade" role="dialog">
                      <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add Image</h4>
                        </div>
                        <div class="modal-body">
                        <form id="image_form" method="post" enctype="multipart/form-data">
                          <p>
                            <label>Select Image:</label><br />
                            <input type="file" name="image" id="image" />
                          </p><br />
                          <input type="hidden" name="action" id="action" value="insert" />
                          <input type="hidden" name="image_id" id="image_id" />
                          <input type="submit" name="insert" id="insert_img" value="Insert" class="btn btn-info" />

                        </form>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                      </div>
                    </div>
                  </div>


              <?php } else { ?>
                       <div class="container container-special">
                          <div class='alert alert-danger' style='margin-top: 60px;'><b><i class='fas fa-exclamation-circle' style="padding: 10px;"></i> <?php echo $lang['Sorry Not Found Any Record To Show, but you can add now.']; ?></b></div>

                           <a
                            href = 'sellar.php?do=Add'
                            class='btn btn-danger'>
                            <i class='fa fa-plus'></i> <?php echo $lang['Add New product']; ?></a>
                      </div>
            <?php } ?>

          <?php    } elseif ($do == 'Add') { ?>

                    <div class="container container-special form-content">
                      <h1 class="text-center global-h1"><?php echo $lang['Add New Product']; ?></h1>
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
                                              name="product-img"
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
                                      <option value="city"><?php echo $lang['City']; ?></option>
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
                                        <select class="form-control" name="brand">
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
                                              value="<?php echo $lang['Add New Product']; ?>"
                                              class="btn btn-success btn-block" />
                                    </div>
                                </div>
                            <!-- End  submit Field -->
                        </form>

                        <div class="back-dashboard">
                          <a class="btn btn-danger" href="sellar.php?do=myDashboard"><?php echo $lang['Back Dashboard']; ?></a>
                        </div>
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
                      $status                = test_input($_POST['status']);
                      $sellar                = test_input($_SESSION['sellar_id']);
                      $category              = test_input($_POST['category']);
                      $city                  = test_input($_POST['city']);
                      $brand                 = test_input($_POST['brand']);
                      $available_product_num = test_input($_POST['available_product_num']);
                      $Places_distribution   = $_POST['distribution'];

                      $place="";  
                      foreach($Places_distribution as $distribution){  
                            $place .= $distribution . ",";
                      }

                      $productImg     = $_FILES['product-img'];
                      $productImgName = $_FILES['product-img']['name'];
                      $productImgSize = $_FILES['product-img']['size'];
                      $productImgTmp  = $_FILES['product-img']['tmp_name'];
                      $productImgType = $_FILES['product-img']['type'];

                      // List Odf Allowed File Typed To Upload
                      $productImgAllowedExtention = array("jpeg", "jpg", "png", "gif");

                      // Get productImg Extention
                      $productImgEtention = strtolower(end(explode('.', $productImgName)));

                      // Validate The Form
                      $formErrors = array();

                      if (empty($name)) { $formErrors[] = 'Name Can\'t Be <strong> Empty</strong>';  }
                      if (! empty($productImgName) && ! in_array($productImgEtention, $productImgAllowedExtention)) { $formErrors[] = 'This Extention Is Not <strong> Allowed </strong>'; }
                      if (empty($productImgName)) { $formErrors[] = 'Image Product is <strong> Required </strong>'; }
                      if ($productImgSize > 4194304) { $formErrors[] = 'This Image Can\'t Larger Than <strong> 4MB </strong>'; }
                      if (empty($available_product_num)) { $formErrors[] = 'Available product number Product is <strong> Required </strong>';  }
                      if (empty($desc)) { $formErrors[] = 'Description Can\'t Be <strong> Empty</strong>'; }
                      if (empty($price)) { $formErrors[] = 'Price Can\'t Be <strong> Empty</strong>'; }
                      if (empty($country)) { $formErrors[] = 'Country Can\'t Be <strong> Empty</strong>'; }
                      if (empty($Places_distribution)) { $formErrors[] = 'Places distribution Can\'t Be <strong> Empty</strong>'; }
                      if ($status == 'not') { $formErrors[] = 'You Must Choose <strong>Status</strong>'; }
                      if ($category == 'not') { $formErrors[] = 'You Must Choose <strong>Category</strong>'; }
                      if ($city == 'city'){ $formErrors_sign [] = 'Field <b>City</b> Not Found!'; }
                      if ($country == 0){ $formErrors_sign [] = 'Field <b>Country</b> Not Found!'; }

                      // Check If There's No Proceed The Update Operation
                      if (empty($formErrors)) {

                        // Check If User Exist In Database
                        $check = checkItem("p_name", "products", $name);

                          if ($check == 1) {
                              $theMsg =  "<div class='alert alert-danger text_alert'><i class='fas fa-exclamation-circle' style='padding: 10px;'></i> Sorry This Name Is Exist</div>";
                              redirectHome($theMsg, 'back');
                          } else {

                            $productImg = rand(0, 1000000) . '_' . $productImgName;
            
                            move_uploaded_file($productImgTmp, "upload\products\\" . $productImg);
                            $tmp = 'upload/products/'. $productImg;
                            $new = 'admin-dashboard/upload/products/'. $productImg;
                            $cpy = copy($tmp, $new);
                            move_uploaded_file($productImgTmp, $cpy);

                              // Insert UserInfo In DB
                              $sql = $con->prepare("INSERT INTO
                                                  products(p_name, p_description, p_picture, price, discount, available_product_num, p_country_id, city_product, status, date_insert, brand_ID, categoryID, sellar_id, Places_distribution)
                                                  VALUES(:zname, :zdesc, :pic, :zprice, :zprice_discount, :ava_pro_num, :zcountry, :city, :zstatus, now(), :brand, :zcategory, :zsellar, :zdistribution)");
                              $sql->execute(array (

                                  'zname'            => $name,
                                  'zdesc'            => $desc,
                                  'pic'              => $productImg,
                                  'zprice'           => $price,
                                  'zprice_discount'  => $discount,
                                  'ava_pro_num'      => $available_product_num,
                                  'zcountry'         => $country,
                                  'city'             => $city,
                                  'zstatus'          => $status,
                                  'zcategory'        => $category,
                                  'brand'            => $brand,
                                  'zsellar'          => $sellar,
                                  'zdistribution'    => $place
                              ));

                                    echo "<div class='container container_100'>";
                                       // Echo Success Message
                                     $theMsg = "<div class='alert alert-success text_alert'>" . $sql->rowCount() . ' ' . $lang['Record Inserted'] . '</div>';
                                     redirectHome($theMsg, 'back');
                                    echo '</div>';
                                exit();
                             }
                      } else {
                        // Loop Into Errors Array And Echo It
                        foreach($formErrors as $error) { echo '<div class="alert alert-danger text_alert container_100"><i class="fas fa-exclamation-circle" style="padding: 10px;"></i>' . $error . '</div>'; }
                        $theMsg =  '<div class="alert alert-danger"><i class="fas fa-exclamation-circle" style="padding: 10px;"></i>Something error!</div>';
                        redirectHome($theMsg, 'back');
                      }


                  } else {

                      $theMsg =  '<div class="alert alert-danger"><i class="fas fa-exclamation-circle" style="padding: 10px;"></i> ' . $lang['Sorry you Can\'t Browse This Page Directory'] . '</div>';
                      redirectHome($theMsg, 'back');
                  }

                
           echo "</div>";


              } elseif ($do == 'Edit') {


                          // Check If Get Request itemid Is Numeric & Get The Integer Value It
                         $productid = isset($_GET['productid']) && is_numeric($_GET['productid']) ? intval($_GET['productid']) : 0;

                          // Select All Data Depend On This ID
                          $sql   = $con->prepare("SELECT * FROM products WHERE p_id = ? AND sellar_id = ?");

                          // Execute Query
                          $sql->execute(array($productid, $_SESSION['sellar_id']));

                          // Fetch The Data
                          $product   = $sql->fetch();

                          // The Row Count
                          $count = $sql->rowCount();

                          $Places_distributions = explode(",", $product['Places_distribution']);

                        if($count > 0) { // If There Is Such ID Show The Form ?>

                              <h1 class="text-center global-h1"><?php echo $lang['Edit product']; ?></h1>
                              <div class="container container-special form-content">
                                  <form class="form-horizontal" action="?do=Update" method="POST" enctype="multipart/form-data">
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
                                            <h5><?php echo $lang['available_product_num']; ?></h5>
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
                                                      <option value="new" <?php if ($product['status']== 'new') { echo "selected"; } ?> >New</option>
                                                      <option value="like-new" <?php if ($product['status']== 'like-new') { echo "selected"; } ?> >Like New</option>
                                                      <option value="used" <?php if ($product['status']== 'used') { echo "selected"; } ?> >Used</option>
                                                      <option value="old" <?php if ($product['status']== 'old') { echo "selected"; } ?> >Old</option>
                                                  </select>
                                              </div>
                                         </div>
                                      <!-- End  Status Field -->

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
                                                       value="Save Item"
                                                       class="btn btn-danger btn-block" />
                                              </div>
                                          </div>
                                      <!-- End  submit Field -->
                                  </form>

                                  <div class="back-dashboard">
                                    <a class="btn btn-danger" href="sellar.php?do=myDashboard"><?php echo $lang['Back Dashboard']; ?></a>
                                  </div>
                              </div>

                <?php

                      // If There Is No Such ID Show Error Message
                    } else {

                            echo "<div class='container container_100'>";
                              $theMsg  =  "<div class='alert alert-danger text_alert'>" . $lang['This Id Not Exist'] . "</div>";
                              redirectHome($theMsg, 'back');
                            echo "</div>";
                      }


              }  elseif ($do == 'Update') {

                  echo "<h1 class='text-center global-h1 mar_top'>" . $lang['Update Product'] . "</h1>";
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
                      $sellar                = test_input($_SESSION['sellar_id']);

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
                      if ($status == 'not') { $formErrors[] = 'You Must Choose <strong>Status</strong>'; }
                      if ($cat == 'not') { $formErrors[] = 'You Must Choose <strong>Category</strong>'; }
                      if (empty($Places_distribution)) { $formErrors[] = 'Places distribution Can\'t Be <strong> Empty</strong>'; }
                      if ($city == 'city'){ $formErrors_sign [] = 'Field <b>City</b> Not Found!'; }
                      if ($country == 0){ $formErrors_sign [] = 'Field <b>Country</b> Not Found!'; }

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
                                                     Places_distribution = ?

                                              WHERE
                                                     p_id = ? LIMIT 1");
                        $sql->execute(array($name, $desc, $price, $discount, $available_product_num, $country, $city, $status, $cat, $sellar, $place, $id ));

                           // Echo Success Message
                          $theMsg ="<div class='alert alert-success text_alert'><i class='fa fa-check-circle'></i> " . $sql->rowCount() . ' ' . $lang['Record Update'] . "</div>";
                          redirectHome($theMsg, 'back');
                      } else {
                        // Loop Into Errors Array And Echo It
                        foreach($formErrors as $error) { echo '<div class="alert alert-danger">' . $error . '</div>'; }
                      }

                  } else {

                      $theMsg   = '<div class="alert alert-danger text_alert">' . $lang['Sorry you Can\'t Browse This Page Directory'] . '</div>';
                      redirectHome($theMsg);
                  }


                     echo "</div>";


              } elseif ($do == 'Delete') {

                      echo "<h1 class='text-center global-h1 mar_top'>" . $lang['Delete Product'] . "</h1>";
                        echo "<div class='container container_100'>";

                              // Check If Get Request Itemid Is Numeric & Get The Integer Value It
                              $productid = isset($_GET['productid']) && is_numeric($_GET['productid']) ? intval($_GET['productid']) : 0;

                              // Select All Data Depend On This ID
                              $check = checkItem('p_id', 'products', $productid);

                            if($check > 0) { // If There Is Such ID Show The Form

                                $sql = $con->prepare('DELETE FROM products WHERE p_id = :zname');
                                $sql->bindparam(":zname", $productid); 
                                $sql-> execute();
                                $theMsg = "<div class='alert alert-success text_alert'><i class='fa fa-check-circle'></i> " . $sql->rowCount() . $lang['Delete Record'] . '</div>';
                                redirectHome($theMsg, 'back');

                            } else {

                                $theMsg = '<div class="alert alert-danger text_alert">' . $lang['This Id Not Exist'] . '</div>';
                                redirectHome($theMsg, 'back');
                            }

                        echo "</div>";
              } else {
                  header('Location: index.php');
                  exit();
              }

    include $temp . 'footer.php'; // Footer template
    ob_end_flush(); // Release The Output
 ?>
