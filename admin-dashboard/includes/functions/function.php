<?php

       /*
       ** Get All Function v2.0
       ** Function To Get All Records Fron Any Database Table
       */

        function getAllFrom($field, $table, $where = NULL, $and = NULL, $orderField, $ordering = "DESC") {

            global $con;

            $getAll = $con->prepare("SELECT $field FROM $table $where ORDER BY $orderField $ordering");
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

    function redirectHome($theMsg, $url = null, $seconds = 1) {

        if ($url === null) {

            $url = 'index.php';
            $link = 'Homepage';
        } else {

            if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {

                $url  = $_SERVER['HTTP_REFERER'];
                $link = 'Previous page';

            } else {

                $url = 'index.php';
                $link = 'Homepage';
            }

        }

        echo $theMsg;
        echo "<div class='alert alert-info text-center'>You Will Redirected To $link After $seconds Seconds</div>";

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


        // validate inputs
        function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
        }