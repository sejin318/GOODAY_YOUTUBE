<?php 

$connection = mysqli_connect('localhost', 'amubros', 'amubros2020!', 'amubros'); 
if(!$connection){
    print mysqli_connect_error(); 
}
$query = "INSERT INTO aaa (b, c, d) VALUES (
$_GET[b], 
$_GET[c], 
$_GET[d]
)";

$result = mysqli_query($connection, $query); 

?>