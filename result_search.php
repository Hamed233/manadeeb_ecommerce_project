<?php
  ob_start();
  if (isset($_POST['search'])) {
    $pageTitle = "your search: " . $_POST['search'];
  } else {
    $pageTitle = 'Search Result'; // Page Main Title
  }

  $no_ads    = '';
  include 'init.php'; // this file contain all info for config

if (isset($_GET['s'])) {
  // start form information
  $search = htmlspecialchars($_GET['s'], ENT_QUOTES, 'UTF-8');

  $formError = array();
  if (empty($search)) {
    $formError [] = 'Search field is empty';
  }

  if (strlen($search) < 3) {
    $formError [] = 'Your search is very short';
  }

  if (empty($formError)) {

    $stmt = $con->prepare("SELECT * FROM products WHERE p_description LIKE '%" . $search . "%' AND p_name LIKE '%" . $search . "%'");
    $stmt->execute();
    $searchResult = $stmt->fetchAll();

  } else {
    foreach ($formError as $err) {
      echo "<div class='alert alert-danger'>" . $err . "</div>";
    }
  }
?>

<div class="container" style="min-height: 100%">
  <div class="search_result">
  <div class="products-search">
  <h2 class="search-header"><?php if (isset($search)) { echo $lang['Your search'] . ":  [ <span> " . $search . "</span> ]"; } ?></h2>
  <div class="row">
    <?php
     if (isset($search)) {
       if(!empty($searchResult)) {
       foreach ($searchResult as $result) { ?>
       <div class="col-sm-6 col-md-3 col-lg-3 col-xl-3 col_p_trick">
          <div class="product-con-sam">
             <a href="product.php?productid=<?php echo $result['p_id'] . '&category_id=' . $result['categoryID'] . '&productname=' . preg_replace('/\s+|&/', '-', $result['p_name']); ?>" style="color: #000;">
              <div class="product-same-info">
               <img src="admin-dashboard/upload/products/<?php echo $result['p_picture']; ?>" alt="image product" />
               <div class="product-title"><?php echo $result['p_name']; ?></div>
                 <div class="price-sam-product">US $<?php echo $result['price']; ?></div>
                 <div class="rating-sam-product">
                   <?php
                   if ($result['Rating'] !== '0') {
                    echo $result['Rating'] . '/5';
                  } else {
                    echo $lang['No rating yet before'];
                  } ?>
                 </div>
              </div><!-- .product-same-info -->
             </a>
           </div><!-- .product-con-sam -->
          </div>
  
<?php } ?>
  </div>
<?php } else { ?>
  <div class="container">
     <div class="alert alert-danger">Sorry not found any result.</div>
      <hr />
     <div class="more-product-same">
     <h4><?php echo $lang['More items you like']; ?></h4>
      <div class="row">
       <?php
         $sql = $con->prepare("SELECT * FROM products WHERE Approve = 1 ORDER BY RAND() ASC ");
         $sql->execute();
         $allProducts = $sql->fetchAll();

         foreach ($allProducts as $product) { ?>
          <div class="col-sm-6 col-md-3 col-lg-3 col-xl-3 col_p_trick">
           <div class="product-con-sam">
             <a href="product.php?productid=<?php echo $product['p_id'] . '&category_id=' . $product['categoryID'] . '&productname=' . preg_replace('/\s+|&/', '-', $product['p_name']); ?>" style="color: #000;">
              <div class="product-same-info">
               <img src="admin-dashboard/upload/products/<?php echo $product['p_picture']; ?>" alt="image product" />
               <div class="product-title"><?php echo $product['p_name']; ?></div>
                 <div class="price-sam-product">US $<?php echo $product['price']; ?></div>
                 <div class="rating-sam-product">
                   <?php
                   if ($product['Rating'] !== '0') {
                    echo $product['Rating'] . '/5';
                  } else {
                    echo $lang['No rating yet before'];
                  } ?>
                 </div>
              </div><!-- .product-same-info -->
             </a>
           </div><!-- .product-con-sam -->
          </div>
      <?php } ?>
    </div><!-- .row -->
  </div>
</div>
<?php }
     }
    ?>

   </div><!-- .row -->
  </div><!-- .search_result -->
</div><!-- .container -->

<?php } else {
  header('Location: index.php');
  exit();
} ?>

  <?php
     include $temp . 'footer.php'; // Footer template
     ob_end_flush(); // Release The Output
  ?>
