<?php 
session_start();
if (isset($_SESSION['id_user']) && isset($_SESSION['email'])&& isset($_SESSION['nikname']) && isset($_SESSION['registertime']) && isset($_SESSION['id_type'])) {
    $title = "Редактирование личных данных";
    $scriptaddimg = 1;
    $_SESSION['temp'] += 1;
    include "../db_conn.php";
    require_once ("../../public_html/header.php");
    

?>
<div class="mright__titleh1">Редактирование аккаунта</div>
<div class="mright__linetitleh1"></div>
<div class="mright__mycubblock">
    <div class="mycubblock__left">
        <img id="img" src="/static/userslogo/<?php echo $_SESSION['namefoto']?>?clearmeboi=<?php echo $_SESSION['temp']?>" alt="" class="downloadbut">
        <div class="edlogfoto">Нажмите на фото, чтобы его изменить</div>
    </div>
    <form action="editmylogintrue.php" method="post" class="mycubblock__right" enctype="multipart/form-data">
        <div class="mycubblock__changeline">
        <label for="email">Email:</label>
        <input type="text" id="email" name="email" value = "<?php echo $_SESSION['email'];?>">
        </div>
        <div class="mycubblock__changeline">
        <label for="nikname">Никнейм:</label>
        <input type="text" id="nikname" name="nikname" value = "<?php echo $_SESSION['nikname'];?>">
        </div>
       
        <div class="mycubblock__changelines">
            <div class="mycubblock__changelinesmall">
                <input type="checkbox" id="chpass" name="chpass" value="chpass" class="hidden">
                <label for="chpass" id="chpasstrue">Изменять пароль</label>
            </div>

            <div class="mycubblock__changelinesmall chpass">
                <label for="old-password">Старый пароль: </label>
                <input type="password" id="old-password" name="old-password">
            </div>
            <div class="mycubblock__changelinesmall chpass">
                <label for="new-password">Новый пароль: </label>
                <input type="password" id="new-password" name="new-password">
            </div>
            <div class="mycubblock__changelinesmall chpass">
                <label for="confirm-password">Повторите пароль: </label>
                <input type="password" id="confirm-password" name="confirm-password">
            </div>
        </div>
        <div class="mycubblock__changeliness">
            <input type="submit" value="Сохранить">
        </div>
        <input type="file" id="foto" name="foto" class="hidden">
        
    </form>
</div>


<?php 
require_once ("../../public_html/rightmain.php");
require_once ("../../public_html/footer.php");
}
else{
    header("Location: login.php");
}

?>