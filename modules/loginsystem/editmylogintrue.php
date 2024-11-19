<?php 
    session_start();
    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    if (isset($_POST['email']) && isset($_POST['nikname'])){
        $uname = validate($_POST['email']);
        $nik = validate($_POST['nikname']);
        $oldpass = validate($_POST['old-password']);
        $newpass= validate($_POST['new-password']);
        $confpass = validate($_POST['confirm-password']);
        if (empty($uname)) {
            header("Location: editmylogin.php?error=1Логин пользователя обязательно");
            exit();
        }
        if (empty($nik)) {
            header("Location: editmylogin.php?error=2Никнейм пользователя обязательно");
            exit();
        }
        include "../db_conn.php";
        if(isset($_POST['chpass'])){
            
            if (empty($oldpass) || empty($newpass) || empty($confpass)) {
                header("Location: editmylogin.php?error=3Заполнение полей паролей обязательно");
                exit();
            }
            if($newpass!=$confpass){
                header("Location: editmylogin.php?error=3Правильно повторите пароли");
                exit();
            }
            $temp = $_SESSION['id_user'];
            $sql = "select pass from useradd where id_user=$temp;";
            $result = $dbcnx->query($sql);
            $pass = md5(md5($oldpass));
            foreach($result as $row){
                $temp1 = $row["pass"];
            }
            if($pass != $temp1){
                header("Location: editmylogin.php?error=3Неправильный старый пароль");
                exit();
            }
            
        }
        if($uname != $_SESSION['email']){
            $sql = "SELECT * FROM users WHERE email='$uname'";
            $result = $dbcnx->query($sql);
            if($result->num_rows) {
                header("Location: editmylogin.php?error=1Логин занят");
                exit();
            }
        }
        $temp = $_SESSION['id_user'];
        $namefoto = $_SESSION['namefoto'];
        include('functions.php');
        if(isset($_FILES['foto'])) {
            $check = can_upload($_FILES['foto']);
            if($check == 0){
              $getMime = explode('.', $_FILES['foto']['name']);
              $mime = strtolower(end($getMime));
              $namefotos = $temp.rand();
              $rrr = make_upload($_FILES['foto'], $namefotos);
              $namefotos = $namefotos.'.'.$mime;
              if (!$rrr) header("Location: editmylogin.php?error=4Ошибка загрузки");
              make_delete($namefoto);
            }
            else if($check == 1){

            }
            else{
                header("Location: editmylogin.php?error=4$check");
            }
          }


        $sql = "update users set email = '$uname', nikname ='$nik', namefoto='$namefotos' WHERE id='$temp'";
        $result = $dbcnx->query($sql);

        if(isset($_POST['chpass'])){
            $pass = md5(md5($newpass));
            $sql = "update useradd set pass = '$pass' WHERE id_user='$temp'";
            $result = $dbcnx->query($sql);
        }
        clearstatcache(true);
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header("Location: mypage.php");
    }

?>




<?php 
    
?>