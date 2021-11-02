<?php

    /*
    ======================================================
    == Manage Admins Page
    ======================================================
    */

    ob_start();
    $pageTitle = 'Admins Manage';
    include 'init.php';

          if (isset($_SESSION['adm_name'])) {

             $do = isset($_GET['do']) ? ($_GET['do']) : 'Manage';

              // Start Manage Page

              if ($do == 'Manage') { // Manage Page

                  // Select All Admins

                   $sql = $con->prepare("SELECT * FROM admins ORDER BY adm_id DESC");
                   $sql->execute();
                   $rows = $sql->fetchAll(); ?>


                  <h2 class="text-center global-h1"><?php echo $lang['Admins']; ?></h2>
                        <div class="container-fluid admins">
                            <div class="stat st-items">
                                <i class="fas fa-users-cog dash_i"></i>
                                <div class="info">
                                   <?php echo $lang['Total admins']; ?>
                                    <span>
                                        <a href="admins.php"><?php echo countItems('adm_id', 'admins') ?></a>
                                    </span>
                                 </div>
                             </div>
                  <?php  if (! empty($rows)) { ?>

                            <div class="table-responsive">
                                <table class="main-table text-center manage_member table table-bordered">
                                    <tr>
                                        <td>#ID</td>
                                        <td><?php echo $lang['Avatar']; ?></td>
                                        <td><?php echo $lang['admin_name']; ?></td>
                                        <td><?php echo $lang['Email']; ?></td>
                                        <td><?php echo $lang['admin_phone']; ?></td>
                                        <td><?php echo $lang['Register Date']; ?></td>
                                        <td><?php echo $lang['Control']; ?></td>
                                    </tr>

                                    <?php

                                         foreach($rows as $row) {

                                             echo "<tr>";
                                                echo "<td>" . $row['adm_id'] . "</td>";
                                                echo "<td>";
                                                if (empty($row['avatar'])) {
                                                    echo "<img src='upload/avatars/avatar2.png' alt='admin avatar' />";
                                                } else {
                                                    echo "<img src='upload/avatars/" . $row['avatar'] . "' alt='admin avatar' />";
                                                }

                                                echo "</td>";

                                                echo "<td>" . $row['adm_full_name'] . "</td>";
                                                echo "<td>" . $row['adm_mail']    . "</td>";
                                                echo "<td>" . $row['adm_phone']    . "</td>";
                                                echo "<td>" . $row['timestamp']     . "</td>";
                                                echo "<td>
                                                    <a href='admins.php?do=Edit&adminid= "  . $row['adm_id'] . "' class='btn btn-success'><i class='fa fa-edit'></i>  " . $lang['Edit'] . "</a>
                                                    <a href='admins.php?do=Delete&admid= " . $row['adm_id'] . "' class='btn btn-danger confirm'><i class='fas fa-times'></i>  " . $lang['Delete'] . "</a>";
                                                    if ($row['adm_status'] == 0) {
                                                      echo "<a href='admins.php?do=Activate&admid= " . $row['adm_id'] . "'' class='btn btn-info activate'><i class='fa fa-check'></i> Activate  </a>";
                                                    }
                                               echo "</td>";
                                             echo "</tr>";
                                         }


                                        ?>

                                </table>
                                 <div class="news">
                                     <div class="head-new">
                                       <i class="fas fa-tachometer-alt"></i>
                                       <h3>Quick report last 24 hours</h3>
                                     </div>
                                     <marquee behavior="scroll" scrollamount="1" direction="left" width="100%">
                                       <?php
                                         // first statment to get any admins added in last 24 hours
                                         $stmt= $con->prepare("SELECT * FROM admins WHERE TIMESTAMPDIFF(HOUR, timestamp, NOW()) < 24; ORDER BY adm_id ASC");
                                         $stmt->execute();
                                         $admins = $stmt->fetchAll(); 
                                         if (!empty($admins)) {
                                          foreach($admins as $admin) {
                                            echo "A new admin was added with the name: <b><span class='red'>" . $admin['adm_full_name'] . "</span></b> at: <span class='red'><b>" . $admin['timestamp'] . '</span></b> - ';  
                                          } 
                                         } else {
                                           echo "No any new admins added in last 24 Hours ";
                                         } 
                                                 
                                         // second statment to get any admins approved in last 24 hours
                                         $sql = $con->prepare("SELECT * FROM admins WHERE adm_status = 1 AND TIMESTAMPDIFF(HOUR, approve_date, NOW()) < 24; ORDER BY adm_id ASC");
                                         $sql->execute();
                                         $adminsApp = $sql->fetchAll();
                                         
                                        if (!empty($adminsApp)) {
                                          foreach($adminsApp as $adminapp) {
                                            echo "New admin is approved with the name: <b><span class='red'>" . $adminapp['adm_full_name'] . "</span></b> at:" . $adminapp['approve_date'] . " today - ";  
                                          }
                                        } else {
                                            echo "Not found any approved admins last 24 hours! ";
                                        }
                                                 
                                         // Thirs statment to get any products edit in last 24 hours
                                         $sql = $con->prepare("SELECT * FROM admins WHERE TIMESTAMPDIFF(HOUR, edit_date, NOW()) < 24; ORDER BY adm_id ASC");
                                         $sql->execute();
                                         $adminsEdit = $sql->fetchAll();
                                         
                                        if (!empty($adminsEdit)) {
                                          foreach($adminsEdit as $adminE) {
                                            echo "New admin is edit with the name: <b><span class='red'>" . $adminE['adm_full_name'] . "</span></b> at:" . $adminE['edit_date'] . " - ";  
                                          }
                                        } else {
                                            echo "Not found any edits admins last 24 hours! ";
                                        }
                                         ?>
                                     </marquee>
                                 </div>
                                <a href = 'admins.php?do=Add'
                                   class="btn btn-danger">
                                <i class="fa fa-plus"></i>  <?php echo $lang['Add New Admin']; ?></a>
                            </div>
                          <?php } else {

                                echo '<div class="container container-special">';
                                    echo "<div class='alert alert-danger'><b><i class='fas fa-exclamation-circle' style='padding: 10px;''></i> " . $lang['Sorry Not Found Any Record To Show'] . "</b></div>";

                                echo "<a
                                       href = 'admins.php?do=Add'
                                       class='btn btn-danger'>
                                       <i class='fa fa-plus'></i> ". $lang['Add New Admin'] . "</a>";
                                echo "</div>";


                            } ?>
                        </div>




        <?php } elseif ($do == 'Add') {  // Add New Member ?>

                        <h1 class="text-center global-h1"><?php echo $lang['Add New Admin']; ?></h1>

                        <div class="container container-special form-content">
                            <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
                                <!-- Start admin name Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['admin_name']; ?><h5>
                                          <input type="text" name="adm_name" class="form-control" value="<?php echo isset($_POST["adm_name"]) ? $_POST["adm_name"] : ''; ?>" autocomplete= "off" required='required' placeholder="<?php echo $lang['admin_name']; ?>" />
                                        </div>
                                    </div>
                                <!-- End admin name Field -->

                                <!-- Start admin mail Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['Email']; ?><h5>
                                          <input type="email" name="adm_mail" class="form-control" value="<?php echo isset($_POST["adm_mail"]) ? $_POST["adm_mail"] : ''; ?>" autocomplete= "off" required='required' placeholder="<?php echo $lang['Email']; ?>" />
                                        </div>
                                    </div>
                                <!-- End admin mail Field -->

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
                                          <h5><?php echo $lang['admin_phone']; ?><h5>
                                          <input type="text" name="phone" class="phone form-control" value="<?php echo isset($_POST["phone"]) ? $_POST["phone"] : ''; ?>" autocomplete="off" required='required' placeholder="<?php echo $lang['admin_phone']; ?>"/>
                                        </div>
                                    </div>
                                <!-- End phone Field -->

                                <!-- Start image Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['Avatar']; ?><h5>
                                          <input type="file" name="avatar" class="form-control"  required='required' placeholder="<?php echo $lang['Avatar']; ?>"/>
                                        </div>
                                    </div>
                                <!-- End image Field -->

                                <!-- Start  submit Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <input type="submit" value="<?php echo $lang['Add New Admin']; ?>" class="btn btn-danger btn-block" />
                                        </div>
                                    </div>
                                <!-- End  submit Field -->

                            </form>
                        </div>

                  <?php

                 } elseif ($do == 'Insert') {

                  // Insert Member Page


            if($_SERVER['REQUEST_METHOD'] == 'POST') {

               echo "<h1 class='text-center global-h1'>" . $lang['Update Admin'] . "</h1>";
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

                $adm_name       = $_POST['adm_name'];
                $adm_mail       = $_POST['adm_mail'];
                $pass           = $_POST['password'];
                $phone          = $_POST['phone'];
                $hashpass       = sha1($pass);


                // Validate The Form

                $formErrors = array();

                if (strlen($adm_name) < 4) { $formErrors[] = 'Username Can\'t Be Less Than<strong> 4 </strong> Characters'; }
                if (strlen($adm_name) > 20) { $formErrors[] = 'Username Can\'t Be More Than <strong> 20 </strong>Characters'; }
                if (empty($adm_name)) { $formErrors[] = 'Username Can\'t Be <strong> Empty </strong>'; }
                if (empty($phone)) { $formErrors [] = 'Phone is empty'; }
                if (!is_numeric($phone)) { $formErrors [] = 'Phone is not valid'; }
                if (empty($pass)) { $formErrors[] = 'Password Can\'t Be Less Than<strong> 8 </strong>'; }
                if (empty($adm_mail)) { $formErrors[] = 'Email Can\'t Be <strong> Empty </strong>'; }
                if (! empty($avatarName) && ! in_array($avatarEtention, $avatarAllowedExtention)) { $formErrors[] = 'This Extention Is Not <strong> Allowed </strong>'; }
                if (empty($avatarName)) { $formErrors[] = 'Avatar is <strong> Required </strong>'; }
                if ($avatarSize > 4194304) { $formErrors[] = 'Avatar Can\'t Larger Than <strong> 4MB </strong>'; }

                // Check If There's No Proceed The Update Operation
                if (empty($formErrors)) {

                    $avatar = rand(0, 1000000) . '_' . $avatarName;

                    move_uploaded_file($avatarTmp, "upload\avatars\\" . $avatar);
                    
                    // Check If User Exist In Database
                  $check = checkItem("adm_full_name", "admins", $adm_name);  // خاصة بفنكشن التشيك على الاسم اذا كان موجود أم لا

                    if ($check == 1) {

                        $theMsg =  "<div class='alert alert-danger'>" . $lang['Sorry This Admin Is Exist'] . "</div>";
                        redirectHome($theMsg, 'back');

                    } else {

                       // Insert UserInfo In DB

                        $sql = $con->prepare("INSERT INTO
                                            admins(adm_full_name, adm_mail, adm_password, adm_phone, avatar)
                                            VALUES(:zuser, :zmail, :zpass, :zphone , :zavatar)");
                        $sql->execute(array (
                            'zuser'     => $adm_name,
                            'zmail'     => $adm_mail,
                            'zpass'     => $hashpass,
                            'zphone'    => $phone,
                            'zavatar'   => $avatar
                        ));

                          echo "<div class='container'>";
                           // Echo Success Message
                           $theMsg = "<div class='alert alert-success'>" . $sql->rowCount() . $lang['Record Inserted'] . '</div>';
                           redirectHome($theMsg, 'back');
                          echo '</div>';
                       }


                } else {
                  // Loop Into Errors Array And Echo It
                  foreach($formErrors as $error) { echo  '<div class="alert alert-danger text-left">' . $error . '</div>'; }
                  $theMsg = "";
                  redirectHome($theMsg, 'back');
                }

            } else {
                $theMsg =  '<div class="alert alert-danger text-center">' . $lang['Sorry you Can\'t Enter To This Page'] . '</div>';
                redirectHome($theMsg);
            }


          echo "</div>";




              } elseif ($do == 'Edit') {  // Edit Page


                    // Check If Get Request Userid Is Numeric & Get The Integer Value It
                   $adminid = isset($_GET['adminid']) && is_numeric($_GET['adminid']) ? intval($_GET['adminid']) : 0;

                    // Select All Data Depend On This ID
                    $sql = $con->prepare("SELECT * FROM admins WHERE adm_id = ? LIMIT 1");

                    // Execute Query
                    $sql->execute(array($adminid));

                    // Fetch The Data
                    $row = $sql->fetch();

                    // The Row Count
                    $count = $sql->rowCount();

                    // If There Is Such ID Show The Form
                  if($count > 0) { ?>

                        <h1 class="text-center global-h1"><?php echo $lang['Edit Admin']; ?></h1>

                        <div class="container container-special form-content">
                            <form class="form-horizontal" action="?do=Update" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="adminid" value="<?php echo $adminid ?>" />

                                <!-- Start admin name Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['admin_name']; ?><h5>
                                          <input type="text" name="adm_name" class="form-control" autocomplete= "off" required='required' placeholder="<?php echo $lang['admin_name']; ?>" value="<?php echo $row['adm_full_name']; ?>" />
                                        </div>
                                    </div>
                                <!-- End admin name Field -->

                                <!-- Start admin mail Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['Email']; ?><h5>
                                          <input type="email" name="adm_mail" class="form-control" autocomplete= "off" required='required' placeholder="<?php echo $lang['Email']; ?>" value="<?php echo $row['adm_mail']; ?>" />
                                        </div>
                                    </div>
                                <!-- End admin mail Field -->

                                <!-- Start  Password Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                           <h5><?php echo $lang['password']; ?><h5>
                                           <input type="hidden" name="oldPassword" value="<?php echo $row['adm_password'] ?>" />
                                           <input type="Password" name="newPassword" class="password form-control" autocomplete="new-password" placeholder="<?php echo $lang['password']; ?>" value="<?php echo $row['adm_password']; ?>"/>
                                           <i class="show-pass fa fa-eye fa-2x"></i>
                                        </div>
                                    </div>
                                <!-- End  Password Field -->

                                <!-- Start phone Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['admin_phone']; ?><h5>
                                          <input type="text" name="phone" class="phone form-control" autocomplete="off" required='required' placeholder="<?php echo $lang['admin_phone']; ?>" value="<?php echo $row['adm_phone']; ?>"/>
                                        </div>
                                    </div>
                                <!-- End phone Field -->

                                <!-- Start image Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['Avatar']; ?><h5>
                                          <input type="file" name="avatar" class="form-control" required='required' placeholder="<?php echo $lang['Avatar']; ?>" value="<?php echo $lang['avatar']; ?>"/>
                                        </div>
                                    </div>
                                <!-- End image Field -->

                                <!-- Start  submit Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <input type="submit" value="<?php echo $lang['Edit Admin']; ?>" class="btn btn-danger btn-block" />
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

            echo "<h1 class='text-center global-h1'>" . $lang['Update Admin'] . "</h1>";
            echo "<div class='container container-special'>";

            if($_SERVER['REQUEST_METHOD'] == 'POST') {

                // Get Variable From The Form
                $id         = $_POST['adminid'];
                $adm_name   = $_POST['adm_name'];
                $adm_mail   = $_POST['adm_mail'];
                $phone      = $_POST['phone'];
                $avatar     = $_FILES['avatar'];

                $avatarName = $_FILES['avatar']['name'];
                $avatarSize = $_FILES['avatar']['size'];
                $avatarTmp  = $_FILES['avatar']['tmp_name'];
                $avatarType = $_FILES['avatar']['type'];

                // List Odf Allowed File Typed To Upload
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

                if (strlen($adm_name) < 4) { $formErrors[] = 'Admin name Can\'t Be Less Than<strong> 4 </strong> Characters'; }
                if (strlen($adm_name) > 20) { $formErrors[] = 'Admin name Can\'t Be More Than <strong> 20 </strong>Characters'; }
                if (empty($adm_name)) { $formErrors[] = 'Admin name Can\'t Be <strong> Empty </strong>'; }
                if (empty($avatar)) { $formErrors[] = 'Avatar admin Can\'t Be <strong> Empty </strong>'; }
                if (empty($adm_mail)) { $formErrors[] = 'Email Can\'t Be <strong> Empty </strong>'; }
                if (empty($phone)) { $formErrors [] = 'Phone is empty'; }
                if (!is_numeric($phone)) { $formErrors [] = 'Phone is not valid'; }
                if (strlen($phone) < 10) { $formErrors[] = 'Phone is very short'; }
                if (! empty($avatarName) && ! in_array($avatarEtention, $avatarAllowedExtention)) { $formErrors[] = 'This Extention Is Not <strong> Allowed </strong>'; }
                if (empty($avatarName)) { $formErrors[] = 'Avatar is <strong> Required </strong>'; }
                if ($avatarSize > 4194304) { $formErrors[] = 'Avatar Can\'t Larger Than <strong> 4MB </strong>'; }

                // Check If There's No Proceed The Update Operation
                if (empty($formErrors)) {

                    $stmt = $con->prepare("SELECT
                                                  *
                                            FROM
                                                  admins
                                            WHERE
                                                  adm_full_name = ?
                                            AND
                                                  adm_id != ?");
                        $stmt->execute(array($adm_name, $id));
                        $count = $stmt->rowCount();


                    if ($count == 1) {
                        echo "<div class='alert alert-danger'>" . $lang['Sorry This Name IS Exit'] . "</div>";
                        redirectHome($theMsg, 'back');

                    } else {

                      $avatar = rand(0, 1000000) . '_' . $avatarName;

                      move_uploaded_file($avatarTmp, "upload\avatars\\" . $avatar);
                     // Update The Database With This Information
                      $sql = $con->prepare("UPDATE admins SET adm_full_name = ?, adm_mail = ?, adm_password = ?, adm_phone = ?, avatar = ?, edit_date = now() WHERE adm_id = ? LIMIT 1");
                      $sql->execute(array($adm_name, $adm_mail, $pass, $phone, $avatar, $id ));

                         // Echo Success Message
                        $theMsg ="<div class='alert alert-success'>" . $sql->rowCount() . $lang['Record Update'] . "</div>";
                        redirectHome($theMsg, 'back');
                    }

                  } else {
                    // Loop Into Errors Array And Echo It
                    foreach($formErrors as $error) { echo '<div class="alert alert-danger">' . $error . '</div>'; }
                    $theMsg = "";
                    redirectHome($theMsg, 'back');
                  }

            } else {
                 // Echo Danger Message

                $theMsg ="<div class='alert alert-danger text-center'>" . $lang['Sorry You Can\'t Browse This Page'] . "</div>";
                redirectHome($theMsg, 'back');
            }

        echo "</div>";

        } elseif ($do == 'Delete') { // Delet Member Page

                  echo "<h1 class='text-center global-h1'>" . $lang['Delete Admin'] . "</h1>";

                  echo "<div class='container container-special'>";

                        // Check If Get Request Userid Is Numeric & Get The Integer Value It
                       $admid = isset($_GET['admid']) && is_numeric($_GET['admid']) ? intval($_GET['admid']) : 0;

                        // Select All Data Depend On This ID
                        $check = checkItem('adm_id', 'admins', $admid);

                        // If There Is Such ID Show The Form
                      if($check > 0) {

                          $sql = $con->prepare('DELETE FROM admins WHERE adm_id = :zadm');
                          $sql->bindparam(":zadm", $admid);    // ربطهم ببعض
                          $sql-> execute();
                          $theMsg = "<div class='alert alert-success text-center'>" . $sql->rowCount() . $lang['Delete Record'] . '</div>';
                           redirectHome($theMsg, 'back');

                      } else {

                          $theMsg = '<div class="alert alert-danger text-center">' . $lang['This Id Not Exist'] . '</div>';
                          redirectHome($theMsg);
                      }

                  echo "</div>";

             } elseif ($do =='Activate') {


                  echo "<h1 class='text-center global-h1'>" . $lang['Activate Admin'] . "</h1>";
                  echo "<div class='container container-special'>";

                        // Check If Get Request Userid Is Numeric & Get The Integer Value It
                       $admid = isset($_GET['admid']) && is_numeric($_GET['admid']) ? intval($_GET['admid']) : 0;

                        // Select All Data Depend On This ID
                        $check = checkItem('adm_id', 'admins', $admid);

                        // If There Is Such ID Show The Form
                      if($check > 0) {

                          $sql = $con->prepare("UPDATE admins SET adm_status = 1, approve_date = now() WHERE adm_id = ?");
                          $sql-> execute(array($admid));
                          $theMsg = "<div class='alert alert-success text-center'>" . $sql->rowCount() . $lang['Record Update'] . '</div>';
                          redirectHome($theMsg, 'back');

                      } else {
                          $theMsg = '<div class="alert alert-danger">' . $lang['This Id Not Exist'] . '</div>';
                          redirectHome($theMsg);
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
