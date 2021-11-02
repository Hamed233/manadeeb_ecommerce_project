<?php
  ob_start();

  if(isset($_GET['productname'])) {
    $pageTitle = preg_replace('/\s+|%/', ' ', $_GET['productname']);
  } else {
    $pageTitle = 'Product Name'; // Page Main Title
  }
  $no_ads    = '';
  include 'init.php'; // this file contain all info for config

  $productid = isset($_GET['productid']) ? $_GET['productid'] : 'products';

  if ($productid == 'products') {

    header('Location: index.php');
    exit();

 } elseif ($productid == $_GET['productid']) {
       $sql = $con->prepare("SELECT * FROM products WHERE p_id = {$_GET['productid']} ORDER BY p_id LIMIT 1");
       $sql->execute();
       $allInfoProduct = $sql->fetch();
  ?>

 <div class="product-content-info">
  <div class="container">
     <div class="row">
        <div class="col-md-2 col-lg-2 col-xl-2 includes_product">
            <?php
              $sql = $con->prepare("SELECT * FROM products WHERE p_id != {$_GET['productid']} ORDER BY p_id LIMIT 2");
              $sql->execute();
              $allRProduct = $sql->fetchAll(); ?>
           <h6 class="head-six-pro"><?php echo $lang['That includes you']; ?></h6>
           <?php foreach ($allRProduct as $product_r) { ?>
             <a href="product.php?productid=<?php echo $product_r['p_id'] . '&category_id=' . $product_r['categoryID'] . '&productname=' . preg_replace('/\s+|&/', '-', $product_r['p_name']); ?>" style="color: #000;">
               <div class="section-pro-first">
                <img src="admin-dashboard/upload/products/<?php echo $product_r['p_picture']; ?>" alt="product" />
                <span class="d-block text-center">US $<?php echo $product_r['price']; ?></span>
               </div><!-- .section-pro-first -->
            </a>
          <?php } ?>
        </div>

        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
           <div class="section-pro-second" id="<?php echo $_GET['productid']; ?>">
              <div class="product-title"><?php echo $allInfoProduct['p_name']; ?></div>

              <span id="rating"></span>

              <div class="banner-count-down" style='height: 56px;background-image: url("https://ae01.alicdn.com/kf/HTB1vHKXQSzqK1RjSZFjq6zlCFXar.jpg");'></div>
              <div class="product-price">
                <div class="current-price">
                  <?php $currentP = $allInfoProduct['price'] - $allInfoProduct['discount']; ?>
                  US $<?php echo number_format($currentP, 2); ?>
                </div><!-- .current-price -->
                <div class="original-price">
                  US $<?php echo $allInfoProduct['price']; ?>
                </div><!-- .original-price -->
              </div><!-- .product-price -->
              <hr />

              <div class="product-colors">
                <h6><?php echo $lang['color']; ?></h6>
                  <div class="all-colors-images">
                     <img class="img-product" src="admin-dashboard/upload/products/<?php echo $allInfoProduct['p_picture']; ?>" alt="product-color" width="50" height="50">
                  </div><!-- .all-colors -->
              </div><!-- .product-colors -->

              <!-- Inputs It will send to server -->
               <input type="hidden" id="<?php echo $_GET['productid']; ?>_product" name="product_id" class="form-control" value="<?php echo $_GET['productid']; ?>">
               <input type="hidden" id="<?php echo $_GET['productid']; ?>_sellar" name="sellar_name" class="form-control" value="<?php echo $allInfoProduct['sellar_id']; ?>">
               <input type="hidden" id="<?php echo $_GET['productid']; ?>_name" name="hidden_name" value="<?php echo $allInfoProduct['p_name']; ?>">
               <input type="hidden" id="<?php echo $_GET['productid']; ?>_price" name="hidden_price" value="<?php echo $allInfoProduct['price']; ?>">
               <input type="hidden" id="<?php echo $_GET['productid']; ?>_discount" name="hidden_discount" value="<?php echo $allInfoProduct['discount']; ?>">
               <input type="hidden" id="<?php echo $_GET['productid']; ?>_discount" name="total_price" value="<?php echo ($allInfoProduct['price'] - $allInfoProduct['discount']); ?>">

               <div class="part-four">
              <div class="row">
               <div class="col-5">
                 <div class="quantity quan-product">
                  <div class="input-group">
                    <span class="input-group-btn">
                      <button type="button" class="quantity-left-minus btn btn-brown btn-number" data-type="minus" data-field="">
                        <i class="fa fa-minus"></i>
                      </button>
                    </span>
                    <input type="text" id="<?php echo $_GET['productid']; ?>_quantity" name="quantity" class="form-control input-number quantity_js" value="1" min="1" max="100">
                    <span class="input-group-btn">
                       <button type="button" class="quantity-right-plus btn btn-brown btn-number" data-type="plus" data-field="">
                         <i class="fa fa-plus"></i>
                       </button>
                    </span>
                   </div>
                 </div>
               </div>
               <div class="col-7">
                 <div class="add-buy-btn for_lg">
                 <span class="msg"></span>
                    <?php
                    if(!(isset($_SESSION['customer']) || isset($_SESSION['sellar']))) { ?>
                      <div class="alert_for_disabled"></div>
                   <?php } ?>
                     <button onclick="cart('<?php echo $_GET['productid']; ?>')" class="<?php if(!(isset($_SESSION['customer']) || isset($_SESSION['sellar']))) { echo "disabled"; } ?> btn btn-danger cart_btn" onclick="cart('<?php echo $_GET['p_id']; ?>')" style="width: 100%;" <?php if(!(isset($_SESSION['customer']) || isset($_SESSION['sellar']))) { echo "disabled"; } ?>>
                       <i class="fas fa-cart-plus"></i>
                       <?php echo $lang['add to cart']; ?>
                     </button>
                  </div><!-- .add-buy-btns -->
                </div><!-- col-7 -->
              </div><!-- .row -->
            </div><!-- .part-four -->
           </div><!-- .section-pro-two -->
        </div>

        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
          <span class='zoom' id='ex1'>
          <img src='admin-dashboard/upload/products/<?php echo $allInfoProduct['p_picture']; ?>' width='555' height='320' alt='product iamge'/>
          </span>
        </div>
     </div><!-- .row -->
   </div><!-- .container -->
  </div><!-- .product-content-info -->

  <div class="clearfix"></div>

  <div class="container">
     <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
           <div class="more-info-product">
             <h5><i class="fas fa-info-circle"></i> <?php echo $lang['more_info_about_product']; ?></h5>
            <div class="more-peoduct-main">
             <div class="product-desc">
                <h5><i class="fas fa-vial"></i> <?php echo $lang['description']; ?></h5>
                <p>- <?php echo $allInfoProduct['p_description']; ?></p>
             </div>
             <hr />
             <div class="product_done_selled">
                <h5><i class="fa fa-check"></i> <?php echo $lang['done_selled']; ?></h5>:
                <span><?php echo $allInfoProduct['orders_number']; ?></span>
             </div>
             <hr />
             <?php
                 $stmt = $con->prepare("SELECT * from product_rating WHERE product_id = ?");
                 $stmt->execute(array($allInfoProduct['p_id']));
                 $ratings = $stmt->rowCount();
               ?>

             <div class="product-rating">
                <h5><i class="fa fa-star"></i><?php echo $lang['Total Reviews']; ?></h5>:
                <span><?php echo $ratings; ?></span>
             </div>
             <hr />
             <div class="distribution">
              <h5><i class="fa fa-map"></i>
               <span><?php echo $lang['Places of distribution']; ?></span>
              </h5>
               <ul>
               <?php
                 $Places_distributions = explode(",", $allInfoProduct['Places_distribution']);
               if(!empty($allInfoProduct['Places_distribution'])) {
                foreach($Places_distributions as $distribution){  
                  if($distribution != '') {
                    echo '<li>' . $distribution . '</li>';
                  }
                }
               } else {
                 echo "<div class='alert alert-primary'>This product Available for any place</div>";
               }
               ?>
               </ul>
             </div>
            </div>
           </div><!-- .more-info-product -->

           <div class="more-product-same">
              <h4><?php echo $lang['More items you like']; ?></h4>
               <div class="row">
                <?php
                  $sql = $con->prepare("SELECT * FROM products WHERE p_id != {$_GET['productid']} AND Approve = 1 AND categoryID = {$_GET['category_id']} ORDER BY RAND() ASC");
                  $sql->execute();
                  $allProducts = $sql->fetchAll();

                  if(!empty($allProducts)){ 

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
                <?php } 
               } else {
                $getProducts = getAllFrom("*", "products", "WHERE Approve = 1", "", "RAND()", "LIMIT 12");
               
                if(!empty($getProducts)){ 

                  foreach ($getProducts as $product) { ?>
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
              <?php } 
                } else { ?>
                  <div class="alert alert-danger" style="margin-top: 20px; width: 100%;"><i class='fas fa-exclamation-circle' style="padding: 10px;"></i><b> <?php echo $lang['Sorry Not Found Any Record To Show, but you can add now.']; ?></b></div>
             <?php }
             } ?>
             </div><!-- .row -->
          </div><!-- .more-product-same -->
        </div>
  </div><!-- .row -->
</div><!-- .container -->

<?php } else {
  header('Location: 404.php');
  exit();
} ?>

<?php
     include $temp . 'footer.php'; // Footer template
?>
