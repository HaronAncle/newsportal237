<?php
$dblocation = "localhost";
$dbname = "newsportal";
$dbuser = "root";
$dbpasswd = "";
$dbcnx = @mysqli_connect($dblocation,$dbuser,$dbpasswd,$dbname);
if (!$dbcnx){
echo( "<p>Серверу не хорошо</p>" );
exit();}
?>