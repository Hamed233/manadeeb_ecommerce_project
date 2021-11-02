<?php
  ob_start();
  $pageTitle = 'Join Us';
  if (isset($_GET['do'])) {
    $pageTitle = $_GET['do']; // Page Main Title
  } else {
    $pageTitle = "Signin";
  }
  $no_ads    = '';
  include 'init.php'; // this file contain all info for config

    if (isset($_POST['signup'])) {

       $formErrors_sign = array();

       $cus_f_name    = $_POST['cus_f_name'];
       $cus_l_name    = $_POST['cus_l_name'];
       $email         = $_POST['mail'];
       $password1     = $_POST['pass'];
       $passwoed2     = $_POST['pass_2'];
       $phone         = $_POST['phone'];
       $city          = $_POST['city'];
       $country       = $_POST['country'];


           // validate Customer name
            if (isset($_POST['cus_f_name']) || isset($_POST['cus_l_name'])) {

                $filter_f_name = filter_var($cus_f_name, FILTER_SANITIZE_STRING);
                $filter_l_name = filter_var($cus_l_name, FILTER_SANITIZE_STRING);

                if (strlen($filter_f_name || $filter_l_name) > 4) {
                    $formErrors_sign[] = 'Field (First Name) or (Last Name) is very <b>short</b>';
                }

                if (empty($cus_f_name || $cus_l_name)) {
                  $formErrors_sign [] = 'Field <b>(First Name) or (Last Name)</b> is Required';
                }
            }

            // validate password
            if (isset($password1) && isset($passwoed2)) {

                if (empty($password1)) {
                    $formErrors_sign[] = '<b>Password</b> must be writing';
                }

                if (sha1($password1) !== sha1($passwoed2)) {
                    $formErrors_sign[] = '<b>Password</b> must be equal';
                }

            }

            // validate mail

            if (isset($email)) {

                $filterEmail = filter_var($email, FILTER_SANITIZE_EMAIL);

                if (filter_var($filterEmail, FILTER_VALIDATE_EMAIL) != true) {

                    $formErrors_sign[] = 'This <b>Email</b> Not Valid';
                }
            }

            // validate phone

            if (isset($phone)) {
              if (strlen($phone) < 11 || strlen($phone) > 13 || ! is_numeric($phone)) {
                $formErrors_sign[] = 'This <b>Phone</b> not valid';
              }

              if (empty($phone)) {
                $formErrors_sign[] = 'Field <b>Phone</b> is empty';
              }
            }

            // validate city

            if (empty($city) || is_numeric($city) || strlen($city) > 20) {
              $formErrors_sign [] = 'Field <b>City</b> not valid';
            }

            if($city == 'city'){
              $formErrors_sign [] = 'Field <b>City</b> Not Found!';
            }

            if($country == 0){
              $formErrors_sign [] = 'Field <b>Country</b> Not Found!';
            }

            // Check If There's No ERRORS Proceed The User Add
           if (empty($formErrors_sign)) {

               // Check If User Exist In Database

             $check = checkItem("cus_mail", "customers", $email); // check if mail is exist or not

               if ($check == 1) {
                   $formErrors_sign[] = 'Sorry this <b>Email</b> is exist';
               } else {

                        // Insert UserInfo In DB

                   $sql = $con->prepare("INSERT INTO
                                       customers(cus_f_name, cus_l_name, cus_country_id, cus_password, cus_mail, cus_phone, cus_city, cus_enter_date)
                                       VALUES(:fuser, :luser, :coun, :zpass, :zmail, :phone, :city, now())");
                   $sql->execute(array (

                       'fuser'     => $cus_f_name,
                       'luser'     => $cus_l_name,
                       'coun'      => $country,
                       'zpass'     => sha1($password1),
                       'zmail'     => $email,
                       'phone'     => $phone,
                       'city'      => $city
                   ));
                     // echo success Msg
                     $_SESSION["success"] = ["type" => "success", "message" => $lang["Congratz!! Signin Now"]];
                    header('Location: log-sign.php');
                    exit();
                 } // end check exist
           }  // end check formErr

         }

         if (isset($_POST['Signin'])) {

           $formErrors_s = array();

           $mail       = $_POST['mail'];
           $pass       = $_POST['pass'];
           $hashedpass = sha1($pass);

           // validate form

           if (isset($mail)) {

               $filterEmail = filter_var($mail, FILTER_SANITIZE_EMAIL);

               if (filter_var($mail, FILTER_VALIDATE_EMAIL) != true) {
                   $formErrors_s[] = 'This <b>Email</b> not valid';
               }
            }

            if (empty($pass)) { $formErrors_s [] = 'Field <b>Password</b>is empty'; }

            if (empty($formErrors_s)) {

              $sql = $con->prepare("SELECT
                                         *
                                     FROM
                                           customers
                                     WHERE
                                           cus_mail = ?
                                     AND
                                           cus_password = ?");

              $sql->execute(array($mail, $hashedpass));
              $info   = $sql->fetch();
              $count = $sql->rowCount();
              if ($count > 0) {
                  $_SESSION['customer'] = $info['cus_f_name'];      // Register Session Name
                  $_SESSION['cus_id']   = $info['cus_id'];          // Register User ID In Session
                  $_SESSION['cus_coun'] = $info['cus_country_id'];
                  $_SESSION['cus_city'] = $info['cus_city'];
                  $_SESSIOM['cart']     = $info['cart'];
                  header('Location: index.php');         // Redirect To Dashboard Page
                  exit();
              } else {
                $formErrors_s [] = 'Sorry This Email Not Found';
              }
             }
            }


    $do = isset($_GET['do']) ? $_GET['do'] : 'Signin';

   if ($do == 'Signin') {

      ?>
        <div class="page-wrapper">
                <div class="container">
                    <div class="form-container">
                        <h2 class="main-section-header text-center"><span>M</span></h2>
                        <p class="text-center"><?php echo $lang['Signin']; ?></p>
                        <?php
                          if (isset($_SESSION["success"])){
                              vprintf("<div class='alert alert-success text-center success %s'> <i class=\"fa fa-check-circle\"></i> %s</div>", $_SESSION["success"]);
                              unset($_SESSION["success"]);
                          }
                        ?>
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                          <div class="form-group">
                            <label for="mail"><?php echo $lang['Email']; ?></label>
                            <input type="email" name="mail" class="form-control" id="mail" placeholder="<?php echo $lang['Email']; ?>" value="<?php echo isset($_POST["mail"]) ? $_POST["mail"] : ''; ?>" required>
                          </div>
                          <div class="form-group">
                            <label for="pass"><?php echo $lang['Password']; ?></label>
                            <input type="password" name="pass" class="form-control password" id="pass" placeholder="<?php echo $lang['Password']; ?>" value="<?php echo isset($_POST["pass"]) ? $_POST["pass"] : ''; ?>" required>
                            <i class="show-pass fa fa-eye fa-2x"></i>
                          </div>
                          <button type="submit" class="btn btn-danger" name="Signin"><?php echo $lang['Signin']; ?></button>
                        </form>
                       <hr>
                      <div class="more-info-login">
                        <a href="forget-pass/index.php"><?php echo $lang['Forget_Password']; ?>?</a>
                        <a href="log-sign.php?do=SignUp" target="_self"><?php echo $lang['SignUp']; ?></a>
                      </div>
                    </div><!-- .form-container -->
                    <!-- This Is Loop Special To Show Errors [Filter] Field  -->
                    <div class="errors text-center" style="width: 43%;margin: auto;">
                      <?php
                          if (!empty($formErrors_s)) {
                              foreach ($formErrors_s as $error) {
                                  echo "<div class='alert alert-danger'><i class='fas fa-exclamation-circle' style='padding: 10px;'></i>" . $error . "</div>";
                              }
                          }

                          if (isset($successMsg)) {
                              echo '<div class="msg success">' . $successMsg . '</div>';
                          }
                        ?>
                    </div>
                </div>
            </div>


 <?php  } elseif ($do == 'SignUp') { ?>

            <div class="page-wrapper">
                <div class="container">
                    <div class="form-container">
                        <h2 class="main-section-header text-center"><span>M</span></h2>
                        <p class="text-center">SignUp <span>Now</span></p>
                        <form action="?do=SignUp" method="POST">
                          <div class="form-group">
                            <label for="fname"><?php echo $lang['f_name']; ?></label>
                            <input type="text" name="cus_f_name" class="form-control" id="fname" value="<?php echo isset($_POST["cus_f_name"]) ? $_POST["cus_f_name"] : ''; ?>" placeholder="<?php echo $lang['f_name']; ?>" required >
                          </div>
                          <div class="form-group">
                            <label for="lname"><?php echo $lang['s_name']; ?></label>
                            <input type="text" name="cus_l_name" class="form-control" id="lname" value="<?php echo isset($_POST["cus_l_name"]) ? $_POST["cus_l_name"] : ''; ?>" placeholder="<?php echo $lang['s_name']; ?>" required>
                          </div>
                          <div class="form-group">
                            <label for="mail"><?php echo $lang['Email']; ?></label>
                            <input type="email" name="mail" class="form-control" id="mail" value="<?php echo isset($_POST["mail"]) ? $_POST["mail"] : ''; ?>" aria-describedby="emailHelp" placeholder="<?php echo $lang['Email']; ?>" required>
                          </div>
                          <div class="form-group">
                            <label for="pass"><?php echo $lang['Password']; ?></label>
                            <input type="password" name="pass" class="form-control password" value="<?php echo isset($_POST["pass"]) ? $_POST["pass"] : ''; ?>" id="pass" placeholder="<?php echo $lang['Password']; ?>" required>
                            <i class="show-pass-log fa fa-eye fa-2x"></i>
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
                            <input type="password" name="pass_2" class="form-control" id="pass_2" value="<?php echo isset($_POST["pass_2"]) ? $_POST["pass_2"] : ''; ?>" placeholder="<?php echo $lang['Confirm password']; ?>" required>
                          </div>
                         <div class="form-group">
                            <label for="phone"><?php echo $lang['Phone']; ?></label>
                            <input type="text" name="phone" class="form-control" id="phone" value="<?php echo isset($_POST["phone"]) ? $_POST["phone"] : ''; ?>" placeholder="<?php echo $lang['Phone']; ?>" required>
                          </div>
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
                          <!-- End city Field -->

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
                          <button type="submit" class="btn btn-danger" name="signup"><?php echo $lang['SignUp']; ?></button>
                        </form>
                       <hr>
                      <div class="more-info-login">
                        <a href="log-sign.php?do=Signin" target="_self"><?php echo $lang['Signin']; ?></a>
                      </div>
                    </div><!-- .form-container -->
                    <!-- This Is Loop Special To Show Errors [Filter] Field  -->
                    <div class="errors text-center" style="width: 43%;margin: auto;">
                      <?php
                          if (!empty($formErrors_sign)) {
                              foreach ($formErrors_sign as $error) {
                                  echo "<div class='alert alert-danger text_alert'>" . $error . "</div>";
                              }
                          }

                          if (isset($successMsg)) {
                              echo '<div class="msg success">' . $successMsg . '</div>';
                          }
                        ?>
                    </div>
                </div>
            </div>

<?php } else {
    header('Location: 404.php');
    exit();
  } ?>



 <?php
    include $temp . 'footer.php'; // Footer template
    ob_end_flush(); // Release The Output
 ?>
