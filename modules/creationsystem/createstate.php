<?php 
    $title = "Создание статьи";
    $scriptcreatestate = 1;
    require_once ("../../public_html/header.php");
    include "../db_conn.php";

?>
<!--  -->
    <form class="mright__statecreate" method="post" enctype="multipart/form-data"action="createstatetrue.php" >
        <div class="statecreateblock_title" >
            <textarea type="text" name="title" placeholder = "Заголовок"></textarea>
            <span class="errcreate"></span>
        </div>
        <div class="statecreateblock" >
            <select name="category" id="category" class = "sselect">
            <option value="*" selected>Выберите категорию</option>
            <option value="2">В мире</option>
            <option value="1">Общество</option>
            <option value="4">Спорт</option>
            <option value="3">Технологии</option>
            <option value="5">Экономика</option>
            <option value="6">Культура</option>
            </select>
            <span class="errcreate"></span>
        </div>

        <div class="statecreateblock" id="startmark">
            
            <div class="statecontent__img">
                <img id="foto" src="/static/states/defstate.png" alt="" class="downloadbut"/>
                <input type="file" name="foto"  class="downloadbuthidden hidden">
                <input type = "text" class="statecontent__underimg" name="fotoname" placeholder="Фото с архива">
            </div>

            <span class="errcreate"></span>
        </div>
        <div class="statecreateblock">
            <textarea name="area[]" class="aaa" placeholder="Вставте данные" ></textarea>
        </div>
        <div class="statecreateblock">
            <textarea name="area[]" class="aaa" placeholder="Вставте данные"></textarea>
        </div>
        
        <div class="statecreate_tegblock" id="endmark">
        <?php 
        $sql = "select id, name,phpname from teg";
        $result = $dbcnx->query($sql);
        if($result->num_rows){
            foreach($result as $row){
              $idteg = $row['id'];
              $tegname = $row['name'];
              $phpname = $row['phpname'];
              echo "
              <div class='statecreate_tegitem'>
                <input type='checkbox' id='teg_$phpname' name='tegs[]' value=$idteg class='hidden'>
                <label for='teg_$phpname'>$tegname</label>
              </div>          
              ";
            }
          }
        ?>

            
        </div>
        <input type="submit"  value="Отправить">
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