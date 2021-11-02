<?php
/*
===================================
----- categories page.
===================================
*/

  ob_start();
  if (isset($_GET['catid'])) {
    $pageTitle = 'All products special this categories';
  } else {
    $pageTitle = 'Categories';
  }

  $no_ads = '';
  include 'init.php';

  $cat = isset($_GET['catid']) ? $_GET['catid'] : 'categories';

  if ($cat == 'categories') { ?>
  <div class="cg cg-page" id="categories-banner">
    <div class="container">
      <div class="all-categories-main-head"><?php echo $lang['All Categories']; ?></div>
      <div class="all-categories-sub-head"><?php echo $lang['Smarter Shopping,Better Living!']; ?></div>
    </div>
  </div>

  <div class="categories-page">
    <div class="container">
       <div class="top-cat-nav">
         <div class="row">
           <?php

           $sql = $con->prepare("SELECT * FROM categories WHERE parent = 0 AND visibilty = 0 ORDER BY c_id LIMIT 8");
           $sql->execute();
           $allCats = $sql->fetchAll();

             foreach($allCats as $cat) { ?>

              <div class="col-sm-6 col-md-3 col-lg-3 col-trick">
                <a href="categories.php?catid=<?php echo $cat['c_id'] . "&catname=" . preg_replace('/\s+|&/', '-', $cat['c_name']); ?>">
                  <div class="cat-content">
                     <img src="admin-dashboard/upload/categories/categories_brand/<?php echo $cat['c_picture']; ?>" alt="cat img" />
                     <div class="cat-name"><?php echo $cat['c_name']; ?></div>
                 </div>
               </a>
              </div>
          <?php } ?>

            <div class="cg cg-page second-nav" id="categories-banner">
                <div class="all-categories-main-head"><?php echo $lang['Find Whould you like']; ?></div>
                <div class="all-categories-sub-head"><?php echo $lang['Smarter Shopping with manadeeb']; ?></div>
           </div>


               <div class="row">
                 <?php
                    foreach($allCats as $cat) { ?>
                     <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                       <div class="second-sec-con">
                          <a href="categories.php?catid=<?php echo $cat['c_id'] . "&catname=" . preg_replace('/\s+|&/', '-', $cat['c_name']); ?>"><h2 class="main-cat-name"><?php echo $cat['c_name']; ?></h2></a>
                       <div class="con-cat">
                         <ul>
                          <?php $childCats = getAllFrom("*", 'categories', "WHERE parent = {$cat['c_id']} AND visibilty = 0", "", "c_id", "ASC");
                            if (!empty($childCats)) {
                              foreach ($childCats as $Chcat) { ?>
                                <li><a href="categories.php?catid=<?php echo $Chcat['c_id']; ?>"><?php echo $Chcat['c_name']; ?></a></li>
                        <?php }
                      } else { ?>
                               <div class="alert alert-danger"><?php echo $lang['Sorry Not Found Any Child Categories']; ?>
                       <?php } ?>

                         </ul>
                       </div><!-- .con-cat -->
                     </div><!-- .second-sec-con -->
                    </div>
                <?php } ?>
              </div><!-- .row -->

         </div><!-- .row -->
       </div><!-- .top-cat-nav -->
       <div class="clearfix"></div>

    </div><!-- .container -->
  </div><!-- .categories-page -->

<?php } elseif ($cat == $_GET['catid']) { ?>

  <div class="page-wrapper manadeeb_categories toggled">
    <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
      <i class="fas fa-bars"></i>
      <p class="d-inline"><?php echo $lang['categories']; ?></p>
    </a>
    <nav id="sidebar" class="sidebar-wrapper l-navbar">
      <div class="sidebar-content">
        <div class="sidebar-brand">
          <div id="close-sidebar">
            <i class="fas fa-times"></i>
          </div>
        </div><!-- #sidebar-brand -->

          <div class="sidebar-menu">
            <h2 class="main-heading-sidebar"><?php echo $lang['categories']; ?></h2>
              <div class="courses-content">
                <ul>
                  <?php $RelatedCats = getAllFrom("*", 'categories', "WHERE c_id != {$_GET['catid']} AND visibilty = 0", "", "c_id", "ASC");
                  foreach ($RelatedCats as $Rcat) { ?>
                  <li><a href="categories.php?catid=<?php echo $Rcat['c_id'] . "&catname=" . preg_replace('/\s+|&/', '%', $Rcat['c_name']); ?>"><?php echo $Rcat['c_name']; ?></a></li>
                <?php } ?>
                </ul>
              </div><!-- #courses-content -->
          </div><!-- sidebar-menu  -->
      </div><!-- #sidebar-content  -->
    </nav><!-- #sidebar-wrapper -->

    <main class="page-content page-home">
        <div class="container-fluid">
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="banner-ads">
                    <a href="https://www.bluehost.com/track/hamed200/foraward" target="_blank"> <img style="border=0; width: 100%; margin-bottom: 19px; margin-top: 20px" src="https://bluehost-cdn.com/media/partner/images/hamed200/760x80/760x80BW.png"> </a>
                </div>

                <div class="categories-orders">
                   <div class="latest-oldest">
                     <?php
                     $sort = 'ASC';
                     $sort_array = array('ASC', 'DESC');
                     if (isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)) {
                        $sort = $_GET['sort'];
                     } ?>

                     <i class="fa fa-sort"></i> <?php echo $lang['Ordering']; ?>: [
                     <a class="<?php if ($sort=='ASC') {echo 'active'; } ?>" href="<?php echo $_SERVER['REQUEST_URI']; ?>&sort=ASC"><?php echo $lang['Asc']; ?></a> |
                     <a class="<?php if ($sort=='DESC') {echo 'active'; } ?>" href="<?php echo $_SERVER['REQUEST_URI']; ?>&sort=DESC"><?php echo $lang['Desc']; ?></a> ]
                   </div>

                  <div class="rating_a">
                   <?php
                   $rating = 0;
                   $rating_array = array(0, 1, 2, 3, 4, 5);

                    if (isset($_GET['rating']) && in_array($_GET['rating'], $rating_array)) {
                      $rating = $_GET['rating'];
                    }
                    ?>
                    <span><i class="fas fa-star"></i><?php echo $lang['Rating']; ?>:</span>
                    <ul>
                      <li><a class="<?php if ($rating=='1') {echo 'active'; } ?>" href="<?php echo $_SERVER['REQUEST_URI']; ?>&rating=1"><i class="fas fa-star"></i>5.1</a></li>
                      <li><a class="<?php if ($rating=='2') {echo 'active'; } ?>" href="<?php echo $_SERVER['REQUEST_URI']; ?>&rating=2"><i class="fas fa-star"></i>5.2</a></li>
                      <li><a class="<?php if ($rating=='3') {echo 'active'; } ?>" href="<?php echo $_SERVER['REQUEST_URI']; ?>&rating=3"><i class="fas fa-star"></i>5.3</a></li>
                      <li><a class="<?php if ($rating=='4') {echo 'active'; } ?>" href="<?php echo $_SERVER['REQUEST_URI']; ?>&rating=4"><i class="fas fa-star"></i>5.4</a></li>
                      <li><a class="<?php if ($rating=='5') {echo 'active'; } ?>" href="<?php echo $_SERVER['REQUEST_URI']; ?>&rating=5"><i class="fas fa-star"></i>5.5</a></li>
                    </ul>
                  </div><!-- .rating_a -->

                  <div class="product-status">
                    <?php
                    $pstatus = 'no-choose';
                    $pstatus_array = array('no-choose', 'new', 'Like-New', 'Used', 'Old');

                     if (isset($_GET['pstatus']) && in_array($_GET['pstatus'], $pstatus_array)) {
                       $pstatus = $_GET['pstatus'];
                     }
                     ?>

                     <i class="fas fa-thermometer-three-quarters"></i>
                     <span><?php echo $lang['product status']; ?>:</span>
                         <a class="<?php if ($pstatus=='new') {echo 'active'; } ?>" href="<?php echo $_SERVER['REQUEST_URI']; ?>&pstatus=new"><?php echo $lang['New']; ?></a> |
                         <a class="<?php if ($pstatus=='Like-New') {echo 'active'; } ?>" href="<?php echo $_SERVER['REQUEST_URI']; ?>&pstatus=Like-New"><?php echo $lang['Like New']; ?></a> |
                         <a class="<?php if ($pstatus=='Used') {echo 'active'; } ?>" href="<?php echo $_SERVER['REQUEST_URI']; ?>&pstatus=Used"><?php echo $lang['Used']; ?></a> |
                         <a class="<?php if ($pstatus=='Old') {echo 'active'; } ?>" href="<?php echo $_SERVER['REQUEST_URI']; ?>&pstatus=Old"><?php echo $lang['Old']; ?></a>
                  </div>
                </div>

                <div id="learn-page-content" class="learn-page-content">
                  <h2 class="category-title text-center"><?php echo preg_replace('/\s+|%/', ' ', $_GET['catname']); ?></h3>
                    <div class="row">
                    <?php $Relatedproducts = getAllFrom("*", 'products', "WHERE categoryID = {$_GET['catid']} AND Approve = 1 AND Rating = $rating", "", "p_id", $sort);
                    if (!empty($Relatedproducts)) {
                      foreach ($Relatedproducts as $Rproduct) { ?>
                     <div class="col-sm-6 col-md-3 col-lg-3">
                       <a href="product.php?productid=<?php echo $Rproduct['p_id'] . '&category_id=' . $Rproduct['categoryID'] . '&productname=' . preg_replace('/\s+|&/', '-', $Rproduct['p_name']); ?>">
                        <div class="product-cat-con">
                          <img src="admin-dashboard/upload/products/<?php echo $Rproduct['p_picture']; ?>" alt="product img" />
                          <div class="more-info-pro">
                           <div class="product-tit"><a href="product.php?productid=<?php echo $Rproduct['p_id']; ?>"><?php echo $Rproduct['p_name']; ?></a></div>
                           <div class="product-pri">US $<?php echo $Rproduct['price']; ?></div>
                           <div class="hold-sale"></div>
                           <div class="store-name"></div>
                           <div class="product-rat">
                             <a href=""><i class="fas fa-star"></i> 5.<?php echo $Rproduct['Rating']; ?></a>
                             <span><?php echo $lang['done_selled'] . ' ' . $Rproduct['orders_number']; ?></span>
                           </div>
                         </div><!-- .more-info-pro -->
                        </div><!-- .product-cat-con -->
                      </a>
                     </div>
                   <?php
                }
                 } else {
                   echo "<div class='alert alert-danger not_found_cat'>" . $lang['Sorry, Not Found Any product includes this category'] . "</div>";
                 } ?>
                  </div><!-- .row -->
                </div><!-- #learn-page-content -->
             </div><!-- #col-xs-12 col-sm-12 col-md-9 -->
           </div><!-- #row -->
        </div><!-- #container-fluid -->
      </main><!-- page-content" -->
    </div><!-- .page-wrapper -->

<?php } else {
  header('Location: index.php');
  exit();
} ?>
<?php
     include $temp . 'footer.php'; // Footer template
?>