<?php
  function can_upload($file){
    if($file['name'] == '') return 1;

	if($file['size'] == 0) return 'Файл слишком большой.';
	
	$getMime = explode('.', $file['name']);
	$mime = strtolower(end($getMime));

	$types = array('jpg', 'png', 'jpeg');

	if(!in_array($mime, $types)) return 'Недопустимый тип файла.';
	
	return 0;
  }
  
  function make_upload($file, $userid){	
    $getMime = explode('.', $file['name']);
	$mime = strtolower(end($getMime));
	$name = $userid.'.'.$mime;
	$rrr = copy($file['tmp_name'], '../../static/userslogo/' . $name);
    //$rrr = copy($file['tmp_name'], $file['name']);
    return $rrr;
}
function make_delete($file){
	$file_path = "../../static/userslogo/".$file; 
	if (file_exists($file_path) && $file!="defuser.png") {
		unlink($file_path);
	} else {
	}
}
?>