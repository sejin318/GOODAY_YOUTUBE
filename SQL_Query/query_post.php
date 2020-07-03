<?php 

$connection = mysqli_connect('localhost', 'amubros', 'amubros2020!', 'amubros'); 
if(!$connection){
    print mysqli_connect_error(); 
}
// find the key index of the last record 
$query = "SELECT wr_id FROM g5_write_$_GET[board] ORDER BY wr_id DESC LIMIT 1"; 
$result = mysqli_query($connection, $query); 
$wr_id = mysqli_fetch_assoc($result)["wr_id"] + 1; 

// find the sub index of the last posting 
$query = "SELECT wr_num FROM g5_write_$_GET[board] ORDER BY wr_num ASC LIMIT 1"; 
$result = mysqli_query($connection, $query); 
$wr_num = mysqli_fetch_assoc($result)["wr_num"] - 1; 

$query = "INSERT INTO g5_write_$_GET[board] (wr_num, wr_is_comment, wr_option, wr_subject, wr_content, wr_seo_title, wr_hit, wr_good, wr_nogood, mb_id, wr_name, wr_ip, wr_datetime) VALUES (
$wr_num, 
$_GET[wr_is_comment],
'$_GET[wr_option]',
'$_GET[wr_subject]',
'$_GET[wr_content]',
'$_GET[wr_seo_title]',
$_GET[wr_hit],
$_GET[wr_good],
$_GET[wr_nogood],
'$_GET[mb_id]',
'$_GET[wr_name]',
'$_GET[wr_ip]', 
'$_GET[wr_datetime]'
)";

//$query = "INSERT INTO g5_write_$_GET[board] (wr_option) VALUES ('$_GET[wr_option]')";

$result = mysqli_query($connection, $query); 
if(!$result){
    echo "Error : ".mysqli_error($connection);
}

// get the wr_id of last added record from the database and use it for updating the record's parent
$query = "SELECT wr_id FROM g5_write_$_GET[board] ORDER BY wr_id DESC LIMIT 1"; 
$result = mysqli_query($connection, $query);
$wr_id = mysqli_fetch_assoc($result)["wr_id"];

//echo "@@@@@@@@@@@@@@@@@@@@            $wr_id"; 

$query = "UPDATE g5_write_$_GET[board] SET wr_parent = $wr_id WHERE wr_id = $wr_id"; 
//$query = "UPDATE g5_write_$GET[board] SET wr_parent = $wr_id WHERE wr_id = $wr_id"; 
$result = mysqli_query($connection, $query);
if(!$result){
    echo "!!!!!!!!!!!!!!!!!!!!!!!!!"; 
}

// output the current post's id 
echo "<div id=wr_id>$wr_id</div>"; 










?>