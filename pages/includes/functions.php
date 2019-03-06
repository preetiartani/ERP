<?php
require_once("db.php");

function checkQueryResult($resultset){
    global $connection;
  if(!$resultset){
      die("QUERY FAILED: " . mysqli_error($connection));
  }
}
function getLoggedInEmployeeName($loggedInId){
    global $connection;
    $query = "SELECT * FROM employee WHERE employee_id = $loggedInId";
    $employee_details = mysqli_query($connection, $query);
    checkQueryResult($employee_details);
    if($row = mysqli_fetch_assoc($employee_details)){
        return ($row['employee_name']);
    }
}
function insert($tableName, $columns, $values){
    global $connection;
    $query = "INSERT INTO $tableName($columns) VALUES ($values)";
    
    $resultset = mysqli_query($connection, $query);
    checkQueryResult($resultset);
    return $resultset;
}
function deleteRecord($tableName, $primaryKeyColumnName, $primaryKeyValue, $employeeID){
    global $connection;
    $query = "UPDATE $tableName SET deleted = 1, deleted_at = now(), deleted_by = $employeeID WHERE $primaryKeyColumnName = $primaryKeyValue";
    $resultset = mysqli_query($connection, $query);
    checkQueryResult($resultset);
    return $resultset;
}
function redirect($url){
    header("Location: $url");
    exit();
}

?>