<?php 

session_start();
if (isset($_POST['category']) && isset($_POST['title'])&& isset($_POST['id'])){
    function validate($data){
    $data= strval($data);
    $data = htmlspecialchars($data);
    $data = trim($data);
    $data = stripslashes($data);
    return $data;
    }

   

    if($_POST['category']=="*"){
        header("Location: createstate.php?error=1Выберите категорию");
        exit();
    }
    $category = validate($_POST['category']);
    $title = validate($_POST['title']);
    $foto ="defstate.png"; 
    $fotoname = "Фото с архива";
    //
    if (isset($_FILES['foto']) && isset($_FILES['foto']["name"]) && $_FILES['foto']!=null && $_FILES['foto']['name']!=""){ 
        $foto = $_FILES['foto']['name'];
    }
    
    //
    if (isset($_POST['fotoname']) && $_POST['fotoname']!=null && $_POST['fotoname']!=""){
        $fotoname = $_POST['fotoname'];
    }

    include('functions.php');

    include "../db_conn.php";
    $id = $_POST["id"];
    $sql  = "select statebody from state where id = $id";
    $result = $dbcnx->query($sql);
    foreach($result as $row){
        $bodyinfo = $row["statebody"];
      }
      $bodyinfo = json_decode($bodyinfo, true);
      $img = $bodyinfo[0][1];

      if($foto ==""||$foto==" "|| $foto==null|| $foto=="defstate.png") $foto =  $img;

        if(isset($_FILES['foto'])   && $foto  !="defstate.png" && $foto !=$img) {
            $check = can_upload($_FILES['foto']);
            if($check == 0){
              $getMime = explode('.', $_FILES['foto']['name']);
              $mime = strtolower(end($getMime));
              $foto = $id.'-'.rand();          
              $rrr = make_upload($_FILES['foto'], $foto);
              $foto = $foto.'.'.$mime;         
              if (!$rrr) {
                header("Location: editstate.php?error=4Ошибка загрузки");
              
              }
              else{
                make_delete($img);
              }
            }
            else if($check == 1){
            }
            else{
                header("Location: editstate.php?error=4$check");
                exit();
            }
          }

          echo $foto;

          
    $area_array = array();
    foreach ($_POST as $key => $value) {
    if (strpos($key, 'area') === 0 && $value != null) {
        array_push($area_array, $value);
    }
    }

    $area_array_new = array();
    foreach ($area_array[0] as $row) {
    array_push($area_array_new, ["textarea", validate($row)]);
    }
    $new_object = ['foto',$foto, $fotoname];
    array_unshift($area_array_new, $new_object);

    $json_string = json_encode($area_array_new, JSON_UNESCAPED_UNICODE);
    


          
    $json_string = strval($json_string);
          
    $sql = "update state set id_category = $category,  statename = '$title', statebody = '$json_string' where id = $id;";
    $result = $dbcnx->query($sql);

    $sql = "delete from teglist where id_state = $id;";
    $result = $dbcnx->query($sql);
    

    $area_array = array();
    foreach ($_POST as $key => $value) {
    if (strpos($key, 'tegs') === 0 && $value != null) {
        array_push($area_array, $value);
    }
    }
    
    $teg_array="";
    foreach ($area_array[0] as $row) {
      $teg_array =$teg_array."(". $id.",".validate($row)."),";
    }
      if($teg_array!=""){
          $teg_array = substr($teg_array, 0, -1);
          $sql = "insert teglist(id_state, id_teg) values $teg_array;";
          $result = $dbcnx->query($sql);
      } 


//    $new_object = array('foto' => 'photo.jpg', 'fotoname' => 'My Photo');
// array_unshift($my_array, $new_object);

// $json_string = '{"name":"John","age":30,"city":"New York"}';
// $my_array = json_decode($json_string, true);
// print_r($my_array);

// $json_string = '{"blocks":[{"name":"img","src":"image.jpg"},{"name":"textarea","value":"Hello World!"}]}';
// $my_array = json_decode($json_string, true);

// foreach ($my_array['blocks'] as $block) {
//     if ($block['name'] == 'img') {
//         echo '<div><div><img src="' . $block['src'] . '"></div></div>';
//     } elseif ($block['name'] == 'textarea') {
//         echo '<textarea>' . $block['value'] . '</textarea>';
//     }
// }

   
        header("Location: ../loginsystem/mypage.php");
        exit();
 
}
else {
    header("Location: editstate.php?error=1Заполните все поля");
    exit();
}
?>