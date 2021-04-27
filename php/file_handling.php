<?php
  $filename = strtolower($_FILES["fileToUpload"]["name"]);
  if(strpos($filename, "moek") == 0) {
    echo "Error uploading file (get that nasty shit outta here)";
    die();
  }
  $file_size = $_FILES['fileToUpload']['size'];
  $target_dir = "../files/";
  $max_image_size = "";
  echo $file_size;
  //if(isset($_FILES["fileToUpload"]) && isset($_POST['submit'])) {
    $new_filename = md5(uniqid());
    $extension = pathinfo($_FILES["fileToUpload"]["name"])["extension"];
    $target_file = $target_dir.$new_filename.$new_filename.'.'.$extension;
    $uploadOk = 1;
    echo "Target file: " . $target_file;

    if($file_size > 20000000) {
      echo "Your file is too large! Make sure your file is < 20MB.";
      die();
    }
    else {
      move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
    }
  die();
?>
