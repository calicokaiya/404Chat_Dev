<?php

  //Creates directory that stores the encryption keys
  function create_encrypted_directory() {
    //Generates random name
    $str = rand();
    $result = md5($str);
    mkdir(BASE_ENCRYPTION_DIR."\\".$result, 0700);
  }

  //Deletes all the directories in the current folder (and makes another)
  function delete_encrypted_directory() {
    $directories = get_encrypted_directories();
    foreach($directories as $directory) {
      rmdir($directory);
    }
  }

  //Gets the name of the folder with the encrypted key directories
  function get_encrypted_directories() {
    $folders = [];
    $filelist = glob(BASE_ENCRYPTION_DIR."\\*");
    foreach($filelist as $file) {
      if(is_dir($file)) {
        array_push($folders, $file);
      }
    }

    return $folders;
  }

  //Creates a .dat file for all the encryption keys
  function create_encryption_file() {
    $str = rand();
    $result = md5($str);
    $endpath = get_encrypted_directories()[0].'\\'.$result.".dat";
    $file = fopen($endpath, 'a');
    fclose($file);
  }

  //Deletes the .dat file containing the encryption keys
  function delete_encryption_files() {
    $folders = get_encrypted_directories();

    foreach($folders as $folder) {
      $filelist = glob($folder."\*");
      foreach($filelist as $file) {
        if(is_file($file)) {
          unlink($file);
        }
      }
    }
  }

  //Returns the file name where the encryption keys are stored
  function get_encryption_filename() {
    $files = [];
    $dirname = get_encrypted_directories()[0];
    $filelist = glob($dirname."\\*");
    foreach($filelist as $file) {
      if(is_file($file)) {
        array_push($files, $file);
      }
    }
    if(count($files) > 1) {
      return false;
    }
    else {
      return $files[0];
    }
  }

  function encrypt_room_data($roomname = "", $password = "") {
    $method = "aes-256-cbc";
    $iv_length = openssl_cipher_iv_length($method);

    //First encrypts roomname
    $iv = base64_decode('rlmI8hgJkSZnEumrsr/0rg==');
    $key = base64_decode('CudHGhn2P/7oSUOSs4VqPA==');
    $options = 0;
    $roomname = openssl_encrypt($roomname, $method, $key, $options, $iv);

    //Then encrypts password
    if($password != "") {
      $iv = base64_decode('ulzCK2Y6AuhrurYJMOoGiA==');
      $key = base64_decode('WaDBPrEHNkmL72v/Wn0JOQ==');
      $options = 0;
      $password = openssl_encrypt($password, $method, $key, $options, $iv);
    }

    return ["roomname" => $roomname, "password" => $password];
  }

  function decrypt_room_data($roomname = "", $password = "") {
    $method = "aes-256-cbc";
    $iv_length = openssl_cipher_iv_length($method);

    //First decrypts roomname
    $iv = base64_decode('rlmI8hgJkSZnEumrsr/0rg==');
    $key = base64_decode('CudHGhn2P/7oSUOSs4VqPA==');
    $options = 0;
    $roomname = openssl_decrypt($roomname, $method, $key, $options, $iv);

    //Then decrypts password
    if($password != "") {
      $iv = base64_decode('ulzCK2Y6AuhrurYJMOoGiA==');
      $key = base64_decode('WaDBPrEHNkmL72v/Wn0JOQ==');
      $options = 0;
      $password = openssl_decrypt($password, $method, $key, $options, $iv);
    }

    return ["roomname" => $roomname, "password" => $password];
  }

  //Writes encryption information to the encryption .dat file
  function write_to_encryption_file($roomident = "", $enc_info) {
    $filepath = get_encryption_filename();
    $file = fopen($filepath, 'a');
    $writestring = $roomident.':'.base64_encode($enc_info['key']).':'.base64_encode($enc_info['iv']);
    fwrite($file, $writestring.PHP_EOL);
  }

  //Attempts to grab the encryption information from a room
  function read_encryption_data($searchfor = "") {
    //Finds encryption information
    $filename = get_encryption_filename();
    $filecontents = file_get_contents($filename);
    $filecontents_arr = explode(PHP_EOL, $filecontents);
    $found = false;
    $result = "";
    while($found === false) {
      foreach($filecontents_arr as $line) {
        if($found !== false) {
          break;
        }
        else if(strpos($line, $searchfor) !== false) {
          $result = $line;
          $found = true;
        }
      }
      break;
    }

    //Prepares array with information and returns it
    if($found) {
      $result = explode(':', $result);
      return $result;
    }
  }

  //Creates a secure encryption key and iv, and returns it
  function create_encryption_data() {
    $method = "aes-256-cbc";
    $iv_length = openssl_cipher_iv_length($method);
    $iv = openssl_random_pseudo_bytes($iv_length);
    $key = openssl_random_pseudo_bytes($iv_length);
    $options = 0;

    return ["method" => $method, "key" => $key, "iv" => $iv, "options" => $options];
  }

  //Encrypts data and returns it
  function encrypt_data($roomident, $data) {
    $enc_info = read_encryption_data($roomident);
    $method = 'aes-256-cbc';
    $key = base64_decode($enc_info[1]);
    $iv = base64_decode($enc_info[2]);
    $options = 0;
    $encrypted_data = openssl_encrypt($data, $method, $key, $options, $iv);
    return $encrypted_data;
  }

  //Decrypts data and returns it
  function decrypt_data($roomident, $data) {
    if(isset($roomident)) {
      $options = 0;
      $method = "aes-256-cbc";
      $encryption_data = read_encryption_data($roomident);
      $key = base64_decode($encryption_data[1]);
      $iv = base64_decode($encryption_data[2]);
      $decrypted_data = openssl_decrypt($data, $method, $key, $options, $iv);
    }
    return $decrypted_data;
  }
?>
