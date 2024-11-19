</div>
<div class="main__mleft">
            <div class="mleft__adv">
              <img src="/public_html/img/adv.png" alt="" />
            </div>
            <div class="mleft__popular">
              <div class="popular__title">Популярное</div>
              <div class="popular__line"></div>
          <?php 
          $sql = "SELECT state.id, state.statename, state.birthday 
          FROM state order by state.totalviews desc limit 6";
          $result = $dbcnx->query($sql);
          if($result->num_rows){
              foreach ($result as $row){
                  $statename = $row['statename'];
                  $id = $row['id'];

                  $date = date("d.m.y", strtotime($row["birthday"]));
                  $time = date("H:i",strtotime($row["birthday"]));
                  $date = $date . " в " . $time;


                  ?>
              <div class="popular__item">
                <a class="pitem__title" href = "/modules/state.php?state='<?php echo $id; ?>'"> <?php echo  $statename;?></a>
                <div class="pitem__info"><?php echo  $date;?></div>
              </div>


                  <?php
              }
          }
          else {
            echo "Ничего не найдено";
          }
          
          
          ?>

              
              <!-- <div class="popular__item">
                <div class="pitem__title">В республике представят новые модели кибер-футболистов, в том числе синекожих. Это является крайне выгодным вложением для всех нас.</div>
                <div class="pitem__info">19 октября, 22:44</div>
              </div>
              <div class="popular__item">
                <div class="pitem__title">В республике представят новые модели кибер-футболистов, в том числе синекожих. Это является крайне выгодным вложением для всех нас.</div>
                <div class="pitem__info">19 октября, 22:44</div>
              </div>
              <div class="popular__item">
                <div class="pitem__title">В республике представят новые модели кибер-футболистов, в том числе синекожих. Это является крайне выгодным вложением для всех нас.</div>
                <div class="pitem__info">19 октября, 22:44</div>
              </div>
              <div class="popular__item">
                <div class="pitem__title">В республике представят новые модели кибер-футболистов, в том числе синекожих. Это является крайне выгодным вложением для всех нас.</div>
                <div class="pitem__info">19 октября, 22:44</div>
              </div> -->
            </div>
