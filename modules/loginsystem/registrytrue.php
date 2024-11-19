<?php 
session_start();
if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['nikname']) && isset($_POST['passconf'])){
    function validate($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
    }
    $uname = validate($_POST['email']);
    $pass = validate($_POST['password']);
    $nik = validate($_POST['nikname']);
    $passconf = validate($_POST['passconf']);
    if (empty($uname)) {
        header("Location: registry.php?error=1Логин пользователя обязательно");
        exit();
    }
    if (empty($nik)) {
        header("Location: registry.php?error=2Никнейм пользователя обязательно");
        exit();
    }
        if(empty($pass)) {
        header("Location: registry.php?error=3Пароль обязателен");
        exit();
    }
    if (empty($passconf)) {
        header("Location: registry.php?error=4Повторение пароля обязательно");
        exit();
    }
    if ($passconf != $pass) {
        header("Location: registry.php?error=4Правильно подтвердите пароль");
        exit();
    }
    $sql = "SELECT * FROM users WHERE email='$uname'";
    include "../db_conn.php";
    $result = $dbcnx->query($sql);
    if($result->num_rows) {
        header("Location: registry.php?error=1Логин занят");
        exit();
    }
    else{
        $sql = "insert into users (email, nikname, registertime) values ('$uname','$nik',NOW());";
        $result = $dbcnx->query($sql);
        $sql = "select id from users where email = '$uname' and nikname = '$nik';";
        $result = $dbcnx->query($sql);
        $pass = md5(md5($pass));
        foreach($result as $row){
           $temp = $row["id"];   
           $sql = "insert into useradd values ($temp,'$pass');";
           $result = $dbcnx->query($sql);
           $sql = "select email,nikname, id_type, registertime, namefoto from users where id=$temp;";
           $result = $dbcnx->query($sql);
           foreach($result as $row){
            $_SESSION['email'] = $row["email"];
            $_SESSION['nikname'] = $row["nikname"];
            $_SESSION['id_user'] = $temp;
            $_SESSION['registertime'] = $row["registertime"];
            $_SESSION['id_type'] = $row["id_type"];
            $_SESSION['namefoto'] = $row["namefoto"];
           }
        }
        header("Location: mypage.php");
        exit();
    }
}
else {
    header("Location: registry.php?error=1Заполните все поля");
    exit();
}
?>