<?php
//category_id
//category_name
//hsn_code
//gst_rate
require_once("../../includes/functions.php");
session_start();

if(isset($_POST['edit_product'])){
    $category_id = $_POST['category_id'];
    $category_name = $_POST['category_name'];
    
    $employee_id = $_SESSION['employee_id'];
    
    $query = "UPDATE category SET category_name = '$category_name', updated_by = $employee_id,updated_at = now() WHERE category_id = $category_id";
    
    $result = mysqli_query($connection, $query);
    checkQueryResult($result);
    $_SESSION['status'] = CATEGORY_EDIT_SUCCESS;
    header("Location: http://".BASE_SERVER."/erp/pages/manage-category.php");
    exit();
}
?>