<?php 
    if(!isset($_GET["state"])) header("Location: ../loginsystem/mypage.php");
    $title = "Редактирование статьи";
    $scriptcreatestate = 1;
    require_once ("../../public_html/header.php");
    include "../db_conn.php";
    $idstate = $_GET["state"];
    $sql = "select * from state where id = $idstate";
    $result = $dbcnx->query($sql);
    foreach($result as $row){
        $name = $row["id_category"];
        $title = $row["statename"];
        $bodyinfo = $row["statebody"];
      }
      $bodyinfo = json_decode($bodyinfo, true);
      $img = $bodyinfo[0][1];
      $imgname = $bodyinfo[0][2];

?>
    <form class="mright__statecreate" method="post" enctype="multipart/form-data" action="editstatetrue.php" >
        <input type="hidden" name="id" value="<?php echo $idstate;?>">
        <div class="statecreateblock_title" >
            <textarea type="text" name="title" placeholder = "Заголовок"><?php echo $title;?></textarea>
            <span class="errcreate"></span>
        </div>
        <div class="statecreateblock" >
            <select name="category" id="category" class = "sselect">
            <option value="2" <?php if($name==2) echo "selected";?>>В мире</option>
            <option value="1" <?php if($name==1) echo "selected";?>>Общество</option>
            <option value="4" <?php if($name==4) echo "selected";?>>Спорт</option>
            <option value="3" <?php if($name==3) echo "selected";?>>Технологии</option>
            <option value="5" <?php if($name==5) echo "selected";?>>Экономика</option>
            <option value="6" <?php if($name==6) echo "selected";?>>Культура</option>
            </select>
            <span class="errcreate"></span>
        </div>

        <div class="statecreateblock" id="startmark">
            
            <div class="statecontent__img">
                <img id="foto" src="/static/states/<?php echo $img;?>" alt="" class="downloadbut"/>
                <input type="file" name="foto"  class="downloadbuthidden hidden">
                <input type = "text" class="statecontent__underimg" name="fotoname" placeholder="Фото с архива" value="<?php echo $imgname;?>">
            </div>

            <span class="errcreate"></span>
        </div>
        <?php 
            for($i =1; $i<count($bodyinfo); $i++){
                if($bodyinfo[$i][1]!=""){
                    echo "<div class='statecreateblock'>
                    <textarea name='area[]' class='aaa' placeholder='Вставте данные' >".$bodyinfo[$i][1]."</textarea>
                </div>";
                }
                
            }
        ?>
        <div class="statecreate_tegblock" id="endmark">
        <?php 
        $sql = "SELECT teg.id , teg.name, teg.phpname, 1 as fff
        FROM teg
        inner JOIN teglist ON teg.id = teglist.id_teg where teglist.id_state = $idstate
        union all  
        SELECT teg.id, teg.name, teg.phpname, 0 as fff
        FROM teg 
        where teg.id not in (select  teglist.id_teg from teglist where teglist.id_state = $idstate);
        ";
        $result = $dbcnx->query($sql);
        if($result->num_rows){
            foreach($result as $row){
              $idteg = $row['id'];
              $tegname = $row['name'];
              $phpname = $row['phpname'];
              $istrue = $row['fff'];
              ?>
                <div class='statecreate_tegitem <?php if($istrue==1) echo "currenttteg" ;?>' >
                <input type='checkbox' <?php if($istrue==1) echo "checked"; ?> id='teg_<?php echo $phpname?>' name='tegs[]' value=<?php echo $idteg; ?> class='hidden '>
                <label for='teg_<?php echo $phpname?>'><?php  echo $tegname; ?></label>
              </div>    
              <?php
            }
          }

         
        ?>

            
        </div>
        
        
        <input type="submit" value="Отправить">
        </form>


</div>

<div class="main__mleft">
    <div class="mleft__buttons">
        <div class="mleft__butblock">
        <div class="mleft__butblocktitle">Вставка абзацев</div>
        <div class="mleft__butblockline"></div>
        <div class="mleft__butblockbody">
        <button id="insertpbefore">Вставить до выбранного блока</button>
        <button id="insertpafter">Вставить после выбранного блока</button>
        <button id="insertpstart">Вставить в начало</button>
        <button id="insertpend">Вставить в конец</button>
        </div>
        </div>
        
        
        <div class="mleft__butblock">
        <div class="mleft__butblocktitle">Удаление</div>
        <div class="mleft__butblockline"></div>
        <div class="mleft__butblockbody">
        <button id="deletep">Удалить выбранный</button>
        </div>
        </div>
        

    </div>
<?php 
    require_once ("../../public_html/footer.php");
?>