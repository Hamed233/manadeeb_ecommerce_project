
<?php
include '../../config/connectDB.php';
error_reporting( ~E_NOTICE ); // avoid notice

// Update Category Image
if(isset($_POST["action"])) {
   // Img info
    $Img     = $_FILES['image'];
    $ImgName = $_FILES['image']['name'];
    $ImgSize = $_FILES['image']['size'];
    $ImgTmp  = $_FILES['image']['tmp_name'];
    $ImgType = $_FILES['image']['type'];

    // List Of Allowed File Typed To Upload
    $ImgAllowedExtention = array("jpeg", "jpg", "png", "gif");
    // Get cateImg Extention
    $ImgEtention = strtolower(end(explode('.', $ImgName)));

    $formErrors = array();

    if (! empty($ImgName) && ! in_array($ImgEtention, $ImgAllowedExtention)) { $formErrors[] = 'This Extention Is Not <strong> Allowed </strong>'; }
    if ($ImgSize > 4194304) { $formErrors[] = 'This Image Can\'t Larger Than <strong> 4MB </strong>'; }

    if (empty($formErrors)) {

        if ($_POST["action"] == "update_img") {
            $productImg = rand(0, 1000000) . '_' . $ImgName;

            
            move_uploaded_file($ImgTmp, "../../upload\products\\" . $productImg);
            $tmp = '../../upload/products/'. $productImg;
            $new = '../../admin-dashboard/upload/products/'. $productImg;
            $cpy = copy($tmp, $new);
            move_uploaded_file($ImgTmp, $cpy);

            $query = $con->prepare("UPDATE products SET p_picture = '$productImg' WHERE p_id = '".$_POST["image_id"]."'");
            $query->execute();
            $row = $query->rowCount();

            if($row > 0){
            echo 'Image Updated Into Database, please reload page for show all updates!';
            }
        } 
 }
}
?>
