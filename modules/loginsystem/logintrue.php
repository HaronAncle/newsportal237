<?php 

session_start();
if (isset($_POST['email']) && isset($_POST['password'])){
    function validate($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
    }
    $uname = validate($_POST['email']);
    $pass = validate($_POST['password']);
    if (empty($uname)) {
        header("Location: login.php?error=1Имя пользователя обязательно");
        exit();
    }
    if(empty($pass)) {
        header("Location: login.php?error=2Пароль обязателен");
        exit();
    }

    // 
    $sql = "SELECT id FROM users WHERE email='$uname'";
    include "../db_conn.php";
    $result = $dbcnx->query($sql);
    if(!($result->num_rows)) {
        header("Location: login.php?error=1Неправильный логин или пароль");
        exit();
    }
    else{
        foreach($result as $row){
            $temp = $row["id"];  
        }
        $sql = "select pass from useradd where id_user=$temp limit 1;";
        $result = $dbcnx->query($sql);
        $pass = md5(md5($pass));

        foreach($result as $row){
            $temp1 = $row["pass"];
        }

        if($pass != $temp1){
            header("Location: login.php?error=1Неправильный логин или пароль");
            exit();
        }
        else{
            $sql = "select email,nikname, id_type, registertime,namefoto from users where id=$temp;";
            $result = $dbcnx->query($sql);
            foreach($result as $row){
             $_SESSION['email'] = $row["email"];
             $_SESSION['nikname'] = $row["nikname"];
             $_SESSION['id_user'] = $temp;
             $_SESSION['registertime'] = $row["registertime"];
             $_SESSION['id_type'] = $row["id_type"];
             $_SESSION['namefoto'] = $row["namefoto"];
 
            }
            header("Location: mypage.php");
            exit();
        }
        
    }
}
else {
    header("Location: login.php?error=1Заполните все поля");
    exit();
}
?>