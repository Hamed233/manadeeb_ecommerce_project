<?php
  ob_start();
  if($_GET['kind'] == 'Customer-services') {
    $pageTitle = 'Customer services'; // Page Main Title
  } else {
    $pageTitle = "disputes";
  }

  $no_ads    = '';
  include 'init.php'; // this file contain all info for config

   $kind = isset($_GET['kind']) ? $_GET['kind'] : 'Customer-services';

    if ($kind == 'Customer-services') { ?>

       <div class="header-services"></div>

       <div class="container">
           <div class="page-services-content">
              <h5 class="text-center"><?php echo $lang['Frequently asked questions']; ?></h5>
               <div class="accordtion-content">
                       <button class="accordion"><?php echo $lang['Why was my order closed?']; ?></button>
                        <div class="panel">
                          <p>Answer</p>
                        </div>

                        <button class="accordion"><?php echo $lang['I haven\'t received my money back on my credit card yet. What can i do?']; ?></button>
                        <div class="panel">
                          <p>Answer</p>
                        </div>

                        <button class="accordion"><?php echo $lang['When will the seller send the order?']; ?></button>
                        <div class="panel">
                          <p>Answer</p>
                        </div>

                       <button class="accordion"><?php echo $lang['Payment service upon receipt']; ?></button>
                        <div class="panel">
                          <p>Answer</p>
                        </div>
                 </div>

               <h5 class="text-center"><?php echo $lang['self service']; ?></h5>
                 <div class="accordtion-content">
                       <button class="accordion"><?php echo $lang['How can I track the shipping information for orders using the manadeeb direct method? - Cash on delivery and prepayment']; ?></button>
                        <div class="panel">
                          <p>Answer</p>
                        </div>

                        <button class="accordion"><?php echo $lang['How do I place an order using the cash on delivery service?']; ?></button>
                        <div class="panel">
                          <p>Answer</p>
                        </div>

                        <button class="accordion"><?php echo $lang['Why is “Delivered” displayed while I haven\'t received the package?']; ?></button>
                        <div class="panel">
                          <p>Answer</p>
                        </div>

                       <button class="accordion"><?php echo $lang['What if the order is held by customs?']; ?></button>
                        <div class="panel">
                          <p>Answer</p>
                        </div>

                        <button class="accordion"><?php echo $lang['How do I get the refund?']; ?></button>
                        <div class="panel">
                          <p>Answer</p>
                        </div>

                        <button class="accordion"><?php echo $lang['How do I check / find my refunded money on cash on delivery basis?']; ?></button>
                        <div class="panel">
                          <p>Answer</p>
                        </div>

                        <button class="accordion"><?php echo $lang['How can I open a dispute?']; ?></button>
                        <div class="panel">
                          <p>Answer</p>
                        </div>

                       <button class="accordion"><?php echo $lang['How can I cancel an order?']; ?></button>
                        <div class="panel">
                          <p>Answer</p>
                        </div>
                 </div>

               <h5 class="text-center"><?php echo $lang['Contact us']; ?></h5>
               <div class="contact-us-content">
                   <div class="row">
                       <div class="col-sm-12 col-md-6 col-lg-6 offset-md-3">
                           <div class="section-electronic-services _global">
                               <i class="fab fa-contao"></i>
                             <h6><?php echo $lang['Online service']; ?></h6>
                             <p><?php echo $lang['Online service']; ?></p>
                           </div>
                      </div>

                     <div class="col-sm-12 col-md-6 col-lg-6 offset-md-3">
                       <div class="section-questionnaire _global">
                           <i class="fas fa-pen-alt"></i>
                         <h6><?php echo $lang['A questionnaire']; ?></h6>
                         <p><?php echo $lang['A questionnaire']; ?></p>
                       </div>
                     </div>
                   </div><!--row -->
               </div>

           </div>
       </div>

<?php    } elseif ($kind == 'disputes') { ?>


   <div class="container">
     <h2 class="dispute-head text-center"><?php echo $lang['disputes']; ?></h2>
     <div class="row">
       <div class="col-12">
         <div class="tabs-content">
            <!-- Tab links -->
            <div class="tab">
              <button class="tablinks content_1 active" onclick="openCity(event, 'content_1')"><?php echo $lang['Refund policy']; ?></button>
              <button class="tablinks content_2" onclick="openCity(event, 'content_2')"><?php echo $lang['Return policy']; ?></button>
            </div>

            <!-- Tab content -->
            <div id="content_1" class="tabcontent" style="display: block;">
              <div class="storyInfo animated fadeInLeft">
                <button class="accordion"><?php echo $lang['Why is “Delivered” displayed while I haven\'t received the package?']; ?></button>
                    <div class="panel">
                      <p>Answer</p>
                    </div>

                  <button class="accordion"><?php echo $lang['What if the order is held by customs?']; ?></button>
                    <div class="panel">
                      <p>Answer</p>
                    </div>

                    <button class="accordion"><?php echo $lang['How do I check / find my refunded money on cash on delivery basis?']; ?></button>
                    <div class="panel">
                      <p>Answer</p>
                    </div>

                    <button class="accordion"><?php echo $lang['How can I open a dispute?']; ?></button>
                    <div class="panel">
                      <p>Answer</p>
                    </div>

                  <button class="accordion"><?php echo $lang['How can I cancel an order?']; ?></button>
                    <div class="panel">
                      <p>Answer</p>
                    </div>
                </div>
              </div>
                
              <div id="content_2" class="tabcontent">
                <button class="accordion"><?php echo $lang['How do I place an order using the cash on delivery service?']; ?></button>
                <div class="panel">
                  <p>Answer</p>
                </div>

                <button class="accordion"><?php echo $lang['Why is “Delivered” displayed while I haven\'t received the package?']; ?></button>
                <div class="panel">
                  <p>Answer</p>
                </div>

              <button class="accordion"><?php echo $lang['What if the order is held by customs?']; ?></button>
                <div class="panel">
                  <p>Answer</p>
                </div>

                <button class="accordion"><?php echo $lang['How do I get the refund?']; ?></button>
                <div class="panel">
                  <p>Answer</p>
                </div>

                <button class="accordion"><?php echo $lang['How do I check / find my refunded money on cash on delivery basis?']; ?></button>
                <div class="panel">
                  <p>Answer</p>
                </div>

                <button class="accordion"><?php echo $lang['How can I open a dispute?']; ?></button>
                <div class="panel">
                  <p>Answer</p>
                </div>

              <button class="accordion"><?php echo $lang['How can I cancel an order?']; ?></button>
                <div class="panel">
                  <p>Answer</p>
                </div>
            </div>
        </div>
        </div>
     </div>
    </div>

<?php } else {
        header('Location: index.php');
        exit();
    } 


    include $temp . 'footer.php';
    ob_end_flush(); // Release The Output
 ?>
