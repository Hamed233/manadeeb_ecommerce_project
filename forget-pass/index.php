<?php
  ob_start();
  $pageTitle = 'Reset password';
  $no_ads    = '';
  include 'init.php';
  ?>

  <!-- header -->
  <header class="header-area">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
     <div class="container header-con">
      <a class="navbar-brand" href="../index.php"><span>M</span></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="../index.php"><?php echo $lang['Home']; ?> <span class="sr-only">(current)</span></a>
          </li>
          <?php if (!(isset($_SESSION['sellar']) || isset($_SESSION['customer']))) { ?>
          <li class="nav-item">
            <a class="nav-link login_sellar" href="../sellar.php?do=login"><?php echo $lang['Sell on Manadeeb']; ?></a>
          </li>
          <?php } else {?>
            <li class="nav-item">
             <a class="nav-link login_sellar" href="../sellar.php?do=myDashboard"><?php echo $lang['My Dashboard']; ?></a>
          </li>
       <?php } ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="../categories.php" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?php echo $lang['categories']; ?>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <?php $getAllCat = getAllFrom("*", "categories", "WHERE visibilty = 0", "", "c_id");
              foreach ($getAllCat as $cat) { ?>
                <a class="dropdown-item" href="../categories.php?catid=<?php echo $cat['c_id'] . '&catname=' . preg_replace('/\s+|&/', '%', $cat['c_name']); ?>"><?php echo $cat['c_name']; ?></a>
            <?php } ?>
            </div>
          </li>
        </ul>

        <form class="form-inline my-2 my-lg-0" action="../result_search.php" method="get">
          <input class="form-control mr-sm-2" type="search" name="s" placeholder="Search" aria-label="Search">
          <i class="fas fa-search"></i>
        </form>



         <ul class="navbar-nav">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?php
                if (isset($_GET['lang'])) {
                  if ($_GET['lang'] == 'ar') { ?>
                     <div class="d-inline"><img src="../layout/images/egypt.png" alt="arabic"><?php echo $lang['Arabic']; ?></div>
            <?php } elseif ($_GET['lang'] == 'en') { ?>
                     <div class="d-inline"><img src="../layout/images/USA.png" alt="english"><?php echo $lang['English']; ?></div>
            <?php } else { ?>
                    <div class="d-inline"><img src="../layout/images/USA.png" alt="english"><?php echo $lang['English']; ?></div>
           <?php  }
      } else { ?>
        <div class="d-inline"><?php echo $_SESSION['lang']; ?></div>
  <?php } ?>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="<?php if ($_SERVER['REQUEST_URI'] == '/manadeeb/front-area/index.php' || $_SERVER['REQUEST_URI'] == '/manadeeb/front-area/cart.php') { echo '?lang=ar'; } else { echo '?lang=ar'; } ?>"><img src="../layout/images/egypt.png" alt="arabic"><?php echo $lang['Arabic']; ?></a>
              <a class="dropdown-item" href="<?php if ($_SERVER['REQUEST_URI'] == '/manadeeb/front-area/index.php' || $_SERVER['REQUEST_URI'] == '/manadeeb/front-area/cart.php') { echo '?lang=ar'; } else { echo '?lang=en'; } ?>"><img src="../layout/images/USA.png" alt="english"><?php echo $lang['English']; ?></a>
            </div>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="help.php?kind=Customer-services" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?php echo $lang['help']; ?>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="../help.php?kind=Customer-services"><?php echo $lang['customers service']; ?></a>
              <a class="dropdown-item" href="../help.php?kind=disputes"><?php echo $lang['Disputes']; ?></a>
            </div>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link account-nav dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?php echo $lang['account']; ?>
              <i class="fas fa-user"></i>
            </a>
                <div class="dropdown-menu acc-content"  aria-labelledby="navbarDropdown">
                  <p><?php
                       echo $lang['welcome in manadeeb.com'];
                       echo '<br />';
                       if (isset($_SESSION['customer'])) { echo '<br>( ' . $_SESSION['customer'] . ' )</b>'; }
                      ?>
                  </p>
                  <?php if (!isset($_SESSION['sellar']) && !isset($_SESSION['customer'])) { ?>
                     <a class="btn btn-danger btn_join" href="../log-sign.php?do=SignUp"><?php echo $lang['Join']; ?></a>
                     <a class="btn btn-outline-danger " href="../log-sign.php?do=Signin"><?php echo $lang['Signin']; ?></a>
                   <?php } else { ?>
                      <p><a class="dropdown-item" href="../logout.php"><?php echo $lang['logout']; ?></a></p>
            <?php } ?>
                <?php if (isset($_SESSION['sellar'])) { ?>
                    <p><a class="dropdown-item" href="../sellar.php?do=myDashboard"><?php echo $lang['My Dashboard']; ?></a></p>
              <?php }
                 if (isset($_SESSION['customer'])) { ?>
                   <p><a class="dropdown-item" href="../order.php?do=my_orders&customerid=<?php echo $_SESSION['cus_id']; ?>"><?php echo $lang['My order']; ?></a></p>
             <?php } ?>
                </div><!-- .acc-content -->
          </li>
        </ul>
      </div>
     </div>
    </nav>

    <?php if (isset($_SESSION['cart']) && isset($_SESSION['customer']) || isset($_SESSION['sellar'])) { ?>
       <!-- This Alert run when product add to cart -->
         <div class="cap_status"></div>
    <?php } 
    
      if(!(isset($_SESSION['customer']) || isset($_SESSION['sellar']))) { ?>
      <!-- make message, if user don't login! -->
         <div class="alert alert-primary dont_login"><i class='fas fa-exclamation-circle'></i> <?php echo $lang['Log In to see the products closest to you']; ?></div>
<?php } ?>

