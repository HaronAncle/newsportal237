


<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/public_html/css/style.css" />
    <title><?php echo $title ?></title>
    <script src="/public_html/js/script.js" defer></script>
    <?php 
    if(isset($scriptcreatestate)) echo '<script src="/public_html/js/scriptcreatestate.js" defer></script>';
    if(isset($scriptaddimg)) echo '<script src="/public_html/js/scriptaddimg.js" defer></script>';
    ?>
  </head>
  <body>
    <header class="header">
      <div class="head">
        <div class="container">
          <div class="head__div">
            <a href="/index.php" class="header__mainlogo">
              <img src="/public_html/img/mainlogo.svg" alt="" />
            </a>
            <div class="header__iconblock">
              <a class="header__logo logo" id="account" href="/modules/loginsystem/mypage.php">
                <img src="/public_html/img/user.svg" alt="" />
              </a>
              <a class="header__logo logo" id="searchbtn" href="/modules/search.php">
                <img src="/public_html/img/find.svg" alt="" />
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="headerline"></div>
      <div class="navigation">
        <div class="container">
          <div class="navigation__div">
            <a href="/modules/find.php?info=c2">В мире</a>
            <a href="/modules/find.php?info=c1">Общество</a>
            <a href="/modules/find.php?info=c4">Спорт</a>
            <a href="/modules/find.php?info=c3">Технологии</a>
            <a href="/modules/find.php?info=c5">Экономика</a>
            <a href="/modules/find.php?info=c6">Культура</a>
          </div>
        </div>
      </div>
    </header>
    <main class="main">
      <div class="container">
        <div class="main__div">
            <div class="main__mright">