<?php 
session_start();
$title = "Лента";
$searchcategory = -1;
$isAdmin = false;
include "public_html/header.php";
?>
<div class="mright__titleh1">Лента</div>
<div class="mright__linetitleh1"></div>
<div class="result">
<?php 
include "modules/db_conn.php";

$sql = "SELECT state.id, state.statename, state.birthday, state.totalviews, state.statebody, category.name 
FROM state INNER JOIN category ON state.id_category = category.id order by state.birthday desc";
$result = $dbcnx->query($sql);
if($result->num_rows){
    foreach ($result as $row){
        $statename = $row['statename'];
        $name = $row['name'];
        $id = $row['id'];

        $views = $row['totalviews'];

        $bodyinfo = $row["statebody"];
        $bodyinfo = json_decode($bodyinfo, true);
        $img = $bodyinfo[0][1];
        
        $date = date("d.m.y", strtotime($row["birthday"]));
        $time = date("H:i",strtotime($row["birthday"]));
        $date =  $name.", ".$date . " в " . $time;
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
include "public_html/rightmain.php";
include "public_html/footer.php";
?>