</header>



<?php if (isset($_POST["email"]) && !empty($_POST["email"])) {

  $formErr = array();

  $email = $_POST["email"];
  $email = filter_var($email, FILTER_SANITIZE_EMAIL);
  $email = filter_var($email, FILTER_VALIDATE_EMAIL);

  if (!$email) {
     $formErr [] = "<p>Invalid email address please type a valid email address!</p>";
  } else {
     $sel_query = $con->prepare("SELECT * FROM `customers` WHERE cus_mail= ?");
     $sel_query->execute(array($email));
     $row = $sel_query->rowCount();

     if ($row == "") {
       $formErr [] = "<p>No user is registered with this email address!</p>";
     }
  }

     if (!empty($formErr)) { ?>
       <div class="container form_r_err">
         <h3 class="text-center"><?php echo $lang['Something Wrong!']; ?></h3>
         <div class="error-content">
          <?php foreach ($formErr as $err) {
               echo "<div class='alert alert-danger'>" .$err. "</div>";
           } ?>
          <br />
          <div class="btn btn-danger"><a href='javascript:history.go(-1)'>Go Back</a></div>
        </div>
      </div>
<?php } else {
     $expFormat = mktime(
       date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y")
     );
     $expDate = date("Y-m-d H:i:s", $expFormat);
     $key = md5(2418*2);
     $addKey = substr(sha1(uniqid(rand(),1)),3,10);
     $key = $key . $addKey;

      // Insert Temp Table
      $stmt = $con->prepare("INSERT INTO `password_reset` (`email`, `p_key`, `expDate`)
      VALUES ('".$email."', '".$key."', '".$expDate."')");

      $output='<p>Dear user,</p>';
      $output.='<p>Please click on the following link to reset your password.</p>';
      $output.='<p>-------------------------------------------------------------</p>';
      $output.='<p><a href="https://manadeb.000webhostapp.com/manadeeb/forget-pass/reset-password.php?
      key='.$key.'&email='.$email.'&action=reset" target="_blank">
      https://https://manadeb.000webhostapp.com/manadeeb/forget-pass/reset-password.php
      ?key='.$key.'&email='.$email.'&action=reset</a></p>';
      $output.='<p>-------------------------------------------------------------</p>';
      $output.='<p>Please be sure to copy the entire link into your browser.
      The link will expire after 1 day for security reason.</p>';
      $output.='<p>If you did not request this forgotten password email, no action
      is needed, your password will not be reset. However, you may want to log into
      your account and change your security password as someone may have guessed it.</p>';
      $output.='<p>Thanks,</p>';
      $output.='<p>Manadeeb Team</p>';
      $body = $output;

      $to = $email;
  
      $headers = "From: $email";
      $headers = "From: " . $email . "\r\n";
      $headers .= "Reply-To: ". $email . "\r\n";
      $headers .= "MIME-Version: 1.0\r\n";
      $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

      $subject = "Password Recovery - Manadeeb.com";

      $send = mail($to, $subject, $body, $headers);

      if($send){
        echo "<div class='error'>
        <p>An email has been sent to you with instructions on how to reset your password.</p>
        </div><br /><br /><br />";
      } else {
        echo "<div class='error'>SomeThing errors!</div>";
      }
    }
      } else { ?>
        <div class="container reset-pass">
          <div class="form-container">
            <h2 class="main-section-header text-center"><span>M</span></h2>
            <p class="text-center"><?php echo $lang['reset-password']; ?></p>
              <form method="post" action="" name="reset">
                <br /><br />
                <label><?php echo $lang['Enter Your Email Address']; ?>:</label>
                <br /><br />
                <input class="form-control" type="email" name="email" placeholder="username@email.com" />
                <br /><br />
                <input class="btn btn-danger" type="submit" value="<?php echo $lang['reset-password']; ?>"/>
              </form>
          </div>
        </div>

<?php }
      include '../includes/templates/footer.php';
      ob_end_flush();
  ?>
