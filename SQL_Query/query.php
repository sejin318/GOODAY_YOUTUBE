<?php 

$connection = mysqli_connect('localhost', 'amubros', 'amubros2020!', 'amubros'); 
if(!$connection){
    print mysqli_connect_error(); 
}
$query = "INSERT INTO g5_$_GET[board] (wr_num, wr_parent, wr_is_comment, wr_comment, wr_comment_reply, wr_option, wr_subject, wr_content, wr_seo_title, wr_hit, wr_good, wr_nogood, mb_id, wr_name, wr_datetime, wr_last, wr_ip) VALUES (
$_GET[wr_num], 
$_GET[wr_parent],
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
'$_GET[wr_datetime]',
'$_GET[wr_last]',
'$_GET[wr_ip]'
)";

$result = mysqli_query($connection, $query); 
if(!$result){
    echo "Error : ".mysqli_error($connection);
}
?>