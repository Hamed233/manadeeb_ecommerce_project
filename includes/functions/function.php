<?php

       /*
       ** Get All Function v2.0
       ** Function To Get All Records Fron Any Database Table
       */

        function getAllFrom($field, $table, $where = NULL, $and = NULL, $orderField, $ordering = "DESC", $limit = NULL) {

            global $con;

            $getAll = $con->prepare("SELECT $field FROM $table $where $and ORDER BY $orderField $ordering $limit");
            $getAll->execute();
            $all = $getAll->fetchAll();

            return $all;
        }


/* ================================================================================= */



   /*
   ** Title Function v1.0
   ** Title Function That Echo The Page Title In Case The Page
   ** Has The Variable $pageTitle And Echo Defualt Title For Other Pages
   */


   function getTitle() {

       global $pageTitle;

       if (isset($pageTitle)) {

           echo $pageTitle;

       } else {

           echo 'Defualt';

       }
   }


   /*
   ** Home Redirect Function v2.0
   ** This Function Accept Parameters
   ** $theMsg   = Echo The  Message
   ** $url      = The Link You Want To Redirect To
   ** $seconds  = Seconds Before Redircting
   ** عمل فنكشن ديناميكية للتحول للصفحة الرئيسية
   */

    function redirectHome($theMsg, $url = null, $seconds = 3) {

        if ($url === null) {

            $url = 'index.php';
            $link = 'Homepage';
        } else {

            if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {

                $url = $_SERVER['HTTP_REFERER'];
                $link = 'Previous page';

            } else {

                $url = 'index.php';
                $link = 'Homepage';
            }

        }

        echo $theMsg;
        echo "<div class='alert alert-info'>You Will Redirected To $link After $seconds Seconds</div>";

        header("refresh:$seconds;url=$url");
        exit();
    }



     /*
     ********لعمل فنكشن تقوم بعمل فحص للبيانات اذا كانت موجوده أم لا؟؟؟؟؟**********
     ** Check Items Function v1.0
     ** Function To Check Item In Database [ Function Accept Parameters ]
     ** $select = Item To Select [ Example: user, item, categories]
     ** $from = The Table To Select From [ Example: users, items, category]
     ** $value = The Value Of Select [Example: Hamed, Box, Electronies]
     */


     function checkItem($select, $from, $value) {

         global $con;

         $sqlTwo = $con->prepare("SELECT $select FROM $from WHERE $select = ?");
         $sqlTwo->execute(array($value));
         $count = $sqlTwo->rowCount();
         return $count;

     }

     /*
     ** Count Number Of Items Function v1.0
     ** Function To Count Number Of Items Rows
     ** $item = The Item To Count
     ** $table = The Table To Choose From
     ** فنكشن لحساب عدد الصفوف فى اى جدول
     */

      function countItems($item, $table) {

          global $con;

        $sql2 = $con->prepare("SELECT COUNT($item) From $table");
        $sql2->execute();

        return $sql2->fetchColumn();
      }



       /*
       ** Get Latest Records Function v1.0
       ** Function To Get Latest Items From Database [Users, Items Comments]
       ** $select = Field To Select
       ** $table = The Table To Choose From
       ** $Limit = The Number Of Records To Get
       ** DESC = لجعل الجدول ترتيب تصاعدى
       ** فنكشن لعرض اى عدد من العناصر من قاعدة البيانات
       */

        function getLatest($select, $table, $order, $Limit = 5) {

            global $con;

            $sql3 = $con->prepare("SELECT $select FROM  $table ORDER BY $order DESC LIMIT 5");
            $sql3->execute();
            $rows = $sql3->fetchAll();

            return $rows;
        }

        // validate phone
        function validate_phone_number($phone){
         // Allow +, - and . in phone number
         $filtered_phone_number = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
         // Remove "-" from number
         $phone_to_check = str_replace("-", "", $filtered_phone_number);
         // Check the lenght of number
         // This can be customized if you want phone number from a specific country
         if (strlen($phone_to_check) < 10 || strlen($phone_to_check) > 14) {
            return false;
         } else {
           return true;
         }
        }


        // validate card
        function validatecard($number) {
          global $type;

            $cardtype = array(
                "visa"       => "/^4[0-9]{12}(?:[0-9]{3})?$/",
                "mastercard" => "/^5[1-5][0-9]{14}$/",
                "amex"       => "/^3[47][0-9]{13}$/",
                "discover"   => "/^6(?:011|5[0-9]{2})[0-9]{12}$/",
            );

            if (preg_match($cardtype['visa'],$number)) {
              	$type= "visa";
                return 'visa';
            } else if (preg_match($cardtype['mastercard'],$number)) {
              	$type= "mastercard";
                return 'mastercard';
            } else if (preg_match($cardtype['amex'],$number)) {
              	$type= "amex";
                return 'amex';
            } else if (preg_match($cardtype['discover'],$number)) {
              	$type= "discover";
                return 'discover';
            } else {
                return false;
            }
         }

         // validate inputs
         function test_input($data) {
             $data = trim($data);
             $data = stripslashes($data);
             $data = htmlspecialchars($data);
             return $data;
          }
