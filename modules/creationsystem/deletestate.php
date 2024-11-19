<?php 
session_start();
if(isset($_GET['state'])){
    include "../db_conn.php";
    $temp = $_SESSION['id_user'];
    $state = $_GET['state'];
    $sql = "delete from state where id=$state && id_autor=$temp;";
    $result = $dbcnx->query($sql);
}








header("Location: ../loginsystem/mypage.php");
exit();

?>