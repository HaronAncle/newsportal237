<?php
$title = "Авторизация";
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
        <form method="post" action="logintrue.php" class="login__div">
          <div class="login__up">
            <div class="login__logo">Haron.news</div>
            <div class="login__title">Вход в аккаунт</div>
          </div>
          <div class="login__center">
            <div class="login__block">
              <label for="email">Ваш email</label>
              <input  name="email" id="email" type="text" placeholder="Email" autocomplete="on" />
              <span  class="errordiv" ><?php 
              if($errnum == 1){
                echo $err;
              }
              
              ?></span>
            </div>

            <div class="login__block">
              <label for="password">Пароль</label>
              <input name="password" id="password" type="password" placeholder="Пароль " autocomplete="off" maxlength="14" />
               <span  class="errordiv"><?php if($errnum == 2){
                echo $err;
              }?></span>
            </div>
          </div>
          <div class="login__down">
            <input type="submit" value="Войти" />
            <div class="login__buttons">
              <button type="reset">Очистить</button>
              <a class="return" href="../../index.php">Назад</a>
            </div>
          </div>
          <div class="login__additional">
            <pre>Нет аккаунта? </pre>
            <a href="registry.php">Зарегистрироваться</a>
          </div>
        </form>
      </div>
    </div>

    </body>
</html>
