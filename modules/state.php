<?php 
    $title = "Статья";
    require_once ("../public_html/header.php");
    session_start();
    if(isset($_GET["state"])){
      include "db_conn.php";    
      $temp = $_GET["state"];
      $sql = "SELECT state.id, state.statename, state.statebody, state.birthday,state.totalviews, category.name, users.nikname,users.namefoto
      FROM state
      INNER JOIN category ON state.id_category = category.id
      INNER JOIN users ON state.id_autor = users.id
      WHERE state.id = $temp;";
      $result = $dbcnx->query($sql);


      
      foreach($result as $row){
        $name = $row["name"];
        $nik = $row["nikname"];
        $views = $row["totalviews"];
        $date = date("d.m.y", strtotime($row["birthday"]));
        $time = date("H:i",strtotime($row["birthday"]));
        $date =  $date . " в " . $time;
        $title = $row["statename"];
        $namefoto = $row["namefoto"];
        $bodyinfo = $row["statebody"];
      }
      $bodyinfo = json_decode($bodyinfo, true);
      $img = $bodyinfo[0][1];
      $imgname = $bodyinfo[0][2];
?>
   <div class="mright__state">
              <div class="mright__category"><?php echo mb_strtoupper($name, 'UTF-8') ?></div>
              <div class="mright__uptitle">
                <div class="mright__autor">
                  <div class="mright__autorlogo"><img src="/static/userslogo/<?php echo $namefoto ?>" alt="" srcset="" /></div>
                  <div class="mright__autorname"><?php echo  $nik ?></div>
                </div>
                <div class="mright__date"><?php echo  $date ?></div>
                <div class="mright__viewcount"><img src="/public_html/img/eye.svg" alt="" /> <span><?php echo $views ?></span></div>
              </div>
              <div class="mright__title"><?php echo  $title ?></div>
              <div class="mright__statecontent">
                <div class="statecontent__img">
                  <img src="/static/states/<?php echo $img ?>" alt="" />
                  <p class="statecontent__underimg"><?php echo $imgname ?></p>
                </div>
                <?php 
                  for($i=1;$i<count($bodyinfo);$i++){
                    echo "<p>".$bodyinfo[$i][1]."</p>";
                  }

                ?>
               
                 
              </div>
              <?php 
              
              $sql = "SELECT emotiontype.name, COUNT(emotionlist.id) AS count
              FROM emotiontype
              LEFT JOIN emotionlist ON emotiontype.id = emotionlist.id_type AND emotionlist.id_state = $temp
              GROUP BY emotiontype.name order by emotiontype.name";
              $result = $dbcnx->query($sql);
              $emlist = [];
              foreach($result as $row){
                array_push($emlist,[$row["name"],$row["count"]]);
              }
              $true = -1;
              if(isset($_SESSION['id_user'])){
                $id_user = $_SESSION['id_user'];
                $sql = "SELECT id_type from emotionlist where id_user = $id_user and id_state=$temp;";
                $result = $dbcnx->query($sql);
              }
              if($result->num_rows){
                foreach($result as $row){
                  if(isset($row['id_type']))$true = $row['id_type'];
                }
                
              }
              ?>
              <div class="mright__stateemotion">
                <a 
                <?php if(isset($_SESSION['id_user']) && $true!=5) 
                echo "href='doemotion.php?state=$temp&iduser=$id_user&idtype=5'";
                ?> 
                class="mright__emotionblock <?php if($true==5) echo "curemotion";?>" id="wou">
                <img class="mright__emotion" src="/public_html/img/emotion/wou.svg" alt="" srcset="" />
                <div class="mright__emcount"> <?php echo $emlist[4][1]?></div>
               
                </a>

                <a 
                <?php if(isset($_SESSION['id_user']) && $true!=2) 
                echo "href='doemotion.php?state=$temp&iduser=$id_user&idtype=2'";
                ?> 
                class="mright__emotionblock <?php if($true==2) echo "curemotion";?>" id="fine">
                  <img class="mright__emotion" src="/public_html/img/emotion/fine.svg" alt="" srcset="" />
                  <div class="mright__emcount"> <?php echo $emlist[1][1]?></div>
                </a>

                <a 
                <?php if(isset($_SESSION['id_user']) && $true!=3) 
                echo "href='doemotion.php?state=$temp&iduser=$id_user&idtype=3'";
                ?> 
                class="mright__emotionblock <?php if($true==3) echo "curemotion";?>" id="good">
                  <img class="mright__emotion" src="/public_html/img/emotion/good.svg" alt="" srcset="" />
                  <div class="mright__emcount"> <?php echo $emlist[2][1]?></div>
                </a>

                <a 
                <?php if(isset($_SESSION['id_user']) && $true!=4) 
                echo "href='doemotion.php?state=$temp&iduser=$id_user&idtype=4'";
                ?> 
                class="mright__emotionblock <?php if($true==4) echo "curemotion";?>" id="sorrymedium">
                  <img class="mright__emotion" src="/public_html/img/emotion/sorrymedium.svg" alt="" srcset="" />
                  <div class="mright__emcount"> <?php echo $emlist[3][1]?></div>
                </a>

                <a
                <?php if(isset($_SESSION['id_user']) && $true!=1) 
                echo "href='doemotion.php?state=$temp&iduser=$id_user&idtype=1'";
                ?> 
                class="mright__emotionblock <?php if($true==1) echo "curemotion";?>" id="angry">
                  <img class="mright__emotion" src="/public_html/img/emotion/angry.svg" alt="" srcset="" />
                  <div class="mright__emcount"><?php echo $emlist[0][1]?></div>
                </a>

              </div>
              <div class="mright__stateteglist">
                <?php
                  $sql = "SELECT teg.name, teg.phpname from teglist 
                  inner join teg on teg.id = teglist.id_teg 
                  where teglist.id_state=$temp;";
                  $result = $dbcnx->query($sql);
                  foreach($result as $row){
                    $phpname = $row["phpname"];
                    $tegname = $row["name"];
                    echo "<a href='find.php?info=t$phpname'>$tegname</a>";
                  }
                ?>
              </div>
            </div>


<?php 
}
    if(!isset($_SESSION["idstate"]) || $_SESSION["idstate"]!=$temp){
      $_SESSION["idstate"]=$temp;
      $sql = "update state set totalviews = totalviews+1 where id=$temp;";
      $result = $dbcnx->query($sql);
    }
    

require_once ("../public_html/rightmain.php");
require_once ("../public_html/footer.php");

?>