<?php 

$connection = mysqli_connect('localhost', 'amubros', 'amubros2020!', 'amubros'); 
if(!$connection){
    print mysqli_connect_error(); 
}

$query = "SELECT wr_id FROM g5_write_entertainment ORDER BY wr_id DESC LIMIT 1"; 
$result = mysqli_query($connection, $query);
$wr_id = mysqli_fetch_assoc($result)["wr_id"];

$query = "UPDATE g5_write_entertainment SET wr_parent = $wr_id WHERE wr_id = $wr_id"; 
$result = mysqli_query($connection, $query); 

echo $wr_id; 

$query = "SELECT wr_num FROM g5_write_entertainment ORDER BY wr_num ASC LIMIT 1"; 
$result = mysqli_query($connection, $query); 
$wr_num = mysqli_fetch_assoc($result)["wr_num"] - 1; 
echo $wr_num; 
?>