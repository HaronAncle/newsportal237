<?php 
$title = "Поиск";
require_once ("../public_html/header.php");

$linesearch="";
$category="*";
$datesort = "*";
$typesort = "new";
$tegsfind = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if(isset($_POST["linesearch"])&&isset($_POST["time"])&&isset($_POST["sort"])&&isset($_POST["category"])&&isset($_POST["teg"])){
    $linesearch=$_POST["linesearch"];
    $category=$_POST["category"];
    $datesort = $_POST["time"];
    $typesort = $_POST["sort"];
    $tegsfind = trim($_POST["teg"]);
  }
}
else{
  if(isset($_GET["linesearch"])&&isset($_GET["time"])&&isset($_GET["sort"])&&isset($_GET["category"])&&isset($_GET["teg"])){
    $linesearch=$_GET["linesearch"];
    $category=$_GET["category"];
    $datesort = $_GET["time"];
    $typesort = $_GET["sort"];
    $tegsfind = $_GET["teg"];
  }
}
include "db_conn.php";





$where = "";
if($category == "*"){
  $where= $where."";
}
else{
  if($category == "world") $where = $where." id_category = 2 ";
  else if($category == "society") $where = $where." id_category = 1 ";
  else if($category == "sport")$where = $where." id_category = 4 ";
  else if($category == "techno")$where = $where." id_category = 3 ";
  else if($category == "economy")$where = $where." id_category = 5 ";
  else if($category == "culture")$where = $where." id_category = 6 ";
}

if($where!="") $where  = $where." and ";
if($datesort == "*"){
  $where  = $where."";
}
elseif($datesort == "year"){
  $where  = $where." state.birthday >= DATE_SUB(NOW(), INTERVAL 1 year)";
}
elseif($datesort == "mounth"){
  $where  = $where." state.birthday >= DATE_SUB(NOW(), INTERVAL 1 month)";
}
elseif ($datesort == "week"){
  $where  = $where." state.birthday >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
}
elseif ($datesort == "day"){
  $where  = $where." state.birthday >= DATE_SUB(NOW(), INTERVAL 1 DAY)";
}

if($linesearch!=""){
  if($where!="") $where = $where." and state.statename like '%".$linesearch."%'";
  else $where = $where."state.statename like '%".$linesearch."%'";
  
}
$teg="";
if($tegsfind!="") {
  $teg = "INNER JOIN teglist ON state.id = teglist.id_state INNER JOIN teg ON teglist.id_teg = teg.id";
  if($where!="") $where = $where." and teg.name like '%".$tegsfind."%'";
  else $where = $where."teg.name like '%".$tegsfind."%'";
}
if($where!="") $where = "where ".$where;


if($typesort == "new"){
  $orderby = "state.birthday";
}
else{
  $orderby = "state.totalviews";
}


$sql = "SELECT state.id, state.statename, state.birthday, state.totalviews, state.statebody, category.name 
FROM state INNER JOIN category ON state.id_category = category.id $teg $where  order by $orderby desc ";
$result = $dbcnx->query($sql);

?>


 <div class="search">
              <form class="search__form" method = "get"  >
                <div class="search__inputblock">
                  <input type="text" placeholder="Поиск ..." name="linesearch" value="<?php echo $linesearch;?>"/>
                  <input type="submit" value="Найти" />
                </div>
                <div class="search__line"></div>
                <div class="search__materealscount"><?php echo $result->num_rows;?> материалов</div>
                <div class="search__sorted">
                  <select class="select" name="time">
                    <option value="*" <?php if($datesort=="*") echo "selected";?>>За все время</option>
                    <option value="year" <?php if($datesort=="year") echo "selected";?>>За год</option>
                    <option value="mounth" <?php if($datesort=="mounth") echo "selected";?>>За месяц</option>
                    <option value="week" <?php if($datesort=="week") echo "selected";?>>За неделю</option>
                    <option value="day" <?php if($datesort=="day") echo "selected";?>>За день</option>
                  </select>
                  <select class="select" name="sort">
                    <option value="new" <?php if($typesort=="new") echo "selected";?>>Актуальные</option>
                    <option value="popular" <?php if($typesort=="popular") echo "selected";?>>Популярные</option>
                  </select>
                  <select class="select" name="category">
                    <option value="*" <?php if($category=="*") echo "selected";?>>Все категории</option>
                    <option value="world" <?php if($category=="world") echo "selected";?>>В мире</option>
                    <option value="society" <?php if($category=="society") echo "selected";?>>Общество</option>
                    <option value="sport" <?php if($category=="sport") echo "selected";?>>Спорт</option>
                    <option value="techno" <?php if($category=="techno") echo "selected";?>>Технологии</option>
                    <option value="economy" <?php if($category=="economy") echo "selected";?>>Экономика</option>
                    <option value="culture" <?php if($category=="culture") echo "selected";?>>Культура</option>
                  </select>
                  <input class="select" type="text" placeholder="Тег" name="teg" value="<?php echo $tegsfind;?>"/>
                </div>
              </form>
            </div>
            <div class="result">
<?php 

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
  echo '<div class="result__item">
                <div class="ritem__line"></div>
                <a href = "/modules/state.php?state='.$id.'" class="ritem__block">
                  <div class="ritem__left">
                    <div class="ritem__title">
                      '.$statename.'
                    </div>
                    <div class="ritem__info">
                      <span>'.$date.'</span>
                      <img src="/public_html/img/eye.svg" alt="" />
                      <span>'.$views.'</span> 
                    </div>
                  </div>
                  <div class="ritem__right">
                    <img src="/static/states/'.$img.'" alt="" />
                  </div>
                </a>
              </div>';
}
}

?>


              

            </div>


<?php

require_once ("../public_html/rightmain.php");
require_once ("../public_html/footer.php");
?>