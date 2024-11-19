<?php 
$info = $_GET["info"];
include "db_conn.php";
$category;
if($info[0]=='c') {
    $category = $info[1];
    $sql = "SELECT name FROM category where id = $info[1]";
    $result = $dbcnx->query($sql);
    if($result->num_rows) {
        //
        foreach($result as $row){
            $title = $row["name"];
        }
    }
    else  {
        $title = "Все категории";
    }
}
elseif($info[0]=='t'){
    $temp = $dbcnx->real_escape_string($info);
    $temp = mb_substr($temp, 1);
    $sql = "SELECT id, name FROM teg where phpname = '$temp'";
    $result = $dbcnx->query($sql);
    if($result->num_rows) {
        //
        foreach($result as $row){
            $title = "Тег ".$row["name"]."";
            $temp = $row["id"];
            
        }
        //
        //$sql = "SELECT id_state FROM teglist where id_teg = $temp"; 
    }
    else  {
        $title = "Все теги";
    }
}
else {
    //для обработки поиска

}
require_once ("../public_html/header.php");

echo '<div class="mright__titleh1">'.$title.'</div>
<div class="mright__linetitleh1"></div>';
?>
<div class="result">
<?php 
if($info[0]=='c'){
    $sql = "SELECT state.id, state.statename, state.birthday, state.totalviews, state.statebody, category.name 
    FROM state inner join category on category.id=state.id_category where state.id_category = $category order by state.birthday desc";
}
elseif ($info[0]=='t') {
    $sql = "SELECT state.id, state.statename, state.birthday, state.totalviews, state.statebody, category.name  
    FROM state inner join category on category.id=state.id_category where state.id in (SELECT teglist.id_state FROM teglist WHERE teglist.id_teg = $temp) order by state.birthday desc";
}
$result = $dbcnx->query($sql);
if($result->num_rows){
    foreach ($result as $row){
        $statename = $row['statename'];
        $id = $row['id'];
        $categoryname =$row["name"];
        $views = $row['totalviews'];

        $bodyinfo = $row["statebody"];
        $bodyinfo = json_decode($bodyinfo, true);
        $img = $bodyinfo[0][1];
        
        $date = date("d.m.y", strtotime($row["birthday"]));
        $time = date("H:i",strtotime($row["birthday"]));
        $date =  $categoryname.", ".$date . " в " . $time;
        ?>

        <div class="result__item">
                <div class="ritem__line"></div>
                <a href = "/modules/state.php?state=<?php echo $id; ?>" class="ritem__block">
                  <div class="ritem__left">
                    <div class="ritem__title">
                    <?php echo $statename; ?>
                    </div>
                    <div class="ritem__info">
                      <span><?php echo $date;?></span>
                      <img src="/public_html/img/eye.svg" alt="" />
                      <span><?php echo $views; ?></span> 
                    </div>
                  </div>
                  <div class="ritem__right">
                    <img src="/static/states/<?php echo $img; ?>" alt="" />
                  </div>
                </a>
              </div>


        <?php         
    }


}
else {
    echo "Ничего не найдено";
}

// for($i =0 ;$i<3;$i++){
//   echo '<div class="result__item">
//                 <div class="ritem__line"></div>
//                 <a href = "/modules/state.php" class="ritem__block">
//                   <div class="ritem__left">
//                     <div class="ritem__title">
//                       В республике представят новые модели кибер-футболистов, в том числе синекожих. Это является крайне выгодным вложением для всех нас.
//                     </div>
//                     <div class="ritem__info">
//                       <span>Спорт, 19 октября, 22:44</span>
//                       <img src="/public_html/img/eye.svg" alt="" />
//                       <span>297</span> 
//                     </div>
//                   </div>
//                   <div class="ritem__right">
//                     <img src="/public_html/img/mok.png" alt="" />
//                   </div>
//                 </a>
//               </div>';
// }

?>

</div >

<?php

require_once ("../public_html/rightmain.php");
require_once ("../public_html/footer.php");
?>