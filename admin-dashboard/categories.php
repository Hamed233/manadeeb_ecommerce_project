<?php

/*
===============================
   Category Page
===============================
*/

   ob_start(); // OutPut Buffering Start
  $pageTitle = 'Categories';
  include "init.php";

 if (isset($_SESSION['adm_name'])) {
        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

        if ($do == 'Manage') {

            $sort = 'ASC';
            $sort_array = array('ASC', 'DESC');

            if (isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)) {
                $sort = $_GET['sort'];
            }

            $stmt= $con->prepare("SELECT * FROM categories ORDER BY sort_order $sort");
            $stmt->execute();
            $cats = $stmt->fetchAll(); ?>

             <h1 class='text-center global-h1'><?php echo $lang['Manage Categories']; ?></h1>
               <div class="container-fluid categories">
                 <div class="row">
                 <div class="col-sm-12 col-md-6 col-lg-6">
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
                     <div class="stat categories-count">
                         <div class="info">
                          <?php echo $lang['Total visibile Categories']; ?>
                             <span>
                               <?php

                               $sql = $con->prepare("SELECT COUNT('c_id') From categories WHERE visibilty = 0");
                               $sql->execute();
                               $count = $sql->fetchColumn();
                               ?>
                                <a href="categories.php"><?php echo $count; ?></a>
                             </span>
                         </div>
                      </div>
                   </div>
                </div>
                 <?php if (! empty($cats)) { ?>

                 <div class="table-responsive">
                     <table class="main-table text-center table table-bordered">
                         <tr>
                             <td>#ID</td>
                             <td><?php echo $lang['Category Name']; ?></td>
                             <td><?php echo $lang['Category Brand']; ?></td>
                             <td><?php echo $lang['Category Description']; ?></td>
                             <td><?php echo $lang['Visible']; ?></td>
                             <td><?php echo $lang['parent']; ?></td>
                             <td><?php echo $lang['Control']; ?></td>
                         </tr>

                         <?php

                              foreach($cats as $cat) {

                                  echo "<tr>";
                                     echo "<td>" . $cat['c_id']    . "</td>";
                                     echo "<td>" . $cat['c_name']    . "</td>";
                                     echo "<td>";
                                        if (empty($cat['c_picture'])) {
                                             echo "<b>Not Found Image.</b>";
                                         } else {
                                             echo "<img style='width: 100px; height: 100px' src='upload/categories/categories_brand/" . $cat['c_picture'] . "' alt='cat image' />";
                                         }

                                      "</td>";
                                     echo "<td>" . $cat['c_description']   . "</td>";
                                     echo "<td>";
                                       if ($cat['visibilty'] == 0) {
                                         echo "Public";
                                       } else {
                                         echo "Private";
                                       }
                                     echo "</td>";
                                     echo "<td>";

                                         $stmt= $con->prepare("SELECT * FROM categories WHERE parent = ? ORDER BY c_id ASC");
                                         $stmt->execute(array($cat['c_id']));
                                         $childCats = $stmt->fetch();

                                          if (!empty($childCats)) {
                                            echo $childCats['c_name'];
                                          } else {
                                            echo 'No Parent';
                                          }
                                       echo "</td>";
                                     echo "<td>
                                         <a href='categories.php?do=Edit&catid=" . $cat['c_id'] . "' class='btn btn-primary'><i class='fa fa-edit'></i> " . $lang['Edit'] . "</a>
                                         <a href='categories.php?do=Delete&catid=" . $cat['c_id'] . "' class='confirm btn btn-danger'><i class='fas fa-times'></i> " . $lang['Remove'] .  "</a>";
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
                          <?php
                             $stmt= $con->prepare("SELECT * FROM categories WHERE TIMESTAMPDIFF(HOUR, date_inserted, NOW()) < 24; ORDER BY c_id ASC");
                             $stmt->execute();
                             $Cats = $stmt->fetchAll();                  
                          ?>
                         <marquee behavior="scroll" scrollamount="1" direction="left" width="100%">
                           <?php
                             if (!empty($Cats)) {
                              foreach($Cats as $cat) {
                                echo "A new category was added with the name: <b><span class='red'>" . $cat['c_name'] . "</span></b> - ";  
                              } 
                             } else {
                               echo "No Any Actions in last 24 Hours";
                             } 
                             
                              // Second statment to get any categories edit in last 24 hours
                             $sql = $con->prepare("SELECT * FROM categories WHERE TIMESTAMPDIFF(HOUR, edit_date, NOW()) < 24; ORDER BY c_id ASC");
                             $sql->execute();
                             $catsEdit = $sql->fetchAll();

                            if (!empty($catsEdit)) {
                              foreach($catsEdit as $catE) {
                                echo "New Categories is edit with the name: <b><span class='red'>" . $catE['c_name'] . "</span></b> at:" . $catE['edit_date'] . " - ";  
                              }
                            } else {
                                echo "Not found any edits categories last 24 hours! - ";
                            }
                             
                             ?>
                         </marquee>
                     </div>
                   <?php } else { ?>
                            <div class="container container-special">
                             <div class='alert alert-danger' style='margin-top: 60px;'><i class='fas fa-exclamation-circle' style="padding: 10px;"></i><?php echo $lang['Sorry Not Found Any Record To Show, but you can add now.']; ?></div>
                              <a href ='categories.php?do=Add' class='btn btn-danger'>
                               <i class='fa fa-plus'></i>
                               <?php echo $lang['Add New Category']; ?>
                              </a>
                            </div>
                   <?php } ?>
                   </div>
                   <a class="add_category btn btn-primary" href="categories.php?do=Add"> <i class="fa fa-plus"></i>  <?php echo $lang['Add New Category']; ?></a>
                </div>


 <?php } elseif ($do == 'Add') { ?>

                <h1 class="text-center global-h1"><?php echo $lang['Add New Category']; ?></h1>

                <div class="container container-special form-content">
                    <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
                        <!-- Start  Name Field -->
                            <div class="form-group form-group-lg">
                                <div class="col-12">
                                  <h5><?php echo $lang['Category Name']; ?></h5>
                                  <input type="text" name="name" class="form-control" value="<?php echo isset($_POST["name"]) ? $_POST["name"] : ''; ?>" autocomplete= "off" required="required" placeholder="<?php echo $lang['Category Name']; ?>">
                                </div>
                           </div>
                        <!-- End  Name Field -->

                        <!-- Start  Description Field -->
                            <div class="form-group form-group-lg">
                                <div class="col-12">
                                   <h5><?php echo $lang['Category Description']; ?></h5>
                                   <input type="text" name="description" class="form-control" value="<?php echo isset($_POST["description"]) ? $_POST["description"] : ''; ?>" required="required" placeholder="<?php echo $lang['Category Description']; ?>"/>
                                </div>
                            </div>
                        <!-- End  Description Field -->

                        <!-- Start Categories Brand -->
                            <div class="form-group form-group-lg">
                                <div class="col-12">
                                  <h5><?php echo $lang['Category Brand']; ?></h5>
                                  <input
                                     type="file"
                                     name="cat_img"
                                     class="form-control"
                                     required="required"
                                     placeholder="<?php echo $lang['Category Brand']; ?>" />
                                </div>
                           </div>
                        <!-- End Categories Brand -->

                        <!-- Start  Ordering Field -->
                            <div class="form-group form-group-lg">
                                <div class="col-12">
                                  <h5><?php echo $lang['ordering']; ?></h5>
                                  <input type="text" name="ordering" class="form-control" value="<?php echo isset($_POST["ordering"]) ? $_POST["ordering"] : ''; ?>" placeholder="<?php echo $lang['To Arrange The Categories']; ?>" />
                                </div>
                            </div>
                        <!-- End  Ordering Field -->

                        <!-- Start category field -->
                            <div class="form-group form-group-lg">
                              <label class="col-sm-2 control-label"><?php echo $lang['Parent ?']; ?></label>
                                <div class="col-12">
                                    <select class="browser-default custom-select" name="parent">
                                        <option value="0"><?php echo $lang['None']; ?></option>
                                        <?php
                                         $allCats = getAllFrom("*", 'categories', "", "", "c_id", "ASC");
                                          foreach ($allCats as $cat) {
                                              echo "<option value= '" . $cat['c_id'] . "'>" . $cat['c_name'] . "</option>";
                                          }
                                        ?>
                                    </select>
                                </div>
                            </div>

                        <!-- End category field -->

                        <!-- Start  Visibltiy Field -->
                            <div class="form-group form-group-lg">
                              <label class="col-sm-2 control-label"><?php echo $lang['Visible']; ?></label>
                                <div class="col-12">
                                    <div>
                                      <input id="vis-yes" type="radio" name="visiblity" value="0" checked />
                                        <label for="vis-yes"><?php echo $lang['Yes']; ?></label>
                                    </div>
                                    <div>
                                      <input id="vis-no" type="radio" name="visiblity" value="1" />
                                        <label for="vis-no"><?php echo $lang['No']; ?></label>
                                    </div>
                                </div>
                            </div>
                        <!-- End  Visiblity Field -->

                        <!-- Start  submit Field -->
                            <div class="form-group form-group-lg">
                                <div class="col-12">
                                  <input type="submit" value="<?php echo $lang['Add New Category']; ?>" class="btn btn-danger btn-block" />
                                </div>
                            </div>
                        <!-- End  submit Field -->

                    </form>
                </div>


    <?php } elseif ($do == 'Insert') {

            // Insert Category Page
            if ($_SERVER['REQUEST_METHOD'] == 'POST') { ?>

              <h1 class='text-center global-h1'><?php echo $lang['Insert Category']; ?></h1>
              <div class='container container-special'>

              <?php
              // Img info
               $cateImg     = $_FILES['cat_img'];
               $cateImgName = $_FILES['cat_img']['name'];
               $cateImgSize = $_FILES['cat_img']['size'];
               $cateImgTmp  = $_FILES['cat_img']['tmp_name'];
               $cateImgType = $_FILES['cat_img']['type'];

               // List Odf Allowed File Typed To Upload
               $cateImgAllowedExtention = array("jpeg", "jpg", "png", "gif");

               // Get cateImg Extention
               $cateImgEtention = strtolower(end(explode('.', $cateImgName)));

                // Get Variable From The Form
                $name              = $_POST['name'];
                $description       = $_POST['description'];
                $visiblity         = $_POST['visiblity'];
                $order             = $_POST['ordering'];
                $parent            = $_POST['parent'];

                // Validate The Form
                $formErrors = array();
                if (empty($name) || strlen($name) < 5) { $formErrors[] = '<b>Category Name</b> very short or empty'; }
                if (empty($description) || strlen($description) < 10) { $formErrors[] = '<b>Category Description</b> very short or empty'; }
                if (! empty($cateImgName) && ! in_array($cateImgEtention, $cateImgAllowedExtention)) { $formErrors[] = 'This Extention Is Not <strong> Allowed </strong>'; }
                if (empty($cateImgName)) { $formErrors[] = '<b>Image category</b> is Required'; }
                if ($cateImgSize > 4194304) { $formErrors[] = 'This Image Can\'t Larger Than <strong> 4MB </strong>'; }

                // Check If There's No Proceed The Update Operation
                if (empty($formErrors)) {

                  $cateImg = rand(0, 1000000) . '_' . $cateImgName;

                  move_uploaded_file($cateImgTmp, "upload\categories\categories_brand\\" . $cateImg);
                    // Check If User Exist In Database
                  $check = checkItem("c_name", "categories", $name);

                    if ($check == 1) {

                        $theMsg =  "<div class='alert alert-danger text-center'><i class='fas fa-exclamation-circle' style='padding: 10px;'>" . $lang['Sorry This Category Is Exist'] . "</div>";
                        redirectHome($theMsg, 'back');

                    } else {

                        // Insert CategoryInfo In DB
                        $sql = $con->prepare("INSERT INTO
                                            categories(c_name, c_description, c_picture, sort_order, visibilty, parent)
                                            VALUES(:zname, :zdescription, :zcatImg, :order, :zavisible, :zparent)");
                        $sql->execute(array (

                            'zname'            => $name,
                            'zdescription'     => $description,
                            'zcatImg'          => $cateImg,
                            'order'            => $order,
                            'zavisible'        => $visiblity,
                            'zparent'           => $parent
                        ));

                          echo "<div class='container'>";
                           // Echo Success Message
                           $theMsg = "<div class='alert alert-success text-center' style='direction: ltr;'>" . $sql->rowCount() . ' Record Inserted</div>';
                           redirectHome($theMsg, 'back');
                          echo "</div>";
                       } // end check

                     } else {

                       // Loop Into Errors Array And Echo It
                       foreach($formErrors as $error) {
                         echo '<div class="alert alert-danger text-left" style="direction: ltr;"><i class="fas fa-exclamation-circle"></i> ' . $error . '</div>';
                       }
                       $theMsg = "";
                       redirectHome($theMsg, 'back');

                     } // end else

                   } else {
                     // Echo Failed Message
                     $theMsg = "<div class='alert alert-Danger text-center'>". $lang['Sorry Yoy Can\'t Browse This Page Directly'] . "</div>";
                     redirectHome($theMsg, 'back');
                  }

              echo "</div>"; // end insert container

        } elseif ($do == 'Edit') {


                    // Check If Get Request Catid Is Numeric & Get The Integer Value It
                   $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

                    // Select All Data Depend On This ID
                    $sql = $con->prepare("SELECT * FROM categories WHERE c_id = ? ");

                    // Execute Query
                    $sql->execute(array($catid));

                    // Fetch The Data
                    $cat = $sql->fetch();

                    // The Row Count
                    $count = $sql->rowCount();

                    // If There Is Such ID Show The Form
                  if($count > 0) { ?>

                        <h1 class="text-center global-h1"><?php echo $lang['Edit Category']; ?></h1>

                        <div class="container container-special form-content">
                            <form class="form-horizontal" action="?do=Update" method="POST" enctype="multipart/form-data">
                              <input type="hidden" name="catid" value="<?php echo $catid ?>" />
                                <!-- Start  Name Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['Category Name']; ?></h5>
                                          <input type="text" name="name" class="form-control" autocomplete= "off" required='required' placeholder="<?php echo $lang['Category Name']; ?>" value="<?php echo $cat['c_name'] ?>">
                                        </div>
                                   </div>
                                <!-- End  Name Field -->

                                <!-- Start  Description Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                           <h5><?php echo $lang['Category Description']; ?></h5>
                                           <input type="text" name="description" class="form-control" required='required' placeholder="<?php echo $lang['Category Description']; ?>" value="<?php echo $cat['c_description'] ?>"/>
                                        </div>
                                    </div>
                                <!-- End  Description Field -->

                                <!-- Start Categories Brand -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['Category Brand']; ?></h5>
                                          <input
                                             type="file"
                                             class="form-control"
                                             required="required"
                                             name="cat_img"
                                             value="<?php echo $cat['c_picture'] ?>"
                                             placeholder="<?php echo $lang['Category Brand']; ?>" />
                                        </div>
                                   </div>
                                <!-- End Categories Brand -->

                                <!-- Start  Ordering Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['ordering']; ?></h5>
                                          <input type="text" name="ordering" class="form-control" placeholder="<?php echo $lang['To Arrange The Categories']; ?>" />
                                        </div>
                                    </div>
                                <!-- End  Ordering Field -->

                                <!-- Start category field -->
                                    <div class="form-group form-group-lg">
                                      <label class="col-sm-2 control-label"><?php echo $lang['Parent ?']; ?></label>
                                        <div class="col-12">
                                            <select class="browser-default custom-select" name="parent">
                                                <option value="0"><?php echo $lang['None']; ?></option>
                                                <?php
                                                 $allCats = getAllFrom("*", 'categories', "", "", "c_id", "ASC");
                                                  foreach ($allCats as $cat) {
                                                      echo "<option value= '" . $cat['c_id'] . "'>" . $cat['c_name'] . "</option>";
                                                  }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                <!-- End category field -->

                                <!-- Start  Visibltiy Field -->
                                    <div class="form-group form-group-lg">
                                      <label class="col-sm-2 control-label"><?php echo $lang['Visible']; ?></label>
                                        <div class="col-12">
                                          <div>
                                            <input id="vis-yes" type="radio" name="visiblity" value="0" <?php if($cat['visibilty'] == '0') { echo "checked"; } ?> />
                                              <label for="vis-yes"><?php echo $lang['Yes']; ?></label>
                                          </div>
                                          <div>
                                            <input id="vis-no" type="radio" name="visiblity" value="1" <?php if($cat['visibilty'] == '1') { echo "checked"; } ?>/>
                                              <label for="vis-no" <?php if($cat['visibilty'] == 1) { echo "checked"; } ?>><?php echo $lang['No']; ?></label>
                                          </div>
                                        </div>
                                    </div>
                                <!-- End  Visiblity Field -->

                                <!-- Start  submit Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <input type="submit" value="<?php echo $lang['Update Category']; ?>" class="btn btn-danger btn-block" />
                                        </div>
                                    </div>
                                <!-- End  submit Field -->

                            </form>
                        </div>

               <?php
                // If There Is No Such ID Show Error Message
                } else {
                      echo "<div class='container container-special'>";
                      $theMsg    =  "<div class='alert alert-danger'>There is No Such Id</div>";
                      redirectHome($theMsg);
                      echo "</div>";
                }

        } elseif ($do == 'Update') {

            echo "<h1 class='text-center global-h1'>" . $lang['Update Category'] . "</h1>";
            echo "<div class='container container-special'>";

            if($_SERVER['REQUEST_METHOD'] == 'POST') {

                // Get Variable From The Form
                $id          = $_POST['catid'];
                $name        = $_POST['name'];
                $desc        = $_POST['description'];
                $visibilty   = $_POST['visiblity'];

                // Img info
                 $cateImg     = $_FILES['cat_img'];
                 $cateImgName = $_FILES['cat_img']['name'];
                 $cateImgSize = $_FILES['cat_img']['size'];
                 $cateImgTmp  = $_FILES['cat_img']['tmp_name'];
                 $cateImgType = $_FILES['cat_img']['type'];

                 // List Of Allowed File Typed To Upload
                 $cateImgAllowedExtention = array("jpeg", "jpg", "png", "gif");

                 // Get cateImg Extention
                 $cateImgEtention = strtolower(end(explode('.', $cateImgName)));

                 if (! empty($cateImgName) && ! in_array($cateImgEtention, $cateImgAllowedExtention)) { $formErrors[] = 'This Extention Is Not <strong> Allowed </strong>'; }

                 if ($cateImgSize > 4194304) { $formErrors[] = 'This Image Can\'t Larger Than <strong> 4MB </strong>'; }

                 if (strlen($name) < 5) {
                   $formErrors [] = "This category name is very short.";
                 }

                 if (strlen($desc) < 15) {
                   $formErrors [] = "This category description is very short.";
                 }

                 if (empty($formErrors)) {


                   $cateImg = rand(0, 1000000) . '_' . $cateImgName;

                   move_uploaded_file($cateImgTmp, "upload\categories\categories_brand\\" . $cateImg);


                     // Update The Database With This Information

                  $sql = $con->prepare("UPDATE
                                            categories
                                        SET
                                            c_name = ?,
                                            c_description = ?,
                                            c_picture = ?,
                                            visibilty = ?,
                                            edit_date = now()
                                        WHERE
                                             c_id = ?");
                  $sql->execute(array($name, $desc, $cateImg, $visibilty, $id));

                     // Echo Success Message

                    $theMsg ="<div class='alert alert-success text-center'>" . $sql->rowCount() . " Record Update.</div>";
                    redirectHome($theMsg, 'back');

            } else {
              foreach ($formErrors as $err) {
                $theMsg = "<div class='alert alert-danger text-center'>" . $err . "</div>";
                redirectHome($theMsg, 'back');
              }
            }

            } else {

                $theMsg   = '<div class="alert alert-danger text-center">Sorry you Can\'t Browse This Page Directory</div>';
                redirectHome($theMsg);
            }


               echo "</div>";


        } elseif ($do == 'Delete') {

                 echo "<h1 class='text-center global-h1'>" . $lang['Delete Category'] . "</h1>";
                  echo "<div class='container container-special'>";

                        // Check If Get Request Catid Is Numeric & Get The Integer Value It
                       $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

                        // Select All Data Depend On This ID
                        $check = checkItem('c_id', 'categories', $catid);

                        // If There Is Such ID Show The Form
                      if($check > 0) {
                          $sql = $con->prepare('DELETE FROM categories WHERE c_id = :zid');
                          $sql->bindparam(":zid", $catid);
                          $sql-> execute();
                          $theMsg = "<div class='alert alert-success text-center'>" . $sql->rowCount() . ' ' . $lang['Delete Record'] . '</div>';
                          redirectHome($theMsg, 'back');
                      } else {

                          $theMsg = '<div class="alert alert-danger text-center">' . $lang['This Id Not Exist'] . '</div>';
                          redirectHome($theMsg, 'back');
                      }

                  echo "</div>";
        } else {
          header('Location: index.php');
          exit();
        }

        include $tpl .'footer-copyright.php';
        include $tpl .'footer.php';

      } else {
          header('Location: index.php');
          exit();
      }

   ob_end_flush(); // Release The Output
?>