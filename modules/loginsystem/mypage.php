<?php 
session_start();
header('Cache-Control: no-cache, no-store, must-revalidate');
if (isset($_SESSION['id_user']) && isset($_SESSION['email'])&& isset($_SESSION['nikname']) && isset($_SESSION['registertime']) && isset($_SESSION['id_type'])) {
    $title = "Личный кабинет";
    require_once ("../../public_html/header.php");
    include "../db_conn.php";
    $temp = $_SESSION['id_user'];
    $sql = "select email,nikname, id_type, namefoto from users where id=$temp;";
    $result = $dbcnx->query($sql);
    foreach($result as $row){
        $_SESSION['email'] = $row["email"];
        $_SESSION['nikname'] = $row["nikname"];
        $_SESSION['id_type'] = $row["id_type"];
        $_SESSION['namefoto'] = $row["namefoto"];
    }
    $_SESSION['temp'] = 0;
?>

<div class="mright__titleh1">Личный кабинет</div>
<div class="mright__linetitleh1"></div>

<div class="mright__mycubblock">
    <div class="mycubblock__left">
        <img src="/static/userslogo/<?php echo $_SESSION['namefoto']?>?clearmeboi=<?php echo $_SESSION['temp']?>" alt="">
    </div>
    <div class="mycubblock__right">
        <div class="mycubblock__line"><b>Email:</b> <?php echo $_SESSION['email'];?></div>
        <div class="mycubblock__line"><b>Никнейм:</b> <?php echo $_SESSION['nikname']?></div>
        <div class="mycubblock__line"><b>Статус:</b> <?php 
        if($_SESSION['id_type']==1) echo "читатель";
        elseif($_SESSION['id_type']==2) echo "автор";
        elseif($_SESSION['id_type']==3) echo "администратор";
        ?></div>
        <div class="mycubblock__line"><b>Дата регистрации:</b> <?php 
            $date = date("d.m.y", strtotime($_SESSION['registertime']));
            $time = date("H:i",strtotime($_SESSION['registertime']));
            echo $date . " в " . $time;
        
        ?></div>
        <div class="mycubblock__lineblock">
        <form action="editmylogin.php" method="post"><input type="submit" value="Администрирование аккаунта"></form>
        <form action="logout.php" method="post"><input type="submit" value="Выйти с аккаунта" ></form>
        </div>

    </div>
</div>
<div class="mright__myactivity">
    <div class="myactivity__title">Ваша активность</div>
    <div class="myactivity__line"></div>
    <div class="myactivity__table">
    <?php 
    $sql = "SELECT e.id, e.id_state, t.name, s.statename
    FROM emotionlist e 
    JOIN emotiontype t ON e.id_type = t.id 
    join state s ON e.id_state = s.id 
    WHERE e.id_user = $temp
    order by e.id;";
    $result = $dbcnx->query($sql);
    if($result->num_rows){
?>
<table>
<tr>
    <th >Реакция</th>
    <th colspan="2">На статью</th>
</tr>
<?php 
    foreach($result as $row){
        $idstate = $row["id_state"];
        $name = $row["name"];
        $statename = $row["statename"];
        $id = $row["id"];
        echo "<tr>
        <td class='center'>$name</td>
        <td ><a class='fontweight500' href='../state.php?state=".$idstate."'>$statename</a></td>
        <td>
        <form action='deleteemotion.php?em=".$id."' method='post'>
            <input type='submit' value='Удалить реакцию'>
         </form>
        </td>
        </tr>";
    }

?>

</table>
<?php

    }
    else {
        echo "Вы не оставляли эмоций";
    }
    
    
    ?>
    </div>
</div>


<?php 
    //if writer start
    if($_SESSION['id_type']==2){
        ?>
    <div class="mright__statestable">
    <div class="statestable__title">Ваши статьи</div>
    <div class="statestable__line"></div>
    <div class="statestable__table">
        <?php 
        
            $sql = "SELECT state.id, state.statename, state.birthday, category.name FROM state INNER JOIN category ON state.id_category = category.id
            WHERE state.id_autor = $temp order by state.birthday desc;";
            $result = $dbcnx->query($sql);
            if($result->num_rows){
           
        ?>
        
        <table>
            <tr>
                <th>Дата</th>
                <th>Категория</th>
                <th colspan="3">Название</th>

            </tr>
  
            <?php
                foreach ($result as $row){
                    $statename = $row['statename'];
                    $name = $row['name'];
                    $id = $row['id'];
                    $date = date("d.m.Y", strtotime($row['birthday']));
                    echo 
                    "<tr>
                        <td>$date</td>
                        <td>$name</td>
                        <td ><a class='fontweight500' href='../state.php?state=".$id."'>$statename</a></td>
                        <td>
                        <form action='../creationsystem/editstate.php?state=".$id."' method='post'>
                        <input type='submit' value='Редактировать'>
                        </form>
                        </td>
                        <td>
                        <form action='../creationsystem/deletestate.php?state=".$id."' method='post'>
                            <input type='submit' value='Удалить'>
                         </form>
                        </td>
                    </tr>
                    ";
                }
            ?>

        </table>
        <div class="statestable__statecount">Всего у вас <?php echo $result->num_rows?> статей</div>
        <?php
      }
            else{
                echo "Нет ваших статей";
            }
        ?>

        <form action="../creationsystem/createstate.php" method="post">
            <input type="submit" class="createnew" value="Создать новую статью">
        </form>
    </div>
    </div>

    <?php 
    $sql = "select * from state where id_autor=$temp;";
    $result = $dbcnx->query($sql);
    if($result->num_rows){

    }
    else{
        echo "Нет ваших статей";
    }





    }
     //if writer end
?>

<?php 
    //if admin start
    if($_SESSION['id_type']==3){
        ?>

        <?php 
    }
     //if admin end
?>



<?php 
require_once ("../../public_html/rightmain.php");
require_once ("../../public_html/footer.php");
}
else{
    header("Location: login.php");
}

?>