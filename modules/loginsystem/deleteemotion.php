<?php 
   session_start();
   if(isset($_GET['em'])){
       include "../db_conn.php";
       $em = $_GET['em'];
       $sql = "delete from emotionlist where id=$em;";
       $result = $dbcnx->query($sql);
   }
   
   
   
   
   
   
   
   
   header("Location: mypage.php");
   exit();
?>