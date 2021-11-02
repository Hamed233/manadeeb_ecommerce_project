<?php
  ob_start();
  $pageTitle = 'Reset password';
  include '../init.php';

if (isset($_GET["key"]) && isset($_GET["email"]) && isset($_GET["action"]) && ($_GET["action"]=="reset") && !isset($_POST["action"])){

  $key   = $_GET["key"];
  $email = $_GET["email"];
  $curDate = date("Y-m-d H:i:s");

  $stmt = $con->prepare("SELECT * FROM `password_reset` WHERE `p_key`= ? and `email`= ? ");
  $stmt->execute(array($key, $email));
  $row = $stmt->rowCount();
  if ($row == ""){
  $error .= '<h2>Invalid Link</h2>
              <p>The link is invalid/expired. Either you did not copy the correct link
              from the email, or you have already used the key in which case it is
              deactivated.</p>
              <p><a href="https://www.manadeeb.com/forgot-password/index.php">
              Click here</a> to reset password.</p>';
 } else {
  $row = $stmt->fetch();

  $expDate = $row['expDate'];
  if ($expDate >= $curDate){ ?>
   <br />
   <form method="post" action="" name="update">
    <input type="hidden" name="action" value="update" />
    <br /><br />

    <label><strong>Enter New Password:</strong></label><br />
    <input type="password" name="pass1" maxlength="15" required />
    <br /><br />

    <label><strong>Re-Enter New Password:</strong></label><br />
    <input type="password" name="pass2" maxlength="15" required/>
    <br /><br />

    <input type="hidden" name="email" value="<?php echo $email;?>"/>
    <input type="submit" value="Reset Password" />
   </form>
<?php } else {
          $error .= "<h2>Link Expired</h2>
          <p>The link is expired. You are trying to use the expired link which
          as valid only 24 hours (1 days after request).<br /><br /></p>";
      }
  }

if ($error!=""){
  echo "<div class='alert alert-danger'>".$error."</div><br />";
  }
} // isset email key validate end


if(isset($_POST["email"]) && isset($_POST["action"]) && ($_POST["action"]=="update")){
  $error   ="";
  $pass1   = $_POST["pass1"];
  $pass2   = $_POST["pass2"];
  $email   = $_POST["email"];
  $curDate = date("Y-m-d H:i:s");

  if ($pass1 != $pass2){
    $error.= "<p>Password do not match, both password should be same.<br /><br /></p>";
    }
    if($error!=""){
        echo "<div class='alert alert-danger'>".$error."</div><br />";
    } else {
      $pass1 = sha1($pass1);

      $stmt = $con->prepare("UPDATE `customers` SET `cus_password`= ?, `update_date`= ? WHERE `cus_mail`= ?");
      $stmt->execute(array($pass1, $curDate, $email));

      $sql = $con->prepare("DELETE FROM `password_reset` WHERE `email`= ?");
      $sql->execute(array($email));

      echo '<div class="alert alert-danger"><p>Congratulations! Your password has been updated successfully.</p>
            <p><a href="https://www.manadeeb.com/log-sign.php">
            Click here</a> to Login.</p></div><br />';
     }
  }

  include '../' . $temp . 'footer.php';
  ob_end_flush();
?>
