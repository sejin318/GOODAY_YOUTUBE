<?php 

$connection = mysqli_connect('localhost', 'amubros', 'amubros2020!', 'amubros'); 
if(!$connection){
    print mysqli_connect_error(); 
}

// find the key index of the last record 
$query = "UPDATE g5_visit_sum SET vs_count = vs_count + 1 ORDER BY vs_date DESC LIMIT 1"; 
$result = mysqli_query($connection, $query); 

if(!$result){
    echo "Error : ".mysqli_error($connection);
}

?>