<?php
session_start();
require_once("../../includes/functions.php");
$employee_id = $_SESSION['employee_id'];
/*SAMPLE CODE FOR UPLOADING A FILE*/
//$image_name = $_FILES['product_image']['name'];
//$image_size = $_FILES['product_image']['size'];
//$temp_name = $_FILES['product_image']['tmp_name'];
//$valid_extensions = array("jpeg", "jpg", "png");
//if(in_array($file_extension, $valid_extensions) == false){
//    $error_msg[] = "Image is not valid! Please choose a JPEG or PNG file!";
//}
//if($image_size>2097152){
//    $error_msg[] = "Image size is too huge! Please select image within 2MB size!";
//}
//if(empty($error_msg)){
//    move_uploaded_file($temp_name, "../../../assets/products/images/".$image_name);
//    echo "File Uploaded Successfully";
//}else{
//    print_r($error_msg);
//}
/* END OF SAMPLE CODE*/

if(isset($_POST['add_product'])){
    //Checking whether file was uploaded or not!
    if(isset($_FILES['product_image'])){
        //yes the file was uploaded so we are initializing all the required variables
        $image_name = $_FILES['product_image']['name'];
        $image_size = $_FILES['product_image']['size'];
        $temp_name = $_FILES['product_image']['tmp_name'];
        $file_extension = strtolower(end(explode(".",$image_name)));//TO LOWER ISILEYE KIYA QKI SERVER SIDE LINUX BASED HOTE H UDR CAPITAL JPG AND SMALL jpg DIFFERENT HOTE H!!!
    }
    $product_name = $_POST['product_name'];
    $rate_of_sale = $_POST['rate_of_sale'];
    $additional_specification = $_POST['additional_specification'];
    $category_id = $_POST['category_id'];
    $eoq = $_POST['eoq'];
    $suppliers = $_POST['supplier_id'];
    
    $tablename = "product";
    $columns = "product_name, eoq, additional_specification, category_id, image_extension, created_by";
    $values = "'$product_name', $eoq,'$additional_specification', $category_id, '$file_extension', $employee_id";
    $result = insert($tablename,$columns,$values);
    $product_id = mysqli_insert_id($connection);
    //PRODUCT ADDED AND FETCHED LATEST PRODUCT ID
    $tablename = "product_sale_rate";
    $columns = "product_id, rate_of_sale, wef, created_by";
    $values = "$product_id, $rate_of_sale, now(), $employee_id";
    $result = insert($tablename,$columns,$values);
    
    $tablename = "product_supplier";
    $columns = "product_id, supplier_id";
    foreach($suppliers as $supplier_id){
        $values = "$product_id, $supplier_id";
        $result = insert($tablename,$columns,$values);
    }
    move_uploaded_file($temp_name, "../../../assets/products/images/".$product_id.".".$file_extension);
    $_SESSION['status'] = PRODUCT_ADD_SUCCESS;
}
?>