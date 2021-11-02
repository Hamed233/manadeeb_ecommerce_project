<?php

      $noNavbar  = '';       // Special 'Navbar'
      $pageTitle ='login admin';  // Special 'function'
      include "init.php";

       if (isset($_SESSION['adm_name'])) { header('Location: dashboard.php'); }

/* ========== Form =========== */

  //  Check If User Coming From HTTP Post Request
if($_SERVER['REQUEST_METHOD'] == 'POST'){

     $adm_name_or_mail = $_POST['adm_name_or_mail'];
     $password   = $_POST['pass'];
     $hashedPass = sha1($password);

     $formErrs = array();

     if(empty($adm_name_or_mail)) {
      $formErrs[] = 'Admin Name OR Email is Empty.';
     }

     if(empty($password)) {
      $formErrs[] = 'Admin Password is Empty.';
     }

     if(empty($formErrs)){
      $sql = $con->prepare("SELECT adm_id, adm_full_name, adm_mail, adm_password, avatar FROM admins WHERE adm_full_name = ? OR adm_mail = ? AND adm_password = ? LIMIT 1");
      $sql->execute(array($adm_name_or_mail, $adm_name_or_mail, $hashedPass));
      $row = $sql->fetch();
      $count = $sql->rowCount();

      // If count > 0 This Mean The Database Contain Record About This Username
      if($count > 0) {
          $_SESSION['adm_name'] = $row['adm_full_name'];     // Register Session username
          $_SESSION['ID']       = $row['adm_id'];   // Register Session ID
          $_SESSION['avatar']   = $row['avatar'];
          
          header('Location: dashboard.php');  // Redirect To Dashboard page
          exit();
      } else {
        $err = '<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> ' . $lang['Not Found This Mail'] . '</div>';
      }
    }
} ?>


 <form class="login" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
   <div class="form-content">
   <h2 class="main-section-header text-center"><span>M</span></h2>
     <h4 class="text-center"><?php echo $lang['Admin Login']; ?></h4>
     <input class = "form-control" type="text" id="adm_name_mail" name="adm_name_or_mail" value="<?php echo isset($_POST['adm_name_or_mail']) ? $_POST['adm_name_or_mail'] : ''; ?>" placeholder="<?php echo $lang['Username'] . " | " . $lang['Email']; ?>" autocomplete="off" required />
     <input class = "form-control password" type="password" name="pass" value="<?php echo isset($_POST['pass']) ? $_POST['pass'] : ''; ?>" placeholder="<?php echo $lang['password']; ?>" autocomplete="new-password" required />
     <i class="show-pass-log fa fa-eye fa-2x"></i>
     <input class = "btn btn-danger btn-block" type="submit" value="<?php echo $lang['Login']; ?>" name ="submit" />
     <?php 
          if(!empty($err)) { echo $err; }
         if(!empty($formErrs)) {
           foreach($formErrs as $ferror) {
            echo '<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> ' . $ferror . '</div>';
           }
         }    
     ?>
   </div>
 </form>

<?php
     // Include Footer page
    include $tpl . 'footer.php';
?>
