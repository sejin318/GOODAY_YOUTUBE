<?php 

$connection = mysqli_connect('localhost', 'amubros', 'amubros2020!', 'amubros'); 
if(!$connection){
    print mysqli_connect_error(); 
}

// find the key index of the last record 
$query = "SELECT wr_id FROM g5_write_$_GET[board] ORDER BY wr_id DESC LIMIT 1"; 
$result = mysqli_query($connection, $query); 
$wr_id = mysqli_fetch_assoc($result)["wr_id"] + 1; 

$wr_parent = $_GET["wr_parent"];
$query = "SELECT wr_num FROM g5_write_$_GET[board] WHERE wr_id = $wr_parent";
$result = mysqli_query($connection, $query); 
$wr_num = mysqli_fetch_assoc($result)["wr_num"]; 

$query = "INSERT INTO g5_write_$_GET[board] (wr_parent, wr_num, wr_is_comment, wr_comment, wr_comment_reply, wr_option, wr_subject, wr_content, wr_seo_title, wr_hit, wr_good, wr_nogood, mb_id, wr_name, wr_ip, wr_datetime) VALUES (
$_GET[wr_parent], 
$wr_num, 
$_GET[wr_is_comment],
$_GET[wr_comment],
'$_GET[wr_comment_reply]', 
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

$result = mysqli_query($connection, $query); 
if(!$result){
    echo "Error : ".mysqli_error($connection);
}
$query = "UPDATE g5_write_$_GET[board] SET wr_comment = wr_comment + 1 WHERE wr_id = $_GET[wr_parent]"; 
$result = mysqli_query($connection, $query); 
if(!$result){
    echo "Error : ".mysqli_error($connection);
}

?>