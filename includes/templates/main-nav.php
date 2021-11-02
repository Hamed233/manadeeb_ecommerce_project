<header class="header-area">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
     <div class="container header-con">
      <a class="navbar-brand" href="index.php"><span>M</span></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="index.php"><?php echo $lang['Home']; ?> <span class="sr-only">(current)</span></a>
          </li>
          <?php if (!(isset($_SESSION['sellar']) || isset($_SESSION['customer']))) { ?>
          <li class="nav-item">
            <a class="nav-link login_sellar" href="sellar.php?do=login"><?php echo $lang['Sell on Manadeeb']; ?></a>
          </li>
          <?php } ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="categories.php" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?php echo $lang['categories']; ?>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <?php $getAllCat = getAllFrom("*", "categories", "WHERE visibilty = 0", "", "c_id");
              foreach ($getAllCat as $cat) { ?>
                <a class="dropdown-item" href="categories.php?catid=<?php echo $cat['c_id'] . '&catname=' . preg_replace('/\s+|&/', '%', $cat['c_name']); ?>"><?php echo $cat['c_name']; ?></a>
            <?php } ?>
            </div>
          </li>
        </ul>

        <form class="form-inline my-2 my-lg-0" action="result_search.php" method="get">
          <input class="form-control mr-sm-2" type="search" name="s" value="<?php echo isset($_GET['s']) ? $_GET['s'] : ''; ?>" placeholder="Search" aria-label="Search">
          <i class="fas fa-search"></i>
        </form>



         <ul class="navbar-nav">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?php
                if (isset($_GET['lang'])) {
                  if ($_GET['lang'] == 'ar') { ?>
                     <div class="d-inline"><img src="layout/images/egypt.png" alt="arabic"><?php echo $lang['Arabic']; ?></div>
            <?php } elseif ($_GET['lang'] == 'en') { ?>
                     <div class="d-inline"><img src="layout/images/USA.png" alt="english"><?php echo $lang['English']; ?></div>
                <?php } elseif ($_GET['lang'] == 'ardo') { ?>
                    <!-- <div class="d-inline"><img src="layout/images/ardo.png" alt="ardo"><?php echo $lang['ardo']; ?></div> -->
       <?php } else { ?>
                    <div class="d-inline"><img src="layout/images/USA.png" alt="english"><?php echo $lang['English']; ?></div>
        <?php  }
      } else { ?>
        <div class="d-inline"><?php echo $_SESSION['lang']; ?></div>
  <?php } ?>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="<?php if ($_SERVER['REQUEST_URI'] == '/manadeeb/front-area/index.php' || $_SERVER['REQUEST_URI'] == '/manadeeb/front-area/cart.php') { echo '?lang=ar'; } else { echo '?lang=ar'; } ?>"><img src="layout/images/egypt.png" alt="arabic"><?php echo $lang['Arabic']; ?></a>
              <a class="dropdown-item" href="<?php if ($_SERVER['REQUEST_URI'] == '/manadeeb/front-area/index.php' || $_SERVER['REQUEST_URI'] == '/manadeeb/front-area/cart.php') { echo '?lang=ar'; } else { echo '?lang=en'; } ?>"><img src="layout/images/USA.png" alt="english"><?php echo $lang['English']; ?></a>
              <!-- <a class="dropdown-item" href="<?php if ($_SERVER['REQUEST_URI'] == '/manadeeb/front-area/index.php' || $_SERVER['REQUEST_URI'] == '/manadeeb/front-area/cart.php') { echo '?lang=ar'; } else { echo '?lang=ardo'; } ?>"><img src="layout/images/ardo.png" alt="ardo"><?php echo $lang['ardo']; ?></a> -->
            </div>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="help.php?kind=Customer-services" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?php echo $lang['help']; ?>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="help.php?kind=Customer-services"><?php echo $lang['customers service']; ?></a>
              <a class="dropdown-item" href="help.php?kind=disputes"><?php echo $lang['Disputes']; ?></a>
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
                     <a class="btn btn-danger btn_join" href="log-sign.php?do=SignUp"><?php echo $lang['Join']; ?></a>
                     <a class="btn btn-outline-danger " href="log-sign.php?do=Signin"><?php echo $lang['Signin']; ?></a>
                   <?php } else { ?>
                      <p><a class="dropdown-item" href="logout.php"><?php echo $lang['logout']; ?></a></p>
            <?php } ?>
                <?php if (isset($_SESSION['sellar'])) { ?>
                    <p><a class="dropdown-item" href="sellar.php?do=myDashboard"><?php echo $lang['My Dashboard']; ?></a></p>
              <?php }
                 if (isset($_SESSION['customer'])) { ?>
                   <p><a class="dropdown-item" href="order.php?do=my_orders&customerid=<?php echo $_SESSION['cus_id']; ?>"><?php echo $lang['My order']; ?></a></p>
             <?php } ?>
                </div><!-- .acc-content -->
          </li>
        </ul>

          <div id="cartIcon">
             <a href="cart.php">
               <i class="fa fa-shopping-cart"></i>
               <span id="cart-quantity" class="cart-quantity">
            <?php if (isset($_SESSION['cart']) && isset($_SESSION['customer']) || isset($_SESSION['sellar'])){
                    $cou_cart = countItems("p_c_id", "store_cart_item");
                    echo $cou_cart;
                } else {
                    echo "0";
                } ?>
              </span>
             </a>
         </div>
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


<?php if (!isset($no_ads)) { ?>

        <div class="container">
          <div class="container-header">
            <div class="row">
                <div class="col-sm-12 col-md-3 col-lg-3">
                    <div class="header-brand">
                        <div class="h-brand">
                         <h2><?php echo $lang['Manadeeb']; ?></h2>
                         <p><?php echo $lang['Shopping Best & more Intelligent']; ?></p>
                        </div>
                    </div><!-- .header-brand -->
                </div>
                <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 ads" style="padding-right: 0;">
                  <div class="ads top-bannar">
                   <img src="<?php echo $img; ?>ads_space.jpg" alt="ads" />
                  </div>
                </div>
            </div>
        </div>
    </div>

<?php } ?>


</header>
