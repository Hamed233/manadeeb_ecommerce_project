<?php
/*
** =================================== **
**** Home page website
** =================================== **
*/
  ob_start();
  $pageTitle = 'Manadeeb For shopping'; // Page Main Title
  include 'init.php'; // this file contain all info for config
 ?>

  <div class="page-container">
    <div class="home-page">
       <div class="container">
         <div class="row">
           <!-- Get All Categories -->
           <div class="col-sm-3 col-md-3 col-lg-3 categories_t">
            <div class="categories">
               <div class="cat-title">
                 <span><a href="categories.php"><?php echo $lang['categories']; ?></a></span>
               </div><!-- .cat-title -->
               <div class="cat-list-box">
                 <?php $getAllCat = getAllFrom("*", "categories", "WHERE visibilty = 0", "", "c_id");
                 foreach ($getAllCat as $cat) { ?>
                   <dl>
                     <dt class="cat-name">
                       <span>
                         <img class="cat-img" src="admin-dashboard/upload/categories/categories_brand/<?php echo $cat['c_picture']; ?>" alt="category image">
                         <a href="categories.php?catid=<?php echo $cat['c_id'] . '&catname=' . preg_replace('/\s+|&/', '%', $cat['c_name']); ?>"><?php echo $cat['c_name']; ?></a></span>
                     </dt>
                   </dl>
               <?php } ?>
               </div>
            </div>
          </div>
          <div class="col-sm-12 col-md-12 col-lg-6">
            <div class="slideshow-container">

              <!-- Full-width images with number and caption text -->
              <?php
                $getAll = $con->prepare("SELECT * FROM products WHERE Approve = 1 ORDER BY p_id ASC");
                $getAll->execute();
                $getProducts = $getAll->fetchAll();

                foreach ($getProducts as $product) { ?>
                <div class="mySlides">
                  <a href="product.php?productid=<?php echo $product['p_id'] . '&category_id=' . $product['categoryID'] . "&productname=" . preg_replace('/\s+|&/', '%', $product['p_name']); ?>">
                    <img class="product-img" src="admin-dashboard/upload/products/<?php echo $product['p_picture']; ?>">
                  </a>

                  <div class="text"><?php echo $product['p_name']; ?></div>
                </div>
                <?php } ?>

              <!-- Next and previous buttons -->
              <a class="prev-img" onclick="plusSlides(-1)">&#10094;</a>
              <a class="next-img" onclick="plusSlides(1)">&#10095;</a>

              <!-- The dots/circles -->
              <div class="align-center">
                <span class="dot" onclick="currentSlide(1)"></span>
                <span class="dot" onclick="currentSlide(2)"></span>
                <span class="dot" onclick="currentSlide(3)"></span>
              </div>
          </div><!-- .slideshow-container -->

          <!-- Some small products -->
          <div class="some-products">
             <ul>
               <?php $getAllPro = getAllFrom("*", "products", "WHERE Approve = 1", "", "p_id", "ASC", "LIMIT 5");
               foreach ($getAllPro as $product) { ?>
                 <li>
                   <a href="product.php?productid=<?php echo $product['p_id'] . '&category_id=' . $product['categoryID'] . '&productname=' . preg_replace('/\s+|&/', '%', $product['p_name']); ?>" target="_blank">
                     <div class="crowd-container">
                          <div class="crowd-img">
                            <img src="admin-dashboard/upload/products/<?php echo $product['p_picture']; ?>" alt="image-product">
                          </div>
                          <div class="crowd-note">
                            <div class="crowd-price">US $<?php echo $product['price']; ?></div>
                          </div><!-- .crowd-note -->
                          <div class="crowd-title">
                             <?php echo $product['p_name']; ?>
                          </div>
                     </div>
                   </a>
                 </li>
            <?php } ?>
             </ul>
          </div><!-- .some-products -->

        </div>
          
          <!-- side by login -->
          <div class="col-sm-3 col-md-3 col-lg-3 user_b">
            <div class="user-benefits">
               <!-- check first if isset not login -->
              <?php if (isset($_SESSION['sellar'])) {
                       $sellar_id = $_SESSION['sellar_id']; ?>

                <div class="user-login">
                  <?php
                   $stmt = $con->prepare("SELECT * FROM sellars WHERE sellar_id = {$sellar_id} LIMIT 1");
                   $stmt->execute();
                   $sellar_info = $stmt->fetch();
                  ?>
                   <img class="avatar" src="upload/sellars/<?php echo $sellar_info['sellar_img']; ?>" alt="avatar sellar">
                   <p><?php echo '"' . $sellar_info['sellar_name'] . '"<br /> ' . $lang['welcome in manadeeb.com']; ?></p>
                </div><!-- .user-login -->

            <?php } elseif (isset($_SESSION['customer'])) { ?>

              <div class="user-login">
                 <p><?php echo '"' . $_SESSION['customer'] . '"<br /> ' . $lang['welcome in manadeeb.com']; ?></p>
              </div><!-- .user-login -->
            
            <?php } else { ?>

              <div class="user-login">
                 <img class="avatar" src="layout/images/avatar2.png" alt="avatar">
                 <p><?php echo $lang['welcome in manadeeb.com']; ?></p>
                 <a class="btn btn-danger d-inline" href="log-sign.php?do=SignUp"><?php echo $lang['Join']; ?></a>
                 <a class="btn btn-outline-danger d-inline" href="log-sign.php?do=Signin"><?php echo $lang['Signin']; ?></a>
              </div><!-- .user-login -->
            
            <?php } ?>

            <?php if (isset($_SESSION['sellar'])) { ?>

                <div class="member-entry">
                   <h4><?php echo $lang['Hello New Sellar']; ?></h4>
                   <p><?php echo $lang['The best Sell on manadeeb & best Earn']; ?></p>
                   <img src="layout/images/money.jpg" alt="money" />
                </div><!-- .member-entry -->

            <?php } elseif (isset($_SESSION['customer'])) { ?>

               <div class="member-entry">
                  <h4><?php echo $lang['Hello New Customer']; ?></h4>
                  <p><?php echo $lang['The best shopping on manadeeb & best selections']; ?></p>
                  <div class="cart-home text-center">
                    <i class="fas fa-shopping-basket"></i>
                  </div>
               </div><!-- .member-entry -->

            <?php } else { ?>

               <div class="member-entry">
                  <h4><?php echo $lang['Hello New Users']; ?></h4>
                  <p><?php echo $lang['The best shopping on manadeeb & best selections']; ?></p>
                  <div class="cart-home text-center">
                    <i class="fas fa-shopping-basket"></i>
                  </div>
               </div><!-- .member-entry -->

            <?php } ?>
          </div>
        </div>
      </div><!-- .row -->

      <div class="clearfix"></div>

      <div class="row">

        <?php
           // Get the near product for sellar 
           if (isset($_SESSION['sellar'])) {
            $stmt = $con->prepare("SELECT * FROM products WHERE p_country_id = ? OR city_product = ? AND Approve = ? ORDER BY p_id ASC LIMIT 5");
            $stmt->execute(array($_SESSION['country_id'], $_SESSION['sellar_city'], 1));
            $getNProdc = $stmt->fetchAll();

           if (!empty($getNProdc)) { ?>
           
             <div class="products-home">
               <div class="title-sec-container">
                 <h3><?php echo $lang['products near from you']; ?></h3>
                 <span class="view-more"><a href="categories.php" target="_blank"><?php echo $lang['view more']; ?></a></span>
               </div>

             <div class="clearfix"></div>

             <div class="product-container">
               <ul>
              <?php  foreach ($getNProdc as $productC) { ?>
                   <li>
                     <a href="product.php?productid=<?php echo $productC['p_id'] . '&category_id=' . $productC['categoryID'] . '&productname=' . preg_replace('/\s+|&/', '%', $productC['p_name']); ?>" target="_blank">
                        <div class="img-wrapper img-wrapper-se flex justify-center align-items-center">
                            <img src="admin-dashboard/upload/products/<?php echo $productC['p_picture']; ?>" alt="urgent product">
                        </div>
                        <div class="pro-price">
                            <span class="current-price util-left">US $<?php echo $productC['price']; ?></span>
                            <span class="discount"><?php echo $productC['discount']; ?>%</span>
                        </div>
                        <div class="pro-remaining">
                            <div class="pro-claimed"><?php echo $lang['done_selled'] . ' ' . $productC['orders_number']; ?></div>
                        </div>
                     </a>
                   </li>
                <?php } ?>
                 </ul>
             </div>
           </div>
      <?php } 
  } 

  // Get the near product for customer 
  if (isset($_SESSION['customer'])) {
            // Get data from db depend on customer data in login 
            $stmt = $con->prepare("SELECT * FROM products WHERE p_country_id = ? OR city_product = ? AND Approve = ? ORDER BY p_id ASC LIMIT 5");
            $stmt->execute(array($_SESSION['cus_coun'], $_SESSION['cus_city'], 1));
            $cus_products = $stmt->fetchAll();

           if (!empty($cus_products)) { ?>
             <div class="products-home">
               <div class="title-sec-container">
                 <h3><?php echo $lang['products near from you']; ?></h3>
                 <span class="view-more"><a href="categories.php" target="_blank"><?php echo $lang['view more']; ?></a></span>
               </div>

             <div class="clearfix"></div>

             <div class="product-container">
               <ul>
              <?php  foreach ($cus_products as $prodS) { ?>
                   <li>
                     <a href="product.php?productid=<?php echo $prodS['p_id'] . '&category_id=' . $prodS['categoryID'] . '&productname=' . preg_replace('/\s+|&/', '%', $prodS['p_name']); ?>" target="_blank">
                        <div class="img-wrapper img-wrapper-se flex justify-center align-items-center">
                            <img src="admin-dashboard/upload/products/<?php echo $prodS['p_picture']; ?>" alt="urgent product">
                        </div>
                        <div class="pro-price">
                            <span class="current-price util-left">US $<?php echo $prodS['price']; ?></span>
                            <span class="discount"><?php echo $prodS['discount']; ?>%</span>
                        </div>
                        <div class="pro-remaining">
                            <div class="pro-claimed"><?php echo $lang['done_selled'] . ' ' . $prodS['orders_number']; ?></div>
                        </div>
                     </a>
                   </li>
                <?php } ?>
                 </ul>
             </div>
           </div>
       <?php 
      } 
 } ?>


         <div class="products-home">
           <div class="title-sec-container">
             <h3><?php echo $lang['Urgent deals']; ?></h3>
           </div>

          <div class="clearfix"></div>

           <div class="product-container">
             <ul>
               <?php 

                $stmt = $con->prepare("SELECT * FROM products where price <= ? AND Approve = ? ORDER BY RAND() DESC LIMIT 10");
                $stmt->execute(array(222, 1));
                $getAllUrgent = $stmt->fetchAll();

                foreach ($getAllUrgent as $urgent) { ?>
                  <li>
                    <a href="product.php?productid=<?php echo $urgent['p_id'] . '&category_id=' . $urgent['categoryID'] . '&productname=' . preg_replace('/\s+|&/', '%', $urgent['p_name']); ?>" target="_blank">
                       <div class="img-wrapper flex justify-center align-items-center">
                           <img src="admin-dashboard/upload/products/<?php echo $urgent['p_picture']; ?>" alt="urgent product" style="height: 100%;">
                       </div>
                       <div class="pro-price">
                           <span class="current-price util-left">US $<?php echo $urgent['price']; ?></span>
                           <span class="discount"><?php echo $urgent['discount']; ?>%</span>
                       </div>
                       <div class="pro-remaining">
                           <div class="pro-claimed"><?php echo $lang['done_selled'] . ' ' . $urgent['orders_number']; ?></div>
                       </div>
                    </a>
                  </li>
               <?php } ?>

             </ul>
           </div>
         </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
          <div class="col-sm-12 col-md-6 col-lg-6 left-c">
            <div class="left-container">
            	<div class="top-selection container-radius" id="redesign-top-selection">
            		<div class="title-container">
            			<div class="title-info">
            				<h3><?php echo $lang['The best combination']; ?></h3>
                  </div>
                </div>

            		<div class="top-selection-slider">
                  <ul class="product-list flex-horizontal flex-wrap">
                    <?php $getAllCombition = getAllFrom("*", "products", "WHERE Approve = 1", "", "RAND()", "LIMIT 4");
                    foreach ($getAllCombition as $cobmition) { ?>
                <li class="product-item">
                    <a href="product.php?productid=<?php echo $cobmition['p_id'] . '&category_id=' . $cobmition['categoryID'] . '&productname=' . preg_replace('/\s+|&/', '%', $cobmition['p_name']); ?>">
                        <div class="item-box flex-vertical">
                            <div class="img-wrapper product-list-img  flex-vertical justify-center">
                                <img src="admin-dashboard/upload/products/<?php echo $cobmition['p_picture']; ?>">
                            </div>
                            <div class="pro-price">
                                <span class="current-price">US $<?php echo $cobmition['price']; ?></span>
                            </div>
                        </div>
                    </a>
                </li>
              <?php } ?>
            </ul>
          </div>
        </div>
      </div>
   </div><!-- .col-6 -->
      <div class="col-sm-12 col-md-6 col-lg-6 right-c">
         <div class="right-container">
        	<div class="new-for-you container-radius">
        		<div class="title-container">
        			<div class="title-info">
        				<h3><?php echo $lang['New Product For You']; ?></h3>
        			</div>
            </div>

            <div class="new-for-you-slider">
            <ul>
              <?php $getAllNproducts = getAllFrom("*", "products", "WHERE Approve = 1", "", "p_id", "DESC", "LIMIT 4");
              foreach ($getAllNproducts as $nproduct) { ?>
             <li class="product-item">
                <a href="product.php?productid=<?php echo $nproduct['p_id'] . '&category_id=' . $nproduct['categoryID'] . '&productname=' . preg_replace('/\s+|&/', '%', $nproduct['p_name']); ?>">
                    <div class="item-box flex-vertical">
                        <div class="img-wrapper product-list-img flex-vertical justify-center">
                            <img src="admin-dashboard/upload/products/<?php echo $nproduct['p_picture']; ?>" alt="new product">
                        </div>
                        <div class="pro-price">
                            <span class="current-price">US $<?php echo $nproduct['price']; ?></span>
                        </div>
                        <div class="pro-note" style="visibility:hidden;">
                            <div class="pro-note-wrapper">
                                <span class="eval-total-num">tags</span>
                            </div>
                        </div>
                    </div>
                </a>
            </li>
          <?php } ?>
            </ul>
           </div>
        	</div>
        </div>
      </div>

      <div class="col-sm-12 col-md-6 col-lg-6 left-c">
         <div class="right-container">
          <div class="new-for-you container-radius">
            <div class="title-container">
              <div class="title-info">
                <h3><?php echo $lang['Product For sports']; ?></h3>
                <span class="view-more"><a href="categories.php?catid=11&catname=sports & leisure"><?php echo $lang['view more']; ?></a></span>
              </div>
            </div>

            <div class="new-for-you-slider">
            <ul>
              <?php $getAllNproducts = getAllFrom("*", "products", "WHERE Approve = 1", "AND categoryID = 11", "RAND()", "LIMIT 4");
              foreach ($getAllNproducts as $nproduct) { ?>
              <li class="product-item">
                <a href="product.php?productid=<?php echo $nproduct['p_id'] . '&category_id=' . $nproduct['categoryID'] . '&productname=' . preg_replace('/\s+|&/', '%', $nproduct['p_name']); ?>">
                    <div class="item-box flex-vertical">
                        <div class="img-wrapper product-list-img flex-vertical justify-center">
                            <img src="admin-dashboard/upload/products/<?php echo $nproduct['p_picture']; ?>" alt="new product">
                        </div>
                        <div class="pro-price">
                            <span class="current-price">US $<?php echo $nproduct['price']; ?></span>
                        </div>
                        <div class="pro-note" style="visibility:hidden;">
                            <div class="pro-note-wrapper">
                                <span class="eval-total-num">tags</span>
                            </div>
                        </div>
                    </div>
                </a>
              </li>
              <?php } ?>
           </ul>
         </div>
          </div>
        </div>
      </div>

      <div class="col-sm-12 col-md-6 col-lg-6 right-c">
         <div class="right-container">
          <div class="new-for-you container-radius">
            <div class="title-container">
              <div class="title-info">
                <h3><?php echo $lang['Products For Home']; ?></h3>
                <span class="view-more"><a href="categories.php?catid=10&catname=Home & garden"><?php echo $lang['view more']; ?></a></span>
              </div>
            </div>

            <div class="new-for-you-slider">
            <ul>
              <?php $getAllNproducts = getAllFrom("*", "products", "WHERE Approve = 1", "AND categoryID = 10", "RAND()", "LIMIT 4");
              foreach ($getAllNproducts as $nproduct) { ?>
             <li class="product-item">
                <a href="product.php?productid=<?php echo $nproduct['p_id'] . '&category_id=' . $nproduct['categoryID'] . '&productname=' . preg_replace('/\s+|&/', '%', $nproduct['p_name']); ?>">
                    <div class="item-box flex-vertical">
                        <div class="img-wrapper product-list-img flex-vertical justify-center">
                            <img src="admin-dashboard/upload/products/<?php echo $nproduct['p_picture']; ?>" alt="new product">
                        </div>
                        <div class="pro-price">
                            <span class="current-price">US $<?php echo $nproduct['price']; ?></span>
                        </div>
                        <div class="pro-note" style="visibility:hidden;">
                            <div class="pro-note-wrapper">
                                <span class="eval-total-num">tags</span>
                            </div>
                        </div>
                    </div>
                </a>
            </li>
          <?php } ?>
           </ul>
         </div>
          </div>
        </div>
      </div>
 <!--ams-region-end 1233-->

        </div><!-- .row -->

         <div class="clearfix"></div>
        <div class="row">
         <div class="products-home second_home">
           <div class="title-sec-container">
             <h3><?php echo $lang['cell phones and communications']; ?></h3>
             <span class="view-more"><a href="categories.php?catid=7&catname=cell phones and communications" target="_blank"><?php echo $lang['view more']; ?></a></span>
           </div>

          <div class="clearfix"></div>

           <div class="product-container">
             <ul>
               <?php $getAllSmart = getAllFrom("*", "products", "WHERE Approve = 1", "AND categoryID = 7", "RAND()", "LIMIT 5");
               foreach ($getAllSmart as $smart) { ?>
               <li>
                 <a href="product.php?productid=<?php echo $smart['p_id'] . '&category_id=' . $smart['categoryID'] . '&productname=' . preg_replace('/\s+|&/', '%', $smart['p_name']); ?>" target="_blank">
                    <div class="img-wrapper flex justify-center align-items-center">
                        <img src="admin-dashboard/upload/products/<?php echo $smart['p_picture']; ?>" alt="urgent product" style="height: 100%;">
                    </div>
                    <div class="pro-price">
                        <span class="current-price util-left">US $<?php echo $smart['price']; ?></span>
                        <span class="discount"><?php echo $smart['discount']; ?>%</span>
                    </div>
                    <div class="pro-remaining">
                        <div class="pro-claimed"><?php echo $lang['done_selled'] . ' ' . $smart['orders_number']; ?></div>
                    </div>
                 </a>
               </li>
             <?php } ?>
             </ul>
           </div>
         </div>
        </div>

        <div class="clearfix"></div>

        <h2 class="main-title"><?php echo $lang['More products you will like']; ?></h2>

        <div class="more-products">
        <div class="row">
          <?php 

        // Get data from db depend on customer data in login 
        $getRanProducts = getAllFrom("*", "products", "WHERE  Approve = 1", "", "RAND()");
        foreach($getRanProducts as $rProduct) { ?>
          <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 col-xl-3">
            <div class="product-demo">
              <a href="product.php?productid=<?php echo $rProduct['p_id'] . '&category_id=' . $rProduct['categoryID'] . '&productname=' . preg_replace('/\s+|&/', '%', $rProduct['p_name']); ?>" target="_blank">
                <img src="admin-dashboard/upload/products/<?php echo $rProduct['p_picture']; ?>" alt="product image" />
                <span class="d-block">US $<?php echo $rProduct['price']; ?></span>
              </a>
            </div>
          </div>
        <?php 
       }  ?>
      </div><!-- .row -->
    </div>
   </div><!-- .container -->
 </div><!-- .home-page -->
</div><!-- .page-container -->

 <?php
    include $temp . 'sub_footer.php'; // Sub Footer template
    include $temp . 'footer.php'; //  Main Footer template
    ob_end_flush(); // Release The Output
 ?>