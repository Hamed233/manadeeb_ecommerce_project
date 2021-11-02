

<nav class="navbar navbar-expand-lg navbar-dark bg-danger">
  <a class="navbar-brand" href="dashboard.php">M</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="dashboard.php">Dashboard</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="categories.php">Categories</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="products.php">products</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="admins.php">Admins</a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="sellars.php">Sellars</a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="customers.php">Customers</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="orders.php">Orders</a>
      </li>
      <li class="nav-item dropdown navbar-dropdown lang-nav">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php
          if (isset($_GET['lang'])) {
            if ($_GET['lang'] == 'ar') { ?>
               <div class="d-inline"><img src="layout/images/egypt.png" alt="arabic"><?php echo $lang['Arabic']; ?></div>
          <?php } elseif ($_GET['lang'] == 'en') { ?>
               <div class="d-inline"><img src="layout/images/USA.png" alt="english"><?php echo $lang['English']; ?></div>
          <?php } else { ?>
              <div class="d-inline"><?php echo $_SESSION['lang']; ?></div>
          <?php  }
        } else { ?>
          <div class="d-inline"><?php echo $_SESSION['lang']; ?></div>
    <?php } ?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="?lang=ar"><img src="layout/images/egypt.png" width="34" height="24" alt="arabic"><span><?php echo $lang['Arabic']; ?></span></a>
          <a class="dropdown-item" href="?lang=en"><img src="layout/images/USA.png" width="34" height="24" alt="english"><span><?php echo $lang['English']; ?><span></a>
        </div>
      </li>

      <li class="nav-item dropdown navbar-dropdown profile">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <?php
               echo "<img class='avatar' src='upload/avatars/". $_SESSION['avatar'] . "' alt='Admin Image' />";
               echo $_SESSION['adm_name'];
          ?>
        </a>

        <div class="dropdown-menu info_acc" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="../index.php"><?php echo $lang['Visit Website']; ?></a>
          <a class="dropdown-item" href="logout.php"><?php echo $lang['Logout']; ?></a>
        </div>
      </li>
    </ul>
  </div>
</nav>