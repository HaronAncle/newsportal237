<?php
$title = "Регистрация";

$errnum = 0;
$err ="";
if (isset($_GET['error'])){
  $errnum = $_GET['error'][0];
  $err = mb_substr($_GET['error'],1);
}
?>

<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/public_html/css/style.css" />
    <title><?php echo $title ?></title>
    <script src="/public_html/js/script.js" defer></script>
  </head>
  <body>

<div class="login">
<div class="container">
  <form method="post" action="registrytrue.php" class="login__div">
    <div class="login__up">
      <div class="login__logo">Haron.news</div>
      <div class="login__title">Регистрация</div>
    </div>
    <div class="login__center">
      <div class="login__block">
        
        <label for="email">Ваш email</label>
        <input  name="email" id="email" type="text" placeholder="Email" autocomplete="on" />
        <span  class="errordiv"><?php if($errnum == 1){
                echo $err;
              }?></span>
      </div>
      <div class="login__block">
          
          <label for="nikname" >Ваш псевдоним</label>
          <input  name="nikname" id="nikname" type="text" placeholder="Псевдоним" maxlength="14" autocomplete="off">
          <span  class="errordiv"><?php if($errnum == 2){
                echo $err;
              }?></span>
      </div>
      <div class="login__block">
        <label for="password">Пароль</label>
        <input name="password" id="password" type="password" placeholder="Пароль " autocomplete="off" maxlength="14" />
        <span  class="errordiv"><?php if($errnum == 3){
                echo $err;
              }?></span>
      </div>

      <div class="login__block">
      <label for="passconf">Повторите пароль</label>
        <input name="passconf" id = "passconf" type="password" placeholder="Повторите пароль" autocomplete="off" maxlength="14" />
        <span class="errordiv"><?php if($errnum == 4){
                echo $err;
              }?></span>

  </div>
    </div>
    <div class="login__down">
      <input type="submit" value="Войти" />
      <div class="login__buttons">
        <button type="reset">Очистить</button>
        <a href="../../index.php" class="return" >Назад</a>
      </div>
    </div>
    <div class="login__additional">
      <pre>Есть аккаунт? </pre>
      <a href="login.php">Войти</a>
    </div>
  </form>
</div>
</div>
</body>
</html>