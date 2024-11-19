<?php 
if(isset($_GET["state"])&& isset($_GET["iduser"])&&isset($_GET["idtype"]) ){
    include "db_conn.php"; 
    $st = $_GET["state"];
    $user = $_GET["iduser"];
    $type = $_GET["idtype"];
    $sql = "select * from emotionlist where id_state = $st and id_user = $user";
    $result = $dbcnx->query($sql);
    if($result->num_rows){
        $sql = "update emotionlist set id_type=$type where id_state = $st and id_user = $user;";   
    }
    else {
        $sql = "insert into emotionlist(id_type, id_user, id_state) values($type,$user, $st);";
    }
    echo $sql;
    $result = $dbcnx->query($sql);
}
header("location:state.php?state=$st");

?>