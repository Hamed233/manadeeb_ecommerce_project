<?php

    /*
    ======================================================
    == Manage Sellars Page
    ======================================================
    */

    ob_start();
    $pageTitle = 'Sellars Manage';
    include 'init.php';

          if (isset($_SESSION['adm_name'])) {

             $do = isset($_GET['do']) ? ($_GET['do']) : 'Manage';

              // Start Manage Page

              if ($do == 'Manage') { // Manage Page

                  // Select All sellars

                   $sql = $con->prepare("SELECT
                                              sellars. *,
                                              countries.coun_name
                                        FROM
                                              sellars
                                        INNER JOIN
                                              countries
                                        ON countries.coun_id = sellars.country_id
                                        ORDER BY sellar_id DESC");
                   $sql->execute();
                   $rows = $sql->fetchAll(); ?>


                      <h2 class="text-center global-h1"><?php echo $lang['Sellars']; ?></h2>
                        <div class="container-fluid sellars">
                          <div class="row">
                          <div class="col-sm-12 col-md-6 col-lg-6">
                            <div class="stat st-items">
                              <i class="fas fa-users dash_i"></i>
                                <div class="info">
                                   <?php echo $lang['Total Sellars']; ?>
                                    <span>
                                        <a href="sellars.php"><?php echo countItems('sellar_id', 'sellars') ?></a>
                                    </span>
                                 </div>
                             </div>
                           </div>

                           <div class="col-sm-12 col-md-6 col-lg-6">
                             <div class="stat st-items">
                                 <i class="fas fa-question dash_i"></i>
                                 <div class="info">
                                    <?php echo $lang['Pending sellars']; ?>
                                     <span>
                                       <?php
                                         $sql = $con->prepare("SELECT COUNT('sellar_id') From sellars WHERE Reg_status = 0");
                                         $sql->execute();
                                         $count = $sql->fetchColumn();
                                       ?>
                                         <a href="sellars.php"><?php echo $count; ?></a>
                                     </span>
                                  </div>
                              </div>
                            </div>
                         </div>
                    <?php if (! empty($rows)) { ?>
                         <div class="table-responsive">
                            <table class="main-table text-center manage_member table table-bordered">
                              <tr>
                                  <td>#ID</td>
                                  <td><?php echo $lang['Avatar']; ?></td>
                                  <td><?php echo $lang['sellar_name']; ?></td>
                                  <td><?php echo $lang['Email']; ?></td>
                                  <td><?php echo $lang['sellar_phone']; ?></td>
                                  <td><?php echo $lang['country']; ?></td>
                                  <td><?php echo $lang['Register Date']; ?></td>
                                  <td><?php echo $lang['Control']; ?></td>
                              </tr>

                          <?php  foreach($rows as $row) {

                                   echo "<tr>";
                                      echo "<td>" . $row['sellar_id'] . "</td>";
                                      echo "<td>";
                                      if (empty($row['sellar_img'])) {
                                          echo "<img src='upload/avatars/avatar2.png' alt='' />";
                                      } else {
                                          echo "<img src='upload/sellars/" . $row['sellar_img'] . "' alt='sellar iamge' />";
                                      }

                                      echo "</td>";

                                      echo "<td>" . $row['sellar_name']   . "</td>";
                                      echo "<td>" . $row['sellar_mail']   . "</td>";
                                      echo "<td>" . $row['sellar_phone']  . "</td>";
                                      echo "<td>" . $row['coun_name']          . "</td>";
                                      echo "<td>" . $row['date_register'] . "</td>";
                                      echo "<td>
                                          <a href='sellars.php?do=Edit&sellarid= "  . $row['sellar_id'] . "' class='btn btn-success'><i class='fa fa-edit'></i>  " . $lang['Edit'] . "</a>
                                          <a href='sellars.php?do=Delete&sellarid= " . $row['sellar_id'] . "' class='btn btn-danger confirm'><i class='fas fa-times'></i>  " . $lang['Delete'] . "</a>";
                                          if ($row['Reg_status'] == 0) {
                                            echo "<a href='sellars.php?do=Activate&sellarid= " . $row['sellar_id'] . "'' class='btn btn-info activate'><i class='fa fa-check'></i> " . $lang['Activate'] . "</a>";
                                          }
                                     echo "</td>";
                                   echo "</tr>";
                               } ?>

                           </table>
                             
                                 <div class="news">
                                     <div class="head-new">
                                       <i class="fas fa-tachometer-alt"></i>
                                       <h3>Quick report last 24 hours</h3>
                                     </div>
                                     <marquee behavior="scroll" scrollamount="1" direction="left" width="100%">
                                       <?php
                                         // first statment to get any sellars added in last 24 hours
                                         $stmt= $con->prepare("SELECT * FROM sellars WHERE TIMESTAMPDIFF(HOUR, date_register, NOW()) < 24; ORDER BY sellar_id ASC");
                                         $stmt->execute();
                                         $sellars = $stmt->fetchAll(); 
                                         if (!empty($sellars)) {
                                          foreach($sellars as $sellar) {
                                            echo "A new sellar was added with the name: <b><span class='red'>" . $sellar['srllar_name'] . "</span></b> at: <span class='red'><b>" . $sellar['date_register'] . '</span></b> - ';  
                                          } 
                                         } else {
                                           echo "No any new sellar added in last 24 Hours - ";
                                         } 
                                                 
                                         // second statment to get any sellars approved in last 24 hours
                                         $sql = $con->prepare("SELECT * FROM sellars WHERE Reg_status = 1 AND TIMESTAMPDIFF(HOUR, approve_date, NOW()) < 24; ORDER BY sellar_id ASC");
                                         $sql->execute();
                                         $sellarsApp = $sql->fetchAll();
                                         
                                        if (!empty($sellarsApp)) {
                                          foreach($sellarsApp as $sellarA) {
                                            echo "New admin is approved with the name: <b><span class='red'>" . $sellarA['sellar_name'] . "</span></b> at:" . $sellarA['approve_date'] . " today - ";  
                                          }
                                        } else {
                                            echo "Not found any approved sellars last 24 hours! - ";
                                        }
                                                 
                                         // Thirs statment to get any products edit in last 24 hours
                                         $sql = $con->prepare("SELECT * FROM sellars WHERE TIMESTAMPDIFF(HOUR, edit_date, NOW()) < 24; ORDER BY sellar_id ASC");
                                         $sql->execute();
                                         $sellarsEdit = $sql->fetchAll();
                                         
                                        if (!empty($sellarsEdit)) {
                                          foreach($sellarsEdit as $sellarE) {
                                            echo "New sellar is edit with the name: <b><span class='red'>" . $sellarE['sellar_name'] . "</span></b> at:" . $sellarE['edit_date'] . " - ";  
                                          }
                                        } else {
                                            echo "Not found any edits sellars last 24 hours! - ";
                                        }
                                         ?>
                                     </marquee>
                                 </div>
                             
                                <a href = 'sellars.php?do=Add'
                                   class="btn btn-danger">
                                <i class="fa fa-plus"></i>  <?php echo $lang['Add New Sellar']; ?></a>
                            </div>
                          <?php } else {

                                echo '<div class="container container-special">';
                                    echo "<div class='alert alert-danger'><b><i class='fas fa-exclamation-circle' style='padding: 10px;''></i> " . $lang['Sorry Not Found Any Record To Show'] . "</b></div>";

                                echo "<a
                                       href = 'sellars.php?do=Add'
                                       class='btn btn-danger'>
                                       <i class='fa fa-plus'></i> ". $lang['Add New Sellar'] . "</a>";
                                echo "</div>";
                            } ?>

                       </div>

        <?php } elseif ($do == 'Add') {  // Add New Member ?>

                        <h1 class="text-center global-h1"><?php echo $lang['Add New Sellar']; ?></h1>

                        <div class="container container-special form-content">
                            <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
                                <!-- Start sellar name Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['sellar_name']; ?><h5>
                                          <input type="text" name="sellar_name" class="form-control" value="<?php echo isset($_POST["sellar_name"]) ? $_POST["sellar_name"] : ''; ?>" autocomplete= "off" required='required' placeholder="<?php echo $lang['sellar_name']; ?>" />
                                        </div>
                                    </div>
                                <!-- End sellar name Field -->

                                <!-- Start sellar mail Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['Email']; ?><h5>
                                          <input type="email" name="sellar_mail" class="form-control" value="<?php echo isset($_POST["sellar_mail"]) ? $_POST["sellar_mail"] : ''; ?>" autocomplete= "off" required='required' placeholder="<?php echo $lang['Email']; ?>" />
                                        </div>
                                    </div>
                                <!-- End sellar mail Field -->

                                <!-- Start  Password Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['password']; ?><h5>
                                          <input type="Password" name="password" class="password form-control" value="<?php echo isset($_POST["password"]) ? $_POST["password"] : ''; ?>" autocomplete="new-password" required='required' placeholder="<?php echo $lang['password']; ?>"/>
                                          <i class="show-pass fa fa-eye fa-2x"></i>
                                        </div>
                                    </div>
                                <!-- End  Password Field -->

                                <!-- Start phone Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['sellar_phone']; ?><h5>
                                          <input type="text" name="phone" class="phone form-control" value="<?php echo isset($_POST["phone"]) ? $_POST["phone"] : ''; ?>" autocomplete="off" required='required' placeholder="<?php echo $lang['sellar_phone']; ?>"/>
                                        </div>
                                    </div>
                                <!-- End phone Field -->

                                <!-- Start country filed -->
                                <div class="form-group form-group-lg">
                                    <div class="col-12">
                                      <h5><?php echo $lang['country']; ?></h5>
                                        <select class="form-control" name="country" required>
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

                                <!-- Start image Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['Avatar']; ?><h5>
                                          <input type="file" name="avatar" class="form-control" required='required' placeholder="<?php echo $lang['Avatar']; ?>"/>
                                        </div>
                                    </div>
                                <!-- End image Field -->

                                <!-- Start  submit Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <input type="submit" value="<?php echo $lang['Add New Sellar']; ?>" class="btn btn-danger btn-block" />
                                        </div>
                                    </div>
                                <!-- End  submit Field -->

                            </form>
                        </div>

                  <?php

                 } elseif ($do == 'Insert') {

                  // Insert Member Page


            if($_SERVER['REQUEST_METHOD'] == 'POST') {

               echo "<h1 class='text-center global-h1'>" . $lang['Insert sellar'] . "</h1>";
               echo "<div class='container'>";

                // Upload Variables
                $avatar     = $_FILES['avatar'];
                $avatarName = $_FILES['avatar']['name'];
                $avatarSize = $_FILES['avatar']['size'];
                $avatarTmp  = $_FILES['avatar']['tmp_name'];
                $avatarType = $_FILES['avatar']['type'];

                // List Odf Allowed File Typed To Upload
                $avatarAllowedExtention = array("jpeg", "jpg", "png", "gif");

                // Get Avatar Extention
                $avatarEtention = strtolower(end(explode('.', $avatarName)));

                // Get Variable From The Form
                $sellar_name       = $_POST['sellar_name'];
                $sellar_mail       = $_POST['sellar_mail'];
                $pass              = $_POST['password'];
                $country           = $_POST['country'];
                $phone             = $_POST['phone'];
                $hashpass          = sha1($pass);


                // Validate The Form
                $formErrors = array();
                if (strlen($sellar_name) < 4) { $formErrors[] = 'Username Can\'t Be Less Than<strong> 4 </strong> Characters'; }
                if (strlen($sellar_name) > 20) { $formErrors[] = 'Username Can\'t Be More Than <strong> 20 </strong>Characters'; }
                if (empty($sellar_name)) { $formErrors[] = 'Username Can\'t Be <strong> Empty </strong>'; }
                if (empty($phone) || !is_numeric($phone)) { $formErrors [] = 'Phone is not valid'; }
                if (empty($pass)) { $formErrors[] = 'Password Can\'t Be Less Than<strong> 8 </strong>'; }
                if (empty($sellar_mail)) { $formErrors[] = 'Email Can\'t Be <strong> Empty </strong>'; }
                if (! empty($avatarName) && ! in_array($avatarEtention, $avatarAllowedExtention)) { $formErrors[] = 'This Extention Is Not <strong> Allowed </strong>'; }
                if (empty($avatarName)) { $formErrors[] = 'Avatar is <strong> Required </strong>'; }
                if ($avatarSize > 4194304) { $formErrors[] = 'Avatar Can\'t Larger Than <strong> 4MB </strong>'; }
                // Check If There's No Proceed The Update Operation
                if (empty($formErrors)) {

                  $avatar = rand(0, 1000000) . '_' . $avatarName;
                  move_uploaded_file($avatarTmp, "upload\sellars\\" . $avatar);
                  // Check If User Exist In Database
                  $check = checkItem("sellar_name", "sellars", $sellar_name);  // خاصة بفنكشن التشيك على الاسم اذا كان موجود أم لا
                    if ($check == 1) {
                        $theMsg =  "<div class='alert alert-danger'>" . $lang['Sorry This sellar Is Exist'] . "</div>";
                        redirectHome($theMsg, 'back');
                    } else {

                         // Insert UserInfo In DB
                        $sql = $con->prepare("INSERT INTO
                                            sellars(sellar_name, sellar_mail, sellar_phone, sellar_pass, country_id, sellar_img, date_register)
                                            VALUES(:zuser, :zmail, :zphone, :zpass, :zcountry, :zavatar, now())");
                        $sql->execute(array (
                            'zuser'     => $sellar_name,
                            'zmail'     => $sellar_mail,
                            'zpass'     => $hashpass,
                            'zphone'    => $phone,
                            'zcountry'  => $country,
                            'zavatar'   => $avatar
                        ));

                          echo "<div class='container'>";
                           // Echo Success Message
                           $theMsg = "<div class='alert alert-success text-center'>" . $sql->rowCount() . $lang['Record Inserted'] . '</div>';
                           redirectHome($theMsg, 'back');
                          echo '</div>';
                       }


                } else {
                  echo "<div class='container container-special'>";
                     // Loop Into Errors Array And Echo It
                    foreach($formErrors as $error) { echo  '<div class="alert alert-danger text-left">' . $error . '</div>'; }
                    $theMsg = '';
                    redirectHome($theMsg, 'back');

                  echo '</div>';
                }

            } else {
                $theMsg =  '<div class="alert alert-danger text-left">' . $lang['Sorry you Can\'t Enter To This Page'] . '</div>';
                redirectHome($theMsg);
            }


          echo "</div>";

        } elseif ($do == 'Edit') {  // Edit Page

                    // Check If Get Request sellarid Is Numeric & Get The Integer Value It
                    $sellarid = isset($_GET['sellarid']) && is_numeric($_GET['sellarid']) ? intval($_GET['sellarid']) : 0;

                    // Select All Data Depend On This ID
                    $sql   = $con->prepare("SELECT * FROM sellars WHERE sellar_id = ? LIMIT 1");

                    // Execute Query
                    $sql->execute(array($sellarid));

                    // Fetch The Data
                    $row = $sql->fetch();

                    // The Row Count
                    $count = $sql->rowCount();

                    // If There Is Such ID Show The Form
                  if($count > 0) { ?>

                        <h1 class="text-center global-h1"><?php echo $lang['Edit Sellar']; ?></h1>

                        <div class="container container-special form-content">
                            <form class="form-horizontal" action="?do=Update" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="sellarid" value="<?php echo $sellarid ?>" />

                                <!-- Start sellar name Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['sellar_name']; ?><h5>
                                          <input type="text" name="sellar_name" class="form-control" autocomplete= "off" required='required' placeholder="<?php echo $lang['sellar_name']; ?>" value="<?php echo $row['sellar_name']; ?>" />
                                        </div>
                                    </div>
                                <!-- End sellar name Field -->

                                <!-- Start sellar mail Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['Email']; ?><h5>
                                          <input type="email" name="sellar_mail" class="form-control" autocomplete= "off" required='required' placeholder="<?php echo $lang['Email']; ?>" value="<?php echo $row['sellar_mail']; ?>" />
                                        </div>
                                    </div>
                                <!-- End sellar  mail Field -->

                                <!-- Start  Password Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                           <h5><?php echo $lang['password']; ?><h5>
                                           <input type="hidden" name="oldPassword" value="<?php echo $row['sellar_password'] ?>" />
                                           <input type="Password" name="newPassword" class="password form-control" autocomplete="new-password" placeholder="<?php echo $lang['password']; ?>"/>
                                           <i class="show-pass fa fa-eye fa-2x"></i>
                                        </div>
                                    </div>
                                <!-- End  Password Field -->

                                <!-- Start phone Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['sellar_phone']; ?><h5>
                                          <input type="text" name="phone" class="phone form-control" autocomplete="off" required='required' placeholder="<?php echo $lang['sellar_phone']; ?>" value="<?php echo $row['sellar_phone']; ?>"/>
                                        </div>
                                    </div>
                                <!-- End phone Field -->

                                <!-- Start country filed -->
                                <div class="form-group form-group-lg">
                                    <div class="col-12">
                                      <h5><?php echo $lang['Country']; ?></h5>
                                        <select class="form-control" name="country" required>
                                          <option value="0"><?php echo $lang['Country']; ?></option>
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
                                <!-- End country filed -->

                                <!-- Start image Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['Avatar']; ?><h5>
                                          <input type="file" name="avatar" class="form-control" required='required' placeholder="<?php echo $lang['Avatar']; ?>" value="<?php echo $lang['sellar_img']; ?>"/>
                                        </div>
                                    </div>
                                <!-- End image Field -->

                                <!-- Start  submit Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <input type="submit" value="<?php echo $lang['Add New Sellar']; ?>" class="btn btn-danger btn-block" />
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

            echo "<h1 class='text-center global-h1'>" . $lang['Update sellar'] . "</h1>";
            echo "<div class='container container-special'>";

            if($_SERVER['REQUEST_METHOD'] == 'POST') {

                // Get Variable From The Form

                $id            = $_POST['sellarid'];
                $sellar_name   = $_POST['sellar_name'];
                $sellar_mail   = $_POST['sellar_mail'];
                $phone         = $_POST['phone'];
                $country       = $_POST['country'];
                $avatar        = $_FILES['avatar'];

                $avatarName = $_FILES['avatar']['name'];
                $avatarSize = $_FILES['avatar']['size'];
                $avatarTmp  = $_FILES['avatar']['tmp_name'];
                $avatarType = $_FILES['avatar']['type'];

                // List Of Allowed File Typed To Upload
                $avatarAllowedExtention = array("jpeg", "jpg", "png", "gif");

                // Get Avatar Extention
                $avatarEtention = strtolower(end(explode('.', $avatarName)));

                // Password Trick
                $pass = '';

                if (empty($_POST['newPassword'])) {
                    $pass = $_POST['oldPassword'];
                } else {
                    $pass = sha1($_POST['newPassword']);
                }

                // Validate The Form
                $formErrors = array();
                if (strlen($sellar_name) < 4) { $formErrors[] = 'sellar name Can\'t Be Less Than<strong> 4 </strong> Characters'; }
                if (strlen($sellar_name) > 20) { $formErrors[] = 'sellar name Can\'t Be More Than <strong> 20 </strong>Characters'; }
                if (empty($sellar_name)) { $formErrors[] = 'sellar name Can\'t Be <strong> Empty </strong>'; }
                if (empty($avatar)) { $formErrors[] = 'Avatar sellar Can\'t Be <strong> Empty </strong>'; }
                if (empty($sellar_mail)) { $formErrors[] = 'Email Can\'t Be <strong> Empty </strong>'; }
                if (empty($phone) || !is_numeric($phone) || strlen($phone) < 11) { $formErrors[] = 'Phone Not Valid'; }
                if (! empty($avatarName) && ! in_array($avatarEtention, $avatarAllowedExtention)) { $formErrors[] = 'This Extention Is Not <strong> Allowed </strong>'; }
                if (empty($avatarName)) { $formErrors[] = 'Avatar is <strong> Required </strong>'; }
                if ($avatarSize > 4194304) { $formErrors[] = 'Avatar Can\'t Larger Than <strong> 4MB </strong>'; }

                // Check If There's No Proceed The Update Operation
                if (empty($formErrors)) {

                    $stmt = $con->prepare("SELECT
                                                  *
                                            FROM
                                                  sellars
                                            WHERE
                                                  sellar_name = ?
                                            AND
                                                  sellar_id != ?");
                        $stmt->execute(array($sellar_name, $id));
                        $count = $stmt->rowCount();


                    if ($count == 1) {
                        echo "<div class='alert alert-danger'>" . $lang['Sorry This Name IS Exit'] . "</div>";
                        redirectHome($theMsg, 'back');

                    } else {

                      $avatar = rand(0, 1000000) . '_' . $avatarName;

                      move_uploaded_file($avatarTmp, "upload\sellars\\" . $avatar);
                     // Update The Database With This Information

                      $sql = $con->prepare("UPDATE sellars SET sellar_name = ?, sellar_mail = ?, sellar_password = ?, sellar_phone = ?, country_id = ?, avatar = ? WHERE sellar_id = ? LIMIT 1");
                      $sql->execute(array($sellar_name, $sellar_mail, $pass, $phone, $country, $avatar, $id ));

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

                  echo "<h1 class='text-center global-h1'>" . $lang['Delete sellar'] . "</h1>";

                  echo "<div class='container container-special'>";

                        // Check If Get Request Userid Is Numeric & Get The Integer Value It
                       $sellarid = isset($_GET['sellarid']) && is_numeric($_GET['sellarid']) ? intval($_GET['sellarid']) : 0;

                        // Select All Data Depend On This ID
                        $check = checkItem('sellar_id', 'sellars', $sellarid);

                        // If There Is Such ID Show The Form
                      if($check > 0) {

                          $sql = $con->prepare('DELETE FROM sellars WHERE sellar_id = :zsellar');
                          $sql->bindparam(":zsellar", $sellarid);    // ربطهم ببعض
                          $sql-> execute();
                          $theMsg = "<div class='alert alert-success text-center'>" . $sql->rowCount() . $lang['Delete Record'] . '</div>';
                          redirectHome($theMsg, 'back');

                      } else {

                          $theMsg = '<div class="alert alert-danger text-left">' . $lang['This Id Not Exist'] . '</div>';
                          redirectHome($theMsg);
                      }

                  echo "</div>";

             } elseif ($do =='Activate') {


                  echo "<h1 class='text-center global-h1'>" . $lang['Activate sellar'] . "</h1>";
                  echo "<div class='container container-special'>";

                        // Check If Get Request Userid Is Numeric & Get The Integer Value It
                      $sellarid = isset($_GET['sellarid']) && is_numeric($_GET['sellarid']) ? intval($_GET['sellarid']) : 0;

                        // Select All Data Depend On This ID
                      $check = checkItem('sellar_id', 'sellars', $sellarid);

                        // If There Is Such ID Show The Form
                      if($check > 0) {

                          $sql = $con->prepare("UPDATE sellars SET Reg_status = 1 WHERE sellar_id = ?");
                          $sql-> execute(array($sellarid));
                          $theMsg = "<div class='alert alert-success text-center'>" . $sql->rowCount() . $lang['Record Update'] . '</div>';
                           redirectHome($theMsg, 'back');

                      } else {

                          $theMsg = '<div class="alert alert-danger">' . $lang['This Id Not Exist'] . '</div>';
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

?>